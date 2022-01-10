@include('layout.header')

<div class="content-wrapper">
    <!-- //Content Header AWS 1-->
    @if(!empty($aws))
    <?php $lokasiSel = ''; ?>
    @foreach($aws as $value)
    <section class="content-header">
        <div class="content-fluid">
            <div class="row mb-2 ml-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">
                        {{ $value['loc'] }} {{ $updateterakhir['hari'] }} {{ $updateterakhir['tanggal'] }} Jam {{
                        $updateterakhir['jam'] }}
                    </h1>
                </div>

                <div class="col-sm-6 float-sm-right">
                    <div class="row">
                        <div class="col-md-8">
                            <h1 class="m-0 text-dark float-sm-right">
                                LOKASI
                            </h1>
                        </div>
                        <form class="col-md-4 float-sm-right" action="{{ url('filllokasi') }}" method="post">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-8">
                                    <select name="lokasi" class="form-control" onchange="this.form.submit()">
                                        @foreach($aws_loc as $loc)
                                        <option value="{{ $loc['id'] }}">{{ $loc['loc'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Content Header AWS 1//-->

    <!-- // Main content AWS 1-->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!--//Suhu Ruangan Aws 1-->
                <div class="col-md-4">
                    <div class="card card-primary">
                        <div class="card-header">
                            <div class="card-title">Suhu Udara</div>
                        </div>
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="temp_in1">{{ $value['t'] }}
                                        ºC</div>
                                </div>
                                <div class="col-auto">
                                    <i id="s_temp_in1" class="fas fa-thermometer-three-quarters fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Suhu Ruangan//-->

                <!--//Kelembaban Ruangan Aws 1-->
                <div class="col-md-4">
                    <div class="card card-primary">
                        <div class="card-header">
                            <div class="card-title">Kelembaban Udara</div>
                        </div>
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="hum_in1">{{ $value['h'] }} %
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
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="hum_in1">{{ $value['ws'] }}
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
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="hum_in1">{{ $value['wc'] }}
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
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="rain_rn1">
                                        <?php
                        $curahHujan = $value['r'] * $value['rain_cal'];
                    ?>
                                        {{ $curahHujan }}
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
                <!--Curah Hujan Sekarang//-->

            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content AWS 1 //-->
    @endforeach
    @else
    <?php $lokasiSel = ''; ?>
    <section class="content-header">
        <div class="content-fluid">
            <div class="row mb-2 ml-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">
                        @foreach($aws_loc as $loc)
                        @if($loc['id'] == $lokasi)
                        <?php
                    echo $loc['loc'];
                    $lokasiSel = $loc['loc'];;
                  ?>
                        @endif
                        @endforeach
                    </h1>
                </div>

                <div class="col-sm-6 float-sm-right">
                    <div class="row">
                        <div class="col-md-8">
                            <h1 class="m-0 text-dark float-sm-right">
                                LOKASI
                            </h1>
                        </div>
                        <form class="col-md-4 float-sm-right" action="{{ url('filllokasi') }}" method="post">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-8">
                                    <select name="lokasi" class="form-control" onchange="this.form.submit()">
                                        <option value="{{ $lokasi }}" selected disabled>{{ $lokasiSel }}</option>
                                        @foreach($aws_loc as $loc)
                                        <option value="{{ $loc['id'] }}">{{ $loc['loc'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- // Main content AWS 1-->
    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <!--//Kelembaban Ruangan Aws 1-->
                <div class="col-md-4">
                    <div class="card card-primary">
                        <div class="card-header">
                            <div class="card-title">{{ $lokasiSel }}</div>
                        </div>
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="hum_in1">DATA TIDAK
                                        DITEMUKAN</div>
                                </div>
                                <div class="col-auto">
                                    <i id="s_hum_in1" class="fas fa-search-minus fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Kelembaban Ruangan-->

            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    @endif

    <!--Coba Tambah Koment -->
</div>
@include('layout.footer')