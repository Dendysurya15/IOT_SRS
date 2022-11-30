@include('layout.header')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row m-2">
            <div class="card col-lg-12">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mb-4">
                                @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                                <h2>Input Aktual Kondisi Cuaca AWS Davis Batu Kotam</h2>
                            </div>
                            @if ($message = Session::get('success'))
                            {{-- @error('msg') --}}
                            <div id="boxAlert" style="">
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong> {{ $message }}</strong>

                                </div>
                            </div>
                            {{-- @enderror --}}
                            @endif
                            @if ($message = Session::get('error'))

                            <div id="boxAlert" style="">
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong> {{ $message }}</strong>

                                </div>
                            </div>

                            @endif
                            <form action="{{ route('aktualws.store') }}" method="POST">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label for="inputEmail4">Tanggal <span style="color: red">*</span> </label>
                                        <input type="date" class="form-control" id="inputEmail4" name="tgl"
                                            placeholder="Email" value="{{ old('tgl') }}">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="inputEmail4">Jam <span style="color: red">*</span> </label>
                                        <input type="time" class="form-control" id="inputEmail4" name="time"
                                            placeholder="Email" value="{{ old('time') }}">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="inputPassword4">Curah Hujan (mm) <span style="color: red">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="inputPassword4" name="ch"
                                            placeholder="65.7" value="{{ old('ch') }}">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="inputAddress">Temperatur (C) <span style="color: red">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="inputAddress" name="temp"
                                            placeholder="28.8" value="{{ old('temp') }}">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="inputAddress2">Kelembaban (%) <span style="color: red">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="inputAddress2" name="hum"
                                            placeholder="97.3" value="{{ old('hum') }}">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="inputAddress2">Arah Angin</label>
                                        <input type="text" class="form-control" id="inputAddress2" name="winddir"
                                            placeholder="NNW" value="{{ old('winddir') }}">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="inputAddress2">Kecepatan Angin (m/s)</label>
                                        <input type="text" class="form-control" id="inputAddress2" name="windspeed"
                                            placeholder="4.29" value="{{ old('windspeed') }}">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                        </form>


                    </div>

                </div>
            </div>
        </div>

        <div class="card col-lg-12">
            <div class="card-body">
                <div style="background: white;" class="pb-3">

                    <table class="table" id="yajra-datatable">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Curah Hujan (mm)</th>
                            <th>Temperatur (C)</th>
                            <th>Kelembaban (%)</th>
                            <th>Arah Angin </th>
                            <th>Kecepatan Angin (m/s)</th>
                            {{-- <th>Action</th> --}}
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- /.content -->
</div>
@include('layout.footer')

<script type="text/javascript">
    $(function () {
      var table = $('#yajra-datatable').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('aktual.db') }}",
          columns: [
            {data: 'id', name: 'id', title: 'No' },
              {data: 'datetime', name: 'datetime',title: 'Tanggal'},
              {data: 'rain_fall_real', name: 'rain_fall_real', title:'Curah Hujan (mm)'},
              {data: 'temp_real', name: 'temp_real', title :'Temperatur (C)'},
              {data: 'hum_real', name: 'hum_real', title : 'Kelembaban (%)'},
              {data: 'wind_direction_real', name: 'wind_direction_real', title : 'Arah Angin'},
              {data: 'wind_speed_real', name: 'wind_speed_real', title : 'Kecepatan Angin (m/s)'},
          ]
      });
      
    });
</script>