@extends('layouts.master')
@section('title')
    @lang('DAFTAR ATRIBUT MAHASISWA BARU')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Calon Maba
        @endslot
        @slot('title')
            Daftar Atribut Maba
        @endslot
    @endcomponent
    @if (Session::has('success'))
        <div class="alert alert-success">
            <strong>Success: </strong>{{ Session::get('success') }}
        </div>
    @endif
    <div class="row">
        <div class="col-lg-12">
            <!--================= Filter Dropdown ===============================-->
            <div class="card">
                <div class="card-body">
                    <table class="table align-middle table-nowrap" id="pendaftarTable">
                        <thead class="table-light">
                            <tr>
                                <th>
                                    <select name="gelombang" id="gelombang" class="form-select">
                                        <option value="">PILIH GELOMBANG PENDAFTARAN</option>
                                        @foreach ($gelombangPendaftaran as $gel)
                                            <option value="{{ $gel->id }}">
                                                {{ $gel->nama_gelombang }}</option>
                                        @endforeach
                                    </select>
                                </th>
                                <th>
                                    <select name="tahunajaran" id="tahunajaran" class="form-select">
                                        <option value="">PILIH TAHUN AJARAN</option>
                                        @foreach ($tahunAjaran as $thn)
                                            <option value="{{ $thn->id }}">
                                                {{ $thn->tahun_ajaran }}
                                            </option>
                                        @endforeach
                                    </select>
                                </th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <!--================= End Filter Dropdown ===========================-->
            <div class="card">
                <div id="customerList">
                    <div class="card-header">
                        <div class="row g-4">
                            <div class="col-sm-auto">
                                <h4 class="card-title mt-2">DAFTAR MAHASISWA BARU DAN PILIHAN ATRIBUTNYA (Hanya Menampilkan
                                    Yang Sudah Memilih Attribut)</h4>
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
                    </div><!-- end card header -->
                    <div class="card-body">
                        <div class="table-responsive table-card mt-3 mb-1">
                            <table class="table align-middle table-nowrap" id="customerTable">
                                <thead class="table table-light table-borderless table-nowrap">
                                    <tr>
                                        <th rowspan="2" colspan="1">No</th>
                                        <th rowspan="2" colspan="1" data-sort="customer_name">NIK</th>
                                        <th rowspan="2" colspan="1" data-sort="customer_name">NAMA
                                            PENDAFTAR</th>
                                        <th rowspan="2" colspan="1" data-sort="customer_name">GELOMBANG
                                        </th>
                                        <th rowspan="2" colspan="1" data-sort="customer_name">TAHUN AJARAN
                                        </th>
                                        <th class="text-center" rowspan="1" colspan="5" data-sort="status">
                                            ATTRIBUT</th>
                                        <th class="text-center" rowspan="1" colspan="5" data-sort="action">
                                            PENGAMBILAN</th>
                                        <th rowspan="2" colspan="1" data-sort="email">PRINT
                                        </th>
                                    </tr>
                                    <tr role="row">
                                        <th rowspan="1" colspan="1" data-sort="date">KAOS</th>
                                        <th rowspan="1" colspan="1" data-sort="date">TOPI</th>
                                        <th rowspan="1" colspan="1" data-sort="email">ALMAMATER</th>
                                        <th rowspan="1" colspan="1" data-sort="email">JAS LAB</th>
                                        <th rowspan="1" colspan="1" data-sort="email">BAJU LAPANGAN
                                        </th>
                                        <th rowspan="1" colspan="1" data-sort="phone">KAOS</th>
                                        <th rowspan="1" colspan="1" data-sort="phone">TOPI</th>
                                        <th rowspan="1" colspan="1" data-sort="phone">ALMAMATER</th>
                                        <th rowspan="1" colspan="1" data-sort="status">JAS LAB</th>
                                        <th rowspan="1" colspan="1" data-sort="action">BAJU LAPANGAN
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all" id="tbodyPendaftarID">
                                    @foreach ($maba_attribut as $i => $row)
                                        <tr role="row">
                                            <td>{{ ++$i }}</td>
                                            <td class="id" style="display:none;"><a href="javascript:void(0);"
                                                    class="fw-medium link-primary">#VZ2101</a></td>
                                            <td class="customer_name">{{ $row->user->nik }}</td>
                                            <td class="customer_name">{{ $row->nama }}</td>
                                            <td class="customer_name">{{ $row->gelombangPendaftaran->nama_gelombang }}
                                            </td>
                                            <td class="customer_name">{{ $row->gelombangPendaftaran->tahun_ajaran }}</td>
                                            <td class="date text-center">{{ $row->atribut?->atribut_kaos }}</td>
                                            <td class="date text-center">{{ $row->atribut?->atribut_topi }}</td>
                                            <td class="email text-center">{{ $row->atribut?->atribut_almamater }}</td>
                                            <td class="email text-center">{{ $row->atribut?->atribut_jas_lab }}</td>
                                            <td class="email text-center">{{ $row->atribut?->atribut_baju_lapangan }}</td>
                                            <td class="phone text-center">
                                                @if ($row->atribut?->status_pengambilan_kaos != null)
                                                    <form action="{{ route('maba-attribut.kaos', $row->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="status_pengambilan_kaos" id="inlineCheckbox6"
                                                                checked onChange="this.form.submit()">
                                                            <label class="form-check-label" for="inlineCheckbox6"></label>
                                                        </div>
                                                    </form>
                                                @else
                                                    <form action="{{ route('maba-attribut.kaos', $row->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="status_pengambilan_kaos" id="inlineCheckbox6"
                                                                onChange="this.form.submit()">
                                                            <label class="form-check-label" for="inlineCheckbox6"></label>
                                                        </div>
                                                    </form>
                                                @endif
                                            </td>
                                            <td class="phone text-center">
                                                @if ($row->atribut?->status_pengambilan_topi != null)
                                                    <form action="{{ route('maba-attribut.topi', $row->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="status_pengambilan_topi" id="inlineCheckbox7"
                                                                checked onChange="this.form.submit()">
                                                            <label class="form-check-label" for="inlineCheckbox7"></label>
                                                        </div>
                                                    </form>
                                                @else
                                                    <form action="{{ route('maba-attribut.topi', $row->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="status_pengambilan_topi" id="inlineCheckalmamater"
                                                                onChange="this.form.submit()">
                                                            <label class="form-check-label"
                                                                for="inlineCheckalmamater"></label>
                                                        </div>
                                                    </form>
                                                @endif
                                            </td>
                                            <td class="phone text-center">
                                                @if ($row->atribut?->status_pengambilan_almamater != null)
                                                    <form action="{{ route('maba-attribut.almamater', $row->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="status_pengambilan_almamater" id="inlineCheckbox8"
                                                                checked onChange="this.form.submit()">
                                                            <label class="form-check-label" for="inlineCheckbox8"></label>
                                                        </div>
                                                    </form>
                                                @else
                                                    <form action="{{ route('maba-attribut.almamater', $row->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="status_pengambilan_almamater" id="inlineCheckbox8"
                                                                onChange="this.form.submit()">
                                                            <label class="form-check-label" for="inlineCheckbox8"></label>
                                                        </div>
                                                    </form>
                                                @endif
                                            </td>
                                            <td class="status text-center">
                                                <span>
                                                    @if ($row->atribut?->status_pengambilan_jas_lab != null)
                                                        <form action="{{ route('maba-attribut.jas', $row->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="status_pengambilan_jas_lab" id="inlineCheckbox9"
                                                                    checked onChange="this.form.submit()">
                                                                <label class="form-check-label"
                                                                    for="inlineCheckbox9"></label>
                                                            </div>
                                                        </form>
                                                    @else
                                                        <form action="{{ route('maba-attribut.jas', $row->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="status_pengambilan_jas_lab" id="inlineCheckbox9"
                                                                    onChange="this.form.submit()">
                                                                <label class="form-check-label"
                                                                    for="inlineCheckbox9"></label>
                                                            </div>
                                                        </form>
                                                    @endif
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                @if ($row->atribut?->status_pengambilan_baju_lapangan != null)
                                                    <form action="{{ route('maba-attribut.baju-lapangan', $row->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="status_pengambilan_baju_lapangan"
                                                                id="inlineCheckbox10" checked
                                                                onChange="this.form.submit()">
                                                            <label class="form-check-label"
                                                                for="inlineCheckbox10"></label>
                                                        </div>
                                                    </form>
                                                @else
                                                    <form action="{{ route('maba-attribut.baju-lapangan', $row->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="status_pengambilan_baju_lapangan"
                                                                id="inlineCheckbox10" onChange="this.form.submit()">
                                                            <label class="form-check-label"
                                                                for="inlineCheckbox10"></label>
                                                        </div>
                                                    </form>
                                                @endif
                                            </td>
                                            <td class="email text-center"><a
                                                    href="{{ route('maba-attribut.pdf', $row->id) }}"><i
                                                        class="ri-download-2-line" style="font-size: 20px"></i></a>
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
                                    <h5 class="mt-2">Maaf! Data yang anda cari tidak ada</h5>
                                    <p class="text-muted mb-0">Harap Perbaiki kata kunci yang anda cari. </p>
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
                    </div><!-- end card -->
                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
