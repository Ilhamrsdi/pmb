@extends('layouts.master')
@section('title')
  @lang('PENGUMUMAN ')
@endsection
@section('content')
  @component('components.breadcrumb')
    @slot('li_1')
      Admin
    @endslot
    @slot('title')
      Pengumuman
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
                    data-bs-target="#addModal"><i class="ri-add-line align-bottom me-1"></i> Add</button>
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
                    <th class="sort" data-sort="customer_name">JUDUL PENGUMUMAN</th>
                    <th class="sort" data-sort="date">TGL PENGUMUMAN</th>
                    <th class="sort" data-sort="email" hidden></th>
                    <th class="sort" data-sort="phone" hidden></th>
                    <th class="sort" data-sort="status" hidden></th>
                    <th class="sort" data-sort="action">AKSI</th>
                  </tr>
                </thead>
                <tbody class="list form-check-all">
                  @forelse($pengumuman as $index => $g)
                    <tr>
                      <td>{{ ++$index }}</td>
                      <td class="customer_name">{{ $g->judul_pengumuman }}</td>
                      <td class="date">{{ date('l ,d-m-Y', strtotime($g->tanggal_pengumuman)) }}
                      </td>
                      <td class="email" hidden></td>
                      <td class="phone" hidden></td>
                      <td class="status" hidden><span></span></td>
                      <td>
                        <div class="d-flex gap-2">
                          <div class="detail">
                            <button class="btn btn-sm btn-primary edit-item-btn" data-bs-toggle="modal"
                              data-bs-target="#detailModalEdit{{ $g->id }}">Detail</button>
                          </div>
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
                    @empty
                      @php
                        echo 'Data Kosong';
                      @endphp
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
  <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-light p-3">
          <h5 class="modal-title" id="exampleModalLabel"></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
        </div>
        <form action="{{ route('pengumuman.store') }}" method="post">
          @csrf
          <div class="modal-body">
            <div class="mb-3">
              <label for="id-field" class="form-label">JUDUL PENGUMUMAN</label>
              <input required name="judul_pengumuman" type="text" class="form-control"
                placeholder="Judul Pengumuman" />
            </div>
            <div class="mb-3">
              <label for="id-field" class="form-label">TANGGAL PENGUMUMAN</label>
              <input required name="tanggal_pengumuman" type="date" class="form-control"
                placeholder="Tanggal Pengumuman" />
            </div>
            <div class="mb-3">
              <label for="id-field" class="form-label">ISI PENGUMUMAN</label>
              {{-- <textarea type="text" name="isi_pengumuman" id="date-field" class="form-control" rows="5"
                                style="resize: none" required></textarea> --}}
              <textarea name="isi_pengumuman" class="ckeditor-classic-1"></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <div class="hstack gap-2 justify-content-end">
              <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
              <button type="submit" class="btn btn-success" id="add-btn">Tambah Pengumuman</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- modal Edit -->
  @forelse($pengumuman as $index => $g)
    <!-- modal Detail -->
    <div class="modal fade" id="detailModalEdit{{ $g->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header bg-light p-3">
            <h5 class="modal-title" id="exampleModalLabel">Detail Pengumuman {{ $g->judul_pengumuman }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
              id="close-modal"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="id-field" class="form-label">JUDUL PENGUMUMAN</label>
              <input value="{{ $g->judul_pengumuman }}" required type="text" class="form-control"
                placeholder="Judul Pengumuman" readonly />
            </div>
            <div class="mb-3">
              <label for="id-field" class="form-label">TANGGAL PENGUMUMAN</label>
              <input value="{{ $g->tanggal_pengumuman }}" required type="date" class="form-control"
                placeholder="Tanggal Pengumuman" readonly />
            </div>
            <div class="mb-3">
              <label for="id-field" class="form-label">ISI PENGUMUMAN</label>
              {{-- <textarea type="text" name="isi_pengumuman" id="date-field" class="form-control" rows="5"
                                style="resize: none" required readonly>{{ $g->isi_pengumuman }}</textarea> --}}
              <textarea class="ckeditor-classic-2">{{ $g->isi_pengumuman }}</textarea>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- modal edit -->
    <div class="modal fade" id="showModalEdit{{ $g->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header bg-light p-3">
            <h5 class="modal-title" id="exampleModalLabel">Edit Pengumuman {{ $g->judul_pengumuman }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
              id="close-modal"></button>
          </div>
          <form action="{{ route('pengumuman.update', $g->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="modal-body">
              <div class="mb-3">
                <label for="id-field" class="form-label">JUDUL PENGUMUMAN</label>
                <input value="{{ $g->judul_pengumuman }}" required name="judul_pengumuman" type="text"
                  class="form-control" placeholder="Judul Pengumuman" />
              </div>
              <div class="mb-3">
                <label for="id-field" class="form-label">TANGGAL PENGUMUMAN</label>
                <input value="{{ $g->tanggal_pengumuman }}" required name="tanggal_pengumuman" type="date"
                  class="form-control" placeholder="Tanggal Pengumuman" />
              </div>
              <div class="mb-3">
                <label for="id-field" class="form-label">ISI PENGUMUMAN</label>
                {{-- <textarea type="text" name="isi_pengumuman" class="form-control" rows="5" style="resize: none" required>{{ $g->isi_pengumuman }}</textarea> --}}
                <textarea name="isi_pengumuman" class="ckeditor-classic-3">{{ $g->isi_pengumuman }}</textarea>
              </div>
            </div>
            <div class="modal-footer">
              <div class="hstack gap-2 justify-content-end">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-success" id="add-btn">Update Pengumuman</button>
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
  @forelse($pengumuman as $index => $g)
    <form action="{{ route('pengumuman.destroy', $g->id) }}" method="post">
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
                    {{ $g->judul_pengumuman }}?</p>
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

  <!-- Form Editors -->
  <script src="{{ URL::asset('assets/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js') }}"></script>
  {{-- CK Editor --}}
  <script>
    for (let i = 1; i < 4; i++) {
      ClassicEditor.create(document.querySelector(".ckeditor-classic-" + i)).then(function(e) {
        e.ui.view.editable.element.style.height = "250px"
      }).catch(function(e) {
        console.error(e)
      })

    }
  </script>
  <!-- listjs init -->
  <script src="{{ URL::asset('assets/js/pages/listjs.init.js') }}"></script>
  <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
