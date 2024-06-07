<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px; /* Sesuaikan dengan ukuran yang Anda inginkan */
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Laporan Data {{ $jenis == 'anggota' ? 'Anggota' : ($jenis == 'buku' ? 'Buku' : 'Peminjaman') }}</h2>
    <table>
        <thead>
            <tr>
                @if($jenis == 'anggota')
                <th>#</th>
                <th>Kode Anggota</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Jenis</th>
                <th>Tanggal Daftar</th>
                <th>Tanggal Buat</th>
                <th>Dibuat Oleh</th>
                <th>Tanggal Update</th>
                <th>Di Update Oleh</th>
                @elseif($jenis == 'buku')
                <th>#</th>
                <th>Gambar</th>
                <th>Kode Buku</th>
                <th>Judul</th>
                <th>Nama Pengarang</th>
                <th>Tahun Terbit</th>
                <th>ISBN</th>
                <th>Status</th>
                <th>Kondisi</th>
                <th>Jumlah Halaman</th>
                <th>Jumlah Buku</th>
                <th>PDF</th>
                <th>Tanggal Buat</th>
                <th>Dibuat Oleh</th>
                <th>Tanggal Update</th>
                <th>Di Update Oleh</th>
                @elseif($jenis == 'peminjaman')
                <th>#</th>
                <th>Anggota</th>
                <th>Buku</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
                <th>Tanggal Buat</th>
                <th>Dibuat Oleh</th>
                <th>Tanggal Update</th>
                <th>Di Update Oleh</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @if($data)
            @foreach($data as $value)
            <tr>
                @if($jenis == 'anggota')
                <td>{{ $value->anggota_id }}</td>
                <td>{{ $value->anggota_kode }}</td>
                <td>{{ $value->anggota_nama }}</td>
                <td>{{ $value->anggota_alamat }}</td>
                <td>{{ $value->anggota_jenis }}</td>
                <td>{{ $value->anggota_tgl_daftar }}</td>
                <td>{{ $value->created_at }}</td>
                <td>{{ $value->created_by }}</td>
                <td>{{ $value->updated_at }}</td>
                <td>{{ $value->updated_by }}</td>

                @elseif($jenis == 'buku')
                <td>{{ $value->buku_id }}</td>
                <td class="text-center">
                    @if($value->buku_gambar && file_exists(public_path('buku-gambar/'.$value->buku_gambar)))
                        <div style="width: 80px; height: 80px; border: 1px solid #ccc; overflow: hidden; margin: auto;">
                            <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents(public_path('buku-gambar/'.$value->buku_gambar))) }}" alt="Gambar Buku" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                    @else
                        <p>Tidak Ada Gambar</p>
                    @endif
                </td>
                <td>{{ $value->buku_kode }}</td>
                <td>{{ $value->buku_judul }}</td>
                <td>{{ $value->buku_nama_pengarang }}</td>
                <td>{{ $value->tahun_terbit }}</td>
                <td>{{ $value->buku_isbn }}</td>
                <td>{{ $value->buku_status }}</td>
                <td>{{ $value->buku_kondisi }}</td>
                <td>{{ $value->buku_jumlah_halaman }}</td>
                <td>{{ $value->buku_jumlah_buku }}</td>
                <td>
                    @if($value->buku_pdf)
                    <a href="{{ asset('buku-pdf/' . $value->buku_pdf) }}" target="_blank">{{ $value->buku_pdf }}</a>
                    @else
                    Tidak Ada PDF
                    @endif
                </td>
                <td>{{ $value->created_at }}</td>
                <td>{{ $value->created_by }}</td>
                <td>{{ $value->updated_at }}</td>
                <td>{{ $value->updated_by }}</td>

                @elseif($jenis == 'peminjaman')
                <td>{{ $value->peminjaman_id }}</td>
                <td>{{ $value->anggota->anggota_nama }}</td>
                <td>{{ $value->buku->buku_judul }}</td>
                <td>{{ $value->peminjaman_tgl }}</td>
                <td>{{ $value->peminjaman_tgl_pengembalian }}</td>
                <td>{{ $value->status }}</td>
                <td>{{ $value->created_at }}</td>
                <td>{{ $value->created_by }}</td>
                <td>{{ $value->updated_at }}</td>
                <td>{{ $value->updated_by }}</td>
                @endif
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
</body>
</html>
