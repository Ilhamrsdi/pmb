<header id="page-topbar">
  <div class="layout-width">
    <div class="navbar-header">
      <div class="d-flex">
        <!-- LOGO -->
        <div class="navbar-brand-box horizontal-logo">
          <a href="{{ route('dashboard') }}" class="logo logo-dark">
            <span class="logo-sm">
              <img src="{{ URL::asset('assets/images/logo-sm.png') }}" alt="" height="30">
            </span>
            <span class="logo-lg">
              <img src="{{ URL::asset('assets/images/logo-dark.png') }}" alt="" height="50">
            </span>
          </a>

          <a href="/dashboard" class="logo logo-light">
            <span class="logo-sm">
              <img src="{{ URL::asset('assets/images/logo-sm.png') }}" alt="" height="30">
            </span>
            <span class="logo-lg">
              <img src="{{ URL::asset('assets/images/logo-light.png') }}" alt="" height="50">
            </span>
          </a>
        </div>

        <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger"
          id="topnav-hamburger-icon">
          <span class="hamburger-icon">
            <span></span>
            <span></span>
            <span></span>
          </span>
        </button>
      </div>

      <div class="d-flex align-items-center">

      

     
        

       

        <div class="ms-1 header-item d-none d-sm-flex">
          <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
            data-toggle="fullscreen">
            <i class='bx bx-fullscreen fs-22'></i>
          </button>
        </div>

        <div class="ms-1 header-item d-none d-sm-flex">
          <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode">
            <i class='bx bx-moon fs-22'></i>
          </button>
        </div>
        <div class="dropdown ms-sm-3 header-item topbar-user">
          <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <span class="d-flex align-items-center">
              <img class="rounded-circle header-profile-user"
                src="@if (Auth::user()->avatar != '') {{ URL::asset('images/' . Auth::user()->avatar) }}@else{{ URL::asset('assets/images/users/avatar-1.jpg') }} @endif"
                alt="Header Avatar">
              <span class="text-start ms-xl-2">
                <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">
                  {{ Auth::user()->username}}
              </span>
              
              <span class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text">
                {{ Auth::user()->role_id == 1 ? '' : optional(Auth::user()->role)->role }}
              </span>
              
            </span>
          </button>
          <div class="dropdown-menu dropdown-menu-end">
              <h6 class="dropdown-header">Welcome
                {{ Auth::user()->username }}
              </h6>
            <a class="dropdown-item " href="javascript:void();"
              onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                class="bx bx-power-off font-size-16 align-middle me-1"></i> <span
                key="t-logout">@lang('translation.logout')</span></a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>
