<?php

namespace App\Http\Controllers\Customers;

use App\Http\Controllers\Controller;
use App\Models\Keranjang;
use App\Models\KeranjangVariant;
use App\Models\ProdukMaster;
use App\Models\ProdukVariant;
use App\Models\ProdukVariantValues;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProdukDetailController extends Controller
{
    public function index($slug)
    {
        $pro_detail = ProdukMaster::where('slug', $slug)
            ->with([
                'kategori_produk',
                'variant' => function($query) {
                    $query->with(['variantValues' => function($q) {
                        $q->with('variantAttribute');
                    }]);
                }
            ])
            ->firstOrFail();
        // dd($pro_detail);
            $variantAttributes = [];

        foreach ($pro_detail->variant as $variant) {
            foreach ($variant->variantValues as $value) {
                $attributeName = $value->variantAttribute->nama_variant;
                $attributeSlug = $value->variantAttribute->slug;
                $optionValue = $value->variantValues->value;
                $optionId = $value->variantValues->id_variant_value;

                $variantAttributes[$attributeName]['slug'] = $attributeSlug;
                $variantAttributes[$attributeName]['values'][$optionId] = $optionValue;
            }
        }

        return view('customers.produk-detail',
            [
                'pro_detail' => $pro_detail,
                'variantAttributes' => $variantAttributes,
            ]
        );
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'id_master_produk' => 'required|exists:produk_master,id_master_produk',
            'jumlah' => 'required|integer|min:1',
            'variant_values' => 'required|array',
            'variant_values.*' => 'exists:variant_values,id_variant_value',
        ]);

        $userId = Auth::id();
        $idMasterProduk = $request->id_master_produk;
        $jumlah = $request->jumlah;
        $variantValueIds = $request->variant_values;

        DB::beginTransaction();

        try {
            // Cari kombinasi variant value ke produk_variant
            $variantProduk = DB::table('produk_variant_values')
                ->whereIn('id_variant_value', $variantValueIds)
                ->select('id_var_produk')
                ->groupBy('id_var_produk')
                ->havingRaw('COUNT(*) = ?', [count($variantValueIds)])
                ->pluck('id_var_produk')
                ->first();

            if (!$variantProduk) {
                return response()->json(['message' => 'Varian produk tidak valid'], 422);
            }

            // Ambil detail harga dari produk_variant
            $produkVariant = ProdukVariant::findOrFail($variantProduk);

            // Simpan ke keranjang
            $keranjang = Keranjang::create([
                'id_user' => $userId,
                'id_master_produk' => $idMasterProduk,
                'jumlah' => $jumlah,
            ]);

            // Simpan detail variant yang dipilih
            foreach ($variantValueIds as $variantValueId) {
                // Ambil id dari tabel pivot produk_variant_values
                $pivot = ProdukVariantValues::where([
                    'id_var_produk' => $produkVariant->id_var_produk,
                    'id_variant_value' => $variantValueId
                ])->first();

                if ($pivot) {
                    KeranjangVariant::create([
                        'id_keranjang' => $keranjang->id_keranjang,
                        'id_product_variant_value' => $pivot->id_product_variant_value
                    ]);
                }
            }

            DB::commit();
            return response()->json(['message' => 'Produk berhasil ditambahkan ke keranjang']);
        } catch (\Throwable $e) {
            DB::rollback();
            return response()->json(['message' => 'Gagal menambahkan ke keranjang', 'error' => $e->getMessage()], 500);
        }
    }

}
