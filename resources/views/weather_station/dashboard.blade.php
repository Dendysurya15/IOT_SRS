@include('layout.header')

<style>
    .selectCard:hover {
        transform: scale(1.01);
        box-shadow: 0 10px 20px rgba(0, 0, 0, .12), 0 4px 8px rgba(0, 0, 0, .06);
    }

    .selectCard {
        border-radius: 4px;
        background: #fff;
        box-shadow: 0 6px 10px rgba(0, 0, 0, .08), 0 0 6px rgba(0, 0, 0, .05);
        transition: .3s transform cubic-bezier(.155, 1.105, .295, 1.12), .3s box-shadow, .3s -webkit-transform cubic-bezier(.155, 1.105, .295, 1.12);
        cursor: pointer;
    }

    .pixelated {
        image-rendering: pixelated;
        -ms-interpolation-mode: nearest-neighbor;
    }
</style>

<div class="content-wrapper" style="background: white">
    <!-- //Content Header AWS 1-->

    <?php $lokasiSel = ''; ?>
    {{-- @foreach($aws as $value) --}}
    <section class="content-header">
        <div class="content-fluid">

        </div>
    </section>
    <!--Content Header AWS 1//-->

    <!-- // Main content AWS 1-->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 mb-3">
                    <div class="row">

                        <form class="col-md-6" action="" method="post">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md">
                                    <select name="lokasi" id="locList" class="form-control">
                                        {{-- <option selected disabled>Pilih Lokasi</option> --}}
                                        @foreach($listStation as $loc)
                                        <option value="{{ $loc->id }}">{{ $loc->loc }}</option>
                                        @endforeach
                                    </select>


                        </form>
                    </div>
                    {{-- <div class="col-md">
                        <form class="" action="{{ route('dashboard_ws') }}" method="get">
                    <input class="form-control" type="date" name="tgl" id="inputDate" onchange="this.form.submit()">
                    </form>

                </div> --}}
            </div>
        </div>
</div>
</div>
<div class="row">
    <!--//Suhu Ruangan Aws 1-->
    <div class="col-md-12">
        <div class="card">
            {{-- <div class="card-header"> --}}
            {{-- <h5>Cuaca terkini {{$date}} --}}
            {{-- untuk wilayah --}}
            {{-- <span id="locTitle"></span> --}}
            {{-- </h5> --}}
            {{-- </div> --}}
            <div class="card-body p-5 " style="background:white;">
                <div class="layer">
                    <div class="row no-gutters align-items-center">
                        <div class="col-1 mr-2">
                            @php

                            if($aktual != null){
                            $iconAktual = 'fa-solid fa-'.$aktual->icon . ' fa-4x';
                            }else{
                            $iconAktual = '-';
                            }
                            @endphp
                            <i class="{{$iconAktual}} '" style="color:#183153;"></i>
                        </div>
                        <div class="col-2">
                            <div style="font-size: 13px;margin-bottom:-10px">
                                <span id="locTitle" style="font-style: italic;font-weight: bold">Last Update : </span>
                                {{$aktual->date_format ?? '-'}}
                            </div>
                            <div class="" style="font-size: 45px" id="tempReal">
                            </div>
                            <div style="margin-top: -10px">
                                {{$aktual->titleIcon ?? 'Tidak ada data'}}
                            </div>
                        </div>
                        <div class="col">
                            Kelembaban
                            <br>
                            <i class="fa-solid fa-droplet" style="color:#183153"></i>
                            <span id="humReal"></span> %
                        </div>
                        <div class="col">
                            Curah Hujan
                            <br>
                            <i class="fas fa-water" style="color: #183153"></i>
                            <span id="chReal"></span> mm

                        </div>
                        <div class="col">
                            Arah Angin
                            <br>
                            <i class="fas fa-compass" style="color: #183153"></i>
                            <span id="wdReal"></span>

                        </div>
                        <div class="col">
                            Kecepatan Angin
                            <br>
                            <i class="fas fa-wind" style="color: #183153"></i>
                            <span id="wsReal"></span> m/s
                        </div>
                        <div class="col">
                            Indeks UV
                            <br>
                            <i class="fas fa-sun" style="color: #183153"></i>
                            <span id="uvReal"></span>

                        </div>
                    </div>

                    {{-- <div class="row mt-4">

                    </div> --}}
                </div>
            </div>
        </div>
    </div>
    <!--Suhu Ruangan//-->

</div>
<div class="card">
    <div class="card-header card-light">
        <h5>Ringkasan Temperatur Aktual dan Forecast dalam 24 jam</h5>
    </div>
    <div class="card-body pb-5">
        <div id="tempGraphAktualForecast"></div>
    </div>
