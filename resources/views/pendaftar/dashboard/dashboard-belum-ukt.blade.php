@extends('layouts.master')
@section('title')
  Data diri
@endsection
@section('content')
  @component('components.breadcrumb')
    @slot('li_1')
      Dashboard
    @endslot
    @slot('title')
      Data diri
    @endslot
  @endcomponent

  <div class="row">
    <div class="col-xxl-5">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body p-0">
              <div class="alert alert-warning border-0 rounded-0 m-0 d-flex align-items-center" role="alert">
                <i data-feather="alert-triangle" class="text-warning me-2 icon-sm"></i>
                <div class="flex-grow-1 text-truncate">
                  Anda belum mendapatkan Kartu Ujian
                </div>
              </div>

              <div class="row align-items-end">
                <div class="col-sm-12">
                  <div class="text-center py-5">
                    <div class="mb-4">
                      <lord-icon src="https://cdn.lordicon.com/nocovwne.json" trigger="loop"
                        colors="primary:#0ab39c,secondary:#405189" style="width:120px;height:120px"></lord-icon>
                    </div>
                    <h5>
                      @php
                        use App\Models\Pendaftar; // Impor model Pendaftar
                        $pendaftar = Pendaftar::where('user_id', auth()->user()->id)->first();
                      @endphp
                      <a href="{{ route('kelengkapan-data.edit', ['id' => $pendaftar->id]) }}" class="text-decoration-none">
                        Silakan melengkapi data diri
                      </a>
                  </div>
                </div>
              </div>
            </div>
          </div> <!-- end card-body-->
        </div>
      </div> <!-- end col-->
    </div> <!-- end row-->
  </div> <!-- end col-->
  </div> <!-- end row-->;
@endsection
@section('script')
  <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
