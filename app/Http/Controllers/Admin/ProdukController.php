<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriProduk;
use App\Models\ProdukMaster;
use App\Models\ProdukVariant;
use App\Models\ProdukVariantValues;
use App\Models\VariantAttribute;
use App\Models\VariantValues;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("admin.catalog.produk-view.produk" );
    }

    public function data(Request $request){
        if ($request->ajax()) {
            $data = ProdukMaster::with([
                'kategori_produk:id_ktg_produk,nama_kategori',
                'variant:id_master_produk,harga,stok,sku,gambar'
            ])
            ->select('id_master_produk','id_ktg_produk','nama_produk','status','slug');

            return DataTables::of($data)
                ->addColumn('checkbox', function($row){
                    return '<input type="checkbox" data-slug="'.$row->slug.'" class="form-check-input" value="'.$row->id_master_produk.'">';
                })
                ->addColumn('nama_produk', function($row){
                    $gambarPath = asset('storage/' . $row->variant->first()->gambar);
                    $label = $row->nama_produk;
                    return 
                    '<div class="d-flex align-items-center">
                        <a href="" class="symbol symbol-50px">
                            <span class="symbol-label" style="background-image:url(\''. $gambarPath .'\');"></span>
                        </a>
                        <div class="ms-5">
                            <a href="" class="text-gray-800 text-hover-primary fs-5 fw-bold">
                                \''. $label .'\'
                            </a>
                        </div>
                    </div>'
                    ;
                })
                ->addColumn('nama_kategori', function($row){
                    return $row->kategori_produk ? $row->kategori_produk->nama_kategori : '-';
                })
                ->addColumn('nama_kategori', function($row){
                    return $row->kategori_produk ? $row->kategori_produk->nama_kategori : '-';
                })
                ->addColumn('harga', function($row){
                    return $row->variant->first() ? number_format($row->variant->first()->harga, 0, ',', '.') : '-';
                })
                ->addColumn('stok', function($row){
                    return $row->variant->first() ? $row->variant->first()->stok : '-';
                })
                ->addColumn('sku', function($row){
                    return $row->variant->first() ? $row->variant->first()->sku : '-';
                })
                ->addColumn('status', function($row){
                    $class = $row->status === 'published' ? 'badge-light-success' : 'badge-light-danger';
                    $label = ucfirst($row->status); 
                    
                    return '<div class="badge '.$class.'">'.$label.'</div>';
                })
                ->addColumn('action', function($row){
                    return '
                    <button href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                    <i class="ki-duotone ki-down fs-5 ms-1"></i></button>
                    <!--begin::Menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="/produk-edit/'.$row->slug.'" class="menu-link px-3">View</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3" data-slug="'.$row->slug.'" data-kt-category-table-filter="delete_row">Delete</a>
                        </div>
                        <!--end::Menu item-->
                    </div>
                    ';
                })
                ->rawColumns(['checkbox', 'action', 'nama_produk', 'nama_kategori', 'sku', 'harga','stok','status'])
                ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategori = KategoriProduk::select('id_ktg_produk', 'nama_kategori')->get()->all();
        $variant = VariantAttribute::select('id_variant_attributes', 'nama_variant')->get()->all();
        // dd($kategori);
        return view('admin.catalog.produk-view.create',['kategori'=> $kategori, 'variant' => $variant]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kategori_id' => 'required',
            'nama_produk' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric',
            'stok' => 'required|integer|min:0',
            'sku' => 'required|string|unique:produk_variant,sku',
            'status' => 'nullable|in:published,unpublished',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();
            $gambarPath = $request->file('gambar')->store('produk/thumbnails', 'public');

            // Create produk master
            $produk = ProdukMaster::create([
                'id_ktg_produk' => $request->kategori_id,
                'nama_produk' => $request->nama_produk,
                'deskripsi' => $request->deskripsi,
                'status' => $request->status,
                'meta_keywords' => $request->meta_keywords,
                'meta_desc' => $request->meta_desc,
                'gambar' => $gambarPath,
            ]);
            
            // Create main product variant
            $variant = ProdukVariant::create([
                'id_master_produk' => $produk->id_master_produk,
                'harga' => $request->harga,
                'stok' => $request->stok,
                'sku' => $request->sku,
                'gambar' => $gambarPath,
            ]);

            // Process variant attributes if any
            if ($request->has('kt_ecommerce_add_product_options')) {
                $variantOptions = $request->kt_ecommerce_add_product_options;
                
                foreach ($variantOptions as $option) {
                    // Skip empty options
                    if (empty($option['product_option']) || empty($option['nilai_variant'])) {
                        continue;
                    }
                    
                    $attributeId = $option['product_option'];
                    $attributeValue = $option['nilai_variant'];
                    
                    $attribute = VariantAttribute::find($attributeId);
                    
                    if ($attribute) {
                        // Create or find the variant value
                        $value = VariantValues::firstOrCreate([
                            'id_variant_attributes' => $attribute->id_variant_attributes,
                            'value' => $attributeValue
                        ]);
                        
                        // Link the value to the product variant
                        ProdukVariantValues::create([
                            'id_var_produk' => $variant->id_var_produk,
                            'id_variant_attributes' => $attribute->id_variant_attributes,
                            'id_variant_value' => $value->id_variant_value
                        ]);
                    }
                }
            }

            // Save additional product images if any
            if ($request->hasFile('product_images')) {
                foreach ($request->file('product_images') as $file) {
                    $path = $file->store('produk/gallery', 'public');
                    
                    DB::table('produk_gambar')->insert([
                        'id_master_produk' => $produk->id_master_produk,
                        'gambar' => $path
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil disimpan',
                'redirect' => route('produk.index')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan produk: ' . $e->getMessage()
            ], 500);
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $slug)
    {
        // Ubah pencarian berdasarkan slug
        $produk = ProdukMaster::where('slug', $slug)
            ->with([
                'kategori_produk',
                'variant' => function($query) {
                    $query->with(['variantValues' => function($q) {
                        $q->with('variantAttribute', 'variantValues');
                    }]);
                }
            ])
            ->firstOrFail();
        // dd($produk);
        $gambar = asset('storage/' . $produk->variant->first()->gambar);

        $kategori = KategoriProduk::select('id_ktg_produk', 'nama_kategori')->get();
        $attributes = VariantAttribute::with('values')->get();

        return view('admin.catalog.produk-view.edit', [
            'produk' => $produk,
            'kategori' => $kategori,
            'attributes' => $attributes,
            'gambar'=> $gambar
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $slug)
    {
        $produk = ProdukMaster::where('slug', $slug)->firstOrFail();

        $validator = Validator::make($request->all(), [
            'kategori_id' => 'required',
            'nama_produk' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric',
            'stok' => 'required|integer|min:0',
            'sku' => [
                'required',
                'string',
                Rule::unique('produk_variant', 'sku')->ignore($produk->variant->first()->id_var_produk ?? 0, 'id_var_produk')
            ],
            'status' => 'nullable|in:published,unpublished',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            // Update gambar jika ada
            if ($request->hasFile('gambar')) {
                $gambarPath = $request->file('gambar')->store('produk/thumbnails', 'public');
            } else {
                $gambarPath = $produk->gambar; // gunakan gambar lama
            }

            // Update produk master
            $produk->update([
                'id_ktg_produk' => $request->kategori_id,
                'nama_produk' => $request->nama_produk,
                'deskripsi' => $request->deskripsi,
                'status' => $request->status,
                'meta_keywords' => $request->meta_keywords,
                'meta_desc' => $request->meta_desc,
                'gambar' => $gambarPath,
            ]);

            // Hapus variant lama (dan relasi ke attributes)
            foreach ($produk->variant as $variant) {
                ProdukVariantValues::where('id_var_produk', $variant->id_var_produk)->delete();
                $variant->delete();
            }

            // Buat ulang variant utama
            $variant = ProdukVariant::create([
                'id_master_produk' => $produk->id_master_produk,
                'harga' => $request->harga,
                'stok' => $request->stok,
                'sku' => $request->sku,
                'gambar' => $gambarPath,
            ]);

            // Proses attribute jika ada
            if ($request->has('kt_ecommerce_add_product_options')) {
                $variantOptions = $request->kt_ecommerce_add_product_options;

                foreach ($variantOptions as $option) {
                    if (empty($option['product_option']) || empty($option['nilai_variant'])) {
                        continue;
                    }

                    $attributeId = $option['product_option'];
                    $attributeValue = $option['nilai_variant'];

                    $attribute = VariantAttribute::find($attributeId);

                    if ($attribute) {
                        $value = VariantValues::firstOrCreate([
                            'id_variant_attributes' => $attribute->id_variant_attributes,
                            'value' => $attributeValue
                        ]);

                        ProdukVariantValues::create([
                            'id_var_produk' => $variant->id_var_produk,
                            'id_variant_attributes' => $attribute->id_variant_attributes,
                            'id_variant_value' => $value->id_variant_value
                        ]);
                    }
                }
            }

            // Tambah/replace gambar gallery jika ada
            if ($request->hasFile('product_images')) {
                DB::table('produk_gambar')->where('id_master_produk', $produk->id_master_produk)->delete();

                foreach ($request->file('product_images') as $file) {
                    $path = $file->store('produk/gallery', 'public');

                    DB::table('produk_gambar')->insert([
                        'id_master_produk' => $produk->id_master_produk,
                        'gambar' => $path
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil diperbarui',
                'redirect' => route('produk.index')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate produk: ' . $e->getMessage()
            ], 500);
        }
    }


    public function destroy($slug)
    {
        $kategori = ProdukMaster::where('slug', $slug)->firstOrFail();
        $kategori->delete();
    
        return response()->json(['success' => true, 'message' => 'Produk berhasil dihapus']);
    }
    
    public function destroySelected(Request $request)
    {
        $ids = $request->ids;
        if (!$ids || !is_array($ids)) {
            return response()->json(['success' => false, 'message' => 'ID tidak valid'], 400);
        }

        ProdukMaster::whereIn('slug', $ids)->delete();

        return response()->json(['success' => true, 'message' => 'Data Produk berhasil dihapus']);
    }
}
