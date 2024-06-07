<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnggotaModel extends Model
{
    use HasFactory;

    protected $table = 'anggota';
    protected $primaryKey = 'anggota_id';

    protected $fillable = [
        'anggota_kode', 'anggota_nama', 'anggota_alamat', 'anggota_jenis',
        'anggota_tgl_daftar'
    ];

    static public function getAnggota()
    {
        return self::select('anggota.*')
            ->where('anggota.is_delete', 0)
            ->orderBy('anggota_id', 'desc') // Mengubah 'anggota' menjadi 'anggota_id'
            ->paginate(5);
    }


    static public function softDeleteAnggota($anggota_id)
    {
        // Temukan data fakultas berdasarkan ID
        $anggota = self::find($anggota_id);

        if ($anggota) {
            // Set is_delete menjadi 1 (deleted)
            $anggota->is_delete = 1;
            $anggota->save();
        }

        return $anggota;
    }

    public static function daftarAnggota()
        {
            return self::where('is_delete', 0)->orderBy('anggota_nama', 'asc')->get();
        }

}
