@extends('layouts.master')
@section('title')
  @lang('DATA PENDAFTAR ')
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
      Calon Maba
    @endslot
    @slot('title')
      Pendaftar
    @endslot
  @endcomponent
  @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

        <div class="row">
          <div class="col-lg-12">
            <div id="#customerList">
              <button type="button" class="btn btn-success btn-label btn-sm mb-2" data-bs-target="#importData"
                data-bs-toggle="modal"><i class="las la-file-excel label-icon align-middle fs-16 me-2"></i>
                Import</button>
              <a href={{ asset('template_excel_import_pendaftar/Pendaftar_maba.xlsx') }}>
                <button type="button" class="btn btn-primary btn-label btn-sm mb-2"><i
                    class="las la-file-excel label-icon align-middle fs-16 me-2"></i>
                  DOWNLOAD TEMPLATE EXCEL ADD PENDAFTAR</button>
              </a>
              <!--================= Filter Dropdown ===============================-->
              <div class="card">
                <div class="card-body">
                  <table class="table align-middle table-nowrap" id="pendaftarTable">
                    <thead class="table-light">
                      <tr>
                        <th>
                          <select data-column="0" name="gelombang" id="gelombang" class="form-select">
                            <option value="">PILIH GELOMBANG PENDAFTARAN</option>
                            @foreach ($gelombangPendaftaran as $gel)
                              <option value="{{ $gel->id }}">
                                {{ $gel->nama_gelombang }}</option>
                            @endforeach
                          </select>
                        </th>
                        <th>
                          <select data-column="1" name="prodi" id="prodi" class="form-select">
                            <option value="">PILIH PROGRAM STUDI</option>
                            @foreach ($programStudi as $pro)
                              <option value="{{ $pro->id }}">
                                {{ $pro->nama_program_studi }}
                              </option>
                            @endforeach
                          </select>
                        </th>
                        <th>
                          <select data-column="2" name="statuspendaftaran" id="statuspendaftaran" class="form-select">
                            <option value="">STATUS PENDAFTARAN</option>
                            <option value="sudah">SUDAH</option>
                            <option value="belum">BELUM</option>
                          </select>
                        </th>
                        <th>
                          <select data-column="3" name="statusukt" id="statusukt" class="form-select">
                            <option value="">STATUS UKT</option>
                            <option value="sudah">SUDAH</option>
                            <option value="belum">BELUM</option>
                          </select>
                        </th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
              <!--================= End Filter Dropdown ===========================-->
            <div class="card">
                <div id="customerList">
                <div class="card-header">
                <div class="row g-4">
                    <div class="col-sm-auto">
                        <h4 class="card-title mt-2">DAFTAR PENDAFTAR</h4>
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
                        <th>No</th>
                        {{-- <th scope="col" style="width: 50px;">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="checkAll"
                                                            value="option">
                                                    </div>
                                                </th> --}}
                        <th data-sort="customer_name">NAMA</th>
                        <th data-sort="date">TGL DAFTAR</th>
                        <th data-sort="email">GELOMBANG</th>
                        <th data-sort="phone">PROGRAM STUDI</th>
                        <th data-sort="status">STATUS KELENGKAPAN DATA PENDAFTARAN</th>
                        <th data-sort="statuspendaftaran">STATUS PENDAFTARAN</th>
                        <th data-sort="status">STATUS UKT</th>
                        <th data-sort="action">AKSI</th>
                      </tr>
                    </thead>
                    <tbody class="list form-check-all" id="tbodyPendaftarID">
                      @foreach ($pendaftar as $i => $row)
                        <tr>
                          <td>{{ ++$i }}</td>
                          {{-- <th scope="row">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="checkAll"
                                                                value="option1">
                                                        </div>
                                                    </th> --}}
                          <td class="id" style="display:none;"><a href="javascript:void(0);"
                              class="fw-medium link-primary">#VZ2101</a></td>
                          <td class="customer_name">{{ $row->nama }}</td>
                          {{-- <!--<td class="date">{{ $row->detailPendaftar->tanggal_daftar }}</td>--> --}}
                          <td class="date">
                            @if($row->detailPendaftar && $row->detailPendaftar->created_at)
                              {{ $row->detailPendaftar->created_at->format('d-m-Y') }}
                            @endif
                          </td>
                          <td class="email">{{ $row->gelombangPendaftaran->nama_gelombang ?? '-' }}</td>
                          <td class="phone">{{ $row->programStudi->name ?? '-' }}</td>
                          <td class="status text-center">
                            @if ($row->detailPendaftar?->status_kelengkapan_data == 'sudah')
                                <span class="badge badge-soft-success text-uppercase">{{ $row->detailPendaftar->status_kelengkapan_data }}</span>
                            @else
                                {{-- <span class="badge badge-soft-danger text-uppercase">belum</span> --}}
                                <!-- Button trigger modal -->
                                <a class="badge badge-soft-danger text-uppercase" 
                                data-bs-toggle="modal" 
                                data-bs-target="#ModalKelengkapanData-{{ $row->detailPendaftar->id ?? '' }}">
                                {{ $row->detailPendaftar->status_kelengkapan_data ?? 'Belum' }}
                             </a>
                             
