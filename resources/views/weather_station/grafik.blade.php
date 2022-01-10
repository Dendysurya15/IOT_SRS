@include('layout.header')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <!-- Curah Hujan -->
                    <div class="card card-red">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-wind pr-2"></i>Data Aws Hari Ini
                            </h3>
                            <div class="row float-sm-right">
                                <div class="col-md-4 float-sm-right">
                                    <h3 class="card-title">
                                        PILIH DATA
                                    </h3>
                                </div>
                                <form class="col-md-5" action="{{ url('/perhari') }}" method="post">

                                    {{ csrf_field() }}
                                    <select name="pilih_data" class="form-control" onchange="this.form.submit()">
                                        @if(isset($fillHariini) && !empty($fillHariini))
                                        <option value="{{ $fillHariini['value'] }}" selected disabled>{{
                                            $fillHariini['data'] }}</option>
                                        @endif
                                        <option value="suhu_udara">Suhu Udara</option>
                                        <option value="kelembaban_udara">Kelembaban Udara</option>
                                        <option value="curah_hujan">Curah Hujan</option>
                                    </select>
                                </form>
                                <div class="col-md-3 float-sm-right">
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                                class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                                                class="fas fa-times"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart" id="awsPerHariini">
                            </div>
                        </div><!-- /.card-body -->
                    </div><!-- Curah Hujan -->

                    <!-- Curah Hujan -->
                    <div class="card card-cyan">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-wind pr-2"></i>Data Aws Minggu Ini
                            </h3>

                            <div class="row float-sm-right">
                                <div class="col-md-4 float-sm-right">
                                    <h3 class="card-title">
                                        PILIH DATA
                                    </h3>
                                </div>
                                <form class="col-md-5" action="{{ url('/perminggu') }}" method="post">
                                    {{ csrf_field() }}
                                    <select name="pilih_data" class="form-control" onchange="this.form.submit()">
                                        @if(isset($fillMinggu) && !empty($fillMinggu))
                                        <option value="{{ $fillMinggu['value'] }}" selected disabled>{{
                                            $fillMinggu['data'] }}</option>
                                        @endif
                                        <option value="suhu_udara">Suhu Udara</option>
                                        <option value="kelembaban_udara">Kelembaban Udara</option>
                                        <option value="curah_hujan">Curah Hujan</option>
                                    </select>
                                </form>
                                <div class="col-md-3 float-sm-right">
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                                class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                                                class="fas fa-times"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart" id="awsPerMinggu">
                            </div>
                        </div><!-- /.card-body -->
                    </div><!-- Curah Hujan -->

                    <!-- Curah Hujan -->
                    <div class="card card-purple">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-wind pr-2"></i>Data Aws Bulan Ini
                            </h3>
                            <div class="row float-sm-right">
                                <div class="col-md-4 float-sm-right">
                                    <h3 class="card-title">
                                        PILIH DATA
                                    </h3>
                                </div>
                                <form class="col-md-5" action="{{ url('/perbulan') }}" method="post">
                                    {{ csrf_field() }}
                                    <select name="pilih_data" class="form-control" onchange="this.form.submit()">
                                        @if(isset($fillBulan) && !empty($fillBulan))
                                        <option value="{{ $fillBulan['value'] }}" selected disabled>{{
                                            $fillBulan['data'] }}</option>
                                        @endif
                                        <option value="suhu_udara">Suhu Udara</option>
                                        <option value="kelembaban_udara">Kelembaban Udara</option>
                                        <option value="curah_hujan">Curah Hujan</option>
                                    </select>
                                </form>
                                <div class="col-md-3 float-sm-right">
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                                class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                                                class="fas fa-times"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart" id="awsPerbulan">
                            </div>
                        </div><!-- /.card-body -->
                    </div><!-- Curah Hujan -->
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
@include('layout.footer')

<!-- jQuery -->
<script src="{{ asset('public/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('public/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('public/plugins/chart.js/Chart.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('public/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('public/js/demo.js') }}"></script>

<script src="{{ asset('public/js/loader.js') }}"></script>

<script type="text/javascript">
    google.charts.load('current', {
    'packages': ['corechart']
  });
  google.charts.setOnLoadCallback(drawChart);

  function drawChart() {  
    //--Aws Perminggu  
    var judulPerhariini = '<?php echo $arrAwsHariIni['judul']; ?>';

    var dataAwsPerHariIni = new google.visualization.DataTable();
    dataAwsPerHariIni.addColumn('string', 'Name');
    dataAwsPerHariIni.addColumn('number', judulPerhariini);
    dataAwsPerHariIni.addRows([
      <?php echo $arrAwsHariIni['data']; ?>
    ]);

    var optionsAwsPerHariIni = {
      chartArea: {},
      series: {
        1: {
          targetAxisIndex: 1
        }
      },
      theme: 'material',
      legend: {
        position: 'top'
      },
      height: 300
    };

    var awsPerHariIni = new google.visualization.LineChart(document.getElementById('awsPerHariini'));
    awsPerHariIni.draw(dataAwsPerHariIni, optionsAwsPerHariIni);
    //Aws Perminggu--

    //--Aws Perminggu  
    var judulPerminggu = '<?php echo $arrAwsPerminggu['judul']; ?>';

    var dataAwsPerMinggu = new google.visualization.DataTable();
    dataAwsPerMinggu.addColumn('string', 'Name');
    dataAwsPerMinggu.addColumn('number', judulPerminggu);
    dataAwsPerMinggu.addRows([
      <?php echo $arrAwsPerminggu['data']; ?>
    ]);

    var optionsAwsPerMinggu = {
      chartArea: {},
      series: {
        1: {
          targetAxisIndex: 1
        }
      },
      theme: 'material',
      legend: {
        position: 'top'
      },
      height: 300
    };

    var awsPerMinggu = new google.visualization.LineChart(document.getElementById('awsPerMinggu'));
    awsPerMinggu.draw(dataAwsPerMinggu, optionsAwsPerMinggu);
    //Aws Perminggu--

    //--Aws Perbulan  
    var judulPerbulan = '<?php echo $arrAwsPerbulan['judul']; ?>';

    var dataAwsPerBulan = new google.visualization.DataTable();
    dataAwsPerBulan.addColumn('string', 'Name');
    dataAwsPerBulan.addColumn('number', judulPerbulan);
    dataAwsPerBulan.addRows([
      <?php echo $arrAwsPerbulan['data']; ?>
    ]);

    var optionsAwsPerBulan = {
      chartArea: {},
      series: {
        1: {
          targetAxisIndex: 1
        }
      },
      theme: 'material',
      legend: {
        position: 'top'
      },
      height: 300
    };

    var awsPerBulan = new google.visualization.LineChart(document.getElementById('awsPerbulan'));
    awsPerBulan.draw(dataAwsPerBulan, optionsAwsPerBulan);
    //Aws Perbulann--
  }  
  $(window).resize(function() {
    drawStuff();
  });
</script>