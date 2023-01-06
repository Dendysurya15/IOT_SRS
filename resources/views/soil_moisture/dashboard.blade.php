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


    {{-- @foreach($aws as $value) --}}
    <section class="content-header">
        <div class="content-fluid">

        </div>
    </section>
    <!--Content Header AWS 1//-->

    <!-- // Main content AWS 1-->
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header card-light">
                    <h5>Kelembaban Tanah Selama 24 Jam Terakhir</h5>
                </div>
                <div class="card-body pb-5">
                    <div id="hum"></div>
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-header card-light">
                    <h5>Temperatur Tanah Selama 24 Jam Terakhir</h5>
                </div>
                <div class="card-body pb-5">
                    <div id="temp"></div>
                </div>
            </div>
        </div>
</div>
</div>
< </section>



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
        var arrHour = <?php echo json_encode($arrHour); ?>;
        var listHour = <?php echo json_encode($listHour); ?>;

        // console.log(listHour)
        var dateNow = <?php echo json_encode($dateNow); ?>;

        var arrNewHour = Object.entries(arrHour)

        var categoriesHour = '['
        listHour.forEach(element => {
            categoriesHour += '"' + element + '",'
        });


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

        categoriesHour = categoriesHour.substring(0, categoriesHour.length - 1);
        categoriesHour += ']'
        // console.log(categoriesHour)
        hum = JSON.parse(hum)
        temp = JSON.parse(temp)
        categoriesHour = JSON.parse(categoriesHour)
        // console.log(categoriesHour)

        var options = {
            series: [{
                name: 'Kelembaban',
                data: hum
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
                show: true,
                curve: 'smooth',
                lineCap: 'butt',
                colors: undefined,
                width: 2,
                dashArray: 0,
            },
            xaxis: {
                type: 'string',
                categories: categoriesHour
                // ["2018-09-19T00:00:00.000Z", "2018-09-19T01:30:00.000Z", "2018-09-19T02:30:00.000Z",
                // "2018-09-19T03:30:00.000Z", "2018-09-19T04:30:00.000Z", "2018-09-19T05:30:00.000Z", "2018-09-19T06:30:00.000Z"]
            },
            annotations: {
                xaxis: [{
                    x: '00:00',
                    borderColor: '#775DD0',
                    label: {
                        borderColor: "#FF4560",
                        borderWidth: 1,
                        borderRadius: 2,
                        offsetY: 0,
                        style: {
                            color: "#fff",
                            background: "#FF4560",
                            fontSize: '13pt',
                            fontWeight: 400,
                        },
                        orientation: 'horizontal',

                        text: dateNow
                    }
                }]
            }
            // tooltip: {
            // x: {
            // format: 'dd/MM/yy HH:mm'
            // },
            // },
        };

        var chart = new ApexCharts(document.querySelector("#hum"), options);
        chart.render();

        var options = {
            series: [{
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
            colors: ['#f44336', '#b71c1c', '#9C27B0'],
            stroke: {
                show: true,
                curve: 'smooth',
                lineCap: 'butt',
                colors: undefined,
                width: 2,
                dashArray: 0,
            },
            xaxis: {
                type: 'string',
                categories: categoriesHour
                // ["2018-09-19T00:00:00.000Z", "2018-09-19T01:30:00.000Z", "2018-09-19T02:30:00.000Z",
                // "2018-09-19T03:30:00.000Z", "2018-09-19T04:30:00.000Z", "2018-09-19T05:30:00.000Z", "2018-09-19T06:30:00.000Z"]
            },
            annotations: {
                xaxis: [{
                    x: '00:00',
                    borderColor: '#775DD0',
                    label: {
                        borderColor: "#FF4560",
                        borderWidth: 1,
                        borderRadius: 2,
                        offsetY: 0,
                        style: {
                            color: "#fff",
                            background: "#FF4560",
                            fontSize: '13pt',
                            fontWeight: 400,
                        },
                        orientation: 'horizontal',

                        text: dateNow
                    }
                }]
            }
        };

        var chart = new ApexCharts(document.querySelector("#temp"), options);
        chart.render();
    </script>