<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Tagihan;
use App\Models\Pembayaran;
use Carbon\Carbon;
use Illuminate\Http\Request;


class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $totalPelanggan = Pelanggan::count();

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $tagihanQuery = Tagihan::query();

        if ($startDate && $endDate) {
            $tagihanQuery->whereBetween('periode', [$startDate, $endDate]);
        } elseif ($startDate) {
            $tagihanQuery->where('periode', '>=', $startDate);
        } elseif ($endDate) {
            $tagihanQuery->where('periode', '<=', $endDate);
        }

        $totalUangMasuk = $tagihanQuery->whereHas('pembayarans', function ($query) {
            $query->where('status', '=', 'success');
        })
            ->sum('total');

        $tagihanSudahDibayar = $tagihanQuery->whereHas('pembayarans', function ($query) {
            $query->where('status', '!=', 'pending');
        })
            ->count();

        $tagihanBelumDibayar = $tagihanQuery->where(function ($query) {
            $query->whereDoesntHave('pembayarans')
                ->orWhereHas('pembayarans', function ($query) {
                    $query->where('status', 'pending');
                });
        })
            ->orWhereDoesntHave('pembayarans') // Menambahkan pengecualian untuk tagihan tanpa pembayaran sama sekali
            ->count();


        return view('Admin/Dashboard/index', compact('totalPelanggan', 'tagihanBelumDibayar', 'tagihanSudahDibayar', 'totalUangMasuk'));
    }
}
