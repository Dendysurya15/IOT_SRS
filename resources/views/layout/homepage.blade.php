@include('layout.header')

<style>
    a,
    a:hover,
    a:focus,
    a:active {
        text-decoration: none;
        color: inherit;
    }

    /* .cardHead {
        height: 500px;
        background-image: url('../img/bgHome.png');
        background-repeat: no-repeat;
        background-position: 0px 150px;
        background-size: 500px;
    } */

    /* .cardHead {
        background-image: url('../img/bgHomeLeft.png');
        background-repeat: no-repeat;
        background-position: 350px 0px;
        background-size: 850px;
    } */
    .card {
        height: 100%;
    }

    .selectCard:hover {
        transform: scale(1.05);
        box-shadow: 0 10px 20px rgba(0, 0, 0, .12), 0 4px 8px rgba(0, 0, 0, .06);
    }

    .selectCard {
        border-radius: 4px;
        background: #fff;
        box-shadow: 0 6px 10px rgba(0, 0, 0, .08), 0 0 6px rgba(0, 0, 0, .05);
        transition: .3s transform cubic-bezier(.155, 1.105, .295, 1.12), .3s box-shadow, .3s -webkit-transform cubic-bezier(.155, 1.105, .295, 1.12);
        cursor: pointer;
    }
</style>
<div class="content-wrapper">

    <section class="content">

        <br>
        <div class="container-fluid">

            <div class="row">
                <div class="col-md">
                    <div class="card cardHead">
                        <div class="card-body">
                            <div class="row">

                                <div class="col-sm-6">
                                    <div class="col-sm-12">
                                        <h3> <span> IoT (Weather Station dan Water
                                                Level)</span></h3>
                                    </div>
                                    <div class="col-sm-12">
                                        {{-- <h3>Dashboard, visualisasi dan tabel dari data pengamatan cuaca dan
                                            ketinggian
                                            air
                                        </h3> --}}
                                    </div>
                                    <div class="col-sm-8" style="font-size: 18px">
                                        <span class="text-muted">Mendapatkan data secara real-time dari sensor serta
                                            menampilkan
                                            report
                                            berupa rekap rata-rata data di <span class="font-weight-bold"> dashboard
                                            </span>,
                                            visualisasi <span class="font-weight-bold"> grafik </span> harian, mingguan
                                            dan bulanan serta <span class="font-weight-bold"> tabel </span> yang dapat
                                            diunduh dengan format
                                            Excel
                                        </span>
                                    </div>
                                    <div class="col-sm-12">
                                        {{--
                                        <br>
                                        <h6>Project</h6>
                                        <ul class="list-inline">
                                            <li class="list-inline-item">
                                                <i class=" fa fa-map-marker-alt"></i>
                                                KNE Q23
                                            </li>
                                            <li class="list-inline-item">
                                                <i class=" fa fa-map-marker-alt"></i>
                                                KNE Q24
                                            </li>
                                        </ul> --}}

                                        <br>

                                    </div>
                                </div>
                                <div class="col-sm-6" style="">
                                    <h6>
                                        Fitur Utama :
                                    </h6>

                                    <ul class="list-inline">
                                        <li class="list-inline-item col-sm-3">
                                            <a href="{{ url('/dashboard_wl') }}">
                                                <div class="card h-100 selectCard">
                                                    <div class="card-body" style="text-align: center">
                                                        <i class="fa fa-water fa-2x" style="color:#5797E6;"></i>
                                                        <br>
                                                        <span style="font-size: 15px; "> Dashboard Water
                                                            Level</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="list-inline-item col-sm-3">
                                            <a href="{{ url('/grafik_wl') }}">
                                                <div class="card h-100 selectCard">
                                                    <div class="card-body" style="text-align: center">
                                                        <i class="fa fa-chart-area fa-2x" style="color:#D24141;"></i>
                                                        <br>
                                                        <span style="font-size: 16px"> Grafik Water
                                                            Level</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="list-inline-item col-sm-3">
                                            <a href="{{ url('/tabel_wl') }}">
                                                <div class="card h-100 selectCard">
                                                    <div class="card-body" style="text-align: center">
                                                        <i class="fa fa-border-all fa-2x" style="color:#3C3B4C;"></i>
                                                        <br>
                                                        <span style="font-size: 15px"> Tabel Water
                                                            Level</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="list-inline-item col-sm-3">
                                            <a href="{{ url('/dashboard_ws') }}">
                                                <div class="card h-100 selectCard">
                                                    <div class="card-body" style="text-align: center">
                                                        <i class="fa fa-cloud fa-2x" style="color:#0D6287;"></i>
                                                        <br>
                                                        <span style="font-size: 15px"> Dashboard AWS
                                                        </span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="list-inline-item col-sm-3">
                                            <a href="{{ url('/grafik') }}">
                                                <div class="card h-100 selectCard">
                                                    <div class="card-body" style="text-align: center">
                                                        <i class="fa fa-chart-pie fa-2x" style="color:#E2870B;"></i>
                                                        <br>
                                                        <span style="font-size: 15px"> Grafik AWS
                                                        </span>

                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="list-inline-item col-sm-3">
                                            <a href="{{ url('/tabel') }}">
                                                <div class="card h-100 selectCard ">
                                                    <div class="card-body" style="text-align: center">
                                                        <i class=" fa fa-table fa-2x" style="color:#69B585;"></i>
                                                        <br>
                                                        <span style="font-size: 15px"> Tabel AWS
                                                        </span>

                                                    </div>
                                                </div>
                                            </a>
                                        </li>

                                    </ul>
                                </div>

                            </div>


                        </div>
                    </div>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </section>


    <!--Coba Tambah Koment -->
</div>
@include('layout.footer')