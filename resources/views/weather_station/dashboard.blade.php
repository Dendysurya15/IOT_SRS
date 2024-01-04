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
                <div class="col-lg-3 order-lg-1 order-sm-2 order-2">
                    <div class="col-12">
                        <div class="card" style="height:550px;border-radius: 20px;">
                            <div class="card-body">

                                <div style="width: 100%;"><span id="tanggal_update">Jan 2, 08:02</span> -
                                    Weather Report</div>
                                <div class="row align-items-center" style="height:230px;">
                                    <div class="col-6 text-center">
                                        <img src="{{ asset('img/sunny.png') }}" alt="Sunny Day Image"
                                            style="height: 140px" class="img-fluid">
                                    </div>
                                    <div class="col-6">
                                        <table class="table" style="">
                                            <tr>
                                                <td style="height: 80px;border-top:1px solid white" colspan="2">
                                                    <div class="col-12"
                                                        style="font-size:15px;font-weight:600;border-bottom:1px solid white;">
                                                        Berawan
                                                    </div>
                                                    <div class="col-12"
                                                        style="font-size:55px;font-weight: bold;margin-top:-5px;margin-bottom:-15px">
                                                        20°C
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="text-center" style="font-size: 22px">
                                                <td style="height: 20px;border-right:1px solid #E5E4E2;border-top:1px solid white;width: 93px; max-width: 93px; min-width: 93px;"
                                                    class="align-middle">68°F</td>
                                                <td class="align-middle" style="border-top:1px solid white">16°R</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <table class="table">
                                    <tr>
                                        <td style="width: 50px; max-width: 50px; min-width: 50px; height: 70px;border:1px solid white;border-right:1px solid #E5E4E2"
                                            class="align-middle">


                                            <div class="d-flex justify-content-center align-items-center">
                                                <div style="width: 100px;" class="text-center">
                                                    <img src="{{ asset('img/sun.png') }}" alt="Sunny Day Image"
                                                        style="height: 65px" class="img-fluid">
                                                </div>
                                                <div style="width: 100px;">
                                                    <div class="text-left" style="font-weight: 500">Sedang (4)</div>
                                                    <div class="text-left" style="color: #B6BBC4;font-size:13px">
                                                        Indeks UV</div>
                                                </div>
                                            </div>




                                        </td>
                                        <td style="width: 50px; max-width: 50px; min-width: 50px; height: 70px;border:1px solid white;border-right:1px solid #E5E4E2"
                                            class="align-middle">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <div style="width: 100px;" class="text-center">
                                                    <img src="{{ asset('img/humidity.png') }}" alt="Sunny Day Image"
                                                        style="height: 50px" class="img-fluid">
                                                </div>
                                                <div style="width: 100px;">
                                                    <div class="text-left" id="humReal">77%</div>
                                                    <div class="text-left" id style="color: #B6BBC4;font-size:13px">
                                                        Kelembaban</div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 50px; max-width: 50px; min-width: 50px; height: 70px; border:1px solid white;border-right:1px solid #E5E4E2"
                                            class="align-middle">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <div style="width: 100px;" class="text-center">
                                                    <img src="{{ asset('img/rain.png') }}" alt="Sunny Day Image"
                                                        style="height: 55px" class="img-fluid">
                                                </div>
                                                <div style="width: 100px;">
                                                    <div class="text-left">0 mm</div>
                                                    <div class="text-left" style="color: #B6BBC4;font-size:13px">Curah
                                                        Hujan</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="width: 50px; max-width: 50px; min-width: 50px; height: 70px;border:1px solid white;border-right:1px solid #E5E4E2"
                                            class="align-middle">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <div style="width: 100px;" class="text-center">
                                                    <img src="{{ asset('img/wind_speed.png') }}" alt="Sunny Day Image"
                                                        style="height: 50px" class="img-fluid">
                                                </div>
                                                <div style="width: 100px;">
                                                    <div class="text-left">196 km/jam</div>
                                                    <div class="text-left" style="color: #B6BBC4;font-size:13px">
                                                        Kec. Angin</div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="height: 70px;" colspan="2">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <div style="width: 130px;" class="text-center">
                                                    <img src="{{ asset('img/winddir.png') }}" alt="Sunny Day Image"
                                                        style="height: 50px" class="img-fluid">
                                                </div>
                                                <div style="width: 130px;">
                                                    <div class="text-left">Barat Daya Selatan</div>
                                                    <div class="text-left" style="color: #B6BBC4;font-size:13px">
                                                        Arah Angin</div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>




                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="list-group">
                            <button type="button"
                                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                Lokasi
                                <span class="ml-auto"> <img src="{{ asset('img/location.png') }}" alt="Sunny Day Image"
                                        style="height: 25px" class="img-fluid"></span>
                            </button>
                        </div>
                        <br>
                        @php
                        $inc = 0;
                        @endphp
                        @foreach($listStation as $loc)
                        <div class="list-group mb-1">

                            <button type="button"
                                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                {{ $loc->loc }}
                                <span class="ml-auto">20%</span>
                            </button>

                        </div>
                        @php
                        $inc++;

                        if ($inc ==3) { break; } @endphp @endforeach
                    </div>
                </div>
                <div class="col-lg-9  col-sm-12  order-lg-2 order-sm-1 order-1">
                    <div>
                        <div class="float-lg-right">
                            <select name="lokasi" id="locList" class="form-control">
                                @foreach($listStation as $loc)
                                <option value="{{ $loc->id }}">{{ $loc->loc }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="float-lg-left">
                            <h2>Dashboard AWS</h2>
                            <p>Informasi terkait kebutuhan data-data cuaca saat ini</p>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-lg-12 order-3">
                            <div class="card" style="height:350px;border-radius: 20px;">
                                <div class="card-body">
                                    <div id="tempGraphAktualForecast"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 order-3">
                            <div class="card" style="height:350px;border-radius: 20px;">
                                <div class="card-body">
                                    <div id="chAktualForecast "></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>




            {{-- <div class="float-lg-right">
                <div class="row">
                    <div class="col-8" style="border: 1px solid red;width:300px">
                        <select name="lokasi" id="locList" class="form-control">
                            @foreach($listStation as $loc)
                            <option value="{{ $loc->id }}">{{ $loc->loc }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-4">
                        aksdjfklajsdfkjaslk
                    </div>
                </div>
            </div> --}}
            {{-- <div class="row">
                <div class="col-lg-12" style="border: 1px solid red">

                    <div class="float-lg-right" style="border: 1px solid green">
                        <div class="col-12">
                            asdkfjasdlf
                        </div>
                    </div>


                </div>
            </div> --}}
            {{-- <div class="float-lg-right float-md-left">

                <div class="col-lg-3" style="border: 1px solid red">
                    <p>This content will float right on lg screens and above.</p>
                </div>

            </div> --}}



            {{-- <div class=" col-lg-2 d-flex flex-row-reverse" style="border: 1px solid red">
                <select name="lokasi" id="locList" class="form-control">
                    @foreach($listStation as $loc)
                    <option value="{{ $loc->id }}">{{ $loc->loc }}</option>
                    @endforeach
                </select>
            </div> --}}


            {{-- <div class="row">
                <div class="col-lg-6 mb-3">
                    <div class="row">

                        <form class="col-md-6" action="" method="post">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md">
                                    <select name="lokasi" id="locList" class="form-control">
                                        @foreach($listStation as $loc)
                                        <option value="{{ $loc->id }}">{{ $loc->loc }}</option>
                                        @endforeach

                                    </select>


                        </form>
                    </div>

                </div>
            </div> --}}
        </div>
</div>
{{-- <div class="row" style="border: 1px solid red">
    <!--//Suhu Ruangan Aws 1-->
    <div class="col-md-12">
        <div class="card">
            <div class="card-body p-5 " style="background:white;">
                <div class="layer">
                    <div class="row no-gutters align-items-center">
                        <div class="col-1 mr-2">

                            <i id="iconweather" class="fa-solid" style="color:#183153; font-size: 50px;"></i>

                        </div>
                        <div class="col-2">
                            <div style="font-size: 13px;margin-bottom:-10px">
                                <span id="locTitle" style="font-style: italic;font-weight: bold">Last Update :
                                </span>

                            </div>
                            <div class="" style="font-size: 15px;margin-top:10px">
                                <span id="tempReal" style="font-style: italic;font-weight: bold"></span>
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
                            <span id="wdReal" style="font-size: 13px"></span>

                        </div>
                        <div class="col">
                            Kecepatan Angin
                            <br>
                            <i class="fas fa-wind" style="color: #183153"></i>
                            <span id="wsReal"></span> m/s
                        </div>
                        <div class="col ml-5">
                            Hembusan angin
                            <br>
                            <i class="fas fa-sun" style="color: #183153"></i>
                            <span id="wgReal"></span>
                        </div>
                        <div class="col ml-5">
                            Indeks UV
                            <br>
                            <i class="fas fa-sun" style="color: #183153"></i>
                            <span id="uvReal"></span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div> --}}
{{-- <div class="card">
    <div class="card-header card-light">
        <h5>Ringkasan Temperatur Aktual dalam 24 jam</h5>
    </div>
    <div class="card-body pb-5">
        <div id="tempGraphAktualForecast"></div>
    </div>
</div>
<div class="card">
    <div class="card-header card-light">
        <h5>Ringkasan Curah Hujan Aktual dalam 24 jam</h5>
    </div>
    <div class="card-body pb-5">

        <div id="chAktualForecast"></div>



    </div>
</div> --}}
<!-- 
<div class="card">
    <div class="card-header card-light">
        <h5>Ringkasan Curah Hujan Aktual selama 30 hari terakhir</h5>
    </div>
    <div class="card-body pb-5">
        <div id="chAktual30"></div>
    </div>
    <div class="card-body" style="margin-top: -70px" id="ketRainRate"></div>
</div> -->
<!-- <div class="mt-2 mb-3">
    <span>
        Perkiraan cuaca seminggu kedepan
    </span>
    <span class="float-right font-italic">
        {{-- <a href="{{ route('month_weather_forecast') }}"> Perkiraan cuaca bulanan ...</a> --}}
    </span>
</div> -->
<!-- <div class="row">
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

                                <span id="rain_{{$key}}"></span>
                                mm
                            </div>
                            <div class="mb-2">
                                <i class="fa-solid fa-temperature-three-quarters fa-fw" style="color: #183153"></i>
                                <span id="max_temp_{{$key}}"></span>

                                <span id="min_temp_{{$key}}"></span>
                                {{
                                $item['min_temp'] != 0 ? $item['min_temp'] : '-'
                                }}
                                ºC
                            </div>
                            <i class="fa-solid fa-cloud-showers-heavy fa-fw" style="color: #183153"></i>

                            <span id="rain_hours_{{$key}}"></span>
                            Jam
                        </div>
                    </div>
                    <div class="col-auto">
                        @php

                        $iconPred = 'fa-solid fa-'.$item['icon']. ' fa-2x';
                        @endphp
                        <span id="icon_{{$key}}"></span>
                        <i class="{{$iconPred}}" style="color: #183153"></i>
                        @if ($key == 0)
                        <br>
                        <i id="s_hum_in1" class="fa-solid fa-droplet"></i>
                        {{
                        $item['hum_real'] != 0 ? $item['hum_real'] : '-'
                        }} %
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div> -->
<!-- <p>
    <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
        Detail perkiraan cuaca
    </button>
</p> -->
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
                <div
                    style="background:white;border-radius:5px;height:340px;box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;">
                    @foreach ($item as $data)

                    <div style="height: 170px;">
                        <div id="textbox">
                            <p class="alignleft" style="float:left;margin-top:15px;margin-left:25px">
                                <span style="font-size:13px">
                                    <span id="div_waktu_{{$data['waktu']}}_{{$key}}"></span> (
                                    <span id="div_jam_{{$data['waktu']}}_{{$key}}"></span> )</span> <br>
                                <span class="font-italic" style="color:#6C757D"><span
                                        id="div_title_{{$data['waktu']}}_{{$key}}"></span></span>
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
                                    <span style="font-size:11px"> <span
                                            id="div_rain_{{$data['waktu']}}_{{$key}}"></span> mm</span>
                                </div>
                                <div class="col-6" style="">
                                    <i class="fa-solid fa-temperature-low fa-sm fa-fw m-1" style="color:#183153;"></i>

                                    <span style="font-size:11px"> <span
                                            id="div_temp_{{$data['waktu']}}_{{$key}}"></span> C</span>
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

                                    <span style="font-size:11px"> <span
                                            id="div_ws_{{$data['waktu']}}_{{$key}}"></span>m/s</span>
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
    $(document).ready(function() {
        var select2 = document.getElementById('locList');
        var defaultStation = $("#locList option:selected").val();


        

        getDataLoc(defaultStation)
        getDataRainRate(defaultStation)
    });

    $('#locList').change(function() {
        if ($(this).val() != '') {
            station = $(this).val();
            var _token = $('input[name="_token"]').val();
            getDataLoc(station)
        }
    });

    var arrHistoryData = <?php echo json_encode($arrHistoryData); ?>;
    var arrForecast12hour = <?php echo json_encode($arrForecast12hour); ?>;
    var arrNewForecast12 = <?php echo json_encode($arrForecastNew12hour); ?>;
    var arrOneDayForecast = <?php echo json_encode($arrOneDayForecast); ?>;
    var arrNewForecast12 = Object.entries(arrNewForecast12);
    var arrHistoryData = Object.entries(arrHistoryData);
    var arrForecast12hour = Object.entries(arrForecast12hour);
    var arrOneDayForecast = Object.entries(arrOneDayForecast);

    var categoriesHistoryHour = [];
    var rainHistoryHour = [];
    var tempHistoryHour = [];

    arrHistoryData.forEach(element => {
        categoriesHistoryHour.push(element[1]['jam']);
        rainHistoryHour.push(element[1]['rain']);
        tempHistoryHour.push(element[1]['temp']);
    });

    var categoriesJSON = JSON.stringify(categoriesHistoryHour);
    var rainJSON = JSON.stringify(rainHistoryHour);
    var tempJSON = JSON.stringify(tempHistoryHour);

    var categoriesForecastHour = [];
    var rainForecastHour = [];
    var tempForecastHour = [];

    arrForecast12hour.forEach(element => {
        categoriesForecastHour.push(element[1]['jam']);
        rainForecastHour.push(element[1]['rain']);
        tempForecastHour.push(element[1]['temp']);
    });

    var categoriesAll = categoriesHistoryHour.concat(categoriesForecastHour);
    var rainAll = rainHistoryHour.concat(rainForecastHour);
    var tempAll = tempHistoryHour.concat(tempForecastHour);

    var rainForecastOneDay = [];
    var tempForecastOneDay = [];

    arrOneDayForecast.forEach(element => {
        rainForecastOneDay.push(element[1]['rain']);
        tempForecastOneDay.push(element[1]['temp']);
    });

    categoriesAll = JSON.parse(JSON.stringify(categoriesAll));

    rainAll = JSON.parse(JSON.stringify(rainAll));
    tempAll = JSON.parse(JSON.stringify(tempAll));
    rainForecastOneDay = JSON.parse(JSON.stringify(rainForecastOneDay));
    tempForecastOneDay = JSON.parse(JSON.stringify(tempForecastOneDay));


    var options = {

        series: [{
            name: 'Aktual Temperatur (°C)',
            data: tempHistoryHour
        }, {
            name: 'Forecast Temperatur (°C)',
            data: tempAll
        }],
        chart: {
            background: '#ffffff',
            height: 300,
            type: 'area'
        },


        colors: [
            '#48abfc',
            '#00FF00',
            '#00FF00',
            '#00FF00',
            '#3063EC',
            '#3063EC',
            '#3063EC',
            '#3063EC',
            '#FF8D1A',
            '#FF8D1A',
            '#FF8D1A',
            '#FF8D1A',
            '#00ffff'
        ],

        stroke: {
            curve: 'smooth'
        },
        xaxis: {
            type: 'string',
            categories: categoriesAll
        }
    };

    var chartTemp = new ApexCharts(document.querySelector("#tempGraphAktualForecast"), options);
    chartTemp.render();

    var chartCh = new ApexCharts(document.querySelector("#chAktualForecast"), options);
    chartCh.render();


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
            method: "get",
            data: {
                id_loc: value,
                _token: _token
            },
            success: function(result) {



                arrResult = JSON.parse(result)

                // console.log(arrResult['historyForecast']);

                


                var arrAktual = arrResult['dataAktual']

                // console.log(arrAktual);

                // var iconElement = document.getElementById('iconweather');

                // // Replace the icon's class with the dynamically obtained class
                // iconElement.className = 'fa-solid ' + arrAktual['icon'];
                // var titleElement = document.getElementById('locTitle');

                // // Update the text content of the span element
                // titleElement.textContent = 'Last Update: ' + arrAktual['date_format'];


                // var tempReal = document.getElementById('tempReal');
                 //tempReal.textContent = arrAktual['titleIcon']
                 var humReal = document.getElementById('humReal');
                 humReal.textContent = arrAktual['hum_out']
                // var chReal = document.getElementById('chReal');
                // chReal.textContent = arrAktual['rain_rate']
                // var wdReal = document.getElementById('wdReal');
                // wdReal.textContent = arrAktual['windDirIndonesian']
                // var wsReal = document.getElementById('wsReal');
                // wsReal.textContent = arrAktual['winddir']
                // var wgReal = document.getElementById('wgReal');
                // wgReal.textContent = arrAktual['wind_gust']

                uvVal = arrAktual['uv'];

                let uvTitle = '';
                if (uvVal >= 0 && uvVal < 2) {
                    uvTitle = 'Rendah';
                } else if (uvVal >= 2 && uvVal < 5) {
                    uvTitle = 'Sedang';
                } else if (uvVal >= 5 && uvVal < 7) {
                    uvTitle = 'Tinggi';
                } else if (uvVal >= 7 && uvVal < 10) {
                    uvTitle = 'Sangat Tinggi';
                }

                // var uvReal = document.getElementById('uvReal');
                // uvReal.textContent = uvTitle + '(' + uvVal + ')'



                var arrPred = arrResult['dataPred']
                var arrPagiMalam = arrResult['dataPagiMalam']


                let node = document.createTextNode(arrAktual['temp_out']);


                var Prediksi = Object.entries(arrResult['dataPred'])


                chartTemp.updateOptions({
                    xaxis: {
                        categories: arrResult['keydata']
                    }
                });


                chartTemp.updateSeries([{
                    name: 'Temperatur (°C)',
                    data: arrResult['valdata']

                }])

                chartCh.updateOptions({
                    xaxis: {
                        categories: arrResult['keydata']
                    }
                });


                chartCh.updateSeries([{
                    name: 'Temperatur (°C)',
                    data: arrResult['rain']

                }])

            },
            error: function(xhr, status, error) {
                if (xhr.status == 404) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Data Not Found!',
                        text: 'The requested data was not found.'
                    });
                } else {
                    // For other errors
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Data Tidak Ditemukan'
                    });
                }
            }

        })
    }



    var arrHour = <?php echo json_encode($arrHour); ?>;
    var listHour = <?php echo json_encode($listHour); ?>;

    var arrNewHour = Object.entries(arrHour)

    humFirst = [0, 0]
    tempFirst = [0, 0]
    categoriesHourFirst = ['07:00', '08:00']


    var chartKt = new ApexCharts(document.querySelector("#ktAktualForecast"), options);
    chartKt.render();

    function getDataRainRate(locIndex) {
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: "{{ route('getHistoryRainRate') }}",
            method: "POST",
            data: {
                id_loc: locIndex,
                _token: _token
            },
            success: function(result) {
                var dates = [];
                var values1 = [];
                var values2 = [];

                var parseResult = JSON.parse(result)
                var dataChart1 = Object.entries(parseResult['dataChart1'])
                var dataChart2 = Object.entries(parseResult['dataChart2'])

                dataChart1.forEach(element => {
                    dates.push(element[0]);
                    values1.push(element[1]);
                });

                dataChart2.forEach(element => {
                    values2.push(element[1]);
                });

                var avgDaily = parseResult.avgDaily
                var sumMonth = parseResult.sumMonth.toFixed(2)

                // var ketRainRate = document.getElementById('ketRainRate');
                // ketRainRate.innerHTML = '<a style="font-size: 20px;">Rata-rata per hari : </a><a style="font-weight: bold; color: blue; font-size: 20px;">' + avgDaily + '</a><br><a style="font-size: 20px;">Total curah hujan dalam 30 hari : </a><a style="font-weight: bold; color: blue; font-size: 20px;">' + sumMonth + '</a>';

                // var options = {
                //     series: [{
                //         name: 'Curah Hujan',
                //         data: values2
                //     }, {
                //         name: 's/d Hari ini',
                //         data: values1
                //     }],
                //     chart: {
                //         height: 350,
                //         type: 'area'
                //     },
                //     dataLabels: {
                //         enabled: false
                //     },
                //     colors: ['#1565c0', '#b71c1c'],
                //     stroke: {
                //         curve: 'smooth'
                //     },
                //     xaxis: {
                //         type: 'string',
                //         categories: dates
                //     }
                // }

                // var chart = new ApexCharts(document.querySelector("#chAktual30"), options);
                // chart.render();
            }
        })
    }
</script>