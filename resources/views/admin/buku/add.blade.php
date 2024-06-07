@extends('layout.app')

@section('content')

<main class="main-content position-relative border-radius-lg ">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Tambah Buku Baru</h6>
                    </div>
                    <div class="card-body px-4 pt-4">
                        <form action="{{ route('admin.buku.proses_create') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="buku_kode" class="form-label">Kode Buku</label>
                                        <input type="text" class="form-control" id="buku_kode" name="buku_kode" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="buku_judul" class="form-label">Judul Buku<span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" id="buku_judul" name="buku_judul" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="buku_nama_pengarang" class="form-label">Nama Pengarang<span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" id="buku_nama_pengarang" name="buku_nama_pengarang" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
                                        <input type="text" class="form-control" id="tahun_terbit" name="tahun_terbit" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="buku_isbn" class="form-label">ISBN</label>
                                        <input type="text" class="form-control" id="buku_isbn" name="buku_isbn" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="buku_status" class="form-label">Status</label>
                                        <select class="form-select" id="buku_status" name="buku_status" required>
                                            <option value="Tersedia">Tersedia</option>
                                            <option value="Dipinjam">Dipinjam</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="buku_kondisi" class="form-label">Kondisi</label>
                                        <select class="form-select" id="buku_kondisi" name="buku_kondisi" required>
                                            <option value="Baik">Baik</option>
                                            <option value="Rusak">Rusak</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="buku_jumlah_halaman" class="form-label">Jumlah Halaman</label>
                                        <input type="text" class="form-control" id="buku_jumlah_halaman" name="buku_jumlah_halaman" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="buku_jumlah_buku" class="form-label">Jumlah Buku</label>
                                        <input type="text" class="form-control" id="buku_jumlah_buku" name="buku_jumlah_buku" required>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="gambar" class="form-label">Gambar</label>
                                <input type="file" class="form-control" id="gambar" name="buku_gambar" onchange="previewImage(event)">
                                <div class="mt-2">
                                    <img id="preview" src="#" alt="Preview" style="max-width: 200px; display: none;">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="buku_pdf" class="form-label">PDF</label>
                                <input type="file" class="form-control" id="buku_pdf" name="buku_pdf">
                            </div>
                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="{{ route('admin.buku.list') }}" class="btn btn-secondary">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function () {
            var preview = document.getElementById('preview');
            preview.src = reader.result;
            preview.style.display = 'block'; // Menampilkan gambar setelah dipilih
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>

@endsection
