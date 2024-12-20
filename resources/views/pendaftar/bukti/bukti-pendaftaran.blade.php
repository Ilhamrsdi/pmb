@extends('layouts.master')
@section('title')
  Cetak Bukti Pendaftaran
@endsection
@section('css')
  <style>
    .column {
      /* max-width: 200px; */
      width: 10px;
    }
  </style>
@endsection
@section('content')
  @component('components.breadcrumb')
    @slot('li_1')
      Dashboard
    @endslot
    @slot('title')
      Cetak Bukti Pendaftaran
    @endslot
  @endcomponent

  <div class="row mb-4">
    <div class="col-xl-12">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body p-0">
              <div class="alert alert-success border-0 rounded-0 m-0 d-flex align-items-center" role="alert">
                <i data-feather="alert-triangle" class="text-success me-2 icon-sm"></i>
                <div class="flex-grow-1 text-truncate">
                  Selamat Anda dinyatakan Lolos Seleksi
                </div>
                <div class="flex-shrink-0">
                    <a class="btn btn-success" href="{{ route('bukti.kartu-ujian', ['id' => $pendaftar->id]) }}">Cetak</a>
                </div>
                
              </div>

              <div class="row">
                <div class="col-sm-12">
                  <div class="p-2">
                    <div class="table-responsive">
                      <table class="table table-striped table-nowrap align-middle mb-0">
                        <tbody>
                          <tr>
                            <td class="fw-medium column">Email</td>
                            <td class="fw-medium column">:</td>
                            <td>{{ $pendaftar->user->email }}</td>
                            <td></td>
                            <td></td>
                          </tr>
                          <tr>
                            <td class="fw-medium column">NIK</td>
                            <td class="fw-medium column">:</td>
                            <td>{{ $pendaftar->user->nik }}</td>
                            <td></td>
                            <td></td>
                          </tr>
                          <tr>
                            <td class="fw-medium column">Nama</td>
                            <td class="fw-medium column">:</td>
                            <td>{{ $pendaftar->nama }}</td>
                            <td></td>
                            <td></td>
                          </tr>
                          <tr>
                            <td class="fw-medium column">Asal Sekolah</td>
                            <td class="fw-medium column">:</td>
                            <td>{{ $pendaftar->sekolah }}</td>
                            <td></td>
                            <td></td>
                          </tr>
                          <tr>
                            <td class="fw-medium column">No Telp</td>
                            <td class="fw-medium column">:</td>
                            <td>{{ $pendaftar->no_hp }}</td>
                            <td></td>
                            <td></td>
                          </tr>
                          <tr>
                            <td class="fw-medium column">Gelombang yang dipilih</td>
                            <td class="fw-medium column">:</td>
                            <td>{{ $pendaftar->gelombangPendaftaran->nama_gelombang }}</td>
                            <td></td>
                            <td></td>
                          </tr>
                          <tr>
                            <td class="fw-medium column">Tahun Ajar Mahasiswa</td>
                            <td class="fw-medium column">:</td>
                            <td>{{ $pendaftar->gelombangPendaftaran->tahun_ajaran }}</td>
                            <td></td>
                            <td></td>
                          </tr>
                          <tr>
                            <td class="fw-medium column">Program Studi</td>
                            <td class="fw-medium column">:</td>
                            <td>{{ $pendaftar->programStudi->name }}</td>
                            <td></td>
                            <td></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div> <!-- end card-body-->
          </div>
        </div> <!-- end col-->
      </div> <!-- end row-->


    </div> <!-- end col-->

  </div> <!-- end row-->
@endsection
@section('script')
  <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
