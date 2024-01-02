@include('layout.header')

<div class="content-wrapper">

    <section class="content-header"></section>
    <!--Content Header AWS 1//-->

    <!-- // Main content AWS 1-->
    <section class="content">
        <div class="col-12">
            {{csrf_field()}}
            <div class="row p-1 ">
                Filter Tanggal :
            </div>
            <div class="row p-1">
                <input class="form-control col-md-2" type="date" name="tgl" id="inputDate">
                <br>
                <select id="listWil" class="form-control col-md-2">
                    {{-- <option selected disabled>Pilih Wilayah</option> --}}
                    @foreach ($listWil as $key => $list)
                    <option value="{{$list}}" {{ $key==0 ? 'selected' : '' }}>{{$list}}</option>
                    @endforeach
                </select>
                <select id="listLoc" class="form-control col-md-2">

                </select>
            </div>
            <div class="row p-1">
                <div class="col-lg-4 col-md- col-sm-12 m-1 p-5 mb-2 dashboard_div"
                    style="background-color: white;border-radius: 5px;">
                    <h2 style="color:#013C5E;font-weight: 550">Water Level IoT
                    </h2>
                    <p style="color:#013C5E;">Portal website ini digunakan untuk memonitoring data dari proses pemantuan
                        ketinggian
                        air di <span id="namePlot" style="font-weight: bold"></span>
                    </p>
                    <p style="color:#013C5E;">Update data device terakhir pada <span
                            class="font-italic font-weight-bold" id="last_date"></span></p>
                    <ul class="list-group">
                        <li class="list-group-item">
                            <div class="d-flex flex-row bd-highlight ">

                                <div class=" bd-highlight mr-2"><i class="fa-solid fa-equals" style="color:grey"></i>
                                </div>
                                <div class="flex-grow-1  bd-highlight">Level In Terakhir</div>
                                <div class=" bd-highlight" id="lastIn"></div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="d-flex flex-row bd-highlight ">

                                <div class=" bd-highlight mr-2"><i class="fa-solid fa-equals" style="color:grey"></i>
                                </div>
                                <div class="flex-grow-1  bd-highlight">Level Out Terakhir</div>
                                <div class=" bd-highlight" id="lastOut"></div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="d-flex flex-row bd-highlight ">

                                <div class=" bd-highlight mr-2"><i class="fa-solid fa-equals" style="color:grey"></i>
                                </div>
                                <div class="flex-grow-1  bd-highlight">Level Actual Terakhir</div>
                                <div class=" bd-highlight" id="lastAct"></div>
                            </div>
                        </li>
                    </ul>

                    {{-- rata rata --}}

                    <br>
                    <ul class="list-group">
                        <li class="list-group-item">
                            <div class="d-flex flex-row bd-highlight ">

                                <div class=" bd-highlight mr-2"><i class="fa-solid fa-water" style="color: #013C5E"></i>
                                </div>
                                <div class="flex-grow-1  bd-highlight">Rata rata Level In</div>
                                <div class=" bd-highlight" id="avgIn"></div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="d-flex flex-row bd-highlight ">

                                <div class=" bd-highlight mr-2"><i class="fa-solid fa-water" style="color: #013C5E"></i>
                                </div>
                                <div class="flex-grow-1  bd-highlight">Rata rata Level Out</div>
                                <div class=" bd-highlight" id="avgOut"></div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="d-flex flex-row bd-highlight ">

                                <div class=" bd-highlight mr-2"><i class="fa-solid fa-water" style="color: #013C5E"></i>
                                </div>
                                <div class="flex-grow-1  bd-highlight">Rata rata Level Actual</div>
                                <div class=" bd-highlight" id="avgAct"></div>
                            </div>
                        </li>
                    </ul>

                    <br>
                    <ul class="list-group">
                        <li class="list-group-item">
                            <div class="d-flex flex-row bd-highlight ">

                                <div class=" bd-highlight mr-2"><i class="fa-solid fa-water" style="color: #013C5E"></i>
                                </div>
                                <div class="flex-grow-1  bd-highlight">Batas Atas Air</div>
                                <div class=" bd-highlight" id="MaxBatasElement"></div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="d-flex flex-row bd-highlight ">

                                <div class=" bd-highlight mr-2"><i class="fa-solid fa-water" style="color: #013C5E"></i>
                                </div>
                                <div class="flex-grow-1  bd-highlight">Batas Bawah Air</div>
                                <div class=" bd-highlight" id="MinBatasElement"></div>
                            </div>
                        </li>

                    </ul>

                </div>
                <div class="col-lg-7 col-md-12 col-sm-12 p-5 mb-2 m-1 dashboard_div"
                    style="background-color: white;border-radius: 5px;" style="border: 1px solid red">

                    <div class="row">
                        <div class="col-lg-12">
                            <h4 style="color:#013C5E;font-weight: 550">Titik Lokasi Pompa
                            </h4>
                            <div id="map" style="height: 550px;"></div>

                        </div>
                        {{-- <div class="col-lg-7">
                            <h4 style="color:#013C5E;font-weight: 550">Foto Pompa
                            </h4>
                            <div style="text-align:center">
                                <img id="map-image" src="{{ asset('storage/no-image.png') }}" class="img-fluid"
                                    alt="Image Description" style="">
                            </div>
                        </div> --}}
                    </div>
                    {{-- <h4 style="color:black;font-weight: 550">Titik Lokasi Pompa
                    </h4>
                    <div id="map" style="height: 200px;"></div>
                    <br>

                    <div class="row">

                        <div class="col-lg-12 col-sm-12">
                            <h4 style="color:black;font-weight: 550">Foto Pompa
                            </h4>
                            <div style="height: 400px">
                                <img src=" {{ asset('storage/nbe_od_b9.jpg') }}" class="img-fluid"
                                    alt="Image Description" style="max-height: 100%; width: auto;">
                            </div>

                        </div>

                    </div> --}}


                </div>
                {{-- <div class="col-lg-3 col-md-12 col-sm-12 p-5 mb-2 m-1 dashboard_div"
                    style="background-color: white;border-radius: 5px;" style="border: 1px solid red">
                    <h4 style="color:black;font-weight: 550">Titik Lokasi Pompa
                    </h4>
                    <div id="map" style="height: 600px;"></div>

                </div> --}}

            </div>
        </div>
