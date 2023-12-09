@include('layout.header')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col">

                    <div class="row p-1 ">
                        Filter Tanggal :
                    </div>
                    <div class="row p-1">
                        <input class="form-control col-md-2" type="date" name="tgl" id="inputDate">
                        <br>
                        <select id="listWil" class="form-control col-md-2">
                            @foreach ($listWil as $key => $list)
                            <option value="{{$list}}" {{ $key==0 ? 'selected' : '' }}>{{$list}}</option>
                            @endforeach
                        </select>
                        <select id="listLoc" class="form-control col-md-2">

                        </select>
                    </div>
                    <!-- Curah Hujan -->
                    <div class="card card-red mt-3">
                        <div class="card-header">
                            <div class=" card-title">
                                <i class="fas fa-water pr-2"></i>Water Level Per Bulan
                            </div>
                            <div class="float-right">
                                <div class="list-inline">
                                    {{-- <h5 class="list-inline-item">Lokasi</h5> --}}
                                    {{-- <form class="list-inline-item col-md-5" action="{{ route('grafik_wl') }}"
                                        method="get">
                                        <select name="id" class="form-control-sm" onchange="this.form.submit()">
                                            <option value="" selected disabled>Pilih Lokasi</option>
                                            @foreach ($listLoc as $key => $list)
                                            <option value="{{$key}}">{{$list}}</option>
                                            @endforeach
                                        </select>
                                    </form> --}}
                                </div>
                            </div>

                        </div>
                        <div class="card-body">

                            <div class="chart" id="chartBulanan">
                            </div>

                        </div><!-- /.card-body -->
                    </div><!-- Curah Hujan -->


                    <!-- Curah Hujan -->
                    {{-- <div class="card card-cyan">
                        <div class="card-header">
                            <div class=" card-title">
                                <i class="fas fa-water pr-2"></i>Water Level {{$listLoc[Request()->id ?: $defaultId]}}
                                dalam
                                7 hari terakhir
                            </div>
                            <div class="float-right">

                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart" id="wlPerminggu">
                            </div>
                        </div><!-- /.card-body -->
                    </div><!-- Curah Hujan --> --}}

                    <!-- Curah Hujan -->

                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
@include('layout.footer')

<!-- jQuery -->
<script src="{{ asset('/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('/plugins/chart.js/Chart.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('/js/demo.js') }}"></script>

<script src="{{ asset('/js/loader.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script type="text/javascript">
    var chart;
  function handleAjaxRequest(selectedValue, currentDate) {
        
        $.ajax({
            url: '{{ route("get_estate") }}', // Replace with your actual endpoint URL
            type: 'GET',
            data: {  wil: selectedValue,
            tgl: currentDate },
              success: function (data) {
                  // Update the content or perform other actions based on the AJAX response
                  var selectLoc = $('#listLoc');
                  selectLoc.empty(); // Clear existing options

                  // Check if data is empty
                  if ($.isEmptyObject(data)) {
                      // If data is empty, add a disabled option
                      selectLoc.append($('<option>', {
                          value: '',
                          text: 'Tidak ada implementasi pada wilayah ini',
                          disabled: true
                      }));
                  } else {
                      // Iterate through the object and append options to the select element
                      $.each(data, function (index, location) {
                          selectLoc.append($('<option>', {
                              value: location,
                              text: location
                          }));
                      });

                      var defaultSelectedValue = selectLoc.val();
                      handleListLocClick(defaultSelectedValue,currentDate);
                  }
              },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    }

    function handleListLocClick(selectedValue, currentDate) {      
      var rangeDays, lvl_in;
      $.ajax({
            url: '{{ route("get_data_bulan") }}', // Replace with your actual endpoint URL
            type: 'GET',
            data: {  titikPompa: selectedValue,
            tgl: currentDate },
              success: function (data) {

                  rangeDays = data.rangeDays;
                  lvl_in = data.lvl_in;
                  lvl_out = data.lvl_out;
                  lvl_act = data.lvl_act;

                  renderApexChart(rangeDays, lvl_in, lvl_out, lvl_act);
              },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
  
    }

  


function renderApexChart(rangeDays, lvl_in, lvl_out, lvl_act) {
    
  var options = {
        chart: {
            type: 'area',
            height: 350
        },
        series: [
            {
                name: 'lvl_in',
                data: lvl_in
            },
            {
                name: 'lvl_out',
                data: lvl_out
            },
            {
                name: 'lvl_act',
                data: lvl_act
            }
        ],
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'smooth'
        },
        title: {
            text: 'Rekap rata-rata harian ',
            align: 'left',
            style: {
                fontSize: '14px'
            }
        },
        xaxis: {
            type: 'category',
            categories: rangeDays,
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false
            },
            labels: {
                formatter: function (value) {
                    return value;
                }
            }
        },
        yaxis: {
            type: 'numeric', // Set the y-axis type to numeric
            tickAmount: 4,
            floating: false,
            labels: {
                style: {
                    colors: '#8e8da4',
                },
                offsetY: -7,
                offsetX: 0,
            },
            axisBorder: {
                show: false,
            },
            axisTicks: {
                show: false
            }
        },
        fill: {
            opacity: 0.5
        },
        tooltip: {
            x: {
                format: 'dd MMM'
            },
            fixed: {
                enabled: false,
                position: 'topRight'
            }
        },
        grid: {
            yaxis: {
                lines: {
                    offsetX: -30
                }
            },
            padding: {
                left: 20
            }
        }
    };


    if (!chart) {
        chart = new ApexCharts(document.querySelector("#chartBulanan"), options);
        chart.render();
    } else {

        chart.updateSeries([
            {
                name: 'lvl_in',
                data: lvl_in
            },
            {
                name: 'lvl_out',
                data: lvl_out
            },{
                name: 'lvl_act',
                data: lvl_act
            }
        ]);
    }
}

    
    $(document).ready(function () {
    
        var defaultSelectedValue = $('#listWil option:first').val();
        
        var currentDate = $('#inputDate').val(); // Get initial date value

        $('#listWil').val(defaultSelectedValue);
        handleAjaxRequest(defaultSelectedValue, currentDate);

        $('#listWil').on('change', function () {
            var selectedValue = $(this).val();
            handleAjaxRequest(selectedValue, currentDate);
        });

        $('#inputDate').on('change', function () {
            currentDate = $(this).val(); // Update currentDate when the date changes
            
            handleAjaxRequest($('#listWil').val(), currentDate);
        });

            $('#listLoc').on('change', function () {
                var selectedValue = $(this).val();

                handleListLocClick(selectedValue , currentDate);
            });
    });
</script>