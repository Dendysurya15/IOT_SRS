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

                        <form class="col-md-12" action="" method="post">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md">
                                    <select name="lokasi" id="locList" class="form-control">
                                        <option selected disabled>Pilih Lokasi</option>
                                        @foreach($aws_loc as $loc)
                                        <option value="{{ $loc['id'] }}" disabled>{{ $loc['loc'] }}</option>
                                        @endforeach
                                    </select>


                        </form>
                    </div>
                    <div class="col-md">
                        {{-- <form class="" action="{{ route('dashboard_ws') }}" method="get">
                            <input class="form-control" type="date" name="tgl" id="inputDate"
                                onchange="this.form.submit()">
                        </form> --}}

                    </div>
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
                            $iconAktual = 'fa-solid fa-'.$aktual->icon . ' fa-5x';
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
                            <div class="" style="font-size: 45px">{{
                                $aktual->temp_real ?? '-' }}
                                ºC
                            </div>
                            <div style="margin-top: -10px">
                                {{$aktual->titleIcon ?? 'Tidak ada data'}}
                            </div>
                        </div>
                        <div class="col">
                            Kelembaban
                            <br>
                            <i class="fa-solid fa-droplet" style="color:#183153"></i>
                            {{
                            $aktual->hum_real ?? '-'
                            }} %
                        </div>
                        <div class="col">
                            Curah Hujan
                            <br>
                            <i class="fas fa-water" style="color: #183153"></i>
                            {{
                            $aktual->rain_fall_real ?? '-'
                            }} mm

                        </div>
                        <div class="col">
                            Arah Angin
                            <br>
                            <i class="fas fa-compass" style="color: #183153"></i>
                            @php
                            if ($aktual != null) {
                            if($aktual->wind_direction_real == 'N'){
                            $wind_direction = 'Utara';
                            }
                            else if($aktual->wind_direction_real == 'WE'){
                            $wind_direction = 'Timur Laut';
                            }
                            else if($aktual->wind_direction_real == 'E'){
                            $wind_direction = 'Timur';
                            }
                            else if($aktual->wind_direction_real == 'SE'){
                            $wind_direction = 'Tenggara';
                            }
                            else if($aktual->wind_direction_real == 'S'){
                            $wind_direction = 'Selatan';
                            }
                            else if($aktual->wind_direction_real == 'SW'){
                            $wind_direction = 'Barat Daya';
                            }
                            else if($aktual->wind_direction_real == 'W'){
                            $wind_direction = 'Barat';
                            }
                            else if($aktual->wind_direction_real == 'NW'){
                            $wind_direction = 'Barat Laut';
                            }else{
                            $wind_direction = $aktual->wind_direction_real ?? '-';
                            }
                            }
                            @endphp
                            {{
                            $wind_direction ?? '-'
                            }}
                        </div>
                        <div class="col">
                            Kecepatan Angin
                            <br>
                            <i class="fas fa-wind" style="color: #183153"></i>
                            {{
                            $aktual->wind_speed_real ?? '-'
                            }} m/s
                        </div>
                        <div class="col">
                            Indeks UV
                            <br>
                            <i class="fas fa-sun" style="color: #183153"></i>

                            @php
                            if ($aktual != null) {
                            if($aktual->uv_real >= 0 && $aktual->uv_real <3) { $val=$aktual->uv_real;
                                $title = 'Low';
                                }
                                else if($aktual->uv_real >= 3 && $aktual->uv_real <6) { $val=$aktual->uv_real;
                                    $title = 'Moderate';
                                    }
                                    else if($aktual->uv_real >= 6 && $aktual->uv_real <8) { $val=$aktual->uv_real;
                                        $title = 'High';
                                        }
                                        else if($aktual->uv_real >= 8 && $aktual->uv_real <11) { $val=$aktual->uv_real;
                                            $title = 'Very high';
                                            }
                                            else if($aktual->uv_real >= 11 ){
                                            $val = $aktual->uv_real;
                                            $title = 'Extreme';
                                            }
                                            else{
                                            $val = $aktual->uv_real ?? '-';
                                            $title = '';
                                            }
                                            }

                                            @endphp

                                            {{
                                            $val ?? '-'
                                            }}
                                            ({{
                                            $title ?? '-'
                                            }})
                        </div>
                    </div>

                    {{-- <div class="row mt-4">

                    </div> --}}
                </div>
            </div>



        </div>

        <div class="card">
            <div class="card-header card-light">
                <h5>Ringkasan history aktual</h5>
            </div>
            <div class="card-body pb-5">

                <div id="test"></div>
                <div id="chartLast12Hour" class="" style="height: 400px">
                </div>
                {{-- <div style="display: flex;
                justify-content: center;">
                    <div class="row " style="margin-top:-40px;width:100%;"> --}}
                        {{-- @foreach ($arrHistoryData as $item) --}}
                        {{-- <div class="col" style="border: 1px solid red">
                            @php

                            if($item['icon'] != null){
                            $iconAktual = 'fa-solid fa-'.$item['icon'] ;
                            }else{
                            $iconAktual = '-';
                            }
                            @endphp
                            <i class="{{$iconAktual}} '" style="color:#183153;"></i>
                        </div> --}}
                        {{-- @endforeach --}}

                        {{-- <div class="col" style="border: 1px solid red">skdjf</div>
                        <div class="col" style="border: 1px solid red">skdjf</div>
                        <div class="col" style="border: 1px solid red">skdjf</div>
                        <div class="col" style="border: 1px solid red">skdjf</div>
                        <div class="col" style="border: 1px solid red">skdjf</div>
                        <div class="col" style="border: 1px solid red">skdjf</div>
                        <div class="col" style="border: 1px solid red">skdjf</div>
                        <div class="col" style="border: 1px solid red">skdjf</div>
                        <div class="col" style="border: 1px solid red">skdjf</div>
                        <div class="col" style="border: 1px solid red">skdjf</div> --}}
                        {{--
                    </div>
                </div> --}}


                <div style="display: flex;
                justify-content: center;margin-top:-50px">
                    <div class="row " style="width:97%">
                        @foreach ($arrHistoryData as $item)
                        @php

                        if($item['icon'] != null){
                        $iconAktual = 'fa-solid fa-'.$item['icon'] ;
                        }else{
                        $iconAktual = '-';
                        }
                        @endphp
                        @if ($item['counter'] != 12)

                        <div class="col "> <i class="{{$iconAktual}} '"></i></div>
                        @endif
                        @endforeach
                        {{-- <div class="col-1" style="border: 1px solid red">asdf</div>
                        <div class="col-1" style="border: 1px solid red">asdf</div>
                        <div class="col-1" style="border: 1px solid red">asdf</div>
                        <div class="col-1" style="border: 1px solid red">asdf</div>
                        <div class="col-1" style="border: 1px solid red">asdf</div>
                        <div class="col-1" style="border: 1px solid red">asdf</div>
                        <div class="col-1" style="border: 1px solid red">asdf</div>
                        <div class="col-1" style="border: 1px solid red">asdf</div>
                        <div class="col-1" style="border: 1px solid red">asdf</div>
                        <div class="col-1" style="border: 1px solid red">asdf</div>
                        <div class="col-1" style="border: 1px solid red">asdf</div> --}}
                        {{-- <div style="border: 1px solid red;width:141px">
                            askdf
                        </div>
                        <div style="border: 1px solid red;width:141px">
                            askdf
                        </div>
                        <div style="border: 1px solid red;width:141px">
                            askdf
                        </div>
                        <div style="border: 1px solid red;width:141px">
                            askdf
                        </div>
                        <div style="border: 1px solid red;width:141px">
                            askdf
                        </div>
                        <div style="border: 1px solid red;width:141px">
                            askdf
                        </div>
                        <div style="border: 1px solid red;width:141px">
                            askdf
                        </div>
                        <div style="border: 1px solid red;width:141px">
                            askdf
                        </div>
                        <div style="border: 1px solid red;width:141px">
                            askdf
                        </div>
                        <div style="border: 1px solid red;width:141px">
                            askdf
                        </div>
                        <div style="border: 1px solid red;width:141px">
                            askdf
                        </div>
                        <div style="border: 1px solid red;width:141px">
                            askdf
                        </div> --}}
                    </div>
                </div>


            </div>
        </div>

    </div>
