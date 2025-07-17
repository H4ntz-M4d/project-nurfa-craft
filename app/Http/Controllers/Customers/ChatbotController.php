<?php

namespace App\Http\Controllers\Customers;

use App\Http\Controllers\Controller;
use App\Models\ChatbotHistory;
use App\Models\ChatbotSession;
use App\Models\ProdukMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

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
            'session_id' => 'nullable|uuid'
        ]);

        $input = strtolower($request->input('content'));

        // === Step 1: Cek pertanyaan umum statis terlebih dahulu ===
        if (Str::contains($input, ['batas kapasitas order', 'kapasitas produksi', 'maksimal order'])) {
            return response()->json([
                'reply' => 'Batas kapasitas order per bulan adalah 3000 pcs, karena itu adalah kapasitas produksi kami per bulan. Jika ingin memesan lebih, silakan hubungi admin kami di WhatsApp 6288232000188.',
                'session_id' => $request->session_id ?? Str::uuid(),
            ]);
        }

        if (Str::contains($input, ['minimal order', 'min order'])) {
            return response()->json([
                'reply' => 'Minimal order per bulan adalah 100 pcs per model produk. Silakan hubungi admin kami di WhatsApp 6288232000188 untuk info lebih lanjut.',
                'session_id' => $request->session_id ?? Str::uuid(),
            ]);
        }

        // === Step 2: Session Chat ===
        $sessionId = $request->session_id;
        $session = ChatbotSession::firstOrCreate(
            ['session_id' => $sessionId ?? Str::uuid()],
            []
        );

        // === Step 3: Simpan Pertanyaan User ===
        ChatbotHistory::create([
            'chatbot_session_id' => $session->id,
            'role' => 'user',
            'message' => $request->input('content')
        ]);

        // === Step 4: Ambil 10 History Sebelumnya ===
        $history = ChatbotHistory::where('chatbot_session_id', $session->id)
            ->latest()
            ->take(10)
            ->get()
            ->reverse()
            ->map(fn($msg) => [
                'role' => $msg->role,
                'content' => $msg->message
            ])
            ->toArray();

        // === Step 5: Context Produk (dibatasi 10 produk) ===
        $produkList = ProdukMaster::with([
            'detailProduk:id_detail_produk,id_master_produk,stok,harga',
            'variant' => fn($q) => $q->select('id_var_produk', 'id_master_produk', 'stok', 'harga'),
            'variant.variantValues.variantAttribute:id_variant_attributes,nama_variant',
            'variant.variantValues.variantValues:id_variant_value,value'
        ])
        ->select('id_master_produk', 'nama_produk', 'deskripsi', 'use_variant')
        ->take(10)
        ->get();

        $produkContext = "";
        foreach ($produkList as $produk) {
            $produkContext .= "- Produk: {$produk->nama_produk}\n";
            $produkContext .= "  Deskripsi: {$produk->deskripsi}\n";

            if ($produk->use_variant === 'yes') {
                foreach ($produk->variant as $varian) {
                    $values = $varian->variantValues->map(fn($v) =>
                        "{$v->variantAttribute->nama_variant}: {$v->variantValues->value}"
                    )->implode(', ');
                    $produkContext .= "  Varian: ({$values}) - Stok: {$varian->stok} - Harga: Rp{$varian->harga}\n";
                }
            } else {
                $harga = $produk->detailProduk->first()?->harga ?? 0;
                $stok = $produk->detailProduk->first()?->stok ?? 0;
                $produkContext .= "  Harga: Rp{$harga} - Stok: {$stok}\n";
            }
            $produkContext .= "\n";
        }

        // === Step 6: Tambahkan SYSTEM Message ===
        array_unshift($history, [
            'role' => 'system',
            'content' => "Kamu adalah asisten digital untuk toko Nurfa Craft. Jawab pertanyaan berdasarkan data produk berikut:\n\n$produkContext\n\nJika ada pertanyaan yang tidak bisa dijawab, arahkan user untuk menghubungi admin di WhatsApp: 6288232000188."
        ]);

        // === Step 7: Kirim ke DeepSeek LLM ===
        $res = Http::withToken(config('services.deepseek.key'))
            ->post('https://api.deepseek.com/chat/completions', [
                'model' => 'deepseek-chat',
                'messages' => $history,
            ]);

        $reply = $res['choices'][0]['message']['content'] ?? 'Maaf, saya tidak bisa menjawab pertanyaan itu saat ini.';

        // === Step 8: Simpan Jawaban AI ===
        ChatbotHistory::create([
            'chatbot_session_id' => $session->id,
            'role' => 'assistant',
            'message' => $reply
        ]);

        // === Step 9: Kirim Balasan ke Frontend ===
        return response()->json([
            'reply' => $reply,
            'session_id' => $session->session_id
        ]);
    }

}