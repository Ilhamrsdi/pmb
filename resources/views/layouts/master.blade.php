<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-layout="horizontal" data-topbar="light"
  data-sidebar="dark" data-sidebar-size="lg">

<head>
  <meta charset="utf-8" />
  <title>@yield('title') | PMB Poliwangi</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
  <meta content="Themesbrand" name="author" />
  <!-- App favicon -->
  <link rel="shortcut icon" href="{{ URL::asset('assets/images/favicon.ico') }}">
  @include('layouts.head-css')
</head>

@section('body')
  @include('layouts.body')
@show
<!-- Begin page -->
<div id="layout-wrapper">
  @include('layouts.topbar')
  @include('layouts.sidebar')
  <!-- ============================================================== -->
  <!-- Start right Content here -->
  <!-- ============================================================== -->
  <div class="main-content">
    <div class="page-content">
      <div class="container-fluid">
        @yield('content')
      </div>
      <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
    @include('layouts.footer')
  </div>
  <!-- end main content-->
</div>
<!-- END layout-wrapper -->

@include('layouts.customizer')

<!-- JAVASCRIPT -->

@include('layouts.vendor-scripts')

<!-- Chatting Online -->
@if (auth()->user()->role_id == 2)
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
@endif
</body>

</html>