</div>
<!--Suhu Ruangan//-->

</div>
<div class=" mt-2 mb-3">
    <span>
        Perkiraan cuaca beberapa hari kedepan
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
                <div class="card-title">{{$key}}</div>
            </div>
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="hum">
                            <div class="mb-2">
                                <i class="fa-solid fa-water fa-fw" style="color: #183153"></i> {{
                                $item['rain'] != 0 ? $item['rain'] : '-'
                                }} mm
                            </div>
                            <div class="mb-2">
                                <i class="fa-solid fa-temperature-three-quarters fa-fw" style="color: #183153"></i>
                                {{
                                $item['max_temp'] != 0 ? $item['max_temp'] : '-'
                                }} / {{
                                $item['min_temp'] != 0 ? $item['min_temp'] : '-'
                                }} ºC
                            </div>
                            <i class="fa-solid fa-cloud-showers-heavy fa-fw" style="color: #183153"></i>
                            {{
                            $item['rain_hours'] != 0 ? $item['rain_hours'] : '-'
                            }} Jam
                        </div>
                    </div>
                    <div class="col-auto">
                        @php

                        $iconPred = 'fa-solid fa-'.$item['icon']. ' fa-2x';
                        @endphp
                        <i class="{{$iconPred}}" style="color: #183153"></i>
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
    <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample"
        aria-expanded="false" aria-controls="collapseExample">
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
                        {{$key}}
                    </div>
                </div>
                <div
                    style="background:white;border-radius:5px;height:340px;box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;">
                    @foreach ($item as $data)

                    <div style="height: 170px;">
                        <div id="textbox">
                            <p class="alignleft" style="float:left;margin-top:15px;margin-left:25px">
                                <span style="font-size:14px">
                                    {{$data['waktu']}} ( {{$data['jam']}} )</span> <br>
                                <span class="font-italic" style="color:#6C757D">{{$data['title']}}</span>
                            </p>
                            <p class="alignright" style="float:right;margin-top:25px;margin-right:15px;"> <i
                                    class="fa-solid fa-{{$data['icon']}} fa-2xl" style="color:#183153;"></i>
                            </p>
                        </div>
                        <div style="clear: both;"></div>
                        <div style="padding:9px;background:#F7F7F7;border-radius:5px">
                            <div class="row m-2" style="">
                                <div class="col-6" style="">
                                    <i class="fa-solid fa-water fa-sm fa-fw m-1" style="color:#183153;"></i>
                                    <span style="font-size:13px"> {{$data['rain']}} mm</span>
                                </div>
                                <div class="col-6" style="">
                                    <i class="fa-solid fa-temperature-low fa-sm fa-fw m-1" style="color:#183153;"></i>

                                    <span style="font-size:13px"> {{$data['temp']}} C</span>
                                </div>
                            </div>
                            <div class="row m-2" style="">
                                <div class="col-6" style="">
                                    <i class="fa-solid fa-cloud-sun-rain fa-sm fa-fw m-1" style="color:#183153;"></i>

                                    <span style="font-size:13px"> Persentase
                                        {{$data['rain_probability']}} % </span>
                                </div>
                                <div class="col-6" style="">
                                    <i class="fa-solid fa-wind fa-sm fa-fw m-1" style="color:#183153;"></i>

                                    <span style="font-size:13px"> {{$data['winddir']}}
                                        {{$data['ws']}}m/s</span>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.9.4/lottie.min.js"
    integrity="sha512-ilxj730331yM7NbrJAICVJcRmPFErDqQhXJcn+PLbkXdE031JJbcK87Wt4VbAK+YY6/67L+N8p7KdzGoaRjsTg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
    $(document).ready(function(){
    $( "#inputDate" ).datepicker( "option", "disabled", true );
    $( "#locList" ).datepicker( "option", "disabled", true );
    });

    var options = {
          series: [{
          data: [1269,
1288,
1562,
1562,
1655,
1635,
1124,
1274,
1434,
 ]
        }],
          chart: {
          type: 'bar',
          height: 350
        },
        plotOptions: {
          bar: {
            borderRadius: 4,
            horizontal: false,
          }
        },
        dataLabels: {
          enabled: true
        },
        colors:['#F44336', '#E91E63', '#9C27B0', '#9C27B0', '#9C27B0', '#9C27B0', '#9C27B0', '#9C27B0', '#9C27B0'],
        xaxis: {
          categories: ['SLM', 'SYM', 'SGM', 'SKM', 'NBM', 'MLM', 'MKM',
            'SCM', 'KTM'
          ],
        }
        };

