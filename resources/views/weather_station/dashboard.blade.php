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
        p image-rendering: pixelated;
        -ms-interpolation-mode: nearest-neighbor;
    }


    @media (min-width: 1200px) and (max-width: 1300px) {
        #titleCuaca {
            font-size: 16px;
        }

        #tempReal {
            font-size: 25px;
        }

        #celToFah {
            font-size: 14px;
        }

        #celToRea {
            font-size: 14px;
        }

        #imageId {

            height: 180px;
        }

        #divUv {
            width: 100px;
            font-size: 11px;
        }

        #tdUV {
            width: 25px;
        }

        #tdUV img {
            width: 45px;
        }


        #divKelembaban {
            width: 100px;
            font-size: 11px;
        }


        #tdKelembaban {
            width: 25px;
        }

        #tdKelembaban img {
            width: 45px;
        }


        #divHujan {
            width: 100px;
            font-size: 11px;
        }


        #tdHujan {
            width: 25px;
        }

        #tdHujan img {
            width: 45px;
            height: 40px;
        }

        #divKecAngin {
            width: 100px;
            font-size: 11px;
        }


        #tdKecAngin {
            width: 25px;
        }

        #tdKecAngin img {
            width: 40px;
            height: 30px;
        }

        #divArahAngin {
            width: 100px;
            font-size: 11px;
        }


        #tdArahAngin {
            width: 25px;
        }

        #tdArahAngin img {
            width: 40px;
            height: 30px;
        }

        #cardMain {
            height: 450px;
        }
    }

    @media (min-width: 1300px) and (max-width: 1650px) {
        #titleCuaca {
            font-size: 18px;
        }

        #tempReal {
            font-size: 30px;
        }

        #celToFah {
            font-size: 18px;
        }

        #celToRea {
            font-size: 18px;
        }

        #imageId {

            height: 180px;
        }

        #divUv {
            width: 100px;
            font-size: 11px;
        }

        #tdUV {
            width: 25px;
        }

        #tdUV img {
            width: 45px;
        }


        #divKelembaban {
            width: 100px;
            font-size: 11px;
        }


        #tdKelembaban {
            width: 25px;
        }

        #tdKelembaban img {
            width: 45px;
        }


        #divHujan {
            width: 100px;
            font-size: 11px;
        }

        #tdHujan {
            width: 25px;
        }

        #tdHujan img {
            width: 45px;
            height: 40px;
        }

        #divKecAngin {
            width: 100px;
            font-size: 11px;
        }


        #tdKecAngin {
            width: 25px;
        }

        #tdKecAngin img {
            width: 40px;
            height: 30px;
        }

        #divArahAngin {
            width: 100px;
            font-size: 11px;
        }


        #tdArahAngin {
            width: 25px;
        }

        #tdArahAngin img {
            width: 40px;
            height: 30px;
        }

        #cardMain {
            height: 450px;
        }
    }

    @media (min-width: 1650px) and (max-width: 1800px) {
        #titleCuaca {
            font-size: 22px;
        }

        #tempReal {
            font-size: 40px;
        }

        #celToFah {
            font-size: 21px;
        }

        #celToRea {
            font-size: 21px;
        }

        #imageId {

            height: 180px;
        }

        #divUv {
            width: 100px;
            font-size: 11px;
        }

        #tdUV {
            width: 25px;
        }

        #tdUV img {
            width: 45px;
        }


        #divKelembaban {
            width: 100px;
            font-size: 11px;
        }


        #tdKelembaban {
            width: 25px;
        }

        #tdKelembaban img {
            width: 45px;
        }


        #divHujan {
            width: 100px;
            font-size: 11px;
        }


        #tdHujan {
            width: 25px;
        }

        #tdHujan img {
            width: 45px;
            height: 40px;
        }

        #divKecAngin {
            width: 100px;
            font-size: 11px;
        }


        #tdKecAngin {
            width: 25px;
        }

        #tdKecAngin img {
            width: 40px;
            height: 30px;
        }

        #divArahAngin {
            width: 100px;
            font-size: 11px;
        }

        #tdArahAngin {
            width: 25px;
        }

        #tdArahAngin img {
            width: 40px;
            height: 30px;
        }

        #cardMain {
            height: 450px;
        }
    }

    @media (min-width: 1801px) {
        #titleCuaca {
            font-size: 24px;
        }

        #tempReal {
            font-size: 45px;
        }

        #celToFah {
            font-size: 25px;
        }

        #celToRea {
            font-size: 25px;
        }

        #imageId {
            height: 250px;
        }

        #divUv {
            width: 100px;
            font-size: 16px;
        }

        #tdUV {
            width: 25px;
        }

        #tdUV img {
            width: 50px;
            height: 55px;
        }


        #divKelembaban {
            width: 100px;
            font-size: 16px;
        }


        #tdKelembaban {
            width: 25px;
        }

        #tdKelembaban img {
            width: 40px;
            height: 40px;
        }


        #divHujan {
            width: 100px;
            font-size: 16px;
        }


        #tdHujan {
            width: 25px;
        }

        #tdHujan img {
            width: 45px;
            height: 50px;
        }

        #divKecAngin {
            width: 100px;
            font-size: 16px;
        }


        #tdKecAngin {
            width: 25px;
        }

        #tdKecAngin img {
            width: 40px;
            height: 40px;
        }

        #divArahAngin {
            width: 100px;
            font-size: 16px;
        }


        #tdArahAngin {
            width: 25px;
        }

        #tdArahAngin img {
            width: 50px;
            height: 50px;
        }

        #cardMain {
            height: 550px;
        }
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
                <div class="col-xl-3 order-xl-1 order-sm-2 order-2">
                    <div class="col-12">
                        <div class="card" id="cardMain" style="border-radius: 20px;">
                            <div class="card-body">

                                <div style="width: 100%;"><span id="last_updates">-</span> -
                                    Weather Report</div>
                                <div class="row align-items-center" id="imageId">
                                    <div class="col-6 text-center" id="imageContainer">
                                    </div>
                                    <div class="col-6">
                                        <table class="table" style="">
                                            <tr>
                                                <td style="height: 80px;border-top:1px solid white" colspan="2">
                                                    <div class="col-12" id="titleCuaca"
                                                        style="font-weight:600;border-bottom:1px solid white;">
                                                        -
                                                    </div>
                                                    <div class="col-12"
                                                        style="font-weight: bold;margin-top:-5px;margin-bottom:-15px"
                                                        id="tempReal">
                                                        -
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="text-center">
                                                <td style="height: 20px;border-right:1px solid #E5E4E2;border-top:1px solid white;color:#fc9d18"
                                                    class="align-middle" id="celToFah">-</td>
                                                <td class="align-middle"
                                                    style="border-top:1px solid white;color:#79d5fc" id="celToRea">-
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <table class="table">
                                    <tr>
                                        <td id="tdUV"
                                            style=" height: 70px;border:1px solid white;border-right:1px solid #E5E4E2"
                                            class="align-middle">


                                            <div class="d-flex justify-content-center align-items-center">
                                                <div class="text-center">
                                                    <img src="{{ asset('img/sun.png') }}" alt="Sunny Day Image" style=""
                                                        class="img-fluid">
                                                </div>
                                                <div id="divUv">
                                                    <div class="text-left" style="font-weight: 500" id="uvReal">-</div>
                                                    <div class="text-left" style="color: #B6BBC4;">
                                                        Indeks UV</div>
                                                </div>
                                            </div>




                                        </td>
                                        <td id="tdKelembaban"
                                            style=" height: 70px;border:1px solid white;border-right:1px solid white"
                                            class="align-middle">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <div class="text-center">
                                                    <img src="{{ asset('img/humidity.png') }}" alt="Sunny Day Image"
                                                        style="" class="img-fluid">
                                                </div>
                                                <div id="divKelembaban">
                                                    <div class="text-left" id="humReal">-</div>
                                                    <div class="text-left" style="color: #B6BBC4;">
                                                        Kelembaban</div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td id="tdHujan"
                                            style=" height: 70px; border:1px solid white;border-right:1px solid #E5E4E2"
                                            class="align-middle">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <div class="text-center">
                                                    <img src="{{ asset('img/rain.png') }}" alt="Sunny Day Image"
                                                        class="img-fluid">
                                                </div>
                                                <div id="divHujan">
                                                    <div class="text-left" id="chReal">-</div>
                                                    <div class="text-left" style="color: #B6BBC4;">Curah
                                                        Hujan</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td id="tdKecAngin"
                                            style=" height: 70px;border:1px solid white;border-right:1px solid white"
                                            class="align-middle">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <div class="text-center">
                                                    <img src="{{ asset('img/wind_speed.png') }}" alt="Sunny Day Image"
                                                        class="img-fluid">
                                                </div>
                                                <div id="divKecAngin">
                                                    <div class="text-left" id="wsReal">-</div>
                                                    <div class="text-left" style="color: #B6BBC4;">
                                                        Kec. Angin</div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td id="tdArahAngin" style="height: 70px;" colspan="2">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <div class="text-center">
                                                    <img src="{{ asset('img/winddir.png') }}" alt="Sunny Day Image"
                                                        class="img-fluid">
                                                </div>
                                                <div id="divArahAngin">
                                                    <div class="text-left" id="wdReal">-</div>
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
                    {{-- <div class="col-12">
                        <div class="list-group">
                            <button type="button"
                                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                Lokasi
                                <span class="ml-auto"> <img src="{{ asset('img/location.png') }}" alt="Sunny Day Image"
                                        style="height: 25px" class="img-fluid"></span>
                            </button>
                        </div>
                        <br>

                        <div id="stationListContainer"></div>


                    </div> --}}
                </div>
                <div class="col-xl-9  col-sm-12  order-xl-2 order-sm-1 order-1">
                    <div>
                        <div class="float-xl-right">
                            <select name="lokasi" id="locList" class="form-control">
                                @foreach($listStation as $loc)
                                <option value="{{ $loc->id }}">{{ $loc->loc }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="float-xl-left">
                            <h2>Dashboard AWS</h2>
                            <p style="color: #6C757D">Informasi terkait kebutuhan data-data cuaca saat ini</p>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-xl-12 order-3">
                            <div class="card" style="height:350px;border-radius: 20px;">
                                <div class="card-body">
                                    <div id="tempAktual"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12 order-3">
                            <div class="card" style="height:350px;border-radius: 20px;">
                                <div class="card-body">
                                    <div id="chAktual"></div>
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
                                <span id="last_updates" style="font-style: italic;font-weight: bold">Last Update :
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


    var today = new Date();
    var options = { day: 'numeric', month: 'short', year: 'numeric' };
var todayFormatted = today.toLocaleDateString('en-US', options);

    var options = {

        series: [{
            name:'',
            data: ''
        }],
        chart: {
            background: '#ffffff',
            height: 300,
            type: 'area'
        },
        dataLabels: {
        enabled: false // disable data labels
    },
    markers: {
        size: 0 // hide data points
    },
         fill: {
        type: 'gradient',
        gradient: {
            shadeIntensity: 0.9, // intensity of the gradient
            opacityFrom: 0.1,
            opacityTo: 0.9,
            stops: [0, 100]
        }
    },


        colors: [
            '#61cdfc',
        ],

        stroke: {
            curve: 'smooth'
        },
        xaxis: {
            type: 'string',
            categories: categoriesAll,

        },
        annotations: {
          xaxis: [{
            x: '00:00',
            strokeDashArray: 0,
            borderColor: '#f44336',
            label: {
              borderColor: '#f44336',
              
              style: {
                color: '#fff',
                background: '#f44336',
                fontSize: '14px' 
              },
              text:todayFormatted,
            }
          }]
        },
    };

    var chartTemp = new ApexCharts(document.querySelector("#tempAktual"), options);
    chartTemp.render();

    var chartCh = new ApexCharts(document.querySelector("#chAktual"), options);
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
                
                var list_loc_update = arrResult['last_update_each_loc']
            
                var arrAktual = arrResult['dataAktual']

                // var stationListContainer = document.getElementById('stationListContainer');

                // stationListContainer.innerHTML = '';

                // // Iterate through the station data and create list items
                // for (var i = 0; i < list_loc_update.length; i++) {
                //     var temp_out = list_loc_update[i].temp_out;
                //     var location = list_loc_update[i].location;

                //     // Create list item
                //     var listItem = document.createElement('button');
                //     listItem.className = 'list-group-item list-group-item-action d-flex justify-content-between align-items-center';
                //     listItem.innerHTML = location + '<span class="ml-auto" style="color:#fcc533;font-weight:bold">' + temp_out + '</span>';

                //     // Append the list item to the container
                //     stationListContainer.appendChild(listItem);
                // }
                var imageContainer = document.getElementById('imageContainer');
                var existingImgElement = document.getElementById('weatherImage');

                var imageSource;

                if (arrAktual['titleIcon'] == 'Berawan') {
                    imageSource = '{{ asset("img/sunny.png") }}';
                } else if (arrAktual['titleIcon'] == 'Hujan') {
                    imageSource = '{{ asset("img/rain_icon.png") }}';
                } else {
                    imageSource = '{{ asset("img/no_data.png") }}';
                }

                // Check if the image element already exists
                if (existingImgElement) {
                    // If it exists, update its source
                    existingImgElement.src = imageSource;
                } else {
                    // If it doesn't exist, create a new image element
                    var imgElement = document.createElement('img');
                    imgElement.id = 'weatherImage';
                    imgElement.src = imageSource;
                    imgElement.alt = 'no image';
                    imgElement.classList.add('img-fluid');
                    imageContainer.appendChild(imgElement);
                }

                
                hitungCelToFah = ((9 * arrAktual['temp_out'] / 5 ) + 32).toFixed(1)
                hitungCelToRea = ((4 * arrAktual['temp_out'] / 5 ) + 20).toFixed(1)
                
                createOrUpdateElement(document.body, 'titleCuaca', arrAktual['titleIcon']);
                createOrUpdateElement(document.body, 'last_updates', arrAktual['date_format']);
                createOrUpdateElement(document.body, 'celToFah', (hitungCelToFah + '°C'));
                createOrUpdateElement(document.body, 'celToRea', (hitungCelToRea + '°C'));

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

                createOrUpdateElement(document.body, 'tempReal', arrAktual['temp_out'] + '°C');
                createOrUpdateElement(document.body, 'humReal', arrAktual['hum_out'] + ' %');
                createOrUpdateElement(document.body, 'chReal', arrAktual['rain_rate'] + ' mm');
                createOrUpdateElement(document.body, 'wdReal', arrAktual['windDirIndonesian']);
                createOrUpdateElement(document.body, 'wsReal', arrAktual['windspeedkmh'] ? arrAktual['windspeedkmh'] + ' km/jam' : '0 km/jam');
                createOrUpdateElement(document.body, 'uvReal', uvTitle + ' (' + uvVal +  ')');
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
                    name: 'Curah Hujan (mm)',
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


            createOrUpdateElement(document.body, 'tempReal', '-');
            createOrUpdateElement(document.body, 'humReal', '-');
            createOrUpdateElement(document.body, 'chReal', '-');
            createOrUpdateElement(document.body, 'wdReal', '-');
            createOrUpdateElement(document.body, 'wsReal', '-');

            chartTemp.updateOptions({
            xaxis: {
                categories: []
            }
        });

        chartTemp.updateSeries([{
            name: 'Temperatur (°C)',
            data: []
        }]);

        chartCh.updateOptions({
            xaxis: {
                categories: []
            }
        });

        chartCh.updateSeries([{
            name: 'Curah Hujan (mm)',
            data: []
        }]);
                }
            }

        })
    }


    function createOrUpdateElement(container, elementId, content) {
    var element = document.getElementById(elementId);

    if (element) {
        // If the element exists, update its content
        element.textContent = content;
    } else {
        // If the element doesn't exist, create a new one
        var newElement = document.createElement('div');
        newElement.id = elementId;
        newElement.textContent = content;

        // Append the new element to the container (adjust the container accordingly)
        container.appendChild(newElement);
    }
}

</script>