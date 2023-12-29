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


                        </div>
                        <p style="color: grey">Pilih filter data yang akan ditampilkan</p>
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
                    <div class="col-4 d-flex align-items-center justify-content-end pl-4">
                        <div style="padding: 5px;">

                        </div>
                    </div>
                </div>
            </div>
        </div>




        <div class="container-fluid">
            <div class="card">

                <div class="card-header bg-success">
                    <h4 class="card-title"><i class="fas fa-calendar-alt"></i> Rekap data secara tabel</h4>
                </div>
                <div class="card-body" a>

                    <table class="table " id="tableaws">

                    </table>

                </div>
            </div>
        </div>


    </section>
    <!-- /.content -->
</div>
@include('layout.footer')

<script>
    function handleAjaxRequest(lokasi,tanggal) {

 if (tanggal === '') {
            const today = new Date(); // Get today's date
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, '0'); // Month starts from 0
            const day = String(today.getDate()).padStart(2, '0');
            tanggal = `${year}-${month}-${day}`; // Format the date as YYYY-MM-DD
        }


        console.log(tanggal);
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
                    dom: 'B<"top"lf>rtip', // Explicitly define the DOM layout
                    buttons: [
                        'excel' // Enable Excel export button
                    ],
                    lengthMenu: [
                        [10, 20, 50, -1],
                        [10, 20, 50, "All"]
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
}
    


    $(document).ready(function() {
    var defaultSelectedLocValue = $('#lokasi option:first').val();
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
  })
</script>