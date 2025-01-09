@extends('layouts.master')
@section('title')
  Pembayaran UKT
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
      Dashboard
    @endslot
    @slot('title')
      Pembayaran UKT
    @endslot
  @endcomponent
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <div class="row mb-4">
    <div class="col-xl-6">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body p-0">
              <div class="alert alert-danger border-0 rounded-0 m-0 d-flex align-items-center" role="alert">
                <i data-feather="alert-triangle" class="text-danger me-2 icon-sm"></i>
                <div class="flex-grow-1 text-truncate">
                  Anda belum membayar UKT
                </div>
              </div>
              @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
           <!-- Tombol untuk membuka Modal Pengajuan Keringanan/Pencicilan UKT -->
<button type="button" class="btn btn-secondary px-3 py-1 mt-3" data-bs-toggle="modal" data-bs-target="#modalPencicilan">
  Ajukan Pencicilan UKT
</button>

<button type="button" class="btn btn-secondary px-3 py-1 mt-3" data-bs-toggle="modal" data-bs-target="#modalKeringanan">
  Ajukan Keringanan UKT
</button>


              <div class="row align-items-end">
                <div class="col-sm-12">
                  <div class="text-center py-5">
                    <div class="mb-4">
                      <lord-icon src="https://cdn.lordicon.com/kbtmbyzy.json" trigger="loop"
                        colors="primary:#0ab39c,secondary:#405189" style="width:120px;height:120px"></lord-icon>
                    </div>

                    <h5>Silakan lakukan pembayaran UKT</h5>
                    <p class="text-muted">Nomor Virtual Akun Bank BNI</p>
                    @if ($nomer_va == null)
                      <button type="submit" class="btn btn-primary px-3 py-1 show-details">Dapatkan Virtual Account
                        Pembayaran UKT
                      </button>
                    @else
                      <h3 class="fw-semibold">{{ $nomer_va }}</h3>
                      <p class="fw-semibold">
                        Nominal Pembayaran UKT: 
                        Rp. 
                        {{ 
                            $detailPendaftar->status_cicilan === 'disetujui' 
                            ? number_format($detailPendaftar->cicilan_pertama, 0, ',', '.') 
                            : number_format($detailPendaftar->nominal_ukt, 0, ',', '.') 
                        }}
                    </p>
                    
                      <p class="text-muted">Pembayaran paling lambat tanggal
                        {{ Carbon\Carbon::parse($expired_va)->format('d-m-Y') }}</p>
                    
                    @endif
                  </div>
                </div>
              </div>
            </div> <!-- end card-body-->
          </div>
        </div> <!-- end col-->
        <div class="col-12">
          <div class="card">
            <div class="card-body p-0">
              <div class="alert alert-info border-0 rounded-0 m-0 d-flex align-items-center" role="alert">
                <i data-feather="alert-triangle" class="text-info me-2 icon-sm"></i>
                <div class="flex-grow-1 text-truncate">
                  Upload Bukti Pembayaran UKT
                </div>
              </div>

              <div class="row align-items-end">
                <div class="col-12">
                  <div class="text-end p-5">
                    <form action="{{ route('upload-bukti-ukt') }}" method="post" enctype="multipart/form-data">
                      @csrf
                      <input type="hidden" name="id" value="{{ session('pendaftar_id') }}">
                      <label for="file-bukti-bayar-ukt" class="d-flex justify-content-between align-items-center">Bukti
                        UKT
                      </label>
                      <label for="file-bukti-bayar-ukt" class="drop-container">
                        <i class="display-4 text-muted ri-upload-cloud-2-fill"></i>
                        <h4 class="drop-title">Drop files here or click to upload.</h4>
                        <input type="file" name="bukti_bayar_ukt" id="file-bukti-bayar-ukt" accept="image/jpg"
                          required>
                      </label>

                      <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                  </div>
                </div>
              </div>
            </div> <!-- end card-body-->
          </div>
        </div> <!-- end col-->
      </div> <!-- end row-->
    </div> <!-- end col-->

    <div class="col-xl-6">
      <div class="accordion custom-accordionwithicon custom-accordion-border accordion-border-box" id="genques-accordion">
        @foreach ($tata_cara as $index => $item)
          @if ($loop->first)
            <div class="accordion-item">
              <h2 class="accordion-header" id="{{ 'collapse-header-' . $loop->iteration }}">
                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                  data-bs-target="#{{ 'collapse-' . $loop->iteration }}" aria-expanded="true"
                  aria-controls="{{ 'collapse-' . $loop->iteration }}">
                  {{ $loop->iteration . '. ' . Str::title($index) }}
                </button>
              </h2>
              <div id="{{ 'collapse-' . $loop->iteration }}" class="accordion-collapse collapse show"
                aria-labelledby="{{ 'collapse-header-' . $loop->iteration }}" data-bs-parent="#genques-accordion">
                <div class="accordion-body ff-secondary">
                  <ol class="list-group list-group-numbered">
                    @foreach ($item as $i)
                      <li class="list-group-item">{{ $i->deskripsi }}</li>
                    @endforeach
                  </ol>
                </div>
              </div>
            </div>
          @else
            <div class="accordion-item">
              <h2 class="accordion-header" id="{{ 'collapse-header-' . $loop->iteration }}">
                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                  data-bs-target="#{{ 'collapse-' . $loop->iteration }}" aria-expanded="true"
                  aria-controls="{{ 'collapse-' . $loop->iteration }}">
                  {{ $loop->iteration . '. ' . Str::title($index) }}
                </button>
              </h2>
              <div id="{{ 'collapse-' . $loop->iteration }}" class="accordion-collapse collapse hide"
                aria-labelledby="{{ 'collapse-header-' . $loop->iteration }}" data-bs-parent="#genques-accordion">
                <div class="accordion-body ff-secondary">
                  <ol class="list-group list-group-numbered">
                    @foreach ($item as $i)
                      <li class="list-group-item">{{ $i->deskripsi }}</li>
                    @endforeach
                  </ol>
                </div>
              </div>
            </div>
          @endif
        @endforeach
      </div>
    </div>

    @if($detailPendaftar->status_cicilan === 'disetujui')
    <div class="col-xl-6">
      <div class="card">
        <div class="card-header bg-info text-white">
          <h5 class="mb-0">Cicilan UKT Anda</h5>
        </div>
        <div class="card-body">
          <div class="mb-3">
            <h6>Total UKT: <span class="fw-bold">Rp. {{ number_format($detailPendaftar->nominal_ukt, 0, ',', '.') }}</span></h6>
          </div>
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead class="bg-light">
                <tr>
                  <th scope="col">Deskripsi</th>
                  <th scope="col">Nilai</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><strong>Jatuh Tempo</strong></td>
                  <td>{{ $detailPendaftar->jatuh_tempo }}</td>
                </tr>
                <tr>
                  <td><strong>Cicilan Pertama</strong></td>
                  <td>Rp. {{ number_format($detailPendaftar->cicilan_pertama, 0, ',', '.') }}</td>
                </tr>
                <tr>
                  <td><strong>Cicilan Kedua</strong></td>
                  <td>Rp. {{ number_format($detailPendaftar->cicilan_kedua, 0, ',', '.') }}</td>
                </tr>
                <tr>
                  <td><strong>Cicilan Ketiga</strong></td>
                  <td>Rp. {{ number_format($detailPendaftar->cicilan_ketiga, 0, ',', '.') }}</td>
                </tr>
                <tr>
                  <td><strong>Status Cicilan</strong></td>
                  <td>
                    @if ($detailPendaftar->status_cicilan === 'lunas')
                      <span class="badge bg-success">Lunas</span>
                    @elseif ($detailPendaftar->status_cicilan === 'belum')
                      <span class="badge bg-danger">Belum Lunas</span>
                    @else
                      <span class="badge bg-warning">Dalam Proses</span>
                    @endif
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    
  @endif
  
   
    
    <!--end col -->
  </div> <!-- end row-->

  <!-- Modal Pengajuan Pencicilan UKT -->

  <div class="modal fade" id="modalPencicilan" tabindex="-1" aria-labelledby="modalPencicilanLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalPencicilanLabel">Pengajuan Pencicilan UKT</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

        <form action="{{ route('pendaftar.pencicilan-ukt.ajukan') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="modal-body">
            @if($detailPendaftar && $detailPendaftar->status_cicilan === 'Pending')
            <div id="alertStatus" class="alert alert-warning" role="alert">
                Pengajuan cicilan UKT Anda dalam proses.
            </div>
        @endif
        
            <div class="mb-3">
              <label for="jumlahUkt" class="form-label">Jumlah Total UKT</label>
              <input type="number" class="form-control" id="jumlahUkt" name="nominal_ukt" value="{{ old('nominal_ukt') }}"  required>
            </div>
            <div class="mb-3">
              <label for="jumlahCicilan1" class="form-label">Jumlah Cicilan Bulan 1</label>
              <input type="text" class="form-control uang" id="jumlahCicilan1" name="cicilan_pertama" required>
              <small class="form-text text-muted">Cicilan bulan pertama</small>
            </div>
            <div class="mb-3">
              <label for="jumlahCicilan2" class="form-label">Jumlah Cicilan Bulan 2</label>
              <input type="text" class="form-control uang" id="jumlahCicilan2" name="cicilan_kedua" required>
              <small class="form-text text-muted">Cicilan bulan kedua</small>
            </div>
            <div class="mb-3">
              <label for="jumlahCicilan3" class="form-label">Jumlah Cicilan Bulan 3</label>
              <input type="text" class="form-control uang" id="jumlahCicilan3" name="cicilan_ketiga" required>
              <small class="form-text text-muted">Cicilan bulan ketiga</small>
            </div>
            <!-- Input File untuk Dokumen Pengajuan -->
            <div class="mb-3">
              <label for="dokumenCicilan" class="form-label">Dokumen Pendukung</label>
              <input type="file" class="form-control" id="dokumenCicilan" name="dokumen" required>
            </div>
            <!-- Link untuk Download Template -->
            <div class="mb-3">
              <label class="form-label">Download Template Dokumen</label>
              <a href="{{ asset('template/template_pencicilan_ukt.docx') }}" class="btn btn-link" download>Download Template</a>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Ajukan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  
  

