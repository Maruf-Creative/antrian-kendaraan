<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use App\Models\Kendaraan;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function index()
    {
        return view('laporan.index');
    }

    public function cetakKendaraan()
    {
        $kendaraans = Kendaraan::where('user_id', Auth::id())->get();

        $pdf = new \FPDF('P', 'mm', 'A4');
        $pdf->AddPage();
        $pdf->SetMargins(15, 15, 15);

        // Header / Title
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'LAPORAN DATA KENDARAAN', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 6, 'Sistem Informasi Antrian Kendaraan', 0, 1, 'C');
        $pdf->Ln(4);

        // Table Header
        $pdf->SetFillColor(30, 41, 59);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(12, 8, 'No', 1, 0, 'C', true);
        $pdf->Cell(45, 8, 'Nomor Polisi', 1, 0, 'C', true);
        $pdf->Cell(45, 8, 'Jenis Kendaraan', 1, 0, 'C', true);
        $pdf->Cell(78, 8, 'Nama Pemilik', 1, 1, 'C', true);

        // Table Rows
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 10);
        $no = 1;

        if ($kendaraans->isEmpty()) {
            $pdf->Cell(180, 8, 'Belum ada data kendaraan.', 1, 1, 'C');
        } else {
            foreach ($kendaraans as $k) {
                $pdf->Cell(12, 8, $no++, 1, 0, 'C');
                $pdf->Cell(45, 8, ' ' . $k->nomor_polisi, 1, 0, 'L');
                $pdf->Cell(45, 8, ' ' . $k->jenis_kendaraan, 1, 0, 'L');
                $pdf->Cell(78, 8, ' ' . $k->nama_pemilik, 1, 1, 'L');
            }
        }

        $pdf->Ln(6);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 7, 'Jumlah Total Kendaraan: ' . $kendaraans->count(), 0, 1, 'L');
        $pdf->SetFont('Arial', 'I', 9);
        $pdf->Cell(0, 6, 'Tanggal Cetak: ' . date('d/m/Y H:i:s'), 0, 1, 'L');

        return response($pdf->Output('S'), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="laporan_kendaraan.pdf"',
        ]);
    }

    public function cetakAntrian()
    {
        $kendaraanIds = Kendaraan::where('user_id', Auth::id())->pluck('id');
        $antrians = Antrian::whereIn('kendaraan_id', $kendaraanIds)->with('kendaraan')->get();

        $pdf = new \FPDF('L', 'mm', 'A4');
        $pdf->AddPage();
        $pdf->SetMargins(15, 15, 15);

        // Header / Title
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'LAPORAN DATA ANTRIAN KENDARAAN', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 6, 'Sistem Informasi Antrian Kendaraan', 0, 1, 'C');
        $pdf->Ln(4);

        // Table Header
        $pdf->SetFillColor(30, 41, 59);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(12, 8, 'No', 1, 0, 'C', true);
        $pdf->Cell(35, 8, 'No. Antrian', 1, 0, 'C', true);
        $pdf->Cell(45, 8, 'Nomor Polisi', 1, 0, 'C', true);
        $pdf->Cell(65, 8, 'Nama Pemilik', 1, 0, 'C', true);
        $pdf->Cell(35, 8, 'Tanggal', 1, 0, 'C', true);
        $pdf->Cell(35, 8, 'Waktu', 1, 0, 'C', true);
        $pdf->Cell(40, 8, 'Status', 1, 1, 'C', true);

        // Table Rows
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 10);
        $no = 1;

        if ($antrians->isEmpty()) {
            $pdf->Cell(267, 8, 'Belum ada data antrian.', 1, 1, 'C');
        } else {
            foreach ($antrians as $a) {
                $pdf->Cell(12, 8, $no++, 1, 0, 'C');
                $pdf->Cell(35, 8, $a->nomor_antrian, 1, 0, 'C');
                $pdf->Cell(45, 8, ' ' . ($a->kendaraan ? $a->kendaraan->nomor_polisi : '-'), 1, 0, 'L');
                $pdf->Cell(65, 8, ' ' . ($a->kendaraan ? $a->kendaraan->nama_pemilik : '-'), 1, 0, 'L');
                $pdf->Cell(35, 8, date('d/m/Y', strtotime($a->tanggal)), 1, 0, 'C');
                $pdf->Cell(35, 8, date('H:i', strtotime($a->waktu)), 1, 0, 'C');
                $pdf->Cell(40, 8, $a->status, 1, 1, 'C');
            }
        }

        $pdf->Ln(6);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 7, 'Jumlah Total Antrian: ' . $antrians->count(), 0, 1, 'L');
        $pdf->SetFont('Arial', 'I', 9);
        $pdf->Cell(0, 6, 'Tanggal Cetak: ' . date('d/m/Y H:i:s'), 0, 1, 'L');

        return response($pdf->Output('S'), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="laporan_antrian.pdf"',
        ]);
    }
}
