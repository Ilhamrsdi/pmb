<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
  data-sidebar-image="none">

<head>
  <meta name="csrf-token" content="{{ csrf_token() }}" />

  <meta charset="utf-8" />
  <title>Pengumuman | PMB Politeknik Negeri Banyuwangi</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta content="PMB Poliwangi" name="description" />
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
  {{-- <link href="{{ asset('assets/libs/swiper/swiper.min.css') }}" /> --}}
  <!-- custom Css-->
  <link href="{{ asset('assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" />

</head>

<body data-bs-spy="scroll" data-bs-target="#navbar-example" class="p-5">
  <div class="row">
    <div class="col-lg-12">
      <div class="card mt-n4 mx-n4">
        <div class="bg-soft-primary">
          <div class="card-body pb-0 px-4">
            <div class="row mb-3">
              <div class="col-md">
                <div class="row align-items-center g-3">
                  <div class="col-md-auto">
                    <div class="avatar-md">
                      <div class="avatar-title bg-white rounded-circle">
                        <img src="{{ URL::asset('assets/images/users/avatar-1.jpg') }}" alt=""
                          class="avatar-xs">
                      </div>
                    </div>
                  </div>
                  <div class="col-md">
                    <div>
                      <h4 class="fw-bold">Pengumuman</h4>
                      <div class="hstack gap-3 flex-wrap">
                        <div><i class="ri-user-line align-bottom me-1"></i>Administrator</div>
                        <div class="vr"></div>
                        <div>Tanggal : <span
                            class="fw-medium">{{ Carbon\Carbon::parse($pengumuman->tanggal_pengumuman)->format('d-M-Y') }}</span>
                        </div>
                        <div class="vr"></div>
                        <div class="badge rounded-pill bg-info fs-12">New</div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-auto">
                    <div class="hstack gap-1 flex-wrap">
                      <a class="btn btn-warning" href="{{ url('/') }}">Kembali</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- end card body -->
        </div>
      </div>
      <!-- end card -->
    </div>
    <!-- end col -->
  </div>
  <!-- end row -->
  <div class="row">
    <div class="col-lg-12">
      <div class="tab-content text-muted">
        <div class="tab-pane fade show active" id="project-overview" role="tabpanel">
          <div class="row">
            <div class="col-xl-8 col-lg-8">
              <div class="card">
                <div class="card-body">
                  <div class="text-muted">
                    <h6 class="mb-3 fw-semibold text-uppercase">Pengumuman </h6>
                    <p>{{ $pengumuman->isi_pengumuman }}</p>

                    {{-- <ul class="ps-4 vstack gap-2">
                      <li>Product Design, Figma (Software), Prototype</li>
                      <li>Four Dashboards : Ecommerce, Analytics, Project,etc.</li>
                      <li>Create calendar, chat and email app pages.</li>
                      <li>Add authentication pages.</li>
                      <li>Content listing.</li>
                    </ul> --}}

                  </div>
                </div>
                <!-- end card body -->
              </div>
              <!-- end card -->
            </div>
            <!-- ene col -->
            <div class="col-xl-4 col-lg-4">
              <div class="card">
                <div class="card-header align-items-center d-flex border-bottom-dashed">
                  <h4 class="card-title mb-0 flex-grow-1">Pengumuman Lain</h4>
                </div>

                <div class="card-body">

                  <div class="vstack gap-2">
                    @forelse ($pengumumans as $item)
                      <div class="border rounded border-dashed p-2">
                        <div class="d-flex align-items-center">
                          <div class="flex-shrink-0 me-3">
                            <div class="avatar-sm">
                              <div class="avatar-title bg-light text-secondary rounded fs-24">
                                <i class="ri-file-line"></i>
                              </div>
                            </div>
                          </div>
                          <div class="flex-grow-1 overflow-hidden">
                            <h5 class="fs-15 mb-1"><a href="{{ url('pengumuman/' . $item->id) }}"
                                class="text-body text-truncate d-block">{{ $item->judul_pengumuman }}</a></h5>
                            <div>{{ Carbon\Carbon::parse($item->tanggal_pengumuman)->format('d-M-Y') }}</div>
                          </div>
                          <div class="flex-shrink-0 ms-2">
                            <div class="d-flex gap-1">
                              <button type="button" class="btn btn-icon text-muted btn-sm fs-18"><i
                                  class="ri-arrow-drop-right-line"></i></button>
                            </div>
                          </div>
                        </div>
                      </div>
                    @empty
                      Belum ada pengumuman
                    @endforelse

                  </div>
                </div>
                <!-- end card body -->
              </div>
              <!-- end card -->
            </div>
            <!-- end col -->
          </div>
          <!-- end row -->
        </div>
        <!-- end tab pane -->
      </div>
    </div>
    <!-- end col -->
  </div>
  <!-- end row -->

  <!-- JAVASCRIPT -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="{{ asset('assets/libs/bootstrap/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
  <script src="{{ asset('assets/libs/node-waves/node-waves.min.js') }}"></script>
  <script src="{{ asset('assets/libs/feather-icons/feather-icons.min.js') }}"></script>
  <script src="{{ asset('assets/js/pages/lord-icon-2.1.0.js') }}"></script>
  <script src="{{ asset('assets/js/plugins.js') }}"></script>
  <script src="{{ asset('assets/js/pages/project-overview.init.js') }}"></script>
  <script src="{{ asset('/assets/js/app.min.js') }}"></script>

  <script type="text/javascript">
    var Tawk_API = Tawk_API || {},
      Tawk_LoadStart = new Date();
    (function() {
      var s1 = document.createElement("script"),
        s0 = document.getElementsByTagName("script")[0];
      s1.async = true;
      s1.src = 'https://embed.tawk.to/62e8256354f06e12d88c5ffa/1g9dd43jb';
      s1.charset = 'UTF-8';
      s1.setAttribute('crossorigin', '*');
      s0.parentNode.insertBefore(s1, s0);
    })();
  </script>
</body>

</html>