<!-- Modal Pengajuan Keringanan UKT -->
<div class="modal fade" id="modalKeringanan" tabindex="-1" aria-labelledby="modalKeringananLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalKeringananLabel">Pengajuan Keringanan UKT</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('pendaftar.keringanan-ukt.ajukan') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          {{-- @if($status_pengajuan == 'disetujui')
          <div class="alert alert-success" role="alert">
            Pengajuan keringanan UKT Anda sudah disetujui!
          </div>
        @elseif($status_pengajuan == 'ditolak')
          <div class="alert alert-danger" role="alert">
            Pengajuan keringanan UKT Anda ditolak.
          </div>
        @else
          <div class="alert alert-warning" role="alert">
            Pengajuan keringanan UKT Anda dalam proses.
          </div>
        @endif --}}
        <div id="alertStatus" class="alert alert-warning" role="alert">
          Pengajuan keringanan UKT Anda dalam proses.
        </div>
          <div class="mb-3">
            <label for="nominalUkt" class="form-label">Nominal UKT</label>
            <input type="number" class="form-control" id="nominalUkt" name="nominal_ukt" value="{{ $nominal_ukt }}" readonly required>
          </div>
          <div class="mb-3">
            <label for="nominalKeringanan" class="form-label">Nominal Keringanan</label>
            <input type="text" class="form-control uang" id="nominalKeringanan" name="nominal_keringanan" required>
            <small class="form-text text-muted">Masukkan nominal keringanan yang diajukan.</small>
          </div>
          <div class="mb-3">
            <label for="alasanKeringanan" class="form-label">Alasan Pengajuan</label>
            <textarea class="form-control" id="alasanKeringanan" name="alasan" rows="3" required></textarea>
          </div>
          <!-- Input File untuk Dokumen Pengajuan -->
          <div class="mb-3">
            <label for="dokumenKeringanan" class="form-label">Dokumen Pendukung</label>
            <input type="file" class="form-control" id="dokumenKeringanan" name="dokumen" required>
          </div>
          <!-- Link untuk Download Template -->
          <div class="mb-3">
            <label class="form-label">Download Template Dokumen</label>
            <a href="{{ asset('template/template_keringanan_ukt.docx') }}" class="btn btn-link" download>Download Template</a>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Ajukan</button>
        </div>
      </form>
    </div>
  </div>
</div>



  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script type="text/javascript">
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $(".show-details").click(function(e) {
      e.preventDefault();
      var nominal_ukt = "<?php echo $nominal_ukt; ?>";
      var nama_pendaftar = "<?php echo $nama_pendaftar; ?>";
      var id_pendaftar = "<?php echo $id_pendaftar; ?>";
      var nomer_va = "<?php echo $nomer_va; ?>";
      // alert(nomer_va);

      $.ajax({
        type: 'post',
        url: "{{ URL('cek_va_ukt') }}",
        data: {
          nominal_ukt: nominal_ukt,
          nama_pendaftar: nama_pendaftar,
          id_pendaftar: id_pendaftar
        },
        success: function(data) {
          location.reload();
          // console.log(data);
          //  alert(data);
        }
      });

    });
  </script>

@endsection
@section('script')
  <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
