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
    <div class="container-fluid">
      <div class="card p-4">
        <div class="row">
          <div class="col-8">
            <div class="d-flex justify-content-between align-items-center">
              <h4 class="mb-0">Filter Grafik</h4>

            </div>
            <p style="color: grey">Pilih filter data yang akan ditampilkan dalam 30 hari terakhir, adapun default parameter yaitu <i>Curah
                Hujan</i></p>
            <div class="row">
              <div class="col-2">
                <select name="" id="estate" class="form-control" onchange="getAfdeling()">
                  @foreach($estate as $key => $items)
                  <option value="{{ $items['id'] }}">{{ $items['nama'] }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-2">
                <select name="" id="afdeling" class="form-control">
                </select>
              </div>
              <div class="col-2">
                {{csrf_field()}}
                <input type="date" class="form-control" name="tgl" id="tanggalaws" onchange="getdata()">
              </div>
            </div>
          </div>
          <div class="col-lg-12">
            <div class="card mb-3">
              <div class="card-header bg-success">
                <h4 class="card-title"><i class="fas fa-clock"></i> Grafik <span id="paramsSelected"></span> Selama 30 Hari Terakhir
                </h4>
              </div>
              <div class="card-body">

                <div id="chart_curah"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
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

    $.ajax({


      url: '{{ route("get_data_24hour") }}',
      type: 'GET',
      data: {
        loc: selectedValue,
        params: paramsValue,
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
      name: '',
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
  var today = new Date();
  var options = {
    day: 'numeric',
    month: 'short',
    year: 'numeric'
  };
  var todayFormatted = today.toLocaleDateString('en-US', options);
  var options2 = {
    series: [{
      name: '',
      data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
    }],
    chart: {
      background: '#ffffff',
      height: 300,
      type: 'area',
      toolbar: {
        show: false
      }
    },
    dataLabels: {
      enabled: true // disable data labels
    },
    plotOptions: {
      bar: {
        distributed: true
      }
    },

    colors: [
      '#61cdfc',
    ],

    stroke: {
      curve: 'smooth'
    },
    xaxis: {
      labels: {
        rotate: -50,
        rotateAlways: true,
      },
      type: '',
      categories: ['test']
    },
    annotations: {
      xaxis: [{
        x: '00:00',
        strokeDashArray: 0,
        borderColor: '#f44336',
        label: {
          borderColor: '#f44336',

          style: {
            color: '#fff',
            background: '#f44336',
            fontSize: '14px'
          },
          text: todayFormatted,
        }
      }]
    },
  };
  var chart30days = new ApexCharts(document.querySelector("#chart_curah"), options2);
  chart30days.render();


  function getAfdeling() {
    var estateId = $('#estate').val();

    // AJAX request to get afdeling options
    $.ajax({
      url: '/get-afdlist',
      type: 'GET',
      data: {
        estate_id: estateId
      },
      success: function(response) {
        var afdelingSelect = $('#afdeling');
        afdelingSelect.empty();

        response.forEach(function(item) {
          var option = $('<option></option>').val(item.id).text(item.nama);
          afdelingSelect.append(option);
        });

        // Fetch data based on the first afdeling option if available
        if (response.length > 0) {
          afdelingSelect.val(response[0].id);
          getdata(); // Call getdata after afdeling options are populated
        }
      },
      error: function(xhr) {
        console.error(xhr.responseText);
      }
    });
  }

  function getdata() {
    var estate = $('#estate').val();
    var afd = $('#afdeling').val();
    var date = $('#tanggalaws').val();
    // console.log(afd);
    // Only make the AJAX request if afdeling is not null
    if (afd) {
      // AJAX request to get data
      $.ajax({
        url: '/get-datacurahhujan',
        type: 'GET',
        data: {
          estate: estate,
          afd: afd,
          date: date
        },
        success: function(result) {
          var parseResult = JSON.parse(result)
          var category = parseResult['category']
          var curahhujan_val = parseResult['curahhujan_val']

          chart30days.updateSeries([{
            name: 'Curah Hujan',
            data: curahhujan_val
          }]);

          // If ktg is an array, you can use it for x-axis categories
          chart30days.updateOptions({
            xaxis: {
              categories: category,
              markers: {
                size: 0,
              }
            },

          });

        },
        error: function(xhr) {
          console.error(xhr.responseText);
        }
      });
    }
  }


  $(document).ready(function() {
    var defaultSelectedLocValue = $('#lokasiDevice option:first').val();
    var defaultSelectedParamsValue = $('#params option:first').val();
    var currentDate = new Date().toISOString().split('T')[0];

    $('#inputDate').val(currentDate);
    handleAjaxRequest(defaultSelectedLocValue, defaultSelectedParamsValue, currentDate);

    $('#lokasiDevice').on('change', function() {
      var selectedValue = $(this).val();
      handleAjaxRequest(selectedValue, defaultSelectedParamsValue, currentDate);
    });

    $('#params').on('change', function() {
      currentParams = $(this).val(); // Update currentDate when the date changes

      handleAjaxRequest($('#lokasiDevice').val(), currentParams, currentDate);
    });

    $('#inputDate').on('change', function() {
      currentDate = $(this).val();

      handleAjaxRequest($('#lokasiDevice').val(), $('#params').val(), currentDate);
    });
    var dateInput = $('#tanggalaws');
    if (!dateInput.val()) {
      var today = new Date().toISOString().split('T')[0];
      dateInput.val(today);
    }

    // Fetch afdeling options on page load
    getAfdeling();


  })
</script>