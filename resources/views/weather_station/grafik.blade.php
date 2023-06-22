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

    <div class="card p-3">
      <h4>Filter Grafik </h4>
      <p style="color:grey">Pilih filter data yang akan ditampilkan, adapun default parameter yaitu <i>Curah Hujan </i> </p>
      <div class="row">
      <div class="col-2">
      <select name="" id="lokasi"  class="form-control">
            <option value="" selected disabled>Pilih Lokasi</option>
            @foreach ($listLoc as $key => $list)
            <option value="{{$list}}">{{$list}}</option>
            @endforeach
          </select>
        </div>
        <div class="col-2">
      <select name="" id="params"  class="form-control">
              <option value=""  selected disabled>Parameter AWS</option>
              <option  value="Curah Hujan">Curah Hujan ()</option>
              <option  value="Temperatur">Temperatur ()</option>
              <option  value="Kelembaban">Kelembaban ()</option>
              <option  value="UV">UV ()</option>
              <option  value="Radiasi Matahari">Radiasi Matahari ()</option>
              <option  value="Kecepatan Angin">Kecepatan Angin ()</option>
            </select>
          </div>  
          <div class="col-2">
            <input type="date" id="tanggal" class="form-control">
          </div>  
         
          <button type="button" class="btn btn-primary mr-2" onclick="getSelectedValues()">Filters</button>
          <button type="button" class="btn btn-danger" onclick="resetForm()">Reset</button>
          </div>
        </div>
       
      </div>
   
 
     
      <div class="resultDiv" style="display:none">
      <div class="row">
        <div class="col">
          <div class="card card-green">
            <div class="card-header">
              <h3 class="card-title">
                <i class="fas fa-wind pr-2"></i> <span id="cardResult1"></span> dalam 24 jam terakhir pada <span id='day'></span>
              </h3>
              <div class="row float-sm-right">
              </div>
            </div>
            <div class="card-body">
            <div class="col">
            <div id="graphCard1" ></div>
          </div>
            </div>
          </div>

        </div>
      </div>

      <div class="row">
        <div class="col">
          <!-- Curah Hujan -->
        
          <div class="card card-green">
            <div class="card-header">
              <h3 class="card-title">
                <i class="fas fa-wind pr-2"></i><span id="cardResult2"></span> dalam seminggu terakhir dari  <span id='startWeek' class="font-weight-bold"></span> hingga <span id='endWeek' class="font-weight-bold"></span>
              </h3>
              <div class="row float-sm-right">
              </div>
            </div>
            <div class="card-body">
              <div class="col">

              <div id="graphCard2" ></div>
              </div>
            </div><!-- /.card-body -->
          </div><!-- Curah Hujan -->

        </div>
      </div>

      <div class="row">
        <div class="col">
          <!-- Curah Hujan -->
        
          <div class="card card-green">
            <div class="card-header">
              <h3 class="card-title">
                <i class="fas fa-wind pr-2"></i><span id="cardResult3"></span> dalam 1 bulan terakhir pada <span id="monthYear" class="font-weight-bold"></span>
              </h3>
              <div class="row float-sm-right">
              </div>
            </div>
            <div class="card-body">
             <div class="col">
             <div id="graphCard3" ></div>
             </div>
            </div><!-- /.card-body -->
          </div><!-- Curah Hujan -->

        </div>
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
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script type="text/javascript">
  // Declare the chart variable outside the function
  var chart1;
  var chart2;
  var chart3;

 function getSelectedValues() {
  // Retrieve the selected values
  var lokasiValue = document.getElementById("lokasi").value;
  var paramsValue = document.getElementById("params").value;
  var tanggalValue = document.getElementById("tanggal").value;
  var _token = $('input[name="_token"]').val();

  var givenDate = new Date(tanggalValue); // Replace with your desired date

  // Find the starting date (Sunday) of the week
  var startingDate = new Date(givenDate);
  startingDate.setDate(givenDate.getDate() - givenDate.getDay());

  // Find the ending date (Saturday) of the week
  var endingDate = new Date(givenDate);
  endingDate.setDate(givenDate.getDate() + (6 - givenDate.getDay()));

  // Format the dates as YYYY-MM-DD strings
  var optionsWeek = { weekday: 'long', day: 'numeric', month: 'short', year: 'numeric', timeZone: 'Asia/Jakarta' };
  var optionMonthYear = {  month: 'long', year: 'numeric', timeZone: 'Asia/Jakarta' };
  var optionDay = { day: 'numeric',  month: 'long', year: 'numeric', timeZone: 'Asia/Jakarta' };
  var varMonthYear = givenDate.toLocaleDateString('id-ID', optionMonthYear);
  var varDay = givenDate.toLocaleDateString('id-ID', optionDay);
  var startingDateStr = startingDate.toLocaleDateString('id-ID', optionsWeek);
  var endingDateStr = endingDate.toLocaleDateString('id-ID', optionsWeek);
// Reset the field highlighting
resetFieldHighlighting();
  if (lokasiValue !== "" && paramsValue !== "" && tanggalValue !== "") {
    
    $.ajax({
    url: "{{ route('generateDataGrafik') }}", // Replace with your Laravel route URL
    method: "GET",
    data: {
      lokasi: lokasiValue,
      params: paramsValue,
      tanggal: tanggalValue,
      tglAwalMinggu: startingDateStr,
      tglAkhirMinggu: endingDateStr,
      bulan : varMonthYear,
      _token: _token
    },
    success: function(response) {
     
      // Handle the response from the server
      // console.log("Response:", response.arrResult.hari);
      var hour = Object.keys(response.arrResult.hari);
      var valDayResult = Object.values(response.arrResult.hari);

      var listDateWeek = Object.keys(response.arrResult.minggu);
      var valWeekResult = Object.values(response.arrResult.minggu);

      var listDateMonth = Object.keys(response.arrResult.bulan);
      var valMonthResult = Object.values(response.arrResult.bulan);


      // Example: Show the resultDiv
      document.querySelector('.resultDiv').style.display = 'block';

      // Example: Set the values to the cardResult elements
      document.getElementById("cardResult1").textContent = paramsValue;
      document.getElementById("cardResult2").textContent = paramsValue;
      document.getElementById("cardResult3").textContent = paramsValue;
      document.getElementById("startWeek").textContent = startingDateStr;
      document.getElementById("endWeek").textContent = endingDateStr;
      document.getElementById("monthYear").textContent = varMonthYear;
      document.getElementById("day").textContent = varDay;

    
      renderChart1(paramsValue, valDayResult, hour);
      renderChart2(paramsValue, valWeekResult, listDateWeek);
      renderChart3(paramsValue, valMonthResult, listDateMonth);

       

       
    },
    error: function(xhr, status, error) {
      // Handle the error response
      console.log("Error:", error);
    }
  });
  } else {
    if (lokasiValue === "") {
      document.getElementById("lokasi").classList.add("empty-field");
    }
    if (paramsValue === "") {
      document.getElementById("params").classList.add("empty-field");
    }
    if (tanggalValue === "") {
      document.getElementById("tanggal").classList.add("empty-field");
    }
    // alert("Please fill in all fields.");
  }
}
function resetForm() {
  // Clear the selected values
  document.getElementById("lokasi").value = "";
  document.getElementById("params").value = "";
  document.getElementById("tanggal").value = "";
  resetFieldHighlighting();
  // Hide the resultDiv
  document.querySelector('.resultDiv').style.display = 'none';
  chart.destroy();
  chart = null;
}