</div>
<div class="card">
    <div class="card-header card-light">
        <h5>Ringkasan Curah Hujan Aktual dan Forecast dalam 24 jam</h5>
    </div>
    <div class="card-body pb-5">

        <div id="chAktualForecast"></div>



    </div>
</div>
<div class="card">
    <div class="card-header card-light">
        <h5>Ringkasan Kelembaban dan Temperatur Tanah selama 24 jam terakhir</h5>
    </div>
    <div class="card-body pb-5">
        <div id="ktAktualForecast"></div>
    </div>
</div>
<div class="mt-2 mb-3">
    <span>
        Perkiraan cuaca seminggu kedepan
    </span>
    <span class="float-right font-italic">
        {{-- <a href="{{ route('month_weather_forecast') }}"> Perkiraan cuaca bulanan ...</a> --}}
    </span>
</div>
<div class="row">
    @foreach ($forecasting as $key => $item)

    <div class="col-md">
        <div class="card card-light selectCard">
            <div class="card-header">
                <div class="card-title" id="{{$key}}">{{$key}}</div>
            </div>
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="hum">
                            <div class="mb-2">
                                <i class="fa-solid fa-water fa-fw" style="color: #183153"></i>
                                {{-- {{
                                $item['rain'] != 0 ? $item['rain'] : '-'
                                }} --}}
                                <span id="rain_{{$key}}"></span>
                                mm
                            </div>
                            <div class="mb-2">
                                <i class="fa-solid fa-temperature-three-quarters fa-fw" style="color: #183153"></i>
                                <span id="max_temp_{{$key}}"></span>
                                {{-- {{
                                $item['max_temp'] != 0 ? $item['max_temp'] : '-'
                                }} --}}
                                /
                                <span id="min_temp_{{$key}}"></span>
                                {{-- {{
                                $item['min_temp'] != 0 ? $item['min_temp'] : '-'
                                }} --}}
                                ºC
                            </div>
                            <i class="fa-solid fa-cloud-showers-heavy fa-fw" style="color: #183153"></i>
                            {{-- {{
                            $item['rain_hours'] != 0 ? $item['rain_hours'] : '-'
                            }} --}}
                            <span id="rain_hours_{{$key}}"></span>
                            Jam
                        </div>
                    </div>
                    <div class="col-auto">
                        {{-- @php

                        $iconPred = 'fa-solid fa-'.$item['icon']. ' fa-2x';
                        @endphp --}}
                        <span id="icon_{{$key}}"></span>
                        {{-- <i class="{{$iconPred}}" style="color: #183153"></i> --}}
                        {{-- @if ($key == 0)
                        <br>
                        <i id="s_hum_in1" class="fa-solid fa-droplet"></i>
                        {{
                        $item['hum_real'] != 0 ? $item['hum_real'] : '-'
                        }} %
                        @endif --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
<p>
    <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
        Detail perkiraan cuaca
    </button>
</p>
<div class="collapse" id="collapseExample">
    <div class="row">
        @foreach ($arrPagiMalam as $key => $item)
        <div class="col-md">
            <div class="">
                <div class="card-header">
                    <div class="card-title">
                        <span id="div_hari_{{$key}}"></span>
                    </div>
                </div>
                <div style="background:white;border-radius:5px;height:340px;box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;">
                    @foreach ($item as $data)

                    <div style="height: 170px;">
                        <div id="textbox">
                            <p class="alignleft" style="float:left;margin-top:15px;margin-left:25px">
                                <span style="font-size:13px">
                                    <span id="div_waktu_{{$data['waktu']}}_{{$key}}"></span> (
                                    <span id="div_jam_{{$data['waktu']}}_{{$key}}"></span> )</span> <br>
                                <span class="font-italic" style="color:#6C757D"><span id="div_title_{{$data['waktu']}}_{{$key}}"></span></span>
                            </p>
                            <p class="alignright" style="float:right;margin-top:25px;margin-right:15px;">
                                <span id="div_icon_{{$data['waktu']}}_{{$key}}"></span>
                            </p>
                        </div>
                        <div style="clear: both;"></div>
                        <div style="padding:9px;background:#F7F7F7;border-radius:5px">
                            <div class="row m-2" style="">
                                <div class="col-6" style="">
                                    <i class="fa-solid fa-water fa-sm fa-fw m-1" style="color:#183153;"></i>
                                    <span style="font-size:11px"> <span id="div_rain_{{$data['waktu']}}_{{$key}}"></span> mm</span>
                                </div>
                                <div class="col-6" style="">
                                    <i class="fa-solid fa-temperature-low fa-sm fa-fw m-1" style="color:#183153;"></i>

                                    <span style="font-size:11px"> <span id="div_temp_{{$data['waktu']}}_{{$key}}"></span> C</span>
                                </div>
                            </div>
                            <div class="row m-2" style="">
                                <div class="col-6" style="">
                                    <i class="fa-solid fa-cloud-sun-rain fa-sm fa-fw m-1" style="color:#183153;"></i>

                                    <span style="font-size:11px"> <span id="div_rp_{{$data['waktu']}}_{{$key}}"></span>
                                        % </span>
                                </div>
                                <div class="col-6" style="">
                                    <i class="fa-solid fa-wind fa-sm fa-fw m-1" style="color:#183153;"></i>

                                    <span style="font-size:11px"> <span id="div_ws_{{$data['waktu']}}_{{$key}}"></span>m/s</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    @endforeach



                </div>
            </div>

        </div>
        @endforeach
    </div>
</div>

<!--<div class="card">-->
<!--    <div class="card-header card-light">-->
<!--        <h5>Ringkasan Forecast 12 Jam kedepan dari <i>AccuWeather</i> </h5>-->
<!--    </div>-->
<!--    <div class="card-body pb-5">-->

<!--        <div id="forecast12"></div>-->



<!--    </div>-->
<!--</div>-->
<div class="mt-2 mb-3">
    {{-- <span>
        Ringkasan data per jam
    </span> --}}
</div>

<div class="row">
    {{-- <div class="col-2" style="border: 1px solid red">
        akdsfj
    </div>
    <div class="col-2" style="border: 1px solid red">
        akdsfj
    </div>
    <div class="col-2" style="border: 1px solid red">
        akdsfj
    </div> --}}
</div>
{{-- <div class="" style="border: 1px solid red">
    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" src=".../800x400?auto=yes&bg=777&fg=555&text=First slide" alt="First slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src=".../800x400?auto=yes&bg=666&fg=444&text=Second slide"
                    alt="Second slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src=".../800x400?auto=yes&bg=555&fg=333&text=Third slide" alt="Third slide">
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</div> --}}

{{-- <div class="col-md-4">
    <div class="card card-primary">
        <div class="card-header">
            <div class="card-title">Kelembaban Udara</div>
        </div>
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="hum">{{
                        $data[0]['hum_real'] ?? 0
                        }} %
</div>
</div>
<div class="col-auto">
    <i id="s_hum_in1" class="fas fa-thermometer-three-quarters fa-2x"></i>
</div>
</div>
</div>
</div>
</div>
<!--Kelembaban Ruangan-->

<!--//Kelembaban Ruangan Aws 1-->
<div class="col-md-4">
    <div class="card card-primary">
        <div class="card-header">
            <div class="card-title">Kecepatan Angin</div>
        </div>
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="wind_speed_real">{{
                        $data[0]['wind_speed_real'] ?? 0}}
                        m/s</div>
                </div>
                <div class="col-auto">
                    <i id="s_hum_in1" class="fas fa-wind fa-2x"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Kelembaban Ruangan-->

<!--//Kelembaban Ruangan Aws 1-->
<div class="col-md-4">
    <div class="card card-primary">
        <div class="card-header">
            <div class="card-title">Arah Angin</div>
        </div>
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="wind_chill_real">{{
                        $data[0]['wind_chill_real'] ?? 0 }}
                    </div>
                </div>
                <div class="col-auto">
                    <i id="s_hum_in1" class="fas fa-compass fa-2x "></i>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Kelembaban Ruangan-->

<!--//Curah Hujan Sekarang Aws 1-->
<div class="col-md-4">
    <div class="card card-primary">
        <div class="card-header">
            <div class="card-title">Curah Hujan</div>
        </div>
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="rain_fall_real">
                        <?php
                        // $curahHujan = $data[0]['rain_fall_real'] ?? 0;
                        ?>
                        mm
                    </div>
                </div>
                <div class="col-auto">
                    <i id="s_rain_rn1" class="fas fa-cloud-rain fa-2x "></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-md-4">
    <div class="card card-primary">
        <div class="card-header">
            <div class="card-title">Forecasting Curah Hujan</div>
        </div>
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="rain_forecast">
                        <?php
                        // $curahHujan = $data[0]['rain_forecast'] ?? 0;
                        ?>
                        mm
                    </div>
                </div>
                <div class="col-auto">
                    <i id="s_rain_rn1" class="fas fa-cloud-rain fa-2x "></i>
                </div>
            </div>
        </div>
    </div>
</div> --}}
<!--Curah Hujan Sekarang//-->

<!-- /.row -->
</div><!-- /.container-fluid -->
</section>
<!-- Main content AWS 1 //-->
{{-- @endforeach --}}



<!--locList Tambah Koment -->
</div>
@include('layout.footer')

<script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.9.4/lottie.min.js" integrity="sha512-ilxj730331yM7NbrJAICVJcRmPFErDqQhXJcn+PLbkXdE031JJbcK87Wt4VbAK+YY6/67L+N8p7KdzGoaRjsTg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- jQuery -->

<!-- Bootstrap 4 -->
<script src="{{ asset('/public/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('/public/plugins/chart.js/Chart.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('/public/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('/public/js/demo.js') }}"></script>

<script src="{{ asset('/public/js/loader.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
    $(document).ready(function() {
        // $( "#inputDate" ).datepicker( "option", "disabled", true );
        // $( "#locList" ).datepicker( "option", "disabled", true );

        var select2 = document.getElementById('locList');
        var defaultStation = $("#locList option:selected").val();

        getDataLoc(defaultStation)
        // });
    });

    $('#locList').change(function() {
        if ($(this).val() != '') {

            station = $(this).val();

            var _token = $('input[name="_token"]').val();
            // var e = document.getElementById("locList");
            // var loc = e.options[e.selectedIndex].text;

            getDataLoc(station)
        }
    });

    var arrHistoryData = <?php echo json_encode($arrHistoryData); ?>;
    var arrForecast12hour = <?php echo json_encode($arrForecast12hour); ?>;
    var arrNewForecast12 = <?php echo json_encode($arrForecastNew12hour); ?>;
    var arrOneDayForecast = <?php echo json_encode($arrOneDayForecast); ?>;
    var arrNewForecast12 = Object.entries(arrNewForecast12)
    var arrHistoryData = Object.entries(arrHistoryData)
    var arrForecast12hour = Object.entries(arrForecast12hour)
    var arrOneDayForecast = Object.entries(arrOneDayForecast)

    var categoriesHistoryHour = '['
    var rainHistoryHour = '['
    var tempHistoryHour = '['
    arrHistoryData.forEach(element => {
        categoriesHistoryHour += '"' + element[1]['jam'] + '",'
        rainHistoryHour += '"' + element[1]['rain'] + '",'
        tempHistoryHour += '"' + element[1]['temp'] + '",'
    });

    categoriesHistoryHour = categoriesHistoryHour.substring(0, categoriesHistoryHour.length - 1);
    rainHistoryHour = rainHistoryHour.substring(0, rainHistoryHour.length - 1);
    tempHistoryHour = tempHistoryHour.substring(0, tempHistoryHour.length - 1);
    categoriesHistoryHour += ']'
    rainHistoryHour += ']'
    tempHistoryHour += ']'

    categoriesHistoryHour = JSON.parse(categoriesHistoryHour)
    rainHistoryHour = JSON.parse(rainHistoryHour)
    tempHistoryHour = JSON.parse(tempHistoryHour)

    var categoriesForecastHour = '['
    var rainForecastHour = '['
    var tempForecastHour = '['
    arrForecast12hour.forEach(element => {
        categoriesForecastHour += '"' + element[1]['jam'] + '",'
        rainForecastHour += '"' + element[1]['rain'] + '",'
        tempForecastHour += '"' + element[1]['temp'] + '",'
    });

    categoriesForecastHour = categoriesForecastHour.substring(0, categoriesForecastHour.length - 1);
    rainForecastHour = rainForecastHour.substring(0, rainForecastHour.length - 1);
    tempForecastHour = tempForecastHour.substring(0, tempForecastHour.length - 1);
    categoriesForecastHour += ']'
    rainForecastHour += ']'
    tempForecastHour += ']'

    categoriesForecastHour = JSON.parse(categoriesForecastHour)
    rainForecastHour = JSON.parse(rainForecastHour)
    tempForecastHour = JSON.parse(tempForecastHour)


    var categoriesAll = '['
    var rainAll = '['
    var tempAll = '['
    arrNewForecast12.forEach(element => {
        categoriesAll += '"' + element[1]['jam'] + '",'
        rainAll += '"' + element[1]['rain'] + '",'
        tempAll += '"' + element[1]['temp'] + '",'
    });

    categoriesAll = categoriesAll.substring(0, categoriesAll.length - 1);
    rainAll = rainAll.substring(0, rainAll.length - 1);
    tempAll = tempAll.substring(0, tempAll.length - 1);
    categoriesAll += ']'
    rainAll += ']'
    tempAll += ']'

    var rainForecastOneDay = '['
    var tempForecastOneDay = '['
    arrOneDayForecast.forEach(element => {
        rainForecastOneDay += '"' + element[1]['rain'] + '",'
        tempForecastOneDay += '"' + element[1]['temp'] + '",'
    });

    categoriesAll = categoriesAll.substring(0, categoriesAll.length - 1);
    rainForecastOneDay = rainForecastOneDay.substring(0, rainForecastOneDay.length - 1);
    tempForecastOneDay = tempForecastOneDay.substring(0, tempForecastOneDay.length - 1);
    categoriesAll += ']'
    rainForecastOneDay += ']'
    tempForecastOneDay += ']'

    rainForecastOneDay = JSON.parse(rainForecastOneDay)
    tempForecastOneDay = JSON.parse(tempForecastOneDay)


    categoriesAll = JSON.parse(categoriesAll)

    rainAll = JSON.parse(rainAll)
    tempAll = JSON.parse(tempAll)

    var options = {
        series: [{
            name: 'Aktual Temperatur (°C)',
            data: tempHistoryHour
        }, {
            name: 'Forecast Temperatur (°C)',
            data: tempForecastOneDay
        }],
        chart: {
            height: 350,
            type: 'area'
        },
        dataLabels: {
            enabled: false
        },
        colors: ['#1565c0', '#b71c1c', '#9C27B0'],
        stroke: {
            curve: 'smooth'
        },
        xaxis: {
            type: 'string',
            categories: categoriesAll
            // ["2018-09-19T00:00:00.000Z", "2018-09-19T01:30:00.000Z", "2018-09-19T02:30:00.000Z",
            // "2018-09-19T03:30:00.000Z", "2018-09-19T04:30:00.000Z", "2018-09-19T05:30:00.000Z", "2018-09-19T06:30:00.000Z"]
        }
        // tooltip: {
        // x: {
        // format: 'dd/MM/yy HH:mm'
        // },
        // },
    };

    var chartTemp = new ApexCharts(document.querySelector("#tempGraphAktualForecast"), options);
    chartTemp.render();
    var options = {
        series: [{
            name: 'Aktual Curah Hujan (mm)',
            data: rainHistoryHour
        }, {
            name: 'Forecast Curah Hujan  (mm)',
            data: rainForecastOneDay
        }],
        chart: {
            height: 350,
            type: 'area'
        },
        dataLabels: {
            enabled: false
        },
        colors: ['#1565c0', '#b71c1c', '#9C27B0'],
        stroke: {
            curve: 'smooth'
        },
        xaxis: {
            type: 'string',
            categories: categoriesAll
            // ["2018-09-19T00:00:00.000Z", "2018-09-19T01:30:00.000Z", "2018-09-19T02:30:00.000Z",
            // "2018-09-19T03:30:00.000Z", "2018-09-19T04:30:00.000Z", "2018-09-19T05:30:00.000Z", "2018-09-19T06:30:00.000Z"]
        }
        // tooltip: {
        // x: {
        // format: 'dd/MM/yy HH:mm'
        // },
        // },
    };

    var chartCh = new ApexCharts(document.querySelector("#chAktualForecast"), options);
    chartCh.render();
    //   var indexDefault = 2;
    //   $('#locList').val(99)


    var arrHour = <?php echo json_encode($arrHour); ?>;
    var listHour = <?php echo json_encode($listHour); ?>;

    var arrNewHour = Object.entries(arrHour)

    var categoriesHour = '['
    listHour.forEach(element => {
        categoriesHour += '"' + element + '",'
    });

    categoriesHour = categoriesHour.substring(0, categoriesHour.length - 1);
    categoriesHour += ']'

    var temp = '['
    var hum = '['
    arrNewHour.forEach(element => {
        hum += '"' + element[1]['hum'] + '",'
        temp += '"' + element[1]['temp'] + '",'
    });

    hum = hum.substring(0, hum.length - 1);
    temp = temp.substring(0, temp.length - 1);
    hum += ']'
    temp += ']'

    var defStation = $("#locList option:selected").val();
    if (defStation == 1) {
        hum = [0, 0, 0, 0, 0]
        temp = [0, 0, 0, 0, 0]
    } else {
        hum = JSON.parse(hum)
        temp = JSON.parse(temp)
    }
    categoriesHour = JSON.parse(categoriesHour)

    var options = {
        series: [{
            name: 'Kelembaban',
            data: hum
        }, {
            name: 'Temperatur',
            data: temp
        }],
        chart: {
            height: 350,
            type: 'area'
        },
        dataLabels: {
            enabled: false
        },
        colors: ['#1565c0', '#b71c1c', '#9C27B0'],
        stroke: {
            curve: 'smooth'
        },
        xaxis: {
            type: 'string',
            categories: categoriesHour
            // ["2018-09-19T00:00:00.000Z", "2018-09-19T01:30:00.000Z", "2018-09-19T02:30:00.000Z",
            // "2018-09-19T03:30:00.000Z", "2018-09-19T04:30:00.000Z", "2018-09-19T05:30:00.000Z", "2018-09-19T06:30:00.000Z"]
        }
        // tooltip: {
        // x: {
        // format: 'dd/MM/yy HH:mm'
        // },
        // },
    };
    var chartKt = new ApexCharts(document.querySelector("#ktAktualForecast"), options);
    chartKt.render();

    function getDataLoc(locIndex) {

        value = locIndex;

        var _token = $('input[name="_token"]').val();
        const params = new URLSearchParams(window.location.search)
        var paramArr = [];
        for (const param of params) {
            paramArr = param
        }

        if (paramArr.length > 0) {
            date = paramArr[1]
        } else {
            date = new Date().toISOString().slice(0, 10)
        }

        $.ajax({
            url: "{{ route('getHistoryForecastDay') }}",
            method: "POST",
            data: {
                id_loc: value,
                _token: _token
            },
            success: function(result) {


                let tempDiv = document.getElementById('tempReal');
                let locTitleDiv = document.getElementById('locTitle');
                let humDiv = document.getElementById('humReal');
                let chDiv = document.getElementById('chReal');
                let wdDiv = document.getElementById('wdReal');
                let wsDiv = document.getElementById('wsReal');
                let uvDiv = document.getElementById('uvReal');

                arrResult = JSON.parse(result)

                // console.log(arrResult['historyForecast']);

                var arrResultHistory = Object.entries(arrResult['historyData'])
                var arrResultForecast = Object.entries(arrResult['historyForecast'])
                if (arrResult['arrHour'] != null) {
                    var arrResultSoil = Object.entries(arrResult['arrHour'])
                    var temperature = '['
                    var humidity = '['
                    arrResultSoil.forEach(element => {
                        humidity += '"' + element[1]['hum'] + '",'
                        temperature += '"' + element[1]['temp'] + '",'
                    });

                    humidity = humidity.substring(0, humidity.length - 1);
                    temperature = temperature.substring(0, temperature.length - 1);
                    humidity += ']'
                    temperature += ']'

                    humidity = JSON.parse(humidity)
                    temperature = JSON.parse(temperature)
                    chartKt.updateSeries([{
                        name: 'Kelembaban',
                        data: humidity
                    }, {
                        name: 'Temperature',
                        data: temperature
                    }])
                } else {
                    chartKt.updateSeries([{
                        name: 'Kelembaban',
                        data: [0, 0, 0, 0, 0]
                    }, {
                        name: 'Temperature',
                        data: [0, 0, 0, 0, 0]
                    }])
                }
                var arrAktual = arrResult['dataAktual']
                var arrPred = arrResult['dataPred']
                var arrPagiMalam = arrResult['dataPagiMalam']

                let node = document.createTextNode(arrAktual['temp_real']);

                tempDiv.innerHTML = arrAktual['temp_real'];
                locTitleDiv.innerHTML = arrAktual['loc'] + ', ';
                humDiv.innerHTML = arrAktual['hum_real'];
                chDiv.innerHTML = arrAktual['rain_fall_real'];

                wdVal = arrAktual['wind_direction_real']

                var wind_direction = '';

                if (wdVal == 'N') {
                    wind_direction = 'Utara';
                } else if (wdVal == 'WE') {
                    wind_direction = 'Timur Laut';
                } else if (wdVal == 'E') {
                    wind_direction = 'Timur';
                } else if (wdVal == 'SE') {
                    wind_direction = 'Tenggara';
                } else if (wdVal == 'S') {
                    wind_direction = 'Selatan';
                } else if (wdVal == 'SW') {
                    wind_direction = 'Barat Daya';
                } else if (wdVal == 'W') {
                    wind_direction = 'Barat';
                } else if (wdVal == 'NW') {
                    wind_direction = 'Barat Laut';
                } else {
                    wind_direction = wdVal;
                }

                wdDiv.innerHTML = wind_direction;
                wsDiv.innerHTML = arrAktual['wind_speed_real'];
                // uvDiv.innerHTML = arrAktual['uv_real'];

                uvVal = arrAktual['uv_real']


                uvTitle = ''
                if (uvVal >= 0 && uvVal < 3) {
                    $val = uvVal;
                    uvTitle = 'Low';
                } else if (uvVal >= 3 && uvVal < 6) {
                    $val = uvVal;
                    uvTitle = 'Moderate';
                } else if (uvVal >= 6 && uvVal < 8) {
                    $val = uvVal;
                    uvTitle = 'High';
                } else if (uvVal >= 8 && uvVal < 11) {
                    $val = uvVal;
                    uvTitle = 'Very high';
                } else if (uvVal >= 11) {
                    $val = uvVal;
                    uvTitle = 'Extreme';
                } else {
                    $val = uvVal;
                    uvTitle = '';
                }

                uvDiv.innerHTML = uvTitle + ' (' + uvVal + ')'


                //perkiraan cuaca seminggu kedepan
                var Prediksi = Object.entries(arrResult['dataPred'])


                Prediksi.forEach(element => {
                    let divTanggal = document.getElementById(element[0])
                    let divRain = document.getElementById('rain_' + element[0])
                    let divMaxTemp = document.getElementById('max_temp_' + element[0])
                    let divMinTemp = document.getElementById('min_temp_' + element[0])
                    let divHoursRain = document.getElementById('rain_hours_' + element[0])
                    let divIcon = document.getElementById('icon_' + element[0])

                    divTanggal.innerHTML = element[0]
                    divRain.innerHTML = element[1]['rain']
                    divMaxTemp.innerHTML = element[1]['max_temp']
                    divMinTemp.innerHTML = element[1]['min_temp']
                    divHoursRain.innerHTML = element[1]['rain_hours']
                    divIcon.innerHTML = `<i class="fa-solid fa-` + element[1]['icon'] + ` fa-2x"  style="color: #183153"></i>`
                });
                // end - perkiraan cuaca seminggu kedepan

                // detail perkiraan cuaca
                var PagiMalam = Object.entries(arrResult['dataPagiMalam'])

                PagiMalam.forEach(element => {

                    let divHari = document.getElementById('div_hari_' + element[0])
                    let divPagiWaktu = document.getElementById('div_waktu_Pagi_' + element[0])
                    let divMalamWaktu = document.getElementById('div_waktu_Malam_' + element[0])
                    let divPagiJam = document.getElementById('div_jam_Pagi_' + element[0])
                    let divMalamJam = document.getElementById('div_jam_Malam_' + element[0])
                    let divPagiRain = document.getElementById('div_rain_Pagi_' + element[0])
                    let divMalamRain = document.getElementById('div_rain_Malam_' + element[0])
                    let divPagiTemp = document.getElementById('div_temp_Pagi_' + element[0])
                    let divMalamTemp = document.getElementById('div_temp_Malam_' + element[0])
                    let divPagiRp = document.getElementById('div_rp_Pagi_' + element[0])
                    let divMalamRp = document.getElementById('div_rp_Malam_' + element[0])
                    let divPagiWs = document.getElementById('div_ws_Pagi_' + element[0])
                    let divMalamWs = document.getElementById('div_ws_Malam_' + element[0])
                    let divPagiTitle = document.getElementById('div_title_Pagi_' + element[0])
                    let divMalamTitle = document.getElementById('div_title_Malam_' + element[0])
                    let divPagiIcon = document.getElementById('div_icon_Pagi_' + element[0])
                    let divMalamIcon = document.getElementById('div_icon_Malam_' + element[0])


                    divHari.innerHTML = element[0]
                    divPagiWaktu.innerHTML = element[1]['Pagi']['waktu']
                    divMalamWaktu.innerHTML = element[1]['Malam']['waktu']
                    divPagiJam.innerHTML = element[1]['Pagi']['jam']
                    divMalamJam.innerHTML = element[1]['Malam']['jam']
                    divPagiRain.innerHTML = element[1]['Pagi']['rain']
                    divMalamRain.innerHTML = element[1]['Malam']['rain']
                    divPagiTemp.innerHTML = element[1]['Pagi']['temp']
                    divMalamTemp.innerHTML = element[1]['Malam']['temp']
                    divPagiRp.innerHTML = element[1]['Pagi']['rain_probability']
                    divMalamRp.innerHTML = element[1]['Malam']['rain_probability']
                    divPagiWs.innerHTML = element[1]['Pagi']['ws']
                    divMalamWs.innerHTML = element[1]['Malam']['ws']
                    divPagiTitle.innerHTML = element[1]['Pagi']['title']
                    divMalamTitle.innerHTML = element[1]['Malam']['title']
                    divPagiIcon.innerHTML = `<i class="fa-solid fa-` + element[1]['Pagi']['icon'] + ` fa-2xl"  style="color: #183153"></i>`
                    divMalamIcon.innerHTML = `<i class="fa-solid fa-` + element[1]['Malam']['icon'] + ` fa-2xl"  style="color: #183153"></i>`

                });
                // end - detail perkiraan cuaca

                var rainHistory = '['
                var tempHistory = '['
                var categoriesHistory = '['
                arrResultForecast.forEach(element => {
                    rainHistory += '"' + element[1]['rain'] + '",'
                    tempHistory += '"' + element[1]['temp'] + '",'
                    categoriesHistory += '"' + element[1]['jam'] + '",'
                });
                rainHistory = rainHistory.substring(0, rainHistory.length - 1);
                tempHistory = tempHistory.substring(0, tempHistory.length - 1);
                categoriesHistory = categoriesHistory.substring(0, categoriesHistory.length - 1);
                categoriesHistory += ']'
                rainHistory += ']'
                tempHistory += ']'

                rainHistory = JSON.parse(rainHistory)
                tempHistory = JSON.parse(tempHistory)
                categoriesHistory = JSON.parse(categoriesHistory)

                var rainForecast = '['
                var tempForecast = '['
                var categoriesForecast = '['
                arrResultHistory.forEach(element => {
                    rainForecast += '"' + element[1]['rain'] + '",'
                    tempForecast += '"' + element[1]['temp'] + '",'
                    categoriesForecast += '"' + element[1]['jam'] + '",'
                });
                rainForecast = rainForecast.substring(0, rainForecast.length - 1);
                tempForecast = tempForecast.substring(0, tempForecast.length - 1);
                categoriesForecast = categoriesForecast.substring(0, categoriesForecast.length - 1);
                categoriesForecast += ']'
                rainForecast += ']'
                tempForecast += ']'

                rainForecast = JSON.parse(rainForecast)
                tempForecast = JSON.parse(tempForecast)
                categoriesForecast = JSON.parse(categoriesForecast)

                chartTemp.updateSeries([{
                    name: 'Aktual Temperatur (°C)',
                    data: tempForecast
                }, {
                    name: 'Forecast Temperatur (°C)',
                    data: tempHistory
                }])
                chartCh.updateSeries([{
                    name: 'Aktual Curah Hujan (mm)',
                    data: rainHistory
                }, {
                    name: 'Forecast Temperatur (°C)',
                    data: rainForecast
                }])

                // if(result.length > 10){
                //     sliceResult = result.slice(1, -1);
                // const arrSlice = sliceResult.split(",");
                // const arrResult = []
                // for (let index = 0; index < arrSlice.length; index++) {
                //     const splitted = arrSlice[index].split(":")
                //     var estate = splitted[0].slice(1, -1);
                //     var valEst = splitted[1]
                //     arrResult.push([estate,valEst])
                // }
                // console.log(arrResult)
                // $textTemp = (arrResult[6][1] == 0 || arrResult[6][1] == '"0"') ? '-' : arrResult[6][1] + ' ºC';
                // $textHum = (arrResult[7][1] == 0 || arrResult[7][1] == '"0"') ? '-'  :arrResult[7][1] + ' %';
                // $textWC = (arrResult[5][1] == 0 || arrResult[5][1] == '"0"') ? '-' :arrResult[5][1] + ' m/s';
                // $textWS = (arrResult[3][1] == 0 || arrResult[3][1] == '"0"') ? '-' :arrResult[3][1] + ' mm';
                // $textRF = (arrResult[8][1] == 0 || arrResult[8][1] == '"0"') ? '-' :arrResult[8][1] + ' mm';
                // $textRFo = (arrResult[9][1] == 0 || arrResult[9][1] == '"0"') ? '-' :  parseFloat(arrResult[9][1]).toFixed(2) + ' mm';
                // }else{
                // $textTemp = '-';
                // $textHum = '-';
                // $textWC = '-';
                // $textWS = '-';
                // $textRF = '-';
                // $textRFo = '-';
                // }

                // document.getElementById('locTitle').innerHTML = loc + ", ";
                // document.getElementById('temp').innerHTML = $textTemp ;
                // document.getElementById('hum').innerHTML = $textHum ;
                // document.getElementById('wind_chill_real').innerHTML = $textWC ;
                // document.getElementById('wind_speed_real').innerHTML = $textWS ;
                // document.getElementById('rain_fall_real').innerHTML = $textRF ;
                // document.getElementById('rain_forecast').innerHTML = $textRFo ;

            }
        })
    }
</script>