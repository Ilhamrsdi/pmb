@extends('layouts.master')
@section('title')
    Pembayaran Biaya Pendaftaran
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
            Pembayaran Biaya Pendaftaran
        @endslot
    @endcomponent

    <div class="row mb-4">
        <div class="col-xl-6">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body p-0">
                            <div class="alert alert-danger border-0 rounded-0 m-0 d-flex align-items-center" role="alert">
                                <i data-feather="alert-triangle" class="text-danger me-2 icon-sm"></i>
                                <div class="flex-grow-1 text-truncate">
                                    Anda belum Terdaftar
                                </div>
                            </div>

                            <div class="row align-items-end">
                                <div class="col-sm-12">
                                    <div class="text-center py-5">
                                        <div class="mb-4">
                                            <lord-icon src="https://cdn.lordicon.com/kbtmbyzy.json" trigger="loop"
                                                colors="primary:#0ab39c,secondary:#405189"
                                                style="width:120px;height:120px"></lord-icon>
                                        </div>
                                        <h5>Silakan lakukan pembayaran biaya pendaftaran</h5>
                                        <p class="text-muted">Nomor Virtual Akun Bank BNI</p>
                                        <h3 class="fw-semibold">{{ $nomer_va }}</h3>
                                        <p class="text-muted">Pembayaran paling lambat tanggal
                                            {{ Carbon\Carbon::parse($expired_va)->format('d-m-Y') }}</p>
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
                                    Upload Bukti Pembayaran Pendaftaran
                                </div>
                            </div>

                            <div class="row align-items-end">
                                <div class="col-12">
                                    <div class="text-end p-5">
                                        @php
                                            // Cek apakah file bukti pembayaran sudah ada
                                            $uploadedFilePath = '';
                                            $uploadedExtensions = ['jpg', 'png', 'jpeg']; // Ekstensi file yang didukung
                                            foreach ($uploadedExtensions as $ext) {
                                                $possibleUploadedFile =
                                                    'assets/file/bukti-pendaftaran/' .
                                                    $dataPendaftar .
                                                    '.' .
                                                    $ext;
                                                if (file_exists(public_path($possibleUploadedFile))) {
                                                    $uploadedFilePath = asset($possibleUploadedFile);
                                                    break;
                                                }
                                            }
                                        @endphp

                                        @if ($uploadedFilePath)
                                            {{-- Tampilkan bukti pembayaran yang sudah diunggah --}}
                                            <div class="text-center">
                                                <p>Bukti pembayaran Anda sudah diunggah:</p>
                                                <img src="{{ $uploadedFilePath }}" alt="Bukti Pembayaran" class="img-fluid rounded mb-3" style="max-width: 100%; height: auto;">
                                                <p><a href="{{ $uploadedFilePath }}" class="btn btn-primary" download>Download Bukti Pembayaran</a></p>
                                                <form action="{{ route('upload-bukti-pendaftaran') }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ session('pendaftar_id') }}">
                                                
                                                    <!-- Jika sudah ada file yang diupload -->
                                                    @if(session('file_uploaded'))
                                                        <div class="uploaded-file">
                                                            <p>File yang telah diupload:</p>
                                                            <img src="{{ asset('storage/' . session('file_uploaded')) }}" alt="Bukti Bayar" style="max-width: 200px;">
                                                        </div>
                                                    @endif
                                                
                                                    <!-- Form upload file, sembunyikan dengan display: none -->
                                                    <div id="upload-form" style="display: none;">
                                                        <label for="file-bukti-bayar-pendaftaran" class="drop-container">
                                                            <h4 class="drop-title">Drop files here or click to upload.</h4>
                                                            <input type="file" name="bukti_bayar_pendaftaran" id="file-bukti-bayar-pendaftaran" accept="image/jpg,image/png,image/jpeg" required>
                                                        </label>
                                                    </div>
                                                
                                                    <!-- Tombol Upload Ulang -->
                                                    <button type="button" class="btn btn-primary" id="upload-ulang-btn">
                                                        @if(session('file_uploaded'))
                                                            Upload Ulang
                                                        @else
                                                            Upload
                                                        @endif
                                                    </button>
                                                
                                                    <!-- Tombol submit, tampilkan jika file diupload ulang -->
                                                    <button type="submit" class="btn btn-primary" id="submit-btn" style="display: none;">
                                                        Upload Ulang
                                                    </button>
                                                </form>

                                            </div>
                                        @else
                                            {{-- Form untuk mengunggah bukti pembayaran --}}
                                            <form action="{{ route('upload-bukti-pendaftaran') }}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ session('pendaftar_id') }}">
                                                <label for="file-bukti-bayar-pendaftaran" class="drop-container">
                                                    <i class="display-4 text-muted ri-upload-cloud-2-fill"></i>
                                                    <h4 class="drop-title">Drop files here or click to upload.</h4>
                                                    <input type="file" name="bukti_bayar_pendaftaran" id="file-bukti-bayar-pendaftaran" accept="image/jpg, image/png, image/jpeg" required>
                                                </label>
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end card-body-->
                    </div>
                </div> <!-- end col-->
            </div> <!-- end row-->
        </div> <!-- end col-->

        <div class="col-xl-6">
            <div class="accordion custom-accordionwithicon custom-accordion-border accordion-border-box"
                id="genques-accordion">
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
                                aria-labelledby="{{ 'collapse-header-' . $loop->iteration }}"
                                data-bs-parent="#genques-accordion">
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
                                aria-labelledby="{{ 'collapse-header-' . $loop->iteration }}"
                                data-bs-parent="#genques-accordion">
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

    </div> <!-- end row-->
@endsection
@section('script')
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>

<script>
    // Ambil elemen-elemen yang dibutuhkan
    const uploadForm = document.getElementById('upload-form');
    const uploadButton = document.getElementById('upload-ulang-btn');
    const submitButton = document.getElementById('submit-btn');

    // Fungsi untuk menampilkan form upload ketika tombol ditekan
    uploadButton.addEventListener('click', function() {
        uploadForm.style.display = 'block'; // Menampilkan form upload
        submitButton.style.display = 'inline'; // Menampilkan tombol submit
        uploadButton.style.display = 'none'; // Menyembunyikan tombol upload ulang
    });
</script>
@endsection
