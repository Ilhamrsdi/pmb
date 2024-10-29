@extends('layouts.master')
@section('title')
  @lang('CALON MABA BELUM / SUDAH MEMBAYAR UKT')
@endsection
@section('content')
  @component('components.breadcrumb')
    @slot('li_1')
      Calon Maba
    @endslot
    @slot('title')
      Calon Maba Sudah / Belum Membayar UKT
    @endslot
  @endcomponent
  @if (Session::has('success'))
    <div class="alert alert-success">
      <strong>Success: </strong>{{ Session::get('success') }}
    </div>
  @endif
  <div class="row">
    <div class="col-lg-12">
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
                  <select data-column="2" name="statusukt" id="statusukt" class="form-select">
                    <option value="">STATUS UKT</option>
                    <option value="sudah">SUDAH</option>
                    <option value="belum">BELUM</option>
                  </select>
                </th>
                <th>
                  <select data-column="3" name="statuspembayaran" id="statuspembayaran" class="form-select">
                    <option value="">STATUS PEMBAYARAN</option>
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
                <h4 class="card-title mt-2">DAFTAR CALON MAHASISWA BARU YANG SUDAH / BELUM MENGISI DATA UKT
                  DAN PEMBAYARAN UKT</h4>
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
            <div class="table-responsive table-card mt-3 mb-1">
              <table class="table align-middle table-nowrap" id="customerTable">
                <thead class="table-light">
                  <tr>
                    <th>No</th>
                    <th class="sort" data-sort="customer_name">NIK</th>
                    <th class="sort" data-sort="customer_name">NAMA PENDAFTAR</th>
                    <th class="sort" data-sort="date">TGL DAFTAR</th>
                    <th class="sort" data-sort="email">GELOMBANG</th>
                    <th class="sort" data-sort="phone">PROGRAM STUDI</th>
                    <th class="sort" data-sort="status">UKT</th>
                    <th class="sort" data-sort="status">PEMBAYARAN</th>
                    <th class="sort" data-sort="action">AKSI</th>
                  </tr>
                </thead>
                <tbody class="list form-check-all" id="tbodyPendaftarID">
                  @foreach ($camaba_ukt as $i => $row)
                    <tr>
                      <td>{{ ++$i }}</td>
                      <td class="id" style="display:none;"><a href="javascript:void(0);"
                          class="fw-medium link-primary">#VZ2101</a></td>
                      <td class="customer_name">{{ $row->user->nik }}</td>
                      <td class="customer_name">{{ $row->nama }}</td>
                      <td class="date">{{ $row->created_at->format('d-m-Y') }}</td>
                      <td class="email">{{ $row->gelombangPendaftaran->nama_gelombang }}</td>
                      <td class="phone">{{ $row->programStudi?->nama_program_studi }}</td>
                      @if ($row->status_ukt == 'sudah')
                        <td class="status"><span class="badge badge-soft-success text-uppercase">SUDAH DIATUR</span>
                        </td>
                      @else
                        <td class="status"><span class="badge badge-soft-danger text-uppercase">BELUM DIATUR</span>
                        </td>
                      @endif
                      @if ($row->status_pembayaran == 'sudah')
                        <td class="status"><span class="badge badge-soft-success text-uppercase">SUDAH
                            MEMBAYAR</span>
                        </td>
                      @else
                        <td class="status"><span class="badge badge-soft-danger text-uppercase">BELUM MEMBAYAR</span>
                        </td>
                      @endif
                      <td>
                        <div class="d-flex gap-2">
                          <div class="edit">
                            <button type="button" class="btn btn-warning btn-icon waves-effect waves-light rounded-pill"
                              data-bs-toggle="modal" data-bs-target="#showModal{{ $row->id }}"><i
                                class="ri-information-line"></i></button>
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
      <!-- end col -->
    </div>
    <!-- end col -->
  </div>
  <!-- end row -->
  <!-- Modal -->
  @foreach ($camaba_ukt as $row)
    <!-- Modal Show Data -->
    <div class="modal fade" id="showModal{{ $row->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content">
          <div class="modal-header bg-warning p-3">
            <h5 class="modal-title" id="exampleModalLabel" style="text-transform: uppercase">Detail Data
              {{ $row->nama }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
              id="close-modal"></button>
          </div>
          <div class="modal-body">
            <div class="card">
              <div class="card-body">
                <!-- Nav tabs -->
                <ul class="nav nav-pills nav-primary mb-3" role="tablist">
                  <li class="nav-item waves-effect waves-light">
                    <a class="nav-link active" data-bs-toggle="tab" href="#pilihan-ukt{{ $row->id }}"
                      role="tab">PILIHAN UKT</a>
                  </li>
                  <li class="nav-item waves-effect waves-light">
                    <a class="nav-link" data-bs-toggle="tab" href="#profile{{ $row->id }}"
                      role="tab">PROFILE</a>
                  </li>
                  <li class="nav-item waves-effect waves-light">
                    <a class="nav-link" data-bs-toggle="tab" href="#bio-ayah{{ $row->id }}" role="tab">BIO
                      AYAH/WALI</a>
                  </li>
                  <li class="nav-item waves-effect waves-light">
                    <a class="nav-link" data-bs-toggle="tab" href="#bio-ibu{{ $row->id }}" role="tab">BIO
                      IBU/WALI</a>
                  </li>
                  <li class="nav-item waves-effect waves-light">
                    <a class="nav-link" data-bs-toggle="tab" href="#lainnya{{ $row->id }}"
                      role="tab">LAINNYA</a>
                  </li>
                  <li class="nav-item waves-effect waves-light">
                    <a class="nav-link" data-bs-toggle="tab" href="#file-pendamping{{ $row->id }}"
                      role="tab">FILE PENDAMPING</a>
                  </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content text-muted">
                  <!-- Tabs Pilihan UKT-->
                  <div class="tab-pane active" id="pilihan-ukt{{ $row->id }}" role="tabpanel">
                    <div class="row">
                      <div class="col-sm-12">
                        <table class="table table-striped">
                          <tbody>
                            <tr>
                              <td style="width: 400px">NIM</td>
                              <td>{{ $row->nim }}</td>
                            </tr>
                            <tr>
                              <td style="width: 400px">NAMA MAHASISWA</td>
                              <td>{{ $row->nama }}</td>
                            </tr>
                            <tr>
                              <td style="width: 400px">PILIHAN UKT</td>
                              <td>{{ $row->potongan_ukt }}</td>
                            </tr>
                            <tr>
                              <td style="width: 400px">NOMINAL UKT</td>
                              <td>{{ $row->nominal_ukt }}</td>
                            </tr>
                            <tr>
                              <td style="width: 400px">JURUSAN / PRODI</td>
                              <td>{{ $row->programStudi?->jurusan?->nama_jurusan }}
                                -
                                {{ $row->programStudi?->jenjang_pendidikan }}
                                {{ $row->programStudi?->nama_program_studi }}
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <!-- Tabs Profile-->
                  <div class="tab-pane" id="profile{{ $row->id }}" role="tabpanel">
                    <div class="row">
                      <div class="col-sm-12">
                        <table class="table table-striped">
                          <tbody>
                            <tr>
                              <td style="width: 400px">NIM</td>
                              <td>{{ $row->nim }}</td>
                            </tr>
                            <tr>
                              <td style="width: 400px">NAMA PENDAFTAR</td>
                              <td>{{ $row->nama }}</td>
                            </tr>
                            <tr>
                              <td style="width: 400px">PRODI - JURUSAN</td>
                              <td>{{ $row->programStudi?->jenjang_pendidikan }}
                                {{ $row->programStudi?->nama_program_studi }}
                                -
                                {{ $row->programStudi?->nama_jurusan }}
                              </td>
                            </tr>
                            <tr>
                              <td style="width: 400px">JENIS KELAMIN</td>
                              <td>{{ $row->jenis_kelamin }}</td>
                            </tr>
                            <tr>
                              <td style="width: 400px">NO HP</td>
                              <td>{{ $row->no_hp }}</td>
                            </tr>
                            <tr>
                              <td style="width: 400px">TEMPAT / TANGGAL LAHIR</td>
                              <td>{{ $row->tempat_lahir }} /
                                {{ $row->tanggal_lahir }}
                              </td>
                            </tr>
                            <tr>
                              <td style="width: 400px">NISN</td>
                              <td>{{ $row->nisn }}</td>
                            </tr>
                            <tr>
                              <td style="width: 400px">NIK</td>
                              <td>{{ $row->nik }}</td>
                            </tr>
                            <tr>
                              <td style="width: 400px">EMAIL</td>
                              <td>{{ $row->email }}</td>
                            </tr>
                            <tr>
                              <td style="width: 400px">AGAMA</td>
                              <td>{{ $row->agama }}</td>
                            </tr>
                            <tr>
                              <td style="width: 400px">ALAMAT</td>
                              <td>{{ $row->alamat }}</td>
                            </tr>
                            <tr>
                              <td style="width: 400px">RT / RW</td>
                              <td>{{ $row->rt }} / {{ $row->rw }}</td>
                            </tr>
                            <tr>
                              <td style="width: 400px">KELURAHAN/DESA</td>
                              <td>{{ $row->kelurahan_desa }}</td>
                            </tr>
                            <tr>
                              <td style="width: 400px">KECAMATAN</td>
                              <td>{{ $row->kecamatan }}</td>
                            </tr>
                            <tr>
                              <td style="width: 400px">KABUPATEN</td>
                              <td>{{ $row->kabupaten }}</td>
                            </tr>
                            <tr>
                              <td style="width: 400px">KODE POS</td>
                              <td>{{ $row->kode_pos }}</td>
                            </tr>
                            <tr>
                              <td style="width: 400px">JENIS TINGGAL</td>
                              <td>{{ $row->jenis_tinggal }}</td>
                            </tr>
                            <tr>
                              <td style="width: 400px">ALAT TRANSPORT</td>
                              <td>{{ $row->kendaraan }}</td>
                            </tr>
                            <tr>
                              <td style="width: 400px">TELP RUMAH</td>
                              <td>{{ $row->telepon_rumah }}</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <!-- Tabs BIO Ayahhhh-->
                  <div class="tab-pane" id="bio-ayah{{ $row->id }}" role="tabpanel">
                    <div class="row">
                      <div class="col-sm-12">
                        <table class="table table-striped">
                          <tbody>
                            <tr>
                              <td style="width: 400px">NIK AYAH / WALI</td>
                              <td>{{ $row->wali?->nik_ayah }}</td>
                            </tr>
                            <tr>
                              <td style="width: 400px">NAMA AYAH / WALI</td>
                              <td>{{ $row->wali?->nama_ayah }}</td>
                            </tr>
                            <tr>
                              <td style="width: 400px">TGL LAHIR AYAH / WALI</td>
                              <td>{{ $row->wali?->tanggal_lahir_ayah }}</td>
                            </tr>
                            <tr>
                              <td style="width: 400px">PENDIDIKAN AYAH / WALI</td>
                              <td>{{ $row->wali?->pendidikan_ayah }}</td>
                            </tr>
                            <tr>
                              <td style="width: 400px">PEKERJAAN AYAH / WALI</td>
                              <td>{{ $row->wali?->pekerjaan_ayah }}</td>
                            </tr>
                            <tr>
                              <td style="width: 400px">PEKERJAAN AYAH / WALI</td>
                              <td>{{ $row->wali?->pekerjaan_ayah }}</td>
                            </tr>
                            <tr>
                              <td style="width: 400px">PENGHASILAN AYAH / WALI</td>
                              @if ($row->wali?->penghasilan_ayah < 500000)
                                <td>Kurang Dari Rp. 500.000</td>
                              @elseif ($row->wali?->penghasilan_ayah < 1000000)
                                <td>Kurang Dari Rp. 1000.000</td>
                              @elseif ($row->wali?->penghasilan_ayah < 2000000)
                                <td>Kurang Dari Rp. 2000.000</td>
                              @elseif ($row->wali?->penghasilan_ayah < 3000000)
                                <td>Kurang Dari Rp. 3000.000</td>
                              @endif
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <!-- Tabs BIO Ibuuuu-->
                  <div class="tab-pane" id="bio-ibu{{ $row->id }}" role="tabpanel">
                    <div class="row">
                      <div class="col-sm-12">
                        <table class="table table-striped">
                          <tbody>
                            <tr>
                              <td style="width: 400px">NIK AYAH / WALI</td>
                              <td>{{ $row->wali?->nik_ibu }}</td>
                            </tr>
                            <tr>
                              <td style="width: 400px">NAMA AYAH / WALI</td>
                              <td>{{ $row->wali?->nama_ibu }}</td>
                            </tr>
                            <tr>
                              <td style="width: 400px">TGL LAHIR AYAH / WALI</td>
                              <td>{{ $row->wali?->tanggal_lahir_ibu }}</td>
                            </tr>
                            <tr>
                              <td style="width: 400px">PENDIDIKAN AYAH / WALI</td>
                              <td>{{ $row->wali?->pendidikan_ibu }}</td>
                            </tr>
                            <tr>
                              <td style="width: 400px">PEKERJAAN AYAH / WALI</td>
                              <td>{{ $row->wali?->pekerjaan_ibu }}</td>
                            </tr>
                            <tr>
                              <td style="width: 400px">PEKERJAAN AYAH / WALI</td>
                              <td>{{ $row->wali?->pekerjaan_ibu }}</td>
                            </tr>
                            <tr>
                              <td style="width: 400px">PENGHASILAN IBU / WALI</td>
                              @if ($row->wali?->penghasilan_ibu < 500000)
                                <td>Kurang Dari Rp. 500.000</td>
                              @elseif ($row->wali?->penghasilan_ibu < 1000000)
                                <td>Kurang Dari Rp. 1000.000</td>
                              @elseif ($row->wali?->penghasilan_ibu < 2000000)
                                <td>Kurang Dari Rp. 2000.000</td>
                              @elseif ($row->wali?->penghasilan_ibu < 3000000)
                                <td>Kurang Dari Rp. 3000.000</td>
                              @endif
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <!-- Tabs Lainnya -->
                  <div class="tab-pane" id="lainnya{{ $row->id }}" role="tabpanel">
                    <div class="row">
                      <div class="col-sm-12">
                        <table class="table table-striped">
                          <tbody>
                            <tr>
                              <td style="width: 400px">KEWARGANEGARAAN</td>
                              <td>{{ $row->kewarganegaraan }}</td>
                            </tr>
                            <tr>
                              <td style="width: 400px">JENIS PENDAFTARAN</td>
                              <td>PESERTA DIDIK BARU</td>
                            </tr>
                            <tr>
                              <td style="width: 400px">TANGGAL MASUK KULIAH</td>
                              <td>{{ $row->detailPendaftar?->tanggal_masuk_kuliah }}</td>
                            </tr>
                            <tr>
                              <td style="width: 400px">TAHUN MASUK</td>
                              <td>{{ $row->gelombangPendaftaran->nama_gelombang }}
                                {{ $row->gelombangPendaftaran->tahun_ajaran }}</td>
                            </tr>
                            <tr>
                              <td style="width: 400px">PEMBIAYAAN</td>
                              @if ($row->gelombangPendaftaran->deskripsi == 'Jalur Mandiri')
                                <td>MANDIRI</td>
                              @elseif ($row->gelombangPendaftaran->deskripsi == 'Jalur Reguler')
                                <td>REGULER</td>
                              @elseif ($row->gelombangPendaftaran->deskripsi == 'Jalur Beasiswa')
                                <td>BEASISWA</td>
                              @endif
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <!-- Tabs File Pendamping -->
                  <div class="tab-pane" id="file-pendamping{{ $row->id }}" role="tabpanel">
                    <div class="row">
                      <div class="col-sm-12">
                        <table class="table table-striped">
                          <tbody>
                            <tr>
                              <td style="width: 400px">FILE KTP</td>
                              {{-- <td><a href="{{ url('file_pendamping/ktp/', $row->file_ktp) }}"
                                                                    class="btn btn-link">DOWNLOAD</a></td> --}}
                              <td><button class="btn btn-link" id="showKTP{{ $row->id }}"
                                  onclick="showKTPfunction('{{ $row->id }}')">TAMPILKAN</button>
                              </td>
                            </tr>
                            <tr>
                              <td>
                                <div id="formKTP{{ $row->id }}" hidden>
                                  <div class="card-header">
                                    <button type="button" id="hideKTP{{ $row->id }}"
                                      onclick="hideKTPfunction('{{ $row->id }}')"
                                      class="btn-close float-end fs-11" aria-label="Close"></button>
                                  </div>
                                  <iframe src="{{ url('file_pendamping/ktp/', $row->file_ktp) }}" width="950px"
                                    height="400px">
                                  </iframe>
                                  {{-- <embed
                                                                        src="{{ url('file_pendamping/ktp/', $row->file_ktp) }}"
                                                                        type="application/pdf" width="950px"
                                                                        height="400px"> --}}
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td style="width: 400px">FILE KK</td>
                              {{-- <td><a href="{{ url('file_pendamping/kk/', $row->file_kk) }}"
                                                                    class="btn btn-link">DOWNLOAD</a></td> --}}
                              <td><a class="btn btn-link" id="showKK{{ $row->id }}"
                                  onclick="showKKfunction('{{ $row->id }}')">TAMPILKAN</a>
                              </td>
                            </tr>
                            <tr>
                              <td>
                                <div id="formKK{{ $row->id }}" hidden>
                                  <div class="card-header">
                                    <button type="button" id="hideKK{{ $row->id }}"
                                      onclick="hideKKfunction('{{ $row->id }}')" class="btn-close float-end fs-11"
                                      aria-label="Close"></button>
                                  </div>
                                  <iframe src="{{ url('file_pendamping/kk/', $row->file_kk) }}" width="950px"
                                    height="400px">
                                  </iframe>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td style="width: 400px">FILE IJAZAH</td>
                              {{-- <td><a href="{{ url('file_pendamping/ijazah/', $row->file_ijazah) }}"
                                                                    class="btn btn-link">DOWNLOAD</a></td> --}}
                              <td><a class="btn btn-link" id="showIjazah{{ $row->id }}"
                                  onclick="showIjazahfunction('{{ $row->id }}')">TAMPILKAN</a>
                              </td>
                            </tr>
                            <tr>
                              <td>
                                <div id="formIjazah{{ $row->id }}" hidden>
                                  <div class="card-header">
                                    <button type="button" id="hideIjazah{{ $row->id }}"
                                      onclick="hideIjazahfunction('{{ $row->id }}')"
                                      class="btn-close float-end fs-11" aria-label="Close"></button>
                                  </div>
                                  <iframe src="{{ url('file_pendamping/ijazah/', $row->file_ijazah) }}" width="950px"
                                    height="400px">
                                  </iframe>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td style="width: 400px">FILE TRANSKIP NILAI</td>
                              {{-- <td><a href="{{ url('file_pendamping/transkip/', $row->file_transkip) }}"
                                                                    class="btn btn-link">DOWNLOAD</a></td> --}}
                              <td><a class="btn btn-link" id="showTranskip{{ $row->id }}"
                                  onclick="showTranskipfunction('{{ $row->id }}')">TAMPILKAN</a>
                              </td>
                            </tr>
                            <tr>
                              <td>
                                <div id="formTranskip{{ $row->id }}" hidden>
                                  <div class="card-header">
                                    <button type="button" id="hideTranskip{{ $row->id }}"
                                      onclick="hideTranskipfunction('{{ $row->id }}')"
                                      class="btn-close float-end fs-11" aria-label="Close"></button>
                                  </div>
                                  <iframe src="{{ url('file_pendamping/transkip/', $row->file_transkip) }}"
                                    width="950px" height="400px">
                                  </iframe>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td style="width: 400px">FILE RAPOR</td>
                              {{-- <td><a href="{{ url('file_pendamping/transkip/', $row->file_transkip) }}"
                                                                    class="btn btn-link">DOWNLOAD</a></td> --}}
                              <td><a class="btn btn-link" id="showRapor{{ $row->id }}"
                                  onclick="showRaporfunction('{{ $row->id }}')">TAMPILKAN</a>
                              </td>
                            </tr>
                            <tr>
                              <td>
                                <div id="formRapor{{ $row->id }}" hidden>
                                  <div class="card-header">
                                    <button type="button" id="hideRapor{{ $row->id }}"
                                      onclick="hideRaporfunction('{{ $row->id }}')"
                                      class="btn-close float-end fs-11" aria-label="Close"></button>
                                  </div>
                                  <iframe src="{{ url('file_pendamping/raport/', $row->file_raport) }}" width="950px"
                                    height="400px">
                                  </iframe>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td style="width: 400px">FILE FOTO</td>
                              {{-- <td><a href="{{ url('file_pendamping/transkip/', $row->file_transkip) }}"
                                                                    class="btn btn-link">DOWNLOAD</a></td> --}}
                              <td><a class="btn btn-link" id="showFoto{{ $row->id }}"
                                  onclick="showFotofunction('{{ $row->id }}')">TAMPILKAN</a>
                              </td>
                            </tr>
                            <tr>
                              <td>
                                <div id="formFoto{{ $row->id }}" hidden>
                                  <div class="card-header">
                                    <button type="button" id="hideFoto{{ $row->id }}"
                                      onclick="hideFotofunction('{{ $row->id }}')"
                                      class="btn-close float-end fs-11" aria-label="Close"></button>
                                  </div>
                                  <iframe src="{{ url('file_pendamping/foto/', $row->file_foto) }}" width="950px"
                                    height="400px">
                                  </iframe>
                                </div>
                              </td>
                            </tr>
                            {{-- <tr>
                                                            <td style="width: 400px">FILE RAPOR</td>
                                                            <td><a href="{{ url('file_pendamping/raport/', $row->file_raport) }}"
                                                                    class="btn btn-link">DOWNLOAD</a></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 400px">FILE FOTO</td>
                                                            <td><a href="{{ url('file_pendamping/foto/', $row->file_foto) }}"
                                                                    class="btn btn-link">DOWNLOAD</a></td>
                                                        </tr> --}}
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div><!-- end card-body -->
            </div><!-- end card -->
          </div>
        </div>
      </div>
    </div>
  @endforeach
  <!--end modal -->
  <!-- end row -->
@endsection
@section('script')
  <!--================ Show & hide File Pendamping ==================-->
  <script>
    //KTP
    function showKTPfunction(id) {
      $("#formKTP" + id).prop("hidden", false);
    }

    function hideKTPfunction(id) {
      $("#formKTP" + id).prop("hidden", true);
    }
    //KK
    function showKKfunction(id) {
      $("#formKK" + id).prop("hidden", false);
    }

    function hideKKfunction(id) {
      $("#formKK" + id).prop("hidden", true);
    }
    //Ijazah
    function showIjazahfunction(id) {
      $("#formIjazah" + id).prop("hidden", false);
    }

    function hideIjazahfunction(id) {
      $("#formIjazah" + id).prop("hidden", true);
    }
    //Transkip Nilai
    function showTranskipfunction(id) {
      $("#formTranskip" + id).prop("hidden", false);
    }

    function hideTranskipfunction(id) {
      $("#formTranskip" + id).prop("hidden", true);
    }
    //Raport
    function showRaporfunction(id) {
      $("#formRapor" + id).prop("hidden", false);
    }

    function hideRaporfunction(id) {
      $("#formRapor" + id).prop("hidden", true);
    }
    //Foto
    function showFotofunction(id) {
      $("#formFoto" + id).prop("hidden", false);
    }

    function hideFotofunction(id) {
      $("#formFoto" + id).prop("hidden", true);
    }
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
      $('#statusukt').on('change', function(e) {
        getMoreUsers();
      });
      $('#statuspembayaran').on('change', function(e) {
        getMoreUsers();
      });
    });

    function getMoreUsers(page) {
      var gelombang = $("#gelombang option:selected").val();
      var prodi = $("#prodi option:selected").val();
      var statusukt = $("#statusukt option:selected").val();
      var statuspembayaran = $("#statuspembayaran option:selected").val();
      $.ajax({
        type: "GET",
        data: {
          'gelombang': gelombang,
          'prodi': prodi,
          'statusukt': statusukt,
          'statuspembayaran': statuspembayaran,
        },
        url: "{{ route('camaba-ukt.index') }}" + "?page=" + page,
        success: function(data) {
          // $("#tbodyPendaftarID").html(data);
          var camaba_ukt = data.camaba_ukt;
          // console.log(camaba_acc);
          var html = '';
          if (camaba_ukt.length > 0) {
            for (let i = 0; i < camaba_ukt.length; i++) {
              html += `<tr>
                            <td>${i+1}</td>
                            <td>${camaba_ukt[i]['user']['nik']}</td>
                            <td>${camaba_ukt[i]['nama']}</td>
                            <td>${moment(camaba_ukt[i]['created_at']).format('DD-MM-YYYY')}</td>
                            <td>${camaba_ukt[i]['gelombang_pendaftaran']['nama_gelombang']}</td>
                            <td>${camaba_ukt[i]['program_studi']['nama_program_studi']}</td>
                            <td class="status text-center"><span
                                    class="${camaba_ukt[i]['detail_pendaftar']['status_ukt'] == null ? 'badge badge-soft-danger text-uppercase' : 'badge badge-soft-success text-uppercase' }">${camaba_ukt[i]['detail_pendaftar']['status_ukt'] == null ? 'BELUM DIATUR' : camaba_ukt[i]['detail_pendaftar']['status_ukt'] }</span>
                            </td>
                            <td class="status text-center"><span
                                    class="${camaba_ukt[i]['detail_pendaftar']['status_pembayaran'] == null ? 'badge badge-soft-danger text-uppercase' : 'badge badge-soft-success text-uppercase' }">${camaba_ukt[i]['detail_pendaftar']['status_pembayaran'] == null ? 'BELUM MEMBAYAR' : camaba_ukt[i]['detail_pendaftar']['status_pembayaran'] }</span>
                            </td>
                            <td>
                              <div class="d-flex gap-2">
                                    <div class="edit">
                                        <button type="button" class="btn btn-warning btn-icon waves-effect waves-light rounded-pill"
                                              data-bs-toggle="modal" data-bs-target="#showModal${camaba_ukt[i]['id']}"><i
                                              class="ri-information-line"></i></button>
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
