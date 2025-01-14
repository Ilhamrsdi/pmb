@extends('layouts.master')
@section('title')
  GRAFIK BERDASARKAN PROGRAM STUDI
@endsection
@section('content')
  @component('components.breadcrumb')
    @slot('li_1')
      Laporan
    @endslot
    @slot('title')
      Grafik Program Studi
    @endslot
  @endcomponent
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header border-0 align-items-center d-flex bg-soft-light">
          <div class="col-12">
            <div class="row">
              <div class="col-10">
                <form action="{{ route('grafikProdi') }}" method="get">
                  <div class="row">
                    <div class="col-11">
                      <select name="gelombang" id="gelombang" class="form-select">
                        <option value="">PILIH GELOMBANG PENDAFTARAN</option>
                        @foreach ($data_gelombang as $gelombang)
                          <option value="{{ $gelombang->id }}"
                            {{ request()->gelombang == $gelombang->id ? 'selected' : '' }}>
                            {{ $gelombang->nama_gelombang }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-1">
                      <button type="submit" class="btn btn-primary">Filter</button>
                    </div>
                  </div>
                </form>
              </div>
              <div class="col-2">
                <select class="form-select" name="tipe" id="tipe">
                  <option>Pilih Tipe</option>
                  <option value="bar">Bar Chart</option>
                  <option value="line">Line Chart</option>
                  <option value="donut">Donut Chart</option>
                  <option value="polar">Polar Chart</option>
                </select>
              </div>
            </div>
          </div>
        </div><!-- end card header -->
        <div class="card-body p-0 pb-2">
          <div class="p-2">
            <div id="grafik-prodi" data-colors='["--vz-primary"]' class="apex-charts" dir="ltr"></div>
          </div>
        </div><!-- end card body -->
      </div><!-- end card -->
    </div><!-- end col -->
  </div><!-- end row -->
@endsection
@section('script')
  <!-- apexcharts -->
  <script src="{{ URL::asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

  {{-- chart --}}
  <script>
    var data = @json($data);
    var data_prodi = @json($data_prodi);
    var prodi = data_prodi.map((value) => value.name);
  
    var total = [];
  
    // Inisialisasi array total dengan nilai 0
    for (let i = 0; i < prodi.length; i++) {
      total.push(0);
    }
  
    // Mengisi nilai total berdasarkan data yang ada
    prodi.map((value, index) => {
      data.forEach(element => {
        if (element.prodi === value) {
          total[index] = element.total;
        }
      });
    });
  
    // Cek apakah total sudah terisi dengan benar
    console.log(total);
  
    function getChartColorsArray(e) {
      if (null !== document.getElementById(e)) {
        var t = document.getElementById(e).getAttribute("data-colors");
        if (t)
          return (t = JSON.parse(t)).map(function(e) {
            var t = e.replace(" ", "");
            if (-1 === t.indexOf(",")) {
              var r = getComputedStyle(document.documentElement).getPropertyValue(t);
              return r || t;
            }
            e = e.split(",");
            return 2 !== e.length ? t : "rgba(" + getComputedStyle(document.documentElement).getPropertyValue(e[0]) + "," + e[1] + ")";
          });
        console.warn("data-colors Attribute not found on:", e);
      }
    }
  
    var linechartcustomerColors = getChartColorsArray("grafik-prodi");
  
    barChart();
  
    function barChart() {
      let optionsBar = {
        chart: {
          height: 350,
          type: "bar",
          toolbar: { show: false }
        },
        plotOptions: {
          bar: {
            horizontal: false,
            columnWidth: '50%' // Menyesuaikan lebar bar
          }
        },
        dataLabels: {
          enabled: true, // Menampilkan label data di dalam bar
          style: {
            fontSize: '12px',
            colors: ['#fff'] // Warna teks label
          }
        },
        series: [{
          name: 'Total Pendaftar',
          data: total
        }],
        colors: linechartcustomerColors,
        grid: {
          borderColor: "#f1f1f1"
        },
        xaxis: {
          categories: prodi,
        },
        yaxis: {
          title: {
            text: 'Jumlah Pendaftar'
          }
        }
      };
  
      // Render grafik jika elemen #grafik-prodi ada
      if (document.querySelector("#grafik-prodi")) {
        const chart = new ApexCharts(document.querySelector("#grafik-prodi"), optionsBar);
        chart.render();
      }
    }
  </script>
  

  {{-- <script src="{{ URL::asset('/assets/js/pages/dashboard-projects.init.js') }}"></script> --}}
  <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
