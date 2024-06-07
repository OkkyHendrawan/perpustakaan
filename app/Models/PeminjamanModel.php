<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeminjamanModel extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';

    protected $primaryKey = 'peminjaman_id';

    protected $fillable = [
        'peminjaman_anggota_id',
        'peminjaman_buku_id',
        'peminjaman_tgl',
        'peminjaman_tgl_pengembalian',
        'status',
        'peminjaman_denda',
        'created_by',
        'updated_by',
    ];

    protected $dates = [
        'peminjaman_tgl',
        'peminjaman_tgl_pengembalian',
    ];

    static public function getPeminjaman()
    {
        return self::select('peminjaman.*', 'anggota.anggota_nama', 'buku.buku_judul')
            ->join('anggota', 'peminjaman.peminjaman_anggota_id', '=', 'anggota.anggota_id')
            ->join('buku', 'peminjaman.peminjaman_buku_id', '=', 'buku.buku_id')
            ->where('peminjaman.is_delete', 0)
            ->orderBy('peminjaman.peminjaman_id', 'desc')
            ->paginate(5);
    }

    static public function softDeletePeminjaman($peminjaman_id)
    {
        // Temukan data fakultas berdasarkan ID
        $peminjaman = self::find($peminjaman_id);

        if ($peminjaman) {
            // Set is_delete menjadi 1 (deleted)
            $peminjaman->is_delete = 1;
            $peminjaman->save();
        }

        return $peminjaman;
    }

    public function anggota()
    {
        return $this->belongsTo(AnggotaModel::class, 'peminjaman_anggota_id', 'anggota_id');
    }

    public function buku()
    {
        return $this->belongsTo(BukuModel::class, 'peminjaman_buku_id', 'buku_id');
    }
}
