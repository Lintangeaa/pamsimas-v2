<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PelangganController extends Controller
{
    public function getPelanggan()
    {
        $pelanggan = DB::select('select u.id, u.name, u.email, p.nama_pelanggan , p.no_pelanggan , p.alamat_pelanggan from users u join pelanggans p on u.id = p.user_id order by u.created_at desc;');

        return $pelanggan;
    }

    public function index()
    {
        // Mendapatkan data pelanggan dari fungsi getPelanggan
        $pelanggan = $this->getPelanggan();

        // Merender view 'nama_view_pelanggan' dengan menyertakan data pelanggan
        return view('Admin/Pelanggan/Index', ['pelanggans' => $pelanggan]);
    }
}
