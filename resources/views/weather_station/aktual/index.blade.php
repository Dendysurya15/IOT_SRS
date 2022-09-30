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
                                    <div class="form-group col-md">
                                        <label for="inputEmail4">Tanggal</label>
                                        <input type="date" class="form-control" id="inputEmail4" name="tgl"
                                            placeholder="Email">
                                    </div>
                                    <div class="form-group col-md">
                                        <label for="inputEmail4">Jam</label>
                                        <input type="time" class="form-control" id="inputEmail4" name="time"
                                            placeholder="Email">
                                    </div>
                                    <div class="form-group col-md">
                                        <label for="inputPassword4">Curah Hujan (mm)</label>
                                        <input type="text" class="form-control" id="inputPassword4" name="ch"
                                            placeholder="65.7">
                                    </div>
                                    <div class="form-group col-md">
                                        <label for="inputAddress">Temperatur (C)</label>
                                        <input type="text" class="form-control" id="inputAddress" name="temp"
                                            placeholder="28.8">
                                    </div>
                                    <div class="form-group col-md">
                                        <label for="inputAddress2">Kelembaban (Hum)</label>
                                        <input type="text" class="form-control" id="inputAddress2" name="hum"
                                            placeholder="97.3">
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
              
              
          ]
      });
      
    });
</script>