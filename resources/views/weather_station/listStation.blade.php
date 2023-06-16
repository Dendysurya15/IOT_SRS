@include('layout.header')

<style>
    a,
    a:hover,
    a:focus,
    a:active {
        text-decoration: none;
        color: inherit;
    }

    .inner {
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
    }

    .selectCard:hover {
        transform: scale(1.05);
        box-shadow: 0 10px 20px rgba(0, 0, 0, .12), 0 4px 8px rgba(0, 0, 0, .06);
    }

    .selectCard {
        border-radius: 4px;
        background: #fff;
        box-shadow: 0 6px 10px rgba(0, 0, 0, .08), 0 0 6px rgba(0, 0, 0, .05);
        transition: .3s transform cubic-bezier(.155, 1.105, .295, 1.12), .3s box-shadow, .3s -webkit-transform cubic-bezier(.155, 1.105, .295, 1.12);
        cursor: pointer;
    }
    
    th, td {
        text-align: center;
    }
</style>
</style>
<div class="content-wrapper">
    <section class="content">
        @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <!-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> -->
        </div>
        @endif
        @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <!-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> -->
        </div>
        @endif
        <br>
        <div class="container-fluid">

            <div class="row">
                <div class="col-md">
                    <div class="card cardHead">
                        <div class="card-body">
                            <div class="row">

                                <div class="col-sm-12">
                                    <h1 style="font-weight: bold;">Weather Station List</h1>
                                    <hr>
                                    <button type="button" class="btn btn-primary" style="margin-bottom: 1%; float: right;"
                                        data-toggle="modal" data-target="#insertModal"><i class="fa fa-plus fa-fw"></i>Tambah Data</button>

                                    <table id="stationList" class="table table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th style="width: 10%;">No</th>
                                                <th>Lokasi</th>
                                                <th>Flags</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $station)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$station->loc}}</td>
                                                <td>{{$station->flags}}</td>
                                                <td>
                                                    <button type="button" class="btn btn-success" data-toggle="modal"
                                                    data-target="#editModal{{ $station->id }}"><i
                                                        class="fa fa-edit fa-fw"></i></button>
                                                <form action="{{ route('deleteStation') }}" method="post" class="d-inline">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $station->id }}">
                                                    <button onclick="return confirm('Yakin menghapus data?')" type="submit"
                                                        class="btn btn-danger" title="Hapus Data"><i
                                                            class="fa fa-trash fa-fw"></i></button>
                                                </form></td>
                                            </tr>

                                            <div class="modal fade" id="editModal{{ $station->id }}" tabindex="-1" role="dialog"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Perbarui Data Station</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="{{ route('updateStation') }}" method="post">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Lokasi</label>
                                                                    <input type="hidden" name="id" value="{{ $station->id }}">
                                                                    <input type="text" name="loc" class="form-control"
                                                                        style="width: 100%;" value="{{ $station->loc }}" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label">Flags</label>
                                                                    <select class="form-control" name="flags" required>
                                                                        <option disabled="" value="">-- SILAHKAN PILIH --</option>
                                                                        <option {{ ($station->flags=="0")? "selected" : "" }}
                                                                            value="0">0</option>
                                                                        <option {{ ($station->flags=="1")? "selected" : "" }}
                                                                            value="1">1</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Close</button>
                                                                <button onclick="return confirm('Yakin perbarui data?')" type="submit"
                                                                    class="btn btn-primary">Submit</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="modal fade" id="insertModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Data Station</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('insertStation') }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Lokasi</label>
                                <input type="text" name="loc" class="form-control" style="width: 100%;" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Flags</label>
                                <select class="form-control" name="flags" required>
                                    <option disabled="" selected value="">-- SILAHKAN PILIH --</option>
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button onclick="return confirm('Yakin tambahkan data?')" type="submit"
                                class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@include('layout.footer')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script>
    $(document).ready(function () {
        $('#stationList').DataTable();
    });
</script>