<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengeluaran;
use App\Models\Pesanan;
use App\Models\TransactionDetails;
use App\Models\Transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ReportOmsetController extends Controller
{
    public function index()
    {
        return view('admin.laporan.report.report-omset-bulanan',[
            'title' => 'Laporan Omset Tahunan',
            'sub_title' => 'Laporan Omset Tahunan',
        ]);
    }

    public function data(Request $request)
    {
        if ($request->ajax()) {
            $tahun = Transactions::selectRaw('YEAR(created_at) as tahun')
                ->groupBy('tahun')
                ->orderBy('tahun', 'desc')
                ->get();

            $data = [];

            foreach ($tahun as $thn) {
                $pemasukan = Transactions::whereYear('created_at', $thn->tahun)
                    ->where('status', 'paid')
                    ->sum('total');

                $pengeluaran = Pengeluaran::whereYear('created_at', $thn->tahun)
                    ->sum('jumlah_pengeluaran');

                $ongkos_kirim = Pesanan::whereYear('created_at', $thn->tahun)
                    ->where(function ($query) {
                        $query->where('status', 'selesai')
                            ->orWhere('status', 'dikirim');
                    })
                    ->sum('harga_pengiriman');


                $omzet_tahunan = $pemasukan - $pengeluaran + $ongkos_kirim;

                $data[] = [
                    'tahun' => $thn->tahun,
                    'pemasukan' => number_format($pemasukan, 0, ',', '.'),
                    'pengeluaran' => number_format($pengeluaran, 0, ',', '.'),
                    'ongkos_kirim' => number_format($ongkos_kirim, 0, ',', '.'),
                    'omzet_tahunan' => number_format($omzet_tahunan, 0, ',', '.'),
                    'action' => '
                        <a href="/cetak-report-omzet/'.$thn->tahun.'" class="btn btn-sm btn-info btn-flex btn-center btn-active-light-primary">
                            <i class="ki-solid ki-cheque fs-5 ms-1"></i>
                            Cetak Report
                        </a>
                    ', // placeholder
                ];
            }
            return response()->json(['data' => $data]);
        }
    }

    public function cetakReportOmzet($tahun)
    {
        $bulanSekarang = now()->month; // Sampai bulan sekarang
        $data = [];
        $totalOmzetTahunIni = 0;

        for ($i = 1; $i <= $bulanSekarang; $i++) {
            $namaBulan = Carbon::create()->month($i)->translatedFormat('F');

            $pemasukan = Transactions::whereYear('created_at', $tahun)
                ->whereMonth('created_at', $i)
                ->where('status', 'paid')
                ->sum('total');

            $pengeluaran = Pengeluaran::whereYear('created_at', $tahun)
                ->whereMonth('created_at', $i)
                ->sum('jumlah_pengeluaran');

            $ongkir = Pesanan::whereYear('created_at', $tahun)
                ->whereMonth('created_at', $i)
                ->where(function ($query) {
                    $query->where('status', 'selesai')->orWhere('status', 'dikirim');
                })
                ->sum('harga_pengiriman');

            $omzet = $pemasukan + $ongkir - $pengeluaran;
            $totalOmzetTahunIni += $omzet; // Tambahkan ke total

            $data[] = [
                'bulan' => $namaBulan,
                'pemasukan' => number_format($pemasukan, 0, ',', '.'),
                'pengeluaran' => number_format($pengeluaran, 0, ',', '.'),
                'ongkir' => number_format($ongkir, 0, ',', '.'),
                'omzet' => number_format($omzet, 0, ',', '.'),
            ];
        }

        $produkTerlaris = TransactionDetails::whereHas('transaction', function ($q) use ($tahun) {
                $q->whereYear('created_at', $tahun)
                ->where('status', 'paid');
            })
            ->select('id_master_produk', 'nama_produk')
            ->selectRaw('SUM(jumlah) as total_terjual, MIN(harga) as harga_dasar, SUM(jumlah * harga) as total_penjualan')
            ->groupBy('id_master_produk', 'nama_produk')
            ->orderByDesc('total_terjual')
            ->limit(10)
            ->get();

        $produkList = $produkTerlaris->map(function ($item) {
            return [
                'nama_produk' => $item->nama_produk,
                'jum_produk_dibeli' => number_format($item->total_terjual, 0, ',', '.'),
                'harga_brng' => number_format($item->harga_dasar, 0, ',', '.'),
                'total' => number_format($item->total_penjualan, 0, ',', '.'),
            ];
        });


        return view('admin.laporan.report.cetak-report', [
            'title' => 'Cetak Report Omzet ' . $tahun,
            'sub_title' => 'Laporan per Bulan Tahun ' . $tahun,
            'data' => $data,
            'tahun' => $tahun,
            'totalOmzetTahunIni' => number_format($totalOmzetTahunIni, 0, ',', '.'),
            'produkTerlaris' => $produkList,
        ]);

    }

    public function grafikTahunan($tahun)
    {
        $bulanSekarang = now()->month;

        $pemasukanData = [];
        $pengeluaranData = [];
        $ongkirData = [];
        $omzetData = [];
        $labels = [];

        for ($i = 1; $i <= $bulanSekarang; $i++) {
            $namaBulan = Carbon::create()->month($i)->translatedFormat('F');
            $labels[] = $namaBulan;

            $pemasukan = Transactions::whereYear('created_at', $tahun)
                ->whereMonth('created_at', $i)
                ->where('status', 'paid')
                ->sum('total');

            $pengeluaran = Pengeluaran::whereYear('created_at', $tahun)
                ->whereMonth('created_at', $i)
                ->sum('jumlah_pengeluaran');

            $ongkir = Pesanan::whereYear('created_at', $tahun)
                ->whereMonth('created_at', $i)
                ->where(function ($q) {
                    $q->where('status', 'selesai')->orWhere('status', 'dikirim');
                })
                ->sum('harga_pengiriman');

            $omzet = $pemasukan + $ongkir - $pengeluaran;

            $pemasukanData[] = $pemasukan;
            $pengeluaranData[] = $pengeluaran;
            $ongkirData[] = $ongkir;
            $omzetData[] = $omzet;
        }

        return response()->json([
            'labels' => $labels,
            'pemasukan' => $pemasukanData,
            'pengeluaran' => $pengeluaranData,
            'ongkir' => $ongkirData,
            'omzet' => $omzetData,
        ]);
    }
    
    public function grafikProdukTerlaris($tahun)
    {
        $topProduk = DB::table('transaction_details')
            ->join('produk_master', 'transaction_details.id_master_produk', '=', 'produk_master.id_master_produk')
            ->join('transactions', 'transaction_details.id_transaction', '=', 'transactions.id_transaction')
            ->whereYear('transactions.created_at', $tahun)
            ->where('transactions.status', 'paid')
            ->selectRaw('produk_master.nama_produk, SUM(transaction_details.jumlah) as total_terjual')
            ->groupBy('produk_master.nama_produk')
            ->orderByDesc('total_terjual')
            ->limit(10)
            ->get();

        $labels = $topProduk->pluck('nama_produk');
        $data = $topProduk->pluck('total_terjual');

        return response()->json([
            'labels' => $labels,
            'data' => $data,
        ]);
    }

    

}
