<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Tagihan;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPelanggan = Pelanggan::count();

        // Mengambil data tagihan yang belum dibayar
        $tagihanBelumDibayar = Tagihan::whereDoesntHave('pembayarans')->count();

        // Menghitung total uang masuk dari pembayaran yang sukses (status == 'success')
        $totalUangMasuk = Pembayaran::where('status', 'success')->sum('total_pembayaran');

        return view('Admin/Dashboard/index', compact('totalPelanggan', 'tagihanBelumDibayar', 'totalUangMasuk'));
    }
}