<!-- Modal -->
<div class="modal fade" id="ModalKelengkapanData-{{$row->detailPendaftar->id ?? ''}}" tabindex="-1" role="dialog" aria-labelledby="ModalKelengkapanData" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalKelengkapanData">Update Status Kelengkapan Data Pendaftaran{{$row->detailPendaftar->id ?? ''}}</h5>
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{route('pendaftar.update-status-pendaftar')}}" method="POST">
        @csrf
        
      <div class="modal-body">
        Apakah  Anda yakin ingin mengubah status pendaftaran?
        <input type="hidden" value="sudah" name="status_kelengkapan_data">
        <input type="hidden" value="{{$row->detailPendaftar->id ?? ''}}" name="id">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
        <button type="submit" class="btn btn-primary">Ya</button>
      </div>
    </form>

    </div>
  </div>
</div>
                            @endif
                        </td>
<td class="statuspendaftaran text-center">
  @if ($row->detailPendaftar?->status_pendaftaran == 'sudah')
  <span class="badge badge-soft-success text-uppercase">{{ $row->detailPendaftar->status_pendaftaran }}</span>
@else
  <!-- Button trigger modal -->
  <a class="badge badge-soft-danger text-uppercase" 
  data-bs-toggle="modal" 
  data-bs-target="#exampleModal-{{ $row->detailPendaftar->id ?? '' }}">
  {{ $row->detailPendaftar->status_pendaftaran ?? 'Belum' }}
</a>

<!-- Modal -->
<div class="modal fade" id="exampleModal-{{$row->detailPendaftar->id ?? ''}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLabel">Update Status Pendaftaran{{$row->detailPendaftar->id ?? ''}}</h5>
<span aria-hidden="true">&times;</span>
</button>
</div>
<form action="{{route('pendaftar.update-status')}}" method="POST">
@csrf

<div class="modal-body">
Apakah  Anda yakin ingin mengubah status pendaftaran?
<input type="hidden" value="sudah" name="status_pendaftaran">
<input type="hidden" value="{{$row->detailPendaftar->id ?? ''}}" name="id">

</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
<button type="submit" class="btn btn-primary">Ya</button>
</div>
</form>

</div>
</div>
</div>
@endif
</td>
                        

<td class="status text-center">
    @if ($row->detailPendaftar?->status_ukt == 'sudah')
        <span class="badge badge-soft-success text-uppercase">{{ $row->detailPendaftar->status_ukt }}</span>
    @else
        <span class="badge badge-soft-danger text-uppercase">belum</span>
    @endif
