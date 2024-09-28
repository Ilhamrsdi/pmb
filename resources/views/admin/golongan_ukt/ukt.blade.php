@extends('layouts.master')
@section('title')
    @lang('UKT')
@endsection
@section('css')
    <style>
        .drop-container {
            position: relative;
            display: flex;
            gap: 10px;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 200px;
            padding: 20px;
            border-radius: 10px;
            border: 2px dashed #555;
            color: #444;
            cursor: pointer;
            transition: background .2s ease-in-out, border .2s ease-in-out;
        }

        .drop-container:hover {
            background: #eee;
            border-color: #111;
        }

        .drop-container:hover .drop-title {
            color: #222;
        }
    </style>
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
                                <h4 class="card-title mt-2">DAFTAR UKT {{ $golongan->nama_golongan }}</h4>
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
                                    <a href={{ asset('template_excel_import_pendaftar_ukt/Pendaftar_ukt.xlsx') }}>
                                        <button type="button" class="btn btn-success add-btn"><i
                                                class="las la-file-excel label-icon align-middle fs-16 me-2"></i>
                                            DOWNLOAD TEMPLATE EXCEL ADD PENDAFTAR UKT</button>
                                    </a>
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
                                        <th class="sort" data-sort="customer_name">TAHUN AJARAN</th>
                                        <th class="sort" data-sort="date">GELOMBANG</th>
                                        <th class="sort" data-sort="email">GOLONGAN</th>
                                        <th class="sort" data-sort="email">KRITERIA GOLONGAN</th>
                                        <th class="sort" data-sort="phone">NOMINAL REGULER</th>
                                        <th class="sort" data-sort="status">NOMINAL NON REGULER</th>
                                        <th class="sort" data-sort="action">AKSI</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @foreach ($ukt as $i => $row)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td class="customer_name">{{ $row->gelombangPendaftaran?->tahun_ajaran }}</td>
                                            <td class="date">{{ $row->gelombangPendaftaran?->nama_gelombang }}</td>
                                            <td class="email">{{ $row->golongan->nama_golongan }}</td>
                                            <td class="email">{{ $row->golongan->kriteria }}</td>
                                            <td class="phone">Rp. {{ number_format($row->nominal_reguler) }}</td>
                                            <td class="status">Rp. {{ number_format($row->nominal_non_reguler) }}</td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <div class="edit">
                                                        <button type="button"
                                                            class="btn btn-warning btn-icon waves-effect waves-light rounded-pill"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editModal{{ $row->id }}"><i
                                                                class="ri-information-line"></i></button>
                                                    </div>
                                                    <div class="remove">
                                                        <button type="button"
                                                            class="btn btn-danger btn-icon waves-effect waves-light rounded-pill"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#deleteRecordModal{{ $row->id }}"><i
                                                                class="ri-delete-bin-fill"></i></button>
                                                    </div>
                                                    <div class="remove">
                                                        <button type="button"
                                                            class="btn btn-success btn-icon waves-effect waves-light rounded-pill"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#listPendaftarUKT{{ $row->id }}"><i
                                                                class="ri-checkbox-fill"></i></button>
                                                    </div>
                                                    <div class="remove">
                                                        <button type="button"
                                                            class="btn btn-primary btn-icon waves-effect waves-light rounded-pill"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#addPendaftarUKT{{ $row->id }}"><i
                                                                class="ri-add-box-fill"></i></button>
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
    <div class="modal fade" id="importData" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-warning p-3">
                    <h5 class="modal-title" id="exampleModalLabel">IMPORT DATA PENDAFTAR</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="close-modal"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('import.ukt') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        {{-- <input name="file" type="file" class="form-control-file text-center"> --}}
                        <label for="images" class="drop-container">
                            <i class="display-4 text-muted ri-upload-cloud-2-fill"></i>
                            <h4 class="drop-title">Drop files here or click to upload.</h4>
                            <input type="file" name="file" id="images" accept="all/*" required>
                        </label>
                        <button type="submit" class="btn btn-sm btn-success" style="width: 100%">Upload</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Create -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light p-3">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="close-modal"></button>
                </div>
                <form action="{{ route('ukt.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-3" id="modal-id" style="display: none;">
                                    <label for="id-field" class="form-label">ID</label>
                                    <input type="text" id="id-field" class="form-control" placeholder="ID"
                                        readonly />
                                </div>
                                <div class="mb-3">
                                    <label for="customername-field" class="form-label">PILIH TAHUN AJARAN
                                        & GELOMBANG</label>
                                    <select name="gelombang_pendaftaran_id" id="customername-field" class="form-control">
                                        <option disabled>-</option>
                                        @foreach ($gelombangPendaftaran as $data)
                                            <option value="{{ $data->id }}">
                                                {{ $data->nama_gelombang }} -
                                                {{ $data->tahun_ajaran }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="table-responsive table-card mt-3 mb-1">
                                    <table class="table align-middle table-nowrap" id="customerTable">
                                        <thead class="table-light">
                                            <tr>
                                                <th>NO</th>
                                                <th class="sort" data-sort="customer_name">NIK</th>
                                                <th class="sort" data-sort="email">NAMA</th>
                                            </tr>
                                        </thead>
                                        <tbody class="list form-check-all">
                                            @forelse ($listPendaftar as $i => $row)
                                                <tr>
                                                    <td>{{ ++$i }}</td>
                                                    <td class="customer_name">{{ $row->user->nik }}
                                                    </td>
                                                    <td class="email">{{ $row->nama }}</td>
                                                    <td class="remove">
                                                        <form action="{{ route('pendaftarDeleteUKT.ukt') }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('POST')
                                                            <input type="hidden" name="pendaftar"
                                                                value="{{ $row->id }}" class="form-control"
                                                                placeholder="ID" readonly />
                                                            <button type="submit"
                                                                class="btn btn-danger btn-icon waves-effect waves-light rounded-pill"><i
                                                                    class="ri-delete-bin-fill"></i></button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <input type="hidden" name="golongan_id" value="{{ $golongan->id }}">
                                <div class="mb-3">
                                    <label for="phone-field" class="form-label">NOMINAL UKT
                                        REGULER</label>
                                    <input type="number" name="nominal_reguler" id="email-field" class="form-control"
                                        required />
                                </div>
                                <div class="mb-3">
                                    <label for="phone-field" class="form-label">NOMINAL UKT NON
                                        REGULER</label>
                                    <input type="number" name="nominal_non_reguler" id="email-field"
                                        class="form-control" required />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="hstack gap-2 justify-content-end">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary" id="add-btn">Add
                                UKT</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @foreach ($ukt as $i => $row)
        <!-- Modal Edit -->
        <div class="modal fade" id="editModal{{ $row->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-light p-3">
                        <h5 class="modal-title" id="exampleModalLabel"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            id="close-modal"></button>
                    </div>
                    <form action="{{ route('ukt.update', $row->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="mb-3" id="modal-id" style="display: none;">
                                <label for="id-field" class="form-label">ID</label>
                                <input type="text" id="id-field" class="form-control" placeholder="ID" readonly />
                            </div>

                            <div class="mb-3">
                                <label for="email-field" class="form-label">NOMINAL REGULER UKT</label>
                                <input type="number" name="nominal_reguler" id="date-field" class="form-control"
                                    value="{{ $row->nominal_reguler }}" required />
                            </div>

                            <div class="mb-3">
                                <label for="phone-field" class="form-label">NOMINAL NON REGULER UKT</label>
                                <input type="number" name="nominal_non_reguler" id="email-field"
                                    value="{{ $row->nominal_non_reguler }}" class="form-control" required />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="hstack gap-2 justify-content-end">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-warning" id="add-btn">Edit UKT</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal Delete Data -->
        <div class="modal fade zoomIn" id="deleteRecordModal{{ $row->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            id="btn-close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('ukt.destroy', $row->id) }}" method="POST"
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
    @forelse ($ukt as $i => $row)
        <!-- Modal List Pendaftar -->
        <div class="modal fade" id="listPendaftarUKT{{ $row->id }}" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-light p-3">
                        <h5 class="modal-title" id="exampleModalLabel"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            id="close-modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title mb-0">LIST PENDAFTAR UKT
                                            {{ $row->golongan->nama_golongan }}
                                        </h4>
                                    </div><!-- end card header -->

                                    <div class="card-body">
                                        <div id="#customerList">
                                            <div class="row g-4 mb-3">
                                                <div class="col-sm-auto">
                                                </div>
                                                <div class="col-sm">
                                                    <div class="d-flex justify-content-sm-end">
                                                        <div class="search-box ms-2">
                                                            <input type="text" class="form-control search"
                                                                placeholder="Search...">
                                                            <i class="ri-search-line search-icon"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="table-responsive table-card mt-3 mb-1">
                                                <table class="table align-middle table-nowrap" id="customerTable">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>NO</th>
                                                            <th class="sort" data-sort="customer_name">NIK</th>
                                                            <th class="sort" data-sort="email">NAMA</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="list form-check-all">
                                                        @forelse ($listPendaftar as $i => $row)
                                                            <tr>
                                                                <td>{{ ++$i }}</td>
                                                                <td class="customer_name">{{ $row->user->nik }}
                                                                </td>
                                                                <td class="email">{{ $row->nama }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                <div class="noresult" style="display: none">
                                                    <div class="text-center">
                                                        <lord-icon src="https://cdn.lordicon.com/msoeawqm.json"
                                                            trigger="loop" colors="primary:#121331,secondary:#08a88a"
                                                            style="width:75px;height:75px">
                                                        </lord-icon>
                                                        <h5 class="mt-2">Sorry! No Result Found</h5>
                                                        <p class="text-muted mb-0">We've searched more than 150+ Orders
                                                            We
                                                            did not find any
                                                            orders for you search.</p>
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
                                        </div>
                                    </div><!-- end card -->
                                </div>
                                <!-- end col -->
                            </div>
                            <!-- end col -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="modal fade" id="listPendaftarUKT{{ $row->id }}" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-light p-3">
                        <h5 class="modal-title" id="exampleModalLabel"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            id="close-modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title mb-0">LIST PENDAFTAR UKT
                                            {{ $row->golongan->nama_golongan }}
                                        </h4>
                                    </div><!-- end card header -->

                                    <div class="card-body">
                                        <div id="#customerList">
                                            <div class="row g-4 mb-3">
                                                <div class="col-sm-auto">
                                                </div>
                                                <div class="col-sm">
                                                    <div class="d-flex justify-content-sm-end">
                                                        <div class="search-box ms-2">
                                                            <input type="text" class="form-control search"
                                                                placeholder="Search...">
                                                            <i class="ri-search-line search-icon"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="table-responsive table-card mt-3 mb-1">
                                                <table class="table align-middle table-nowrap" id="customerTable">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>NO</th>
                                                            <th class="sort" data-sort="customer_name">NIK</th>
                                                            <th class="sort" data-sort="email">NAMA</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="list form-check-all">
                                                        <tr>
                                                            <div class="noresult" style="display: none">
                                                                <div class="text-center">
                                                                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json"
                                                                        trigger="loop"
                                                                        colors="primary:#121331,secondary:#08a88a"
                                                                        style="width:75px;height:75px">
                                                                    </lord-icon>
                                                                    <h5 class="mt-2">Sorry! No Result Found</h5>
                                                                    <p class="text-muted mb-0">We've searched more than
                                                                        150+ Orders
                                                                        We
                                                                        did not find any
                                                                        orders for you search.</p>
                                                                </div>
                                                            </div>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div><!-- end card -->
                                </div>
                                <!-- end col -->
                            </div>
                            <!-- end col -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforelse
    @foreach ($ukt as $i => $row)
        <!-- Modal Add Pendaftar -->
        <div class="modal fade" id="addPendaftarUKT{{ $row->id }}" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-light p-3">
                        <h5 class="modal-title" id="exampleModalLabel"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            id="close-modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title mb-0">ADD PENDAFTAR UKT
                                            {{ $row->golongan->nama_golongan }}
                                            {{ $row->id }}
                                        </h4>
                                    </div><!-- end card header -->
                                    <form action="{{ route('pendaftarCreateUKT.ukt') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="ukt_id" value="{{ $row->id }}">
                                        <input type="hidden" name="nominal_ukt"
                                            value="{{ $nominal_ukt->nominal_reguler }}">
                                        <div class="card-body">
                                            <div id="customerList">
                                                <div class="row g-4 mb-3">
                                                    <div class="col-sm-auto">
                                                        <div>
                                                            <button type="submit" class="btn btn-success add-btn"><i
                                                                    class="ri-add-line align-bottom me-1"></i>Submit</button>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm">
                                                        <div class="d-flex justify-content-sm-end">
                                                            <div class="search-box ms-2">
                                                                <input type="text" class="form-control search"
                                                                    placeholder="Search...">
                                                                <i class="ri-search-line search-icon"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="table-responsive table-card mt-3 mb-1">
                                                    <table class="table align-middle table-nowrap" id="customerTable">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th>NO</th>
                                                                <th scope="col" style="width: 50px;">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            id="checkAll" value="option">
                                                                    </div>
                                                                </th>
                                                                <th class="sort" data-sort="customer_name">NIK
                                                                </th>
                                                                <th class="sort" data-sort="email">NAMA
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="list form-check-all">
                                                            @foreach ($addPendaftar as $i => $data)
                                                                <tr>
                                                                    <td>{{ ++$i }}</td>
                                                                    <th scope="row">
                                                                        <div class="form-check">
                                                                            <input class="form-check-input"
                                                                                type="checkbox" name="pendaftar"
                                                                                value="{{ $data->id }}">
                                                                        </div>
                                                                    </th>
                                                                    <td class="customer_name">
                                                                        {{ $data->User->nik }}</td>
                                                                    <td class="email">
                                                                        {{ $data->nama }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>

                                                    <div class="noresult" style="display: none">
                                                        <div class="text-center">
                                                            <lord-icon src="https://cdn.lordicon.com/msoeawqm.json"
                                                                trigger="loop" colors="primary:#121331,secondary:#08a88a"
                                                                style="width:75px;height:75px">
                                                            </lord-icon>
                                                            <h5 class="mt-2">Sorry! No Result
                                                                Found</h5>
                                                            <p class="text-muted mb-0">We've
                                                                searched more than 150+ Orders
                                                                We
                                                                did not find any
                                                                orders for you search.</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="d-flex justify-content-center">
                                                    <div class="pagination-wrap hstack gap-2">
                                                        <a class="page-item pagination-prev disabled" href="#">
                                                            Previous
                                                        </a>
                                                        <ul class="pagination listjs-pagination mb-0">
                                                        </ul>
                                                        <a class="page-item pagination-next" href="#">
                                                            Next
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- end card -->
                                    </form>
                                </div>
                                <!-- end col -->
                            </div>
                            <!-- end col -->
                        </div>
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
