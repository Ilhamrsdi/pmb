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
      Grafik Provinsi
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
    var prodi = data_prodi.map((value) => value.nama_program_studi)

    var total = []

    for (let i = 0; i < prodi.length; i++) {
      total.push(0)
    }

    prodi.map((value, index) => {
      data.forEach(element => {
        if (element.prodi == value) {
          total[index] = element.total
        }
      });
    })


    function getChartColorsArray(e) {
      if (null !== document.getElementById(e)) {
        var t = document.getElementById(e).getAttribute("data-colors");
        if (t)
          return (t = JSON.parse(t)).map(function(e) {
            var t = e.replace(" ", "");
            if (-1 === t.indexOf(",")) {
              var r = getComputedStyle(
                document.documentElement
              ).getPropertyValue(t);
              return r || t;
            }
            e = e.split(",");
            return 2 != e.length ?
              t :
              "rgba(" +
              getComputedStyle(
                document.documentElement
              ).getPropertyValue(e[0]) +
              "," +
              e[1] +
              ")";
          });
        console.warn("data-colors Attribute not found on:", e);
      }
    }
    var linechartcustomerColors = getChartColorsArray("grafik-prodi");

    barChart()

    function barChart() {
      let optionsBar = {
        chart: {
          height: 350,
          type: "bar",
          toolbar: {
            show: !1
          }
        },
        plotOptions: {
          bar: {
            horizontal: !0
          }
        },
        dataLabels: {
          enabled: !1
        },
        series: [{
          name: 'Total pendaftar',
          data: total
        }, ],
        colors: linechartcustomerColors,
        grid: {
          borderColor: "#f1f1f1"
        },
        xaxis: {
          categories: prodi,
        },
      }
      document.querySelector("#grafik-prodi") &&
        (chart = new ApexCharts(
          document.querySelector("#grafik-prodi"),
          optionsBar
        )).render();
    }

    function lineChart() {
      let optionsLine = {
        series: [{
          name: "Pendaftar",
          data: total
        }, ],
        chart: {
          height: 350,
          type: "line",
          zoom: {
            enabled: !1
          },
          toolbar: {
            show: !1
          },
        },
        markers: {
          size: 4
        },
        dataLabels: {
          enabled: !1
        },
        stroke: {
          curve: "straight"
        },
        colors: linechartcustomerColors,
        xaxis: {
          categories: prodi,
        },
      }
      document.querySelector("#grafik-prodi") &&
        (chart = new ApexCharts(
          document.querySelector("#grafik-prodi"),
          optionsLine
        )).render();
    }

    function donutChart() {
      let optionsDonut = {
        series: total,
        chart: {
          height: 300,
          type: "pie"
        },
        labels: prodi,
        theme: {
          monochrome: {
            enabled: !0,
            color: "#6691E7",
            shadeTo: "light",
            shadeIntensity: 0.6,
          },
        },
        plotOptions: {
          pie: {
            dataLabels: {
              offset: -5
            }
          }
        },
        dataLabels: {
          formatter: function(e, t) {
            return [t.w.globals.labels[t.seriesIndex], e.toFixed(1) + "%"];
          },
          dropShadow: {
            enabled: !1
          },
        },
        legend: {
          show: !1
        },
      };
      document.querySelector("#grafik-prodi") &&
        (chart = new ApexCharts(
          document.querySelector("#grafik-prodi"),
          optionsDonut
        )).render();
    }

    function polarChart() {
      let optionsPolar = {
        series: total,
        chart: {
          width: 400,
          type: "polarArea"
        },
        labels: prodi,
        fill: {
          opacity: 1
        },
        stroke: {
          width: 1,
          colors: void 0
        },
        yaxis: {
          show: !1
        },
        legend: {
          position: "bottom"
        },
        plotOptions: {
          polarArea: {
            rings: {
              strokeWidth: 0
            },
            spokes: {
              strokeWidth: 0
            },
          },
        },
        theme: {
          mode: "light",
          palette: "palette1",
          monochrome: {
            enabled: !0,
            shadeTo: "light",
            color: "#6691E7",
            shadeIntensity: 0.6,
          },
        },
      };
      document.querySelector("#grafik-prodi") &&
        (chart = new ApexCharts(
          document.querySelector("#grafik-prodi"),
          optionsPolar
        )).render();
    }

    let select = document.getElementById('tipe')
    select.addEventListener('change', () => {
      let tipe = select.value

      switch (tipe) {
        case 'bar':
          chart.destroy();
          return barChart()
          break;

        case 'line':
          chart.destroy();
          return lineChart()
          break;

        case 'donut':
          chart.destroy();
          return donutChart()
          break;

        case 'polar':
          chart.destroy();
          return polarChart()
          break;

        default:
          return barChart
          break;
      }

    })

    // linechartcustomerColors &&
    //   ((options = {
    //       chart: {
    //         height: 350,
    //         type: "bar",
    //         toolbar: {
    //           show: !1
    //         }
    //       },
    //       plotOptions: {
    //         bar: {
    //           horizontal: !0
    //         }
    //       },
    //       dataLabels: {
    //         enabled: !1
    //       },
    //       series: [{
    //         name: 'Total pendaftar',
    //         data: total
    //       }, ],
    //       colors: linechartcustomerColors,
    //       grid: {
    //         borderColor: "#f1f1f1"
    //       },
    //       xaxis: {
    //         categories: prodi,
    //       },
    //     }),
    //     (chart = new ApexCharts(
    //       document.querySelector("#grafik-prodi"),
    //       options
    //     )).render());
  </script>

  {{-- <script src="{{ URL::asset('/assets/js/pages/dashboard-projects.init.js') }}"></script> --}}
  <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
