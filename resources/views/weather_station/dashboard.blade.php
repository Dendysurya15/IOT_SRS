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

<div class="content-wrapper">
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
                <div class="col-lg-3 mb-3">
                    <div class="row">
                        <div class="col-md-8">
                        </div>
                        <form class="col-md-12" action="" method="post">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md">
                                    <select name="lokasi" id="locList" class="form-control">
                                        <option selected disabled>Pilih Lokasi</option>
                                        @foreach($aws_loc as $loc)
                                        <option value="{{ $loc['id'] }}">{{ $loc['loc'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </form>
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
                        <div class="card-body p-5 "
                            style="color:white;
                       background: linear-gradient(rgba(0,0,0,0.6),rgba(0,0,0,0.2)), url({{asset('../img/sunny-day.png')}}) no-repeat; background-size: cover;background-position:top center;">
                            <div class="layer">
                                <div class="row no-gutters align-items-center">
                                    <div class="col-1 mr-2">
                                        <img src="{{ asset('../img/'.$aktual->icon) }}" class="img-fluid"
                                            style="width: 80px;" alt="Responsive image">
                                    </div>
                                    <div class="col-2">
                                        <div style="font-size: 13px;margin-bottom:-10px">
                                            <span id="locTitle"></span> {{$date}}
                                        </div>
                                        <div class="" style="font-size: 45px">{{
                                            $data[0]['temp_real'] ?? '-' }}
                                            ºC
                                        </div>
                                        <div style="margin-top: -10px">
                                            {{$aktual->titleIcon}}
                                        </div>
                                    </div>
                                    <div class="col">
                                        Kelembaban
                                        <br>
                                        <img src="{{ asset('../img/water.png') }}" class="img-fluid"
                                            style="width: 15px;margin-left:10px;" alt="Responsive image">
                                        {{
                                        $aktual->hum_real != 0 ? $aktual->hum_real : '-'
                                        }} %
                                    </div>
                                    <div class="col">
                                        Kecepatan Angin
                                        <br>
                                        <i class="fas fa-wind"></i>
                                        {{
                                        $aktual->wind_speed_real != 0 ? $aktual->wind_speed_real : '-'
                                        }} m/s
                                    </div>
                                    <div class="col">
                                        Arah Angin
                                        <br>
                                        <i class="fas fa-compass"></i>
                                        {{
                                        $aktual->wind_chill_real != 0 ? $aktual->wind_chill_real : '-'
                                        }}
                                    </div>
                                    <div class="col">
                                        Curah Hujan
                                        <br>
                                        <i class="fas fa-water"></i>
                                        {{
                                        $aktual->rain_fall_real != 0 ? $aktual->rain_fall_real : '-'
                                        }} mm
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
            <div class="mt-2 mb-3">
                <span>
                    Perkiraan cuaca seminggu kedepan
                </span>
                <span class="float-right font-italic">
                    <a href="{{ route('month_weather_forecast') }}"> Lihat Perkiraan cuaca ...</a>
                </span>
            </div>
            <div class="row">
                @foreach ($forecasting as $key => $item)
                <div class="col-md">
                    <div class="card card-light selectCard">
                        <div class="card-header">
                            <div class="card-title">{{$item['hari']}}</div>
                        </div>
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="hum">
                                        <div class="mb-2">
                                            {{
                                            $item['predSuhu'] != 0 ? $item['predSuhu'] : '-'
                                            }} ºC
                                        </div>
                                        {{
                                        $item['predKel'] != 0 ? $item['predKel'] : '-'
                                        }} %
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <img src="{{ asset('../img/'.$item['icon']) }}" class="img-fluid"
                                        style="width: 50px;" alt="Responsive image">
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
            <div class="mt-2 mb-3">
                <span>
                    Ringkasan data per jam
                </span>
            </div>
            <div class="" style="border: 1px solid red">
                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img class="d-block w-100" src=".../800x400?auto=yes&bg=777&fg=555&text=First slide"
                                alt="First slide">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" src=".../800x400?auto=yes&bg=666&fg=444&text=Second slide"
                                alt="Second slide">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" src=".../800x400?auto=yes&bg=555&fg=333&text=Third slide"
                                alt="Third slide">
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
            </div>

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
<script src="{{ asset('/public/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('/public/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('/public/plugins/chart.js/Chart.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('/public/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('/public/js/demo.js') }}"></script>

<script src="{{ asset('/public/js/loader.js') }}"></script>

<script>
    $(document).ready(function(){
      var indexDefault = 2;
      $('#locList').val(99)
      let dropdownList = document.getElementById('locList');
      let selectedOption = dropdownList.options[indexDefault];
      var idws = selectedOption.value;
      var loc = selectedOption.text;
      getDataLoc(idws,loc)
    });

    $('#locList').change(function(){
    if($(this).val() != '')
    {
    var e = document.getElementById("locList");
    var loc = e.options[e.selectedIndex].text;

    getDataLoc($('#locList'),loc)
    }
    });

    function getDataLoc(locIndex, loc){
        var status = 0 // ketika ada klik id yang di fetch
    var value = ''
    try {
        value = locIndex.val();   
    }
    catch(err) {
        var status = 1 // ketika tidak ada klik dan nilai RDE
    } 

    if(status == 1){
        value = locIndex
    }      

    var _token = $('input[name="_token"]').val();
    const params = new URLSearchParams(window.location.search)
    var paramArr = [];
    for (const param of  params) {
        paramArr = param
    }

    if(paramArr.length > 0){
        date = paramArr[1]
    }else{
        date = new Date().toISOString().slice(0, 10)
    }

    $.ajax({
    url:"{{ route('getDataDashboard') }}",
    method:"POST",
    data:{ id_loc:value, _token:_token, tgl:date},
    success:function(result)
    {
        if(result.length > 10){
            sliceResult = result.slice(1, -1);
        const arrSlice = sliceResult.split(",");
        const arrResult = []
        for (let index = 0; index < arrSlice.length; index++) {
            const splitted = arrSlice[index].split(":")
            var estate = splitted[0].slice(1, -1);
            var valEst = splitted[1]
            arrResult.push([estate,valEst])
        }
        console.log(arrResult)
        $textTemp = (arrResult[6][1] == 0 || arrResult[6][1] == '"0"') ? '-' : arrResult[6][1] + ' ºC';
        $textHum = (arrResult[7][1] == 0 || arrResult[7][1] == '"0"') ? '-'  :arrResult[7][1] + ' %';
        $textWC = (arrResult[5][1] == 0 || arrResult[5][1] == '"0"') ? '-' :arrResult[5][1] + ' m/s';
        $textWS = (arrResult[3][1] == 0 || arrResult[3][1] == '"0"') ? '-' :arrResult[3][1] + ' mm';
        $textRF = (arrResult[8][1] == 0 || arrResult[8][1] == '"0"') ? '-' :arrResult[8][1] + ' mm';
        $textRFo = (arrResult[9][1] == 0 || arrResult[9][1] == '"0"') ? '-' :  parseFloat(arrResult[9][1]).toFixed(2) + ' mm';
        }else{
        $textTemp = '-';
        $textHum = '-';
        $textWC = '-';
        $textWS = '-';
        $textRF = '-';
        $textRFo = '-';
        }
        
        document.getElementById('locTitle').innerHTML = loc + ", ";
        document.getElementById('temp').innerHTML = $textTemp ;
        document.getElementById('hum').innerHTML = $textHum ;
        document.getElementById('wind_chill_real').innerHTML = $textWC ;
        document.getElementById('wind_speed_real').innerHTML = $textWS ;
        document.getElementById('rain_fall_real').innerHTML = $textRF ;
        document.getElementById('rain_forecast').innerHTML = $textRFo ;

    }
    })
    }
</script>