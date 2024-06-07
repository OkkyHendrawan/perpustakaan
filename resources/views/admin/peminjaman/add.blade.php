@extends('layout.app')

@section('content')

<main class="main-content position-relative border-radius-lg">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Tambah Peminjaman</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <form action="{{ route('admin.peminjaman.proses_create') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label> Anggota <span style="color: red;">*</span></label>
                                <select class="form-select" id="anggota" name="anggota_id">
                                    <option value="">Pilih Anggota</option>
                                    @foreach($anggota as $value)
                                    @if(!$value->is_delete)
                                    <option value="{{ $value->anggota_id }}">{{ $value->anggota_nama }}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label> Buku <span style="color: red;">*</span></label>
                                <select class="form-select" id="buku" name="buku_id">
                                    <option value="">Pilih Judul Buku</option>
                                    @foreach($buku as $value)
                                    @if(!$value->is_delete)
                                    <option value="{{ $value->buku_id }}">{{ $value->buku_judul }}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="tgl_peminjaman" class="form-label">Tanggal Peminjaman</label>
                                <input type="date" class="form-control" id="tgl_peminjaman" name="tgl_peminjaman">
                            </div>
                            <div class="mb-3">
                                <label for="tgl_pengembalian" class="form-label">Tanggal Pengembalian</label>
                                <input type="date" class="form-control" id="tgl_pengembalian" name="tgl_pengembalian">
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="Dipinjam">Dipinjam</option>
                                    <option value="Kembali">Kembali</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="denda" class="form-label">Denda</label>
                                <input type="text" class="form-control" id="denda" name="denda">
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