var chart = new ApexCharts(document.querySelector("#test"), options);

chart.render();
    //   var indexDefault = 2;
    //   $('#locList').val(99)
    //   let dropdownList = document.getElementById('locList');
    //   let selectedOption = dropdownList.options[indexDefault];
    //   var idws = selectedOption.value;
    //   var loc = selectedOption.text;
    //   getDataLoc(idws,loc)
    // });

    // $('#locList').change(function(){
    // if($(this).val() != '')
    // {
    // var e = document.getElementById("locList");
    // var loc = e.options[e.selectedIndex].text;

    // getDataLoc($('#locList'),loc)
    // }
    // });

    // function getDataLoc(locIndex, loc){
    //     var status = 0 // ketika ada klik id yang di fetch
    // var value = ''
    // try {
    //     value = locIndex.val();   
    // }
    // catch(err) {
    //     var status = 1 // ketika tidak ada klik dan nilai RDE
    // } 

    // if(status == 1){
    //     value = locIndex
    // }      

    // var _token = $('input[name="_token"]').val();
    // const params = new URLSearchParams(window.location.search)
    // var paramArr = [];
    // for (const param of  params) {
    //     paramArr = param
    // }

    // if(paramArr.length > 0){
    //     date = paramArr[1]
    // }else{
    //     date = new Date().toISOString().slice(0, 10)
    // }

    // $.ajax({
    // url:"{{ route('getDataDashboard') }}",
    // method:"POST",
    // data:{ id_loc:value, _token:_token, tgl:date},
    // success:function(result)
    // {
    //     if(result.length > 10){
    //         sliceResult = result.slice(1, -1);
    //     const arrSlice = sliceResult.split(",");
    //     const arrResult = []
    //     for (let index = 0; index < arrSlice.length; index++) {
    //         const splitted = arrSlice[index].split(":")
    //         var estate = splitted[0].slice(1, -1);
    //         var valEst = splitted[1]
    //         arrResult.push([estate,valEst])
    //     }
    //     console.log(arrResult)
    //     $textTemp = (arrResult[6][1] == 0 || arrResult[6][1] == '"0"') ? '-' : arrResult[6][1] + ' ºC';
    //     $textHum = (arrResult[7][1] == 0 || arrResult[7][1] == '"0"') ? '-'  :arrResult[7][1] + ' %';
    //     $textWC = (arrResult[5][1] == 0 || arrResult[5][1] == '"0"') ? '-' :arrResult[5][1] + ' m/s';
    //     $textWS = (arrResult[3][1] == 0 || arrResult[3][1] == '"0"') ? '-' :arrResult[3][1] + ' mm';
    //     $textRF = (arrResult[8][1] == 0 || arrResult[8][1] == '"0"') ? '-' :arrResult[8][1] + ' mm';
    //     $textRFo = (arrResult[9][1] == 0 || arrResult[9][1] == '"0"') ? '-' :  parseFloat(arrResult[9][1]).toFixed(2) + ' mm';
    //     }else{
    //     $textTemp = '-';
    //     $textHum = '-';
    //     $textWC = '-';
    //     $textWS = '-';
    //     $textRF = '-';
    //     $textRFo = '-';
    //     }
        
    //     document.getElementById('locTitle').innerHTML = loc + ", ";
    //     document.getElementById('temp').innerHTML = $textTemp ;
    //     document.getElementById('hum').innerHTML = $textHum ;
    //     document.getElementById('wind_chill_real').innerHTML = $textWC ;
    //     document.getElementById('wind_speed_real').innerHTML = $textWS ;
    //     document.getElementById('rain_fall_real').innerHTML = $textRF ;
    //     document.getElementById('rain_forecast').innerHTML = $textRFo ;

    // }
    // })
    // }
    google.charts.load('current', {'packages':['corechart']});

    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {  
    
    var plot_ch = '<?php echo $arrlogLast12hour['plot1']; ?>';
    var plot_temp = '<?php echo $arrlogLast12hour['plot2']; ?>';
   
    var dataLog12jamterakhir = new google.visualization.DataTable();
    dataLog12jamterakhir.addColumn('string', 'Name');
    dataLog12jamterakhir.addColumn('number', plot_ch);    
    dataLog12jamterakhir.addColumn({type:'string', role:'style'});
    dataLog12jamterakhir.addColumn({type:'number', role:'annotation'});   
    dataLog12jamterakhir.addColumn('number', plot_temp);
    dataLog12jamterakhir.addColumn({type:'string', role:'style'});
    dataLog12jamterakhir.addColumn({type:'number', role:'annotation'});
    dataLog12jamterakhir.addRows([
      <?php echo $arrlogLast12hour['data']; ?>
    ]);

    var optionlog12jamterakhirs = {
        chartArea: {
            width: '97%'
        },
        annotations: {
    textStyle: {
      fontName: 'Times-Roman',
      fontSize: 15,
      bold: true,
    //   italic: true,
      // The color of the text.
      color: '#871b47',
      // The color of the text outline.
      // The transparency of the text.
      opacity: 0.8
    }
  },
        theme: 'material',
        colors:[ '#6B728E','#6B728E'],
        legend: { position: 'none',
        textStyle: {fontSize: 15}},
        lineWidth: 2,
        'tooltip' : {
  trigger: 'none'
},
        vAxis: {
            baselineColor: '#fff',
         gridlineColor: '#fff',
      textPosition: 'none',
    //   maxValue: 100,
    //   minValue: -100,
    //   gridlines: { interval: 0}
    },
        // height:400,
    };

    var loglast12jam = new google.visualization.AreaChart(document.getElementById('chartLast12Hour'));
    loglast12jam.draw(dataLog12jamterakhir,optionlog12jamterakhirs);

  }
</script>