@extends('layouts.master')
@section('title')
    @lang('GOLONGAN')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Calon Maba
        @endslot
        @slot('title')
            Golongan
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
                                <h4 class="card-title mt-2">DATA PENDAFTAR CICILAN UKT</h4>
                            </div>
                        </div>
                    </div><!-- end card header -->
                    <div class="card-body">
                        <div class="row g-4 mb-3">
                            <div class="col-sm-auto">
                                <div>
                                    <button type="button" class="btn btn-primary add-btn" data-bs-toggle="modal"
                                        id="create-btn" data-bs-target="#addModal"><i
                                            class="ri-add-line align-bottom me-1"></i>Tambah Pendaftar Cicilan UKT</button>
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
                                        <th class="sort" data-sort="customer_name">NAMA PENDAFTAR</th>
                                        <th class="sort" data-sort="date">NOMINAL UKT</th>
                                        <th class="sort" data-sort="email">CICILAN PERTAMA</th>
                                        <th class="sort" data-sort="phone">CICILAN KEDUA</th>
                                        <th class="sort" data-sort="status">CICILAN KETIGA</th>
                                        <th class="sort" data-sort="status_cicilan">STATUS CICILAN</th>
                                        <th class="sort" data-sort="dokumen">DOKUMEN</th>
                                        <th class="sort" data-sort="action">AKSI</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @foreach ($cicilan as $i => $row)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td class="customer_name">{{ $row->pendaftar->nama ?? 'Tidak ada' }}</td>
                                            <td class="date">{{ $row->nominal_ukt }}</td>
                                            <td class="email">{{$row->cicilan_pertama}}</td>
                                            <td class="phone">{{$row->cicilan_kedua}}</td>
                                            <td class="status">{{$row->cicilan_ketiga}}</td>
                                            <td class="status">
                                                @if ($row->status_cicilan === 'Pending')
                                                    <span class="badge bg-warning text-dark">Pending</span>
                                                @elseif ($row->status_cicilan === 'ditolak')
                                                    <span class="badge bg-danger text-white">Ditolak</span>
                                                @elseif ($row->status_cicilan === 'disetujui')
                                                    <span class="badge bg-success text-white">Disetujui</span>
                                                @else
                                                    <span class="badge bg-secondary text-white">Tidak Diketahui</span>
                                                @endif
                                            </td>
                                            
                                            
                                            <td class="dokumen">{{$row->dokumen}}</td>
                                            <td>
                                                <!-- Tombol Edit -->
                                                <button class="btn btn-warning btn-sm" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#editModal{{ $row->id }}"
                                                    @if ($row->status_cicilan != 'Pending') disabled @endif>
                                                    Edit
                                                </button>
                                            
                                                <!-- Tombol Hapus -->
                                                <button class="btn btn-danger btn-sm" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#deleteModal{{ $row->id }}"
                                                    @if ($row->status_cicilan != 'Pending') disabled @endif>
                                                    Hapus
                                                </button>
                                                <button class="btn btn-info btn-sm" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#updateStatusModal{{ $row->id }}"
                                                    @if ($row->status_cicilan != 'Pending') disabled @endif>
                                                    Update Status Cicilan
                                                 </button>

                                                @if ($row->status_cicilan != 'Pending')
                                                    <small class="text-warning">Aksi ini hanya bisa dilakukan pada status Pending.</small>
                                                @endif
                                            
                                                <!-- Modal Edit -->
                                                <div class="modal fade" id="editModal{{ $row->id }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <form action="{{ route('cicilanUkt.update', $row->id) }}" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="editModalLabel">Edit Cicilan</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="mb-3">
                                                                        <label for="nama" class="form-label">Nama Pendaftar</label>
                                                                        <input type="text" class="form-control" id="nama" name="nama" value="{{ $row->pendaftar->nama }}" required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="nominal_ukt" class="form-label">Nominal UKT</label>
                                                                        <input type="number" class="form-control" id="nominal_ukt" name="nominal_ukt" value="{{ $row->nominal_ukt }}" required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="status_cicilan" class="form-label">Status Cicilan</label>
                                                                        <select class="form-select" id="status_cicilan" name="status_cicilan" required>
                                                                            <option value="pending" {{ $row->status_cicilan == 'pending' ? 'selected' : '' }}>Pending</option>
                                                                            <option value="disetujui" {{ $row->status_cicilan == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                                                                            <option value="ditolak" {{ $row->status_cicilan == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary" @if ($row->status_cicilan != 'Pending') disabled @endif>Simpan Perubahan</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            
                                                <!-- Modal Hapus -->
                                                <div class="modal fade" id="deleteModal{{ $row->id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <form action="{{ route('cicilanUkt.destroy', $row->id) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="deleteModalLabel">Hapus Data Cicilan</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p>Apakah Anda yakin ingin menghapus data cicilan ini?</p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                                                                    <button type="submit" class="btn btn-danger" @if ($row->status_cicilan != 'pending') disabled @endif>Hapus</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Modal Update Status Cicilan -->
                                                <div class="modal fade" id="updateStatusModal{{ $row->id }}" tabindex="-1" aria-labelledby="updateStatusModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <form action="{{ route('cicilanUkt.updateStatus', $row->id) }}" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="updateStatusModalLabel">Update Status Cicilan</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="mb-3">
                                                                        <label for="status_cicilan" class="form-label">Status Cicilan</label>
                                                                        <select class="form-select" id="status_cicilan" name="status_cicilan" required>
                                                                            <option value="pending" {{ $row->status_cicilan == 'pending' ? 'selected' : '' }}>Pending</option>
                                                                            <option value="disetujui" {{ $row->status_cicilan == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                                                                            <option value="ditolak" {{ $row->status_cicilan == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary">Update Status</button>
                                                                </div>
                                                            </form>
                                                        </div>
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
@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/prismjs/prismjs.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/list.js/list.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/list.pagination.js/list.pagination.min.js') }}"></script>
    <!-- listjs init -->
    <script src="{{ URL::asset('assets/js/pages/listjs.init.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
