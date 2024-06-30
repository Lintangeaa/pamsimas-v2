<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Tagihan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PembayaranController extends Controller
{
    // Metode untuk pembayaran via admin
    public function index(Request $request)
    {
        // Query untuk mengambil tagihan beserta pembayarannya
        $tagihans = Tagihan::with('pembayarans')
            ->whereHas('user.pelanggan', function ($query) use ($request) {
                if ($request->has('no_pelanggan')) {
                    $query->where('no_pelanggan', 'like', '%' . $request->no_pelanggan . '%');
                }
            })
            ->get();

        // Format waktu pembayaran
        foreach ($tagihans as $tagihan) {
            if ($tagihan->pembayarans->isNotEmpty() && $tagihan->pembayarans->first()->status) {
                $waktu_pembayaran = $tagihan->pembayarans->first()->updated_at;
                $formatted_date = Carbon::parse($waktu_pembayaran)->setTimezone('Asia/Jakarta')
                    ->isoFormat('dddd, D MMMM Y, HH:mm');

                $tagihan->waktu_pembayaran = $formatted_date;
            } else {
                $tagihan->waktu_pembayaran = '-';
            }
        }

        return view('Admin.Pembayaran.index', compact('tagihans'));
    }

    // Metode untuk inisiasi pembayaran (Snap Token)
    public function bayar(Request $request, $tagihan_id)
    {
        try {
            $tagihan = Tagihan::findOrFail($tagihan_id);

            // Cek apakah sudah ada pembayaran untuk tagihan ini
            $pembayaran = Pembayaran::where('tagihan_id', $tagihan->id)->first();

            if ($pembayaran) {
                return response()->json(['snap_token' => $pembayaran->snap_token, 'code' => $pembayaran->code]);
            } else {
                return response()->json(['error' => 'Pembayaran not found for this tagihan'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Metode untuk menangani status pembayaran
    public function handleStatus(Request $request)
    {
        $request->validate([
            'transaction_status' => 'required',
            'order_id' => 'required',
        ]);

        // Ambil order_id dari request
        $orderId = $request->order_id;

        // Cari pembayaran berdasarkan order_id
        $pembayaran = Pembayaran::where('code', $orderId)->first();

        if (!$pembayaran) {
            return response()->json(['error' => 'Pembayaran not found'], 404);
        }

        // Update status pembayaran sesuai transaction_status
        $transactionStatus = $request->transaction_status;
        $pembayaran->status = $transactionStatus;
        $pembayaran->save();

        return response()->json(['success' => true]);
    }

    // Metode untuk pembayaran tunai (langsung sukses)
    public function bayarCash(Request $request, $tagihan_id)
    {
        try {
            $tagihan = Tagihan::findOrFail($tagihan_id);

            // Cek apakah sudah ada pembayaran untuk tagihan ini
            $pembayaran = Pembayaran::where('tagihan_id', $tagihan->id)->first();

            if (!$pembayaran) {
                // Simpan informasi pembayaran tunai
                $pembayaran = Pembayaran::create([
                    'code' => $tagihan->user->pelanggan->no_pelanggan . '_' . Carbon::now()->timestamp,
                    'snap_token' => 'Tunai',
                    'tagihan_id' => $tagihan_id,
                    'total_pembayaran' => $tagihan->total,
                    'status' => 'success',
                ]);

                return response()->json(['message' => 'Pembayaran tunai berhasil'], 200);
            } else {
                return response()->json(['error' => 'Pembayaran sudah dilakukan'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
