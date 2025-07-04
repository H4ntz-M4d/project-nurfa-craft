<?php

namespace App\Http\Controllers\Customers;

use App\Http\Controllers\Controller;
use App\Models\ProdukMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{

    // public function askAI(Request $request)
    // {
    //     $request->validate([
    //         'content' => 'required|string|max:255',
    //     ]);

    //     // Step 1: Ambil produk lengkap dengan detail & varian
    //     $produkList = ProdukMaster::with([
    //         'detailProduk:id_detail_produk,id_master_produk,stok',
    //         'variant' => function ($query) {
    //             $query->select('id_var_produk', 'id_master_produk', 'stok');
    //         },
    //         'variant.variantValues.variantAttribute:id_variant_attributes,nama_variant',
    //         'variant.variantValues.variantValues:id_variant_value,value'
    //     ])
    //     ->select('id_master_produk', 'nama_produk', 'deskripsi')
    //     ->take(10)
    //     ->get();

    //     // Step 2: Susun context string
    //     $produkContext = "";
    //     foreach ($produkList as $produk) {
    //         $produkContext .= "- {$produk->nama_produk}: {$produk->deskripsi}\n";

    //         if ($produk->use_variant === 'no') {
    //             $stok = $produk->detailProduk->first()?->stok ?? 'Tidak diketahui';
    //             $produkContext .= "  Stok: {$stok}\n";
    //         } else {
    //             foreach ($produk->variant as $varian) {
    //                 $stokVarian = $varian->stok;
    //                 $atribut = [];

    //                 foreach ($varian->variantValues as $vv) {
    //                     $atribut[] = "{$vv->variantAttribute->nama_variant}: {$vv->variantValues->value}";
    //                 }

    //                 $labelVarian = implode(', ', $atribut);
    //                 $produkContext .= "  Varian ({$labelVarian}) - Stok: {$stokVarian}\n";
    //             }
    //         }
    //     }

    //     // Step 3: Format pesan ke AI
    //     $messages = [
    //         [
    //             'role' => 'system',
    //             'content' => "Kamu adalah asisten toko Nurfa Craft. Jawablah hanya berdasarkan data berikut:\n\n$produkContext\n\nJika pertanyaan tidak sesuai, jawab: 'Maaf, saya hanya bisa menjawab pertanyaan seputar produk Nurfa Craft.'"
    //         ],
    //         [
    //             'role' => 'user',
    //             'content' => $request->input('content')
    //         ]
    //     ];

    //     // Step 4: Kirim ke LLM
    //     $res = Http::withToken(config('services.deepseek.key')) // pakai .env
    //         ->timeout(60)
    //         ->post('https://api.deepseek.com/chat/completions', [
    //             'model' => 'deepseek-chat',
    //             'messages' => $messages,
    //             'temperature' => 0.7,
    //             'max_tokens' => 512,
    //         ]);

    //     // Step 5: Response
    //     return response()->json([
    //         'reply' => $res['choices'][0]['message']['content'] ?? 'Tidak ada jawaban.',
    //     ]);
    // }

    public function askAI(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:255',
        ]);

        // Step 1: Ambil produk lengkap dengan detail & varian
        $produkList = ProdukMaster::with([
            'detailProduk:id_detail_produk,id_master_produk,stok,harga',
            'variant' => function ($query) {
                $query->select('id_var_produk', 'id_master_produk', 'stok', 'harga');
            },
            'variant.variantValues.variantAttribute:id_variant_attributes,nama_variant',
            'variant.variantValues.variantValues:id_variant_value,value'
        ])
        ->select('id_master_produk', 'nama_produk', 'deskripsi', 'use_variant')
        ->take(10)
        ->get();

        // Step 2: Susun context string
        $produkContext = "";
        foreach ($produkList as $produk) {
            $produkContext .= "- Produk: {$produk->nama_produk}\n";
            $produkContext .= "  Deskripsi: {$produk->deskripsi}\n";

            if ($produk->use_variant == 'yes') {
                foreach ($produk->variant as $varian) {
                    $values = $varian->variantValues->map(function ($v) {
                        return "{$v->variantAttribute->nama_variant}: {$v->variantValues->value}";
                    })->implode(', ');

                    $produkContext .= "  Varian: ({$values}) - Stok: {$varian->stok} - Harga: {$varian->harga}\n";
                }
            } else {
                $harga = $produk->detailProduk->first()?->harga ?? 0;
                $stok = $produk->detailProduk->first()?->stok ?? 0;
                $produkContext .= "  Harga: Rp{$harga} - Stok: {$stok}\n";
            }

            $produkContext .= "\n";
        }
        // dd($produkContext);

        // Step 3: Format pesan ke AI
        $messages = [
            [
                'role' => 'system',
                'content' => "Kamu adalah asisten toko Nurfa Craft. Berdasarkan data berikut, jawablah pertanyaan user dengan jelas dan spesifik sesuai dengan data apapun yang di dapatkan.\n\nJika kamu tidak menemukan informasi yang cocok dengan pertanyaan dari data tersebut, jawab bahwa kamu tidak menemukan informasi yang user tanyakan tersebut.\n\nBerikut daftar produk:\n\n$produkContext"
            ],
            [
                'role' => 'user',
                'content' => $request->input('content')
            ]
        ];

        // Step 4: Kirim ke LLM
        $res = Http::withToken(config('services.deepseek.key')) // pakai .env
            ->post('https://api.deepseek.com/chat/completions', [
                'model' => 'deepseek-chat',
                'messages' => $messages,
            ]);

        // Step 5: Response
        return response()->json([
            'reply' => $res['choices'][0]['message']['content'] ?? 'Tidak ada jawaban.',
        ]);
    }


}
