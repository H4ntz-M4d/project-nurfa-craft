<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Dashboard extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->role === 'customers') {
            return redirect()->route('home');
        }
        
        return view('dashboard',[
            'title' => 'Dashboard',
            'sub_title' => 'Dashboard'
        ]);
    }

    public function getDailyIncome()
    {
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();

        $todayIncome = DB::table('transactions')
            ->whereDate('created_at', $today)
            ->where('status', 'unpaid') // hanya paid yang dihitung
            ->sum('total');

        $yesterdayIncome = DB::table('transactions')
            ->whereDate('created_at', $yesterday)
            ->where('status', 'unpaid')
            ->sum('total');

        $percentage = 0;
        if ($yesterdayIncome > 0) {
            $percentage = (($todayIncome - $yesterdayIncome) / $yesterdayIncome) * 100;
        }
        

        return response()->json([
            'today' => round($todayIncome, 2),
            'yesterday' => round($yesterdayIncome, 2),
            'percentage' => round($percentage, 1), // contoh: 2.6
        ]);
    }


    public function getDailySales()
    {
        $data = DB::table('transactions')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as total'))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date', 'asc')
            ->get();

        // Response dalam bentuk: { labels: [...], data: [...] }
        $labels = $data->pluck('date')->toArray();
        $values = $data->pluck('total')->toArray();

        return response()->json([
            'labels' => $labels,
            'data' => $values,
        ]);
    }

    public function getMonthSales()
    {
        $today = Carbon::now();
        $startOfMonth = $today->copy()->startOfMonth();
        $endOfMonth = $today->copy()->endOfMonth();

        $sales = DB::table('transactions')
            ->selectRaw('DATE(created_at) as date, SUM(total) as total')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get();

        // Buat array label dan data langsung dari hasil query
        $labels = $sales->pluck('date')->map(function ($date) {
            return Carbon::parse($date)->format('M d'); // Contoh: "Jun 17"
        });

        $data = $sales->pluck('total')->map(function ($total) {
            return (int) $total;
        });

        $totalBulanIni = $data->sum();

        return response()->json([
            'labels' => $labels,
            'data' => $data,
            'total' => $totalBulanIni,
        ]);
    }

    public function getMonthOrderTotal()
    {
        $now = Carbon::now();

        // Periode bulan ini
        $startOfMonth = $now->copy()->startOfMonth();
        $endOfMonth = $now->copy()->endOfMonth();

        // Periode bulan lalu
        $startOfLastMonth = $now->copy()->subMonth()->startOfMonth();
        $endOfLastMonth = $now->copy()->subMonth()->endOfMonth();

        // Total order bulan ini
        $thisMonthOrder = DB::table('transactions')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->count();

        // Total order bulan lalu
        $lastMonthOrder = DB::table('transactions')
            ->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])
            ->count();

        // Hitung persentase pencapaian terhadap bulan lalu
        $percentage = 0;
        $goal_gap = 0;
        $goal_percentage = 0;

        if ($lastMonthOrder > 0) {
            $percentage = (($thisMonthOrder - $lastMonthOrder) / $lastMonthOrder) * 100;
            $goal_percentage = min(round(($thisMonthOrder / $lastMonthOrder) * 100), 100); // batas 100%
            $goal_gap = $lastMonthOrder - $thisMonthOrder;
        }

        return response()->json([
            'total' => $thisMonthOrder,
            'percentage' => round($percentage, 1),
            'goal_gap' => $goal_gap,
            'goal_percentage' => $goal_percentage,
        ]);
    }


    public function getTotalCustomers()
    {
        $totalCustomers = User::where('role', 'customers')
            ->count();

        $latestUsers = User::with('customers:id_user,nama')->where('role', 'customers')
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get(['id']);

        return response()->json([
            'total' => $totalCustomers,
            'latest_users' => $latestUsers,
        ]);
    }

    public function getProdukStat()
    {
        // Ambil total produk
        $totalProduk = DB::table('produk_master')->count();

        // Ambil jumlah produk per kategori (limit 2 kategori teratas)
        $kategoriCounts = DB::table('kategori_produk as kp')
            ->join('produk_master as pm', 'kp.id_ktg_produk', '=', 'pm.id_ktg_produk')
            ->select('kp.nama_kategori', DB::raw('COUNT(pm.id_master_produk) as jumlah'))
            ->groupBy('kp.id_ktg_produk', 'kp.nama_kategori')
            ->orderByDesc('jumlah')
            ->get();

        $kategori1 = $kategoriCounts[0] ?? null;
        $kategori2 = $kategoriCounts[1] ?? null;

        // Hitung jumlah produk kategori lainnya
        $otherCount = $kategoriCounts->skip(2)->sum('jumlah');

        // Kirim data ke frontend
        return response()->json([
            'total' => $totalProduk,
            'kategori1' => $kategori1,
            'kategori2' => $kategori2,
            'others' => $otherCount
        ]);
    }

}
