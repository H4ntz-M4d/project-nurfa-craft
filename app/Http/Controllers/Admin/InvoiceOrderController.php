<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transactions;
use App\Models\User;
use Illuminate\Http\Request;
use function Laravel\Prompts\select;

class InvoiceOrderController extends Controller
{
    public function invoiceOrderCustomers($slug, $order_id)
    {
        $user = User::with('customers:id_user,nama')
            ->select('id','email','slug')
            ->where('slug', $slug)
            ->firstOrFail();

        $transaksi = Transactions::with('details.produk','details.variants')
            ->where('id_user', $user->id)
            ->where('order_id', $order_id)
            ->firstOrFail();

        return view('admin.laporan.invoice',
        [
            'user' => $user,
            'transaksi' => $transaksi,
            'title' => 'Invoice User',
            'sub_title' => 'Laporan - Invoice User',
        ]);
    }
}
