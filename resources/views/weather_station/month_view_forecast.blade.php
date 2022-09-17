@include('layout.header')

<style>
    .selectCard:hover {
        transform: scale(1.01);
        box-shadow: 0 10px 20px rgba(0, 0, 0, .12), 0 4px 8px rgba(0, 0, 0, .06);
    }

    .selectCard {
        border-radius: 3px;
        background: white;
        box-shadow: 0 2px 2px rgba(0, 0, 0, .08), 0 0 2px rgba(0, 0, 0, .05);
        transition: .3s transform cubic-bezier(.155, 1.105, .295, 1.12), .3s box-shadow, .3s -webkit-transform cubic-bezier(.155, 1.105, .295, 1.12);
        cursor: pointer;
    }
</style>

<div class="content-wrapper">
    <!-- //Content Header AWS 1-->

    <?php $lokasiSel = ''; ?>
    {{-- @foreach($aws as $value) --}}
    <section class="content-header">
        <div class="content-fluid">

        </div>
    </section>
    <!--Content Header AWS 1//-->

    <!-- // Main content AWS 1-->
    <section class="content">
        <div class="container-fluid pb-3">
            <div class="row">
                <div class="col-lg-3 mb-3">
                    <div class="row">
                        <div class="col-md-8">
                        </div>
                        <form class="col-md-12" action="" method="post">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md">
                                    <select name="lokasi" id="locList" class="form-control">
                                        <option selected disabled>Pilih Lokasi</option>
                                        @foreach($loc as $loc)
                                        <option value="{{ $loc['id'] }}">{{ $loc['loc'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- <div class="mt-2 mb-3 ml-2 mr-2">
                <div class="row">
                    @foreach ($nextMonth as $key => $item)
                    <div class="col text-center selectCard pt-3 pb-3">
                        <span id="{{$key}}">{{$item}}</span>
                    </div>
                    @endforeach
                </div>
            </div> --}}
            <div class="p-5" style="background: white;border-radius:5px">
                <span>
                    Perkiraan cuaca bulan ini<span class="font-weight-bold" style="color: #013C5E">
                        {{$thisMonth}}</span>
                </span>
                <div class="row">
                    @foreach ($query as $item)
                    <div class="col-md-2 mt-2">
                        <a {{-- href=" --}}
                        {{-- {{ route('getDay', ['id'=>$item['date_num']]) }} --}}
                            {{-- " --}}>

                            <div class=" ">
                                @php
                                $num_today = \Carbon\Carbon::now()->format('d');
                                $num_today = (int)$num_today;
                                @endphp
                                @if ($item['num_days'] == $num_today)
                                <div class=""
                                    style="color:white;background: #40669E; border:#40669E solid 3px;border-radius:9px">
                                    @else
                                    <div class=""
                                        style="color:#63666A;background: white; border:#94AED7 solid 3px;border-radius:9px">
                                        @endif
                                        <div class="row">
                                            <div class="col ml-3 mt-2" style="font-size: 14px;">
                                                <img src="{{ asset('../img/water.png') }}" class="img-fluid"
                                                    style="width: 15px;margin-left:10px" alt="Responsive image">
                                                <br>
                                                {{
                                                $item['rerata_rf']
                                                }} mm
                                            </div>
                                            <div class="col">
                                                <div class="d-flex" style="font-size: 14px">
                                                    <div class="ml-auto mt-2 mr-2">
                                                        <span class="font-weight-bold"> {{$item['date']}}</span>
                                                        <br>
                                                        {{
                                                        $item['rerata_tf'] != 0 ? $item['rerata_tf'] : '-'
                                                        }} ºC
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- <div class="col" style="font-size: 14px;border:1px solid red">
                                                <div class="col " style="border: 1px solid green">
                                                    {{$item['date']}}
                                                    <br>
                                                    {{
                                                    $item['temperature'] != 0 ? $item['temperature'] : '-'
                                                    }} ºC
                                                </div>
                                            </div> --}}
                                        </div>
                                        <div class="row">
                                            <div class="col ml-3 mb-2">
                                                <img src="{{ asset('../img/'.$item['icon']) }}" class="img-fluid"
                                                    style="width: 60px;" alt="Responsive image">
                                            </div>

                                        </div>
                                        {{-- <div class="row">
                                            <div class="row">
                                                <div class="col" style="border: 1px solid red">
                                                    {{$item['date']}}
                                                </div>
                                                <div class="col" style="border: 1px solid red">
                                                    <i class="fas fa-cloud fa-lg pr-2"></i>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col" style="border:1px solid green">
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="hum">
                                                        <div class="mb-2">
                                                            {{
                                                            $item['temperature'] != 0 ? $item['temperature'] : '-'
                                                            }} ºC
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>

                        </a>
                        @endforeach
                        <!--Suhu Ruangan//-->

                    </div>

                </div>
            </div><!-- /.container-fluid -->
    </section>
    <!-- Main content AWS 1 //-->
    {{-- @endforeach --}}



    <!--locList Tambah Koment -->
</div>
@include('layout.footer')

<script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.9.4/lottie.min.js"
    integrity="sha512-ilxj730331yM7NbrJAICVJcRmPFErDqQhXJcn+PLbkXdE031JJbcK87Wt4VbAK+YY6/67L+N8p7KdzGoaRjsTg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- jQuery -->
<script src="{{ asset('/public/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('/public/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('/public/plugins/chart.js/Chart.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('/public/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('/public/js/demo.js') }}"></script>

<script src="{{ asset('/public/js/loader.js') }}"></script>

<script>
    $(document).ready(function(){
      var indexDefault = 2;
      $('#locList').val(99)
      let dropdownList = document.getElementById('locList');
      let selectedOption = dropdownList.options[indexDefault];
      var idws = selectedOption.value;
      var loc = selectedOption.text;

    });

</script>