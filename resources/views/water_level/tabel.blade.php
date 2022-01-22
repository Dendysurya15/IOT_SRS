@include('layout.header')

<div class="content-wrapper">
    <section class="content-header">
        <div class="content-fluid ">
            <div class="col-sm">
                <div class=" row ">
                    <div class="col-auto">
                        <h1 class="m-0 text-dark">
                            Water Level {{$listLoc[Request()->id ?: $defaultId]}}
                        </h1>
                    </div>
                    <div class="col-auto ml-auto">
                        <form class="" action="{{ route('tabel_wl') }}" method="get">
                            <select name="id" class="form-control-sm" onchange="this.form.submit()">
                                <option value="" selected disabled>Pilih Lokasi</option>
                                @foreach ($listLoc as $key => $list)
                                <option value="{{$key}}">{{$list}}</option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                    {{-- <h5 class="list-inline-item">Lokasi</h5> --}}
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
                                        Data Water Level
                                    </h1>
                                </div>
                                <form class="col-sm-7" action="{{ url('/filltabel') }}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="form-group float-sm-right col-md-5">
                                            <label>Tanggal Mulai :</label>
                                            <input class="form-control" type="date" name="tglMulai">
                                            {{-- @if(session('error_select'))
                                            @if ($errors->has('tglMulai')) --}}
                                            {{-- <span class="text-danger">{{ $errors->first('tglMulai') }}</span> --}}
                                            {{-- @endif
                                            @endif --}}
                                        </div>
                                        <div class="form-group float-sm-right ml-3 col-md-5">
                                            <label>Tanggal Selesai :</label>
                                            <input class="form-control" type="date" name="tglSelesai">
                                            {{-- @if(session('error_select'))
                                            @if ($errors->has('tglSelesai')) --}}
                                            {{-- <span class="text-danger">{{ $errors->first('tglSelesai') }}</span>
                                            --}}
                                            {{-- @endif
                                            @endif --}}
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
                                <table class="table table-bordered table-hover text-center" id="rekapWaterLevel">
                                    <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th>Idwl</th>
                                            <th style="width:15%;">Waktu</th>
                                            <th>Level In</th>
                                            <th>Level Out</th>
                                            <th>Level Aktual</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data as $value)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{$value['idwl']}}</td>
                                            <td>
                                                <?php
                                                        $tanggal = date('H:i:s d-m-Y', strtotime($value['datetime']));
                                                    ?>
                                                {{ $tanggal }}
                                            </td>
                                            <td>{{ $value['lvl_in'] }}</td>
                                            <td>{{ $value['lvl_out'] }}</td>
                                            <td>{{ $value['lvl_act'] }}</td>
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
        $('#rekapWaterLevel').DataTable({
            "searching": true,
            dom: 'Bfrtip',
            buttons: [{
                extend : 'excelHtml5',
                title   : judul
            }],
        });
    });
</script>