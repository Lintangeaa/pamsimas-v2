<?php

namespace App\Exports;

use App\Models\Tagihan;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\View;
use Dompdf\Dompdf;
use Dompdf\Options;

class InvoiceExport
{
  public function exportInvoice($tagihan_id)
  {
    // Ambil data tagihan dari database
    $tagihan = Tagihan::findOrFail($tagihan_id);

    // Siapkan data untuk template
    $data = [
      'No' => $tagihan->id,
      'Nama Pelanggan' => $tagihan->user->pelanggan->nama_pelanggan ?? '',
      'No Pelanggan' => $tagihan->user->pelanggan->no_pelanggan ?? '',
      'Periode' => $tagihan->periode,
      'Pemakaian' => $tagihan->pemakaian,
      'Total' => $tagihan->total,
      'Status Pembayaran' => $tagihan->pembayarans->isEmpty() ? 'Belum Dibayar' : $tagihan->pembayarans->first()->status,
      'Waktu Pembayaran' => $tagihan->pembayarans->isEmpty() ? '-' : $this->formatWaktuPembayaran($tagihan->pembayarans->first()->updated_at),
    ];

    // Render template HTML invoice
    return $this->generatePDF($data);
  }

  protected function formatWaktuPembayaran($waktu_pembayaran)
  {

    $date = Carbon::parse($waktu_pembayaran)->setTimezone('Asia/Jakarta');

    $nama_hari = [
      0 => 'Senin',
      1 => 'Selasa',
      2 => 'Rabu',
      3 => 'Kamis',
      4 => 'Jumat',
      5 => 'Sabtu',
      6 => 'Minggu',
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

    $formatted_date = $nama_hari[$date->dayOfWeek - 1] . ', ' . $date->day . ' ' . $nama_bulan[$date->month] . ' ' . $date->year . ', ' . $date->format('H:i');

    return $formatted_date;

  }


  protected function generatePDF($data)
  {
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isPhpEnabled', true);
    $options->set('defaultFont', 'Arial');

    $dompdf = new Dompdf($options);
    $html = view('exports/invoice', compact('data'))->render();

    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();

    return $dompdf->stream('invoice.pdf', ['Attachment' => true]);
  }
}