function resetFieldHighlighting() {
  // Remove the "empty-field" class from all fields
  var fields = document.querySelectorAll('.form-control');
  fields.forEach(function(field) {
    field.classList.remove("empty-field");
  });
}


function renderChart1(paramsValue, datas, categories){
  var options = {
          series: [{
            name: paramsValue,
            data:datas
        }],
          chart: {
          height: 350,
          type: 'area',
          zoom: {
            enabled: false
          }
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          curve: 'straight',
           width: 4,
        },
        grid: {
          row: {
            colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
            opacity: 0.5
          },
        },
        xaxis: {
          categories: categories,
        }
        };

        if (chart1) {
          // Update the chart data and categories
          chart1.updateSeries([{ name: paramsValue, data: datas }]);
          chart1.updateOptions({ 
            xaxis: { categories: categories },
            stroke: { width: 4 } // Adjust the line thickness as needed
          },true);
        } else {
          // Create a new chart instance
          chart1 = new ApexCharts(document.querySelector("#graphCard1"), options);
          chart1.render();
        }
}
function renderChart2(paramsValue, datas, categories){
  var options = {
          series: [{
            name: paramsValue,
            data:datas
        }],
          chart: {
          height: 350,
          type: 'area',
          zoom: {
            enabled: false
          }
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          curve: 'straight'
        },
        // title: {
        //   text: 'Product Trends by Month',
        //   align: 'left'
        // },
        grid: {
          row: {
            colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
            opacity: 0.5
          },
        },
        xaxis: {
          categories: categories,
        }
        };

        if (chart2) {
          // Update the chart data and categories
          chart2.updateSeries([{ name: paramsValue, data: datas }]);
          chart2.updateOptions({ xaxis: { categories: categories } });
        } else {
          // Create a new chart instance
          chart2 = new ApexCharts(document.querySelector("#graphCard2"), options);
          chart2.render();
        }
}
function renderChart3(paramsValue, datas, categories){
  var options = {
          series: [{
            name: paramsValue,
            data:datas
        }],
          chart: {
          height: 350,
          type: 'area',
          zoom: {
            enabled: false
          }
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          curve: 'straight'
        },
        // title: {
        //   text: 'Product Trends by Month',
        //   align: 'left'
        // },
        grid: {
          row: {
            colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
            opacity: 0.5
          },
        },
        xaxis: {
          categories: categories,
        }
        };

        if (chart3) {
          // Update the chart data and categories
          chart3.updateSeries([{ name: paramsValue, data: datas }]);
          chart3.updateOptions({ xaxis: { categories: categories } });
        } else {
          // Create a new chart instance
          chart3 = new ApexCharts(document.querySelector("#graphCard3"), options);
          chart3.render();
        }
}
</script>