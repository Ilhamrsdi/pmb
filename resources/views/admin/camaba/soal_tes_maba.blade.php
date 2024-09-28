@extends('layouts.master')
@section('title')
  @lang('Pendaftar')
@endsection
@section('content')
  @component('components.breadcrumb')
    @slot('li_1')
      Calon Maba
    @endslot
    @slot('title')
      Pendaftar
    @endslot
  @endcomponent
  @if (Session::has('success'))
    <div class="alert alert-success">
      <strong>Success: </strong>{{ Session::get('success') }}
    </div>
  @endif
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div id="customerList#">
          <div class="card-header">
            <div class="row g-4">
              <div class="col-sm-auto">
                <h4 class="card-title mt-2">DATA SOAL</h4>
              </div>
            </div>
          </div><!-- end card header -->
          <div class="card-body">
            <div class="row g-4 mb-3">
              <div class="col-sm-auto">
                <div>
                  <a type="button" class="btn btn-primary add-btn" href="{{ route('tes-maba.index') }}"><i
                      class=" ri-arrow-go-back-fill align-bottom me-1"></i>Kembali</a>
                </div>
              </div>
              <div class="col-sm">
                <div class="d-flex justify-content-sm-end">
                  <div class="search-box ms-2">
                    <input type="text" class="form-control search" placeholder="Search...">
                    <i class="ri-search-line search-icon"></i>
                  </div>
                </div>
              </div>
            </div>
            <div class="table-responsive table-card mt-3 mb-1">
              <table class="table align-middle table-nowrap" id="customerTable">

                <tbody class="list form-check-all">
                  <div class="modal-body">

                    <form action="{{ route('soal-tes-maba-add.store') }}" method="post">
                      @csrf

                      @if ($soal->soal != null)



                        @foreach ($soal->soal as $index => $data)
                          <div class="mb-3 mt-3">
                            <label for="email-field" class="form-label">SOAL {{ $index + 1 }}</label>
                            <input type="text" value="{{ $data->soal }}" name="soal[]" id="date-field"
                              class="form-control" required />
                          </div>
                          <div class="mb-3 mt-3">
                            <label for="email-field" class="form-label">Jawaban Benar</label>
                            <input type="text" value="{{ $data->jawaban }}" name="jawaban[]" id="date-field"
                              class="form-control" required placeholder="Masukkan Jawaban Benar" />
                          </div>
                          <div class="mb-3 mt-3">
                            <label for="email-field" class="form-label">Jawaban Salah </label>
                            <input type="text" value="{{ $data->jawaban1 }}" name="jawaban1[]" id="date-field"
                              class="form-control" required placeholder="Masukkan Jawaban Salah " />
                          </div>
                          <div class="mb-3 mt-3">
                            <label for="email-field" class="form-label">Jawaban Salah</label>
                            <input type="text" value="{{ $data->jawaban2 }}" name="jawaban2[]" id="date-field"
                              class="form-control" required placeholder="Masukkan Jawaban Salah " />
                          </div>
                          <div class="mb-3 mt-3">
                            <label for="email-field" class="form-label">Jawaban Salah</label>
                            <input type="text" value="{{ $data->jawaban3 }}" name="jawaban3[]" id="date-field"
                              class="form-control" required placeholder="Masukkan Jawaban Salah " />
                          </div>
                        @endforeach

                        @if ($soal->soal->count() < $jumlah_soal->jumlah_soal)
                          @php
                            $sisa_soal = $jumlah_soal->jumlah_soal - $soal->soal->count();
                          @endphp

                          @for ($i = 0; $i < $sisa_soal; $i++)
                            <div class="mb-3 mt-3">
                              <label for="email-field" class="form-label">SOAL {{ $soal->soal->count() + $i + 1 }}</label>
                              <input type="text" name="soal[]" id="date-field" class="form-control" required />
                            </div>
                            <div class="mb-3 mt-3">
                              <label for="email-field" class="form-label">Jawaban Benar</label>
                              <input type="text" name="jawaban[]" id="date-field" class="form-control" required
                                placeholder="Masukkan Jawaban Benar" />
                            </div>
                            <div class="mb-3 mt-3">
                              <label for="email-field" class="form-label">Jawaban Salah </label>
                              <input type="text" name="jawaban1[]" id="date-field" class="form-control" required
                                placeholder="Masukkan Jawaban Salah " />
                            </div>
                            <div class="mb-3 mt-3">
                              <label for="email-field" class="form-label">Jawaban Salah</label>
                              <input type="text" name="jawaban2[]" id="date-field" class="form-control" required
                                placeholder="Masukkan Jawaban Salah " />
                            </div>
                            <div class="mb-3 mt-3">
                              <label for="email-field" class="form-label">Jawaban Salah</label>
                              <input type="text" name="jawaban3[]" id="date-field" class="form-control" required
                                placeholder="Masukkan Jawaban Salah " />
                            </div>
                          @endfor
                        @else
                        @endif
                      @else
                        @for ($i = 1; $i < $jumlah_soal->jumlah_soal; $i++)
                          <div class="mb-3 mt-3">
                            <label for="email-field" class="form-label">SOAL {{ $i }}</label>
                            <input type="text" name="soal[]" id="date-field" class="form-control" required />
                          </div>
                          <div class="mb-3 mt-3">
                            <label for="email-field" class="form-label">Jawaban Benar</label>
                            <input type="text" name="jawaban[]" id="date-field" class="form-control" required
                              placeholder="Masukkan Jawaban Benar" />
                          </div>
                          <div class="mb-3 mt-3">
                            <label for="email-field" class="form-label">Jawaban Salah </label>
                            <input type="text" name="jawaban1[]" id="date-field" class="form-control" required
                              placeholder="Masukkan Jawaban Salah " />
                          </div>
                          <div class="mb-3 mt-3">
                            <label for="email-field" class="form-label">Jawaban Salah</label>
                            <input type="text" name="jawaban2[]" id="date-field" class="form-control" required
                              placeholder="Masukkan Jawaban Salah " />
                          </div>
                          <div class="mb-3 mt-3">
                            <label for="email-field" class="form-label">Jawaban Salah</label>
                            <input type="text" name="jawaban3[]" id="date-field" class="form-control" required
                              placeholder="Masukkan Jawaban Salah " />
                          </div>
                        @endfor
                      @endif



                      <input type="hidden" name="id_tes" value="{{ $jumlah_soal->id }}" id="date-field"
                        class="form-control" required />

                      <button type="submit" class="btn btn-primary add-btn"><i
                          class="ri-save-fill align-bottom me-1"></i>Submit</button>
                    </form>
                  </div>

                </tbody>
              </table>
              <div class="noresult" style="display: none">
                <div class="text-center">
                  <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                    colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px">
                  </lord-icon>
                  <h5 class="mt-2">Maaf! Data yang anda cari tidak ada</h5>
                  <p class="text-muted mb-0">Harap Perbaiki kata kunci yang anda cari. </p>
                </div>
              </div>
            </div>
            <div class="d-flex justify-content-end">
              <div class="pagination-wrap hstack gap-2">
                <a class="page-item pagination-prev disabled" href="#">
                  Close
                </a>
                <ul class="pagination listjs-pagination mb-0"></ul>
                <a class="page-item pagination-next" type="submit">
                  Submit
                </a>
              </div>
            </div>


          </div><!-- end card -->
        </div>
      </div>
      <!-- end col -->
    </div>
    <!-- end col -->
  </div>
  <!-- end row -->

  <!-- Modal Create -->

  <!-- Modal Edit -->


@endsection
@section('script')
  <script src="{{ URL::asset('assets/libs/prismjs/prismjs.js') }}"></script>
  <script src="{{ URL::asset('assets/libs/list.js/list.min.js') }}"></script>
  <script src="{{ URL::asset('assets/libs/list.pagination.js/list.pagination.min.js') }}"></script>
  <!-- listjs init -->
  <script src="{{ URL::asset('assets/js/pages/listjs.init.js') }}"></script>
  <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
