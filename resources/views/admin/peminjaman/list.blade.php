@extends('layout.app')

@section('content')

<main class="main-content position-relative border-radius-lg">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Daftar Peminjaman</h6>
                        @include('auth.message')
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.peminjaman.form_create') }}" class="btn btn-primary">Tambah Peminjaman</a>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <form action="{{ route('peminjaman.search') }}" method="GET">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" name="peminjaman_anggota_id" class="form-control" placeholder="Cari Nama Anggota">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" name="peminjaman_buku_id" class="form-control" placeholder="Cari Judul Buku">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Cari</button>
                                    <a href="{{ route('admin.peminjaman.list') }}" class="btn btn-secondary">Reset</a>
                            </div>
                        </form>
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Anggota</th>
                                        <th>Judul Buku</th>
                                        <th>Tanggal Peminjaman</th>
                                        <th>Tanggal Pengembalian</th>
                                        <th>Status</th>
                                        <th>Denda</th>
                                        <th>Tanggal Buat</th>
                                        <th>Dibuat Oleh</th>
                                        <th>Tanggal Update</th>
                                        <th>Di Update Oleh</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($peminjaman as $value)
                                    <tr>
                                        <td>{{ $value->peminjaman_id }}</td>
                                        <td>{{ $value->anggota->anggota_nama }}</td>
                                        <td>{{ $value->buku->buku_judul }}</td>
                                        <td>{{ $value->peminjaman_tgl }}</td>
                                        <td>{{ $value->peminjaman_tgl_pengembalian }}</td>
                                        <td>{{ $value->status }}</td>
                                        <td>
                                            @if($value->peminjaman_denda)
                                                {{ $value->peminjaman_denda }}
                                            @else
                                                Tidak ada denda
                                            @endif
                                        </td>

                                        <td>{{ $value->created_at }}</td>
                                        <td>{{ $value->created_by }}</td>
                                        <td>{{ $value->updated_at }}</td>
                                        <td>{{ $value->updated_by }}</td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#previewModal{{ $value->peminjaman_id }}">Preview</button>
                                            <a href="{{ route('admin.peminjaman.edit', $value->peminjaman_id) }}"
                                                class="btn btn-success btn-sm">Edit</a>
                                            <button type="button" class="btn btn-danger btn-sm"
                                                data-bs-toggle="modal" data-bs-target="#deleteModal{{ $value->peminjaman_id }}">Delete</button>
                                            <!-- Modal -->
                                            <div class="modal fade" id="previewModal{{ $value->peminjaman_id }}" tabindex="-1"
                                                aria-labelledby="previewModalLabel{{ $value->peminjaman_id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="previewModalLabel{{ $value->peminjaman_id }}">Preview Peminjaman</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <ul class="list-group">
                                                                <li class="list-group-item"><strong>Nama Anggota:</strong> {{ $value->anggota->anggota_nama }}</li>
                                                                <li class="list-group-item"><strong>Judul Buku:</strong> {{ $value->buku->buku_judul }}</li>
                                                                <li class="list-group-item"><strong>Tanggal Peminjaman:</strong> {{ $value->peminjaman_tgl }}</li>
                                                                <li class="list-group-item"><strong>Tanggal Pengembalian:</strong> {{ $value->peminjaman_tgl_pengembalian }}</li>
                                                                <li class="list-group-item"><strong>Status:</strong> {{ $value->status }}</li>
                                                                <li class="list-group-item"><strong>Denda:</strong> {{ $value->peminjaman_denda }}</li>
                                                                <li class="list-group-item"><strong>Tanggal Buat:</strong> {{ $value->created_at }}</li>
                                                                <li class="list-group-item"><strong>Dibuat Oleh:</strong> {{ $value->created_by }}</li>
                                                                <li class="list-group-item"><strong>Tanggal Update:</strong> {{ $value->updated_at }}</li>
                                                                <li class="list-group-item"><strong>Di Update Oleh:</strong> {{ $value->updated_by }}</li>
                                                            </ul>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Modal -->
                                            <div class="modal fade" id="deleteModal{{ $value->peminjaman_id }}" tabindex="-1"
                                                aria-labelledby="deleteModalLabel{{ $value->peminjaman_id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="deleteModalLabel{{ $value->peminjaman_id }}">Konfirmasi
                                                                Hapus</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <ul class="list-group">
                                                                <li class="list-group-item"><strong>Nama Anggota:</strong> {{ $value->anggota->anggota_nama }}</li>
                                                                <li class="list-group-item"><strong>Judul Buku:</strong> {{ $value->buku->buku_judul }}</li>
                                                            </ul>
                                                        </div>
                                                        <p>Apakah Anda yakin ingin menghapus peminjaman ini?</p>
                                                        <div class="modal-footer">
                                                            <form
                                                                action="{{ route('admin.peminjaman.softDeletePeminjaman', ['peminjaman_id' => $value->peminjaman_id]) }}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                <button type="submit" class="btn btn-danger">Ya,
                                                                    Hapus</button>
                                                            </form>
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Tidak</button>
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
                            {{ $peminjaman->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection
