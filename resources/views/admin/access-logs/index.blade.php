
@extends('layouts.master')
@section('title')
  @lang('LOGGING ')
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
      color: #444
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
      Lainnya
    @endslot
    @slot('title')
     Logging
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
                <form id="deleteAllLogsForm" method="POST" action="{{ route('access-logs.delete-all') }}">
                    @csrf
                    <button type="submit" class="btn btn-primary">Hapus Semua Log</button>
                </form>
                
                  <div class="table-responsive table-card mt-3 mb-1">
                      <table class="table align-middle table-nowrap" id="customerTable">
                          <thead class="table-light">
                              <tr>
                                  <th>No</th>
                                  <th>Pengguna</th>
                                  <th>Url</th>
                                  <th>Ip Address</th>
                                  <th>Waktu Akses</th>
                                  <th>Aksi</th>
                              </tr>
                          </thead>
                          <tbody class="list form-check-all" id="tbodyPendaftarID">
                            @foreach ($logs as $log)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $log->user ? $log->user->username : 'Guest' }}</td> <!-- Memastikan user ada -->
                                <td>{{ $log->url }}</td>
                                <td>{{ $log->ip_address }}</td>
                                <td>{{ $log->accessed_at }}</td>
                                <td>

                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('access-logs.destroy', $log->id) }}" method="POST" class="delete-form" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger delete-btn" data-id="{{ $log->id }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus log ini">
                                            Hapus
                                        </button>
                                        
                                    </form>                                    
                                </td>
                            </tr>
                        @endforeach
                          </tbody>
                      </table>
                  </div>
              
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
{{-- <script>
    // Konfirmasi penghapusan log dengan popup konfirmasi
    $(document).on('submit', '.delete-form', function(event) {
      event.preventDefault();
      var form = this;
  
      // Menampilkan konfirmasi penghapusan
      if (confirm('Apakah Anda yakin ingin menghapus log ini?')) {
        form.submit();  // Jika pengguna mengkonfirmasi, kirimkan form
      }
    });
  </script> --}}
  <script>
$.ajax({
    url: '/access-logs/' + logId,
    type: 'DELETE',
    data: {
        _token: '{{ csrf_token() }}'
    },
    success: function(response) {
        console.log(response); // Debugging output
        if (response.success) {
            Swal.fire(
                'Dihapus!',
                'Log berhasil dihapus.',
                'success'
            );
            $button.closest('tr').remove(); // Menghapus baris dari tabel
        } else {
            Swal.fire(
                'Gagal!',
                'Terjadi kesalahan, silakan coba lagi.',
                'error'
            );
        }
    },
    error: function(xhr, status, error) {
        console.error(xhr.responseText); // Debugging output
        Swal.fire(
            'Gagal!',
            'Terjadi kesalahan, silakan coba lagi.',
            'error'
        );
    }
});

  </script>
  <script>
    document.getElementById('deleteAllLogsForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Mencegah pengiriman form langsung
        
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Semua log akan dihapus permanen!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();  // Jika konfirmasi, kirim form
            }
        });
    });
    </script>
    
  
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

