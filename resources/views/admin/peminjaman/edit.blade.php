@extends('layout.app')

@section('content')

<main class="main-content position-relative border-radius-lg">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Edit Peminjaman</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <form action="{{ route('admin.peminjaman.update', $peminjaman->peminjaman_id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label>Nama Anggota <span style="color: red;">*</span></label>
                                <select class="form-control" required name="peminjaman_anggota_id">
                                    <option value="">Pilih Anggota</option>
                                    @foreach($daftarAnggota as $value)
                                        <option value="{{ $value->anggota_id }}" {{ $peminjaman->peminjaman_anggota_id == $value->anggota_id ? 'selected' : '' }}>{{ $value->anggota_nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Judul Buku <span style="color: red;">*</span></label>
                                <select class="form-control" required name="peminjaman_buku_id">
                                    <option value="">Pilih Buku</option>
                                    @foreach($daftarBuku as $value)
                                        <option value="{{ $value->buku_id }}" {{ $peminjaman->peminjaman_buku_id == $value->buku_id ? 'selected' : '' }}>{{ $value->buku_judul }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="peminjaman_tgl" class="form-label">Tanggal Peminjaman</label>
                                <input type="date" class="form-control" id="peminjaman_tgl" name="peminjaman_tgl" value="{{ $peminjaman->peminjaman_tgl }}">
                            </div>
                            <div class="mb-3">
                                <label for="peminjaman_tgl_pengembalian" class="form-label">Tanggal Pengembalian</label>
                                <input type="date" class="form-control" id="peminjaman_tgl_pengembalian" name="peminjaman_tgl_pengembalian" value="{{ $peminjaman->peminjaman_tgl_pengembalian }}">
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="Dipinjam" @if($peminjaman->status == 'Dipinjam') selected @endif>Dipinjam</option>
                                    <option value="Kembali" @if($peminjaman->status == 'Kembali') selected @endif>Kembali</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="peminjaman_denda" class="form-label">Denda</label>
                                <input type="text" class="form-control" id="peminjaman_denda" name="peminjaman_denda" value="{{ $peminjaman->peminjaman_denda }}">
                            </div>
                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="{{ route('admin.peminjaman.list') }}" class="btn btn-secondary">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection
