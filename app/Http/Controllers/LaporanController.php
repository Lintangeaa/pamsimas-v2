<?php

namespace App\Http\Controllers;

use App\Exports\LaporanExport;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Exports\TagihanExport;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function index()
    {
        $laporans = Tagihan::with('pembayarans')->get();

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

        foreach ($laporans as $tagihan) {
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

        return view('admin.laporan.index', compact('laporans'));
    }

    public function exportExcel()
    {
        return Excel::download(new LaporanExport, 'laporan.xlsx');
    }

    public function exportPdf()
    {
        $export = new LaporanExport();
        $export->exportPDF();
    }

}
