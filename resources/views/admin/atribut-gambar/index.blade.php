@extends('layouts.master')
@section('title')
  @lang('Preview Gambar Atribut Maba')
@endsection
@section('content')
  @component('components.breadcrumb')
    @slot('li_1')
    Calon Maba
    @endslot
    @slot('title')
     Preview Gambar Atribut Maba
    @endslot
  @endcomponent
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title mb-0">Add, Edit & Remove</h4>
        </div><!-- end card header -->

        <div class="card-body">
          <div id="gelombangList">
            <div class="row g-4 mb-3">
              <div class="col-sm-auto">
                <div>
                  <button type="button" class="btn btn-primary add-btn" data-bs-toggle="modal" id="create-btn"
                    data-bs-target="#showModal"><i class="ri-add-line align-bottom me-1"></i>Tambah Gambar Atribut</button>
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
                    <th class="sort text-center" data-sort="jenis_gambar">JENIS GAMBAR</th>
                    <th class="text-center" data-sort="nama_gambar">GAMBAR</th>
                    <th class="text-center" data-sort="ukuran">UKURAN</th>
                    <th class="text-center" data-sort="aksi">AKSI</th>
                  </tr>
                </thead>
                <tbody class="list form-check-all">

                  @forelse($atributGambars as $index => $g)
                    <tr>
                      <th>{{ ++$index }}</th>
                      <td class="jenis_gambar">{{ $g->jenis_gambar }}</td>
                      <td class="nama_gambar text-center">
                        <a href="{{ asset('uploads/atribut-gambars/' . $gambar->nama_gambar) }}" target="_blank">
                            Lihat Gambar
                        </a>
                      </td>
                      <td class="tanggal_mulai text-center">{{ $g->ukuran}}
                      </td>
                      <td>
                        <div class="d-flex gap-2">
                          <div class="edit" z>
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
  <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-light p-3">
          <h5 class="modal-title" id="exampleModalLabel"></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
        </div>
        <form action="{{ route('atribut-gambars.store') }}" method="post">
          @csrf
          <div class="modal-body">

            <div class="mb-3">
              <label for="id-field" class="form-label">Jenis Gambar</label>
              <input required name="jenis_gambar" type="text" class="form-control"
                placeholder="jenis_gambar" />
            </div>
            <div class="mb-3">
              <label for="id-field" class="form-label">File Gambar</label>
              <input required name="nama_gambar" type="file" class="form-control" placeholder="file_gambar" />
            </div>
            <div class="mb-3">
              <label for="id-field" class="form-label">Ukuruan</label>
              <input required name="ukuran" type="text" class="form-control" placeholder="ukuran" />
            </div>
          </div>
          <div class="modal-footer">
            <div class="hstack gap-2 justify-content-end">
              <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
              <button type="submit" class="btn btn-success" id="add-btn">Simpan</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- modal edit -->
  @forelse($atributGambars as $index => $g)
    <!-- modal edit -->
    <div class="modal fade" id="showModalEdit{{ $g->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-light p-3">
            <h5 class="modal-title" id="exampleModalLabel">Edit Gelombang {{ $g->jenis_gambar }} -
              {{ $g->ukuran }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
              id="close-modal"></button>
          </div>
          <form action="{{ route('atribut-gambars.edit', $g->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="modal-body">

              <div class="mb-3">
                <label for="id-field" class="form-label">Jenis Gambar Atribut</label>
                <input value="{{ $g->jenis_gambar }}" required name="jenis_gambar" type="text"
                  class="form-control" placeholder="jenis_gambar" />
              </div>
              <div class="mb-3">
                <label for="id-field" class="form-label">File Gambar</label>
                <div class="input-group">
                    <input type="file" name="nama_gambar" class="form-control" />
                    <a href="{{ asset('storage/' . $g->nama_gambar) }}" target="_blank" class="btn btn-outline-secondary">Lihat Gambar</a>
                </div>
            </div>
            
              <div class="mb-3">
                <label for="id-field" class="form-label">Ukuran</label>
                <input value="{{ $g->ukuran }}" required name="ukuran" type="text"
                  class="form-control" placeholder="ukuran" />
              </div>
            </div>
            <div class="modal-footer">
              <div class="hstack gap-2 justify-content-end">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-success" id="add-btn">Update</button>
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
  @forelse($atributGambars as $index => $g)
    <form action="{{route('atribut-gambars.destroy', $g->id)  }}" method="post">
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
                    {{ $g->jenis_gambar }} -
                    {{ $g->ukuran }} ?</p>
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
  @foreach ($atributGambars as $i => $row)
    <!-- Modal Add Pendaftar -->
  @endforeach
@endsection
@section('script')
  <script src="{{ URL::asset('assets/libs/prismjs/prism.js') }}"></script>
  <script src="{{ URL::asset('assets/libs/list.js/list.min.js') }}"></script>
  <script src="{{ URL::asset('assets/libs/list.pagination.js/list.pagination.min.js') }}"></script>
  <!-- listjs init -->
  {{-- <script src="{{ URL::asset('assets/js/pages/listjs.init.js') }}"></script> --}}
  <script>
    var gelombangList,
      perPage = 5,
      options = {
        valueNames: ["nama", "tahun", 'tanggal_mulai', "tanggal_selesai", 'deskripsi', 'nominal', 'kuota', 'status'],
        page: perPage,
        pagination: !0,
        plugins: [ListPagination({
          left: 2,
          right: 2
        })],
      };
    document.getElementById("gelombangList") &&
      (gelombangList = new List("gelombangList", options).on(
        "updated",
        function(e) {
          0 == e.matchingItems.length ?
            (document.getElementsByClassName(
              "noresult"
            )[0].style.display = "block") :
            (document.getElementsByClassName(
              "noresult"
            )[0].style.display = "none");
          var t = 1 == e.i,
            a = e.i > e.matchingItems.length - e.page;
          document.querySelector(".pagination-prev.disabled") &&
            document
            .querySelector(".pagination-prev.disabled")
            .classList.remove("disabled"),
            document.querySelector(".pagination-next.disabled") &&
            document
            .querySelector(".pagination-next.disabled")
            .classList.remove("disabled"),
            t &&
            document
            .querySelector(".pagination-prev")
            .classList.add("disabled"),
            a &&
            document
            .querySelector(".pagination-next")
            .classList.add("disabled"),
            e.matchingItems.length <= perPage ?
            (document.querySelector(
              ".pagination-wrap"
            ).style.display = "none") :
            (document.querySelector(
              ".pagination-wrap"
            ).style.display = "flex"),
            e.matchingItems.length == perPage &&
            document
            .querySelector(".pagination.listjs-pagination")
            .firstElementChild.children[0].click(),
            0 < e.matchingItems.length ?
            (document.getElementsByClassName(
              "noresult"
            )[0].style.display = "none") :
            (document.getElementsByClassName(
              "noresult"
            )[0].style.display = "block");
        }
      ));

    document.querySelector(".pagination-next") &&
      document
      .querySelector(".pagination-next")
      .addEventListener("click", function() {
        !document.querySelector(".pagination.listjs-pagination") ||
          (document
            .querySelector(".pagination.listjs-pagination")
            .querySelector(".active") &&
            document
            .querySelector(".pagination.listjs-pagination")
            .querySelector(".active")
            .nextElementSibling.children[0].click());
      }),
      document.querySelector(".pagination-prev") &&
      document
      .querySelector(".pagination-prev")
      .addEventListener("click", function() {
        !document.querySelector(".pagination.listjs-pagination") ||
          (document
            .querySelector(".pagination.listjs-pagination")
            .querySelector(".active") &&
            document
            .querySelector(".pagination.listjs-pagination")
            .querySelector(".active")
            .previousSibling.children[0].click());
      });
  </script>

  <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
