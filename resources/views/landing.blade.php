<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
  data-sidebar-image="none">

<head>
  <meta name="csrf-token" content="{{ csrf_token() }}" />

  <meta charset="utf-8" />
  <title>PMB Politeknik Negeri Banyuwangi</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
  <meta content="Themesbrand" name="author" />
  <!-- App favicon -->
  <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

  <!--Swiper slider css-->
  <link href="{{ asset('assets/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css" />

  <!-- Layout config Js -->
  <script src="{{ asset('assets/js/layout.js') }}"></script>
  <!-- Bootstrap Css -->
  <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
  <!-- Icons Css -->
  <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
  <!-- App Css-->
  <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
  <!-- swiper css-->
  <link href="{{ asset('assets/libs/swiper/swiper.min.css') }}" />
  <!-- custom Css-->
  <link href="{{ asset('assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.7/dist/sweetalert2.min.css" rel="stylesheet">
  {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>


  {{-- <style>
    @keyframes movePattern {
      0% {
        transform: translateY(0);
      }
      50% {
        transform: translateY(-20px);
      }
      100% {
        transform: translateY(0);
      }
    }
  
    .demo-img-patten-top img {
      animation: movePattern 3s ease-in-out infinite;
    }
  </style> --}}
  <style>
    .demo-img-patten-top img {
      position: relative;
      transition: transform 1.5s ease-in-out;
    }
  </style>
    

</head>

<body data-bs-spy="scroll" data-bs-target="#navbar-example">

  <!-- Begin page -->
  <div class="layout-wrapper landing">
    <nav class="navbar navbar-expand-lg navbar-landing fixed-top" id="navbar">
      <div class="container">
        <a class="navbar-brand" href="/">
          <img src="assets/images/logo-dark.png" class="card-logo card-logo-dark" alt="logo dark" height="50">
          {{-- <img src="assets/images/logo-light.png" class="card-logo card-logo-light" alt="logo light" height="50"> --}}
        </a>
        <button class="navbar-toggler py-0 fs-20 text-body" type="button" data-bs-toggle="collapse"
          data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
          aria-label="Toggle navigation">
          <i class="mdi mdi-menu"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mx-auto mt-2 mt-lg-0" id="navbar-example">
            <li class="nav-item">
              <a class="nav-link active" href="#hero">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#layanan">Layanan</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#tata_cara">Tata Cara</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#pendaftaran">Pendaftaran</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#pengumuman">Pengumuman</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#tentang">Tentang</a>
            </li>
          </ul>

          <div class="">
            <a href="{{ url('login') }}" class="btn btn-primary">Sign In</a>
          </div>
        </div>

      </div>
    </nav>
    <!-- end navbar -->

    <!-- start hero section -->
    <section class="section pb-0 hero-section" id="hero">
      <div class="bg-overlay bg-overlay-pattern"></div>
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-8 col-sm-10">
            <div class="text-center mt-lg-5 pt-5">
              <h1 class="display-6 fw-semibold mb-3 lh-base">Pendaftaran Mahasiswa Baru
                <p class="lead text-muted lh-base">Politeknik Negeri Banyuwangi</p>

                <div class="d-flex gap-2 justify-content-center mt-4">
                  <a href="#pendaftaran" class="btn btn-primary">Daftar Sekarang <i
                      class="ri-arrow-right-line align-middle ms-1"></i></a>
                  <a href="https://www.youtube.com/embed/bnbKP_R8uDg?autoplay=1&controls=0&start=0&end=0&modestbranding=1&wmode=transparent&enablejsapi=1&loop=1&rel=0&mute=1&playlist=bnbKP_R8uDg"
                    class="btn btn-danger">Lihat Video <i class="ri-eye-line align-middle ms-1"></i></a>
                </div>
            </div>

            <div class="mt-4 mt-sm-5 pt-sm-5 mb-sm-n5 demo-carousel">
              <div class="demo-img-patten-top d-none d-sm-block">
                <img src="assets/images/landing/img-pattern.png" class="d-block img-fluid" alt="...">
              </div>
              <div class="demo-img-patten-bottom d-none d-sm-block">
                <img src="assets/images/landing/img-pattern.png" class="d-block img-fluid" alt="...">
              </div>
              <div class="carousel slide carousel-fade" data-bs-ride="carousel">
                <div class="carousel-inner shadow-lg p-2 bg-white rounded">
                  <div class="carousel-item active" data-bs-interval="2000">
                    <img src="assets/images/demos/hero-image-1.png" class="d-block w-100"
                      alt="Hero Image Politeknik Negeri Banyuwangi">
                  </div>
                  <div class="carousel-item" data-bs-interval="2000">
                    <img src="assets/images/demos/hero-image-2.png" class="d-block w-100"
                      alt="Hero Image Politeknik Negeri Banyuwangi">
                  </div>
                  <div class="carousel-item" data-bs-interval="2000">
                    <img src="assets/images/demos/hero-image-3.png" class="d-block w-100"
                      alt="Hero Image Politeknik Negeri Banyuwangi">
                  </div>
                  <div class="carousel-item" data-bs-interval="2000">
                    <img src="assets/images/demos/hero-image-4.png" class="d-block w-100"
                      alt="Hero Image Politeknik Negeri Banyuwangi">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- end row -->
      </div>
      <!-- end container -->
      <div class="position-absolute start-0 end-0 bottom-0 hero-shape-svg">
        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
          viewBox="0 0 1440 120">
          <g mask="url(&quot;#SvgjsMask1003&quot;)" fill="none">
            <path d="M 0,118 C 288,98.6 1152,40.4 1440,21L1440 140L0 140z">
            </path>
          </g>
        </svg>
      </div>
      <!-- end shape -->
    </section>
    <!-- end hero section -->

    <!-- start layanan -->
    <section class="section" id="layanan">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-8">
            <div class="text-center mb-5">
              <h1 class="mb-3 ff-secondary fw-semibold lh-base">A Collaborative Learning By Enterprising
              </h1>
              <p class="text-muted">Poliwangi memegang teguh keyakinan bahwa kolaborasi penting dalam
                proses
                pembelajaran saat ini, tidak hanya dari segi pengetahuan dan kemampuan teoritis tetapi
                juga untuk
                penerapan kesatuan ilmu dalam dunia bisnis dan dunia kerja.</p>
            </div>
          </div>
          <!-- end col -->
        </div>
        <!-- end row -->
        <div class="row">
          @foreach ($gelombang as $key => $h)
            <div class='col-sm-6 col-xl-3'>
              <div class="card">
                <div class="card-body bg-primary text-light text-center py-5 ">
                  <div class="position-relative">
                    <h3 class="card-title mb-3 text-light">
                        {{ Str::upper($h->nama_gelombang) }}
                    </h3>
                    @if (strtolower($h->status) == 'active')
                        <span
                            class="position-absolute top-0 start-100 translate-middle badge badge-label bg-success">
                            {{ $h->status }}
                        </span>
                    @else
                        <span
                            class="position-absolute top-0 start-100 translate-middle badge badge-label bg-danger">
                            {{ $h->status }}
                        </span>
                    @endif
                </div>
                
                  <h6 class="card-subtitle font-14 text-light mb-3">{{ $h->tahun_ajaran }}</h6>
                  <p class="card-subtitle text-light">
                    {{ Carbon\Carbon::parse($h->tanggal_mulai)->format('d M Y') . ' - ' . Carbon\Carbon::parse($h->tanggal_selesai)->format('d M Y') }}
                  </p>
                </div>
                <div class="card-body bg-light">
                  <p id="card-text{{ $h->id }}" class="card-text">
                    {{ Str::limit($h->deskripsi, 20) }}
                  </p>
                  <div id="more{{ $h->id }}" style="display:none;">
                    <p class="mt-2">{{ $h->deskripsi }} </p>
                    <a href="#pendaftaran" onclick="daftar( '{{ $h->id }}' )" class="btn btn-success w-100">
                      Daftar <i class="ri-login-box-line align-middle ms-1 lh-1"></i></a>
                  </div>
                </div>
                <div class="card-footer d-flex justify-content-between">
                  <a href="javascript:void(0);" style="display:none; text-decoration: none;" id="close{{ $h->id }}"
                    onclick="hide( '{{ $h->id }}' )" class="card-link link-danger">Close <i
                      class="ri-close-line ms-1 align-middle lh-1"></i></a>
                  <a href="javascript:void(0);" style="text-decoration: none" onclick="show( '{{ $h->id }}' )"
                    class="card-link link-secondary">Read More <i
                      class="ri-arrow-right-s-line ms-1 align-middle lh-1"></i></a>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
      <!-- end container -->
    </section>
    <!-- end layanan -->

    <!-- start tata_cara -->
    <section class="section" id="tata_cara">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-8">
            <div class="text-center mb-5">
              <h3 class="mb-3 fw-semibold">Tata Cara Pendaftaran</h3>
              <p class="text-muted mb-4 ff-secondary">Bacalah langkah-langkah atau tata cara pendaftaran
                terlebih
                dahulu sebelum mendaftar.</p>
            </div>
          </div>
        </div>
        <!-- end row -->

        <div class="row g-lg-5 g-4">
          <div class="col-lg-12">
            <div class="d-flex align-items-center mb-2">
              <div class="flex-shrink-0 me-1">
                <i class="ri-question-line fs-24 align-middle text-success me-1"></i>
              </div>
              <div class="flex-grow-1">
                <h5 class="mb-0 fw-semibold">Pendaftaran</h5>
              </div>
            </div>
            <div class="accordion custom-accordionwithicon custom-accordion-border accordion-border-box"
            id="genques-accordion">
            @foreach ($tata_cara as $item)
              <div class="accordion-item">
                <h2 class="accordion-header" id="{{ 'collapse-header-' . $loop->iteration }}">
                  <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse"
                    data-bs-target="#{{ 'collapse-' . $loop->iteration }}" aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
                    aria-controls="{{ 'collapse-' . $loop->iteration }}">
                    {{ $loop->iteration . '. ' . $item->title }}
                  </button>
                </h2>
                <div id="{{ 'collapse-' . $loop->iteration }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}"
                  aria-labelledby="{{ 'collapse-header-' . $loop->iteration }}" data-bs-parent="#genques-accordion">
                  <div class="accordion-body ff-secondary">
                    {{ $item->deskripsi }}
                  </div>
                </div>
              </div>
            @endforeach
          </div>
          
            <!--end accordion-->

          </div>
          <!-- end col -->
        </div>
        <!-- end row -->
      </div>
      <!-- end container -->
    </section>
    <!-- end tata_cara -->

    <!-- start pendaftaran -->
    <section class="section" id="pendaftaran">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-8">
            <div class="text-center mb-5">
              <h3 class="mb-3 fw-semibold">Daftar Sekarang</h3>
              <p class="text-muted mb-4 ff-secondary">Silahkan mengisi form pendaftaran dibawah ini
                dengan data yang
                sebenar-benarnya.</p>
            </div>
          </div>
        </div>
        <!-- end row -->

        <div class="row gy-4" id="features">
          <div class="col-lg-6">
            <img src="assets/images/widget-img.png" alt="" class="img-fluid mx-auto">
          </div>
          <!-- end col -->
          <div class="col-lg-6">
            <div>
              <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                  <div class="col-lg-6">
                    <div class="mb-4">
                      <label for="nama" class="form-label fs-13">Nama</label>
                      <input name="nama" id="nama" type="text" class="form-control"
                        placeholder="Masukkan Nama">
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="mb-4">
                      <label for="email" class="form-label fs-13">Email</label>
                      <input name="email" id="email" type="email" class="form-control"
                        placeholder="Masukkan Email">
                        <small class="form-text text-success"> *Silahkan menggunakan Email Aktif </small>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6">
                    <div class="mb-4">
                      <label for="nik" class="form-label fs-13">NIK</label>
                      <input name="nik" id="nik" type="number" class="form-control"
                        placeholder="Masukkan NIK">
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="mb-4">
                      <label for="no_hp" class="form-label fs-13">No Hp</label>
                      <input name="no_hp" id="no_hp" type="number" class="form-control"
                        placeholder="Masukkan No HP">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-12">
                    <div class="mb-4">
                      <label for="sekolah" class="form-label fs-13">Asal Sekolah</label>
                      <input type="text" class="form-control" placeholder="Masukkan Asal Sekolah" id="sekolah"
                        name="sekolah" />
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6">
                    <div class="mb-4">
                      <label for="program_studi" class="form-label fs-13">Program Studi</label>
                      <select class="form-select" aria-label="Default select example" name="program_studi" id="program_studi">
                        <option value="" selected>Pilih Program Studi</option>
                        @forelse($prodi as $h)
                            <option value="{{ $h->id }}">
                                {{ $h->jurusan->name ?? '-' }} - {{ $h->name }}
                            </option>
                        @empty
                            <option value="">Data Program Studi tidak tersedia</option>
                        @endforelse
                    </select>
                    </div>
                  </div>
                  
                  <div class="col-lg-6">
                    <div class="mb-4">
                      <label for="gelombang" class="form-label fs-13">Gelombang Pendaftaran</label>
                      <select class="form-select" aria-label="Default select example" name="gelombang" id="gelombang">
                        <option value="" selected>Pilih Gelombang Pendaftaran</option>
                        @forelse($gelombang as $h)
                          <option value="{{ $h->id }}">{{ $h->nama_gelombang }}</option>
                        @empty
                          <option value="">Data Gelombang tidak tersedia</option>
                        @endforelse
                      </select>
                    </div>
                  </div>
                </div>
                
                <div class="row">
                  <div class="col-lg-12 text-end">
                    <a data-bs-toggle="modal" data-bs-target="#forgetcode" class="btn btn-warning">Lupa Kode Virtual Account
                      Pendaftaran</a>
                    <input type="submit" id="submit" name="send" class="submitBnt btn btn-primary"
                      value="Daftar">
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- end row -->
      </div>
      <!-- end container -->
    </section>
    <!-- end pendaftaran -->

    <!-- start pengumuman -->
    <section class="section bg-primary" id="pengumuman">
      <div class="bg-overlay bg-overlay-pattern"></div>
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-12">
            <div class="text-center">
              <div>
                <i class="ri-double-quotes-l text-success display-3"></i>
              </div>
              <h4 class="text-white mb-5">Pengumuman</h4>
            </div>
            <div class="row d-flex justify-content-center">
              @forelse ($pengumuman as $item)
                <div class="col-sm-6 col-xl-3">
                  <div class="card">
                    <img class="card-img-top img-fluid" src="{{ URL::asset('assets/images/small/img-2.jpg') }}"
                      alt="Card image cap">
                    <div class="card-body">
                      <h4 class="card-title mb-2">{{ $item->judul_pengumuman }}</h4>
                      <p class="card-text mb-0 fs-6">
                        {!! Str::limit($item->isi_pengumuman, 100) !!}
                      </p>
                    </div>
                    <div class="card-footer d-flex justify-content-end">
                      <a href="{{ url('pengumuman/' . $item->id) }}" class="card-link link-secondary">Read More <i
                          class="ri-arrow-right-s-line ms-1 align-middle lh-1"></i></a>
                    </div>
                  </div><!-- end card -->
                </div><!-- end col -->
              @empty
              @endforelse
            </div>
          </div>
          <!-- end col -->
        </div>
        <!-- end row -->
      </div>
      <!-- end container -->
    </section>
    <!-- end pengumuman -->

    <!-- start Work Process -->
    <section class="section" id="tentang">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-8">
            <div class="text-center mb-5">
              <h3 class="mb-3 fw-semibold">Bergabunglah bersama kami</h3>
              <p class="text-muted mb-4 ff-secondary">Dengan arsitektur pembelajaran giat Poliwangi dan
                institusi yang
                dimilikinya, Poliwangi telah bekerja sangat keras dalam dua tahun terakhir ini untuk
                membangun dan
                membina sebuah bangunan pembelajaran universitas yang kedepannya diharapkan dapat
                membantu memperkuat
                berbasis ilmu pengetahuan bisnis di Indonesia.</p>
            </div>
          </div>
        </div>
        <!-- end row -->

        <div class="row text-center">
          <div class="col-lg-4">
            <div class="process-card mt-4">
              <div class="process-arrow-img d-none d-lg-block">
                <img src="assets/images/landing/process-arrow-img.png" alt="" class="img-fluid">
              </div>
              <div class="avatar-sm icon-effect mx-auto mb-4">
                <div class="avatar-title bg-transparent text-success rounded-circle h1">
                  <i class="ri-quill-pen-line"></i>
                </div>
              </div>

              <h5>Kegiatan Belajar Mengajar yang baik</h5>
              <p class="text-muted ff-secondary">Diampu langsung oleh tenaga pendidik dan tenaga
                operasional yang
                profesional dan ahli di bidangnya masing masing.</p>
            </div>
          </div>
          <!-- end col -->
          <div class="col-lg-4">
            <div class="process-card mt-4">
              <div class="process-arrow-img d-none d-lg-block">
                <img src="assets/images/landing/process-arrow-img.png" alt="" class="img-fluid">
              </div>
              <div class="avatar-sm icon-effect mx-auto mb-4">
                <div class="avatar-title bg-transparent text-success rounded-circle h1">
                  <i class="ri-building-line"></i>
                </div>
              </div>

              <h5>Fasilitas yang memadai</h5>
              <p class="text-muted ff-secondary">Sarana dan Prasarana yang bisa digunakan baik untuk
                kegiatan akademik
                maupun non akademik.Poliwangi lebih dari sekedar tempat belajar dimana ada berbagai
                kehidupan menarik
                yang menunggumu di luar kelas!
              </p>
            </div>
          </div>
          <!-- end col -->
          <div class="col-lg-4">
            <div class="process-card mt-4">
               <div class="process-arrow-img d-none d-lg-block">
                <img src="assets/images/landing/process-arrow-img.png" alt="" class="img-fluid">
              </div>
              <div class="avatar-sm icon-effect mx-auto mb-4">
                <div class="avatar-title bg-transparent text-success rounded-circle h1">
                  <i class="ri-book-mark-line"></i>
                </div>
              </div>

              <h5>Metode Pembelajaran yang berkualitas</h5>
              <p class="text-muted ff-secondary">Kolaborasi antara pengetahuan dan kemampuan teoritis
                untuk penerapan
                kesatuan ilmu dalam dunia bisnis dan dunia kerja.</p>
            </div>
          </div>
          <!-- end col -->
        </div>
        <!-- end row -->
      </div>
      <!-- end container -->
    </section>
    <!-- end Work Process -->

    <!-- start counter -->
    <section class="py-5 position-relative bg-light">
      <div class="container">
        <div class="row text-center gy-4">
          <div class="col-lg-3 col-6">
            <div>
              <h2 class="mb-2"><span class="counter-value" data-target="3.5">0</span>k</h2>
              <div class="text-muted">Mahasiswa</div>
            </div>
          </div>
          <!-- end col -->

          <div class="col-lg-3 col-6">
            <div>
              <h2 class="mb-2"><span class="counter-value" data-target="{{ \Illuminate\Support\Facades\DB::table('program_studis')->count() }}"></span></h2>
              <div class="text-muted">Program Studi</div>
            </div>
          </div>
          <!-- end col -->
          <div class="col-lg-3 col-6">
            <div>
              <h2 class="mb-2"><span class="counter-value" data-target="300">0</span>+</h2>
              <div class="text-muted">Penghargaan</div>
            </div>
          </div>
          <!-- end col -->
          <div class="col-lg-3 col-6">
            <div>
              <h2 class="mb-2"><span class="counter-value" data-target="25">0</span>+</h2>
              <div class="text-muted">Organisasi Kemahasiswaaan</div>
            </div>
          </div>
          <!-- end col -->
        </div>
        <!-- end row -->
      </div>
      <!-- end container -->
    </section>
    <!-- end counter -->

    <!-- Start footer -->
    <footer class="custom-footer bg-dark py-5 position-relative">
      <div class="container">
        <div class="row">
          <!-- Logo dan Deskripsi -->
          <div class="col-lg-5 mt-4">
            <div>
              <img src="assets/images/logo-light.png" alt="logo light" height="50">
              <div class="mt-4 fs-13">
                <p class="text-white">Politeknik Negeri Poliwangi</p>
                <p class="ff-secondary text-white">
                  Kolaborasi antara pengetahuan dan kemampuan teoritis untuk penerapan kesatuan ilmu dalam dunia bisnis dan dunia kerja.
                </p>
              </div>
            </div>
          </div>
    
          <!-- Lokasi dan Kontak -->
          <div class="col-lg-7 ms-lg-auto">
            <div class="row">
              <div class="col-sm-7 mt-4">
                <h5 class="text-white mb-0">Lokasi</h5>
                <div class="text-white mt-3">
                  Jalan Raya Jember KM 13<br>
                  Banyuwangi 68461, Jawa Timur – Indonesia
                </div>
              </div>
              <div class="col-sm-5 mt-4">
                <h5 class="text-white mb-0">Kontak</h5>
                <div class="text-white mt-3">
                  <ul class="list-unstyled ff-secondary footer-list">
                    <li>Telepon: +62 (0333) 636780</li>
                    <li>Email: poliwangi@poliwangi.ac.id<br>humas@poliwangi.ac.id</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
    
        <!-- Copyright dan Sosial Media -->
        <div class="row text-center text-sm-start align-items-center mt-5">
          <div class="col-sm-6">
            <div>
              <p class="copy-rights mb-0">
                <script>
                  document.write(new Date().getFullYear())
                </script> © Politeknik Negeri Banyuwangi
              </p>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="text-sm-end mt-3 mt-sm-0">
              <ul class="list-inline mb-0 footer-social-link">
                <li class="list-inline-item">
                  <a href="javascript: void(0);" class="avatar-xs d-block">
                    <div class="avatar-title rounded-circle">
                      <i class="ri-google-fill"></i>
                    </div>
                  </a>
                </li>
                <li class="list-inline-item">
                  <a href="javascript: void(0);" class="avatar-xs d-block">
                    <div class="avatar-title rounded-circle">
                      <i class="ri-facebook-fill"></i>
                    </div>
                  </a>
                </li>
                <li class="list-inline-item">
                  <a href="javascript: void(0);" class="avatar-xs d-block">
                    <div class="avatar-title rounded-circle">
                      <i class="ri-instagram-fill"></i>
                    </div>
                  </a>
                </li>
                <li class="list-inline-item">
                  <a href="javascript: void(0);" class="avatar-xs d-block">
                    <div class="avatar-title rounded-circle">
                      <i class="ri-youtube-fill"></i>
                    </div>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    
      <!-- Iframe -->
      <div id="floating-iframe-container" 
      style="position: fixed; bottom: 20px; right: 20px; width: 300px; height: 200px; overflow: hidden;">
      <iframe src="https://369d7c3875414be19f88e682f82ec916.elf.site/" 
        style="width: 320px; height: 220px; border: none; z-index: 9999;">
      </iframe>
    </div>
    </footer>
    
    <!-- end footer -->

  </div>
  <!-- end layout wrapper -->

  <!-- Modal Lupa Kode Bayar -->
  <div class="modal fade" id="forgetcode" tabindex="-1" aria-labelledby="forgetcodeLabel">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="forgetcodeLabel">Lupa Kode Virtual Account</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form>
            <div class="row g-3">
              <div class="col-xxl-6">
                <label for="nik" class="form-label">NIK</label>
                <input type="text" class="form-control" id="nik_kode" placeholder="Masukkan NIK">
              </div>
              <!--end col-->
              <label for="gelombang" class="form-label fs-13">Gelombang Pendaftaran</label>
              <select class="form-select" aria-label="Default select example" name="gelombang" id="gelombang_kode">
                <option selected>Pilih Gelombang Pendaftaran</option>
                @forelse($gelombang as $index => $h)
                  <option value="{{ $h->id }}">{{ $h->nama_gelombang }}</option>
                @empty
                @endforelse
              </select>
              <div class="col-xxl-6">
                <label for="kode" class="form-label">Kode Virtual Account</label>
                <div class="input-group">
                  <!-- Tempat untuk menampilkan alert -->
<div id="alertBox" class="alert alert-success alert-dismissible fade" role="alert" style="display: none;">
  <strong id="alertTitle"></strong> <span id="alertMessage"></span>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>

                  <input disabled type="text" class="form-control" id="kode" placeholder="Kode Virtual Account">
                  <button type="button" class="btn btn-outline-secondary" id="copy-button" onclick="copyCode()">Salin</button>
                </div>
              </div>
              
              <!--end col-->
              <div class="col-lg-12">
                <div class="hstack gap-2 justify-content-end">
                  <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>


                  <button type="submit" class="btn btn-primary px-3 py-1 show-details">Details</button>

                </div>
              </div>
              <!--end col-->
            </div>
            <!--end row-->
          </form>
        </div>
      </div>
    </div>
  </div>
  </div>


  <!-- JAVASCRIPT -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="{{ asset('assets/libs/bootstrap/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
  <script src="{{ asset('assets/libs/node-waves/node-waves.min.js') }}"></script>
  <script src="{{ asset('assets/libs/feather-icons/feather-icons.min.js') }}"></script>
  <script src="{{ asset('assets/js/pages/lord-icon-2.1.0.js') }}"></script>
  <script src="{{ asset('assets/js/plugins.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.7/dist/sweetalert2.all.min.js"></script>
  <script type="text/javascript">
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $(".show-details").click(function(e) {
      e.preventDefault();
      var e = document.getElementById("gelombang_kode");
      var nik_kode = document.getElementById("nik_kode").value;
      var gelombang_kode = e.value;

      //  alert(gelombang_kode);

      $.ajax({
        type: 'post',
        url: "{{ URL('cekkode') }}",
        data: {
          nik: nik_kode,
          gelombang: gelombang_kode
        },
        success: function(data) {
          $("#kode").val(data);
          // console.log(data);
          //  alert(data);
        }
      });

    });
  </script>
<script>
  const iframeContainer = document.getElementById('floating-iframe-container');
  let initialBottom = 20; // Jarak awal dari bawah
  let lastScrollPosition = window.scrollY;

  // Set posisi awal iframe di bawah
  iframeContainer.style.bottom = `${initialBottom}px`;

  window.addEventListener('scroll', () => {
    const currentScrollPosition = window.scrollY;
    const scrollDifference = currentScrollPosition - lastScrollPosition;

    // Update posisi bottom berdasarkan arah scroll
    initialBottom -= scrollDifference * 0.5; // Faktor pengurang kecepatan (lebih lambat)

    // Pastikan posisi minimal tetap 20px dari bawah
    iframeContainer.style.bottom = `${Math.max(20, initialBottom)}px`;

    // Update posisi scroll terakhir
    lastScrollPosition = currentScrollPosition;
  });
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.7/dist/sweetalert2.all.min.js"></script>
<script>
function showAlert(title, message, type = 'success') {
  // Mengatur tipe alert (success, danger, info, warning)
  const alertBox = document.getElementById('alertBox');
  const alertTitle = document.getElementById('alertTitle');
  const alertMessage = document.getElementById('alertMessage');

  alertTitle.textContent = title;
  alertMessage.textContent = message;

  // Menambahkan kelas untuk alert
  alertBox.className = `alert alert-${type} alert-dismissible fade show`;
  alertBox.style.display = 'block'; // Menampilkan alert
}

function copyCode() {
  const kodeInput = document.getElementById('kode');
  
  if (kodeInput.value) {
    kodeInput.removeAttribute('disabled');
    kodeInput.select();
    kodeInput.setSelectionRange(0, 99999); // Untuk mendukung browser lama
    
    // Menyalin kode ke clipboard
    navigator.clipboard.writeText(kodeInput.value).then(() => {
      showAlert('Sukses!', 'Kode Virtual Account berhasil disalin!', 'success');
    }).catch(err => {
      showAlert('Gagal!', 'Gagal menyalin kode. Coba lagi.', 'danger');
    });
    
    kodeInput.setAttribute('disabled', true);
  } else {
    showAlert('Peringatan!', 'Tidak ada kode untuk disalin!', 'warning');
  }
}


</script>

  <!--Card Gelombang js-->
  <script>
    function show(id) {
      //shows the #more
      document.getElementById('more' + id).style.display = "block";
      document.getElementById('card-text' + id).style.display = "none";
      document.getElementById('close' + id).style.display = "inline";
    }

    function hide(id) {
      //shows the #more
      document.getElementById('more' + id).style.display = "none";
      document.getElementById('card-text' + id).style.display = "block";
      document.getElementById('close' + id).style.display = "none";
    }

    function daftar(id) {
      //shows the #more
      document.getElementById('gelombang').value = id;
    }
  </script>
  <!--Card Gelombang js-->

  <!--Swiper slider js-->
  <script src="{{ asset('assets/libs/swiper/swiper-bundle.min.js') }}"></script>

  <!-- landing init -->
  <script src="{{ asset('assets/js/pages/landing.init.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/iframe-resizer/4.2.10/iframeResizer.min.js"></script>

<style>
  body {
    margin: 0;
    padding: 0;
  }

  canvas {
    display: block;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: -1;
    pointer-events: none;
  }
</style>

<script>
  function moveImageRandomly() {
    const img = document.querySelector('.demo-img-patten-top img');
    const container = document.querySelector('.demo-img-patten-top');
    if (!img || !container) return;

    // Ukuran container (untuk memastikan gambar tidak keluar area)
    const containerWidth = container.offsetWidth;
    const containerHeight = container.offsetHeight;

    // Ukuran gambar
    const imgWidth = img.offsetWidth;
    const imgHeight = img.offsetHeight;

    // Tentukan gerakan random dalam batas container
    const randomX = Math.random() * (containerWidth - imgWidth);
    const randomY = Math.random() * (containerHeight - imgHeight);

    // Update posisi gambar
    img.style.transform = `translate(${randomX}px, ${randomY}px)`;
  }

  // Panggil fungsi setiap 1.5 detik
  setInterval(moveImageRandomly, 1500);
</script>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const sections = document.querySelectorAll("section");
    const navLinks = document.querySelectorAll(".nav-link");

    function changeActiveLink() {
      let current = "";

      sections.forEach((section) => {
        const sectionTop = section.offsetTop - 50; // Tambahkan padding jika navbar fixed
        if (scrollY >= sectionTop) {
          current = section.getAttribute("id");
        }
      });

      navLinks.forEach((link) => {
        link.classList.remove("active");
        if (link.getAttribute("href").includes(current)) {
          link.classList.add("active");
        }
      });
    }

    window.addEventListener("scroll", changeActiveLink);
  });
</script>


</body>


</html>
