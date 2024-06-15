<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Ramsey\Uuid\Uuid;
use RealRashid\SweetAlert\Facades\Alert;

class PelangganController extends Controller
{
    public function getPelanggan()
    {
        $pelanggans = DB::select('SELECT u.id, u.name, u.email,p.nama_pelanggan , p.no_pelanggan , p.alamat_pelanggan  FROM users u JOIN pelanggans p ON u.id = p.user_id;');

        return view('Admin.Pelanggan.Index', compact('pelanggans'));
    }


    public function getTambahPelanggan()
    {
        return view('Admin/Pelanggan/tambah-pelanggan');
    }

    public function tambahPelanggan(Request $request)
    {
        // Validasi input form pelanggan
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'nama_pelanggan' => 'required|string',
            'alamat_pelanggan' => 'required|string',
        ]);

        // Generate no_pelanggan berikutnya berdasarkan nomor terakhir
        $lastPelanggan = Pelanggan::orderBy('created_at', 'desc')->first();
        $lastNumber = $lastPelanggan ? intval(substr($lastPelanggan->no_pelanggan, 0, 3)) : 0;
        $nextNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        $no_pelanggan = $nextNumber . 'PLG';

        // Simpan data ke dalam tabel 'users' menggunakan Eloquent

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('name') . '123');
        $user->role = 'pelanggan';
        $user->save();

        $pelanggan = new Pelanggan();
        $pelanggan->user_id = $user->id;
        $pelanggan->nama_pelanggan = $request->input('nama_pelanggan');
        $pelanggan->no_pelanggan = $no_pelanggan;
        $pelanggan->alamat_pelanggan = $request->input('alamat_pelanggan');
        $pelanggan->save();

        // Redirect atau kembalikan response jika berhasil
        Alert::success('Sukses', 'Pelanggan baru berhasil ditambahkan.');

        // Redirect atau kembalikan response jika berhasil
        return Redirect::route('admin.pelanggan');
    }

    public function edit($id)
    {
        // Ambil data user dan pelanggan berdasarkan ID
        $user = User::findOrFail($id);
        $pelanggan = Pelanggan::where('user_id', $id)->firstOrFail();
        // Tampilkan view edit dengan data user dan pelanggan
        return view('Admin.Pelanggan.Edit', compact('user', 'pelanggan'));
    }


    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email,' . $id,
                'alamat_pelanggan' => 'required|string',
                'nama_pelanggan' => 'required|string',
            ]);

            $user = User::findOrFail($id);
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            if ($request->has('password')) {
                $user->password = Hash::make($request->input('password'));
            }
            $user->save();

            $pelanggan = Pelanggan::where('user_id', $id)->firstOrFail();
            $pelanggan->nama_pelanggan = $request->input('nama_pelanggan');
            $pelanggan->alamat_pelanggan = $request->input('alamat_pelanggan');
            $pelanggan->save();

            // Set pesan sukses ke session
            return redirect()->route('admin.pelanggan')->with('success', 'Data pelanggan berhasil diperbarui.');
        } catch (\Exception $e) {
            // Set pesan error ke session
            return redirect()->back()->with('error', 'Gagal memperbarui data pelanggan. Silakan coba lagi.');
        }
    }
    public function delete($id)
    {
        try {
            // Cari pengguna berdasarkan UUID
            $user = User::findOrFail($id);
            Pelanggan::where('user_id', $id)->delete();

            // Hapus pengguna
            $user->delete();

            // Set pesan sukses ke session
            session()->flash('success', 'Pelanggan berhasil dihapus.');

            // Redirect ke halaman pelanggan dengan pesan sukses
            return redirect()->route('admin.pelanggan');
        } catch (\Exception $e) {
            // Set pesan error ke session
            session()->flash('error', 'Gagal menghapus pelanggan. Silakan coba lagi.');

            // Redirect kembali ke halaman sebelumnya
            return redirect()->back();
        }
    }
}
