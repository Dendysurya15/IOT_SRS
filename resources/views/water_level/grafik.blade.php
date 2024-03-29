@include('layout.header')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    </section>
    <!-- <h1>ach</h1> -->
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
                                <i class="fas fa-water pr-2"></i>Grafik Water Level
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


                            <div class="chart" id="charthour">
                            </div>

                            <div class="chart" id="chartweek">
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
            data: {
                wil: selectedValue,
                tgl: currentDate
            },
            success: function(data) {
                // Update the content or perform other actions based on the AJAX response
                var selectLoc = $('#listLoc');
                selectLoc.empty(); // Clear existing options

                if ($.isEmptyObject(data)) {
                    selectLoc.append($('<option>', {
                        value: '',
                        text: 'Tidak ada implementasi pada wilayah ini',
                        disabled: true
                    }));
                } else {
                    $.each(data, function(index, location) {
                        selectLoc.append($('<option>', {
                            value: location,
                            text: location
                        }));
                    });

                    var defaultSelectedValue = selectLoc.val();
                    handleListLocClick(defaultSelectedValue, currentDate);
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }

    function handleListLocClick(selectedValue, currentDate) {
        var rangeDays, lvl_in;
        $.ajax({
            url: '{{ route("get_data_bulan") }}', // Replace with your actual endpoint URL
            type: 'GET',
            data: {
                titikPompa: selectedValue,
                tgl: currentDate
            },
            success: function(data) {

                renderApexChart(data);
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });

    }




    function renderApexChart(data) {


        
        rangeDays = data.rangeDays;
        lvl_in = data.lvl_in;
        lvl_out = data.lvl_out;
        lvl_act = data.lvl_act;

        rangeDays2 = data.ktgH;
        lvl_in2 = data.avg_lvlin;
        lvl_out2 = data.avg_lvlout;
        lvl_act2 = data.avg_lvlact;


        rangeDays3 = data.keyWeek;
        lvl_in3 = data.week_lvlin;
        lvl_out3 = data.week_lvlout;
        lvl_act3 = data.week_lvlact;
        
        
        var options = {
            chart: {
                type: 'area',
                height: 350
            },
            series: [{
                    name: '',
                    data: ''
                },
                {
                    name: '',
                    data: ''
                },
                {
                    name: '',
                    data: ''
                }
            ],
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth'
            },
            title: {
                text: '',
                align: 'left',
                style: {
                    fontSize: '14px'
                }
            },
            xaxis: {
                type: 'category',
                categories: '',
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false
                },
                labels: {
                    formatter: function(value) {
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
        chart = new ApexCharts(document.querySelector("#chartBulanan"), options);
            chart.render();
        chart2 = new ApexCharts(document.querySelector("#charthour"), options);
            chart2.render();
    chart3 = new ApexCharts(document.querySelector("#chartweek"), options);
            chart3.render();

        // if (!chart) {
        //     // chart = new ApexCharts(document.querySelector("#chartBulanan"), options);
        //     // chart.render();

        //     // chart2 = new ApexCharts(document.querySelector("#charthour"), options);
        //     // chart2.render();
        //     chart3 = new ApexCharts(document.querySelector("#chartweek"), options);
        //     chart3.render();
        // } else {
            chart.updateOptions({
                xaxis: {
                    categories: rangeDays,

                },
                title: {
                    text: 'Rekap rata-rata Bulanan ',
                    align: 'left',
                    style: {
                        fontSize: '14px'
                    }
                },
            });
            chart2.updateOptions({
                xaxis: {
                    categories: rangeDays2,

                },
                title: {
                    text: 'Rekap rata-rata Perjam ',
                    align: 'left',
                    style: {
                        fontSize: '14px'
                    }
                },
            });
            chart3.updateOptions({
                xaxis: {
                    categories: rangeDays3,

                },
                title: {
                    text: 'Rekap rata-rata PerMinggu ',
                    align: 'left',
                    style: {
                        fontSize: '14px'
                    }
                },
            });
            chart.updateSeries([{
                    name: 'lvl_in',
                    data: lvl_in
                },
                {
                    name: 'lvl_out',
                    data: lvl_out
                }, {
                    name: 'lvl_act',
                    data: lvl_act
                }
            ]);
            chart2.updateSeries([{
                    name: 'lvl_in',
                    data: lvl_in2
                },
                {
                    name: 'lvl_out',
                    data: lvl_out2
                }, {
                    name: 'lvl_act',
                    data: lvl_act2
                }
            ]);
            chart3.updateSeries([{
                    name: 'lvl_in',
                    data: lvl_in3
                },
                {
                    name: 'lvl_out',
                    data: lvl_out3
                }, {
                    name: 'lvl_act',
                    data: lvl_act3
                }
            ]);
        }
    // }


    $(document).ready(function() {

        var defaultSelectedValue = $('#listWil option:first').val();

        var currentDate = new Date().toISOString().split('T')[0];

        $('#inputDate').val(currentDate);
        $('#listWil').val(defaultSelectedValue);
        handleAjaxRequest(defaultSelectedValue, currentDate);

        $('#listWil').on('change', function() {
            var selectedValue = $(this).val();
            handleAjaxRequest(selectedValue, currentDate);
        });

        $('#inputDate').on('change', function() {
            currentDate = $(this).val(); // Update currentDate when the date changes

            handleAjaxRequest($('#listWil').val(), currentDate);
        });

        $('#listLoc').on('change', function() {
            var selectedValue = $(this).val();

            handleListLocClick(selectedValue, currentDate);
        });
    });
</script>