@extends('layouts.master')
@section('title')
    @lang('UKT')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Calon Maba
        @endslot
        @slot('title')
            UKT
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
                                <h4 class="card-title mt-2">DAFTAR UKT</h4>
                            </div>
                            <div class="col-sm">
                                <div class="d-flex justify-content-sm-end">
                                    <div class="search-box ms-2">
                                        <a href="{{ route('golongan-ukt.index') }}" type="button"
                                            class="btn btn-soft-dark waves-effect waves-light add-btn"><i
                                                class="ri-arrow-left-circle-fill align-bottom me-1"></i>Kembali</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- end card header -->
                    <div class="card-body">
                        <div class="row g-4 mb-3">
                            <div class="col-sm-auto">
                                <div>
                                    <button type="button" class="btn btn-primary add-btn" data-bs-toggle="modal"
                                        id="create-btn" data-bs-target="#addModal"><i
                                            class="ri-add-line align-bottom me-1"></i>Tambah UKT</button>
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
                                        <th scope="col" style="width: 50px;">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="checkAll"
                                                    value="option">
                                            </div>
                                        </th>
                                        <td class="id" style="display:none;"><a href="javascript:void(0);"
                                                class="fw-medium link-primary">#VZ2101</a></td>
                                        <th class="sort" data-sort="customer_name">NIK</th>
                                        <th class="sort" data-sort="date">NAMA</th>
                                        {{-- <th class="sort" data-sort="email">GOLONGAN</th>
                                        <th class="sort" data-sort="email">KRITERIA GOLONGAN</th>
                                        <th class="sort" data-sort="phone">NOMINAL REGULER</th>
                                        <th class="sort" data-sort="status">NOMINAL NON REGULER</th>
                                        <th class="sort" data-sort="action">AKSI</th> --}}
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @foreach ($listPendaftar as $i => $row)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <th scope="row">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="checkAll"
                                                        value="option1">
                                                </div>
                                            </th>
                                            <td class="id" style="display:none;"><a href="javascript:void(0);"
                                                    class="fw-medium link-primary">#VZ2101</a></td>
                                            <td class="customer_name">{{ $row->user->nik }}</td>
                                            <td class="date">{{ $row->nama }}</td>
                                            {{-- <td class="email">{{ $row->golongan->nama_golongan }}</td>
                                            <td class="email">{{ $row->golongan->kriteria }}</td>
                                            <td class="phone">Rp. {{ number_format($row->nominal_reguler) }}</td>
                                            <td class="status">Rp. {{ number_format($row->nominal_non_reguler) }}</td> --}}
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
@section('scri pt')
    <script src="{{ URL::asset('assets/libs/prismjs/prismjs.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/list.js/list.js.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/list.pagination.js/list.pagination.js.min.js') }}"></script>
    <!-- listjs init -->
    <script src="{{ URL::asset('assets/js/pages/listjs.init.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
