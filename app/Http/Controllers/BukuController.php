<?php

namespace App\Http\Controllers;

use App\Models\BukuModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BukuController extends Controller
{
    // Menampilkan daftar buku
    public function index()
    {
        $buku = BukuModel::getBuku();
        return view('admin.buku.list', compact('buku'));
    }

    // Menampilkan form untuk menambahkan buku baru
    public function form_create()
    {
        return view('admin.buku.add');
    }

    // Proses penambahan buku baru
    public function proses_create(Request $request)
    {
        // Validasi data yang diterima dari form
        $request->validate([
            'buku_kode' => 'required',
            'buku_judul' => 'required|string|max:255',
            'buku_nama_pengarang' => 'nullable|string|max:100',
            'tahun_terbit' => 'nullable|date_format:Y',
            'buku_isbn' => 'nullable|string|max:20',
            'buku_status' => 'nullable|in:Tersedia,Dipinjam',
            'buku_kondisi' => 'nullable|in:Baik,Rusak',
            'buku_jumlah_halaman' => 'nullable|integer',
            'buku_jumlah_buku' => 'nullable|integer',
        ]);

        $buku = new BukuModel($request->all());

        // Simpan file foto ke folder public/buku-gambar
        if ($request->hasFile('buku_gambar')) {
            $photo = $request->file('buku_gambar');
            $photoName = time() . '_' . $photo->getClientOriginalName();
            $photo->move(public_path('buku-gambar'), $photoName); // Pindahkan file ke folder public/buku-gambar
            $buku->buku_gambar = $photoName; // Simpan nama file foto ke database
        }

        // Simpan file PDF ke folder public/buku-pdf
        if ($request->hasFile('buku_pdf')) {
            $pdf = $request->file('buku_pdf');
            $pdfName = time() . '_' . $pdf->getClientOriginalName();
            $pdf->move(public_path('buku-pdf'), $pdfName); // Pindahkan file ke folder public/buku-pdf
            $buku->buku_pdf = $pdfName; // Simpan nama file PDF ke database
        }

            $buku->created_by = Auth::user()->name;
            $buku->is_delete = 0;

            // Set waktu saat ini sebagai waktu Indonesia Barat (WIB)
            $currentDateTime = now('Asia/Jakarta');
            $buku->created_at = $currentDateTime;
            $buku->updated_at = $currentDateTime;

            $buku->save();

        // Redirect ke halaman daftar buku dengan pesan sukses
        return redirect()->route('admin.buku.list')->with('success', 'Buku berhasil ditambahkan.');
    }

    // Menampilkan form untuk mengedit buku
    public function edit($buku_id)
        {
            $buku = BukuModel::findOrFail($buku_id);
            return view('admin.buku.edit', compact('buku'));
        }

    // Proses update data buku
    public function update(Request $request, $buku_id)
        {

        // Validasi data yang diterima dari form
        $request->validate([
            'buku_kode' => 'required',
            'buku_judul' => 'required|string|max:255',
            'buku_nama_pengarang' => 'nullable|string|max:100',
            'tahun_terbit' => 'nullable|date_format:Y',
            'buku_isbn' => 'nullable|string|max:20',
            'buku_status' => 'nullable|in:Tersedia,Dipinjam',
            'buku_kondisi' => 'nullable|in:Baik,Rusak',
            'buku_jumlah_halaman' => 'nullable|integer',
            'buku_jumlah_buku' => 'nullable|integer',
        ]);

            $buku = BukuModel::findOrFail($buku_id);
            $buku->fill($request->all());
            $buku->updated_by = Auth::user()->name;

        // Proses gambar
        if ($request->hasFile('buku_gambar')) {
            $gambar = $request->file('buku_gambar');
            $gambarName = time() . '_' . $gambar->getClientOriginalName();
            $gambar->move(public_path('buku-gambar'), $gambarName); // Simpan gambar ke folder public/buku-gambar
            $buku->buku_gambar = $gambarName; // Simpan nama gambar ke database
        }

        // Proses PDF
        if ($request->hasFile('buku_pdf')) {
            $pdf = $request->file('buku_pdf');
            $pdfName = time() . '_' . $pdf->getClientOriginalName();
            $pdf->move(public_path('buku-pdf'), $pdfName); // Simpan PDF ke folder public/buku-pdf
            $buku->buku_pdf = $pdfName; // Simpan nama PDF ke database
        }


            // Set waktu saat ini sebagai waktu Indonesia Barat (WIB)
            $currentDateTime = now('Asia/Jakarta');
            $buku->updated_at = $currentDateTime;

            $buku->save();

            // Redirect ke halaman daftar buku dengan pesan sukses
            return redirect()->route('admin.buku.list')->with('success', 'Buku Berhasil di Perbarui.');
    }

    // Menghapus buku secara lembut yang artinya cuma di tabel saja tidak di database
    public function softDeleteBuku($buku_id)
        {
            // Panggil metode softDeleteBuku dari model BukuModel
            $buku = BukuModel::softDeleteBuku($buku_id);

            if ($buku) {
                 // Jika buku berhasil dihapus secara lembut, lakukan tindakan sesuai kebutuhan
                return redirect()->back()->with('success', 'Buku berhasil di hapus .');
            } else {
                // Jika buku tidak ditemukan, tampilkan pesan kesalahan
                return redirect()->back()->with('error', 'Buku tidak ditemukan.');
            }
        }

    // Mencari anggota berdasarkan kriteria tertentu
    public function search(Request $request)
        {
            $query = BukuModel::query()->where('is_delete', 0); // Filter Tabel Buku yang belum dihapus

            // Filter berdasarkan nama buku
            if ($request->has('buku_judul')) {
                $query->where('buku_judul', 'like', '%' . $request->buku_judul . '%');
            }

             // Filter berdasarkan nama pengarang
            if ($request->has('buku_nama_pengarang')) {
                $query->where('buku_nama_pengarang', 'like', '%' . $request->buku_nama_pengarang . '%');
            }

            // mengambil data buku yang telah difilter dan mengunakan paginasi
            $buku = $query->paginate(5); // Menggunakan paginate dengan jumlah per halaman 5

            // Kembalikan view bersama dengan data Anggota
            return view('admin.buku.list', compact('buku'));
        }
}
