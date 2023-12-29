@include('layout.header')
<style>
  .empty-field {
    border: 2px solid red;
  }
</style>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
  </section>

  <!-- Main content -->
  <section class="content">

    <div class="container-fluid">
      <div class="card p-4">
        <div class="row">
          <div class="col-8">
            <div class="d-flex justify-content-between align-items-center">
              <h4 class="mb-0">Filter Grafik</h4>

            </div>
            <p style="color: grey">Pilih filter data yang akan ditampilkan, adapun default parameter yaitu <i>Curah
                Hujan</i></p>
            <div class="row">
              <div class="col-2">
                <select name="" id="lokasiDevice" class="form-control">
                  @foreach($listStation as $key => $loc)
                  <option value="{{ $loc }}">{{ $loc }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-2">
                <select name="" id="params" class="form-control">

                  <option value="rain_rate">Curah Hujan </option>
                  <option value="temp_out">Temperatur </option>
                  <option value="hum_out">Kelembaban </option>
                  <option value="uv">UV </option>
                  <option value="solar_radiation">Radiasi Matahari </option>
                  <option value="windspeedkmh">Kecepatan Angin </option>
                </select>
              </div>
              <div class="col-2">
                {{-- <input class="form-control col-md-2" type="date" name="tgl"> --}}
                {{csrf_field()}}
                <input type="date" class="form-control" name="tgl" id="inputDate">
              </div>
              {{-- <div class="col-4">
                <button type="button" class="btn btn-primary mr-2" onclick="getSelectedValues()">Filters</button>
                <button type="button" class="btn btn-danger" onclick="resetForm()">Reset</button>
              </div> --}}
            </div>
          </div>

        </div>
      </div>
    </div>






    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="card mb-3">
            <div class="card-header bg-success">
              <h4 class="card-title"><i class="fas fa-clock"></i> Grafik <span id="paramsSelected"></span> Selama 24 jam
              </h4>
            </div>
            <div class="card-body">

              <div id="id_chart_24_hour"></div>
            </div>
          </div>
        </div>
        {{-- <div class="col-lg-6">
          <div class="card mb-3">
            <div class="card-header">
              <h4 class="card-title"><i class="fas fa-calendar-alt"></i> Monthly Trends</h4>
            </div>
            <div class="card-body">
              <canvas id="monthlyChart" width="400" height="200"></canvas>
            </div>
          </div>
        </div> --}}
      </div>
      {{-- <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title"><i class="fas fa-info-circle"></i> Latest Weather Info</h4>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-3">
                  <p>Temperature: <strong>30.78°C</strong></p>
                  <p>Humidity: <strong>76%</strong></p>
                  <!-- Add more weather parameters here -->
                </div>
                <div class="col-md-9">
                  <!-- Additional data or charts can go here -->
                </div>
              </div>
            </div>
          </div>
        </div>
      </div> --}}
    </div>


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
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script type="text/javascript">
  function handleAjaxRequest(selectedValue, paramsValue, currentDate) {
    console.log(selectedValue, paramsValue, currentDate)
$.ajax({

    
    url: '{{ route("get_data_24hour") }}',
    type: 'GET',
    data: {
        loc: selectedValue,
        params : paramsValue,
        tgl: currentDate
    },
    success: function(data) {

        arrResult = JSON.parse(data)

        var arrData = arrResult['data']
        var arrJam = arrResult['jam']
        var paramsSelect = arrResult['params']


        
        var iconElement = document.getElementById('paramsSelected');
        iconElement.textContent = paramsSelect;
        
        chart24hour.updateOptions({
                    xaxis: {
                        categories: arrJam
                    }
                });


        chart24hour.updateSeries([{
            name: paramsSelect,
            data: arrData

        }])
     
    },
    error: function(xhr, status, error) {
        console.error(error);
    }
});
}



var options = {

series: [{
    name:'',
    data: ''
}],
chart: {
    background: '#ffffff',
    height: 350,
    type: 'area'
},


colors: [
    '#6897bb',
],

stroke: {
    curve: 'smooth'
},
xaxis: {
    type: 'string',
    categories: ''
}
};

var chart24hour = new ApexCharts(document.querySelector("#id_chart_24_hour"), options);
    chart24hour.render();


  $(document).ready(function() {
    var defaultSelectedLocValue = $('#lokasiDevice option:first').val();
    var defaultSelectedParamsValue = $('#params option:first').val();
    var currentDate = new Date().toISOString().split('T')[0];
    
    $('#inputDate').val(currentDate);
    handleAjaxRequest(defaultSelectedLocValue, defaultSelectedParamsValue, currentDate);

    $('#lokasiDevice').on('change', function() {
            var selectedValue = $(this).val();
            handleAjaxRequest(selectedValue,defaultSelectedParamsValue, currentDate);
        });

        $('#params').on('change', function() {
            currentParams = $(this).val(); // Update currentDate when the date changes

            handleAjaxRequest($('#lokasiDevice').val(), currentParams, currentDate);
        });

        $('#inputDate').on('change', function() {
          currentDate = $(this).val(); 

          handleAjaxRequest($('#lokasiDevice').val(), $('#params').val(), currentDate);
        });
  })
</script>