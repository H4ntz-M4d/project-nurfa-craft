<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DetailProdukMaster;
use App\Models\KategoriProduk;
use App\Models\ProdukGambar;
use App\Models\ProdukMaster;
use App\Models\ProdukVariant;
use App\Models\ProdukVariantValues;
use App\Models\VariantAttribute;
use App\Models\VariantValues;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("admin.catalog.produk-view.produk",[
            'title' => 'List Produk',
            'sub_title' => 'Catalog - List Produk'
        ]);
    }

    public function data(Request $request){
        if ($request->ajax()) {
            $data = ProdukMaster::with([
                'kategori_produk:id_ktg_produk,nama_kategori',
                'detailProduk:id_master_produk,sku,harga,stok',
                'variant:id_master_produk,harga,stok,sku'
            ])
            ->select('id_master_produk','id_ktg_produk','nama_produk','status', 'use_variant','gambar','slug');

            return DataTables::of($data)
                ->addColumn('checkbox', function($row){
                    return '<input type="checkbox" data-slug="'.$row->slug.'" class="form-check-input" value="'.$row->id_master_produk.'">';
                })
                ->addColumn('nama_produk', function($row){
                    $gambarPath = asset('storage/' . $row->gambar);
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
                ->addColumn('harga', function($row){
                    return $row->detailProduk->first() ? number_format($row->detailProduk->first()->harga, 0, ',', '.') : '-';
                })
                ->addColumn('stok', function($row){
                    return $row->detailProduk->first() ? $row->detailProduk->first()->stok : '-';
                })
                ->addColumn('use_variant', function($row){
                    return $row->use_variant === 'yes' 
                        ? '<span class="badge badge-light-primary fs-7">YA</span>' 
                        : '<span class="badge badge-light-info fs-7">Tidak</span>';
                })
                ->addColumn('status', function($row){
                    $class = $row->status === 'published' ? 'badge-light-success' : 'badge-light-danger';
                    $label = ucfirst($row->status); 
                    
                    return '<div class="badge '.$class.'">'.$label.'</div>';
                })
                ->addColumn('action', function($row){
                    $variantMenu = '';
                    if ($row->use_variant == 'yes') {
                        $variantMenu = '
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="/produk-variant/'.$row->slug.'" class="menu-link px-3">Kelola Variant</a>
                        </div>
                        <!--end::Menu item-->
                        ';
                    }

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

                        '.$variantMenu.'

                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3" data-slug="'.$row->slug.'" data-kt-produk-table-filter="delete_row">Delete</a>
                        </div>
                        <!--end::Menu item-->
                    </div>
                    ';
                })
                ->rawColumns(['checkbox', 'action', 'nama_produk', 'nama_kategori', 'use_variant', 'harga','stok','status'])
                ->make(true);
        }
    }

    public function create()
    {
        $kategori = KategoriProduk::select('id_ktg_produk', 'nama_kategori')->where('status','published')->get()->all();
        $variant = VariantAttribute::select('id_variant_attributes', 'nama_variant')->get()->all();
        // dd($kategori);
        return view('admin.catalog.produk-view.create',[
            'kategori'=> $kategori, 'variant' => $variant,
            'title' => 'Tambah Produk',
            'sub_title' => 'Catalog - Tambah Produk',
        ]);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            // Simpan thumbnail
            $gambarPath = $request->file('gambar')->store('produk/thumbnails', 'public');

            // Simpan produk utama
            $produk = ProdukMaster::create([
                'id_ktg_produk' => $request->kategori_id,
                'nama_produk' => $request->nama_produk,
                'deskripsi' => $request->deskripsi,
                'status' => $request->status,
                'meta_desc' => $request->meta_desc,
                'meta_keywords' => $request->meta_keywords,
                'use_variant' => $request->has('use_variant') ? 'yes' : 'no',
                'gambar' => $gambarPath,
            ]);

            if ($produk->use_variant === 'no') {
                // Simpan detail produk tanpa varian
                DetailProdukMaster::create([
                    'id_master_produk' => $produk->id_master_produk,
                    'harga' => $request->harga,
                    'sku' => $request->sku,
                    'stok' => $request->stok,
                ]);

            } else {
                // Simpan varian & kombinasi
                $attributes = $request->input('kt_docs_repeater_nested_outer', []);
                $attributeValues = [];

                foreach ($attributes as $attribute) {
                    // Cek jika atribut tidak ada atau kosong, lewati
                    if (empty($attribute['product_option'])) {
                        continue;
                    }

                    $attributeId = $attribute['product_option'];
                    $attributeModel = VariantAttribute::find($attributeId);

                    // Lewati jika attribute tidak ditemukan di database
                    if (!$attributeModel) {
                        continue;
                    }

                    $values = [];

                    // Cek value dalam inner repeater
                    foreach ($attribute['kt_docs_repeater_nested_inner'] as $val) {
                        // Lewati jika nilai kosong
                        if (empty($val['nilai_variant'])) {
                            continue;
                        }

                        $variantValue = VariantValues::firstOrCreate([
                            'id_variant_attributes' => $attributeModel->id_variant_attributes,
                            'value' => $val['nilai_variant'],
                        ]);

                        $values[] = [
                            'attribute_id' => $attributeModel->id_variant_attributes,
                            'value_id' => $variantValue->id_variant_value,
                            'value_text' => $variantValue->value
                        ];
                    }

                    // Simpan hanya jika ada value valid
                    if (count($values) > 0) {
                        $attributeValues[] = $values;
                    }
                }


                // Buat kombinasi
                $combinations = $this->generateCombinations($attributeValues);

                foreach ($combinations as $combo) {
                    
                    // Buat entri produk_variant
                    $variant = ProdukVariant::create([
                        'id_master_produk' => $produk->id_master_produk,
                        'sku' => null,
                        'harga' => null,
                        'stok' => null,
                        'status' => "unpublish",
                    ]);

                    // Simpan relasi ke variant_values
                    foreach ($combo as $pair) {
                        ProdukVariantValues::create([
                            'id_var_produk' => $variant->id_var_produk,
                            'id_variant_attributes' => $pair['attribute_id'],
                            'id_variant_value' => $pair['value_id'],
                        ]);
                    }
                }

                DB::commit();
                return response()->json([
                    'success' => true,
                    'produkId' => $produk->id_master_produk,
                    'message' => 'Produk berhasil disimpan',
                    'redirect' => route('produk.variant.data', ['slug' => $produk->slug])
                ]);
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'produkId' => $produk->id_master_produk,
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
    
    // Fungsi bantu untuk kombinasi semua varian
    private function generateCombinations($arrays, $i = 0)
    {
        if (!isset($arrays[$i])) return [[]];

        $tmp = $this->generateCombinations($arrays, $i + 1);
        $result = [];

        foreach ($arrays[$i] as $value) {
            foreach ($tmp as $t) {
                $result[] = array_merge([$value], $t);
            }
        }

        return $result;
    }



    public function kelolaVariant(string $slug)
    {
        
        $produk = ProdukMaster::where('slug', $slug)
            ->with([
                'kategori_produk',
                'variant'])
            ->firstOrFail();

        if ($produk->use_variant === 'yes' && $produk->variant->isEmpty()) {
            return redirect()->route('produk.index')->with('variant_error', 'Anda menggunakan varian, tapi tidak ada data varian yang disimpan. Silakan isi data varian terlebih dahulu.');
        }


        $produkVariantValues = ProdukVariantValues::whereHas('produkVariant', function($q) use ($produk) {
            $q->where('id_master_produk', $produk->id_master_produk);
        })->with(['variantAttribute', 'variantValues'])->get();

        $grouped = $produkVariantValues->groupBy(function ($item) {
            return $item->variantAttribute->nama_variant;
        });

        $attributes = [];
        foreach ($grouped as $attributeName => $items) {
            $attributes[$attributeName] = $items->map(function ($item) {
                return [
                    'id' => $item->variantValues->id_variant_value,
                    'nama' => $item->variantValues->value,
                ];
            })->unique('id')->values()->toArray();
        }

        $attributeNames = array_keys($attributes);
        $combinations = $this->getCombinations($attributes);

        // Hitung rowspan hanya untuk atribut pertama
        $rowspanData = [];
        $printFlags = [];

        $firstAttr = $attributeNames[0];
        $valueCounts = [];

        foreach ($combinations as $combo) {
            $valId = $combo[$firstAttr]['id'];
            if (!isset($valueCounts[$valId])) {
                $valueCounts[$valId] = 0;
            }
            $valueCounts[$valId]++;
        }

        $rowspanData[$firstAttr] = $valueCounts;
        $printFlags[$firstAttr] = [];

        // Buat peta untuk mencocokkan kombinasi dengan varian
        $variantMap = [];

        foreach ($produk->variant as $variant) {
            $valueIds = $variant->variantValues->pluck('id_variant_value')->sort()->values()->toArray();
            $key = implode('-', $valueIds); // key kombinasi

            $variantMap[$key] = [
                'harga' => $variant->harga,
                'stok' => $variant->stok,
                'sku' => $variant->sku,
            ];
        }


        if ($produk->variant->first()->status === "unpublish") {
            return view('admin.catalog.produk-view.kelola-variant', [
                'produk' => $produk,
                'attribute_names' => $attributeNames,
                'combinations' => $combinations,
                'rowspanData' => $rowspanData,
                'printFlags' => $printFlags, // dikirim awalnya kosong, akan dipakai di blade
                'title' => 'Kelola Variant Produk',
                'sub_title' => 'Catalog - Kelola Variant Produk'
            ]);
        } else {
            return view('admin.catalog.produk-view.edit-variant', [
                'produk' => $produk,
                'variantMap' => $variantMap,
                'attribute_names' => $attributeNames,
                'combinations' => $combinations,
                'rowspanData' => $rowspanData,
                'printFlags' => $printFlags, // dikirim awalnya kosong, akan dipakai di blade
                'title' => 'Kelola Variant Produk',
                'sub_title' => 'Catalog - Kelola Variant Produk'
            ]);
        }
        
    }

    // Tambahkan ke dalam class ProdukController
    protected function getCombinations($arrays)
    {
        $result = [[]];
        foreach ($arrays as $key => $values) {
            $append = [];
            foreach ($result as $product) {
                foreach ($values as $item) {
                    $append[] = array_merge($product, [$key => $item]);
                }
            }
            $result = $append;
        }
        return $result;
    }

    public function storeVariant(Request $request, string $slug)
    {
        $produk = ProdukMaster::where('slug', $slug)->firstOrFail();

        DB::beginTransaction();
        try {
            $variant_value_ids = $request->input('variant_value_ids'); // array of array
            $harga = $request->input('harga');
            $stok = $request->input('stok');
            $sku = $request->input('sku');

            // Ambil semua varian lama
            $existingVariants = $produk->variant()->with('variantValues')->get();
            $existingMap = [];

            foreach ($existingVariants as $variant) {
                $valueIds = $variant->variantValues->pluck('id_variant_value')->sort()->values()->implode('-');
                $existingMap[$valueIds] = $variant;
            }

            $usedKeys = [];

            foreach ($variant_value_ids as $index => $value_ids) {
                $key = collect($value_ids)->sort()->values()->implode('-');

                $usedKeys[] = $key;

                if (isset($existingMap[$key])) {
                    // UPDATE jika sudah ada
                    $variant = $existingMap[$key];
                    $variant->update([
                        'harga' => $harga[$index],
                        'stok' => $stok[$index],
                        'sku' => $sku[$index],
                        'status' => 'publish',
                    ]);
                } else {
                    // INSERT baru
                    $variant = ProdukVariant::create([
                        'id_master_produk' => $produk->id_master_produk,
                        'harga' => $harga[$index],
                        'stok' => $stok[$index],
                        'sku' => $sku[$index],
                        'status' => 'publish',
                    ]);

                    // Simpan nilai variant
                    foreach ($value_ids as $value_id) {
                        ProdukVariantValues::create([
                            'id_produk_variant' => $variant->id_produk_variant,
                            'id_variant_value' => $value_id,
                        ]);
                    }
                }
            }

            // HAPUS yang tidak digunakan lagi
            foreach ($existingMap as $key => $variant) {
                if (!in_array($key, $usedKeys)) {
                    $variant->variantValues()->delete();
                    $variant->delete();
                }
            }

            DB::commit();
            return redirect()->route('produk.index')->with('success', 'Data variasi berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyimpan variasi: ' . $e->getMessage());
        }
    }

    public function edit(string $slug)
    {
        // Ubah pencarian berdasarkan slug
        $produk = ProdukMaster::where('slug', $slug)
            ->with([
                'kategori_produk',
                'detailProduk',
                'variant' => function($query) {
                    $query->with(['variantValues' => function($q) {
                        $q->with('variantAttribute', 'variantValues');
                    }]);
                }
            ])
            ->firstOrFail();
        // dd($produk);
        $gambar = asset('storage/' . $produk->gambar);

        $kategori = KategoriProduk::select('id_ktg_produk', 'nama_kategori')->where('status','published')->get();
        $attributes = VariantAttribute::with('values')->get();

        $groupedVariants = $produk->variant
        ->flatMap(fn ($variant) => $variant->variantValues)
        ->groupBy('id_variant_attributes')
        ->map(function ($items, $attrId) {
            return $items->map(function ($item) {
                return $item->variantValues->value ?? '';
            })->unique()->values();
        });

        return view('admin.catalog.produk-view.edit', [
            'produk' => $produk,
            'kategori' => $kategori,
            'attributes' => $attributes,
            'gambar'=> $gambar,
            'groupedVariants' => $groupedVariants,
            'title' => 'Edit Produk',
            'sub_title' => 'Catalog - Edit Produk',
        ]);
    }

    public function update(Request $request, $slug)
    {
        $produk = ProdukMaster::where('slug', $slug)
            ->with(['kategori_produk', 'variant.variantValues.variantValues'])
            ->firstOrFail();

        $validator = Validator::make($request->all(), [
            'kategori_id' => 'required',
            'nama_produk' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'nullable|numeric',
            'sku' => [
                'nullable',
                'string',
                Rule::unique('produk_variant', 'sku')->ignore($produk->variant->first()->id_var_produk ?? 0, 'id_var_produk')
            ],
            'status' => 'nullable|in:published,unpublished',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'removed_files' => 'nullable|json',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();

        try {
            $gambarPath = $produk->gambar;
            if ($request->hasFile('gambar')) {
                $gambarPath = $request->file('gambar')->store('produk/thumbnails', 'public');
            }

            $produk->update([
                'id_ktg_produk' => $request->kategori_id,
                'nama_produk' => $request->nama_produk,
                'deskripsi' => $request->deskripsi,
                'status' => $request->status,
                'meta_desc' => $request->meta_desc,
                'meta_keywords' => $request->meta_keywords,
                'use_variant' => $request->has('use_variant') ? 'yes' : 'no',
                'gambar' => $gambarPath,
            ]);

            if ($produk->use_variant === 'no') {
                DetailProdukMaster::updateOrCreate(
                    ['id_master_produk' => $produk->id_master_produk],
                    [
                        'harga' => $request->harga,
                        'sku' => $request->sku,
                    ]
                );
            } else {
                $attributes = $request->input('kt_docs_repeater_nested_outer', []);
                $attributeValues = [];

                foreach ($attributes as $attribute) {
                    // Cek jika atribut tidak ada atau kosong, lewati
                    if (empty($attribute['product_option'])) {
                        continue;
                    }

                    $attributeId = $attribute['product_option'];
                    $attributeModel = VariantAttribute::find($attributeId);

                    // Lewati jika attribute tidak ditemukan di database
                    if (!$attributeModel) {
                        continue;
                    }

                    $values = [];

                    // Cek value dalam inner repeater
                    foreach ($attribute['kt_docs_repeater_nested_inner'] as $val) {
                        // Lewati jika nilai kosong
                        if (empty($val['nilai_variant'])) {
                            continue;
                        }

                        $variantValue = VariantValues::firstOrCreate([
                            'id_variant_attributes' => $attributeModel->id_variant_attributes,
                            'value' => $val['nilai_variant'],
                        ]);

                        $values[] = [
                            'attribute_id' => $attributeModel->id_variant_attributes,
                            'value_id' => $variantValue->id_variant_value,
                            'value_text' => $variantValue->value
                        ];
                    }

                    // Simpan hanya jika ada value valid
                    if (count($values) > 0) {
                        $attributeValues[] = $values;
                    }
                }


                if (empty($attributeValues)) {
                    throw new \Exception("Anda memilih menggunakan varian, tetapi tidak mengisi kombinasi apa pun.");
                }


                $newCombinations = $this->generateCombinations($attributeValues);

                // Ambil semua kombinasi lama (kunci = id_variant_value yang diurut dan digabung koma)
                $oldVariants = $produk->variant()->with('variantValues')->get();
                $existingCombinations = [];
                foreach ($oldVariants as $v) {
                    $comboKey = $v->variantValues->pluck('id_variant_value')->sort()->implode(',');
                    $existingCombinations[$comboKey] = $v;
                }

                $processedKeys = [];

                foreach ($newCombinations as $combo) {
                    // Lewati jika kombinasi tidak lengkap (misalnya hanya 1 atribut padahal seharusnya 2)
                    if (count($combo) < count($attributeValues)) {
                        continue;
                    }

                    $valueIds = collect($combo)->pluck('value_id');
                    $comboKey = $valueIds->sort()->implode(',');
                    $processedKeys[] = $comboKey;

                    if (isset($existingCombinations[$comboKey])) {
                        // Kombinasi lama
                        $variantModel = $existingCombinations[$comboKey];
                        unset($existingCombinations[$comboKey]);
                    } else {
                        $variantModel = ProdukVariant::create([
                            'id_master_produk' => $produk->id_master_produk,
                        ]);
                    }

                    // Pastikan kita hanya simpan kombinasi dengan isi
                    if (!empty($combo)) {
                        // Hapus dan insert ulang varian values
                        $variantModel->variantValues()->delete();

                        foreach ($combo as $pair) {
                            ProdukVariantValues::create([
                                'id_var_produk' => $variantModel->id_var_produk,
                                'id_variant_attributes' => $pair['attribute_id'],
                                'id_variant_value' => $pair['value_id'],
                            ]);
                        }
                    }
                }


                // Hapus kombinasi lama yang tidak terpakai lagi
                foreach ($existingCombinations as $oldVariant) {
                    $oldVariant->variantValues()->delete();
                    $oldVariant->delete();
                }
            }

            // Hapus gambar jika ada yang dihapus
            $removedFiles = json_decode($request->removed_files, true) ?? [];
            foreach ($removedFiles as $fileName) {
                $gambar = ProdukGambar::where('gambar', "produk/{$fileName}")->first();
                if ($gambar) {
                    Storage::delete($gambar->gambar);
                    $gambar->delete();
                }
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'produkId' => $produk->id_master_produk,
                'message' => 'Produk berhasil diperbarui',
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


    public function getGambar($id)
    {
        $produk = ProdukMaster::findOrFail($id);

        $gambarList = $produk->produkGambar()->get()->map(function ($gambar) {
            $path = $gambar->gambar;

            return [
                'name' => basename($path),
                'size' => Storage::disk('public')->size($path),
                'url' => Storage::url($path), // akan otomatis pakai APP_URL
            ];
        });

        return response()->json($gambarList);
    }


    public function uploadGambar(Request $request)
    {
        $request->validate([
            'id_master_produk' => 'required|exists:produk_master,id_master_produk',
            'gambar' => 'required|image|mimes:jpg,jpeg,png|max:10240' // 10MB
        ]);

        $path = $request->file('gambar')->store('produk', 'public'); // simpan ke storage/app/public/produk

        $gambar = ProdukGambar::create([
            'id_master_produk' => $request->id_master_produk,
            'gambar' => $path,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Gambar berhasil diupload',
            'data' => $gambar,
        ]);
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
