@extends('layouts.master')
@section('title')
  @lang('LAPORAN PENERIMAAN')
@endsection
@section('css')
  {{-- <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" /> --}}
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
      Laporan
    @endslot
    @slot('title')
      Laporan Penerimaan
    @endslot
  @endcomponent
  <div class="row">
    <div class="col-lg-12">
      <div id="#pendaftarList">
        <div class="card">
          <div id="pendaftarList">
            <div class="card-header">
              <div class="row g-4">
                <div class="col-sm-auto">
                  <button onclick="printdiv('cetak')" type="button" class="btn btn-success"><i
                      class="ri-printer-line align-bottom me-1"></i>
                    Cetak</button>
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
            </div><!-- end card header -->
            <div class="card-body">
              <div class="table-responsive table-card mt-3 mb-1" id="cetak">
                <table class="table align-middle table-nowrap" id="customerTable">
                  <thead class="table-light">
                    <tr>
                      <th class="text-center">No</th>
                      <th data-sort="nik" class="text-center">NIK</th>
                      <th data-sort="nama" class="text-center">NAMA</th>
                      <th data-sort="gelombang" class="text-center">GELOMBANG</th>
                      <th data-sort="prodi" class="text-center">PROGRAM STUDI</th>
                      <th data-sort="status_ukt" class="text-center">NOMINAL UKT</th>
                      <th data-sort="acc_profil" class="text-center">ACC PROFIL</th>
                    </tr>
                  </thead>
                  <tbody class="list form-check-all" id="tbodyPendaftarID">
                    @foreach ($data as $i => $row)
                    <tr>
                      <td class="no">{{ $loop->iteration }}</td>
                      <td class="nik">{{ $row->user->nik }}</td>
                      <td class="nama">{{ $row->nama }}</td>
                      <td class="gelombang">
                          {{ $row->gelombangPendaftaran?->nama_gelombang . ' - Tahun ' . $row->gelombangPendaftaran?->tahun_ajaran }}
                      </td>
                      <td class="prodi">{{ $row->programStudi?->nama_program_studi }}</td>
                      <td class="status_ukt text-center">
                          <span class="badge text-uppercase {{ optional($row->detailPendaftar)->status_ukt == 'sudah' ? 'badge-soft-success' : 'badge-soft-danger' }}">
                              {{ optional($row->detailPendaftar)->status_ukt ?? 'belum' }}
                          </span>
                      </td>
                      <td class="acc_profil text-center">
                          <span class="badge text-uppercase {{ optional($row->detailPendaftar)->status_acc == 'sudah' ? 'badge-soft-success' : 'badge-soft-danger' }}">
                              {{ optional($row->detailPendaftar)->status_acc ?? 'belum' }}
                          </span>
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
      </div>
    </div>
  </div><!-- end card -->
  <!-- end row -->
@endsection
@section('script')
  <script src="{{ URL::asset('assets/libs/prismjs/prism.js') }}"></script>
  <script src="{{ URL::asset('assets/libs/list.js/list.min.js') }}"></script>
  <script src="{{ URL::asset('assets/libs/list.pagination.js/list.pagination.min.js') }}"></script>
  <!-- listjs init -->
  <script>
    var pendaftarList,
      perPage = 5,
      options = {
        valueNames: ["nik", "nama", "gelombang", "prodi", "status_ukt", "acc_profil"],
        page: perPage,
        pagination: !0,
        plugins: [ListPagination({
          left: 2,
          right: 2
        })],
      };
    document.getElementById("pendaftarList") &&
      (pendaftarList = new List("pendaftarList", options).on(
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
  {{-- <script src="{{ URL::asset('assets/js/pages/listjs.init.js') }}"></script> --}}
  <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>

  <script>
    // function printdiv(printpage) {
    //   var headstr =
    //     "<html><head><title>Laporan Penerimaan</title><style>body{background-color:#fff;}</style></head><body>";
    //   var footstr = "</body>";
    //   var newstr = document.all.item(printpage).innerHTML;
    //   var oldstr = document.body.innerHTML;
    //   document.body.innerHTML = headstr + newstr + footstr;
    //   window.print();
    //   document.body.innerHTML = oldstr;
    //   return false;
    // }
  </script>
@endsection
