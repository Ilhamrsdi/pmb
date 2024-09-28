@extends('layouts.master')
@section('title')
  @lang('BERKAS PENDAFTARAN')
@endsection
@section('content')
  @component('components.breadcrumb')
    @slot('li_1')
      Admin
    @endslot
    @slot('title')
      Berkas Pendaftaran
    @endslot
  @endcomponent
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title mb-0">Add, Edit & Remove</h4>
        </div><!-- end card header -->

        <div class="card-body">
          <div id="customerList">
            <div class="row g-4 mb-3">
              <div class="col-sm-auto">
                <div>
                  <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" id="create-btn"
                    data-bs-target="#showModal"><i class="ri-add-line align-bottom me-1"></i> Add</button>
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
                    <th>NO</th>
                    <th class="sort" data-sort="customer_name" hidden></th>
                    <th class="sort" data-sort="date" hidden></th>
                    <th class="sort" data-sort="email" hidden></th>
                    <th class="sort" data-sort="phone">NAMA BERKAS</th>
                    <th class="sort" data-sort="status">PATH</th>
                    <th class="sort" data-sort="action">Action</th>
                  </tr>
                </thead>
                <tbody class="list form-check-all">

                  @forelse($berkas as $index => $g)
                    <tr>
                      <th>{{ ++$index }}</th>
                      <td class="customer_name" hidden></td>
                      <td class="date" hidden></td>
                      <td class="email" hidden></td>
                      <td class="phone">{{ $g->nama_berkas }}</td>
                      <td class="status"><span>{{ $g->path }}</span></td>
                      <td>
                        <div class="d-flex gap-2">
                          <div class="edit">
                            <button class="btn btn-sm btn-success edit-item-btn" data-bs-toggle="modal"
                              data-bs-target="#showModalEdit{{ $g->id }}">Edit</button>
                          </div>
                          <div class="remove">
                            <button class="btn btn-sm btn-danger remove-item-btn" data-bs-toggle="modal"
                              data-bs-target="#deleteRecordModal{{ $g->id }}">Remove</button>
                          </div>

                        </div>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="6" class="text-center">
                        Data Kosong
                      </td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
              <div class="noresult" style="display: none">
                <div class="text-center">
                  <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                    colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px">
                  </lord-icon>
                  <h5 class="mt-2">Sorry! No Result Found</h5>
                  <p class="text-muted mb-0">We've searched more than 150+ Orders We did not find any
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
  <!-- end row -->


  <!-- modal add -->
  <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-light p-3">
          <h5 class="modal-title" id="exampleModalLabel"></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
        </div>
        <form action="{{ route('settingberkas.store') }}" method="post">
          @csrf
          <div class="modal-body">

            <div class="mb-3">
              <label for="id-field" class="form-label">Nama Berkas</label>
              <input required name="nama_berkas" type="text" class="form-control" placeholder="Masukkan Nama Berkas" />
            </div>
            <div class="mb-3">
              <label for="id-field" class="form-label">Path</label>
              <input required name="path" type="text" class="form-control"
                placeholder="Masukkan Nama Folder Untuk Menyimpan Berkas" />
            </div>
          </div>
          <div class="modal-footer">
            <div class="hstack gap-2 justify-content-end">
              <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
              <button type="submit" class="btn btn-success" id="add-btn">Tambah Berkas</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- modal add -->
  @forelse($berkas as $index => $g)
    <!-- modal edit -->
    <div class="modal fade" id="showModalEdit{{ $g->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-light p-3">
            <h5 class="modal-title" id="exampleModalLabel">Edit Berkas {{ $g->nama_berkas }} -
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
              id="close-modal"></button>
          </div>
          <form action="{{ route('settingberkas.update', $g->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="modal-body">

              <div class="mb-3">
                <label for="id-field" class="form-label">Nama Berkas</label>
                <input value="{{ $g->nama_berkas }}" required name="nama_berkas" type="text" class="form-control"
                  placeholder="Masukkan Nama Berkas" />
              </div>
              <div class="mb-3">
                <label for="id-field" class="form-label">Path</label>
                <input value="{{ $g->path }}" required name="path" type="text" class="form-control"
                  placeholder="Masukkan Nama Folder Untuk Menyimpan Berkas" />
              </div>
            </div>
            <div class="modal-footer">
              <div class="hstack gap-2 justify-content-end">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-success" id="add-btn">Update Berkas</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- modal edit -->
  @empty
    @php
      echo 'Data Kosong';
    @endphp
  @endforelse

  <!-- modal delete -->
  @forelse($berkas as $index => $g)
    <form action="{{ route('settingberkas.destroy', $g->id) }}" method="post">
      @csrf
      @method('DELETE')
      <div class="modal fade zoomIn" id="deleteRecordModal{{ $g->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                id="btn-close"></button>
            </div>
            <div class="modal-body">
              <div class="mt-2 text-center">
                <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                  colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px">
                </lord-icon>
                <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                  <h4>Are you Sure ?</h4>
                  <p class="text-muted mx-4 mb-0">Are you Sure You want to Remove
                    {{ $g->nama_berkas }} -
                    {{ $g->path }} ?</p>
                </div>
              </div>
              <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn w-sm btn-danger " id="delete-record">Yes, Delete
                  It!</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  @empty
    @php
      echo 'Data Kosong';
    @endphp
  @endforelse
  <!-- modal delete -->
@endsection
@section('script')
  <script src="{{ URL::asset('assets/libs/prismjs/prismjs.js') }}"></script>
  <script src="{{ URL::asset('assets/libs/list.js/list.min.js') }}"></script>
  <script src="{{ URL::asset('assets/libs/list.pagination.js/list.pagination.min.js') }}"></script>

  <!-- listjs init -->
  <script src="{{ URL::asset('assets/js/pages/listjs.init.js') }}"></script>

  <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