@endsection
@section('script')
    <script>
        //Form Select Search
        $('.form-select').select2({
            // theme: "bootstrap-5",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
        });
    </script>
    <!--=========================== Filter & Seearch on Select ===============================-->
    <script>
        //Filter with Dropdown
        $(document).ready(function() {
            $(document).on('click', '.pagination a', function(event) {
                event.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                getMoreUsers(page);
            });
            $('#gelombang').on('change', function() {
                getMoreUsers();
            });
            $('#tahunajaran').on('change', function(e) {
                getMoreUsers();
            });
        });

        function getMoreUsers(page) {
            // Search on based of country
            var gelombang = $("#gelombang option:selected").val();
            // Search on based of type
            var tahunajaran = $("#tahunajaran option:selected").val();
            $.ajax({
                type: "GET",
                contentType: 'multipart/form-data',
                data: {
                    'gelombang': gelombang,
                    'tahunajaran': tahunajaran,
                },
                url: "{{ route('maba-attribut.index') }}" + "?page=" + page,
                success: function(data) {
                    // $("#tbodyPendaftarID").html(data);
                    var maba_attribut = data.maba_attribut;
                    console.log(maba_attribut);
                    var html = '';
                    if (maba_attribut.length > 0) {
                        for (let i = 0; i < maba_attribut.length; i++) {
                            html += `<tr role="row">
                                <td>${i+1}</td>
                                <td>${maba_attribut[i]['user']['nik']}</td>
                                <td>${maba_attribut[i]['nama']}</td>
                                <td>${maba_attribut[i]['gelombang_pendaftaran']['nama_gelombang']}</td>
                                <td>${maba_attribut[i]['gelombang_pendaftaran']['tahun_ajaran']}</td>
                                <td>${maba_attribut[i]['atribut']['atribut_kaos']}</td>
                                <td>${maba_attribut[i]['atribut']['atribut_topi']}</td>
                                <td>${maba_attribut[i]['atribut']['atribut_almamater']}</td>
                                <td>${maba_attribut[i]['atribut']['atribut_jas_lab']}</td>
                                <td>${maba_attribut[i]['atribut']['atribut_baju_lapangan']}</td>
                                <td class="text-center">
                                    ${ maba_attribut[i]['atribut']['status_pengambilan_kaos']!=null ? `<form action="/admin/maba-attribut-kaos/${maba_attribut[i]['id']}"
                                                                                                                                                                                                method="POST">
                                                                                                                                                                                                @csrf
                                                                                                                                                                                                <div class="form-check form-check-inline">
                                                                                                                                                                                                    <input class="form-check-input" type="checkbox"
                                                                                                                                                                                                        name="status_pengambilan_kaos" id="inlineCheckbox6"
                                                                                                                                                                                                        checked onChange="this.form.submit()">
                                                                                                                                                                                                    <label class="form-check-label" for="inlineCheckbox6"></label>
                                                                                                                                                                                                </div>
                                                                                                                                                                                            </form>` : `<form action="/admin/maba-attribut-kaos/${maba_attribut[i]['id']}"
                                                                                                                                                                                                method="POST">
                                                                                                                                                                                                @csrf
                                                                                                                                                                                                <div class="form-check form-check-inline">
                                                                                                                                                                                                    <input class="form-check-input" type="checkbox"
                                                                                                                                                                                                        name="status_pengambilan_kaos" id="inlineCheckbox6"
                                                                                                                                                                                                        onChange="this.form.submit()">
                                                                                                                                                                                                    <label class="form-check-label" for="inlineCheckbox6"></label>
                                                                                                                                                                                                </div>
                                                                                                                                                                                            </form>`  
                                    }
                                </td>
                                <td class="text-center">
                                    ${ maba_attribut[i]['atribut']['status_pengambilan_topi']!=null ? `<form action="/admin/maba-attribut-topi/${maba_attribut[i]['id']}"
                                                                                                                                                                                                method="POST">
                                                                                                                                                                                                @csrf
                                                                                                                                                                                                <div class="form-check form-check-inline">
                                                                                                                                                                                                    <input class="form-check-input" type="checkbox"
                                                                                                                                                                                                        name="status_pengambilan_topi" id="inlineCheckbox6"
                                                                                                                                                                                                        checked onChange="this.form.submit()">
                                                                                                                                                                                                    <label class="form-check-label" for="inlineCheckbox6"></label>
                                                                                                                                                                                                </div>
                                                                                                                                                                                            </form>` : `<form action="/admin/maba-attribut-topi/${maba_attribut[i]['id']}"
                                                                                                                                                                                                method="POST">
                                                                                                                                                                                                @csrf
                                                                                                                                                                                                <div class="form-check form-check-inline">
                                                                                                                                                                                                    <input class="form-check-input" type="checkbox"
                                                                                                                                                                                                        name="status_pengambilan_topi" id="inlineCheckbox6"
                                                                                                                                                                                                        onChange="this.form.submit()">
                                                                                                                                                                                                    <label class="form-check-label" for="inlineCheckbox6"></label>
                                                                                                                                                                                                </div>
                                                                                                                                                                                            </form>`  
                                    }
                                </td>
                                <td class="text-center">
                                    ${ maba_attribut[i]['atribut']['status_pengambilan_almamater']!=null ? `<form action="/admin/maba-attribut-almamater/${maba_attribut[i]['id']}"
                                                                                                                                                                                                method="POST">
                                                                                                                                                                                                @csrf
                                                                                                                                                                                                <div class="form-check form-check-inline">
                                                                                                                                                                                                    <input class="form-check-input" type="checkbox"
                                                                                                                                                                                                        name="status_pengambilan_almamater" id="inlineCheckbox6"
                                                                                                                                                                                                        checked onChange="this.form.submit()">
                                                                                                                                                                                                    <label class="form-check-label" for="inlineCheckbox6"></label>
                                                                                                                                                                                                </div>
                                                                                                                                                                                            </form>` : `<form action="/admin/maba-attribut-almamater/${maba_attribut[i]['id']}"
                                                                                                                                                                                                method="POST">
                                                                                                                                                                                                @csrf
                                                                                                                                                                                                <div class="form-check form-check-inline">
                                                                                                                                                                                                    <input class="form-check-input" type="checkbox"
                                                                                                                                                                                                        name="status_pengambilan_almamater" id="inlineCheckbox6"
                                                                                                                                                                                                        onChange="this.form.submit()">
                                                                                                                                                                                                    <label class="form-check-label" for="inlineCheckbox6"></label>
                                                                                                                                                                                                </div>
                                                                                                                                                                                            </form>`  
                                    }
                                </td>
                                <td class="text-center">
                                    <span>
                                        ${ maba_attribut[i]['atribut']['status_pengambilan_jas_lab']!=null ? `<form action="/admin/maba-attribut-jas/${maba_attribut[i]['id']}"
                                                                                         method="POST">
                                                                                        @csrf
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input" type="checkbox"
                                                                                                name="status_pengambilan_jas_lab" id="inlineCheckbox6"
                                                                                                checked onChange="this.form.submit()">
                                                                                            <label class="form-check-label" for="inlineCheckbox6"></label>
                                                                                        </div>
                                                                                        </form>` : `<form action="/admin/maba-attribut-jas/${maba_attribut[i]['id']}"
                                                                                        method="POST">
                                                                                        @csrf
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input" type="checkbox"
                                                                                                name="status_pengambilan_jas_lab" id="inlineCheckbox6"
                                                                                                onChange="this.form.submit()">
                                                                                            <label class="form-check-label" for="inlineCheckbox6"></label>
                                                                                        </div>
                                                                                    </form>`  
                                    }
                                    </span>
                                </td>
                                <td class="text-center">
                                    ${ maba_attribut[i]['atribut']['status_pengambilan_baju_lapangan']!=null ? `<form action="/admin/maba-attribut-baju-lapangan/${maba_attribut[i]['id']}"
                                                                                                                                                                                                method="POST">
                                                                                                                                                                                                @csrf
                                                                                                                                                                                                <div class="form-check form-check-inline">
                                                                                                                                                                                                    <input class="form-check-input" type="checkbox"
                                                                                                                                                                                                        name="status_pengambilan_baju_lapangan" id="inlineCheckbox6"
                                                                                                                                                                                                        checked onChange="this.form.submit()">
                                                                                                                                                                                                    <label class="form-check-label" for="inlineCheckbox6"></label>
                                                                                                                                                                                                </div>
                                                                                                                                                                                            </form>` : `<form action="/admin/maba-attribut-baju-lapangan/${maba_attribut[i]['id']}"
                                                                                                                                                                                                method="POST">
                                                                                                                                                                                                @csrf
                                                                                                                                                                                                <div class="form-check form-check-inline">
                                                                                                                                                                                                    <input class="form-check-input" type="checkbox"
                                                                                                                                                                                                        name="status_pengambilan_baju_lapangan" id="inlineCheckbox6"
                                                                                                                                                                                                        onChange="this.form.submit()">
                                                                                                                                                                                                    <label class="form-check-label" for="inlineCheckbox6"></label>
                                                                                                                                                                                                </div>
                                                                                                                                                                                            </form>`  
                                    }
                                </td>
                                <td class="email text-center"><a
                                                    href="/admin/maba-attribut-pdf/${maba_attribut[i]['id']}"><i
                                                        class="ri-download-2-line" style="font-size: 20px"></i></a>
                                </td>
                            </tr>`;
                        }
                    } else {
                        html +=
                            `<tr><td colspan="16"><div class="text-center">
                                <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                    colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px">
                                </lord-icon>
                                <h5 class="mt-2">Maaf! Data yang anda cari tidak ada</h5>
                                <p class="text-muted mb-0">Harap Perbaiki kata kunci yang anda cari. </p>
                            </div></td></tr>`;
                    }
                    $("#tbodyPendaftarID").html(html);
                },
                error: function(data) {
                    html +=
                        `<tr><td colspan="16"><div class="text-center">
                                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                        colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px">
                                    </lord-icon>
                                    <h5 class="mt-2">Maaf! Data yang anda cari tidak ada</h5>
                                    <p class="text-muted mb-0">Harap Perbaiki kata kunci yang anda cari. </p>
                                </div></td></tr>`;
                }
            });
        }
    </script>
    <!--=========================== End Filter & Seearch on Select ===========================-->
    <script src="{{ URL::asset('assets/libs/prismjs/prismjs.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/list.js/list.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/list.pagination.js/list.pagination.min.js') }}"></script>
    <!-- listjs init -->
    <script src="{{ URL::asset('assets/js/pages/listjs.init.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
