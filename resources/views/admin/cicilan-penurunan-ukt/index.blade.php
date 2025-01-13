@extends('layouts.master')
@section('title')
    @lang('DATA PENDAFTAR CICILAN UKT')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Calon Maba
        @endslot
        @slot('title')
            DATA PENDAFTAR CICILAN UKT
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
                                    <!-- Button untuk Upload -->
                                    <button type="button" class="btn btn-primary add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#addModal">
                                        <i class="ri-add-line align-bottom me-1"></i> Upload Template Dokumen Pendukung
                                    </button>
                            
                                    <!-- Button untuk Lihat Dokumen -->
                                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#viewModal">
                                        <i class="ri-eye-line align-bottom me-1"></i> Lihat Dokumen
                                    </button>
                            
                                    <!-- Modal Upload Dokumen -->
                                    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="addModalLabel">Upload Template Dokumen Pendukung</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('cicilanUkt.upload') }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="template" class="form-label">Pilih File Template</label>
                                                            <input type="file" class="form-control" id="template" name="file_path" required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Upload</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                            
                                    <!-- Modal Lihat Dokumen -->
                                    <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="viewModalLabel">Lihat Dokumen Pendukung</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- Dynamic File -->
                                                    @php
                                                        // Ambil file_path dari database (sesuaikan dengan model dan kolom yang digunakan)
                                                        $filePath = isset($document) ? $document->file_path : ''; // Gantilah dengan query atau data yang sesuai
                                                    @endphp
                                                
                                                    @if($filePath)
                                                        <embed src="{{ asset('assets/templates/' . $filePath) }}" type="application/pdf" width="100%" height="500px">
                                                    @else
                                                        <p>Tidak ada dokumen yang ditampilkan</p>
                                                    @endif
                                                </div>
                                                
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                                            <td class="date">{{ number_format($row->nominal_ukt, 0, ',', '.') }}</td>
                                            <td class="email">{{ number_format($row->cicilan_pertama, 0, ',', '.') }}</td>
                                            <td class="phone">{{ number_format($row->cicilan_kedua, 0, ',', '.') }}</td>
                                            <td class="status">{{ number_format($row->cicilan_ketiga, 0, ',', '.') }}</td>
                                            
                                            <td class="status">
                                                @if ($row->status_cicilan === 'pending')
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
                                                    data-bs-target="#editModal{{ $row->id }}">
                                                    Edit
                                                </button>
                                            
                                                <!-- Tombol Hapus -->
                                                <button class="btn btn-danger btn-sm" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#deleteModal{{ $row->id }}">
                                                    Hapus
                                                </button>
                                            
                                                <!-- Tombol Update Status -->
                                                <button class="btn btn-info btn-sm" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#updateStatusModal{{ $row->id }}">
                                                    Update Status Cicilan
                                                </button>
                                            
                                                <!-- Modal Edit -->
                                                <div class="modal fade" id="editModal{{ $row->id }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <form action="{{ route('cicilanUkt.update', $row->id) }}" method="POST" onsubmit="return validateCicilan({{ $row->id }})">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="editModalLabel">Edit Cicilan</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="mb-3">
                                                                        <label for="nama" class="form-label">Nama Pendaftar</label>
                                                                        <input type="text" class="form-control" id="nama{{ $row->id }}" name="nama" value="{{ $row->pendaftar->nama }}" required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="nominal_ukt" class="form-label">Nominal UKT</label>
                                                                        <input type="text" class="form-control" id="nominal_ukt{{ $row->id }}" name="nominal_ukt" value="{{ number_format($row->nominal_ukt, 0, ',', '.') }}" readonly>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="cicilan_pertama" class="form-label">Cicilan Pertama</label>
                                                                        <input type="text" class="form-control cicilan-input" id="cicilan_pertama{{ $row->id }}" name="cicilan_pertama" value="{{ number_format($row->cicilan_pertama, 0, ',', '.') }}" required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="cicilan_kedua" class="form-label">Cicilan Kedua</label>
                                                                        <input type="text" class="form-control cicilan-input" id="cicilan_kedua{{ $row->id }}" name="cicilan_kedua" value="{{ number_format($row->cicilan_kedua, 0, ',', '.') }}" required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="cicilan_ketiga" class="form-label">Cicilan Ketiga</label>
                                                                        <input type="text" class="form-control cicilan-input" id="cicilan_ketiga{{ $row->id }}" name="cicilan_ketiga" value="{{ number_format($row->cicilan_ketiga, 0, ',', '.') }}" required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="status_cicilan{{ $row->id }}" class="form-label">Status Cicilan</label>
                                                                        <select class="form-control" id="status_cicilan{{ $row->id }}" name="status_cicilan" required>
                                                                            <option value="pending" {{ $row->status_cicilan == 'pending' ? 'selected' : '' }}>Pending</option>
                                                                            <option value="disetujui" {{ $row->status_cicilan == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                                                                            <option value="ditolak" {{ $row->status_cicilan == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                                                        </select>
                                                                    </div>
                                                                    
                                                                    <div id="errorMessage{{ $row->id }}" class="text-danger" style="display:none;">
                                                                        Total cicilan harus sama dengan Nominal UKT!
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <script>
                                                    function validateCicilan(rowId) {
                                                        // Ambil nilai cicilan dan nominal UKT, default ke 0 jika kosong atau tidak valid
                                                        const nominalUkt = parseInt(document.getElementById(`nominal_ukt${rowId}`).value.replace(/\./g, ''), 10) || 0;
                                                        const cicilanPertama = parseInt(document.getElementById(`cicilan_pertama${rowId}`).value.replace(/\./g, ''), 10) || 0;
                                                        const cicilanKedua = parseInt(document.getElementById(`cicilan_kedua${rowId}`).value.replace(/\./g, ''), 10) || 0;
                                                        const cicilanKetiga = parseInt(document.getElementById(`cicilan_ketiga${rowId}`).value.replace(/\./g, ''), 10) || 0;
                                                    
                                                        // Totalkan cicilan
                                                        const totalCicilan = cicilanPertama + cicilanKedua + cicilanKetiga;
                                                    
                                                        // Validasi apakah total cicilan sesuai dengan nominal UKT
                                                        if (totalCicilan !== nominalUkt) {
                                                            document.getElementById(`errorMessage${rowId}`).style.display = 'block';
                                                            return false;
                                                        }
                                                    
                                                        document.getElementById(`errorMessage${rowId}`).style.display = 'none';
                                                        return true;
                                                    }
                                                
                                                    // Menambahkan event listener untuk setiap input cicilan untuk format rupiah
                                                    document.querySelectorAll('.cicilan-input').forEach(input => {
                                                        input.addEventListener('input', function () {
                                                            const value = this.value.replace(/\D/g, ''); // Hanya ambil angka
                                                            this.value = new Intl.NumberFormat('id-ID').format(value); // Format ke Rupiah
                                                        });
                                                    });
                                                </script>
                                                
                                                
                                                
                                            
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
                                                                    <button type="submit" class="btn btn-danger">Hapus</button>
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
