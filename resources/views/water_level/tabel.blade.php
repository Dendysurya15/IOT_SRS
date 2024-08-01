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
                                            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
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

                                        <!-- @foreach($data as $value)
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
                                        @endforeach -->
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <div class="mr-3">
                                    <label for="monthFilter" class="mr-2">Bulan:</label>
                                    <input id="monthFilter" class="form-control" type="month" name="tglMulai">
                                </div>
                                <div>
                                    <label for="locationFilter" class="mr-2">Lokasi:</label>
                                    <select id="locationFilter" name="location" class="form-control">
                                        @foreach ($listLoc as $key => $list)
                                        <option value="{{$key}}">{{$list}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="card-body table-responsive">
                            <div style="margin-left: auto; margin-right: auto;">
                                <h1>Data Perbulan</h1>
                                <table class="table table-bordered table-hover text-center" id="databulan">
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
                                    <tbody id="dataperbulan">

                                    </tbody>
                                </table>
                            </div>
                            <div style="margin-left: auto; margin-right: auto;">
                                <h1>Data Rekap Perbulan</h1>
                                <table class="table table-bordered table-hover text-center" style="width: 100%;" id="rekapperbulan">
                                    <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th>Idwl</th>
                                            <th style="width:15%;">Waktu</th>
                                            <th>Avarage Level In</th>
                                            <th>Avarage Level Out</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                        <script>
                            $(document).ready(function() {
                                var now = new Date();
                                var month = (now.getMonth() + 1).toString().padStart(2, '0');
                                var year = now.getFullYear();
                                var defaultValue = year + '-' + month;
                                $('#monthFilter').val(defaultValue);

                                function fetchData() {
                                    var month = $('#monthFilter').val();
                                    var location = $('#locationFilter').val();
                                    if ($.fn.DataTable.isDataTable('#rekapperbulan')) {
                                        $('#rekapperbulan').DataTable().destroy();
                                    }
                                    if ($.fn.DataTable.isDataTable('#databulan')) {
                                        $('#databulan').DataTable().destroy();
                                    }
                                    $.ajax({
                                        url: '/waterlevelperbulan',
                                        method: 'GET',
                                        data: {
                                            month: month,
                                            location: location
                                        },
                                        success: function(response) {
                                            let datarekap = response.datarekap;
                                            var transformedData = Object.values(datarekap);
                                            let data = response.data;
                                            var transformedData_data = Object.values(data);
                                            // console.log(transformedData_data);
                                            let inc = 1;
                                            var dataTableAncakTest = $('#rekapperbulan').DataTable({
                                                columns: [{
                                                        data: null,
                                                        render: function(data, type, row, meta) {
                                                            return meta.row + 1; // Return the row number
                                                        }
                                                    },
                                                    {
                                                        data: 'idwl'
                                                    },
                                                    {
                                                        data: 'hour'
                                                    },
                                                    {
                                                        data: 'avarage_in'
                                                    },
                                                    {
                                                        data: 'avarage_out'
                                                    }
                                                ],
                                                dom: 'B<"top"lf>rtip',
                                                buttons: ['excel', 'pdf'],
                                                lengthMenu: [
                                                    [10, 20, 50, -1],
                                                    [10, 20, 50, "All"]
                                                ]
                                            });

                                            dataTableAncakTest.clear().rows.add(transformedData).draw();
                                            var datadua = $('#databulan').DataTable({
                                                columns: [{
                                                        data: null,
                                                        render: function(data, type, row, meta) {
                                                            return meta.row + 1; // Return the row number
                                                        }
                                                    },
                                                    {
                                                        data: 'idwl'
                                                    },
                                                    {
                                                        data: 'datetime'
                                                    },
                                                    {
                                                        data: 'lvl_in'
                                                    },
                                                    {
                                                        data: 'lvl_out'
                                                    },
                                                    {
                                                        data: 'lvl_act'
                                                    }
                                                ],
                                                dom: 'B<"top"lf>rtip',
                                                buttons: ['excel', 'pdf'],
                                                lengthMenu: [
                                                    [10, 20, 50, -1],
                                                    [10, 20, 50, "All"]
                                                ]
                                            });

                                            datadua.clear().rows.add(transformedData_data).draw();

                                        },
                                        error: function(xhr) {
                                            console.error('Error:', xhr);
                                        }
                                    });
                                }

                                $('#monthFilter').change(fetchData);
                                $('#locationFilter').change(fetchData);

                                // Call fetchData() immediately to make a request when the page loads
                                fetchData();
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>
@include('layout.footer')

<script>
    var judul = 'DATA AWS';

    var data = @json($data);
    // console.log(data);

    var iotTable = $('#rekapWaterLevel').DataTable({
        columns: [{
                title: 'ID',
                data: 'id'
            },
            {
                title: 'id WL',
                data: 'idwl'
            },
            {
                title: 'Waktu',
                data: 'datetime',

            },

            {
                title: 'Level In',
                data: 'lvl_in'
            },
            {
                title: 'Level Out',
                data: 'lvl_out'
            },
            {
                title: 'Level Aktual',
                data: 'lvl_act'
            }
        ],
    });

    iotTable.clear().rows.add(data).draw();

    // $(function() {
    //     $('#rekapWaterLevel').DataTable({
    //         "searching": true,
    //         dom: 'Bfrtip',
    //         buttons: [{
    //             extend: 'excelHtml5',
    //             title: judul
    //         }],
    //     });
    // });
</script>