</td>

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
  <!-- Modal -->
  <!--======================= Modal Import Data =====================-->
  <div class="modal fade" id="importData" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-warning p-3">
          <h5 class="modal-title" id="exampleModalLabel">IMPORT DATA PENDAFTAR</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
            id="close-modal"></button>
        </div>
        <div class="modal-body">
          <form action="{{ route('import.pendaftar') }}" method="POST" enctype="multipart/form-data">
            @csrf
            {{-- <input name="file" type="file" class="form-control-file text-center"> --}}
            <label for="images" class="drop-container">
              <i class="display-4 text-muted ri-upload-cloud-2-fill"></i>
              <h4 class="drop-title">Drop files here or click to upload.</h4>
              <input type="file" name="file" id="images" accept="all/*" required>
            </label>
            <button type="submit" class="btn btn-sm btn-success" style="width: 100%">Upload</button>
          </form>
        </div>
      </div>
    </div>
    <div class="modal-body">
      <form action="{{ route('import.pendaftar') }}" method="POST" enctype="multipart/form-data">
        @csrf
        {{-- <input name="file" type="file" class="form-control-file text-center"> --}}
        <label for="images" class="drop-container">
          <i class="display-4 text-muted ri-upload-cloud-2-fill"></i>
          <h4 class="drop-title">Drop files here or click to upload.</h4>
          <input type="file" name="file" id="images" accept="all/*" required>
        </label>
        <button type="submit" class="btn btn-sm btn-success" style="width: 100%">Upload</button>
      </form>
    </div>
  </div>
  @foreach ($pendaftar as $row)
    <!--=================== Modal Show Data ========================-->
    <div class="modal fade" id="showModal{{ $row->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header bg-warning p-3">
            <h5 class="modal-title" id="exampleModalLabel">DETAIL DATA {{ $row->nama }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
              id="close-modal"></button>
          </div>
          <div class="modal-body">
            <table class="table table-striped">
              <tbody>
                <tr>
                  <td style="width: 400px">NIK</td>
                  <td>{{ $row->user->nik ?? '-'}}</td>
                </tr>
                <tr>
                  <td style="width: 400px">NAMA PENDAFTAR</td>
                  <td>{{ $row->nama }}</td>
                </tr>
                <tr>
                  <td style="width: 400px">NISN PENDAFTAR</td>
                  <td>{{ $row->nisn }}</td>
                </tr>
                <tr>
                  <td style="width: 400px">EMAIL</td>
                  <td>{{ $row->user->email ?? '-' }}</td>
                </tr>
                <tr>
                  <td style="width: 400px">NO. TELP</td>
                  <td>{{ $row->no_hp ?? 'Belum di perbarui data' }}</td>
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
                  <td style="width: 400px;">BUKTI PEMBAYARAN PENDAFTARAN</td>
                  <td> 
                    @php
                    $extensions = ['jpg', 'png', 'jpeg']; // Daftar ekstensi yang didukung
                    $filePath = '';
                
                    if ($row->detailPendaftar) {
                        foreach ($extensions as $ext) {
                            $possiblePath =
                                'assets/file/bukti-pendaftaran/' .
                                $row->detailPendaftar->pendaftar_id .
                                '.' .
                                $ext;
                            if (file_exists(public_path($possiblePath))) {
                                $filePath = asset($possiblePath);
                                break;
                            }
                        }
                    }
                @endphp
                

                @if ($filePath)
                    <a href="{{ $filePath }}" target=_blank>Melihat Bukti Pendaftaran</a>
                @else
                    <p>File tidak ditemukan.</p>
                @endif
               
</td>
                </tr>
                <tr>
                  <td style="width: 400px">NOMINAL PEMBAYARAN PENDAFTARAN</td>
                  <td>{{ $row->gelombangPendaftaran->biaya_pendaftaran }}</td>
                </tr>
                <tr>
                  <td style="width: 400px">STATUS PENDAFTARAN</td>
                  <td>
                    <span class="badge badge-soft-{{ $row->detailPendaftar->status_pendaftaran === 'sudah' ? 'success' : 'danger' }} text-uppercase">
                        {{ $row->detailPendaftar->status_pendaftaran ?? 'Belum' }}
                    </span>
                </td>
                
                </tr>
                <tr>
                  <td style="width: 400px">KODE BAYAR UKT</td>
                  <td>{{ $row->detailPendaftar?->kode_bayar }}</td>
                </tr>
                <tr>
                  <td style="width: 400px">NOMINAL PEMBAYARAN UKT</td>
                  <td>{{ $row->detailPendaftar?->nominal_ukt ?? 'Belum di set Ukt' }}</td>
                </tr>
                <tr>
                  <td style="width: 400px">STATUS UKT</td>
                    {{-- <td><span class="badge badge-soft-danger text-uppercase">{{ $row->detailPendaftar?->status_ukt ?? 'Belum'}}</span></td> --}}
                    <td>
                      <span class="badge badge-soft-{{ $row->detailPendaftar->status_ukt === 'sudah' ? 'success' : 'danger' }} text-uppercase">
                          {{ $row->detailPendaftar->status_ukt ?? 'Belum' }}
                      </span>
                  </td>
                  
                </tr>
                <tr>
                  <td style="width: 400px">THN AJAR & GELOMBANG PENDAFTARAN</td>
                  <td>{{ $row->gelombangPendaftaran->nama_gelombang . ' & ' . $row->gelombangPendaftaran->tahun_ajaran }}
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
            <form action="{{ route('pendaftar.destroy', $row->id) }}" method="POST" enctype="multipart/form-data">
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
<script>
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
</script>
  <!--=========================== Filter & Seearch on Select ===============================-->
  <script>
    //Form Select Search
    $('.form-select').select2({
      // theme: "bootstrap-5",
      width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
      placeholder: $(this).data('placeholder'),
    });
    //Filter with Dropdown
    $(document).ready(function() {
      $(document).on('click', '.pagination a', function(event) {
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        getMoreUsers(page);
      });
      $('#gelombang').on('change', function() {
        getMoreUsers();
      });
      $('#prodi').on('change', function(e) {
        getMoreUsers();
      });
      $('#statuspendaftaran').on('change', function(e) {
        getMoreUsers();
      });
      $('#statusukt').on('change', function(e) {
        getMoreUsers();
      });
    });

    function getMoreUsers(page) {
      // Search on based of country
      var gelombang = $("#gelombang option:selected").val();
      // Search on based of type
      var prodi = $("#prodi option:selected").val();
      var statuspendaftaran = $("#statuspendaftaran option:selected").val();
      var statusukt = $("#statusukt option:selected").val();
      $.ajax({
        type: "GET",
        data: {
          'gelombang': gelombang,
          'prodi': prodi,
          'statuspendaftaran': statuspendaftaran,
          'statusukt': statusukt,
        },
        url: "{{ route('pendaftar.index') }}" + "?page=" + page,
        success: function(data) {
          // $("#tbodyPendaftarID").html(data);
          var pendaftar = data.pendaftar;
          console.log(pendaftar);
          var html = '';
          if (pendaftar.length > 0) {
            for (let i = 0; i < pendaftar.length; i++) {
              html += `<tr>
                                        <td>${i+1}</td>
                                        <td>${pendaftar[i]['nama']}</td>
                                        <td>${moment(pendaftar[i]['created_at']).format('DD-MM-YYYY')}</td>
                                        <td>${pendaftar[i]['gelombang_pendaftaran']['nama_gelombang']}</td>
                                        <td>${pendaftar[i]['program_studi']['nama_program_studi']}</td>
                                        <td class="status text-center"><span
                                                class="${pendaftar[i]['detail_pendaftar']['status_pendaftaran'] == null ? 'badge badge-soft-danger text-uppercase' : 'badge badge-soft-success text-uppercase' }">${pendaftar[i]['detail_pendaftar']['status_pendaftaran'] == null ? 'belum' : pendaftar[i]['detail_pendaftar']['status_pendaftaran'] }</span>
                                        </td>
                                        <td class="status text-center"><span
                                                            class="${pendaftar[i]['detail_pendaftar']['status_ukt'] == null ? 'badge badge-soft-danger text-uppercase' : 'badge badge-soft-success text-uppercase' }">${pendaftar[i]['detail_pendaftar']['status_ukt'] == null ? 'belum' : pendaftar[i]['detail_pendaftar']['status_ukt'] }</span>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                            <div class="edit">
                                                    <button type="button" class="btn btn-warning btn-icon waves-effect waves-light rounded-pill"
                                                    data-bs-toggle="modal" data-bs-target="#showModal${pendaftar[i]['id']}"><i class="ri-information-line"></i></button>
                                            </div>
                                            <div class="remove">
                                                <button type="button" class="btn btn-danger btn-icon waves-effect waves-light rounded-pill"
                                                    data-bs-toggle="modal" data-bs-target="#deleteRecordModal${pendaftar[i]['id']}"><i
                                                    class="ri-delete-bin-fill"></i></button>
                                            </div>
                                        </div>
                                        </td>
                                    </tr>`;
            }
          } else {
            html +=
              `<tr><td colspan="10"><div class="text-center">
                                        <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                            colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px">
                                        </lord-icon>
                                        <h5 class="mt-2">Maaf! Data yang anda cari tidak ada</h5>
                                        <p class="text-muted mb-0">Harap Perbaiki kata kunci yang anda cari. </p>
                                    </div></td></tr>`;
          }
          $("#tbodyPendaftarID").html(html);
        },
        error: function(data) {
          html +=
            `<tr><td colspan="10"><div class="text-center">
                                        <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                            colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px">
                                        </lord-icon>
                                        <h5 class="mt-2">Maaf! Data yang anda cari tidak ada</h5>
                                        <p class="text-muted mb-0">Harap Perbaiki kata kunci yang anda cari. </p>
                                    </div></td></tr>`;
        }
      });
    }
  </script>
  <!--=========================== End Filter & Seearch on Select ===========================-->
  <script src="{{ URL::asset('assets/libs/prismjs/prismjs.js') }}"></script>
  <script src="{{ URL::asset('assets/libs/list.js/list.min.js') }}"></script>
  <script src="{{ URL::asset('assets/libs/list.pagination.js/list.pagination.min.js') }}"></script>
  <!-- listjs init -->
  <script src="{{ URL::asset('assets/js/pages/listjs.init.js') }}"></script>
  <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
