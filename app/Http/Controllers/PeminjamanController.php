<?php

namespace App\Http\Controllers;

use App\Models\BukuModel;

use App\Models\AnggotaModel;
use Illuminate\Http\Request;
use App\Models\PeminjamanModel;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    // Menampilkan daftar peminjaman
    public function index()
    {
        $peminjaman = PeminjamanModel::getPeminjaman();
        return view('admin.peminjaman.list', compact('peminjaman'));
    }

    // Menampilkan form untuk menambahkan peminjaman baru
    public function form_create()
    {
        $anggota = AnggotaModel::where('is_delete', 0)->get();
        $buku = BukuModel::where('is_delete', 0)->get();
        return view('admin.peminjaman.add', compact('anggota', 'buku',));
    }

    // Proses penambahan peminjaman baru
    public function proses_create(Request $request)
    {
        // Validasi data yang diterima dari form
        $request->validate([
            'anggota_id' => 'required',
            'buku_id' => 'required',
            'tgl_peminjaman' => 'required|date',
            'tgl_pengembalian' => 'required|date',
            'status' => 'required|in:Dipinjam,Kembali',
            'denda' => 'nullable|int',
        ]);

        $peminjaman = new PeminjamanModel;
        $peminjaman->peminjaman_anggota_id = $request->anggota_id;
        $peminjaman->peminjaman_buku_id = $request->buku_id;
        $peminjaman->peminjaman_tgl = $request->tgl_peminjaman;
        $peminjaman->peminjaman_tgl_pengembalian = $request->tgl_pengembalian;
        $peminjaman->status = $request->status;
        $peminjaman->peminjaman_denda = $request->denda;
        $peminjaman->created_by = Auth::user()->name;
        $peminjaman->is_delete = 0;

        // Set waktu saat ini sebagai waktu Indonesia Barat (WIB)
        $currentDateTime = now('Asia/Jakarta');
        $peminjaman->created_at = $currentDateTime;
        $peminjaman->updated_at = $currentDateTime;

        $peminjaman->save();

        // Redirect ke halaman daftar peminjaman dengan pesan sukses
        return redirect()->route('admin.peminjaman.list')->with('success', 'Peminjaman berhasil ditambahkan.');
    }

    // Menampilkan form untuk mengedit peminjaman
    public function edit($peminjaman_id)
    {
        $peminjaman = PeminjamanModel::findOrFail($peminjaman_id);
        $data['daftarBuku'] = BukuModel::daftarBuku();
        $data['daftarAnggota'] = AnggotaModel::daftarAnggota();
        return view('admin.peminjaman.edit', compact('peminjaman'), $data);
    }

     // Proses update data peminjaman
    public function update(Request $request, $peminjaman_id)
    {
        // Validasi data yang diterima dari form
        $request->validate([
            'peminjaman_anggota_id' => 'required',
            'peminjaman_buku_id' => 'required',
            'peminjaman_tgl' => 'required|date',
            'peminjaman_tgl_pengembalian' => 'required|date',
            'status' => 'required|in:Dipinjam,Kembali',
            'peminjaman_denda' => 'nullable|int',
        ]);

        $peminjaman = PeminjamanModel::findOrFail($peminjaman_id);
        $peminjaman->update($request->all());
        $peminjaman->updated_by = Auth::user()->name;

        // Set waktu saat ini sebagai waktu Indonesia Barat (WIB)
        $currentDateTime = now('Asia/Jakarta');
        $peminjaman->updated_at = $currentDateTime;
        $peminjaman->save();

        // Redirect ke halaman daftar peminjaman dengan pesan sukses
        return redirect()->route('admin.peminjaman.list')->with('success', 'Peminjaman berhasil diperbarui.');
    }

    // Menghapus peminjaman secara lembut yang artinya cuma di tabel saja tidak di database
    public function softDeletePeminjaman($peminjaman_id)
        {
            // Panggil metode softDeletePeminjaman dari model PeminjamanModel
            $peminjaman = PeminjamanModel::softDeletePeminjaman($peminjaman_id);

            if ($peminjaman) {
                // Jika peminjaman berhasil dihapus secara lembut, lakukan tindakan sesuai kebutuhan
                return redirect()->back()->with('success', 'Peminjaman berhasil di hapus .');
            } else {
                // Jika peminjaman tidak ditemukan, tampilkan pesan kesalahan
                return redirect()->back()->with('error', 'Peminjaman tidak ditemukan.');
            }
        }

        // Mencari peminjaman berdasarkan kriteria tertentu
        public function search(Request $request)
        {
            $peminjaman_anggota_id = $request->input('peminjaman_anggota_id');
            $peminjaman_buku_id = $request->input('peminjaman_buku_id');

            $peminjaman = PeminjamanModel::select('peminjaman.*')
                ->leftJoin('anggota', 'peminjaman.peminjaman_anggota_id', '=', 'anggota.anggota_id')
                ->leftJoin('buku', 'peminjaman.peminjaman_buku_id', '=', 'buku.buku_id')
                ->where('peminjaman.is_delete', 0) // Filter Tabel Peminjaman yang belum dihapus
                ->where(function($query) use ($peminjaman_anggota_id, $peminjaman_buku_id) {
                    if ($peminjaman_anggota_id) {
                        $query->where('anggota.anggota_nama', 'LIKE', '%' . $peminjaman_anggota_id . '%');
                    }
                    if ($peminjaman_buku_id) {
                        $query->where('buku.buku_judul', 'LIKE', '%' . $peminjaman_buku_id . '%');
                    }
                })
                ->paginate(5);

            return view('admin.peminjaman.list', compact('peminjaman'));
        }

}
