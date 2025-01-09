<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
  <!-- LOGO -->
  <div class="navbar-brand-box">
    <!-- Dark Logo-->
    <a href="{{ route('dashboard') }}" class="logo logo-dark">
      <span class="logo-sm">
        <img src="{{ URL::asset('assets/images/logo-sm.png') }}" alt="" height="30">
      </span>
      <span class="logo-lg">
        <img src="{{ URL::asset('assets/images/logo-dark.png') }}" alt="" height="50">
      </span>
    </a>
    <!-- Light Logo-->
    <a href="{{ route('dashboard') }}" class="logo logo-light">
      <span class="logo-sm">
        <img src="{{ URL::asset('assets/images/logo-sm.png') }}" alt="" height="30">
      </span>
      <span class="logo-lg">
        <img src="{{ URL::asset('assets/images/logo-light.png') }}" alt="" height="50">
      </span>
    </a>
    <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
      <i class="ri-record-circle-line"></i>
    </button>
  </div>

  <div id="scrollbar">
    <div class="container-fluid">

      <div id="two-column-menu">
      </div>
      <ul class="navbar-nav" id="navbar-nav">
        @php
          $user = auth()->user();
        @endphp

        @if ($user->role_id == 1 || $user->role_id == 3)
          @if ($user->role_id== 1)
          <li class="menu-title"><span>Administrator</span></li>
          @endif
          @if ($user->role_id == 3)
          <li class="menu-tittle"><span>Panitia</span></li>
          @endif
          <li class="nav-item">
            <a class="nav-link menu-link" href="{{ route('dashboard') }}"> <i
                class="las la-tachometer-alt"></i><span>Dashboard</span>
            </a>
          </li> <!-- end Dashboard Menu -->
         
          <li class="nav-item">
            <a class="nav-link menu-link" href="#sidebarCalonMaba" data-bs-toggle="collapse" role="button"
              aria-expanded="false" aria-controls="sidebarCalonMaba">
              <i class="las la-user"></i> <span>Calon Maba</span>
            </a>
            <div class="collapse menu-dropdown" id="sidebarCalonMaba">
              <ul class="nav nav-sm flex-column">
                <li class="nav-item">
                  <a href="{{ route('pendaftar.index') }}" class="nav-link">Pendaftar</a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('camaba-acc.index') }}" class="nav-link">Calon Maba Acc</a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('camaba-ukt.index') }}" class="nav-link">Calon Maba Sudah / Belum
                    UKT</a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('maba-ukt.index') }}" class="nav-link">Daftar Maba / Sudah Bayar
                    UKT</a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('maba-attribut.index') }}" class="nav-link">Daftar Atribut
                    Maba</a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('atribut-gambars.index') }}" class="nav-link">Preview Gambar Ukuran Attribut
                    Maba</a>
                </li>
                {{-- <li class="nav-item">
                 <a href="{{ route('tes-maba.index') }}" class="nav-link">Tes
                  Maba</a>
                </li> --}}
              </ul>
            </div>
          </li>
          <!-- end Calon Maba Menu -->
          <!-- <li class="nav-item">
              <a  href="{{ route('tes-maba.index') }}"  class="nav-link menu-link">
                <i class="las la-pen"></i> <span>Tes Maba</span>
              </a>
            </li>  -->
          <!-- end Tes Maba Menu -->

          <li class="nav-item">
            <a class="nav-link menu-link" href="#sidebarGelombangBerkas" data-bs-toggle="collapse" role="button"
              aria-expanded="false" aria-controls="sidebarGelombangBerkas">
              <i class="las la-calendar-alt"></i> <span>Gelombang Dan Setting Berkas</span>
            </a>
            <div class="collapse menu-dropdown" id="sidebarGelombangBerkas">
              <ul class="nav nav-sm flex-column">
                <li class="nav-item">
                  <a href="{{ route('gelombang.index') }}" class="nav-link menu-link">
                    Gelombang Pendaftaran
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('settingberkas.index') }}" class="nav-link">Setting Berkas</a>
                </li>
              </ul>
            </div>
          </li> <!-- end Gelombang Pendaftaran Menu -->
          <li class="nav-item">
            <a class="nav-link menu-link" href="#sidebarJurusanDanProdi" data-bs-toggle="collapse" role="button"
              aria-expanded="false" aria-controls="sidebarJurusanDanProdi">
              <i class="las la-building"></i> <span>Jurusan dan Prodi</span>
            </a>
            <div class="collapse menu-dropdown" id="sidebarJurusanDanProdi">
              <ul class="nav nav-sm flex-column">
                <li class="nav-item">
                  <a href="{{ route('jurusan.index') }}" class="nav-link">Jurusan</a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('prodi.index') }}" class="nav-link">Prodi</a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('prodi-lain.index') }}" class="nav-link">Prodi Kampus Lain</a>
                </li>
              </ul>
            </div>
          </li>
          @if ($user->role_id == 1)
          <li class="nav-item">
            <a class="nav-link menu-link" href="#sidebarMasterDataUser" data-bs-toggle="collapse" role="button"
              aria-expanded="false" aria-controls="sidebarMasterDataUser">
              <i class="las la-users"></i> <span>Master Data User</span>
            </a>
            <div class="collapse menu-dropdown" id="sidebarMasterDataUser">
              <ul class="nav nav-sm flex-column">
                <li class="nav-item">
                  <a href="{{ route('users.index') }}" class="nav-link">User List</a>
                </li>
              </ul>
            </div>
              <div class="collapse menu-dropdown" id="sidebarMasterDataUser">
              <ul class="nav nav-sm flex-column">
                <li class="nav-item">
                  <a href="{{ route('users.index') }}" class="nav-link">User List</a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('generate-nim.index') }}" class="nav-link">Generate NIM Massal</a>
                </li>
              </ul>
            </div>
          </li>
          @endif
          <li class="nav-item">
            <a class="nav-link menu-link" href="{{ route('alurPendaftaran') }}">
              <i class="las la-project-diagram"></i> <span>Alur Pendaftaran</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link menu-link" href="{{ route('golongan-ukt.index') }}">
              <i class="las la-money-bill"></i> <span>Golongan dan UKT</span>
            </a>
          </li> <!-- end Golongan dan UKT Menu -->
          <li class="nav-item">
            <a class="nav-link menu-link" href="{{ route('cicilanUkt')}}">
              <i class="las la-credit-card"></i>
              <span>Cicilan dan Penurunan UKT</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link menu-link" href="#sidebarLaporan" data-bs-toggle="collapse" role="button"
              aria-expanded="false" aria-controls="sidebarLaporan">
              <i class="las la-list"></i> <span>Laporan</span>
            </a>
            <div class="collapse menu-dropdown" id="sidebarLaporan">
              <ul class="nav nav-sm flex-column">
                <li class="nav-item">
                  <a href="{{ route('laporanPenerimaan') }}" class="nav-link">Laporan Penerimaan</a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('laporanPembayaran') }}" class="nav-link">Laporan Pembayaran</a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('grafikProvinsi') }}" class="nav-link">Grafik Sesuai Provinsi</a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('grafikProdi') }}" class="nav-link">Grafik Sesuai Program Studi</a>
                </li>
                {{-- <li class="nav-item">
                  <a href="#" class="nav-link">Grafik Sesuai Golongan</a>
                </li> --}}
              </ul>
            </div>
          </li> <!-- end Laporan Menu -->
          <li class="nav-item">
            <a class="nav-link menu-link" href="{{ route('pengumuman.index') }}">
              <i class="las la-chalkboard"></i> <span>Pengumuman</span>
            </a>
          </li> <!-- end Pengumuman Menu -->
          <li class="nav-item">
            <a class="nav-link menu-link" href="{{ route('pesanSiaran') }}">
              <i class="las la-comment"></i> <span>Pesan Siaran</span>
            </a>
          </li>
          <!-- end Pesan Menu -->
          <li class="nav-item">
            <a class="nav-link menu-link" href="{{ route('access-logs.index') }}">
              <i class="las la-history"></i> <span>Logging</span>
            </a>
          </li> <!-- end Pengumuman Menu -->
        @else
        @if (isset($user->pendaftar[0]) && $user->pendaftar[0]->detailPendaftar?->status_pendaftaran == null)
            <li class="menu-title btn-warning"><span>Pendaftar Belum Pendaftaran dan UKT</span></li>
            <li class="nav-item">
              <a class="nav-link menu-link" href="{{ route('dashboard') }}">
                <i class="las la-tachometer-alt"></i> <span>Dashboard</span>
              </a>
            </li> <!-- end Dashboard Menu -->
            @elseif (
              isset($user->pendaftar[0]) &&
              $user->pendaftar[0]->detailPendaftar?->status_pendaftaran == 'sudah' &&
              $user->pendaftar[0]->detailPendaftar?->nominal_ukt == null)
            <li class="menu-title btn-success"><span>Pendaftar Sudah Pendaftaran Belum UKT</span></li>
            <li class="nav-item">
              <a class="nav-link menu-link" href="{{ route('dashboard') }}">
                <i class="las la-tachometer-alt"></i> <span>Dashboard</span>
              </a>
            </li>
            <?php
            $id = session('pendaftar_id');
            ?>
            <li class="nav-item">
              <a class="nav-link menu-link" href="{{ route('kelengkapan-data.edit', $id) }}">
                <i class="las la-user"></i> <span>Kelengkapan Data</span>
              </a>
            </li> <!-- end Kelengkapan Data Menu -->
            <li class="nav-item">
                <a class="nav-link menu-link" href="{{ route('pendaftar.ujian.index' , $id)}}">
                  <i class="las la-pen"></i><span>Tes Maba</span>
                </a>
              </li> <!-- end Tes Maba Menu -->
              @elseif (
                isset($user->pendaftar[0]) &&
                $user->pendaftar[0]->detailPendaftar?->status_pendaftaran == 'sudah' &&
                $user->pendaftar[0]->detailPendaftar?->nominal_ukt != null &&
                $user->pendaftar[0]->detailPendaftar?->status_ukt == null)
            
            <li class="menu-title"><span>Pendaftar Sudah Pendaftaran Sudah UKT</span></li>
            <li class="nav-item">
              <a class="nav-link menu-link" href="{{ route('dashboard') }}">
                <i class="las la-tachometer-alt"></i> <span>@lang('translation.dashboards')</span>
              </a>
            </li> <!-- end Dashboard Menu -->
            <li class="nav-item">
                <a class="nav-link menu-link">
                  <i class="las la-user"></i><span> Data Diri</span>
                </a>
              </li> <!-- end Data Diri Menu -->
              @elseif (
                isset($user->pendaftar[0]) &&
                $user->pendaftar[0]->detailPendaftar?->status_pendaftaran == 'sudah' &&
                $user->pendaftar[0]->detailPendaftar?->nominal_ukt != null &&
                $user->pendaftar[0]->detailPendaftar?->status_ukt == 'sudah')            
            <li class="menu-title"><span>Pendaftar Lunas</span></li>
            <li class="nav-item">
              <a class="nav-link menu-link" href="{{ route('bukti.show', session('pendaftar_id')) }}">
                <i class="las la-print"></i><span> Cetak Bukti </span>
              </a>
            </li> <!-- end Dashboard Menu -->
            {{-- <li class="nav-item">
              <a class="nav-link menu-link" href="{{ route('pendaftar.ujian.start', session('pendaftar_id')) }}">
                <i class="las la-book"></i><span> Ujian </span>
              </a>
            </li> <!-- end Dashboard Menu --> --}}
          @else
            <li class="menu-title"><span>Tidak ada Menu</span></li>
          @endif

        @endif

        {{-- @include('layouts.menu-partial') --}}
      </ul>
    </div>
    <!-- Sidebar -->
  </div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>
