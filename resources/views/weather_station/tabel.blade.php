@include('layout.header')
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
                            <h4 class="mb-0">Table AWS</h4>

                        </div>
                        <p style="color: grey">Pilih filter data yang akan ditampilkan, adapun default parameter yaitu <i>Curah Hujan</i></p>
                        <div class="row">
                            <div class="col-2">
                                <select name="" id="lokasi" class="form-control">

                                    @foreach ($list as $item)
                                    <option value="{{$item -> id}}">{{$item -> loc}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-2">
                                <input type="date" id="tanggal" class="form-control">
                            </div>
                            <div class="col-4">
                                <button type="button" id="finddata" class="btn btn-primary mr-2">Filters</button>
                                <button type="button" class="btn btn-danger">Reset</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-4 d-flex align-items-center justify-content-end pl-4">
                        <div style="padding: 5px;">

                        </div>
                    </div>
                </div>
            </div>
        </div>




        <div class="container-fluid">
            <div class="card">

                <div class="card-body">
                    <div class="row">

                        <div class="col-lg-12">
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h4 class="card-title"><i class="fas fa-calendar-alt"></i> Monthly Trends</h4>
                                </div>
                                <div class="card-body" a>

                                    <table class="table table-primary" id="tableaws">

                                    </table>

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

<script>
    var judul = 'DATA AWS';
    $(function() {
        $('#rekapTaksasi').DataTable({
            "searching": false,
            dom: 'Bfrtip',
            buttons: [{
                extend: 'excelHtml5',
                title: judul
            }],
        });
    });


    $('#finddata').click(function() {
        const lokasi = $('#lokasi').val();
        const tanggal = $('#tanggal').val();

        // Check if the date field is empty
        if (tanggal === '') {
            alert('Please select a date before clicking Find Data.');
            return; // Prevent further execution if the date is not selected
        }
        var _token = $('input[name="_token"]').val();
        // Create an object with data to be sent in the AJAX request
        const requestData = {
            lokasi: lokasi,
            tanggal: tanggal,
            _token: _token
            // Add more data if needed for your AJAX request
        };
        if ($.fn.DataTable.isDataTable('#tableaws')) {
            $('#tableaws').DataTable().destroy();
        }
        // AJAX request using jQuery
        $.ajax({
            url: 'gettabelaws', // Replace with your server endpoint URL
            method: 'POST', // Specify the HTTP method (POST, GET, etc.)
            data: requestData, // Data to be sent in the request
            success: function(result) {
                var parseResult = JSON.parse(result)


                var datatableweek1 = $('#tableaws').DataTable({
                    columns: [{
                            title: 'ID',
                            data: 'id'
                        },
                        {
                            title: 'Kecepatan Angin',
                            data: 'windspeedkmh'
                        },
                        {
                            title: 'Arah Angin',
                            data: 'winddir'
                        },
                        {
                            title: 'Curah Hujan',
                            data: 'rain_rate'
                        },
                        {
                            title: 'Suhu',
                            data: 'temp_in'
                        },
                        {
                            title: 'Kelembapan',
                            data: 'hum_out'
                        },
                        {
                            title: 'Sinar UV',
                            data: 'uv'
                        },
                    ],
                    dom: 'Bfrtip', // Add the Bfrtip option for Buttons
                    buttons: [
                        'excel' // Enable Excel export button
                    ]
                });

                datatableweek1.clear().rows.add(parseResult['data']).draw();

            },
            error: function(xhr, status, error) {
                // Handle errors in the AJAX request
                console.error('AJAX Error:', status, error);

                // Add logic to handle errors
            }
        });
    });
</script>