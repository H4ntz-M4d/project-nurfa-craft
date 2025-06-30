<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customers;
use App\Models\TransactionDetails;
use App\Models\Transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Yajra\DataTables\Facades\DataTables;

class CustomersController extends Controller
{
    public function index()
    {
        return view('admin.users-management.customers.customers',[
            'title' => 'Customers',
            'sub_title' => 'Manajemen Users - Customers'
        ]);
    }

    public function data(Request $request)
    {
        if($request->ajax()){
            $data = Customers::with('users:id,email,role')
            ->select('id_customers','id_user','nama','no_telp','created_at','slug')
            ->whereHas('users', function ($query) {
                $query->where('role', 'customers');
            });
            return DataTables::of($data)
            ->addColumn('checkbox', function($row){
                return '<input type="checkbox" class="form-check-input" value="'.$row->slug.'">';
            })
            ->addColumn('email', function($row){
                return $row->users->email;
            })
            ->addColumn('action', function($row){
                return '
                <button href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
                <i class="ki-duotone ki-down fs-5 ms-1"></i></button>
                <!--begin::Menu-->
                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        <a href="/customers-view/'.$row->slug.'" class="menu-link px-3">View</a>
                    </div>
                    <!--end::Menu item-->
                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        <a href="#" class="menu-link px-3" data-slug="'.$row->slug.'" data-kt-customer-table-filter="delete_row">Delete</a>
                    </div>
                    <!--end::Menu item-->
                </div>
                ';
            })                
            ->rawColumns(['checkbox', 'action','email'])
            ->make(true);
        }
    }

    public function store(Request $request)
    {
        
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:karyawan,email',
            'no_telp' => 'required|string|max:15',
            'alamat' => 'required|string',
        ]);
    
        Customers::create($request->all());

        // Kirim response JSON jika request berasal dari AJAX
        return response()->json([ 
            'success' => true,
            'message' => 'Data berhasil disimpan'
        ]);
    }

    public function view($slug)
    {
        $customer = Customers::with('users:id,username,email,role,slug')->where('slug', $slug)->first();
        if (!$customer) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        $transaksi = Transactions::with('details')->whereHas('user', function ($query) use ($slug) {
            $query->where('slug', $slug);
        })->select('id_transaction', 'id_user', 'total')->get();

        $user = $customer->users;
        // Ambil semua transaksi user dan hitung total jumlah item dari detail
        $totalProdukDibeli = TransactionDetails::whereHas('transaction', function ($query) use ($user) {
            $query->where('id_user', $user->id);
        })->sum('jumlah');

        $totalTransaksi = $transaksi->sum('total');

        return view('admin.users-management.customers.view-customer', [
            'title' => 'View Customer',
            'sub_title' => 'Manajemen Users - Customers',
            'customer' => $customer,
            'totalTransaksi' => $totalTransaksi,
            'totalProdukDibeli' => $totalProdukDibeli,
        ]);
    }

    public function dataOrders(Request $request, $slug)
    {
        if ($request->ajax()) {
            $data = Transactions::select(
                    'id_transaction', 'id_user', 'order_id', 'tanggal', 'total',
                    'status'
                )
                ->with(['details', 'user'])
                ->whereHas('user', function ($query) use ($slug) {
                    $query->where('slug', $slug);
                })
                ->get()
                ->map(function ($item) {

                    $order = $item->order_id ?? '-';
                    $item->order_id = $order;

                    $item->tanggal = Carbon::parse($item->tanggal)->timezone('Asia/Jakarta')->format('d F Y');
                    $item->total = 'Rp' . number_format($item->total, 0,',','.');
                    $item->user_slug = optional($item->user)->slug;

                    return $item;
                })->sortByDesc('tanggal');

            return DataTables::collection($data)
                ->addColumn('status', function($row){
                    $status = ucfirst($row->status);
                    
                    if ($row->status === 'paid') {
                        $statusRow = '<span class="badge badge-light-success d-inline">'.$status.'</span>';
                    } elseif ($row->status === 'unpaid') {
                        $statusRow = '<span class="badge badge-light-danger d-inline">'.$status.'</span>';
                    } elseif ($row->status === 'pending') {
                        $statusRow = '<span class="badge badge-light-warning d-inline">'.$status.'</span>';
                    }

                    return $statusRow;
                })
                ->addColumn('action', function($row): string{
                    return '
                    <button href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                    <i class="ki-duotone ki-down fs-5 ms-1"></i></button>
                    <!--begin::Menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                        <div class="menu-item px-3">
                            <a href="/invoice-users/'.$row->user_slug.'/'.$row->order_id.'" class="menu-link">
                                Invoice
                            </a>
                        </div>
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3" data-slug="'.$row->slug.'" data-kt-karyawan-table-filter="delete_row">Delete</a>
                        </div>
                        <!--end::Menu item-->
                    </div>  
                    ';
                })
                ->rawColumns(['action','status'])
                ->make(true);

        }
    }

    public function destroy($id)
    {
        $customers = Customers::where('slug', $id);
        $customers->delete();
    
        return response()->json(['success' => true, 'message' => 'Karyawan berhasil dihapus']);
    }
    
    public function destroySelected(Request $request)
    {
        $ids = $request->ids;
        if (!$ids || !is_array($ids)) {
            return response()->json(['success' => false, 'message' => 'ID tidak valid'], 400);
        }

        Customers::whereIn('slug', $ids)->delete();

        return response()->json(['success' => true, 'message' => 'Data karyawan berhasil dihapus']);
    }
}
