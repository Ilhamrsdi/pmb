@extends('layouts.master')
@section('title')
  @lang('Pendaftar')
@endsection
@section('content')
  @component('components.breadcrumb')
    @slot('li_1')
      Calon Maba
    @endslot
    @slot('title')
      Pendaftar
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
        <div id="customerList#">
          <div class="card-header">
            <div class="row g-4">
              <div class="col-sm-auto">
                <h4 class="card-title mt-2">DATA TES MABA</h4>
              </div>
            </div>
          </div><!-- end card header -->
          <div class="card-body">
            <div class="row g-4 mb-3">
              <div class="col-sm-auto">
                <div>
                  <button type="button" class="btn btn-primary add-btn" data-bs-toggle="modal" id="create-btn"
                    data-bs-target="#addModal"><i class="ri-add-line align-bottom me-1"></i>Tambah Tes</button>
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
                        <input class="form-check-input" type="checkbox" id="checkAll" value="option">
                      </div>
                    </th>
                    <td class="id" style="display:none;"><a href="javascript:void(0);"
                        class="fw-medium link-primary">#VZ2101</a></td>
                    <th class="sort" data-sort="email">MATA PELAJARAN</th>
                    <th class="sort" data-sort="email">HASI TES</th>
                    <th class="sort" data-sort="email">DATA SOAL</th>
                    <th class="sort" data-sort="action">AKSI</th>
                  </tr>
                </thead>
                <tbody class="list form-check-all">
                  @foreach ($tes_maba as $i => $row)
                    <tr>
                      <td>{{ ++$i }}</td>
                      <th scope="row">
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" name="checkAll" value="option1">
                        </div>
                      </th>
                      <td class="id" style="display:none;"><a href="javascript:void(0);"
                          class="fw-medium link-primary">#VZ2101</a></td>
                      <td class="email">{{ $row->nama_mapel }}</td>
                      <td>
                        <a type="button" class="btn btn-success btn-label waves-effect waves-light"><i
                            class="ri-bank-card-line label-icon align-middle fs-16 me-2"></i>DATA
                          HASIL</a>
                      </td>
                      <td>
                        <a href="{{ route('soal-tes-maba.show', $row->id) }}" type="button"
                          class="btn btn-secondary btn-label waves-effect waves-light"><i
                            class="ri-bank-card-line label-icon align-middle fs-16 me-2"></i>DATA
                          SOAL</a>
                      </td>
                      <td>
                        <div class="d-flex gap-2">
                          <div class="edit">
                            <button type="button" class="btn btn-warning btn-icon waves-effect waves-light rounded-pill"
                              data-bs-toggle="modal" data-bs-target="#editModal{{ $row->id }}"><i
                                class="ri-edit-box-line"></i></button>
                          </div>
                          {{-- <div class="remove">
                                                        <button type="button"
                                                            class="btn btn-danger btn-icon waves-effect waves-light rounded-pill"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#deleteRecordModal{{ $row->id }}"><i
                                                                class="ri-delete-bin-fill"></i></button>
                                                    </div> --}}
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
        <form action="{{ route('tes-maba.store') }}" method="POST">
          @csrf
          <div class="modal-body">
            <div class="mb-3" id="modal-id" style="display: none;">
              <label for="id-field" class="form-label">ID</label>
              <input type="text" id="id-field" class="form-control" placeholder="ID" readonly />
            </div>

            <div class="mb-3">
              <label for="email-field" class="form-label">KODE MAPEL</label>
              <input type="text" name="kode_mapel" id="date-field" class="form-control" required />
            </div>
            <div class="mb-3">
              <label for="email-field" class="form-label">NAMA MAPEL</label>
              <input type="text" name="nama_mapel" id="date-field" class="form-control" required />
            </div>
            <div class="mb-3">
              <label for="email-field" class="form-label">JUMLAH SOAL</label>
              <input type="number" name="jumlah_soal" id="date-field" class="form-control" required />
            </div>
            <div class="mb-3">
              <label for="email-field" class="form-label">TANGGAL TES</label>
              <input type="date" class="form-control" min='<?php echo date('Y-m-d'); ?>' name="tanggal_tes" id="date-field"
                class="form-control" required />
            </div>
            <div class="mb-3">
              <label for="email-field" class="form-label">WAKTU TES</label>
              <input type="time" name="waktu_tes" id="date-field" class="form-control" required />
            </div>
          </div>
          <div class="modal-footer">
            <div class="hstack gap-2 justify-content-end">
              <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" id="add-btn">Tambah Tes</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Modal Edit -->
  @foreach ($tes_maba as $row)
    <div class="modal fade" id="editModal{{ $row->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-light p-3">
            <h5 class="modal-title" id="exampleModalLabel"></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
              id="close-modal"></button>
          </div>
          <form action="{{ route('tes-maba.update', $row->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-body">
              < <div class="mb-3" id="modal-id" style="display: none;">
                <label for="id-field" class="form-label">ID</label>
                <input value=" {{ $row->id }} " type="text" id="id-field" class="form-control"
                  placeholder="ID" readonly />
            </div>

            <div class="mb-3">
              <label for="email-field" class="form-label">KODE MAPEL</label>
              <input value=" {{ $row->kode_mapel }} " type="text" name="kode_mapel" id="date-field"
                class="form-control" required />
            </div>
            <div class="mb-3">
              <label for="email-field" class="form-label">NAMA MAPEL</label>
              <input value=" {{ $row->nama_mapel }} " type="text" name="nama_mapel" id="date-field"
                class="form-control" required />
            </div>
            <div class="mb-3">
              <label for="email-field" class="form-label">JUMLAH SOAL</label>
              <input value=" {{ $row->jumlah_soal }} " type="number" name="jumlah_soal" id="date-field"
                class="form-control" required />
            </div>
            <div class="mb-3">
              <label for="email-field" class="form-label">TANGGAL TES</label>
              <input value=" {{ $row->tanggal_tes }} " type="date" class="form-control" min='<?php echo date('Y-m-d'); ?>'
                name="tanggal_tes" id="date-field" class="form-control" required />
            </div>
            <div class="mb-3">
              <label for="email-field" class="form-label">WAKTU TES</label>
              <input value=" {{ $row->waktu_tes }} " type="time" name="waktu_tes" id="date-field"
                class="form-control" required />
            </div>
        </div>
        <div class="modal-footer">
          <div class="hstack gap-2 justify-content-end">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-warning" id="add-btn">Edit Tes Maba</button>
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
            <form action="{{ route('tes-maba.destroy', $row->id) }}" method="POST" enctype="multipart/form-data">
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
                <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
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
