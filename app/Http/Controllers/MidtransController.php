<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MidtransController extends Controller
{
    public function Callback() {
        \Midtrans\Config::$isProduction = env("MIDTRANS_IS_PRODUCTION", false);
        \Midtrans\Config::$serverKey = env("MIDTRANS_SERVER_KEY");
    
        $notif = new \Midtrans\Notification();
    
        $transaction_status = $notif->transaction_status;
        $payment_type = $notif->payment_type;
        $order_id = $notif->order_id;
        $fraud_status = $notif->fraud_status;
    
        $transaction = Transaction::where('order_id', $order_id)->first();
                
        if ($transaction_status == 'capture') {
            if ($payment_type == 'credit_card') {
                if ($fraud_status == 'accept') {
                    $transaction->status = 'Success';
                } else {
                    $transaction->status = 'Fraud';
                }
            }
        } else if ($transaction_status == 'settlement') {
            $transaction->status = 'Settlement';
        } else if ($transaction_status == 'pending') {
            $transaction->status = 'Pending';
        } else if ($transaction_status == 'deny') {
            $transaction->status = 'Denied';
        } else if ($transaction_status == 'expire') {
            $transaction->status = 'Expired';
        } else if ($transaction_status == 'cancel') {
            $transaction->status = 'Canceled';
        }
    
        $transaction->save();
        
        return response()->json(['message' => 'Transaction updated successfully']);
    }
    
}
