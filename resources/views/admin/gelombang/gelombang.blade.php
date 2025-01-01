@extends('layouts.master')
@section('title')
  @lang('GELOMBANG PENDAFTARAN')
@endsection
@section('content')
  @component('components.breadcrumb')
    @slot('li_1')
      Admin
    @endslot
    @slot('title')
      Gelombang Pendaftaran
    @endslot
  @endcomponent
  @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

{{-- Menampilkan error dari validasi --}}
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title mb-0">Add, Edit & Remove</h4>
        </div><!-- end card header -->

        <div class="card-body">
          <div id="gelombangList">
            <div class="row g-4 mb-3">
              <div class="col-sm-auto">
                <div>
                  <button type="button" class="btn btn-primary add-btn" data-bs-toggle="modal" id="create-btn"
                    data-bs-target="#showModal"><i class="ri-add-line align-bottom me-1"></i> Add</button>
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
                <thead class="table-light">
                  <tr>
                    <th>NO</th>
                    <th class="sort text-center" data-sort="nama">NAMA GELOMBANG</th>
                    <th class="text-center" data-sort="tahun">TAHUN</th>
                    <th class="text-center" data-sort="prodi1">Program Studi 1</th>
                    <th class="text-center" data-sort="prodi2">Program Studi 2</th>
                    <th class="text-center" data-sort="tanggal_mulai">TANGGAL MULAI</th>
                    <th class="text-center" data-sort="tanggal_selesai">TANGGAL SELESAI</th>
                    <th class="text-center" data-sort="deskripsi">DESKRIPSI</th>
                    <th class="text-center" data-sort="nominal">BIAYA PENDAFTARAN</th>
                    <th class="text-center" data-sort="administrasi">BIAYA ADMINISTRASI</th>
                    <th class="text-center" data-sort="tanggal_ujian">TANGGAL UJIAN</th>
                    <th class="text-center" data-sort="tempat_ujian">TEMPAT UJIAN</th>
                    <th class="text-center" data-sort="kuota">KUOTA PENDAFTAR</th>
                    <th class="sort text-center" data-sort="status">STATUS</th>
                    <th class="text-center">AKSI</th>
                  </tr>
                </thead>
                <tbody class="list form-check-all">

                  @forelse($gelombang as $index => $g)
                    <tr>
                      <th>{{ ++$index }}</th>
                      <td class="nama">{{ $g->nama_gelombang }}</td>
                      <td class="tahun text-center">{{ $g->tahun_ajaran }}</td>
                     <td class="prodi1 text-center">
    @if($g->program_studi_1ids)
        @php
            $programStudi1Ids = json_decode($g->program_studi_1ids);
        @endphp
        @foreach($programStudi1Ids as $id)
            @php
                $prodi = \App\Models\RefPorgramStudi::find($id); // Cari namanya berdasarkan ID
            @endphp
            {{ $prodi->name ?? 'N/A' }},
        @endforeach
    @else
        N/A
    @endif
</td>

<td class="prodi2 text-center">
  @php
      // Decode JSON dari kolom program_studi_2ids dan program_studi_lain_ids
      $programStudi2Ids = json_decode($g->program_studi_2ids, true);
      $programStudiLainIds = json_decode($g->program_studi_lain_ids, true);
  @endphp

  @if(!empty($programStudi2Ids) || !empty($programStudiLainIds))
      {{-- Menampilkan program studi utama --}}
      @if(!empty($programStudi2Ids))
          @foreach($programStudi2Ids as $id)
              @php
                  $prodi = \App\Models\RefPorgramStudi::find($id);
              @endphp
              {{ $prodi->name ?? 'N/A' }},
          @endforeach
      @endif

      {{-- Menampilkan program studi lain --}}
      @if(!empty($programStudiLainIds))
          @foreach($programStudiLainIds as $id)
              @php
                  $prodiLain = \App\Models\ProdiLain::find($id);
              @endphp
              {{ $prodiLain->name ?? 'N/A' }} ({{ $prodiLain->kampus ?? 'N/A' }}),
          @endforeach
      @endif
  @else
      N/A
  @endif
