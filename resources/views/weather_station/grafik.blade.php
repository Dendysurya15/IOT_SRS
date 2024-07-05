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

                {{csrf_field()}}
                <input type="date" class="form-control" name="tgl" id="inputDate">
              </div>
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
      </div>
    </div>
    <div class="container-fluid">
      <div class="card p-4">
        <div class="row">
          <div class="col-2">
            <select name="" id="estatech" class="form-control" onchange="getAfdeling(this.value)">
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
            <input type="date" class="form-control" name="tgl" id="tanggalaws">
          </div>
        </div>
        <div class="col-lg-12">
          <div class="card mb-3">
            <div class="card-header bg-success">
              <h4 class="card-title"><i class="fas fa-clock"></i> Grafik <span id="paramsSelected"></span> Selama 30 Hari Terakhir</h4>
            </div>
            <div class="card-body">
              <div id="chart_curah"></div>
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
  // Function to handle AJAX request and update chart24hour
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
        update24HourChart(data);
      },
      error: function(xhr, status, error) {
        console.error(error);
      }
    });
  }

  // Update the 24-hour chart
  function update24HourChart(data) {
    var arrResult = JSON.parse(data);
    var arrData = arrResult['data'];
    var arrJam = arrResult['jam'];
    var paramsSelect = arrResult['params'];

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
    }]);
  }

  // Initialize the 24-hour chart
  var chart24hour = new ApexCharts(document.querySelector("#id_chart_24_hour"), {
    series: [{
      name: '',
      data: ''
    }],
    chart: {
      background: '#ffffff',
      height: 350,
      type: 'area'
    },
    colors: ['#6897bb'],
    stroke: {
      curve: 'smooth'
    },
    xaxis: {
      type: 'string',
      categories: ''
    }
  });
  chart24hour.render();

  // Function to handle afdeling selection and update curah hujan chart
  function getAfdeling(estateId) {
    $.ajax({
      url: '/get-afdlist',
      type: 'GET',
      data: {
        estate_id: estateId
      },
      success: function(response) {
        updateAfdelingOptions(response);
        if (response.length > 0) {
          handlecurahhujan(estateId, response[0].id, $('#tanggalaws').val());
        }
      },
      error: function(xhr) {
        console.error(xhr.responseText);
      }
    });
  }

  // Update afdeling dropdown options
  function updateAfdelingOptions(response) {
    var afdelingSelect = $('#afdeling');
    afdelingSelect.empty();
    response.forEach(function(item) {
      var option = $('<option></option>').val(item.id).text(item.nama);
      afdelingSelect.append(option);
    });
  }

  // Function to handle curah hujan chart update
  function handlecurahhujan(estate, afdeling, tanggal) {
    if (afdeling) {
      $.ajax({
        url: '/get-datacurahhujan',
        type: 'GET',
        data: {
          estate: estate,
          afd: afdeling,
          date: tanggal
        },
        success: function(result) {
          updateCurahHujanChart(result);
        },
        error: function(xhr) {
          console.error(xhr.responseText);
        }
      });
    }
  }

  // Update the curah hujan chart
  function updateCurahHujanChart(result) {
    var parseResult = JSON.parse(result);
    var category = parseResult['category'];
    var curahhujan_val = parseResult['curahhujan_val'];

    chart30days.updateSeries([{
      name: 'Curah Hujan',
      data: curahhujan_val
    }]);

    chart30days.updateOptions({
      xaxis: {
        categories: category,
        markers: {
          size: 0
        }
      }
    });
  }

  // Initialize the 30-days chart
  var chart30days = new ApexCharts(document.querySelector("#chart_curah"), {
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
      enabled: true
    },
    plotOptions: {
      bar: {
        distributed: true
      }
    },
    colors: ['#61cdfc'],
    stroke: {
      curve: 'smooth'
    },
    xaxis: {
      labels: {
        rotate: -50,
        rotateAlways: true
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
          text: new Date().toLocaleDateString('en-US', {
            day: 'numeric',
            month: 'short',
            year: 'numeric'
          })
        }
      }]
    }
  });
  chart30days.render();

  // Document ready function to initialize default values and event listeners
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
      var currentParams = $(this).val();
      handleAjaxRequest($('#lokasiDevice').val(), currentParams, currentDate);
    });

    $('#inputDate').on('change', function() {
      var currentDate = $(this).val();
      handleAjaxRequest($('#lokasiDevice').val(), $('#params').val(), currentDate);
    });

    $('#tanggalaws').val(currentDate);
    var defaultcurah = $('#estatech option:first').val();
    getAfdeling(defaultcurah);
    handlecurahhujan(defaultcurah, $('#afdeling option:first').val(), currentDate);

    $('#estatech').on('change', function() {
      var selectedValue = $(this).val();
      getAfdeling(selectedValue);
    });
    $('#afdeling').on('change', function() {
      var selectedEstate = $('#estatech').val();
      var tanggal = $('#tanggalaws').val();
      handlecurahhujan(selectedEstate, $(this).val(), tanggal);
    });

    $('#tanggalaws').on('change', function() {
      var selectedEstate = $('#estatech').val();
      var selectedAfdeling = $('#afdeling').val();
      handlecurahhujan(selectedEstate, selectedAfdeling, $(this).val());
    });
  });
</script>