</div>






</section>


<!--Coba Tambah Koment -->
</div>
@include('layout.footer')
<script src="{{ asset('/public/plugins/jquery/jquery.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<script>
    var dateRequestElement = document.getElementById('avgIn');
    var dateRequest2Element = document.getElementById('avgOut');
    var dateRequest3Element = document.getElementById('avgAct');
    var dateLastInElement = document.getElementById('lastIn');
    var dateLastOutElement = document.getElementById('lastOut');
    var dateLastActElement = document.getElementById('lastAct');
    var dateLastDateElement = document.getElementById('last_date');

        var map = L.map('map', {
            preferCanvas: true, // Set preferCanvas to true
        }).setView([-2.2745234, 111.61404248], 13);

        googleSat = L.tileLayer('http://{s}.google.com/vt?lyrs=s&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
        }).addTo(map);
    
    // var marker = L.marker([2.2745234, 111.61404248]).addTo(map);
    var marker;

    function handleAjaxRequest(selectedValue, currentDate) {

        $.ajax({
            url: '{{ route("get_estate") }}', // Replace with your actual endpoint URL
            type: 'GET',
            data: {
                wil: selectedValue,
                tgl: currentDate
            },
            success: function(data) {

                console.log(data)
                // Update the content or perform other actions based on the AJAX response
                var selectLoc = $('#listLoc');
                selectLoc.empty(); // Clear existing options

                // Check if data is empty
                if ($.isEmptyObject(data)) {
                    // If data is empty, add a disabled option
                    selectLoc.append($('<option>', {
                        value: '',
                        text: 'Tidak ada implementasi pada wilayah ini',
                        disabled: true
                    }));

                    dateLastInElement.innerHTML = '-';
                    dateLastOutElement.innerHTML = '-';
                    dateLastActElement.innerHTML = '-';
                    dateRequestElement.innerHTML = '-';
                    dateRequest2Element.innerHTML = '-';
                    dateRequest3Element.innerHTML = '-';
                    dateLastDateElement.innerHTML = 'tidak ada';
                } else {
                    // Iterate through the object and append options to the select element
                    $.each(data, function(index, location) {
                        selectLoc.append($('<option>', {
                            value: location,
                            text: location
                        }));
                    });

                    var defaultSelectedValue = selectLoc.val();
                    handleListLocClick(defaultSelectedValue, currentDate);
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }

    function handleListLocClick(selectedValue, currentDate) {
        var _token = $('input[name="_token"]').val();
        // Remove the last marker if it exists
    if (marker) {
        map.removeLayer(marker);
    }
        $.ajax({
            url: "{{ route('get_wl_dashboard') }}",
            method: "POST",
            data: {
                tgl: currentDate,
                loc: selectedValue,
                _token: _token
            },

            success: function(result) {
                var newCoordinates = [parseFloat(result.lat), parseFloat(result.lon)];
                marker = L.marker(newCoordinates).addTo(map);
                var imageElement = document.querySelector("#map-image");

                
                var imageUrl = "{{ asset('storage/') }}" + "/" + result.foto || "{{ asset('storage/no-image.png') }}";

                imageElement.src = imageUrl;

                // Check if the image exists, and if not, set the src to the default image
                imageElement.onerror = function() {
                    imageElement.src = "{{ asset('storage/no-image.png') }}";
                };
                
                dateLastDateElement.textContent = result.lastDate
                dateRequestElement.textContent = result.avgIn !== '-' ? result.avgIn + ' cm' : result.avgIn
                dateRequest2Element.textContent = result.avgOut !== '-' ? result.avgOut + ' cm' : result.avgOut
                dateRequest3Element.textContent = result.avgAct !== '-' ? result.avgAct + ' cm' : result.avgAct
                dateLastInElement.textContent = result.lastlvlin !== '-' ? result.lastlvlin + ' cm' : result.lastlvlin
                dateLastOutElement.textContent = result.lastlvlout !== '-' ? result.lastlvlout + ' cm' : result.lastlvlout
                dateLastActElement.textContent = result.lastlvlact !== '-' ? result.lastlvlact + ' cm' : result.lastlvlact
                MaxBatasElement.textContent = result.max !== '-' ? result.max + ' cm' : result.max
                MinBatasElement.textContent = result.min !== '-' ? result.min + ' cm' : result.min
                namePlot.textContent = result.namePlot !== '-' ? result.namePlot : result.namePlot
                
                map.setView(newCoordinates, 13);
            }



        })

    }


    $(document).ready(function() {

        var defaultSelectedValue = $('#listWil option:first').val();

        var currentDate = new Date().toISOString().split('T')[0];
    
        $('#inputDate').val(currentDate);
        $('#listWil').val(defaultSelectedValue);
        handleAjaxRequest(defaultSelectedValue, currentDate);

        $('#listWil').on('change', function() {
            var selectedValue = $(this).val();
            handleAjaxRequest(selectedValue, currentDate);
        });

        $('#inputDate').on('change', function() {
            currentDate = $(this).val(); // Update currentDate when the date changes

            handleAjaxRequest($('#listWil').val(), currentDate);
        });
        $('#listLoc').on('change', function() {
            var selectedValue = $(this).val();

            handleListLocClick(selectedValue, currentDate);
        });

    });
</script>