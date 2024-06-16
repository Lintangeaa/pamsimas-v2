<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Midtrans\Snap;
use Midtrans\Config;
use Log;


class PembayaranController extends Controller
{

    public function index(Request $request)
    {
        $tagihans = Tagihan::with('pembayarans')
            ->whereHas('user.pelanggan', function ($query) use ($request) {
                if ($request->has('no_pelanggan')) {
                    $query->where('no_pelanggan', 'like', '%' . $request->no_pelanggan . '%');
                }
            })
            ->get();

        return view('admin.pembayaran.index', compact('tagihans'));
    }

    public function bayar($tagihan_id, Request $request)
    {
        Log::info("Mencoba untuk membayar tagihan dengan ID: " . $tagihan_id);

        $tagihan = Tagihan::findOrFail($tagihan_id);

        // Set your Merchant Server Key
        Config::$serverKey = config('services.midtrans.server_key');
        Log::info("Server Key: " . Config::$serverKey);
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        Config::$isProduction = config('services.midtrans.is_production');
        Log::info("Is Production: " . Config::$isProduction);
        // Set sanitization on (default)
        Config::$isSanitized = config('services.midtrans.is_sanitized');
        Log::info("Is Sanitized: " . Config::$isSanitized);
        // Set 3DS transaction for credit card to true
        Config::$is3ds = config('services.midtrans.is_3ds');
        Log::info("Is 3DS: " . Config::$is3ds);

        $params = [
            'transaction_details' => [
                'order_id' => 'order-' . $tagihan->id,
                'gross_amount' => $tagihan->total,
            ],
            'customer_details' => [
                'first_name' => $tagihan->user->pelanggan->nama_pelanggan,
                'email' => $tagihan->user->email,
                'phone' => $tagihan->user->pelanggan->no_pelanggan,
            ],
        ];

        Log::info("Params: " . json_encode($params));

        try {
            $snapToken = Snap::getSnapToken($params);
            Log::info("Snap Token berhasil dibuat: " . $snapToken);
            return view('admin.pembayaran.bayar', compact('tagihan', 'snapToken'));
        } catch (\Exception $e) {
            Log::error("Gagal membuat pembayaran: " . $e->getMessage());
            Log::error("Trace: " . $e->getTraceAsString());
            return redirect()->route('admin.pembayaran.index')->with('error', 'Gagal membuat pembayaran. Silakan coba lagi.');
        }
    }
}
