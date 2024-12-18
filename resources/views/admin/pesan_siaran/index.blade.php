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
          {{-- Form pengiriman pesan --}}
          <form action="{{ route('admin.pesan-siaran.kirim') }}" method="POST">
            @csrf
            <div class="mb-3">
              <label for="subject" class="form-label">Subjek Pesan</label>
              <input type="text" id="subject" name="subject" class="form-control" placeholder="Masukkan subjek pesan" required>
            </div>
            <div class="mb-3">
              <label for="message" class="form-label">Isi Pesan</label>
              <textarea id="message" name="message" class="ckeditor-classic"></textarea>
            </div>
            <button type="submit" class="btn btn-primary mt-2 float-end">Kirim</button>
          </form>
          
        </div><!-- end card-body -->
      </div><!-- end card -->
    </div><!-- end col -->
  </div><!-- end row -->
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
