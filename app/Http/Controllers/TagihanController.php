<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Tagihan;
use Illuminate\Support\Carbon;

class TagihanController extends Controller
{
    public function index()
    {
        $tagihans = Tagihan::all();

        return view('admin.tagihan.index', compact('tagihans'));
    }

    public function create()
    {
        // Untuk contoh sederhana, ambil semua user
        $users = User::where('role', 'pelanggan')->with('pelanggan')->get();
        return view('Admin.Tagihan.buat-tagihan', compact('users'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'user_id' => 'required',
            'periode' => 'required',
            'pemakaian' => 'required|numeric',
            'total' => 'required|numeric',
        ]);

        // Ambil informasi user berdasarkan user_id
        $user = User::findOrFail($request->user_id);

        // Retrieve Midtrans API keys from configuration
        $serverKey = config('services.midtrans.server_key');
        $clientKey = config('services.midtrans.client_key');

        $params = [
            'transaction_details' => [
                'order_id' => $user->pelanggan->no_pelanggan . '_' . Carbon::now()->timestamp,
                'gross_amount' => $request->total,
            ],
            'customer_details' => [
                'first_name' => $user->pelanggan->nama_pelanggan,
            ],
        ];

        \Midtrans\Config::$serverKey = $serverKey;
        \Midtrans\Config::$clientKey = $clientKey;


        $snapToken = \Midtrans\Snap::getSnapToken($params);

        // Simpan data ke database untuk tagihan
        Tagihan::create([
            'user_id' => $request->user_id,
            'periode' => $request->periode,
            'pemakaian' => $request->pemakaian,
            'total' => $request->total,
        ]);



        try {
            return redirect()->route('admin.tagihan.index')->with('success', 'Tagihan berhasil ditambahkan dan pembayaran sedang diproses.');

        } catch (\Exception $e) {
            // Handle error jika terjadi masalah saat mendapatkan Snap Token
            return back()->with('error', 'Gagal membuat pembayaran. Silakan coba lagi.');
        }
    }

    public function edit($id)
    {
        $tagihan = Tagihan::findOrFail($id);
        $users = User::where('role', 'pelanggan')->get();

        return view('admin.tagihan.edit', compact('tagihan', 'users'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'user_id' => 'required',
            'periode' => 'required',
            'pemakaian' => 'required|numeric',
            'total' => 'required|numeric',
        ]);

        // Temukan tagihan yang akan diupdate
        $tagihan = Tagihan::findOrFail($id);

        // Update data tagihan
        $tagihan->user_id = $request->user_id;
        $tagihan->periode = $request->periode;
        $tagihan->pemakaian = $request->pemakaian;
        $tagihan->total = $request->total;
        $tagihan->save();

        // Redirect dengan pesan sukses
        return redirect()->route('admin.tagihan.index')->with('success', 'Tagihan berhasil diperbarui!');
    }

    public function delete($id)
    {
        try {
            // Cari pengguna berdasarkan UUID
            $tagihan = Tagihan::findOrFail($id);


            // Hapus pengguna
            $tagihan->delete();


            session()->flash('success', 'Tagihan berhasil dihapus.');

            // Redirect ke halaman pelanggan dengan pesan sukses
            return redirect()->route('admin.tagihan.index');
        } catch (\Exception $e) {
            // Set pesan error ke session
            session()->flash('error', 'Gagal menghapus tagihan. Silakan coba lagi.');

            // Redirect kembali ke halaman sebelumnya
            return redirect()->back();
        }
    }

    public function cariTagihan(Request $request)
    {
        // Mendapatkan nomor pelanggan dari request
        $noPelanggan = $request->input('no_pelanggan');

        // Query untuk mencari tagihan berdasarkan nomor pelanggan yang belum memiliki pembayaran
        $tagihans = Tagihan::whereHas('user.pelanggan', function ($query) use ($request) {
            if ($request->has('no_pelanggan')) {
                $query->where('no_pelanggan', 'like', '%' . $request->no_pelanggan . '%');
            }
        })->whereDoesntHave('pembayarans')->get();

        return view('admin.tagihan.cari-tagihan', compact('tagihans'));
    }


    // CONTROLLER PELANGGAN
    public function getTagihan()
    {
        // Mendapatkan ID user yang sedang diautorisasi
        $userId = auth()->user()->id;

        // Query untuk mencari tagihan yang belum memiliki pembayaran berdasarkan user ID
        $tagihans = Tagihan::whereDoesntHave('pembayarans')
            ->where('user_id', $userId)
            ->get();

        return view('pelanggan.tagihan.index', compact('tagihans'));
    }

}
