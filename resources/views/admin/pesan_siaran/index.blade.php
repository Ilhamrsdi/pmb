@extends('layouts.master')
@section('title')
  PESAN SIARAN
@endsection
@section('content')
  @component('components.breadcrumb')
    @slot('li_1')
      Pesan Siaran
    @endslot
    @slot('title')
      Kirim Pesan Siaran
    @endslot
  @endcomponent
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <div class="ckeditor-classic"></div>
          <button type="submit" class="btn btn-primary mt-2 float-end">Kirim</button>
        </div><!-- end card-body -->
      </div><!-- end card -->
    </div>
    <!-- end col -->
  </div>
  <!-- end row -->
@endsection
@section('script')
  <script src="{{ URL::asset('assets/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js') }}"></script>
  {{-- CK Editor --}}
  <script>
    var ckClassicEditor = document.querySelectorAll(".ckeditor-classic");
    ckClassicEditor && Array.from(ckClassicEditor).forEach(function() {
      ClassicEditor.create(document.querySelector(".ckeditor-classic")).then(function(e) {
        e.ui.view.editable.element.style.height = "250px"
      }).catch(function(e) {
        console.error(e)
      })
    });
  </script>
  <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
