<?php

namespace App\Http\Controllers;

use App\Exports\LaporanExport;
use App\Models\Pembayaran;
use App\Models\Tagihan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Midtrans\Notification;
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

        // Array nama hari dalam bahasa Indonesia
        $nama_hari = [
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
            7 => 'Minggu',
        ];

        // Array nama bulan dalam bahasa Indonesia
        $nama_bulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        foreach ($tagihans as $tagihan) {
            if ($tagihan->pembayarans->isNotEmpty() && $tagihan->pembayarans->first()->status) {
                // Ambil waktu pembayaran dari model Pembayaran
                $waktu_pembayaran = $tagihan->pembayarans->first()->updated_at;

                // Konversi waktu ke zona waktu WIB (Asia/Jakarta)
                $date = Carbon::parse($waktu_pembayaran)->setTimezone('Asia/Jakarta');

                // Mendapatkan nama hari dan bulan dalam bahasa Indonesia
                $hari = $nama_hari[$date->dayOfWeek];
                $bulan = $nama_bulan[$date->month];

                // Format waktu
                $formatted_date = $hari . ', ' . $date->format('d') . ' ' . $bulan . ' ' . $date->format('Y, H:i');

                // Tambahkan atribut baru ke dalam objek $tagihan
                $tagihan->waktu_pembayaran = $formatted_date;
            } else {
                // Jika belum dibayar, tetapkan teks 'Belum Dibayar'
                $tagihan->waktu_pembayaran = '-';
            }
        }

        return view('admin.pembayaran.index', compact('tagihans'));
    }

    public function bayar(Request $request, $tagihan_id)
    {
        try {
            $tagihan = Tagihan::findOrFail($tagihan_id);


            $pembayaran = Pembayaran::where('tagihan_id', $tagihan->id)->first();

            if ($pembayaran) {

                $snapToken = $pembayaran->snap_token;
            } else {
                // Jika belum ada pembayaran, maka baru akan dibuat
                $user = User::with('pelanggan')->findOrFail($tagihan->user_id);

                // Konfigurasi Midtrans
                Config::$serverKey = config('services.midtrans.server_key');
                Config::$clientKey = config('services.midtrans.client_key');
                Config::$isSanitized = true;
                Config::$is3ds = true;

                // Parameter untuk pembayaran Snap
                $params = [
                    'transaction_details' => [
                        'order_id' => $user->pelanggan->no_pelanggan . '_' . Carbon::now()->timestamp,
                        'gross_amount' => $tagihan->total,
                    ],
                    'customer_details' => [
                        'first_name' => $user->pelanggan->nama_pelanggan,
                    ],
                ];

                // Mendapatkan token Snap
                $snapToken = Snap::getSnapToken($params);

                // Membuat entri pembayaran baru
                $pembayaran = Pembayaran::create([
                    'code' => $params['transaction_details']['order_id'],
                    'tagihan_id' => $tagihan_id,
                    'total_pembayaran' => $tagihan->total,
                    'status' => 'pending',
                    'snap_token' => $snapToken,
                ]);
            }

            // Mengembalikan snapToken sebagai respons JSON
            return response()->json(['snap_token' => $snapToken, 'code' => $pembayaran->code]);
        } catch (\Exception $e) {
            // Mengembalikan pesan error jika ada masalah
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

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

    //PELANGGAN
    public function getPembayaran()
    {
        $userId = auth()->user()->id;

        // Query untuk mencari tagihan yang belum memiliki pembayaran berdasarkan user ID
        $pembayarans = Tagihan::with('pembayarans')
            ->where('user_id', $userId)
            ->get();

        // Array nama hari dalam bahasa Indonesia
        $nama_hari = [
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
            7 => 'Minggu',
        ];

        // Array nama bulan dalam bahasa Indonesia
        $nama_bulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        foreach ($pembayarans as $data) {
            if ($data->pembayarans->isNotEmpty() && $data->pembayarans->first()->status) {
                // Ambil waktu pembayaran dari model Pembayaran
                $waktu_pembayaran = $data->pembayarans->first()->updated_at;

                // Konversi waktu ke zona waktu WIB (Asia/Jakarta)
                $date = Carbon::parse($waktu_pembayaran)->setTimezone('Asia/Jakarta');

                // Mendapatkan nama hari dan bulan dalam bahasa Indonesia
                $hari = $nama_hari[$date->dayOfWeek];
                $bulan = $nama_bulan[$date->month];

                // Format waktu
                $formatted_date = $hari . ', ' . $date->format('d') . ' ' . $bulan . ' ' . $date->format('Y, H:i');

                // Tambahkan atribut baru ke dalam objek $data
                $data->waktu_pembayaran = $formatted_date;
            } else {
                // Jika belum dibayar, tetapkan teks 'Belum Dibayar'
                $data->waktu_pembayaran = '-';
            }
        }

        return view('pelanggan.pembayaran.index', compact('pembayarans'));
    }

    public function cetakInvoice($tagihan_id)
    {
        $export = new LaporanExport();
        $export->exportInvoice($tagihan_id);
    }
}
