
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
      Generate NIM Massal
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
                        <h4 class="card-title mt-2">Generate NIM Massal</h4>
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
                <form id="generate-nim-massal-form" action="{{ route('generate-nim.massal') }}" method="POST">
                  @csrf
                  <div class="table-responsive table-card mt-3 mb-1">
                      <table class="table align-middle table-nowrap" id="customerTable">
                          <thead class="table-light">
                              <tr>
                                  <th>ID</th>
                                  <th>Pilih</th>
                                  <th>Nama pendaftar</th>
                                  <th>NIM</th>
                                  <th>Program Studi</th>
                              </tr>
                          </thead>
                          <tbody class="list form-check-all" id="tbodyPendaftarID">
                              @foreach ($maba_ukt as $index => $row)
                              <tr>
                                
                                  <td>{{ $row->id }}</td>
                                  <td><input type="checkbox" name="id_pendaftar[]" value="{{ $row->id }}" class="form-check-input"></td>
                                  <td>{{ $row->nama }}</td>
                                  <td>{{ $row->nim }}</td>
                                  <td>{{ $row->programStudi?->nama_program_studi }}</td>
                              </tr>
                              @endforeach
                          </tbody>
                      </table>
                      <button type="submit" class="btn btn-success">Generate NIM Massal</button>
                  </div>
              </form>
              
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

