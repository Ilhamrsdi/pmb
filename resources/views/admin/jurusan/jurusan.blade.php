@extends('layouts.master')
@section('title')
  @lang('JURUSAN')
@endsection
@section('content')
  @component('components.breadcrumb')
    @slot('li_1')
      Admin
    @endslot
    @slot('title')
      Jurusan
    @endslot
  @endcomponent
  <div id="loading-overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 9999; text-align: center; color: white;">
    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
        <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <p style="margin-top: 10px;">Sedang memproses, harap tunggu...</p>
    </div>
</div>
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title mb-0">Add, Edit & Remove</h4>
        </div><!-- end card header -->

        <div class="card-body">
          <div id="jurusanList">
            <div class="row g-4 mb-3">
              <div class="col-sm-auto">
                <div>
                  {{-- <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" id="create-btn"
                    data-bs-target="#showModal"><i class="ri-add-line align-bottom me-1"></i> Add</button> --}}
                    <a href="#" class="btn btn-info btn-sync">
                      <i class="ri-refresh-line align-bottom me-1"></i> Sync
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
                    <th>NO</th>
                    <th class="sort text-center" data-sort="nama">NAMA JURUSAN</th>
                    <th class="sort text-center" data-sort="alias">NAMA ALIAS</th>
                    <th class="sort text-center" data-sort="status">STATUS</th>
                    {{-- <th class="text-center">ACTION</th> --}}
                  </tr>
                </thead>
                <tbody class="list form-check-all">
                  @forelse($jurusan as $index => $g)
                    <tr>
                      <th>{{ ++$index }}</th>

                      <td class="nama">{{ $g->nama_jurusan }}</td>
                      <td class="alias text-center">{{ $g->alias_jurusan }}</td>
                      <td class="status text-center">
                        <span
                          class="badge text-uppercase {{ $g->status == 'aktif' ? 'badge-soft-success' : 'badge-soft-danger' }}">
                          {{ $g->status != null ? $g->status : 'nonaktif' }}
                        </span>
                      </td>

                      {{-- <td>
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
                      </td> --}}
                    </tr>
                  @empty
                    <tr>
                      <td colspan="4" class="text-center">Data Kosong</td>
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
        <form action="{{ route('jurusan.store') }}" method="post">
          @csrf
          <div class="modal-body">
            <div class="mb-3">
              <label for="id-field" class="form-label">Nama Jurusan</label>
              <input required name="nama_jurusan" type="text" class="form-control" placeholder="nama_jurusan" />
            </div>
            <div class="mb-3">
              <label for="id-field" class="form-label">Nama Alias</label>
              <input required name="alias_jurusan" type="text" class="form-control" placeholder="alias_jurusan" />
            </div>
            <div class="mb-3">
              <label for="id-field" class="form-label">Nama Jurusan</label>
              select
            </div>
            <!-- <div class="mb-3" >                                                                                     </div> -->
          </div>
          <div class="modal-footer">
            <div class="hstack gap-2 justify-content-end">
              <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
              <button type="submit" class="btn btn-success" id="add-btn">Tambah Jurusan</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- modal add -->
  @forelse($jurusan as $index => $g)
    <!-- modal edit -->
    <div class="modal fade" id="showModalEdit{{ $g->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-light p-3">
            <h5 class="modal-title" id="exampleModalLabel">Edit Jurusan {{ $g->nama_jurusan }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
              id="close-modal"></button>
          </div>
          <form action="{{ route('jurusan.update', $g->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="modal-body">
              <div class="mb-3">
                <label for="id-field" class="form-label">Kode Jurusan</label>
                <input value="{{ $g->kode_jurusan }}" required name="kode_jurusan" type="text"
                  class="form-control" placeholder="kode_jurusan" />
              </div>
              <div class="mb-3">
                <label for="id-field" class="form-label">Nama Jurusan</label>
                <input value="{{ $g->nama_jurusan }}" required name="nama_jurusan" type="text"
                  class="form-control" placeholder="nama_jurusan" />
              </div>
              <!-- <div class="mb-3" >
                                                                                                                                               </div> -->
            </div>
            <div class="modal-footer">
              <div class="hstack gap-2 justify-content-end">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-success" id="add-btn">Update Jurusan</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- modal edit -->
  @empty
    @php

    @endphp
  @endforelse

  <!-- modal delete -->
  @forelse($jurusan as $index => $g)
    <form action="{{ route('jurusan.destroy', $g->id) }}" method="post">
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
                  <p class="text-muted mx-4 mb-0">Are you Sure You want to Remove {{ $g->nama_jurusan }}
                    ?</p>
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

    @endphp
  @endforelse
  <!-- modal delete -->
@endsection
@section('script')
  <script src="{{ URL::asset('assets/libs/prismjs/prism.js') }}"></script>
  <script src="{{ URL::asset('assets/libs/list.js/list.min.js') }}"></script>
  <script src="{{ URL::asset('assets/libs/list.pagination.js/list.pagination.min.js') }}"></script>
  <!-- listjs init -->
  {{-- <script src="{{ URL::asset('assets/js/pages/listjs.init.js') }}"></script> --}}
  <script>
    var jurusanList,
      perPage = 5,
      options = {
        valueNames: ["nama", "alias", "status"],
        page: perPage,
        pagination: !0,
        plugins: [ListPagination({
          left: 2,
          right: 2
        })],
      };
    document.getElementById("jurusanList") &&
      (jurusanList = new List("jurusanList", options).on(
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

<script>
  $(document).on('click', '.btn-sync', function(e) {
   e.preventDefault();

   // Tampilkan overlay loading
   $('#loading-overlay').show();

   $.ajax({
       url: "{{ route('prodi.sync') }}",
       type: 'GET',
       beforeSend: function() {
           Swal.fire({
               title: 'Sedang menyinkronkan...',
               text: 'Mohon tunggu.',
               icon: 'info',
               showConfirmButton: false,
               allowOutsideClick: false
           });
       },
       success: function(response) {
           // Sembunyikan overlay loading
           $('#loading-overlay').hide();

           if (response.success) {
               // Perbarui tabel dengan HTML baru
               $('#CustomerList').html(response.html);

               // Tampilkan notifikasi sukses
               Swal.fire({
                   title: 'Berhasil!',
                   text: response.message,
                   icon: 'success',
                   confirmButtonText: 'OK'
               });
           } else {
               Swal.fire({
                   title: 'Gagal!',
                   text: 'Sinkronisasi gagal dilakukan.',
                   icon: 'error',
                   confirmButtonText: 'OK'
               });
           }
       },
       error: function() {
           // Sembunyikan overlay loading
           $('#loading-overlay').hide();

           Swal.fire({
               title: 'Error!',
               text: 'Terjadi kesalahan, coba lagi.',
               icon: 'error',
               confirmButtonText: 'OK'
           });
       }
   });
});


 </script>  

  <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
