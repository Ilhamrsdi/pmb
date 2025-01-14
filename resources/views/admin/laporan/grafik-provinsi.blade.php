@extends('layouts.master')
@section('title')
  GRAFIK BERDASARKAN PROVINSI
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
                <form action="{{ route('grafikProvinsi') }}" method="get">
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
          <div>
            <div id="grafik-provinsi" data-colors='["--vz-primary"]' class="apex-charts" dir="ltr"></div>
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
    var total = data.map((value) => value.total)
    var provinsi = data.map((value) => value.provinsi)

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

    var linechartcustomerColors = getChartColorsArray("grafik-provinsi");

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
          categories: provinsi,
        },
      }
      document.querySelector("#grafik-provinsi") &&
        (chart = new ApexCharts(
          document.querySelector("#grafik-provinsi"),
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
          categories: provinsi,
        },
      }
      document.querySelector("#grafik-provinsi") &&
        (chart = new ApexCharts(
          document.querySelector("#grafik-provinsi"),
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
        labels: provinsi,
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
      document.querySelector("#grafik-provinsi") &&
        (chart = new ApexCharts(
          document.querySelector("#grafik-provinsi"),
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
        labels: provinsi,
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
      document.querySelector("#grafik-provinsi") &&
        (chart = new ApexCharts(
          document.querySelector("#grafik-provinsi"),
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
    //       series: [{
    //         name: "Total Pendaftar",
    //         type: "bar",
    //         data: total,
    //       }],
    //       chart: {
    //         height: 374,
    //         type: "line",
    //         toolbar: {
    //           show: !1
    //         }
    //       },
    //       stroke: {
    //         curve: "smooth",
    //         dashArray: [0, 3, 0],
    //         width: [0, 1, 0]
    //       },
    //       fill: {
    //         opacity: [1, 0.1, 1]
    //       },
    //       markers: {
    //         size: [0, 4, 0],
    //         strokeWidth: 2,
    //         hover: {
    //           size: 4
    //         }
    //       },
    //       xaxis: {
    //         categories: provinsi,
    //         axisTicks: {
    //           show: !1
    //         },
    //         axisBorder: {
    //           show: !1
    //         },
    //       },
    //       grid: {
    //         show: !0,
    //         xaxis: {
    //           lines: {
    //             show: !0
    //           }
    //         },
    //         yaxis: {
    //           lines: {
    //             show: !1
    //           }
    //         },
    //         padding: {
    //           top: 0,
    //           right: 10,
    //           bottom: 15,
    //           left: 10
    //         },
    //       },
    //       legend: {
    //         show: !0,
    //         horizontalAlign: "center",
    //         offsetX: 0,
    //         offsetY: -5,
    //         markers: {
    //           width: 9,
    //           height: 9,
    //           radius: 6
    //         },
    //         itemMargin: {
    //           horizontal: 10,
    //           vertical: 0
    //         },
    //       },
    //       plotOptions: {
    //         bar: {
    //           columnWidth: "30%",
    //           barHeight: "70%"
    //         }
    //       },
    //       colors: linechartcustomerColors,
    //       tooltip: {
    //         shared: !0,
    //         y: [{
    //           formatter: function(e) {
    //             return void 0 !== e ? e.toFixed(0) : e;
    //           },
    //         }],
    //       },
    //     }),
    //     (chart = new ApexCharts(
    //       document.querySelector("#grafik-provinsi"),
    //       options
    //     )).render());
  </script>

  {{-- <script src="{{ URL::asset('/assets/js/pages/dashboard-projects.init.js') }}"></script> --}}
  <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
