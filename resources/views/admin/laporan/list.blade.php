@extends('layout.app')

@section('content')

<main class="main-content position-relative border-radius-lg">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Laporan Data</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <form action="{{ route('admin.laporan.cetak') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="jenis" class="form-label">Jenis Laporan</label>
                                <select class="form-select" id="jenis" name="jenis">
                                    <option value="anggota">Data Anggota</option>
                                    <option value="buku">Data Buku</option>
                                    <option value="peminjaman">Data Peminjaman</option>
                                </select>
                            </div>
                            <button type="submit" name="format" value="pdf" class="btn btn-danger" target="_blank">Cetak PDF</button>
                            <button type="submit" name="format" value="excel" class="btn btn-success" target="_blank">Cetak Excel</button>
                            <button type="button" id="cetak" class="btn btn-primary">Tampilkan Laporan</button>
                            <button type="button" id="reset" class="btn btn-warning">Reset</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if(isset($data))
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        @if($jenis == 'anggota')
                                        <div class="card-header pb-0">
                                            <h6>Laporan Anggota</h6>
                                        </div>
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
                                        <div class="card-header pb-0">
                                            <h6>Laporan Buku</h6>
                                        </div>
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
                                        <div class="card-header pb-0">
                                            <h6>Laporan Peminjaman</h6>
                                        </div>
                                        <th>#</th>
                                        <th>Anggota</th>
                                        <th>Buku</th>
                                        <th>Tanggal Pinjam</th>
                                        <th>Tanggal Kembali</th>
                                        <th>Status</th>
                                        <th>Denda</th>
                                        <th>Tanggal Buat</th>
                                        <th>Dibuat Oleh</th>
                                        <th>Tanggal Update</th>
                                        <th>Di Update Oleh</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($jenis == 'anggota')
                                    @foreach($data as $value)
                                    <tr>
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
                                    </tr>
                                    @endforeach
                                    @elseif($jenis == 'buku')
                                    @foreach($data as $value)
                                    <tr>
                                        <td>{{ $value->buku_id }}</td>
                                        <td class="text-center">
                                            @if($value->buku_gambar && file_exists(public_path('buku-gambar/'.$value->buku_gambar)))
                                            <div style="width: 80px; height: 80px; border: 1px solid #ccc; overflow: hidden; margin: auto;">
                                                <img src="{{ asset('buku-gambar/'.$value->buku_gambar) }}" alt="Gambar Buku" style="width: 100%; height: 100%; object-fit: cover;">
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
                                    </tr>
                                    @endforeach
                                    @elseif($jenis == 'peminjaman')
                                    @foreach($data as $value)
                                    <tr>
                                        <td>{{ $value->peminjaman_id }}</td>
                                        <td>{{ optional($value->anggota)->anggota_nama }}</td>
                                        <td>{{ optional($value->buku)->buku_judul }}</td>
                                        <td>{{ $value->peminjaman_tgl }}</td>
                                        <td>{{ $value->peminjaman_tgl_pengembalian }}</td>
                                        <td>{{ $value->status }}</td>
                                        <td>{{ $value->peminjaman_denda }}</td>
                                        <td>{{ $value->created_at }}</td>
                                        <td>{{ $value->created_by }}</td>
                                        <td>{{ $value->updated_at }}</td>
                                        <td>{{ $value->updated_by }}</td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</main>

<script>
    document.getElementById('cetak').addEventListener('click', function() {
        var jenisLaporan = document.getElementById('jenis').value;
        window.location.href = "{{ route('admin.laporan.cetak') }}" + "?jenis=" + jenisLaporan;
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('reset').addEventListener('click', function() {
            var tableBody = document.querySelector('.table tbody');
            tableBody.innerHTML = ''; // Menghapus semua baris dalam tabel
        });
    });
</script>


@endsection
