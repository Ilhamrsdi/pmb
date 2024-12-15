@extends('layouts.master')
@section('title')
  @lang('Data User ')
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
      Data User
    @endslot
    @slot('title')
      Master Data User
    @endslot
  @endcomponent
  @if (Session::has('success'))
    <div class="alert alert-success">
      <strong>Success: </strong>{{ Session::get('success') }}
    </div>
  @endif
        <div class="row">
          <div class="col-lg-12">
            <div id="#customerList">
              <a href="{{ route('users.create') }}" class="btn btn-success">Create New User</a>
            <div class="card">
                <div id="customerList">
                <div class="card-header">
                <div class="row g-4">
                    <div class="col-sm-auto">
                        <h4 class="card-title mt-2">Data USER</h4>
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
              </div>
              <!-- end card header -->
              <div class="card-body">
                <div class="table-responsive table-card mt-3 mb-1">
                  <table class="table align-middle table-nowrap" id="customerTable">
                    <thead class="table-light">
                      <tr>
                        <th>ID</th>
                        {{-- <th scope="col" style="width: 50px;">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="checkAll"
                                                            value="option">
                                                    </div>
                                                </th> --}}
                        <th data-sort="customer_name">Nama</th>
                        <th data-sort="date">Email</th>
                        <th data-sort="email">Roles</th>
                        <th data-sort="action">AKSI</th>
                      </tr>
                    </thead>
                    <tbody class="list form-check-all" id="tbodyPendaftarID">
                      @foreach ($users as $user => $row)
                        <tr>
                          {{-- <th scope="row">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="checkAll"
                                                                value="option1">
                                                        </div>
                                                    </th> --}}
                          <td class="id" style="display:none;"><a href="javascript:void(0);"
                              class="fw-medium link-primary">#VZ2101</a></td>
                          <td class="customer_name">{{ $row->id }}</td>
                          {{-- <!--<td class="date">{{ $row->detailPendaftar->tanggal_daftar }}</td>--> --}}
                          <td class="name">
                          {{$row->username}}
                          </td>
                          <td class="email">{{ $row->email}}</td>
                          <td class="role">{{ $row->role?->roles }}</td>
                          <td>
                            <div class="d-flex gap-2">
                              <div class="edit">
                                <button type="button"
                                  class="btn btn-warning btn-icon waves-effect waves-light rounded-pill"
                                  data-bs-toggle="modal" data-bs-target="#showModal{{ $row->id }}"><i
                                    class="ri-information-line"></i></button>
                              </div>
                              <div class="remove">
                                <button type="button" class="btn btn-danger btn-icon waves-effect waves-light rounded-pill"
                                  data-bs-toggle="modal" data-bs-target="#deleteRecordModal{{ $row->id }}"><i
                                    class="ri-delete-bin-fill"></i></button>
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
        </div>
      </div>
  </div><!-- end card -->
  <!-- end row -->
  @foreach ($users as $row)
    <!--=================== Modal Show Data ========================-->
    <div class="modal fade" id="showModal{{ $row->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header bg-warning p-3">
            <h5 class="modal-title" id="exampleModalLabel">DETAIL DATA {{ $row->username }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
              id="close-modal"></button>
          </div>
          <div class="modal-body">
            <table class="table table-striped">
              <tbody>
                <tr>
                  <td style="width: 400px">NIK</td>
                  <td>{{ $row->user?->nik }}</td>
                </tr>
                <tr>
                  <td style="width: 400px">NAMA PENDAFTAR</td>
                  <td>{{ $row->username }}</td>
                </tr>
                <tr>
                  <td style="width: 400px">EMAIL</td>
                  <td>{{ $row->user?->email }}</td>
                </tr>
                <tr>
                  <td style="width: 400px">NO. TELP</td>
                  <td>{{ $row->no_hp }}</td>
                </tr>
                <tr>
                  <td style="width: 400px">ASAL SEKOLAH</td>
                  <td>{{ $row->sekolah }}</td>
                </tr>
                <tr>
                  <td style="width: 400px">KODE BAYAR PENDAFTARAN</td>
                  <td>{{ $row->detailPendaftar?->kode_pendaftaran }}</td>
                </tr>
                <tr>
                  <td style="width: 400px">NOMINAL PEMBAYARAN PENDAFTARAN</td>
                  <td>{{ $row->gelombangPendaftaran?->nominal_pendaftaran }}</td>
                </tr>
                <tr>
                  <td style="width: 400px">STATUS PENDAFTARAN</td>
                  @if ($row->detailPendaftar?->status_pendaftaran === 'belum')
                    <td><span class="badge badge-soft-danger text-uppercase">BELUM BAYAR</span></td>
                  @else 
                    <td><span class="badge badge-soft-success text-uppercase">SUDAH BAYAR</span></td>
                  @endif
                </tr>
                <tr>
                  <td style="width: 400px">KODE BAYAR UKT</td>
                  <td>{{ $row->detailPendaftar?->kode_bayar }}</td>
                </tr>
                <tr>
                  <td style="width: 400px">NOMINAL PEMBAYARAN UKT</td>
                  <td>{{ $row->detailPendaftar?->nominal_ukt }}</td>
                </tr>
                <tr>
                  <td style="width: 400px">STATUS UKT</td>
                  @if ($row->detailPendaftar?->status_ukt == 'belum')
                    <td><span class="badge badge-soft-danger text-uppercase">BELUM BAYAR</span></td>
                  @else
                    <td><span class="badge badge-soft-success text-uppercase">SUDAH BAYAR</span></td>
                  @endif
                </tr>
                <tr>
                  <td style="width: 400px">THN AJAR & GELOMBANG PENDAFTARAN</td>
                  <td>{{ $row->gelombangPendaftaran?->nama_gelombang . ' & ' . $row->gelombangPendaftaran?->tahun_ajaran }}
                  </td>
                </tr>
                <tr>
                  <td style="width: 400px">PEMBAYARAN MELALUI</td>
                  <td>{{ $row->detailPendaftar?->va_pendaftaran }}</td>
                </tr>
                <tr>
                  <td style="width: 400px">TGL DAFTAR</td>
                  <td>{{ $row->detailPendaftar?->tanggal_daftar }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <!--==================== Modal Delete Data =====================-->
    <div class="modal fade zoomIn" id="deleteRecordModal{{ $row->id }}" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
              id="btn-close"></button>
          </div>
          <div class="modal-body">
            <form action="{{ route('users.destroy', $row->id) }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('DELETE')
              <div class="mt-2 text-center">
                <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                  colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px">
                </lord-icon>
                <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                  <h4>Are you Sure ?</h4>
                  <p class="text-muted mx-4 mb-0">Are you Sure You want to Remove {{ $row->nama }} ?
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
      <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
        <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn w-sm btn-danger " id="delete-record">Yes, Delete
          It!</button>
      </div>
      </form>
    </div>
  @endforeach
  <!--end modal -->
  <!-- end row -->
@endsection
@section('script')
{{-- <script>
  $(document).ready(function() {
      // Menangkap perubahan pada dropdown status
      $(document).on('change', '.status-selector', function() {
          var id = $(this).data('id'); // Mengambil ID pendaftar dari data-id
          var status = $(this).val();  // Mengambil nilai status yang dipilih

          // Mengirimkan AJAX request untuk update status
          $.ajax({
              url: "{{ route('pendaftar.update-status') }}", // Route untuk update status
              type: "POST",
              data: {
                  _token: "{{ csrf_token() }}", // Token CSRF untuk keamanan
                  id: id,                       // ID pendaftar
                  status_pendaftaran: status    // Status yang dipilih
              },
              success: function(response) {
                  if (response.success) {
                      alert('Status berhasil diperbarui');
                  } else {
                      alert('Terjadi kesalahan, silakan coba lagi.');
                  }
              },
              error: function() {
                  alert('Gagal memperbarui status, silakan coba lagi.');
              }
          });
      });
  });
</script> --}}
  <!--=========================== Filter & Seearch on Select ===============================-->
  <script>
    //Form Select Search
    $('.form-select').select2({
      // theme: "bootstrap-5",
      width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
      placeholder: $(this).data('placeholder'),
    });
  </script>
  <!--=========================== End Filter & Seearch on Select ===========================-->
  <script src="{{ URL::asset('assets/libs/prismjs/prismjs.js') }}"></script>
  <script src="{{ URL::asset('assets/libs/list.js/list.min.js') }}"></script>
  <script src="{{ URL::asset('assets/libs/list.pagination.js/list.pagination.min.js') }}"></script>
  <!-- listjs init -->
  <script src="{{ URL::asset('assets/js/pages/listjs.init.js') }}"></script>
  <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
