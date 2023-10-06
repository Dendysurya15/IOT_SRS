@include('layout.header')

<div class="content-wrapper">

<section class="content-header"></section>
<!--Content Header AWS 1//-->

<!-- // Main content AWS 1-->
<section class="content">
    <div class="col-12">
        {{csrf_field()}}
        <div class="row p-1 ">
            Filter Tanggal dan Mill :
        </div>
<div class="row p-1">
    <input class="form-control col-md-3" type="date" name="tgl" id="inputDate">
    <br>
    <select id="listLoc" class="form-control col-md-3">
        <option selected disabled>Pilih Lokasi</option>
        @foreach ($listLoc as $key => $list)
<option value="{{$key}}" {{ $key==0 ? 'selected' : '' }}>{{$list}}</option>
@endforeach
</select>
</div>
<div class="row p-1">
    <div class="col-4 col-lg-4 m-1 p-5 mb-2 dashboard_div" style="background-color: white;border-radius: 5px;">
        <h2 style="color:#013C5E;font-weight: 550">Water Level IoT
        </h2>
        <p style="color:#013C5E;">Portal website ini digunakan untuk memonitoring data dari proses pemantuan ketinggian
            air di <span id="namePlot"></span>
        </p>
        <p style="color:#013C5E;">Update data device terakhir pada <span class="font-italic font-weight-bold"
                id="last_date"></span></p>
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

</div>
<div class="col p-5 mb-2 m-1 dashboard_div" style="background-color: white;border-radius: 5px;">
    <div id="lineChart"></div>

</div>

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

<script>
    var inputDate = document.getElementById('inputDate');
    var listLokasi = document.getElementById('listLoc');
    // var counterDay = document.getElementById('counterDay');

    inputDate.valueAsDate = new Date(); // Set the date input to today's date
    listLokasi.value = '1'; // Set the select element to option 1
    var colorArray = ['#AB221D', '#4CAF50', '#FF9800', '#BE8C64', '#001E3C'];


var seriesData = [];

for (var i = 0; i <5; i++) {
    var series = {
        name: i,
        data: [], // Replace this with your actual data
        color: colorArray[i],
    };
    seriesData.push(series);
}

var initialData = {
    series: seriesData,
    chart: {
        type: 'line',
        height: 350,
        curve: 'smooth',
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        curve: "smooth"
    },
    grid: {
        padding: {
            right: 30,
            left: 20
        }
    },
    xaxis: {
        categories:@json($arrJam)
    },
    
};

// Initialize the chart
var chartLine = new ApexCharts(document.querySelector("#lineChart"), initialData);
chartLine.render();

function pushData() {
        tgl = inputDate.value
        loc = listLokasi.value

        var _token = $('input[name="_token"]').val();
        Swal.fire({
                title: 'Loading',
                html: '<span class="loading-text">Mohon Tunggu...</span>',
                allowOutsideClick: false,
                showConfirmButton: false,
                willOpen: () => {
                    Swal.showLoading();
                }

            });
        $.ajax({
        url:"{{ route('get_wl_dashboard') }}",
        method:"POST",
        data:{ tgl:tgl,loc:loc, _token:_token},
        
        success:function(result)
        {
            Swal.close();

            var dateRequestElement = document.getElementById('avgIn');
            var dateRequest2Element = document.getElementById('avgOut');
            var dateRequest3Element = document.getElementById('avgAct');
            var dateLastInElement = document.getElementById('lastIn');
            var dateLastOutElement = document.getElementById('lastOut');
            var dateLastActElement = document.getElementById('lastAct');
            var dateLastDateElement = document.getElementById('last_date');
            dateLastDateElement.textContent =  result.lastDate
            dateRequestElement.textContent =  result.avgIn !== '-' ? result.avgIn + ' cm' : result.avgIn
            dateRequest2Element.textContent = result.avgOut !== '-' ? result.avgOut + ' cm' : result.avgOut
            dateRequest3Element.textContent =  result.avgAct !== '-' ? result.avgAct + ' cm' : result.avgAct
            dateLastInElement.textContent =  result.lastlvlin !== '-' ? result.lastlvlin + ' cm' : result.lastlvlin
            dateLastOutElement.textContent = result.lastlvlout !== '-' ? result.lastlvlout + ' cm' : result.lastlvlout
            dateLastActElement.textContent =  result.lastlvlact !== '-' ? result.lastlvlact + ' cm' : result.lastlvlact
            

    //         if (isSameDate) {
    //             var dateJamLastElement = document.getElementById('jam_last');
    //         var dateJamLast2Element = document.getElementById('jam_last2');
    //         var dateJamLast3Element = document.getElementById('jam_last3');
    //         dateJamLastElement.textContent = 'hingga pukul ' + result.jamLast ;
    //         dateJamLast2Element.textContent = 'hingga pukul ' + result.jamLast ;
    //         dateJamLast3Element.textContent = 'hingga pukul ' + result.jamLast ;
    //         } else{
    //             // Clear the text content of the span elements when the date is not the same
    
    
    // var dateJamLastElement = document.getElementById('jam_last');
    // var dateJamLast2Element = document.getElementById('jam_last2');
    // var dateJamLast3Element = document.getElementById('jam_last3');

    // dateJamLastElement.textContent = '';
    // dateJamLast2Element.textContent = '';
    // dateJamLast3Element.textContent = '';
    //         }
            
            
    //         var dateTotalCounterElement = document.getElementById('totalCounter');
    //         dateTotalCounterElement.textContent =  result.totalCounter ;
    //         var dateHiOerElement = document.getElementById('hiOer');
    //         dateHiOerElement.textContent = result.hiOer;
    //         var dateShiOerElement = document.getElementById('shiOer');
    //         dateShiOerElement.textContent = result.shiOer;
    //         var dateHiRipenessElement = document.getElementById('hiRipeness');
    //         dateHiRipenessElement.textContent = result.hiRipeness;
    //         var dateShiRipenessElement = document.getElementById('shiRipeness');
    //         dateShiRipenessElement.textContent = result.shiRipeness;

            if(result.totalCounter >0){
    
        //     $('#card_data_empty').hide();
        //     removeExistingCards();
        //     var dataArray = result.itemPerClass;
        //     var dataChart = result.data;
        //     createAndAppendCards(dataArray)
        
        //     chartLine.updateSeries([
        //     { data: result.unripe },
        //     { data: result.ripe },
        //     { data: result.overripe },
        //     { data: result.empty_bunch },
        //     { data: result.abnormal }
        // ]);
        //     chartPie.updateSeries(result.totalMasingKategori)
            }
            // else{
            
            // }
            
        }
        })
    }
    inputDate.addEventListener('change', pushData);
    listLokasi.addEventListener('change', pushData);
    pushData();
</script>