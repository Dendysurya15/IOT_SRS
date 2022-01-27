@include('layout.header')

<div class="content-wrapper">
    <!-- //Content Header AWS 1-->

    <section class="content-header">
        <div class="content-fluid">
            <div>
                <div class="col-sm">
                    <div class=" row ">
                        <div class="col-auto">
                            <h1 class="m-0 text-dark">
                                Water Level {{$listLoc[Request()->id ?: $defaultId]}}, Hari ini {{ $timeToday }}
                            </h1>
                        </div>
                        <div class="col-auto ml-auto">
                            <form class="" action="{{ route('dashboard_wl') }}" method="get">
                                <select name="id" class="form-control-sm" onchange="this.form.submit()">
                                    <option value="" selected disabled>Pilih Lokasi</option>
                                    @foreach ($listLoc as $key => $list)
                                    <option value="{{$key}}">{{$list}}</option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                        {{-- <h5 class="list-inline-item">Lokasi</h5> --}}
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
                            <div class="card-title" style="text-transform: uppercase;">Rata-rata Level In</div>
                        </div>
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="temp_in1">{{
                                        isset($avg['lvl_in']) ? ''.$avg['lvl_in'].' cm' : "Data Level In tidak ada"}}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i id="s_temp_in1" class="fas fa-water fa-2x"></i>
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
                            <div class="card-title" style="text-transform: uppercase;">Rata-rata Level Out</div>
                        </div>
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="hum_in1">
                                        {{ isset($avg['lvl_out']) ? ''.$avg['lvl_out'].' cm' : "Data Level Out tidak
                                        ada"}}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i id="s_hum_in1" class="fas fa-water fa-2x"></i>
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
                            <div class="card-title" style="text-transform: uppercase;">Rata-rata Level Actual</div>
                        </div>
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="hum_in1">
                                        {{
                                        isset($avg['lvl_act']) ? ''.$avg['lvl_act'].' cm' : "Data Level Actual tidak
                                        ada"}}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i id="s_hum_in1" class="fas fa-water fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Kelembaban Ruangan-->

            </div>
            <!-- /.row -->


            <div class="row">

                <div class="col-md-6">
                    <div class="card">
                        @if (!is_null($maps->foto_udara))
                        <div class=" card-header text-center">
                            <span class="font-weight-bold" style="text-transform: uppercase;">
                                Lokasi Pompa Air {{$listLoc[Request()->id ?: $defaultId]}} view Satelit
                            </span>
                        </div>
                        <div class="card-body">
                            <a href="https://maps.google.com/maps?t=k&q={{$maps->lat}},{{$maps->long}}" target=”_blank”>
                                <img src="{{ asset('../img/'.$maps->foto_udara) }}" class="img-fluid"
                                    alt="Responsive image">
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        @if (!is_null($maps->foto_udara))
                        <div class="card-header text-center">
                            <span class="font-weight-bold" style="text-transform: uppercase;">
                                Foto di lokasi {{$listLoc[Request()->id ?: $defaultId]}}
                            </span>
                        </div>
                        <div class="card-body">
                            <img src="{{ asset('../img/'.$maps->foto_lokasi) }}" class="img-fluid"
                                alt="Responsive image">
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>


    <!--Coba Tambah Koment -->
</div>
@include('layout.footer')