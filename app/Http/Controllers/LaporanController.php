<?php

namespace App\Http\Controllers;

use App\Models\BukuModel;
use App\Models\AnggotaModel;
use App\Models\PeminjamanModel;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;
use Dompdf\Options;

class LaporanController extends Controller
{
    // Menampilkan halaman laporan
    public function index()
    {
        return view('admin.laporan.list');
    }

    // Proses pencetakan laporan dalam format PDF atau Excel
    public function cetak(Request $request)
    {
        $jenis = $request->input('jenis');

        // Mengambil data berdasarkan jenis yang dipilih
        if ($jenis == 'anggota') {
            $data = AnggotaModel::where('is_delete', 0)->get();
        } elseif ($jenis == 'buku') {
            $data = BukuModel::where('is_delete', 0)->get();
        } elseif ($jenis == 'peminjaman') {
            $data = PeminjamanModel::where('is_delete', 0)->get();
        } else {
            $data = null;
        }

        // Menentukan format cetakan
        if ($request->has('format')) {
            $format = $request->input('format');

            if ($format == 'pdf') {
                return $this->cetakPdf($data, $jenis);
            } elseif ($format == 'excel') {
                return $this->cetakExcel($data, $jenis);
            }
        }

        return view('admin.laporan.list', compact('data', 'jenis'));
    }


    // Fungsi untuk mencetak laporan dalam format PDF
    private function cetakPdf($data, $jenis)
    {
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $options->set('isHtml5ParserEnabled', true); // Enable HTML5 parsing
        $dompdf = new Dompdf($options);

        // Render view untuk PDF
        $pdfView = view('admin.laporan.pdf', compact('data', 'jenis'));
        $html = $pdfView->render();

        // Load HTML ke Dompdf
        $dompdf->loadHtml($html);

        // Set ukuran dan orientasi kertas (opsional)
        $dompdf->setPaper('A4', 'landscape');

        // Render HTML menjadi PDF
        $dompdf->render();

        // Output PDF yang dihasilkan
        $output = $dompdf->output();

        // Simpan PDF ke lokasi tertentu (opsional)
        $pdfPath = public_path('Laporan.pdf');
        file_put_contents($pdfPath, $output);

        // Kembalikan path atau tampilkan PDF
        return $dompdf->stream('Laporan.pdf');
    }

    // Fungsi untuk mencetak laporan dalam format Excel
    private function cetakExcel($data, $jenis)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Tambahkan baris header
        if ($data->isNotEmpty()) {
            $header = array_keys((array)$data->first());
            $sheet->fromArray([$header], NULL, 'A1');

            // Tambahkan baris data
            $rowData = $data->toArray();
            $sheet->fromArray($rowData, NULL, 'A2');

            // Set autofilter untuk data
            $lastColumn = $sheet->getHighestDataColumn();
            $sheet->setAutoFilter('A1:' . $lastColumn . '1');
        } else {
            // Jika tidak ada data, set header saja
            $header = [];
            if ($jenis == 'anggota') {
                $header = ['ID', 'Kode Anggota', 'Nama', 'Alamat', 'Jenis', 'Tanggal Daftar', 'Tanggal Buat', 'Dibuat Oleh', 'Tanggal Update', 'Di Update Oleh'];
            } elseif ($jenis == 'buku') {
                $header = ['ID', 'Gambar', 'Kode Buku', 'Judul', 'Nama Pengarang', 'Tahun Terbit', 'ISBN', 'Status', 'Kondisi', 'Jumlah Halaman', 'Jumlah Buku', 'PDF', 'Tanggal Buat', 'Dibuat Oleh', 'Tanggal Update', 'Di Update Oleh'];
            } elseif ($jenis == 'peminjaman') {
                $header = ['ID', 'Anggota', 'Buku', 'Tanggal Pinjam', 'Tanggal Kembali', 'Status', 'Tanggal Buat', 'Dibuat Oleh', 'Tanggal Update', 'Di Update Oleh'];
            }

            $sheet->fromArray([$header], NULL, 'A1');
        }

        // Redirect output ke web browser client (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Laporan.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');

        exit;
    }
}
