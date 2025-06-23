<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DetailProdukMaster;
use App\Models\ProdukMaster;
use App\Models\ProdukVariant;
use App\Models\StokRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class StokController extends Controller
{
    public function index()
    {
        return view('admin.catalog.stok-view.list-stok-produk',[
            'title' => 'Kelola Stok',
            'sub_title' => 'Catalog - Kelola Stok',
        ]);
    }

    public function data(Request $request)
    {
        if ($request->ajax()) {
            // Produk tanpa varian
            $produkNonVariant = ProdukMaster::with('kategori_produk')
                ->where('use_variant', 'no')
                ->with(['detailProduk' => function($q) {
                    $q->select('id_detail_produk','id_master_produk', 'sku', 'harga', 'stok');
                }])
                ->get()
                ->map(function ($item) {
                    $detail = $item->detailProduk->first();
                    return (object)[
                        'id_master_produk' => $item->id_master_produk,
                        'nama_produk' => $item->nama_produk,
                        'gambar' => $item->gambar,
                        'slug' => $item->slug,
                        'use_variant' => $item->use_variant,
                        'id_detail_produk' => optional($detail)->id_detail_produk,
                        'id_var_produk' => null,
                        'detailProduk' => collect([(object)[
                            'sku' => optional($detail)->sku,
                            'harga' => optional($detail)->harga,
                            'stok' => optional($detail)->stok,
                        ]]),
                    ];
                });

                // Produk dengan varian (masing-masing varian jadi 1 row)
            $produkVariant = ProdukVariant::with([
                'produkMaster.kategori_produk',
                'variantValues.variantValues' // akses langsung relasi ke VariantValues
                ])
                ->get()
                ->map(function ($item) {
                    $namaVarian = $item->produkMaster->nama_produk;
                    $labelVarian = $item->variantValues->map(fn ($val) => $val->variantValues->value ?? '')->implode(' - ');

                    return (object)[
                        'id_master_produk' => $item->produkMaster->id_master_produk,
                        'nama_produk' => $namaVarian . ' - ' . $labelVarian,
                        'gambar' => $item->produkMaster->gambar,
                        'slug' => $item->produkMaster->slug,
                        'use_variant' => 'yes',
                        'id_var_produk' => $item->id_var_produk,
                        'id_detail_produk' => null,
                        'detailProduk' => collect([(object)[
                            'sku' => $item->sku,
                            'harga' => $item->harga,
                            'stok' => $item->stok,
                        ]]),
                    ];
                });

            // Gabungkan semua produk
            $data = $produkNonVariant->merge($produkVariant)->sortBy(function($item) {
                return optional($item->detailProduk->first())->stok ?? 0;
            })->values();

            $statusFilter = $request->get('status_filter');

            // Apply status filter jika dipilih
            if ($statusFilter && $statusFilter != 'Show All') {
                $data = $data->filter(function ($item) use ($statusFilter) {
                    $stok = optional($item->detailProduk->first())->stok ?? 0;

                    return match($statusFilter) {
                        'Stock Ada' => $stok >= 20,
                        'Stok Rendah' => $stok > 0 && $stok < 20,
                        'Stok Habis' => $stok <= 0,
                        default => true,
                    };
                })->values();
            }


            // Lanjut seperti sebelumnya
            return DataTables::of($data)
                ->addColumn('nama_produk', function($row){
                    $gambarPath = asset('storage/' . $row->gambar);
                    $label = $row->nama_produk;
                    return 
                    '<div class="d-flex align-items-center">
                        <a href="#" class="symbol symbol-50px">
                            <span class="symbol-label" style="background-image:url(\''. $gambarPath .'\');"></span>
                        </a>
                        <div class="ms-5">
                            <a href="#" class="text-gray-800 text-hover-primary fs-5 fw-bold">'
                                . $label .
                            '</a>
                        </div>
                    </div>';
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
                    $stok = $row->detailProduk->first() ? $row->detailProduk->first()->stok : 0;

                    if ($stok == 0) {
                        $class = 'badge-light-danger';
                        $label = 'Stok Habis';
                    } elseif ($stok < 20) {
                        $class = 'badge-light-warning';
                        $label = 'Stok Rendah';
                    } else {
                        $class = 'badge-light-success';
                        $label = 'Stok Ada';
                    }

                    return '<div class="badge '.$class.'">'.$label.'</div>';
                })
                ->addColumn('action', function($row){
                    return '
                    <button href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                    <i class="ki-duotone ki-down fs-5 ms-1"></i></button>
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3" data-bs-toggle="modal" data-bs-target="#kt_modal_add_stocks"
                                data-slug="'.$row->slug.'" 
                                data-use-variant="'.$row->use_variant.'"
                                data-nama-produk="'.e($row->nama_produk).'"
                                data-harga="'.e(optional($row->detailProduk->first())->harga).'"
                                data-stok="'.e(optional($row->detailProduk->first())->stok).'"
                                data-id-master-produk="'.$row->id_master_produk.'"
                                data-id-var-produk="'.($row->use_variant === 'yes' ? $row->id_var_produk ?? '' : '').'"
                                data-id-detail-produk="'.($row->use_variant === 'no' ? $row->id_detail_produk ?? '' : '').'"
                                data-kt-produk-table-filter="add_stock_row">
                                
                                Add Stock
                            </a>
                        </div>
                    </div>';
                })

                ->rawColumns(['action', 'nama_produk', 'use_variant', 'harga','stok','status'])
                ->make(true);
        }
    }


    public function store(Request $request)
    {
        $request->validate([
            'id_master_produk' => 'required|exists:produk_master,id_master_produk',
            'id_var_produk' => 'nullable|exists:produk_variant,id_var_produk',
            'id_detail_produk' => 'nullable|exists:detail_produk_master,id_detail_produk',
            'stok_awal' => 'required|integer|min:0',
            'stok_masuk' => 'required|integer|min:1',
            'stok_akhir' => 'required|integer|min:1',
            'keterangan' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            $idMasterProduk = $request->id_master_produk;
            $idVarProduk = $request->id_var_produk;
            $idDetailProduk = $request->id_detail_produk;
            $stokAwal = $request->stok_awal;
            $stokMasuk = $request->stok_masuk;
            $stokAkhir = $request->stok_akhir;
            $keterangan = $request->keterangan;

            $produk = ProdukMaster::findOrFail($idMasterProduk);

            if ($produk->use_variant === 'yes') {
                // Produk dengan varian
                if (!$idVarProduk) {
                    throw new \Exception('ID Varian harus diisi untuk produk dengan varian.');
                }

                $variant = ProdukVariant::where('id_var_produk', $idVarProduk)
                    ->where('id_master_produk', $idMasterProduk)
                    ->firstOrFail();

                // Update stok
                $variant->update(['stok' => $stokAkhir]);

                StokRecord::create([
                    'id_user' => auth()->id(),
                    'id_master_produk' => $idMasterProduk,
                    'id_var_produk' => $idVarProduk,
                    'stok_awal' => $stokAwal,
                    'stok_masuk' => $stokMasuk,
                    'stok_akhir' => $stokAkhir,
                    'keterangan' => $keterangan,
                    'slug' => Str::uuid(), // Gunakan UUID agar slug selalu unik
                ]);

            } else {
                // Produk tanpa varian
                if (!$idDetailProduk) {
                    throw new \Exception('ID Detail Produk harus diisi untuk produk tanpa varian.');
                }

                $detailProduk = DetailProdukMaster::where('id_detail_produk', $idDetailProduk)
                    ->where('id_master_produk', $idMasterProduk)
                    ->firstOrFail();

                // Update stok
                $detailProduk->update(['stok' => $stokAkhir]);

                StokRecord::create([
                    'id_user' => auth()->id(),
                    'id_master_produk' => $idMasterProduk,
                    'id_detail_produk' => $idDetailProduk,
                    'stok_awal' => $stokAwal,
                    'stok_masuk' => $stokMasuk,
                    'stok_akhir' => $stokAkhir,
                    'keterangan' => $keterangan,
                    'slug' => Str::uuid(), // slug wajib unik
                ]);
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Stok berhasil disimpan',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menambahkan stok: ' . $e->getMessage());
        }
    }

}
