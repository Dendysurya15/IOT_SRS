@include('layout.header')
<div class="content-wrapper">

    <style>
        /* Default styles for weather-card */
        .weather-card {
            margin: 20px 0;
            background: linear-gradient(to bottom right, #74ebd5, #ACB6E5);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: height 0.4s ease, box-shadow 0.4s ease, background 0.6s ease;
            overflow: hidden;
            position: relative;
            padding: 20px;
        }

        .weather-info {
            position: relative;
            z-index: 2;
        }

        .additional-info {
            max-height: 0;
            overflow: hidden;
            opacity: 0;
            transition: max-height 0.4s ease, opacity 0.4s ease;
            background-color: rgba(255, 255, 255, 0.9);
            color: #333;
            border-radius: 5px;
            margin-top: 10px;
            padding: 10px;
        }

        /* On hover, show the additional info */
        .weather-card:hover .additional-info {
            max-height: 300px;
            opacity: 1;
        }

        /* On hover, change background */
        .weather-card:hover {
            background: url('/img/background.jpg') no-repeat center center;
            background-size: cover;
        }

        /* Ensure the first card's additional info is open by default */
        .weather-card:first-child .additional-info {
            max-height: 300px;
            opacity: 1;
        }

        /* Table container styling */
        .table-container {
            max-height: 300px;
            overflow-y: auto;
            background-color: #fff;
            color: #333;
            border-radius: 5px;
            margin-top: 10px;
        }

        .table-striped {
            margin: 0;
        }
    </style>

    <!-- Main content -->
    <section class="content">
        <div class="weather-card">
            <div class="card-content">
                <div class="weather-info">
                    <p style="color: white;">Pilih filter data yang akan ditampilkan</p>
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
                    </div>
                </div>
                <div class="additional-info">
                    <div class="table-container">
                        <h4 class="card-title"><i class="fas fa-calendar-alt"></i> Rekap data secara tabel Perhari</h4>
                        <table class="table table-striped" id="tableaws"></table>
                    </div>
                </div>
                <div class="additional-info">
                    <div class="table-container">
                        <h4 class="card-title"><i class="fas fa-calendar-alt"></i> Rekap data secara tabel Perbulan</h4>
                        <table class="table table-striped" id="tableaws_bulan"></table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Second card -->
        <div class="weather-card">
            <div class="card-content">
                <div class="weather-info">
                    <p style="color: white;">Pilih filter data yang akan ditampilkan</p>
                    <div class="row">
                        <div class="col-2">
                            <select name="" id="dataloks" class="form-control">
                                @foreach($estate as $key => $items)
                                <option value="{{ $items['id'] }}">{{ $items['nama'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-2">
                            <input type="month" id="tanggalcurah" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="additional-info">
                    <div class="table-container">
                        <h4 class="card-title"><i class="fas fa-calendar-alt"></i> Rekap data secara tabel Perhari</h4>
                        <table class="table table-striped" id="tablecurahujan"></table>
                    </div>
                </div>
            </div>
        </div>
    </section>


</div>
@include('layout.footer')

<script>
    function handleAjaxRequest(lokasi, tanggal) {

        if (tanggal === '') {
            const today = new Date(); // Get today's date
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, '0'); // Month starts from 0
            const day = String(today.getDate()).padStart(2, '0');
            tanggal = `${year}-${month}-${day}`; // Format the date as YYYY-MM-DD
        }


        // console.log(tanggal);
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
        if ($.fn.DataTable.isDataTable('#tableaws_bulan')) {
            $('#tableaws_bulan').DataTable().destroy();
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
                            title: 'Tanggal',
                            data: 'date'
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
                    dom: 'B<"top"lf>rtip',
                    buttons: ['excel', 'pdf'],
                    lengthMenu: [
                        [10, 20, 50, -1],
                        [10, 20, 50, "All"]
                    ]
                });

                datatableweek1.clear().rows.add(parseResult['data']).draw();
                var datatableweek2 = $('#tableaws_bulan').DataTable({
                    columns: [{
                            title: 'Tanggal',
                            data: 'date'
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
                    dom: 'B<"top"lf>rtip',
                    buttons: ['excel', 'pdf'],
                    lengthMenu: [
                        [10, 20, 50, -1],
                        [10, 20, 50, "All"]
                    ]
                });

                datatableweek2.clear().rows.add(parseResult['data_perbulan']).draw();

            },
            error: function(xhr, status, error) {
                // Handle errors in the AJAX request
                console.error('AJAX Error:', status, error);

                // Add logic to handle errors
            }
        });
    }

    function handlecurahhujan(lokasi, tanggal) {

        if (tanggal === '') {
            const today = new Date(); // Get today's date
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, '0'); // Month starts from 0
            const day = String(today.getDate()).padStart(2, '0');
            tanggal = `${year}-${month}`; // Format the date as YYYY-MM-DD
        }


        // console.log(tanggal);
        var _token = $('input[name="_token"]').val();
        // Create an object with data to be sent in the AJAX request
        const requestData = {
            lokasi: lokasi,
            tanggal: tanggal,
            _token: _token
            // Add more data if needed for your AJAX request
        };
        if ($.fn.DataTable.isDataTable('#tablecurahujan')) {
            $('#tablecurahujan').DataTable().destroy();
        }
        // AJAX request using jQuery
        $.ajax({
            url: 'gettablecurahujan',
            method: 'post',
            data: requestData,
            success: function(result) {
                var parseResult = JSON.parse(result);
                var datatableweek2 = $('#tablecurahujan').DataTable({
                    columns: [{
                            title: 'Date',
                            data: 'Date'
                        },
                        {
                            title: 'Afdeling',
                            data: 'Afd'
                        },
                        {
                            title: 'Curah Hujan',
                            data: 'CH'
                        }
                    ],
                    dom: 'B<"top"lf>rtip',
                    buttons: ['excel', 'pdf'],
                    lengthMenu: [
                        [10, 20, 50, -1],
                        [10, 20, 50, "All"]
                    ]
                });
                datatableweek2.clear().rows.add(parseResult['data']).draw();
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
            }
        });
    }


    $(document).ready(function() {
        var defaultSelectedLocValue = $('#lokasi option:first').val();
        var defaultcurah = $('#dataloks option:first').val();
        var currentDate = new Date().toISOString().split('T')[0];

        $('#tanggal').val(currentDate);
        handleAjaxRequest(defaultSelectedLocValue, currentDate);

        $('#lokasi').on('change', function() {
            var selectedValue = $(this).val();
            handleAjaxRequest(selectedValue, currentDate);
        });

        $('#tanggal').on('change', function() {
            currentDate = $(this).val();

            handleAjaxRequest($('#lokasi').val(), currentDate);
        });

        $('#tanggalcurah').val(currentDate);
        handlecurahhujan(defaultcurah, currentDate);

        $('#dataloks').on('change', function() {
            var selectedValue = $(this).val();
            handlecurahhujan(selectedValue, currentDate);
        });

        $('#tanggalcurah').on('change', function() {
            currentDate = $(this).val();

            handlecurahhujan($('#dataloks').val(), currentDate);
        });
    })
</script>