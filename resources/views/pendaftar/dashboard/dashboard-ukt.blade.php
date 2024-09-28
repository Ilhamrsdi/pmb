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
                        {{-- <a class="btn btn-sm btn-primary" href="{{ asset('assets/file/' . $pendaftar->'file-'.$berkas ) }}"
                                  download>Download Berkas</a> --}}
                      </label>
                      <label for="file-bukti-bayar-ukt" class="drop-container">
                        <i class="display-4 text-muted ri-upload-cloud-2-fill"></i>
                        <h4 class="drop-title">Drop files here or click to upload.</h4>
                        <input type="file" name="bukti_bayar_ukt" id="file-bukti-bayar-ukt" accept="image/jpg"
                          required>
                      </label>

                      <button type="submit" class="btn btn-primary">simpan</button>
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
    <!--end col -->

  </div> <!-- end row-->;
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
