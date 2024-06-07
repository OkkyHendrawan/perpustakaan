@extends('layout.app')

@section('content')

    <main class="main-content position-relative border-radius-lg ">
      <div class="container-fluid py-4">
        <div class="row">
          <div class="col-12">
            <div class="card mb-4">
              <div class="card-header pb-0">
                <h6>Daftar Anggota</h6>
                @include('auth.message')
                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.anggota.form_create') }}" class="btn btn-primary">Tambah Anggota</a>
                  <!-- Tombol untuk menambah anggota baru -->
                </div>
              </div>
              <div class="card-body px-0 pt-0 pb-2">
                <form action="{{ route('anggota.search') }}" method="GET">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text" name="anggota_nama" class="form-control" placeholder="Cari Nama Anggota">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text" name="anggota_jenis" class="form-control" placeholder="Cari Jenis Anggota">
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Cari</button>
                            <a href="{{ route('admin.anggota.list') }}" class="btn btn-secondary">Reset</a>
                        </div>
                    </div>
                </form>
                <div class="table-responsive p-0">
                  <table class="table align-items-center mb-0">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Kode Anggota</th>
                        <th>Nama Lengkap</th>
                        <th>Alamat</th>
                        <th>Jenis</th>
                        <th>Tanggal Daftar</th>
                        <th>Tanggal Buat</th>
                        <th>Di Buat Oleh</th>
                        <th>Tanggal Update</th>
                        <th>Di Update Oleh</th>
                        <th>Aksi</th> <!-- Kolom untuk aksi edit dan delete -->
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($anggota as $value)
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
                        <td>
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#previewModal{{ $value->anggota_id }}">Preview</button>
                                <!-- Modal -->
                                <div class="modal fade" id="previewModal{{ $value->anggota_id }}" tabindex="-1" aria-labelledby="previewModalLabel{{ $value->anggota_id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="previewModalLabel{{ $value->anggota_id }}">Preview Anggota</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <ul class="list-group">
                                                    <li class="list-group-item"><strong>ID:</strong> {{ $value->anggota_id }}</li>
                                                    <li class="list-group-item"><strong>Kode Anggota:</strong> {{ $value->anggota_kode }}</li>
                                                    <li class="list-group-item"><strong>Nama Lengkap:</strong> {{ $value->anggota_nama }}</li>
                                                    <li class="list-group-item"><strong>Alamat:</strong> {{ $value->anggota_alamat }}</li>
                                                    <li class="list-group-item"><strong>Jenis:</strong> {{ $value->anggota_jenis }}</li>
                                                    <li class="list-group-item"><strong>Tanggal Daftar:</strong> {{ $value->anggota_tgl_daftar }}</li>
                                                    <li class="list-group-item"><strong>Dibuat Pada:</strong> {{ $value->created_at }}</li>
                                                    <li class="list-group-item"><strong>Dibuat Oleh:</strong> {{ $value->created_by }}</li>
                                                    <li class="list-group-item"><strong>Terakhir Diperbarui Pada:</strong> {{ $value->updated_at }}</li>
                                                    <li class="list-group-item"><strong>Terakhir Diperbarui Oleh:</strong> {{ $value->updated_by }}</li>
                                                </ul>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <a href="{{ route('admin.anggota.edit', $value->anggota_id) }}" class="btn btn-success btn-sm">Edit</a>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $value->anggota_id }}">Delete</button>
                            <!-- Modal -->
                            <div class="modal fade" id="deleteModal{{ $value->anggota_id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $value->anggota_id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel{{ $value->anggota_id }}">Konfirmasi Hapus</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <ul class="list-group">
                                                <li class="list-group-item"><strong>Nama Lengkap:</strong> {{ $value->anggota_nama }}</li>
                                                <li class="list-group-item"><strong>Alamat:</strong> {{ $value->anggota_alamat }}</li>
                                            </ul>
                                            </div>
                                            <p>Apakah Anda yakin ingin menghapus anggota ini?</p>
                                        <div class="modal-footer">
                                            <form action="{{ route('admin.anggota.softDeleteAnggota', ['anggota_id' => $value->anggota_id]) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                                            </form>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
                <div class="card-footer clearfix">
                    {{ $anggota->links('pagination::bootstrap-5') }}
                </div>
            </div>
          </div>
        </div>
      </div>
    </main>

@endsection
