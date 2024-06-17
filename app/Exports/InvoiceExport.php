<?php

namespace App\Exports;

use App\Models\Tagihan;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;

use Dompdf\Dompdf;
use Dompdf\Options;

class InvoiceExport
{
    public function exportPDF($tagihan_id)
    {
        $userId = auth()->user()->id;

        // Query untuk mencari tagihan berdasarkan user ID dan tagihan ID
        $tagihan = Tagihan::with('pembayarans', 'user.pelanggan')
            ->where('user_id', $userId)
            ->where('id', $tagihan_id)
            ->first();

        if (!$tagihan) {
            return redirect()->back()->with('error', 'Invoice not found.');
        }

        $nama_hari = [
            0 => 'Minggu',
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
        ];

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

        if ($tagihan->pembayarans->isNotEmpty() && $tagihan->pembayarans->first()->status) {
            $waktu_pembayaran = $tagihan->pembayarans->first()->updated_at;
            $date = Carbon::parse($waktu_pembayaran)->setTimezone('Asia/Jakarta');
            $hari = $nama_hari[$date->dayOfWeek];
            $bulan = $nama_bulan[$date->month];
            $formatted_date = $hari . ', ' . $date->format('d') . ' ' . $bulan . ' ' . $date->format('Y, H:i');
            $tagihan->waktu_pembayaran = $formatted_date;
        } else {
            $tagihan->waktu_pembayaran = '-';
        }

        $nama_pelanggan = $tagihan->user->pelanggan->nama_pelanggan ?? '';

        $data = [
            'No' => 1,
            'Nama Pelanggan' => $nama_pelanggan,
            'No Pelanggan' => $tagihan->user->pelanggan->no_pelanggan ?? '',
            'Periode' => $tagihan->periode ?? '',
            'Pemakaian' => $tagihan->pemakaian ?? '',
            'Total' => $tagihan->total ?? '',
            'Status Pembayaran' => $tagihan->pembayarans->isEmpty() ? 'Belum Dibayar' : $tagihan->pembayarans->first()->status,
            'Waktu Pembayaran' => $tagihan->waktu_pembayaran,
        ];

        // Panggil fungsi untuk generate PDF
        $this->generateInvoice($data);
    }

    protected function generateInvoice($data)
    {
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $options->set('defaultFont', 'Arial');

        $dompdf = new Dompdf($options);
        $html = view('exports.invoice', compact('data'))->render();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->stream('invoice.pdf', ['Attachment' => true]);
    }
}
