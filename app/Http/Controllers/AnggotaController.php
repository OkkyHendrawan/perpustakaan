<?php

namespace App\Http\Controllers;

use App\Models\AnggotaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnggotaController extends Controller
{
    // Menampilkan daftar anggota
    public function index()
    {
        $anggota = AnggotaModel::getAnggota();
        return view('admin.anggota.list', compact('anggota'));
    }

    // Menampilkan form untuk menambahkan anggota baru
    public function form_create()
    {
        return view('admin.anggota.add');
    }

    // Proses penambahan anggota baru
    public function proses_create(Request $request)
    {
        // Validasi data yang diterima dari form
        $request->validate([
            'anggota_kode' => 'required',
            'anggota_nama' => 'required|string|max:100',
            'anggota_alamat' => 'nullable|string|max:255',
            'anggota_jenis' => 'nullable|in:Aktif,Tidak Aktif',
            'anggota_tgl_daftar' => 'nullable|date',
        ]);

            // Simpan data anggota baru ke dalam database
            $anggota = new AnggotaModel;
            $anggota->anggota_kode = $request->anggota_kode;
            $anggota->anggota_nama = $request->anggota_nama;
            $anggota->anggota_alamat = $request->anggota_alamat;
            $anggota->anggota_jenis = $request->anggota_jenis;
            $anggota->anggota_tgl_daftar = $request->anggota_tgl_daftar;
            $anggota->is_delete = 0;
            $anggota->created_by = Auth::user()->name;

            // Set waktu saat ini sebagai waktu Indonesia Barat (WIB)
            $currentDateTime = now('Asia/Jakarta');
            $anggota->created_at = $currentDateTime;

            $anggota->save();

        // Redirect ke halaman daftar anggota dengan pesan sukses
        return redirect()->route('admin.anggota.list')->with('success', 'Anggota berhasil ditambahkan.');
    }

     // Menampilkan form untuk mengedit anggota
    public function edit($anggota_id)
    {
        $anggota = AnggotaModel::findOrFail($anggota_id);
        return view('admin.anggota.edit', compact('anggota'));
    }

     // Proses update data anggota
    public function update(Request $request, $anggota_id)
    {
        // Validasi data yang diterima dari form
        $request->validate([
            'anggota_kode' => 'required',
            'anggota_nama' => 'required|string|max:100',
            'anggota_alamat' => 'nullable|string|max:255',
            'anggota_jenis' => 'nullable|in:Aktif,Tidak Aktif',
            'anggota_tgl_daftar' => 'nullable|date',
        ]);

            // Temukan data anggota yang akan diupdate
            $anggota = AnggotaModel::findOrFail($anggota_id);

            // Update data anggota dengan data baru
            $anggota->update($request->all());
            $anggota->updated_by = Auth::user()->name;

            // Set waktu saat ini sebagai waktu Indonesia Barat (WIB)
            $currentDateTime = now('Asia/Jakarta');
            $anggota->updated_at = $currentDateTime;
            $anggota->save();

            // Redirect ke halaman daftar anggota dengan pesan sukses
            return redirect()->route('admin.anggota.list')->with('success', 'Anggota Berhasil di Perbarui.');
    }

    // Menghapus anggota secara lembut yang artinya cuma di tabel saja tidak di database
    public function softDeleteAnggota($anggota_id)
        {
            // Panggil metode softDeleteAnggota dari model AnggotaModel
            $anggota = AnggotaModel::softDeleteAnggota($anggota_id);

            if ($anggota) {
                 // Jika anggota berhasil dihapus secara lembut, lakukan tindakan sesuai kebutuhan
                return redirect()->back()->with('success', 'Anggota berhasil di hapus .');
            } else {
                // Jika anggota tidak ditemukan, tampilkan pesan kesalahan
                return redirect()->back()->with('error', 'Anggota tidak ditemukan.');
            }
        }

        // Mencari anggota berdasarkan kriteria tertentu
        public function search(Request $request)
        {
            $query = AnggotaModel::query()->where('is_delete', 0); // Filter Tabel Anggota yang belum dihapus

            // Filter berdasarkan nama Anggota
            if ($request->has('anggota_nama')) {
                $query->where('anggota_nama', 'like', '%' . $request->anggota_nama . '%');
            }

            // Filter berdasarkan Status Aktif atau Tidak Aktif
            if ($request->has('anggota_jenis')) {
                $query->where('anggota_jenis', 'like', '%' . $request->anggota_jenis . '%');
            }

            // mengambil data Anggota yang telah difilter dan mengunakan paginasi
            $anggota = $query->paginate(5); // Menggunakan paginate dengan jumlah per halaman 5

            // Kembalikan view bersama dengan data Anggota
            return view('admin.anggota.list', compact('anggota'));
        }
}
