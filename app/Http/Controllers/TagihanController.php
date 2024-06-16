<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Tagihan;

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

        // Simpan data ke database
        Tagihan::create([
            'user_id' => $request->user_id,
            'periode' => $request->periode,
            'pemakaian' => $request->pemakaian,
            'total' => $request->total,
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('admin.tagihan.index')->with('success', 'Tagihan berhasil ditambahkan!');
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
}
