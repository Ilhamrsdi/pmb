@extends('layouts.master')

@section('content')
<div class="container">
    <h1 class="mb-4">Daftar Gambar Atribut</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tombol Tambah Gambar Atribut -->
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createModal">
        Tambah Gambar Atribut
    </button>

    <!-- Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('atribut-gambars.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel">Tambah Gambar Atribut</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="jenis_gambar" class="form-label">Jenis Gambar</label>
                            <input type="text" class="form-control" id="jenis_gambar" name="jenis_gambar" required>
                        </div>
                        <div class="mb-3">
                            <label for="nama_gambar" class="form-label">Nama Gambar</label>
                            <input type="file" class="form-control" id="nama_gambar" name="nama_gambar" required>
                        </div>
                        <div class="mb-3">
                            <label for="ukuran" class="form-label">Ukuran</label>
                            <input type="text" class="form-control" id="ukuran" name="ukuran">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Tabel Daftar Gambar Atribut -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Jenis Gambar</th>
                <th>Nama Gambar</th>
                <th>Ukuran</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($atributGambars as $gambar)
                <tr>
                    <td>{{ $gambar->jenis_gambar }}</td>
                    <td>
                        <a href="{{ asset('uploads/atribut-gambars/' . $gambar->nama_gambar) }}" target="_blank">
                            Lihat Gambar
                        </a>
                    </td>
                    <td>{{ $gambar->ukuran }}</td>
                    <td>
                        <form action="{{ route('atribut-gambars.destroy', $gambar->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <a href="{{ route('atribut-gambars.edit', $gambar->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
