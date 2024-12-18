@extends('layouts.master-without-nav')
@section('title')
  @lang('translation.signin')
@endsection
@section('content')
  <div class="auth-page-wrapper pt-5">
    <!-- auth page bg -->
    <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
      <div class="bg-overlay"></div>

      <div class="shape">
        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
          viewBox="0 0 1440 120">
          <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
        </svg>
      </div>
    </div>

    <!-- auth page content -->
    <div class="auth-page-content">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="text-center mt-sm-5 mb-4 text-white-50">
              <div>
                <a href="index" class="d-inline-block auth-logo">
                  <img src="{{ URL::asset('assets/images/logo-light.png') }}" alt="" height="75">
                </a>
              </div>
              <p class="mt-3 fs-15 fw-medium">PMB Poliwangi</p>
            </div>
          </div>
        </div>
        <!-- end row -->

        <div class="row justify-content-center">
          <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="card mt-2">
              <div class="card-body p-4">
                <div class="text-center">
                  <h5 class="text-primary">Login</h5>
                </div>
                <div class="p-2 mt-2">
                  <!-- Notifikasi Error -->
                  @if(session('loginError'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                      {{ session('loginError') }}
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                  @endif

                  <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                      <label for="email" class="form-label">Email</label>
                      <input type="email" class="form-control @error('email') is-invalid @enderror" value=""
                        id="email" name="email" placeholder="Masukkan Email">

                      @error('email')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>

                    <div class="mb-3">
                      <label class="form-label" for="password-input">Password</label>
                      <div class="position-relative auth-pass-inputgroup mb-3">
                        <input type="password"
                          class="form-control pe-5 @error('password') is-invalid @enderror"
                          name="password" placeholder="Masukkan password" id="password-input" value="">
                        <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted"
                          type="button" id="password-addon" onclick="togglePassword()">
                          <i class="ri-eye-fill align-middle" id="password-icon"></i>
                        </button>

                        @error('password')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                      </div>
                    </div>

                    <div class="mb-3">
                      <label for="gelombang" class="form-label fs-13">Gelombang Pendaftaran</label>
                      <select class="form-select" aria-label="Default select example" name="gelombang"
                        id="gelombang">
                        @php
                          $gelombang = App\Models\GelombangPendaftaran::get();
                        @endphp
                        <option selected>Pilih Gelombang</option>
                        @forelse($gelombang as $index => $h)
                          <option value="{{ $h->id }}">{{ $h->nama_gelombang }}</option>
                        @empty
                        @endforelse
                      </select>
                    </div>

                    <div class="mt-4">
                      <button class="btn btn-success w-100" type="submit">Masuk</button>
                    </div>
                  </form>
                  <div class="mt-4 text-center">
                    <a href="{{ route('password.request') }}" class="text-muted">Lupa Password?</a>
                  </div>
                  

                  <span class="invalid-feedback" role="alert">
                    <strong>{{ Session::get('error_gelombang') }}</strong>
                  </span>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <footer class="footer">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="text-center">
              <p class="mb-0 text-muted">&copy;
                <script>
                  document.write(new Date().getFullYear())
                </script> Crafted with <i class="mdi mdi-heart text-danger"></i> by PMB Poliwangi
              </p>
            </div>
          </div>
        </div>
      </div>
    </footer>
  </div>
@endsection

@section('script')
  <script src="assets/libs/particles.js/particles.js.min.js"></script>
  <script src="assets/js/pages/particles.app.js"></script>
  <script src="assets/js/pages/password-addon.init.js"></script>
  
  <script>
    function togglePassword() {
      const passwordInput = document.getElementById('password-input');
      const passwordIcon = document.getElementById('password-icon');
      
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        passwordIcon.classList.remove('ri-eye-fill');
        passwordIcon.classList.add('ri-eye-close-fill');
      } else {
        passwordInput.type = 'password';
        passwordIcon.classList.remove('ri-eye-close-fill');
        passwordIcon.classList.add('ri-eye-fill');
      }
    }
  </script>
@endsection
