@extends('layout.app')

@section('content')

<main class="main-content position-relative border-radius-lg">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Daftar Buku</h6>
                        @include('auth.message')
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.buku.form_create') }}" class="btn btn-primary">Tambah Buku</a>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <form action="{{ route('buku.search') }}" method="GET">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" name="buku_judul" class="form-control" placeholder="Cari Judul Buku">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" name="buku_nama_pengarang" class="form-control" placeholder="Cari Nama Pengarang">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Cari</button>
                                    <a href="{{ route('admin.buku.list') }}" class="btn btn-secondary">Reset</a>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Sampul Buku</th>
                                        <th>Kode Buku</th>
                                        <th>Judul</th>
                                        <th>Nama Pengarang</th>
                                        <th>Tahun Terbit</th>
                                        <th>ISBN</th>
                                        <th>Status</th>
                                        <th>Kondisi</th>
                                        <th>Jumlah Halaman</th>
                                        <th>Jumlah Buku</th>
                                        <th>File PDF</th>
                                        <th>Tanggal Buat</th>
                                        <th>Dibuat Oleh</th>
                                        <th>Tanggal Update</th>
                                        <th>Di Update Oleh</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($buku as $value)
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
                                        <td>
                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#previewModal{{ $value->buku_id }}">Preview</button>
                                                    <!-- Modal -->
                                        <div class="modal fade" id="previewModal{{ $value->buku_id }}" tabindex="-1" aria-labelledby="previewModalLabel{{ $value->buku_id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="previewModalLabel{{ $value->buku_id }}">Preview Buku</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <ul class="list-group">
                                                            <li class="list-group-item"><strong>ID:</strong> {{ $value->buku_id }}</li>
                                                            <li class="list-group-item"><strong>Kode Buku:</strong> {{ $value->buku_kode }}</li>
                                                            <li class="list-group-item"><strong>Judul:</strong> {{ $value->buku_judul }}</li>
                                                            <li class="list-group-item"><strong>Nama Pengarang:</strong> {{ $value->buku_nama_pengarang }}</li>
                                                            <li class="list-group-item"><strong>Tahun Terbit:</strong> {{ $value->tahun_terbit }}</li>
                                                            <li class="list-group-item"><strong>ISBN:</strong> {{ $value->buku_isbn }}</li>
                                                            <li class="list-group-item"><strong>Status:</strong> {{ $value->buku_status }}</li>
                                                            <li class="list-group-item"><strong>Kondisi:</strong> {{ $value->buku_kondisi }}</li>
                                                            <li class="list-group-item"><strong>Jumlah Halaman:</strong> {{ $value->buku_jumlah_halaman }}</li>
                                                            <li class="list-group-item"><strong>Jumlah Buku:</strong> {{ $value->buku_jumlah_buku }}</li>
                                                            <li class="list-group-item"><strong>Dibuat Pada:</strong> {{ $value->created_at }}</li>
                                                            <li class="list-group-item"><strong>Dibuat Oleh:</strong> {{ $value->created_by }}</li>
                                                            <li class="list-group-item"><strong>Terakhir Diperbarui Pada:</strong> {{ $value->updated_at }}</li>
                                                            <li class="list-group-item"><strong>Terakhir Diperbarui Oleh:</strong> {{ $value->updated_by }}</li>
                                                            <li class="list-group-item">
                                                                <strong>Gambar:</strong><br>
                                                                @if($value->buku_gambar && file_exists(public_path('buku-gambar/'.$value->buku_gambar)))
                                                                    <img src="{{ asset('buku-gambar/'.$value->buku_gambar) }}" alt="Gambar Buku" style="max-width: 50%;">
                                                                @else
                                                                    <p>Tidak Ada Gambar</p>
                                                                @endif
                                                            </li>
                                                            <li class="list-group-item">
                                                                <strong>PDF:</strong><br>
                                                                @if($value->buku_pdf)
                                                                <a href="{{ asset('buku-pdf/' . $value->buku_pdf) }}" target="_blank">{{ $value->buku_pdf }}</a>
                                                                @else
                                                                Tidak Ada PDF
                                                                @endif
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                            <a href="{{ route('admin.buku.edit', $value->buku_id) }}"
                                                class="btn btn-success btn-sm">Edit</a>

                                            <button type="button" class="btn btn-danger btn-sm"
                                                data-bs-toggle="modal" data-bs-target="#deleteModal{{ $value->buku_id }}">Delete</button>
                                            <!-- Modal -->
                                            <div class="modal fade" id="deleteModal{{ $value->buku_id }}" tabindex="-1"
                                                aria-labelledby="deleteModalLabel{{ $value->buku_id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="deleteModalLabel{{ $value->buku_id }}">Konfirmasi
                                                                Hapus</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <ul class="list-group">
                                                                <li class="list-group-item"><strong>Judul:</strong> {{ $value->buku_judul }}</li>
                                                                <li class="list-group-item"><strong>Nama Pengarang:</strong> {{ $value->buku_nama_pengarang }}</li>
                                                            </ul>
                                                        </div>
                                                        <p>Apakah Anda yakin ingin menghapus buku ini?</p>
                                                        <div class="modal-footer">
                                                            <form
                                                                action="{{ route('admin.buku.softDeleteBuku', ['buku_id' => $value->buku_id]) }}"
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
                            {{ $buku->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection
