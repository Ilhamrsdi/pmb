@extends('layouts.master')
@section('title')
  Dashboard 
@endsection
@section('content')
  @component('components.breadcrumb')
    @slot('li_1')
      Dashboards
    @endslot
    @slot('title')
      Administrator
    @endslot
  @endcomponent
  <div class="row project-wrapper">
    <div class="col-xxl-8">
      <div class="row">
        <div class="col-xl-4">
          <div class="card card-animate">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="avatar-sm flex-shrink-0">
                  <span class="avatar-title bg-soft-primary text-primary rounded-2 fs-2">
                    <i data-feather="user" class="text-primary"></i>
                  </span>
                </div>
                <div class="flex-grow-1 overflow-hidden ms-3">
                  <p class="text-uppercase fw-medium text-muted text-truncate mb-3">Total Pendaftar</p>
                  <div class="d-flex align-items-center mb-3">
                    <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value"
                        data-target="{{ $data['total_pendaftar'] }}">0</span></h4>
                  </div>
                  <p class="text-muted text-truncate mb-0">Orang</p>
                </div>
              </div>
            </div><!-- end card body -->
          </div>
        </div><!-- end col -->

        <div class="col-xl-4">
          <div class="card card-animate">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="avatar-sm flex-shrink-0">
                  <span class="avatar-title bg-soft-danger text-danger rounded-2 fs-2">
                    <i data-feather="x" class="text-danger"></i>
                  </span>
                </div>
                <div class="flex-grow-1 ms-3">
                  <p class="text-uppercase fw-medium text-muted mb-3">Belum Bayar Pendaftaran</p>
                  <div class="d-flex align-items-center mb-3">
                    <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value"
                        data-target="{{ $data['total_belum_bayar_pendaftaran'] }}">0</span></h4>
                  </div>
                  <p class="text-muted mb-0">Orang</p>
                </div>
              </div>
            </div><!-- end card body -->
          </div>
        </div><!-- end col -->

        <div class="col-xl-4">
          <div class="card card-animate">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="avatar-sm flex-shrink-0">
                  <span class="avatar-title bg-soft-danger text-danger rounded-2 fs-2">
                    <i data-feather="x" class="text-danger"></i>
                  </span>
                </div>
                <div class="flex-grow-1 ms-3">
                  <p class="text-uppercase fw-medium text-muted mb-3">Belum Bayar UKT</p>
                  <div class="d-flex align-items-center mb-3">
                    <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value"
                        data-target="{{ $data['total_belum_bayar_ukt'] }}">0</span></h4>
                  </div>
                  <p class="text-muted mb-0">Orang</p>
                </div>
              </div>
            </div><!-- end card body -->
          </div>
        </div><!-- end col -->

      </div><!-- end row -->

      <div class="row">
        <div class="col-xl-8">
          <div class="card">
            <div class="card-header">
              <div class="row  align-items-center d-flex justify-content-between">
                <div class="col-6 col-md-6">
                  <h4 class="card-title mb-0 flex-grow-1">Grafik Pendaftar Berdasarkan Tahun</h4>
                </div>
                <div class="col-6 col-md-2">
                  <select name="tahun" id="tahun" class="form-select" onchange="updateChartSetahun()"></select>
                </div>
              </div>
            </div><!-- end card header -->
            <div class="card-body p-0 pb-2">
              <div>
                <div id="grafik-tahunan" data-colors='["--vz-primary", "--vz-success", "--vz-danger"]' class="apex-charts"
                  dir="ltr"></div>
              </div>
            </div><!-- end card body -->
          </div><!-- end card -->
        </div><!-- end col -->

        <div class="col-xl-4">
          <div class="card card-height-100">
            <div class="card-header align-items-center d-flex">
              <div class="row  align-items-center d-flex justify-content-between">
                <div class="col-6 col-md-6">
                  <h4 class="card-title mb-0 flex-grow-1">Grafik Pendaftar Berdasarkan Bulan</h4>
                </div>
                <div class="col-6 col-md-6">
                  <input type="month" id="filter" class="form-control" placeholder="Pilih Bulan"
                    value="{{ Carbon\Carbon::parse(now())->format('Y-m') }}" onchange="updateChartSebulan()">
                </div>
              </div>
            </div><!-- end card header -->
            <div class="card-body">
              <div id="grafik-bulanan" data-colors='["--vz-success", "--vz-primary", "--vz-warning", "--vz-danger"]'
                class="apex-charts" dir="ltr"></div>
              <div class="mt-3">
                <div class="d-flex justify-content-center align-items-center mb-4">
                  <h2 class="me-3 ff-secondary mb-0" id="total-pendaftar"></h2>
                  <div>
                    <p class="text-muted mb-0">Total Pendaftar</p>
                  </div>
                </div>

                <div class="d-flex justify-content-between border-bottom border-bottom-dashed py-2">
                  <p class="fw-medium mb-0"><i class="ri-checkbox-blank-circle-fill text-success align-middle me-2"></i>
                    Maba Diterima</p>
                  <div>
                    <span class="text-muted pe-5" id="maba-diterima"></span>
                  </div>
                </div><!-- end -->
                <div class="d-flex justify-content-between border-bottom border-bottom-dashed py-2">
                  <p class="fw-medium mb-0"><i class="ri-checkbox-blank-circle-fill text-primary align-middle me-2"></i>
                    Maba Belum Diterima</p>
                  <div>
                    <span class="text-muted pe-5" id="maba-belum-diterima"></span>
                  </div>
                </div><!-- end -->
                <div class="d-flex justify-content-between border-bottom border-bottom-dashed py-2">
                  <p class="fw-medium mb-0"><i class="ri-checkbox-blank-circle-fill text-warning align-middle me-2"></i>
                    Belum Bayar Pendaftaran</p>
                  <div>
                    <span class="text-muted pe-5" id="belum-bayar-pendaftaran"></span>
                  </div>
                </div><!-- end -->
                <div class="d-flex justify-content-between py-2">
                  <p class="fw-medium mb-0"><i class="ri-checkbox-blank-circle-fill text-danger align-middle me-2"></i>
                    Belum Bayar UKT</p>
                  <div>
                    <span class="text-muted pe-5" id="belum-bayar-ukt"></span>
                  </div>
                </div><!-- end -->
              </div>
            </div><!-- end cardbody -->
          </div><!-- end card -->
        </div>
      </div><!-- end row -->
    </div><!-- end col -->
  </div><!-- end row -->
@endsection
@section('script')
  <!-- apexcharts -->
  <script src="{{ URL::asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

  {{-- Grafik --}}
  <script>
    var total_pendaftar = document.getElementById('total-pendaftar')
    var maba_diterima = document.getElementById('maba-diterima')
    var maba_belum_diterima = document.getElementById('maba-belum-diterima')
    var belum_bayar_pendaftaran = document.getElementById('belum-bayar-pendaftaran')
    var belum_bayar_ukt = document.getElementById('belum-bayar-ukt')
    // Setting Color

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

    async function getGrafikSetahun(value) {
      let url = "{{ route('grafik-setahun') }}?tahun=" + value

      try {
        let res = await fetch(url);
        return await res.json();
      } catch (error) {
        console.log(error);
      }
    }

    async function renderChartSetahun() {
      let value = document.getElementById('tahun').value;
      let data = await getGrafikSetahun(value);

      console.log(data);

      var linechartcustomerColors = getChartColorsArray("grafik-tahunan");
      linechartcustomerColors &&
        ((options = {
            series: [{
                name: "Total Pendaftar",
                type: "bar",
                data: data.pendaftar,
              },
              {
                name: "Maba Diterima",
                type: "bar",
                data: data.diterima,
              },
              {
                name: "Maba Belum Diterima",
                type: "bar",
                data: data.belum_diterima,
              },
            ],
            chart: {
              height: 400,
              type: "line",
              toolbar: {
                show: !1
              }
            },
            xaxis: {
              categories: [
                "Jan",
                "Feb",
                "Mar",
                "Apr",
                "May",
                "Jun",
                "Jul",
                "Aug",
                "Sep",
                "Oct",
                "Nov",
                "Dec",
              ],
              axisTicks: {
                show: !1
              },
              axisBorder: {
                show: !1
              },
            },
            grid: {
              show: !0,
              xaxis: {
                lines: {
                  show: !0
                }
              },
              yaxis: {
                lines: {
                  show: !1
                }
              },
              padding: {
                top: 0,
                right: 10,
                bottom: 15,
                left: 10
              },
            },
            legend: {
              show: !0,
              horizontalAlign: "center",
              offsetX: 0,
              offsetY: -5,
              markers: {
                width: 9,
                height: 9,
                radius: 6
              },
              itemMargin: {
                horizontal: 10,
                vertical: 0
              },
            },
            plotOptions: {
              bar: {
                columnWidth: "30%",
                barHeight: "70%"
              }
            },
            colors: linechartcustomerColors,
            tooltip: {
              shared: !0,
              y: [{
                  formatter: function(e) {
                    return void 0 !== e ? e.toFixed(0) : e;
                  },
                },
                {
                  formatter: function(e) {
                    return void 0 !== e ? e.toFixed(0) : e;
                  },
                },
                {
                  formatter: function(e) {
                    return void 0 !== e ? e.toFixed(0) : e;
                  },
                },
              ],
            },
          }),
          (chart = new ApexCharts(
            document.querySelector("#grafik-tahunan"),
            options
          )).render());
    }

    async function updateChartSetahun() {
      let value = document.getElementById('tahun').value;
      let data = await getGrafikSetahun(value);

      console.log(data);

      chart.updateSeries([{
          name: "Total Pendaftar",
          type: "bar",
          data: data.pendaftar,
        },
        {
          name: "Maba Diterima",
          type: "bar",
          data: data.diterima,
        },
        {
          name: "Maba Belum Diterima",
          type: "bar",
          data: data.belum_diterima,
        },
      ]);
    }

    async function getGrafikSebulan(value) {
      let url = "{{ route('grafik-sebulan') }}?filter=" + value

      try {
        let res = await fetch(url);
        return await res.json();
      } catch (error) {
        console.log(error);
      }
    }

    async function renderChartSebulan() {
      let value = document.getElementById('filter').value;
      let data = await getGrafikSebulan(value);

      console.log(data);

      total_pendaftar.textContent = data[0]
      maba_diterima.textContent = data[1]
      maba_belum_diterima.textContent = data[2]
      belum_bayar_pendaftaran.textContent = data[3]
      belum_bayar_ukt.textContent = data[4]

      data.shift()

      var options,
        chart,
        donutchartProjectsStatusColors = getChartColorsArray("grafik-bulanan");
      donutchartProjectsStatusColors &&
        ((options = {
            series: data,
            labels: ["Maba Diterima", "Belum Diterima", "Belum Bayar UKT", "Belum Bayar Pendaftaran"],
            chart: {
              type: "donut",
              height: 230
            },
            plotOptions: {
              pie: {
                size: 100,
                offsetX: 0,
                offsetY: 0,
                donut: {
                  size: "90%",
                  labels: {
                    show: !1
                  }
                },
              },
            },
            dataLabels: {
              enabled: !1
            },
            legend: {
              show: !1
            },
            stroke: {
              lineCap: "round",
              width: 0
            },
            colors: donutchartProjectsStatusColors,
          }),
          (chart2 = new ApexCharts(
            document.querySelector("#grafik-bulanan"),
            options
          )).render());
    }

    async function updateChartSebulan() {
      let value = document.getElementById('filter').value;
      let data = await getGrafikSebulan(value);

      console.log(data);

      total_pendaftar.textContent = ''
      maba_diterima.textContent = ''
      maba_belum_diterima.textContent = ''
      belum_bayar_pendaftaran.textContent = ''
      belum_bayar_ukt.textContent = ''

      total_pendaftar.textContent = data[0]
      maba_diterima.textContent = data[1]
      maba_belum_diterima.textContent = data[2]
      belum_bayar_pendaftaran.textContent = data[3]
      belum_bayar_ukt.textContent = data[4]

      data.shift()

      chart2.updateSeries(data);
    }

    renderChartSetahun();
    renderChartSebulan();
  </script>

  <script>
    let startYear = 1800;
    let endYear = new Date().getFullYear();
    for (i = endYear; i > startYear; i--) {
      $('#tahun').append($('<option />').val(i).html(i));
    }
  </script>

  {{-- <script src="{{ URL::asset('/assets/js/pages/dashboard-projects.init.js') }}"></script> --}}
  <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
