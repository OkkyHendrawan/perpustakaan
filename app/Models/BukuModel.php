<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BukuModel extends Model
{
    use HasFactory;

    protected $table = 'buku';
    protected $primaryKey = 'buku_id';

    protected $fillable = [
        'buku_kode',
        'buku_judul',
        'buku_nama_pengarang',
        'tahun_terbit',
        'buku_isbn',
        'buku_status',
        'buku_kondisi',
        'buku_jumlah_halaman',
        'buku_jumlah_buku',
        'buku_gambar',
        'buku_pdf',
    ];

    static public function getBuku()
    {
        return self::select('buku.*')
            ->where('buku.is_delete', 0)
            ->orderBy('buku_id', 'desc') // Mengubah 'buku' menjadi 'buku_id'
            ->paginate(5);
    }

    static public function softDeleteBuku($buku_id)
    {
        // Temukan data fakultas berdasarkan ID
        $buku = self::find($buku_id);

        if ($buku) {
            // Set is_delete menjadi 1 (deleted)
            $buku->is_delete = 1;
            $buku->save();
        }

        return $buku;
    }

    public static function daftarBuku()
        {
            return self::where('is_delete', 0)->orderBy('buku_judul', 'asc')->get();
        }
}
