<?php

namespace App\Exports;

use App\Models\Tagihan;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Dompdf\Dompdf;
use Dompdf\Options;

class LaporanExport implements FromCollection, WithHeadings
{
    protected $laporans;

    public function __construct(Collection $laporans)
    {
        $this->laporans = $laporans;
    }

    public function collection()
    {
        return $this->laporans->map(function ($tagihan, $index) {
            return [
                'No' => $index + 1,
                'Nama Pelanggan' => $tagihan->user->pelanggan->nama_pelanggan ?? '',
                'No Pelanggan' => $tagihan->user->pelanggan->no_pelanggan ?? '',
                'Periode' => $tagihan->periode ?? '',
                'Pemakaian' => $tagihan->pemakaian ?? '',
                'Total' => $tagihan->total ?? '',
                'Status Pembayaran' => $tagihan->pembayarans->isEmpty() ? 'Belum Dibayar' : $tagihan->pembayarans->first()->status,
                'Waktu Pembayaran' => $tagihan->waktu_pembayaran ?? '',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Pelanggan',
            'No Pelanggan',
            'Periode',
            'Pemakaian',
            'Total',
            'Status Pembayaran',
            'Waktu Pembayaran',
        ];
    }

    public function exportPDF()
    {
        $data = $this->laporans;

        return $this->generatePDF($data);
    }

    protected function generatePDF($data)
    {
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $options->set('defaultFont', 'Arial');

        $dompdf = new Dompdf($options);
        $html = view('exports/Laporan/pdf', compact('data'))->render();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        return $dompdf->stream('laporan.pdf', ['Attachment' => true]);
    }
}
