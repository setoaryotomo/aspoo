<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CallbackLog;
use App\Models\Transaction;
use App\Modules\Portal\Model\TransaksiMaster;
use App\Modules\TransaksiBarang\Controllers\TransaksiBarangController;
use App\Modules\TransaksiBarang\Models\TransaksiBarang;
use App\Notifications\NotificationNewOrderDoctor;
use App\Notifications\NotificationNewOrderPatient;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Notification;

class MidtransController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function callback(Request $request)
    {
        // Set konfigurasi midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        // Buat instance midtrans notification
        $notification = new Notification();

        // Assign ke variable untuk memudahkan coding
        $status = $notification->transaction_status;
        $type = $notification->payment_type;
        $fraud = $notification->fraud_status;
        $order_id = $notification->order_id;

        // Cari transaksi berdasarkan code
        // 

        $transaction = TransaksiMaster::with('transaksi')->where('kode_transaksi', $order_id)->first();
        $transactionBarang = $transaction->transaksi;

        if (is_null($transaction)) {
            return response()->json([
                'meta' => [
                    'code' => 404,
                    'message' => 'Transaction not found'
                ]
            ]);
        }

        if ($transaction->payment_status == 'paid') {
            return redirect()->route('home_utama');
        }

        // Handle notification status midtrans
        if ($status == 'capture') {
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    $transaction->payment_status = 'pending';
                } else {
                    $transaction->payment_status = 'paid';
                }
            }
        } else if ($status == 'settlement') {
            $transaction->payment_status = 'paid';
        } else if ($status == 'pending') {
            $transaction->payment_status = 'pending';
        } else if ($status == 'deny') {
            $transaction->payment_status = 'failed';
        } else if ($status == 'expire') {
            $transaction->payment_status = 'failed';
        } else if ($status == 'cancel') {
            $transaction->payment_status = 'failed';
        }

        // Simpan transaksi
        $transaction->save();

        if ($transaction->payment_status == 'paid') {
            return redirect()->route('home_utama');
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function success(Request $request)
    {
        return view('midtrans.success');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function unfinish(Request $request)
    {
        return view('midtrans.unfinish');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function error(Request $request)
    {
        return view('midtrans.error');
    }
}