</td>




                    
                      <td class="tanggal_mulai text-center">{{ Carbon\Carbon::parse($g->tanggal_mulai)->format('d-m-Y') }}</td>
                      <td class="tanggal_selesai text-center">
                        {{ Carbon\Carbon::parse($g->tanggal_selesai)->format('d-m-Y') }}</td>
                      <td class="deskripsi">{{ $g->deskripsi }}</td>
                      <td class="nominal text-center">{{ $g->biaya_pendaftaran }}</td>
                      <td class="administrasi text-center">{{ $g->biaya_administrasi}}</td>
                      <td class="tanggal_ujian text-center">{{$g->tanggal_ujian}}</td>
                      <td class="tempat_ujian text-center">{{$g->tempat_ujian}}</td>
                      <td class="kuota text-center">{{ $g->kuota_pendaftar }}</td>
                      <td class="status text-center">
                        @if (strtolower(trim($g->status)) == 'active')
                            <span class="badge badge-soft-success text-uppercase">{{ $g->status }}</span>
                        @elseif (strtolower(trim($g->status)) == 'off')
                            <span class="badge badge-soft-danger text-uppercase">{{ $g->status }}</span>
                        @endif
                    </td>
                    
                      {{-- <td class="status text-center">
                        <span class="badge 
                            @if($g->status == 'active')
                                badge-soft-success
                            @elseif($g->status == 'off')
                                badge-soft-danger
                            @else
                                badge-soft-secondary
                            @endif
                            text-uppercase">
                            {{ $g->status }}
                        </span>
                    </td> --}}
                    
                      <td>
                        <div class="d-flex gap-2">
                          <div class="edit" >
                            <button class="btn btn-sm btn-success edit-item-btn" data-bs-toggle="modal"
                              data-bs-target="#showModalEdit{{ $g->id }}">Edit</button>
                          </div>
                          <div class="remove">
                            <button class="btn btn-sm btn-danger remove-item-btn" data-bs-toggle="modal"
                              data-bs-target="#deleteRecordModal{{ $g->id }}">Remove</button>
                          </div>
                          <div class="edit">
                            <button class="btn btn-sm btn-primary remove-item-btn" data-bs-toggle="modal"
                              data-bs-target="#SetRecordModal{{ $g->id }}">Set
                              Berkas</button>
                          </div>
                        </div>
                      </td>
                    @empty
                      @php
                        echo 'Data Kosong';
                      @endphp
                    </tr>
                  @endforelse
                </tbody>
              </table>
              <div class="noresult" style="display: none">
                <div class="text-center">
                  <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                    colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px">
                  </lord-icon>
                  <h5 class="mt-2">Sorry! No Result Found</h5>
                  <p class="text-muted mb-0">We've searched more than 150+ Orders We did not find any
                    orders for you search.</p>
                </div>
              </div>
            </div>

            <div class="d-flex justify-content-end">
              <div class="pagination-wrap hstack gap-2">
                <a class="page-item pagination-prev disabled" href="#">
                  Previous
                </a>
                <ul class="pagination listjs-pagination mb-0"></ul>
                <a class="page-item pagination-next" href="#">
                  Next
                </a>
              </div>
            </div>
          </div>
        </div><!-- end card -->
      </div>
      <!-- end col -->
    </div>
    <!-- end col -->
  </div>
  <!-- end row -->


  <!-- modal add -->
  <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title" id="exampleModalLabel">Form Tambah Gelombang Pendaftaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
            </div>
            <form action="{{ route('gelombang.store') }}" method="post">
                @csrf
                <div class="modal-body">
                    <!-- Nama Gelombang -->
                    <div class="mb-3">
                        <label for="id-field" class="form-label">Nama Gelombang</label>
                        <input required name="nama_gelombang" type="text" class="form-control" placeholder="nama_gelombang" />
                    </div>
                    
                      <!-- Program Studi -->
                      <div class="mb-3">
                        <label for="program-studi-1" class="form-label">Pilihan Program Studi Ke 1</label>
                        <div>
                            <input type="checkbox" id="select-all-prodi-1" class="form-check-input">
                            <label for="select-all-prodi-1" class="form-check-label">Select All</label>
                        </div>
                        <div class="row mt-2" id="program-studi-1-container">
                            @foreach($programStudis as $prodi)
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input type="checkbox" name="program_studi_1[]" value="{{ $prodi->id }}" class="form-check-input prodi-1-checkbox" id="program-studi-1-{{ $prodi->id }}">
                                    <label class="form-check-label" for="program-studi-1-{{ $prodi->id }}">
                                        <b>[UTAMA]</b> {{ $prodi->name }}
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    
                    

                   
                    <div class="mb-3">
                      <label for="program_studi_2" class="form-label">Program Studi Ke 2</label>
                      <div class="mt-3">
                        <input type="checkbox" id="select-all-prodi-2" class="form-check-input">
                        <label for="select-all-prodi-2" class="form-check-label">Select All</label>
                    </div>
                      <div class="row mt-2" id="program-studi-2-container">
                          @foreach($programStudis as $prodi)
                              <div class="col-md-6">
                                  <div class="form-check">
                                      <input type="checkbox" name="program_studi_2[]" value="{{ $prodi->id }}" class="form-check-input prodi-2-checkbox">
                                      <label class="form-check-label">{{ $prodi->name }}</label>
                                  </div>
                              </div>
                          @endforeach
                      </div>
                    
                  </div>
                  

                  <!-- Program Studi Lain -->
                  <div class="mb-3">
                    <label for="prodi_lain" class="form-label">Program Studi Lain</label>
                    <div class="row mt-2">
                        @foreach($prodiLain as $prodi)
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input type="radio" name="prodi_lain_id" value="{{ $prodi->id }}" class="form-check-input" required>
                                    <label class="form-check-label">{{ $prodi->name }} - {{ $prodi->kampus }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                

                    
            
                    
                    
                   
                    
                    
                    
                    
                    


                    <!-- Tahun Ajaran -->
                    <div class="mb-3">
                        <label for="id-field" class="form-label">Tahun Ajaran</label>
                        <input required name="tahun_ajaran" type="text" class="form-control" placeholder="tahun_ajaran" />
                    </div>
                    
                    <!-- Tanggal Mulai -->
                    <div class="mb-3">
                        <label for="id-field" class="form-label">Tanggal Mulai</label>
                        <input required name="tanggal_mulai" type="date" class="form-control" placeholder="tanggal_mulai" />
                    </div>
                    
                    <!-- Tanggal Selesai -->
                    <div class="mb-3">
                        <label for="id-field" class="form-label">Tanggal Selesai</label>
                        <input required name="tanggal_selesai" type="date" class="form-control" placeholder="tanggal_selesai" />
                    </div>
                    
                    <!-- Status -->
                    <div class="mb-3">
                        <label for="status-field" class="form-label">Status</label>
                        <select class="form-control" data-trigger required name="status" id="status-field">
                            <option value="">Status</option>
                            <option value="Active">Active</option>
                            <option value="Block">Block</option>
                        </select>
                    </div>
                    
                    <!-- Deskripsi -->
                    <div class="mb-3">
                        <label for="id-field" class="form-label">Deskripsi</label>
                        <input required name="deskripsi" type="text" class="form-control" placeholder="deskripsi" />
                    </div>
                    
                    <!-- Biaya Pendaftaran -->
                    <div class="mb-3">
                        <label for="id-field" class="form-label">Biaya Pendaftaran</label>
                        <input required name="biaya_pendaftaran" type="number" min="0" class="form-control" placeholder="biaya_pendaftaran" />
                    </div>
                    
                    <!-- Biaya Administrasi -->
                    <div class="mb-3">
                        <label for="id-field" class="form-label">Biaya Administrasi</label>
                        <input required name="biaya_administrasi" type="number" min="0" class="form-control" placeholder="biaya_administrasi" />
                    </div>
                    
                    <!-- Tanggal Ujian -->
                    <div class="mb-3">
                        <label for="id-field" class="form-label">Tanggal Ujian</label>
                        <input required name="tanggal_ujian" type="date" class="form-control" placeholder="tanggal_ujian" />
                    </div>
                    
                    <!-- Kuota Pendaftar -->
                    <div class="mb-3">
                        <label for="id-field" class="form-label">Kuota Pendaftar</label>
                        <input required name="kuota_pendaftar" type="number" min="0" class="form-control" placeholder="kuota_pendaftar" />
                    </div>
                    
                    <!-- Tempat Ujian -->
                    <div class="mb-3">
                        <label for="id-field" class="form-label">Tempat Ujian</label>
                        <input required name="tempat_ujian" type="text" class="form-control" placeholder="tempat_ujian" />
                    </div>
                  
                </div>
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-success" id="add-btn">Tambah Gelombang</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

  <!-- modal edit -->
  @forelse($gelombang as $index => $g)
    <!-- modal edit -->
    <div class="modal fade" id="showModalEdit{{ $g->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-light p-3">
            <h5 class="modal-title" id="exampleModalLabel">Edit Gelombang {{ $g->nama_gelombang }} -
              {{ $g->tahun_ajaran }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
              id="close-modal"></button>
          </div>
          <form action="{{ route('gelombang.update', $g->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="modal-body">

              <div class="mb-3">
                <label for="id-field" class="form-label">Nama Gelombang</label>
                <input value="{{ $g->nama_gelombang }}" required name="nama_gelombang" type="text"
                  class="form-control" placeholder="nama_gelombang" />
              </div>
               <!-- Program Studi Ke-1 -->
               <div class="mb-3">
                <label for="program_studi_1" class="form-label">Pilihan Program Studi Ke 1</label>
                <div>
                    <input type="checkbox" id="select-all-prodi-1" class="form-check-input">
                    <label for="select-all-prodi-1" class="form-check-label">Select All</label>
                </div>
                <div class="row mt-2" id="program-studi-1-container">
                    @foreach($programStudis as $prodi)
                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox" name="program_studi_1[]" value="{{ $prodi->id }}" class="form-check-input prodi-1-checkbox" id="program-studi-1-{{ $prodi->id }}" {{ in_array($prodi->id, $g->program_studi_1->pluck('id')->toArray()) ? 'checked' : '' }}>
                                <label class="form-check-label" for="program-studi-1-{{ $prodi->id }}">
                                    <b>[UTAMA]</b> {{ $prodi->name }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            
            
            

           
                   <!-- Program Studi Ke-2 -->
                   <div class="mb-3">
                    <label for="program_studi_2" class="form-label">Program Studi Ke 2</label>
                    <div>
                        <input type="checkbox" id="select-all-prodi-2" class="form-check-input">
                        <label for="select-all-prodi-2" class="form-check-label">Select All</label>
                    </div>
                    <div class="row mt-2" id="program-studi-2-container">
                        @foreach($programStudis as $prodi)
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input type="checkbox" name="program_studi_2[]" value="{{ $prodi->id }}" class="form-check-input prodi-2-checkbox" id="program-studi-2-{{ $prodi->id }}" {{ in_array($prodi->id, $g->program_studi_2->pluck('id')->toArray()) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="program-studi-2-{{ $prodi->id }}">{{ $prodi->name }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                
          

            <!-- Program Studi Lain -->
            <div class="mb-3">
              <label for="prodi_lain" class="form-label">Program Studi Lain</label>
              <div class="row mt-2">
                  @foreach($prodiLain as $prodi)
                      <div class="col-md-6">
                          <div class="form-check">
                              <input type="radio" name="prodi_lain_id" value="{{ $prodi->id }}" class="form-check-input" {{ $g->prodi_lain_id == $prodi->id ? 'checked' : '' }} required>
                              <label class="form-check-label" for="prodi_lain_id_{{ $prodi->id }}">{{ $prodi->name }} - {{ $prodi->kampus }}</label>
                          </div>
                      </div>
                  @endforeach
              </div>
          </div>
          
              <div class="mb-3">
                <label for="id-field" class="form-label">Tahun Ajaran</label>
                <input value="{{ $g->tahun_ajaran }}" required name="tahun_ajaran" type="text"
                  class="form-control" placeholder="tahun_ajaran" />
              </div>
              <div class="mb-3">
                <label for="id-field" class="form-label">Tanggal Mulai</label>
                <input value="{{ $g->tanggal_mulai }}" required name="tanggal_mulai" type="date"
                  class="form-control" placeholder="tanggal_mulai" />
              </div>
              <div class="mb-3">
                <label for="id-field" class="form-label">tanggal Selesai</label>
                <input value="{{ $g->tanggal_selesai }}" required name="tanggal_selesai" type="date"
                  class="form-control" placeholder="tanggal_selesai" />
              </div>
              <div class="mb-3">
                <label for="status-field" class="form-label">Status</label>
                <select class="form-control" data-trigger value="{{ $g->status }}" required name="status"
                  id="status-field">
                  <option value="">Status</option>
                  <option value="Active" {{ $g->status == 'Active' ? 'selected' : '' }}>Active</option>
                  <option value="Off" {{ $g->status == 'Off' ? 'selected' : '' }}>Off</option>
                </select>
              </div>
              <div class="mb-3">
                <label for="id-field" class="form-label">Deskripsi</label>
                <input value="{{ $g->deskripsi }}" required name="deskripsi" type="text" class="form-control"
                  placeholder="deskripsi" />
              </div>
              <div class="mb-3">
                <label for="id-field" class="form-label">Biaya Pendaftaran</label>
                <input value="{{ $g->biaya_pendaftaran }}" required name="biaya_pendaftaran" type="number"
                  min="0" class="form-control" placeholder="biaya_pendaftaran" />
              </div>
              <div class="mb-3">
                <label for="id-field" class="form-label">Biaya Administrasi</label>
                <input value="{{ $g->biaya_administrasi }}" required name="biaya_administrasi" type="number"
                  min="0" class="form-control" placeholder="biaya_administrasi" />
              </div>
              <div class="mb-3">
                <label for="id-field" class="form-label">Tanggal Ujian</label>
                <input value="{{$g->tanggal_ujian}}" name="tanggal_ujian" type="date" class="form-control" placeholder="tanggal_ujian" />
            </div>
              <div class="mb-3">
                <label for="id-field" class="form-label">Kuota Pendaftar</label>
                <input value="{{ $g->kuota_pendaftar }}" required name="kuota_pendaftar" type="number"
                  min="0" class="form-control" placeholder="kuota_pendaftar" />
              </div>
              <div class="mb-3">
                <label for="id-field" class="form-label">Tempat Ujian</label>
                <input value="{{ $g->tempat_ujian }}" required name="tempat_ujian" type="text"
                 class="form-control" placeholder="tempat_ujian" />
              </div>
            </div>
            <div class="modal-footer">
              <div class="hstack gap-2 justify-content-end">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-success" id="add-btn">Update Gelombang</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- modal edit -->
  @empty
    @php
      echo 'Data Kosong';
    @endphp
  @endforelse

  <!-- modal delete -->
  @forelse($gelombang as $index => $g)
    <form action="{{ route('gelombang.destroy', $g->id) }}" method="post">
      @csrf
      @method('DELETE')
      <div class="modal fade zoomIn" id="deleteRecordModal{{ $g->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                id="btn-close"></button>
            </div>
            <div class="modal-body">
              <div class="mt-2 text-center">
                <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                  colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px">
                </lord-icon>
                <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                  <h4>Are you Sure ?</h4>
                  <p class="text-muted mx-4 mb-0">Are you Sure You want to Remove
                    {{ $g->nama_gelombang }} -
                    {{ $g->tahun_ajaran }} ?</p>
                </div>
              </div>
              <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn w-sm btn-danger " id="delete-record">Yes, Delete
                  It!</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  @empty
    @php
      echo 'Data Kosong';
    @endphp
  @endforelse
  <!-- modal delete -->
  @foreach ($gelombang as $i => $row)
    <!-- Modal Add Pendaftar -->
    <div class="modal fade" id="SetRecordModal{{ $row->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header bg-light p-3">
            <h5 class="modal-title" id="exampleModalLabel"></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
              id="close-modal"></button>
          </div>

          <div class="modal-body">
            <div class="row">
              <div class="col-lg-12">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title mb-0">ADD BERKAS GELOMBANG
                      {{ $row->nama_gelombang }}
                    </h4>

                  </div><!-- end card header -->
                  <form action="{{ route('transaksis.berkas_gelombang') }}" method="POST">
                    @csrf
                    <input type="hidden" name="gelombang_id" value="{{ $row->id }}">

                    <div class="card-body">
                      <div id="customerList">
                        <div class="row g-4 mb-3">
                          <div class="col-sm-auto">
                            <div>
                              <button type="submit" class="btn btn-success add-btn"><i
                                  class="ri-add-line align-bottom me-1"></i>Submit</button>
                              <!-- <button type="button" class="btn btn-success add-btn" data-bs-target="#importData"
                                                                                                          data-bs-toggle="modal"><i class="las la-file-excel label-icon align-middle fs-16 me-2"></i>
                                                                                                          Import</button> -->
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
                            <thead class="table-light">
                              <tr>
                                <th>NO</th>
                                <th scope="col" style="width: 50px;">
                                  <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="checkAll" value="option">
                                  </div>
                                </th>
                                <!-- <th class="sort" data-sort="customer_name">NIK</th> -->
                                <th class="sort" data-sort="email">NAMA BERKAS</th>
                              </tr>
                            </thead>
                            <tbody class="list form-check-all">

                              @foreach ($berkas as $i => $data)
                                <tr>
                                  <td>{{ ++$i }}</td>
                                  <th scope="row">
                                    <div class="form-check">

                                      @php
                                        $status = 1;
                                      @endphp

                                      @foreach ($row->berkas as $berkas_gelombang)
                                        @if ($berkas_gelombang->berkas_id == $data->id)
                                          @php
                                            $status = $berkas_gelombang->hapus;
                                          @endphp
                                        @endif
                                      @endforeach

                                      <input class="form-check-input berkas" type="checkbox" name="berkas[]"
                                        value="{{ $data->id }}" {{ $status == 0 ? 'checked' : '' }}>

                                    </div>
                                  </th>
                                  <td class="id" style="display:none;"><a href="javascript:void(0);"
                                      class="fw-medium link-primary">#VZ2101</a></td>
                                  <td class="customer_name">{{ $data->nama_berkas }}
                                  </td>

                                </tr>
                              @endforeach
                            </tbody>
                          </table>

                          <div class="noresult" style="display: none">
                            <div class="text-center">
                              <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px">
                              </lord-icon>
                              <h5 class="mt-2">Sorry! No Result Found</h5>
                              <p class="text-muted mb-0">We've searched more than 150+ Orders
                                We
                                did not find any
                                orders for you search.</p>
                            </div>
                          </div>
                        </div>

                        <div class="d-flex justify-content-center">
                          <div class="pagination-wrap hstack gap-2">
                            <a class="page-item pagination-prev disabled" href="#">
                              Previous
                            </a>
                            <ul class="pagination listjs-pagination mb-0"></ul>
                            <a class="page-item pagination-next" href="#">
                              Next
                            </a>
                          </div>
                        </div>
                      </div>
                    </div><!-- end card -->
                  </form>
                </div>
                <!-- end col -->
              </div>
              <!-- end col -->
            </div>
          </div>

        </div>
      </div>
    </div>
  @endforeach
@endsection
@section('script')
  <script src="{{ URL::asset('assets/libs/prismjs/prism.js') }}"></script>
  <script src="{{ URL::asset('assets/libs/list.js/list.min.js') }}"></script>
  <script src="{{ URL::asset('assets/libs/list.pagination.js/list.pagination.min.js') }}"></script>
  <!-- listjs init -->
  {{-- <script src="{{ URL::asset('assets/js/pages/listjs.init.js') }}"></script> --}}
  <script>
    var gelombangList,
      perPage = 5,
      options = {
        valueNames: ["nama", "tahun", 'tanggal_mulai', "tanggal_selesai", 'deskripsi', 'nominal', 'kuota', 'status'],
        page: perPage,
        pagination: !0,
        plugins: [ListPagination({
          left: 2,
          right: 2
        })],
      };
    document.getElementById("gelombangList") &&
      (gelombangList = new List("gelombangList", options).on(
        "updated",
        function(e) {
          0 == e.matchingItems.length ?
            (document.getElementsByClassName(
              "noresult"
            )[0].style.display = "block") :
            (document.getElementsByClassName(
              "noresult"
            )[0].style.display = "none");
          var t = 1 == e.i,
            a = e.i > e.matchingItems.length - e.page;
          document.querySelector(".pagination-prev.disabled") &&
            document
            .querySelector(".pagination-prev.disabled")
            .classList.remove("disabled"),
            document.querySelector(".pagination-next.disabled") &&
            document
            .querySelector(".pagination-next.disabled")
            .classList.remove("disabled"),
            t &&
            document
            .querySelector(".pagination-prev")
            .classList.add("disabled"),
            a &&
            document
            .querySelector(".pagination-next")
            .classList.add("disabled"),
            e.matchingItems.length <= perPage ?
            (document.querySelector(
              ".pagination-wrap"
            ).style.display = "none") :
            (document.querySelector(
              ".pagination-wrap"
            ).style.display = "flex"),
            e.matchingItems.length == perPage &&
            document
            .querySelector(".pagination.listjs-pagination")
            .firstElementChild.children[0].click(),
            0 < e.matchingItems.length ?
            (document.getElementsByClassName(
              "noresult"
            )[0].style.display = "none") :
            (document.getElementsByClassName(
              "noresult"
            )[0].style.display = "block");
        }
      ));

    document.querySelector(".pagination-next") &&
      document
      .querySelector(".pagination-next")
      .addEventListener("click", function() {
        !document.querySelector(".pagination.listjs-pagination") ||
          (document
            .querySelector(".pagination.listjs-pagination")
            .querySelector(".active") &&
            document
            .querySelector(".pagination.listjs-pagination")
            .querySelector(".active")
            .nextElementSibling.children[0].click());
      }),
      document.querySelector(".pagination-prev") &&
      document
      .querySelector(".pagination-prev")
      .addEventListener("click", function() {
        !document.querySelector(".pagination.listjs-pagination") ||
          (document
            .querySelector(".pagination.listjs-pagination")
            .querySelector(".active") &&
            document
            .querySelector(".pagination.listjs-pagination")
            .querySelector(".active")
            .previousSibling.children[0].click());
      });
  </script>

  <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
  <script>
    document.getElementById('select-all').addEventListener('click', function() {
var checkboxes = document.querySelectorAll('input[name="program_studi[]"]');
checkboxes.forEach(function(checkbox) {
checkbox.checked = document.getElementById('select-all').checked;
});
});


        </script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
      // Pilihan Program Studi Ke 1
      const selectAllProdi1 = document.getElementById('select-all-prodi-1');
      const prodi1Checkboxes = document.querySelectorAll('.prodi-1-checkbox');

      selectAllProdi1.addEventListener('change', function () {
          prodi1Checkboxes.forEach(checkbox => {
              checkbox.checked = selectAllProdi1.checked;
          });
      });

      prodi1Checkboxes.forEach(checkbox => {
          checkbox.addEventListener('change', function () {
              if (!this.checked) {
                  selectAllProdi1.checked = false;
              } else if ([...prodi1Checkboxes].every(cb => cb.checked)) {
                  selectAllProdi1.checked = true;
              }
          });
      });

      // Pilihan Program Studi Ke 2
      const selectAllProdi2 = document.getElementById('select-all-prodi-2');
      const prodi2Checkboxes = document.querySelectorAll('.prodi-2-checkbox');

      selectAllProdi2.addEventListener('change', function () {
          prodi2Checkboxes.forEach(checkbox => {
              checkbox.checked = selectAllProdi2.checked;
          });
      });

      prodi2Checkboxes.forEach(checkbox => {
          checkbox.addEventListener('change', function () {
              if (!this.checked) {
                  selectAllProdi2.checked = false;
              } else if ([...prodi2Checkboxes].every(cb => cb.checked)) {
                  selectAllProdi2.checked = true;
              }
          });
      });
  });
</script>
</script>
@endsection
