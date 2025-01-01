@extends('layouts.master')
@section('title')
    Kelengkapan Data
@endsection
@section('css')
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
            Kelengkapan Data
        @endslot
        @slot('title')
            Form Kelengkapan Data
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body kelengkapan-data-tab">
                    <form id="myform" action="{{ route('kelengkapan-data.update', $pendaftar->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="step-arrow-nav mt-n3 mx-n3 mb-3">
                            <ul class="nav nav-pills nav-justified custom-nav" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link fs-15 p-3 active" id="pills-bio-orangtua-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-bio-orangtua" type="button" role="tab"
                                    aria-controls="pills-bio-orangtua" aria-selected="false"><i
                                        class="ri-briefcase-line fs-16 p-2 bg-soft-primary text-primary rounded-circle align-middle me-2"></i>
                                    Biodata Orang Tua</button>
                                </li>
                          
                               
                               

                                <li class="nav-item" role="presentation">
                                    <button class="nav-link fs-15 p-3" id="pills-atribut-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-atribut" type="button" role="tab"
                                        aria-controls="pills-atribut" aria-selected="false"><i
                                            class="ri-shirt-line fs-16 p-2 bg-soft-primary text-primary rounded-circle align-middle me-2"></i>
                                        Atribut</button>
                                </li>
                               
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link fs-15 p-3" id="pills-berkas-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-berkas" type="button" role="tab"
                                        aria-controls="pills-berkas" aria-selected="false"><i
                                            class="ri-file-line fs-16 p-2 bg-soft-primary text-primary rounded-circle align-middle me-2"></i>
                                        Berkas Pendukung</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link fs-15 p-3" id="pills-finish-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-finish" type="button" role="tab"
                                        aria-controls="pills-finish" aria-selected="false"><i
                                            class="ri-checkbox-circle-line fs-16 p-2 bg-soft-primary text-primary rounded-circle align-middle me-2"></i>Finish</button>
                                </li>
                            </ul>
                        </div>

                        <div class="tab-content">
                           
                            <!-- end tab pane -->
                          
                            <div class="tab-pane fade show active" id="pills-bio-orangtua" role="tabpanel"
                                aria-labelledby="pills-bio-orangtua-tab">
                                <div>
                                    <h5 class="mb-1">Biodata Orang Tua</h5>
                                    <p class="text-muted mb-4">Isilah Informasi dibawah ini dengan sebenar benarnya</p>
                                </div>

                                <div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="nik_ayah" class="form-label">NIK Ayah Kandung</label>
                                            <input type="number" max="16" class="form-control" placeholder="Masukkan NIK Ayah"
                                                id="nik_ayah" value="{{ $pendaftar->wali->nik_ayah }}" name="nik_ayah">
                                        </div>
                                        <!--end col-->
                                        <div class="col-md-6 mb-3">
                                            <label for="status_ayah" class="form-label">Status Ayah Kandung</label>
                                            <select id="status_ayah" class="form-select" data-choices
                                                data-choices-sorting="true" name="status_ayah">
                                                <option selected>Pilih Status...</option>
                                                <option value="hidup"
                                                    {{ $pendaftar->wali->status_ayah == 'hidup' ? 'selected' : '' }}>Hidup
                                                </option>
                                                <option value="wafat"
                                                    {{ $pendaftar->wali->status_ayah == 'wafat' ? 'selected' : '' }}>Wafat
                                                </option>
                                            </select>
                                        </div>
                                        <!--end col-->
                                        <div class="col-md-6 mb-3">
                                            <label for="nama_ayah" class="form-label">Nama Ayah Kandung</label>
                                            <input type="text" class="form-control" placeholder="Masukkan Nama Ayah"
                                                id="nama_ayah" value="{{ $pendaftar->wali->nama_ayah }}"
                                                name="nama_ayah">
                                        </div>
                                        <!--end col-->
                                        <div class="col-md-6 mb-3">
                                            <label for="tanggal_lahir_ayah" class="form-label">Tanggal Lahir Ayah Kandung</label>
                                            <input type="date" class="form-control" placeholder="Masukkan Nama Ayah"
                                                id="tanggal_lahir_ayah"
                                                value="{{ $pendaftar->wali->tanggal_lahir_ayah }}"
                                                name="tanggal_lahir_ayah">
                                        </div>
                                        <!--end col-->
                                        <div class="col-md-4 mb-3">
                                            <label for="pendidikan_ayah" class="form-label">Pendidikan Ayah Kandung</label>
                                            <select id="pendidikan_ayah" class="form-select" data-choices data-choices-sorting="true"
                                                name="pendidikan_ayah">
                                                <option selected>Pilih Pendidikan Terakhir...</option>
                                                @foreach ($pendidikan as $item)
                                                <option {{ $item->name == $pendaftar->wali->pendidikan_ayah ? 'selected' : '' }}>
                                                    {{ $item->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                            {{-- <input id="pendidikan_ayah" class="form-control" name="pendidikan_ayah"
                                                value="SMA"> --}}
                                        </div>
                                        <!--end col-->
                                        <div class="col-md-4 mb-3">
                                            <label for="pekerjaan_ayah" class="form-label">Pekerjaan Ayah Kandung</label>
                                            <select id="pekerjaan_ayah" class="form-select" data-choices data-choices-sorting="true"
                                            name="pekerjaan_ayah">
                                            <option selected>Pilih Pekerjaan...</option>
                                            @foreach ($profesi as $item)
                                            <option {{ $item->name == $pendaftar->wali->pekerjaan_ayah ? 'selected' : '' }}>
                                                {{ $item->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                            {{-- <input id="pekerjaan_ayah" class="form-control" name="pekerjaan_ayah"
                                                value="Dagang"> --}}
                                        </div>
                                        <!--end col-->
                                        <div class="col-md-4 mb-3">
                                            <label for="penghasilan_ayah" class="form-label">Penghasilan Ayah Kandung</label>
                                            <select id="penghasilan_ayah" class="form-select" data-choices data-choices-sorting="true"
                                            name="penghasilan_ayah">
                                            <option selected>Pilih Pendapatan...</option>
                                            @foreach ($pendapatan as $item)
                                            <option {{ $item->name == $pendaftar->wali->penghasilan_ayah ? 'selected' : '' }}>
                                                {{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                            {{-- <input id="pekerjaan_ayah" class="form-control" name="penghasilan_ayah"
                                                value="100000000"> --}}
                                        </div>
                                        <!--end col-->
                                    </div>
                                    <!--end row-->
                                    <hr>
                                    <h4>Biodata Ibu</h4>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="nik_ibu" class="form-label">NIK Ibu Kandung</label>
                                            <input type="number" max="16" class="form-control" placeholder="Masukkan NIK Ibu"
                                                id="nik_ibu" value="{{ $pendaftar->wali->nik_ibu }}" name="nik_ibu">
                                        </div>
                                        <!--end col-->
                                        <div class="col-md-6 mb-3">
                                            <label for="status_ibu" class="form-label">Status Ibu Kandung</label>
                                            <select id="status_ibu" class="form-select" data-choices
                                                data-choices-sorting="true" name="status_ibu">
                                                <option selected>Pilih Status...</option>
                                                <option value="hidup"
                                                    {{ $pendaftar->wali->status_ibu == 'hidup' ? 'selected' : '' }}>Hidup
                                                </option>
                                                <option value="wafat"
                                                    {{ $pendaftar->wali->status_ibu == 'wafat' ? 'selected' : '' }}>Wafat
                                                </option>
                                            </select>
                                        </div>
                                        <!--end col-->
                                        <div class="col-md-6 mb-3">
                                            <label for="nama_ibu" class="form-label">Nama Ibu Kandung</label>
                                            <input type="text" class="form-control" placeholder="Masukkan Nama Ibu"
                                                id="nama_ibu" value="{{ $pendaftar->wali->nama_ibu }}" name="nama_ibu">
                                        </div>
                                        <!--end col-->
                                        <div class="col-md-6 mb-3">
                                            <label for="tanggal_lahir_ibu" class="form-label">Tanggal Lahir Ibu</label>
                                            <input type="date" class="form-control" placeholder="Masukkan Nama Ibu"
                                                id="tanggal_lahir_ibu" value="{{ $pendaftar->wali->tanggal_lahir_ibu }}"
                                                name="tanggal_lahir_ibu">
                                        </div>
                                        <!--end col-->
                                        <div class="col-md-4 mb-3">
                                            <label for="pendidikan_ibu" class="form-label">Pendidikan Ibu Kandung</label>
                                            <select id="pendidikan_ibu" class="form-select" data-choices data-choices-sorting="true"
                                            name="pendidikan_ibu">
                                            <option selected>Pilih Pendidikan Terakhir...</option>
                                            @foreach ($pendidikan as $item)
                                            <option {{ $item->name == $pendaftar->wali->pendidikan_ibu ? 'selected' : '' }}>
                                                {{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                            {{-- <input id="pendidikan_ibu" class="form-control" name="pendidikan_ibu"
                                                value="SMA"> --}}
                                        </div>
                                        <!--end col-->
                                        <div class="col-md-4 mb-3">
                                            <label for="pekerjaan_ibu" class="form-label">Pekerjaan Ibu Kandung</label>
                                            <select id="pekerjaan_ibu" class="form-select" data-choices data-choices-sorting="true"
                                            name="pekerjaan_ibu">
                                            <option selected>Pilih Pekerjaan...</option>
                                            @foreach ($profesi as $item)
                                            <option {{ $item->name == $pendaftar->wali->pekerjaan_ibu ? 'selected' : '' }}>
                                                {{ $item->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                            {{-- <input id="pekerjaan_ibu" class="form-control" name="pekerjaan_ibu"
                                                value="Dagang"> --}}
                                        </div>
                                        <!--end col-->
                                        <div class="col-md-4 mb-3">
                                            <label for="penghasilan_ibu" class="form-label">Penghasilan Ibu Kandung</label>
                                                                        <select id="penghasilan_ibu" class="form-select" data-choices data-choices-sorting="true"
                                                    name="penghasilan_ibu">
                                                    <option selected>Pilih Pendapatan...</option>
                                                    @foreach ($pendapatan as $item)
                                                    <option {{ $item->name == $pendaftar->wali->penghasilan_ibu ? 'selected' : '' }}>
                                                        {{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            {{-- <input id="penghasilan_ibu" class="form-control" name="penghasilan_ibu"
                                                value="1000000000"> --}}
                                        </div>
                                        <!--end col-->
                                    </div>

                                    <div class="d-flex align-items-start gap-3 mt-4">
                                        <button type="button" class="btn btn-primary btn-label right ms-auto nexttab"
                                            data-nexttab="pills-atribut-tab"><i
                                                class="ri-shirt-line label-icon align-middle fs-16 ms-2"></i>Lanjut ke
                                            Atribut</button>
                                    </div>
                                </div>
                            </div>
                            
                           
                            <div class="tab-pane fade" id="pills-atribut" role="tabpanel"
                            aria-labelledby="pills-atribut-tab">
                            <div>
                                <h5 class="mb-1">Atribut</h5>
                                <p class="text-muted mb-4">Isilah Informasi dibawah ini dengan sebenar-benarnya</p>
                            </div>
                        
                            <!-- Display the existing images from the table -->
                            <div class="mb-3">
                                <label for="gambarAtribut" class="form-label">Contoh Gambar Atribut</label>
                                <div class="row">
                                    @php
                                        $gambarPath = public_path('uploads/atribut-gambars');
                                        $gambarFiles = File::files($gambarPath);
                                    @endphp
                            
                                    @if(count($gambarFiles) > 0)
                                        @foreach($gambarFiles as $file)
                                            <div class="col-md-3 mb-3">
                                                <a href="{{ asset('uploads/atribut-gambars/' . basename($file)) }}" target="_blank">
                                                    <img src="{{ asset('uploads/atribut-gambars/' . basename($file)) }}" class="img-fluid" alt="Gambar Atribut" style="max-width: 100%;">
                                                </a>
                                                <p class="text-muted mt-2">Ukuran: {{ round(File::size($file) / 1024, 2) }} KB</p>
                                            </div>
                                        @endforeach
                                    @else
                                        <p class="text-muted">Tidak ada gambar atribut tersedia.</p>
                                    @endif
                                </div>
                            </div>
                            
                            
                        
                            <div class="mb-3">
                                <label for="atribut_kaos" class="form-label">Atribut Kaos</label>
                                <div class="row d-flex justify-content-around">
                                    @foreach ($ukuran as $item)
                                        <div class="col-2 form-check card-radio">
                                            <input class="form-check-input" type="radio" name="atribut_kaos"
                                                id="{{ 'atribut_kaos_' . $item }}" value="{{ $item }}"
                                                {{ $pendaftar->atribut->atribut_kaos == $item ? 'checked' : '' }}>
                                            <label class="form-check-label" for="{{ 'atribut_kaos_' . $item }}">{{ Str::upper($item) }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        
                            <div class="col-12 mb-3 ">
                                <label for="atribut_topi" class="form-label">Atribut Topi</label>
                                <div class="row d-flex justify-content-around">
                                    @foreach ($ukuran as $item)
                                        <div class="col-2 form-check card-radio">
                                            <input class="form-check-input" type="radio" name="atribut_topi"
                                                id="{{ 'atribut_topi_' . $item }}" value="{{ $item }}"
                                                {{ $pendaftar->atribut->atribut_topi == $item ? 'checked' : '' }}>
                                            <label class="form-check-label" for="{{ 'atribut_topi_' . $item }}">{{ Str::upper($item) }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        
                            <div class="col-12 mb-3 ">
                                <label for="atribut_almamater" class="form-label">Atribut Almamater</label>
                                <div class="row d-flex justify-content-around">
                                    @foreach ($ukuran as $item)
                                        <div class="col-2 form-check card-radio">
                                            <input class="form-check-input" type="radio" name="atribut_almamater"
                                                id="{{ 'atribut_almamater_' . $item }}" value="{{ $item }}"
                                                {{ $pendaftar->atribut->atribut_almamater == $item ? 'checked' : '' }}>
                                            <label class="form-check-label" for="{{ 'atribut_almamater_' . $item }}">{{ Str::upper($item) }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        
                            <div class="col-12 mb-3 ">
                                <label for="atribut_jas_lab" class="form-label">Atribut Jas Lab</label>
                                <div class="row d-flex justify-content-around">
                                    @foreach ($ukuran as $item)
                                        <div class="col-2 form-check card-radio">
                                            <input class="form-check-input" type="radio" name="atribut_jas_lab"
                                                id="{{ 'atribut_jas_lab_' . $item }}" value="{{ $item }}"
                                                {{ $pendaftar->atribut->atribut_jas_lab == $item ? 'checked' : '' }}>
                                            <label class="form-check-label" for="{{ 'atribut_jas_lab_' . $item }}">{{ Str::upper($item) }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        
                            <div class="col-12 mb-3 ">
                                <label for="atribut_baju_lapangan" class="form-label">Atribut Baju Lapangan</label>
                                <div class="row d-flex justify-content-around">
                                    @foreach ($ukuran as $item)
                                        <div class="col-2 form-check card-radio">
                                            <input class="form-check-input" type="radio" name="atribut_baju_lapangan"
                                                id="{{ 'atribut_baju_lapangan_' . $item }}" value="{{ $item }}"
                                                {{ $pendaftar->atribut->atribut_baju_lapangan == $item ? 'checked' : '' }}>
                                            <label class="form-check-label" for="{{ 'atribut_baju_lapangan_' . $item }}">{{ Str::upper($item) }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        
                            <div class="d-flex align-items-start gap-3 mt-4">
                                <button type="button" class="btn btn-primary btn-label right ms-auto nexttab" data-nexttab="pills-berkas-tab"><i
                                        class="ri-file-line label-icon align-middle fs-16 ms-2"></i>Lanjut ke Berkas Pendukung</button>
                            </div>
                        </div>
                        
                        
                            <!-- end tab pane -->

                            <div class="tab-pane fade" id="pills-berkas" role="tabpanel"
                                aria-labelledby="pills-berkas-tab">
                                <div>
                                    <h5 class="mb-1">Berkas Pendukung</h5>
                                    <p class="text-muted mb-4">Silakan Unggah Berkas Pendukung yang dibutuhkan</p>
                                </div>

                                <div>

                                    <div class="row">
                                        @foreach ($list_berkas as $berkas)
                                          <div class="col-lg-12 mb-3">
                                            <label for="{{ 'file-' . $berkas->berkas->nama_berkas }}"
                                              class="d-flex justify-content-between align-items-center">Upload Berkas
                                              {{ Str::upper($berkas->berkas->nama_berkas) }}
                                              {{-- <a class="btn btn-sm btn-primary" href="{{ asset('assets/file/' . $pendaftar->'file-'.$berkas ) }}"
                                                download>Download Berkas</a> --}}
                                            </label>
                                            <label for="{{ 'file-' . $berkas->berkas->nama_berkas }}" class="drop-container">
                                              <i class="display-4 text-muted ri-upload-cloud-2-fill"></i>
                                              <h4 class="drop-title">Drop files here or click to upload.</h4>
                                              <input type="file" name="{{ 'file[' . $berkas->berkas->nama_berkas . ']' }}"
                                                id="{{ 'file-' . $berkas->berkas->nama_berkas }}"
                                                accept="application/pdf,image/jpg,image/jpeg,image/png" required>
                                            </label>
                                          </div>
                                        @endforeach
                                      </div>

                                    <div class="d-flex align-items-start gap-3 mt-4">
                                        <button type="button" class="btn btn-light btn-label previestab" data-previous="pills-bio-diri-tab"><i
                                            class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>Kembali ke Biodata Diri</button>
                                        <button type="button" class="btn btn-primary btn-label right ms-auto"
                                            id="btn-submit"><i
                                                class="ri-save-line label-icon align-middle fs-16 ms-2"></i>Simpan</button>
                                    </div>
                                </div>
                            </div>

                            <!-- end tab pane -->

                            <div class="tab-pane fade" id="pills-finish" role="tabpanel"
                                aria-labelledby="pills-finish-tab">
                                <div class="text-center py-5">

                                    <div class="mb-4">
                                        <lord-icon src="https://cdn.lordicon.com/lupuorrc.json" trigger="loop"
                                            colors="primary:#0ab39c,secondary:#405189"
                                            style="width:120px;height:120px"></lord-icon>
                                    </div>
                                    <h5>Terima Kasih telah mengisi kelengkapan data !</h5>
                                    <p class="text-muted">Informasi ini bisa diubah kapan saja.</p>
                                </div>
                            </div>
                            <!-- end tab pane -->
                        </div>
                        <!-- end tab content -->
                    </form>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
        <!-- end col -->
    </div>
    <!-- end row -->
@endsection
@section('script')
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      var e = document.querySelectorAll('[data-plugin="choices"]');
      e && Array.from(e).forEach(function(e) {
        new Choices(e, {
          placeholderValue: "This is a placeholder set in the config",
          searchPlaceholderValue: "Search results here"
        })
      })
    });
    var KelengkapanDataTab = document.querySelectorAll(".kelengkapan-data-tab");
    KelengkapanDataTab && Array.from(document.querySelectorAll(".kelengkapan-data-tab")).forEach(function(o) {
      o.querySelectorAll(".nexttab") && Array.from(o.querySelectorAll(".nexttab")).forEach(function(t) {
        var e = o.querySelectorAll('button[data-bs-toggle="pill"]');
        e && (Array.from(e).forEach(function(e) {
          e.addEventListener("show.bs.tab", function(e) {
            e.target.classList.add("done")
          })
        }), t.addEventListener("click", function() {
          var e = t.getAttribute("data-nexttab");
          e && document.getElementById(e).click()
        }))
      }), document.querySelectorAll(".previestab") && Array.from(o.querySelectorAll(".previestab")).forEach(
        function(r) {
          r.addEventListener("click", function() {
            var e = r.getAttribute("data-previous");
            if (e) {
              var t = r.closest("form").querySelectorAll(".custom-nav .done").length;
              if (t) {
                for (var o = t - 1; o < t; o++) r.closest("form").querySelectorAll(".custom-nav .done")[o] && r
                  .closest("form").querySelectorAll(".custom-nav .done")[o].classList.remove("done");
                document.getElementById(e).click()
              }
            }
          })
        });
      var r = o.querySelectorAll('button[data-bs-toggle="pill"]');
      r && Array.from(r).forEach(function(e, t) {
        e.setAttribute("data-position", t), e.addEventListener("click", function() {
          0 < o.querySelectorAll(".custom-nav .done").length && Array.from(o.querySelectorAll(
            ".custom-nav .done")).forEach(function(e) {
            e.classList.remove("done")
          });
          for (var e = 0; e <= t; e++) r[e].classList.contains("active") ? r[e].classList.remove("done") : r[
            e].classList.add("done")
        })
      })
    });
  </script>
<script>
  $(document).ready(function() {
      $('#provinsi').change(function() {
          var provinsiId = $(this).val();
  
          // Kosongkan dropdown kabupaten
          $('#kabupaten').empty();
          $('#kabupaten').append('<option value="">-- Pilih Kabupaten/Kota --</option>');
  
          // Cek jika provinsiId tidak kosong
          if (provinsiId) {
              $.ajax({
                  url: 'http://backend.sepyankristanto.my.id/api/v1/master/cities', // Endpoint untuk mendapatkan kabupaten/kota
                  type: 'GET',
                  headers: {
                      'Authorization': '874|mO9pzhlhLHttWSVPBPXc0hrza1fpMizrM7e6VdqN' // Token Anda
                  },
                  success: function(response) {
                      var kabupatenKotaData = response.data;
  
                      // Filter data kabupaten/kota berdasarkan provinsi
                      $.each(kabupatenKotaData, function(key, kabupaten) {
                          // Cek apakah ID parent kabupaten sama dengan ID provinsi
                          if (kabupaten.parent.id == provinsiId) { 
                              $('#kabupaten').append('<option value="' + kabupaten.id + '">' + kabupaten.name.trim() + '</option>'); // Menggunakan trim untuk menghilangkan spasi
                          }
                      });
                      
                      // Cek apakah ada kabupaten yang ditambahkan
                      if ($('#kabupaten option').length <= 1) {
                          $('#kabupaten').append('<option value="">Tidak ada Kabupaten/Kota</option>');
                      }
                  },
                  error: function(xhr, status, error) {
                      console.error('Error fetching data:', error);
                  }
              });
          }
      });
  });
</script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var e = document.querySelectorAll('[data-plugin="choices"]');
            e && Array.from(e).forEach(function(e) {
                new Choices(e, {
                    placeholderValue: "This is a placeholder set in the config",
                    searchPlaceholderValue: "Search results here"
                })
            })
        });
        var KelengkapanDataTab = document.querySelectorAll(".kelengkapan-data-tab");
        KelengkapanDataTab && Array.from(document.querySelectorAll(".kelengkapan-data-tab")).forEach(function(o) {
            o.querySelectorAll(".nexttab") && Array.from(o.querySelectorAll(".nexttab")).forEach(function(t) {
                    var e = o.querySelectorAll('button[data-bs-toggle="pill"]');
                    e && (Array.from(e).forEach(function(e) {
                        e.addEventListener("show.bs.tab", function(e) {
                            e.target.classList.add("done")
                        })
                    }), t.addEventListener("click", function() {
                        var e = t.getAttribute("data-nexttab");
                        e && document.getElementById(e).click()
                    }))
                }), document.querySelectorAll(".previestab") && Array.from(o.querySelectorAll(".previestab"))
                .forEach(
                    function(r) {
                        r.addEventListener("click", function() {
                            var e = r.getAttribute("data-previous");
                            if (e) {
                                var t = r.closest("form").querySelectorAll(".custom-nav .done").length;
                                if (t) {
                                    for (var o = t - 1; o < t; o++) r.closest("form").querySelectorAll(
                                            ".custom-nav .done")[o] && r
                                        .closest("form").querySelectorAll(".custom-nav .done")[o].classList
                                        .remove("done");
                                    document.getElementById(e).click()
                                }
                            }
                        })
                    });
            var r = o.querySelectorAll('button[data-bs-toggle="pill"]');
            r && Array.from(r).forEach(function(e, t) {
                e.setAttribute("data-position", t), e.addEventListener("click", function() {
                    0 < o.querySelectorAll(".custom-nav .done").length && Array.from(o
                        .querySelectorAll(
                            ".custom-nav .done")).forEach(function(e) {
                        e.classList.remove("done")
                    });
                    for (var e = 0; e <= t; e++) r[e].classList.contains("active") ? r[e].classList
                        .remove("done") : r[
                            e].classList.add("done")
                })
            })
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#provinsi').change(function() {
                var provinsiId = $(this).val();

                // Kosongkan dropdown kabupaten
                $('#kabupaten').empty();
                $('#kabupaten').append('<option value="">-- Pilih Kabupaten/Kota --</option>');


                // Cek jika provinsiId tidak kosong
                if (provinsiId) {
                    $.ajax({
                        url: 'http://backend.sepyankristanto.my.id/api/v1/master/cities', // Endpoint untuk mendapatkan kabupaten/kota
                        type: 'GET',
                        headers: {
                            'Authorization': 'Bearer 874|mO9pzhlhLHttWSVPBPXc0hrza1fpMizrM7e6VdqN' // Token Anda
                        },
                        success: function(response) {
                            var kabupatenKotaData = response.data;


                            // Filter data kabupaten/kota berdasarkan provinsi
                            $.each(kabupatenKotaData, function(key, kabupaten) {
                                // Cek apakah ID parent kabupaten sama dengan ID provinsi
                                if (kabupaten.parent.id == provinsiId) {
                                    $('#kabupaten').append('<option value="' + kabupaten
                                        .id + '">' + kabupaten.name.trim() +
                                        '</option>'
                                    ); // Menggunakan trim untuk menghilangkan spasi
                                }
                            });

                            // Cek apakah ada kabupaten yang ditambahkan
                            if ($('#kabupaten option').length <= 1) {
                                $('#kabupaten').append(
                                    '<option value="">Tidak ada Kabupaten/Kota</option>');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error fetching data:', error);
                        }
                    });
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#kabupaten').change(function() {
                var kabupatenId = $(this).val(); // Ambil ID kabupaten yang dipilih

                // Kosongkan dropdown kecamatan
                $('#kecamatan').empty();
                $('#kecamatan').append('<option value="">-- Pilih Kecamatan --</option>');

                // Cek jika kabupatenId tidak kosong
                if (kabupatenId) {
                    $.ajax({
                        url: 'http://backend.sepyankristanto.my.id/api/v1/master/sub-districts', // Endpoint untuk mendapatkan kecamatan
                        type: 'GET',
                        headers: {
                            'Authorization': 'Bearer 874|mO9pzhlhLHttWSVPBPXc0hrza1fpMizrM7e6VdqN' // Token Anda
                        },
                        success: function(response) {
                            var kecamatanData = response.data;

                            // Filter kecamatan berdasarkan parent.id (ID kabupaten)
                            $.each(kecamatanData, function(key, kecamatan) {
                                // Pastikan parent tidak null sebelum mengakses id-nya
                                if (kecamatan.parent && kecamatan.parent.id ==
                                    kabupatenId) {
                                    $('#kecamatan').append('<option value="' + kecamatan
                                        .id + '">' + kecamatan.name.trim() +
                                        '</option>');
                                }
                            });

                            // Cek apakah ada kecamatan yang ditambahkan
                            if ($('#kecamatan option').length <= 1) {
                                $('#kecamatan').append(
                                    '<option value="">Tidak ada Kecamatan</option>');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error fetching data:', error);
                        }
                    });
                } else {
                    $('#kecamatan').empty();
                    $('#kecamatan').append('<option value="">Pilih Kecamatan</option>');
                }
            });
        });
    </script>

    {{-- <script>
  provinsi.addEventListener('change', (event) => {
    let id_provinsi = provinsi.value;

    // Kosongkan dropdown kabupaten/kota
    kabupaten.innerHTML = '<option value="">Pilih Kabupaten/Kota...</option>';

    // Memanggil endpoint untuk mengambil data kabupaten
    fetch(`http://localhost:8000/api/get-kabupaten/${id_provinsi}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            data.forEach(kota => {
                let option = document.createElement('option');
                option.value = kota.id; // Pastikan ini sesuai dengan struktur data yang diterima
                option.textContent = kota.name; // Ganti dengan nama kabupaten/kota
                kabupaten.appendChild(option);
            });
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
});

</script> --}}
    {{-- <script>
  $(document).ready(function() {
      // Ketika halaman siap, jalankan AJAX
      $.ajax({
          url: '/api/get-provinsi',  // Route API
          method: 'GET',
          success: function(data) {
              // Jika request sukses, iterasi data dan masukkan ke dropdown
              let dropdown = $('#provinsi');
              dropdown.empty(); // Kosongkan dropdown

              dropdown.append('<option value="">-- Pilih Provinsi --</option>'); // Option default
              
              // Looping melalui data provinsi
              $.each(data, function(index, provinsiItem) {
                  dropdown.append('<option value="' + provinsiItem.id + '">' + provinsiItem.nama + '</option>');
              });
          },
          error: function(err) {
              console.log("Terjadi kesalahan:", err);
          }
      });
  });
</script> --}}
    <script>
        let button = document.getElementById('btn-submit')
        let form = document.getElementById('myform')

        button.addEventListener('click', (event) => {
            form.submit()
            console.log(form);
        })
    </script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
@endsection
