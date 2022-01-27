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
            <div class="card-header" ">
                            <div class=" card-title">
              <i class="fas fa-water pr-2"></i>Water Level {{$listLoc[Request()->id ?: $defaultId]}}, Hari
              ini
              {{$dateToday}}
            </div>
            <div class="float-right">
              <div class="list-inline">
                {{-- <h5 class="list-inline-item">Lokasi</h5> --}}
                <form class="list-inline-item col-md-5" action="{{ route('grafik_wl') }}" method="get">
                  <select name="id" class="form-control-sm" onchange="this.form.submit()">
                    <option value="" selected disabled>Pilih Lokasi</option>
                    @foreach ($listLoc as $key => $list)
                    <option value="{{$key}}">{{$list}}</option>
                    @endforeach
                  </select>
                </form>
              </div>
            </div>

          </div>
          <div class="card-body">

            <div class="chart" id="wlPerhariini">
            </div>

          </div><!-- /.card-body -->
        </div><!-- Curah Hujan -->


        <!-- Curah Hujan -->
        <div class="card card-cyan">
          <div class="card-header">
            <div class=" card-title">
              <i class="fas fa-water pr-2"></i>Water Level {{$listLoc[Request()->id ?: $defaultId]}}
              Minggu ini
            </div>
            <div class="float-right">

            </div>
          </div>
          <div class="card-body">
            <div class="chart" id="wlPerminggu">
            </div>
          </div><!-- /.card-body -->
        </div><!-- Curah Hujan -->

        <!-- Curah Hujan -->
        <div class="card card-purple">
          <div class="card-header">
            <div class=" card-title">
              <i class="fas fa-water pr-2"></i>Water Level {{$listLoc[Request()->id ?: $defaultId]}}
              Bulan ini
            </div>
            <div class="float-right">

            </div>
          </div>
          <div class="card-body">

            <div class="chart" id="wlPerbulan">
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
<script src="{{ asset('/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('/plugins/chart.js/Chart.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('/js/demo.js') }}"></script>

<script src="{{ asset('/js/loader.js') }}"></script>

<script type="text/javascript">
  google.charts.load('current', {
    'packages': ['corechart']
  });
  google.charts.setOnLoadCallback(drawChart);

  function drawChart() {  
    
    //perhari
    var plotlvl_in = '<?php echo $arrWlPerhariiniView['plot1']; ?>';
    var plotlvl_out = '<?php echo $arrWlPerhariiniView['plot2']; ?>';
    var plotlvl_act = '<?php echo $arrWlPerhariiniView['plot3']; ?>';
    var avgLvlAct = '<?php echo $avgLvlActHariIni; ?>'
    

    var dataWlPerHariIni = new google.visualization.DataTable();
    dataWlPerHariIni.addColumn('string', 'Name');
    dataWlPerHariIni.addColumn('number', plotlvl_in);
    dataWlPerHariIni.addColumn('number', plotlvl_out);

    if(avgLvlAct != 0){
    dataWlPerHariIni.addColumn('number', plotlvl_act);
    }

    dataWlPerHariIni.addRows([
      <?php echo $arrWlPerhariiniView['data']; ?>
    ]);

    var optionsWlPerHariIIni = {
      chartArea: {},
      theme: 'material',
        legend: {
            position: 'top',
      },
      height: 300,
     
    };

    var arrWlPerhariiniView = new google.visualization.LineChart(document.getElementById('wlPerhariini'));
    arrWlPerhariiniView.draw(dataWlPerHariIni,optionsWlPerHariIIni );
   
 
 //perminggu
    var plotlvl_in_minggu = '<?php echo $arrWlPermingguView['plot1']; ?>';
    var plotlvl_out_minggu = '<?php echo $arrWlPermingguView['plot2']; ?>';
    var plotlvl_act_minggu = '<?php echo $arrWlPermingguView['plot3']; ?>';

    var dataWlPerMinggu = new google.visualization.DataTable();
    dataWlPerMinggu.addColumn('string', 'Name');
    dataWlPerMinggu.addColumn('number', plotlvl_in_minggu);
    dataWlPerMinggu.addColumn('number', plotlvl_out_minggu);
    dataWlPerMinggu.addColumn('number', plotlvl_act_minggu);
    dataWlPerMinggu.addRows([
      <?php echo $arrWlPermingguView['data']; ?>
    ]);

    var optionsWlPerHariIMinggu = {
      chartArea: {},
      theme: 'material',
        legend: {
            position: 'top',
      },
      colors:['#027E91', '#6FC6B9', '#E6631C'],
      height: 300
    };       
   
    var arrWlPermingguView = new google.visualization.ColumnChart(document.getElementById('wlPerminggu'));
    arrWlPermingguView.draw(dataWlPerMinggu,optionsWlPerHariIMinggu );


    //perbulan
    var plotlvl_in_bulan= '<?php echo $arrWlPerbulanView['plot1']; ?>';
    var plotlvl_out_bulan= '<?php echo $arrWlPerbulanView['plot2']; ?>';
    var plotlvl_act_bulan= '<?php echo $arrWlPerbulanView['plot3']; ?>';
    
    var dataWlPerbulan= new google.visualization.DataTable();
    dataWlPerbulan.addColumn('string', 'Name');
    dataWlPerbulan.addColumn('number', plotlvl_in_minggu);
    dataWlPerbulan.addColumn('number', plotlvl_out_minggu);
    dataWlPerbulan.addColumn('number', plotlvl_act_minggu);
    dataWlPerbulan.addRows([
      <?php echo $arrWlPerbulanView['data']; ?>
    ]);

    var optionsWlPerHariIbulan= {
      chartArea: {},
      theme: 'material',
        legend: {
            position: 'top',
      },
      colors:['#1B9E77', '#D95F02', '#7570B3'],
      height: 300,
      
    };       
   
    var arrWlPerbulanView = new google.visualization.LineChart(document.getElementById('wlPerbulan'));
    arrWlPerbulanView.draw(dataWlPerbulan,optionsWlPerHariIbulan );

  }  
  $(window).resize(function() {
    drawStuff();
  });
</script>