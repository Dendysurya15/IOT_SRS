<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>IoT DASHBOARD</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/img/CBI-logo.png') }}">
    <link href="{{asset('fontawesome6/css/all.css')}}" rel="stylesheet">
    {{-- <script src="https://kit.fontawesome.com/3d2c665316.js" crossorigin="anonymous"></script> --}}

    <!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"-->
    <!--     integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">-->
    <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.11.5/datatables.min.css" />-->

    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"-->
    <!--     integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>-->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"-->
    <!--     integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous">-->
    <!-- </script>-->
    <!-- <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.11.5/datatables.min.js"></script>-->
    {{--
    <link href="{{ asset('fontawesome6/css/solid.css') }}" rel="stylesheet"> --}}


    {{--
    <link href="{{ asset('fontawesome6/css/solid.css') }}" rel="stylesheet"> --}}

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    <link rel="stylesheet" href="{{ asset('css/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery.fancybox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link href="{{ asset('css/css.css') }}" rel="stylesheet">


    <script type="text/javascript" src="{{ asset('js/loader.js') }}"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.11.5/datatables.min.css" />

    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/buttons.dataTables.min.css') }}" />

    <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.dataTables.min.css') }}" />



    <style type="text/css">
        .center {
            margin: auto;
            height: 500px;
            width: 70%;
            padding: 10px;
            text-align: center;
        }

        .tengah {
            vertical-align: middle;
        }

        .hijau {
            background-color: #00621A;
            color: white;
        }

        .biru {
            background-color: #001494;
            color: white;
        }

        .merah {
            background-color: red;
            color: red;
        }

        .dropdown:hover .dropdown-menu {
            display: block;
        }
    </style>

</head>

<body class="hold-transition sidebar-mini sidebar-collapse layout-fixed layout-navbar-fixed">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav" style="width: 100%">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="hover"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item  d-sm-inline-block">
                    <a class="nav-link">Selamat datang, {{ session('user_name') }}!</a>
                </li>



            </ul>
        </nav>
        <aside class="main-sidebar sidebar-light-primary elevation-4">
            <a href="{{ url('/dashboard') }}" class="brand-link">
                <img src="{{ asset('/img/CBI-logo.png') }}" alt="Covid Tracker" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">IoT</span>
            </a>

            <div class="sidebar">
                <nav class="" style="height: 100%">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false" style="height: 100%">
                        <!-- USER LAB -->

                        <!-- TABEL -->
                        <li class="nav-item">
                            <a href="{{ url('/dashboard_wl') }}" class="nav-link">
                                <i class="nav-icon fa fa-water"></i>
                                <p>
                                    Dashboard Water Level
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('/grafik_wl') }}" class="nav-link">
                                <i class="nav-icon fa fa-chart-area"></i>
                                <p>
                                    Grafik Water Level
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('/tabel_wl') }}" class="nav-link">
                                <i class="nav-icon fa fa-border-all"></i>
                                <p>
                                    Tabel Water Level
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('/dashboard_ws') }}" class="nav-link">
                                <i class="nav-icon fa fa-cloud"></i>
                                <p>
                                    Dashboard AWS
                                </p>
                            </a>
                        </li>

                        <!--      <li class="nav-item">-->
                        <!--    <a href="{{ url('/dashboard_soil') }}" class="nav-link">-->
                        <!--        <i class="nav-icon fa fa-droplet"></i>-->
                        <!--        <p>-->
                        <!--            Dashboard Soil Moisture-->
                        <!--        </p>-->
                        <!--    </a>-->
                        <!--</li>-->

                        <!-- TABEL -->
                        <li class="nav-item">
                            <a href="{{ url('/grafik') }}" class="nav-link">
                                <i class="nav-icon fa fa-chart-pie"></i>
                                <p>
                                    Grafik AWS
                                </p>
                            </a>
                        </li>

                        <!-- GRAFIK -->
                        <li class="nav-item">
                            <a href="{{ url('/tabel') }}" class="nav-link">
                                <i class="nav-icon fa fa-table"></i>
                                <p>
                                    Tabel AWS
                                </p>
                            </a>
                        </li>
                        <li class="nav-item fixed-bottom mb-3" heig style="position: absolute;">
                            <a href="{{ route('logout') }}" class="nav-link " onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="nav-icon fa fa-sign-out-alt"></i>
                                <p>
                                    Logout
                                </p>
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>

                    </ul>
                </nav>
            </div>
        </aside>