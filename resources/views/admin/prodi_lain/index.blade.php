@extends('layouts.master')
@section('title')
  @lang('PROGRAM STUDI')
@endsection
@section('content')
  @component('components.breadcrumb')
    @slot('li_1')
      Admin
    @endslot
    @slot('title')
      Program Studi
    @endslot
  @endcomponent
  {{-- <div id="loading-overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 9999; text-align: center; color: white;">
    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
        <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <p style="margin-top: 10px;">Sedang memproses, harap tunggu...</p>
    </div>
</div> --}}

  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title mb-0">Add, Edit & Remove</h4>
        </div><!-- end card header -->

        <div class="card-body">
          <div id="prodiList">
            <div class="row g-4 mb-3">
              <div class="col-sm-auto">
                <div>
                  <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" id="create-btn"
                    data-bs-target="#showModal"><i class="ri-add-line align-bottom me-1"></i> Add</button>
                    {{-- <a href="#" class="btn btn-info btn-sync">
                      <i class="ri-refresh-line align-bottom me-1"></i> Sync
                  </a>                   --}}
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
                    <th class="sort text-center" data-sort="nama">NAMA PRODI</th>
                    <th class="sort text-center" data-sort="jurusan">NAMA KAMPUS</th>
                    <th class="sort text-center" data-sort="jenjang">ALAMAT KAMPUS</th>
                    <th class="sort text-center" data-sort="kuotaditerima">WEBSITE KAMPUS</th>
                    <th class="text-center">AKSI</th>
                  </tr>
                </thead>
                <tbody class="list form-check-all">

                  @forelse($prodiLain as $index => $g)
                    <tr>
                      <th>{{ ++$index }}</th>
                      <td class="kode text-center">{{ $g->name }}</td>
                      <td class="nama text-center">{{ $g->kampus }}</td>
                      <td class="alamat text-center">{{ $g->alamat_kampus }}</td>
                      <td class="website text-center">{{ $g->website_kampus}}</td>
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
                <h5 class="modal-title" id="exampleModalLabel">Tambah Prodi Lain</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
            </div>
            <form action="{{ route('prodi-lain.store') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Prodi</label>
                        <input required name="name" type="text" class="form-control" placeholder="Nama program studi" />
                    </div>
                    <div class="mb-3">
                        <label for="kampus" class="form-label">Nama Kampus</label>
                        <input required name="kampus" type="text" class="form-control" placeholder="Nama kampus" />
                    </div>
                    <div class="mb-3">
                        <label for="alamat_kampus" class="form-label">Alamat</label>
                        <input required name="alamat_kampus" type="text" class="form-control" placeholder="Alamat kampus" />
                    </div>
                    <div class="mb-3">
                        <label for="telepon_kampus" class="form-label">No Telpon Kampus</label>
                        <input required name="telepon_kampus" type="number" min="0" class="form-control" placeholder="No Telpon Kampus" />
                    </div>
                    <div class="mb-3">
                        <label for="website_kampus" class="form-label">Website Kampus</label>
                        <input required name="website_kampus" type="text" class="form-control" placeholder="Website Kampus" />
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-success" id="add-btn">Tambah Prodi Lain</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

  <!-- modal add -->
  @forelse($prodiLain as $index => $g)
    <!-- modal edit -->
    <div class="modal fade" id="showModalEdit{{ $g->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-light p-3">
            <h5 class="modal-title" id="exampleModalLabel">Edit Prodi {{ $g->nama_program_studi }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
              id="close-modal"></button>
          </div>
          <form action="{{ route('prodi.update', $g->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="modal-body">
              <div>
                <label for="jurusan_id-field" class="form-label">Jurusan</label>
                <select class="form-control" data-trigger required name="jurusan_id" id="jurusan_id-field">
                  <option value="">- Pilih Jurusan -</option>
                  @forelse($prodiLain as $index => $h)
                    <option value="{{ $h->id }}" {{ $h->id == $g->jurusan_id ? 'selected' : '' }}>
                      {{ $h->nama_jurusan }}</option>
                  @empty
                  @endforelse
                </select>
              </div>
              <div class="mb-3">
                <label for="id-field" class="form-label">Kode NIM Prodi</label>
                <input value="{{ $g->kode_program_studi }}" required name="kode_program_studi" type="text"
                  class="form-control" placeholder="kode_program_studi" />
              </div>
              <div class="mb-3">
                <label for="id-field" class="form-label">Nama Prodi</label>
                <input value="{{ $g->nama_program_studi }}" required name="nama_program_studi" type="text"
                  class="form-control" placeholder="nama_program_studi" />
              </div>
              <div>
                <label for="jenjang_pendidikan-field" class="form-label">Jenjang Pendidikan</label>
                <select class="form-control" data-trigger required name="jenjang_pendidikan"
                  id="jenjang_pendidikan-field">
                  <option value="">Status</option>
                  <option value="D3" {{ $g->jenjang_pendidikan == 'D3' ? 'selected' : '' }}>D3
                  </option>
                  <option value="D4" {{ $g->jenjang_pendidikan == 'D4' ? 'selected' : '' }}>D4
                  </option>
                </select>
              </div>
              <!-- <div class="mb-3" >
                                                                                                                        <label for="id-field" class="form-label">Jenjang Pendidikan</label>
                                                                                                                        <input required name="jenjang_pendidikan" type="text"  class="form-control" placeholder="jenjang_pendidikan"  />
                                                                                                                    </div> -->
              <div class="mb-3">
                <label for="id-field" class="form-label">Akreditasi</label>
                <input value="{{ $g->akreditasi }}" required name="akreditasi" type="text" class="form-control"
                  placeholder="akreditasi" />
              </div>
              <div>
                <label for="status-field" class="form-label">Status</label>
                <select class="form-control" data-trigger required name="status" id="status-field">
                  <option value="">Status</option>
                  <option value="Active" {{ $g->status == 'Active' ? 'selected' : '' }}>Active</option>
                  <option value="Block" {{ $g->status == 'Block' ? 'selected' : '' }}>Block</option>
                </select>
              </div>
              <div class="mb-3">
                <label for="id-field" class="form-label">Kode NIM</label>
                <input value="{{ $g->kode_nim }}" required name="kode_nim" type="text" class="form-control"
                  placeholder="kode_nim" />
              </div>
              <div class="mb-3">
                <label for="id-field" class="form-label">Nomor Urut NIM</label>
                <input value="{{ $g->nomer_urut_nim }}" required name="nomer_urut_nim" type="number" min="0"
                  class="form-control" placeholder="nomer_urut_nim" />
              </div>
            </div>
            <div class="modal-footer">
              <div class="hstack gap-2 justify-content-end">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-success" id="add-btn">Update Prodi</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- modal edit -->
  @empty
  @endforelse

  <!-- modal delete -->
  @forelse($prodiLain as $index => $g)
    <form action="{{ route('prodi.destroy', $g->id) }}" method="post">
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
                    {{ $g->nama_program_studi }} ?</p>
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
    var prodiList,
      perPage = 5,
      options = {
        valueNames: ["nama", "kode", 'jurusan', "jenjang", 'akreditasi', 'status'],
        page: perPage,
        pagination: !0,
        plugins: [ListPagination({
          left: 2,
          right: 2
        })],
      };
    document.getElementById("prodiList") &&
      (prodiList = new List("prodiList", options).on(
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
                $('#table-prodi').html(response.html);

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
