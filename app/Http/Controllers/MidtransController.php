<?php

namespace App\Http\Controllers;

use App\Models\Transactions;
use Illuminate\Http\Request;

class MidtransController extends Controller
{
    public function handleNotification(Request $request)
    {
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $notification = new \Midtrans\Notification();

        $orderId = $notification->order_id;
        $transactionStatus = $notification->transaction_status;
        $paymentType = $notification->payment_type;

        $transaction = Transactions::where('order_id', $orderId)->first();

        if ($transaction) {
            if ($transactionStatus == 'settlement' || $transactionStatus == 'capture') {
                $transaction->status = 'paid';
            } elseif ($transactionStatus == 'pending') {
                $transaction->status = 'pending';
            } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
                $transaction->status = 'failed';
            }
            $transaction->save();
        }

        return response()->json(['message' => 'Notification handled'], 200);
    }
}
