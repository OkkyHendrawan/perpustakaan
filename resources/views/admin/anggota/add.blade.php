@extends('layout.app')

@section('content')

<main class="main-content position-relative border-radius-lg ">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Tambah Anggota Baru</h6>
                    </div>
                    <div class="card-body px-4 pt-4">
                        <form action="{{ route('admin.anggota.proses_create') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="anggota_kode" class="form-label">Kode Anggota</label>
                                        <input type="text" class="form-control" id="anggota_kode" name="anggota_kode" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="anggota_nama" class="form-label">Nama Lengkap<span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" id="anggota_nama" name="anggota_nama" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="anggota_alamat" class="form-label">Alamat</label>
                                        <textarea class="form-control" id="anggota_alamat" name="anggota_alamat" rows="3" required></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="anggota_status" class="form-label">Status</label>
                                        <select class="form-select" id="anggota_jenis" name="anggota_jenis" required>
                                            <option value="Aktif">Aktif</option>
                                            <option value="Tidak Aktif">Tidak Aktif</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="anggota_tgl_daftar" class="form-label">Tanggal Daftar</label>
                                        <input type="date" class="form-control" id="anggota_tgl_daftar" name="anggota_tgl_daftar" required>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="{{ route('admin.anggota.list') }}" class="btn btn-secondary">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>


@endsection
