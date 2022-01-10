@include('layout.header')

<div class="content-wrapper">
    <section class="content-header">
        <div class="content-fluid ">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 pl-2 text-dark">
                        AWS
                    </h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-sm-5">
                                    <h1 class="m-0 text-primary">
                                        DATA AWS
                                    </h1>
                                </div>
                                <form class="col-sm-7" action="{{ url('/filltabel') }}" method="post">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="form-group float-sm-right col-md-5">
                                            <label>Tanggal Mulai :</label>
                                            <input class="form-control" type="date" name="tglMulai">
                                            @if(session('error_select'))
                                            @if ($errors->has('tglMulai'))
                                            <span class="text-danger">{{ $errors->first('tglMulai') }}</span>
                                            @endif
                                            @endif
                                        </div>
                                        <div class="form-group float-sm-right ml-3 col-md-5">
                                            <label>Tanggal Selesai :</label>
                                            <input class="form-control" type="date" name="tglSelesai">
                                            @if(session('error_select'))
                                            @if ($errors->has('tglSelesai'))
                                            <span class="text-danger">{{ $errors->first('tglSelesai') }}</span>
                                            @endif
                                            @endif
                                        </div>
                                        <div class="form-group float-sm-right ml-3" style="margin-top:4.5%;">
                                            <button type="submit" class="btn btn-primary"><i
                                                    class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card-body table-responsive">
                            <div style="margin-left: auto; margin-right: auto;">
                                <table class="table table-bordered table-hover text-center" id="rekapTaksasi">
                                    <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th style="width:15%;">WAKTU</th>
                                            <th>LOKASI</th>
                                            <th>SUHU UDARA ºC</th>
                                            <th>KELEMBABAN UDARA %</th>
                                            <th>KECEPATAN ANGIN</th>
                                            <th>ARAH ANGIN <i id="s_hum_in1" class="fas fa-compass"></i></th>
                                            <th>CURAH HUJAN</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($aws as $value)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <?php
                                                        $tanggal = date('H:i:s d-m-Y', strtotime($value['datetime']));
                                                    ?>
                                                {{ $tanggal }}
                                            </td>
                                            <td>{{ $value['loc'] }}</td>
                                            <td>{{ $value['t'] }} ºC</td>
                                            <td>{{ $value['h'] }} %</td>
                                            <td>{{ $value['ws'] }} m/s</td>
                                            <td>{{ $value['wc'] }}</td>
                                            <td>{{ $value['r'] * $value['rain_cal'] }} mm</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
@include('layout.footer')

<script>
    var judul = 'DATA AWS';
    $(function() {
        $('#rekapTaksasi').DataTable({
            "searching": false,
            dom: 'Bfrtip',
            buttons: [{
                extend : 'excelHtml5',
                title   : judul
            }],
        });
    });
</script>