@include('layout.header')
<style>
    .content {
        font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
        font-size: 15px;
    }

    th,
    td {
        white-space: nowrap;
    }

    div.dataTables_wrapper {
        /* width: 800px; */
        margin: 0 auto;
    }

    table.dataTable thead tr th {
        border: 1px solid black;
    }
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    </section>

    <section class="content">
        <div class="container-fluid">
            <h3>Tabel Perbandingan Data Forecast Aktual AWS Davis dan Accu Weather</h3>

            <div class="card">
                <div class="card-body">

                    <table id="example" class="table table-bordered" cellspacing="0" width="100%">
                        <thead class="text-center">
                            <tr>
                                <th rowspan="2">Tanggal</th>
                                <th colspan="5">Forecast Weather SRS</th>
                                <th colspan="5">Aktual Davis BKE</th>
                                <th colspan="5">Forecast AccuWeather</th>
                                <th colspan="5">Aktual AccuWeather</th>
                            </tr>
                            <tr>
                                <th>RF (mm)</th>
                                <th>Hum (%)</th>
                                <th>Temp (C)</th>
                                <th>WS(m/s)</th>
                                <th>WD</th>
                                <th>RF (mm)</th>
                                <th>Hum (%)</th>
                                <th>Temp (C)</th>
                                <th>WS(m/s)</th>
                                <th>WD</th>
                                <th>RF (mm)</th>
                                <th>Hum (%)</th>
                                <th>Temp (C)</th>
                                <th>WS(m/s)</th>
                                <th>WD</th>
                                <th>RF (mm)</th>
                                <th>Hum (%)</th>
                                <th>Temp (C)</th>
                                <th>WS(m/s)</th>
                                <th>WD</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>


                </div>
            </div>


        </div>
    </section>

</div>
@include('layout.footer')

{{-- <script src=" {{ asset('lottie/93121-no-data-preview.json') }}" type="text/javascript">
</script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.9.4/lottie.min.js"
    integrity="sha512-ilxj730331yM7NbrJAICVJcRmPFErDqQhXJcn+PLbkXdE031JJbcK87Wt4VbAK+YY6/67L+N8p7KdzGoaRjsTg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- jQuery -->
<script src="{{ asset('/public/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('/public/plugins/bootstrap/js/bootstrap.bundle.min.js') }}">
</script>
<!-- ChartJS -->
<script src="{{ asset('/public/plugins/chart.js/Chart.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('/public/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('/public/js/demo.js') }}"></script>

<script src="{{ asset('/public/js/loader.js') }}"></script>



<script>
    $(function() {
        $('#example').DataTable({
            "scrollX": true,
            "searching": true,
            "pageLength": 10,
            processing: true,
            serverSide: true,
            ajax: "{{ route('data') }}",
            columns: [
            { data: 'tanggal', name: 'tanggal' },
            { data: 'rain_forecast', name: 'rain_forecast' },
            { data: 'hum_forecast', name: 'hum_forecast' },
            { data: 'temp_forecast', name: 'temp_forecast' },
            { data: 'hum_forecast', name: 'hum_forecast' },
            { data: 'hum_forecast', name: 'hum_forecast' },
            { data: 'rain', name: 'rain' },
            { data: 'temp', name: 'temp' },
            { data: 'hum', name: 'hum' },
            { data: 'wind_speed', name: 'wind_speed' },
            { data: 'wind_dir', name: 'wind_dir' },
            { data: 'accu_rain', name: 'accu_rain' },
            { data: 'accu_temp', name: 'accu_temp' },
            { data: 'accu_hum', name: 'accu_hum' },
            { data: 'accu_hum', name: 'accu_hum' },
            { data: 'accu_rain_forecast', name: 'accu_rain_forecast' },
            { data: 'accu_temp_forecast', name: 'accu_temp_forecast' },
            { data: 'accu_hum_forecast', name: 'accu_hum_forecast' },
            { data: 'accu_hum_forecast', name: 'accu_hum_forecast' },
            { data: 'accu_hum_forecast', name: 'accu_hum_forecast' },
            { data: 'accu_hum_forecast', name: 'accu_hum_forecast' },

        ],
        
        });
    });
</script>