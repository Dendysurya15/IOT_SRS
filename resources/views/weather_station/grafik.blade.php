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
        <p style="color:grey">Pilih filter data yang akan ditampilkan, adapun default parameter yaitu <i>Curah Hujan
          </i> </p>
        <div class="row">
          <div class="col-2">
            <select name="" id="lokasi" class="form-control">
              <option value="" selected disabled>Pilih Lokasi</option>
              @foreach ($listLoc as $key => $list)
              <option value="{{$list}}">{{$list}}</option>
              @endforeach
            </select>
          </div>
          <div class="col-2">
            <select name="" id="params" class="form-control">
              <option value="" selected disabled>Parameter AWS</option>
              <option value="Curah Hujan">Curah Hujan ()</option>
              <option value="Temperatur">Temperatur ()</option>
              <option value="Kelembaban">Kelembaban ()</option>
              <option value="UV">UV ()</option>
              <option value="Radiasi Matahari">Radiasi Matahari ()</option>
              <option value="Kecepatan Angin">Kecepatan Angin ()</option>
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
    <div class="container-fluid">
      <div class="card">
        <div class="card-header">
          <h2 class="text-center">Weather Station Dashboard</h2>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-6">
              <div class="card mb-3">
                <div class="card-header">
                  <h4 class="card-title"><i class="fas fa-clock"></i> Hourly Trends</h4>
                </div>
                <div class="card-body">
                  <canvas id="hourlyChart" width="400" height="200"></canvas>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="card mb-3">
                <div class="card-header">
                  <h4 class="card-title"><i class="fas fa-calendar-alt"></i> Monthly Trends</h4>
                </div>
                <div class="card-body">
                  <canvas id="monthlyChart" width="400" height="200"></canvas>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
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
  // Declare the chart variable outside the function
</script>