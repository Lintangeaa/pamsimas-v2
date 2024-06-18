<?php

namespace App\Http\Controllers;

use App\Exports\LaporanExport;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = Tagihan::with('pembayarans');

        if ($startDate) {
            $startDate = Carbon::parse($startDate)->format('Y-m');
            $query->where('periode', '>=', $startDate);
        }

        if ($endDate) {
            $endDate = Carbon::parse($endDate)->format('Y-m');
            $query->where('periode', '<=', $endDate);
        }

        $laporans = $query->get();

        // Format waktu pembayaran dan tambahkan ke $laporans
        $laporans = $laporans->map(function ($tagihan) {
            if ($tagihan->pembayarans->isNotEmpty() && $tagihan->pembayarans->first()->status) {
                $waktu_pembayaran = $tagihan->pembayarans->first()->updated_at;
                $date = Carbon::parse($waktu_pembayaran)->setTimezone('Asia/Jakarta');
                $formatted_date = $date->isoFormat('dddd, D MMMM YYYY, HH:mm');
                $tagihan->waktu_pembayaran = $formatted_date;
            } else {
                $tagihan->waktu_pembayaran = '-';
            }
            return $tagihan;
        });

        return view('Admin/laporan/index', compact('laporans', 'startDate', 'endDate'));
    }

    public function exportExcel(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = Tagihan::with('pembayarans');

        if ($startDate) {
            $startDate = Carbon::parse($startDate)->format('Y-m');
            $query->where('periode', '>=', $startDate);
        }

        if ($endDate) {
            $endDate = Carbon::parse($endDate)->format('Y-m');
            $query->where('periode', '<=', $endDate);
        }

        $laporans = $query->get();

        // Export ke Excel
        return Excel::download(new LaporanExport($laporans), 'laporan.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = Tagihan::with('pembayarans');

        if ($startDate) {
            $startDate = Carbon::parse($startDate)->format('Y-m');
            $query->where('periode', '>=', $startDate);
        }

        if ($endDate) {
            $endDate = Carbon::parse($endDate)->format('Y-m');
            $query->where('periode', '<=', $endDate);
        }

        $laporans = $query->get();

        // Format waktu pembayaran dan tambahkan ke $laporans
        $laporans = $laporans->map(function ($tagihan) {
            if ($tagihan->pembayarans->isNotEmpty() && $tagihan->pembayarans->first()->status) {
                $waktu_pembayaran = $tagihan->pembayarans->first()->updated_at;
                $date = Carbon::parse($waktu_pembayaran)->setTimezone('Asia/Jakarta');
                $formatted_date = $date->isoFormat('dddd, D MMMM YYYY, HH:mm');
                $tagihan->waktu_pembayaran = $formatted_date;
            } else {
                $tagihan->waktu_pembayaran = '-';
            }
            return $tagihan;
        });

        // Export ke PDF
        $export = new LaporanExport($laporans);
        return $export->exportPDF();
    }
}
