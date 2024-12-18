@extends('layouts.master')
@section('title')
    @lang('Alur Pendaftaran')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Lainnya
        @endslot
        @slot('title')
            Alur Pendaftaran
        @endslot
    @endcomponent
    @if (Session::has('success'))
        <div class="alert alert-success">
            <strong>Success: </strong>{{ Session::get('success') }}
        </div>
    @endif
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div id="customerList">
                    <div class="card-header">
                        <div class="row g-4">
                            <div class="col-sm-auto">
                                <h4 class="card-title mt-2">DATA ALUR PENDAFTARAN</h4>
                            </div>
                        </div>
                    </div><!-- end card header -->
                    <div class="card-body">
                        <div class="row g-4 mb-3">
                            <div class="col-sm-auto">
                                <div>
                                    <button type="button" class="btn btn-primary add-btn" data-bs-toggle="modal"
                                        id="create-btn" data-bs-target="#addModal"><i
                                            class="ri-add-line align-bottom me-1"></i>Tambah Alur Pendaftar</button>
                                </div>
                            </div>
                            <div class="col-sm">
                                <div class="d-flex justify-content-sm-end">
                                    <div class="search-box ms-2">
                                        <input type="text" class="form-control search" placeholder="Search...">
                                        <i class="ri-search-line search-icon"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive table-card mt-3 mb-1">
                            <table class="table align-middle table-nowrap" id="customerTable">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th class="sort" data-sort="customer_name">NAMA ALUR PENDAFTARAN</th>
                                        <th class="sort" data-sort="date">GAMBAR</th>
                                        <th class="sort" data-sort="email" hidden></th>
                                        <th class="sort" data-sort="phone" hidden></th>
                                        <th class="sort" data-sort="status" hidden></th>
                                        <th class="sort" data-sort="action">AKSI</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @foreach ($alur as $i => $row)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td class="customer_name">{{ $row->nama_alur }}</td>
                                            <td class="date">
                                                <img src="{{ asset('storage/' . $row->gambar) }}" alt="Gambar Alur" class="img-thumbnail" style="width: 100px;">
                                            </td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <div class="edit">
                                                        <button type="button" class="btn btn-warning btn-icon waves-effect waves-light rounded-pill"
                                                            data-bs-toggle="modal" data-bs-target="#editModal{{ $row->id }}">
                                                            <i class="ri-edit-box-line"></i>
                                                        </button>
                                                    </div>
                                                    <div class="remove">
                                                        <form action="{{ route('alurPendaftaran.destroy', $row->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-icon waves-effect waves-light rounded-pill">
                                                                <i class="ri-delete-bin-line"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                
                            </table>
                            <div class="noresult" style="display: none">
                                <div class="text-center">
                                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                        colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px">
                                    </lord-icon>
                                    <h5 class="mt-2">Maaf! Data yang anda cari tidak ada</h5>
                                    <p class="text-muted mb-0">Harap Perbaiki kata kunci yang anda cari. </p>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <div class="pagination-wrap hstack gap-2">
                                <a class="page-item pagination-prev disabled" href="#">
                                    Previous
                                </a>
                                <ul class="pagination listjs-pagination mb-0"></ul>
                                <a class="page-item pagination-next" href="#">
                                    Next
                                </a>
                            </div>
                        </div>
                    </div><!-- end card -->
                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->

    <!-- Modal Create -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light p-3">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="close-modal"></button>
                </div>
                <form action="{{ route('alurPendaftaran.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <!-- ID Field (Hidden) -->
                        <div class="mb-3" id="modal-id" style="display: none;">
                            <label for="id-field" class="form-label">ID</label>
                            <input type="text" id="id-field" class="form-control" placeholder="ID" readonly />
                        </div>
                
                        <!-- Nama Alur Pendaftaran -->
                        <div class="mb-3">
                            <label for="nama-alur-field" class="form-label">Nama Alur Pendaftaran</label>
                            <input type="text" name="nama_alur" id="nama-alur-field" class="form-control" placeholder="Masukkan nama alur pendaftaran" required />
                        </div>
                
                        <!-- Kriteria -->
                        <div class="mb-3">
                            <label for="kriteria-field" class="form-label">Kriteria</label>
                            <textarea name="kriteria" id="kriteria-field" class="form-control" rows="5" style="resize: none" placeholder="Masukkan kriteria" required></textarea>
                        </div>
                
                        <!-- Upload Gambar -->
                        <div class="mb-3">
                            <label for="gambar-field" class="form-label">Upload Gambar</label>
                            <input type="file" name="gambar" id="gambar-field" class="form-control" accept="image/*" required />
                        </div>
                    </div>
                
                    <div class="modal-footer">
                        <div class="hstack gap-2 justify-content-end">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary" id="add-btn">Tambah Alur</button>
                        </div>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
    <!-- Modal Edit -->
    @foreach ($alur as $row)
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-light p-3">
                        <h5 class="modal-title" id="exampleModalLabel"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            id="close-modal"></button>
                    </div>
                    <form action="{{ route('alurPendaftaran.update', $row->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <!-- ID Field (Hidden) -->
                            <div class="mb-3" id="modal-id" style="display: none;">
                                <label for="id-field" class="form-label">ID</label>
                                <input type="text" id="id-field" class="form-control" placeholder="ID" readonly />
                            </div>
                    
                            <!-- Nama Alur Pendaftaran -->
                            <div class="mb-3">
                                <label for="nama-alur-field" class="form-label">Nama Alur Pendaftaran</label>
                                <input type="text" name="nama_alur" id="nama-alur-field" class="form-control" value="" placeholder="Masukkan nama alur pendaftaran" required />
                            </div>
                    
                            <!-- Kriteria -->
                            <div class="mb-3">
                                <label for="kriteria-field" class="form-label">Kriteria</label>
                                <textarea name="kriteria" id="kriteria-field" class="form-control" rows="5" style="resize: none" placeholder="Masukkan kriteria" required></textarea>
                            </div>
                    
                            <!-- Upload Gambar -->
                            <div class="mb-3">
                                <label for="gambar-field" class="form-label">Upload Gambar</label>
                                <input type="file" name="gambar" id="gambar-field" class="form-control" accept="image/*" />
                                <small class="text-muted">Kosongkan jika tidak ingin mengganti gambar.</small>
                            </div>
                        </div>
                    
                        <div class="modal-footer">
                            <div class="hstack gap-2 justify-content-end">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-warning" id="edit-btn">Edit Alur</button>
                            </div>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
        <!-- Modal Delete Data -->
        <div class="modal fade zoomIn" id="deleteRecordModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            id="btn-close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('DELETE')
                            <div class="mt-2 text-center">
                                <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                    colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px">
                                </lord-icon>
                                <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                                    <h4>Are you Sure ?</h4>
                                    <p class="text-muted mx-4 mb-0">Are you Sure You want to Remove this ?
                                    </p>
                                </div>
                            </div>
                            <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                                <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn w-sm btn-danger " id="delete-record">Yes, Delete
                                    It!</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/prismjs/prismjs.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/list.js/list.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/list.pagination.js/list.pagination.min.js') }}"></script>
    <!-- listjs init -->
    <script src="{{ URL::asset('assets/js/pages/listjs.init.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
