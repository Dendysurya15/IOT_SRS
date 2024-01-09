<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\Datatables;

class MasterController extends Controller
{

    function hari_ini($date)
    {
        $hari = $date;

        switch ($hari) {
            case 'Sun':
                $hari_ini = "Minggu";
                break;

            case 'Mon':
                $hari_ini = "Senin";
                break;

            case 'Tue':
                $hari_ini = "Selasa";
                break;

            case 'Wed':
                $hari_ini = "Rabu";
                break;

            case 'Thu':
                $hari_ini = "Kamis";
                break;

            case 'Fri':
                $hari_ini = "Jumat";
                break;

            case 'Sat':
                $hari_ini = "Sabtu";
                break;

            default:
                $hari_ini = "Tidak di ketahui";
                break;
        }
        return $hari_ini;
    }

    public function store_weather_list(Request $request)
    {
        $response = array();
        $response = (object)$response;

        $rain_cal     = '';
        $loc     = '';
        $lat     = '';
        $lon     = '';
        $desc     = '';

        if (empty($request->rain_cal) || empty($request->loc) || empty($request->lat) || empty($request->lon) || empty($request->desc)) {
            $response->success = 0;
            $response->message = 'Kolom tidak boleh kosong';
        } elseif (
            isset($request->rain_cal) || isset($request->loc) || isset($request->lat) || isset($request->lon) || isset($request->desc)
        ) {
            $rain_cal  = $request->rain_cal;
            $loc  = $request->loc;
            $lat  = $request->lat;
            $lon  = $request->lon;
            $desc = $request->desc;
        }

        $arr_kategori = [
            'rain_cal'                  => $request->rain_cal,
            'loc'                  => $request->loc,
            'lat'                  => $request->lat,
            'lon'                  => $request->lon,
            'desc'                  => $request->desc,
        ];

        $rules   = [
            'rain_cal'                  => 'required|numeric',
            'loc'                  => 'required|string|min:3|max:50',
            'lat'                  => 'required|numeric',
            'lon'                  => 'required|numeric',
            'desc'                  => 'required|string|min:3|max:50',
        ];

        $messages = [
            'rain_cal.required'                 => 'LOKASI WAJIB DIISI',
            'rain_cal.numeric'                  => 'RAIN CAL HARUS BERUPA ANGKA',
            'loc.required'                 => 'LOKASI WAJIB DIISI',
            'loc.min'                      => 'MINIMAL PENGISIAN NAMA ADALAH 3 KARAKTER',
            'loc.max'                      => 'MAXIMAL PENGISISAN NAMA ADALAH 50 KARAKTER',
            'lat.required'                 => 'LATITIDE WAJIB DIISI',
            'lat.numeric'                  => 'LATITUDE HARUS BERUPA ANGKA',
            'lon.required'                 => 'LONGITUDE WAJIB DIISI',
            'lon.numeric'                  => 'LONGITUDE HARUS BERUPA ANGKA',
            'desc.required'                 => 'DESKRIPSI WAJIB DIISI',
            'desc.min'                      => 'MINIMAL PENGISIAN NAMA ADALAH 3 KARAKTER',
            'desc.max'                      => 'MAXIMAL PENGISISAN NAMA ADALAH 50 KARAKTER',
        ];

        $validator = Validator::make($arr_kategori, $rules, $messages);

        if ($validator->fails()) {
            $response->success = 0;
            $response->message = $validator->errors()->first();
        } else {
            try {
                $newWeatherListID = DB::table('weather_station_list')->insertGetId(array(
                    'rain_cal' => $rain_cal,
                    'loc' => $loc,
                    'lat' => $lat,
                    'lon' => $lon,
                    'desc' => $desc,
                ));

                $response->id = $newWeatherListID;
                $response->Rain_Cal = $rain_cal;
                $response->Location = $loc;
                $response->Latitude = $lat;
                $response->Longitude = $lon;
                $response->Description = $desc;

                $response->success = 1;
                $response->message = 'BERHASIL MELAKUKAN INSERT KE TABLE WEATHER STATION LIST';
            } catch (Exception $e) {
                $response->success = 0;
                $response->message = 'GAGAL MELAKUKAN INSERT DATA, PESAN KESALAHAN : ' . $e->getMessage();
            }
        }
        return json_encode($response);
    }

    #Insert Weather Station List
    /**
     * @OA\Post(
     *      path="/api/insert_weather_station_list/{rain_cal}/{loc}/{lat}/{lon}/{desc}",
     *      tags={"Weather Station"},
     *      summary="Insert Weather Station List ke table database",
     *      description="Insert Weather Station List  ke table database",
     * @OA\Parameter(
     *          name="rain_cal",
     *          description="rain_cal",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="number",
     *              format="float"
     *          )
     *      ),
     *   @OA\Parameter(
     *          name="loc",
     *          description="loc",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *   @OA\Parameter(
     *          name="lat",
     *          description="lat",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="number",
     *              format="float",
     *          )
     *      ),
     *   @OA\Parameter(
     *          name="lon",
     *          description="lon",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="number",
     *              format="float"
     *          )
     *      ),
     *   @OA\Parameter(
     *          name="desc",
     *          description="desc",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Returns list of projects
     */

    public function store_weather(Request $request)
    {
        $response = array();
        $response = (object)$response;



        $idws     = '';
        $datetime     = '';
        $ws     = '';
        $wd     = '';
        $wc     = '';
        $t     = '';
        $h     = '';
        $r     = '';

        // return json_encode($response->test = DB::table('weather_station')->where('id', 3554)->get());
        if (empty($request->idws) || empty($request->datetime) || empty($request->ws) || empty($request->wd) || empty($request->wc) || empty($request->t) || empty($request->h) || empty($request->r)) {
            $response->success = 0;
            $response->message = 'Kolom tidak boleh kosong';
        } elseif (
            isset($request->idws) || isset($request->datetime) || isset($request->ws) || isset($request->wd) || isset($request->wc) || isset($request->t) || isset($request->h) || isset($request->r)
        ) {
            $idws  = $request->idws;
            $datetime  = $request->datetime;
            $ws  = $request->ws;
            $wd  = $request->wd;
            $wc = $request->wc;
            $t = $request->t;
            $h = $request->h;
            $r = $request->r;
        }

        $arr_kategori = [
            'idws'                  => $request->idws,
            'datetime'                  => $request->datetime,
            'ws'                  => $request->ws,
            'wd'                  => $request->wd,
            'wc'                  => $request->wc,
            't'                  => $request->t,
            'h'                  => $request->h,
            'r'                  => $request->r,
        ];

        $rules   = [
            'idws'                  => 'required|numeric',
            'datetime'              => 'required|date',
            'ws'                  => 'required|numeric',
            'wd'                  => 'required|numeric',
            'wc'                  => 'required|string|min:3|max:50',
            't'                  => 'required|numeric',
            'h'                  => 'required|numeric',
            'r'                  => 'required|numeric|',
        ];

        $messages = [
            'idws.required'                 => 'LOKASI WAJIB DIISI',
            'idws.numeric'                  => 'IDWS HARUS BERUPA ANGKA',
            'datetime.required'                 => 'DATETIME WAJIB DIISI',
            'datetime.date'                  => 'DATETIME HARUS BERUPA TANGGAL & WAKTU',
            'ws.required'                 => 'WS WAJIB DIISI',
            'ws.numeric'                  => 'WS HARUS BERUPA ANGKA',
            'wd.required'                 => 'WD WAJIB DIISI',
            'wd.numeric'                  => 'WD HARUS BERUPA ANGKA',
            'wc.required'                 => 'WC WAJIB DIISI',
            'wc.min'                      => 'MINIMAL PENGISIAN WC ADALAH 3 KARAKTER',
            'wc.max'                      => 'MAXIMAL PENGISISAN WC ADALAH 50 KARAKTER',
            't.required'                 => 'T WAJIB DIISI',
            't.numeric'                  => 'T HARUS BERUPA ANGKA',
            'h.required'                 => 'H WAJIB DIISI',
            'h.numeric'                  => 'H HARUS BERUPA ANGKA',
            'r.required'                 => 'R WAJIB DIISI',
            'r.numeric'                  => 'R HARUS BERUPA ANGKA',
        ];

        $validator = Validator::make($arr_kategori, $rules, $messages);

        if ($validator->fails()) {
            $response->success = 0;
            $response->message = $validator->errors()->first();
        } else {
            try {
                $newWeatherListID = DB::table('weather_station')->insertGetId(array(
                    'idws' => $idws,
                    'datetime' => $datetime,
                    'ws' => $ws,
                    'wd' => $wd,
                    'wc' => $wc,
                    't' => $t,
                    'h' => $h,
                    'r' => $r,
                ));

                $response->id = $newWeatherListID;
                $response->idws = $idws;
                $response->datetime = $datetime;
                $response->ws = $ws;
                $response->wd = $wd;
                $response->wc = $wc;
                $response->t = $t;
                $response->h = $h;
                $response->r = $r;

                $response->success = 1;
                $response->message = 'BERHASIL MELAKUKAN INSERT KE TABLE WEATHER STATION LIST';
            } catch (Exception $e) {
                $response->success = 0;
                $response->message = 'GAGAL MELAKUKAN INSERT DATA, PESAN KESALAHAN : ' . $e->getMessage();
            }
        }
        return json_encode($response);
    }

    #Insert Weather Station
    /**
     * @OA\Post(
     *      path="/api/insert_weather_station/{idws}/{datetime}/{ws}/{wd}/{wc}/{t}/{h}/{r}",
     *      tags={"Weather Station"},
     *      summary="Insert Weather Station ke table database",
     *      description="Insert Weather Station  ke table database",
     * @OA\Parameter(
     *          name="idws",
     *          description="idws",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer",
     *              format="int32",
     *          )
     *      ),
     *   @OA\Parameter(
     *          name="datetime",
     *          description="datetime",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *              format="date-time",
     *          )
     *      ),
     *   @OA\Parameter(
     *          name="ws",
     *          description="ws",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="number",
     *              format="float",
     *          )
     *      ),
     *   @OA\Parameter(
     *          name="wd",
     *          description="wd",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer",
     *              format="int32",
     *          )
     *      ),
     *   @OA\Parameter(
     *          name="wc",
     *          description="wc",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *   @OA\Parameter(
     *          name="t",
     *          description="t",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="number",
     *              format="float",
     *          )
     *      ),
     *   @OA\Parameter(
     *          name="h",
     *          description="h",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="number",
     *              format="float", 
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="r",
     *          description="r",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="number",
     *              format="float"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Returns list of projects
     */

    public function store_water_list(Request $request)
    {
        $response = array();
        $response = (object)$response;

        $location     = '';
        $lat     = '';
        $long     = '';
        $desc     = '';

        // return json_encode($response->location = $request->location);

        if (empty($request->location) || empty($request->lat) || empty($request->long) || empty($request->desc)) {
            $response->success = 0;
            $response->message = 'Kolom tidak boleh kosong';
        } elseif (
            isset($request->location) || isset($request->lat) || isset($request->long) || isset($request->desc)
        ) {
            $location  = $request->location;
            $lat  = $request->lat;
            $long  = $request->long;
            $desc = $request->desc;
        }

        $arr_kategori = [
            'location'                => $request->location,
            'lat'                  => $request->lat,
            'long'                  => $request->long,
            'desc'                  => $request->desc,
        ];

        $rules   = [
            'location'                  => 'required|string|min:3|max:50',
            'lat'                  => 'required|numeric',
            'long'                  => 'required|numeric',
            'desc'                  => 'required|string|min:3|max:50',
        ];

        $messages = [
            'location.required'                 => 'LOKASI WAJIB DIISI',
            'location.min'                      => 'MINIMAL PENGISIAN NAMA ADALAH 3 KARAKTER',
            'location.max'                      => 'MAXIMAL PENGISISAN NAMA ADALAH 50 KARAKTER',
            'lat.required'                 => 'LATITUDE WAJIB DIISI',
            'lat.numeric'                  => 'LATITUDE HARUS BERUPA ANGKA',
            'long.required'                 => 'LONGITUDE WAJIB DIISI',
            'long.numeric'                  => 'LONGITUDE HARUS BERUPA ANGKA',
            'desc.required'                 => 'DESKRIPSI WAJIB DIISI',
            'desc.min'                      => 'MINIMAL PENGISIAN NAMA ADALAH 3 KARAKTER',
            'desc.max'                      => 'MAXIMAL PENGISISAN NAMA ADALAH 50 KARAKTER',
        ];

        $validator = Validator::make($arr_kategori, $rules, $messages);

        if ($validator->fails()) {
            $response->success = 0;
            $response->message = $validator->errors()->first();
        } else {
            try {
                $newWaterListID = DB::table('water_level_list')->insertGetId(array(
                    'location' => $location,
                    'lat' => $lat,
                    'long' => $long,
                    'desc' => $desc,
                ));

                $response->Id = $newWaterListID;
                $response->Location = $location;
                $response->Latitude = $lat;
                $response->Longitude = $long;
                $response->Description = $desc;

                $response->success = 1;
                $response->message = 'BERHASIL MELAKUKAN INSERT KE TABLE WATER LEVEL LIST';
            } catch (Exception $e) {
                $response->success = 0;
                $response->message = 'GAGAL MELAKUKAN INSERT DATA, PESAN KESALAHAN : ' . $e->getMessage();
            }
        }
        return json_encode($response);
    }

    #Insert Water Level List
    /**
     * @OA\Post(
     *      path="/api/insert_water_level_list/{location}/{lat}/{long}/{desc}",
     *      tags={"Water Level"},
     *      summary="Insert Water Level List ke table database",
     *      description="Insert Water Level List  ke table database",
     *   @OA\Parameter(
     *          name="location",
     *          description="location",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *   @OA\Parameter(
     *          name="lat",
     *          description="lat",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="number",
     *              format="float",
     *          )
     *      ),
     *   @OA\Parameter(
     *          name="long",
     *          description="long",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="number",
     *              format="float"
     *          )
     *      ),
     *   @OA\Parameter(
     *          name="desc",
     *          description="desc",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Returns list of projects
     */

    public function store_water(Request $request)
    {
        $response = array();
        $response = (object)$response;

        $idwl     = '';
        $datetime     = '';
        $lvl_in     = '';
        $lvl_out     = '';
        $lvl_act     = '';

        // return json_encode($response->test = DB::table('weather_station')->where('id', 3554)->get());
        if (empty($request->idwl) || empty($request->datetime) || empty($request->lvl_in) || empty($request->lvl_out) || empty($request->lvl_act)) {
            $response->success = 0;
            $response->message = 'Kolom tidak boleh kosong';
        } elseif (
            isset($request->idwl) || isset($request->datetime) || isset($request->lvl_in) || isset($request->lvl_out) || isset($request->lvl_act)
        ) {
            $idwl  = $request->idwl;
            $datetime  = $request->datetime;
            $lvl_in  = $request->lvl_in;
            $lvl_out  = $request->lvl_out;
            $lvl_act = $request->lvl_act;
        }

        $arr_water_level = [
            'idwl'                  => $request->idwl,
            'datetime'                  => $request->datetime,
            'lvl_in'                  => $request->lvl_in,
            'lvl_out'                  => $request->lvl_out,
            'lvl_act'                  => $request->lvl_act,
        ];

        $rules   = [
            'idwl'                  => 'numeric',
            'datetime'              => 'required|date',
            'lvl_in'                  => 'required|numeric',
            'lvl_out'                  => 'required|numeric',
            'lvl_act'                  => 'required',

        ];

        $messages = [
            'idwl.required'                 => 'IDWL WAJIB DIISI',
            'idwl.numeric'                  => 'idwl HARUS BERUPA ANGKA',
            'datetime.required'                 => 'DATETIME WAJIB DIISI',
            'lvl_in.required'                 => 'lvl_in WAJIB DIISI',
            'lvl_in.numeric'                  => 'lvl_in HARUS BERUPA ANGKA',
            'lvl_out.required'                 => 'lvl_out WAJIB DIISI',
            'lvl_out.numeric'                  => 'lvl_out HARUS BERUPA ANGKA',
            'lvl_act.required'                 => 'lvl_act WAJIB DIISI',
        ];

        $validator = Validator::make($arr_water_level, $rules, $messages);

        if ($validator->fails()) {
            $response->success = 0;
            $response->message = $validator->errors()->first();
        } else {
            try {
                $newWaterLevelID = DB::table('water_level')->insertGetId(array(
                    'idwl' => $idwl,
                    'datetime' => $datetime,
                    'lvl_in' => $lvl_in,
                    'lvl_out' => $lvl_out,
                    'lvl_act' => $lvl_act,
                ));

                $response->id = $newWaterLevelID;
                $response->idwl = $idwl;
                $response->datetime = $datetime;
                $response->lvl_in = $lvl_in;
                $response->lvl_out = $lvl_out;
                $response->lvl_act = $lvl_act;

                $response->success = 1;
                $response->message = 'BERHASIL MELAKUKAN INSERT KE TABLE WEATHER STATION LIST';
            } catch (Exception $e) {
                $response->success = 0;
                $response->message = 'GAGAL MELAKUKAN INSERT DATA, PESAN KESALAHAN : ' . $e->getMessage();
            }
        }
        return json_encode($response);
    }

    #Insert Water Level
    /**
     * @OA\Post(
     *      path="/api/insert_water_level/{idwl}/{datetime}/{lvl_in}/{lvl_out}/{lvl_act}",
     *      tags={"Water Level"},
     *      summary="Insert Water Level ke table database",
     *      description="Insert Water Level  ke table database",
     * @OA\Parameter(
     *          name="idwl",
     *          description="idwl",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer",
     *              format="int32",
     *          )
     *      ),
     *   @OA\Parameter(
     *          name="datetime",
     *          description="datetime",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *   @OA\Parameter(
     *          name="lvl_in",
     *          description="lvl_in",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="number",
     *              format="float",
     *          )
     *      ),
     *   @OA\Parameter(
     *          name="lvl_out",
     *          description="lvl_out",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="number",
     *              format="float",
     *          )
     *      ),
     *   @OA\Parameter(
     *          name="lvl_act",
     *          description="lvl_act",
     *          required=false,
     *          in="path",
     *          @OA\Schema(
     *              type="number",
     *              format="float",
     *          )
     *      ),

     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Returns list of projects
     */
    //

    public static function homepage()
    {
        return view('layout/homepage');
    }

    public static function getDay(Request $request)
    {
        return view('weather_station/forecastDay');
    }

    public static function dashboard_soil(Request $request)
    {

        $dateToday =  Carbon::now();
        $yesterday = Carbon::parse($dateToday)->subDay();

        $query =  DB::table('soil_moisture')
            ->select('soil_moisture.*',  DB::raw("DATE_FORMAT(soil_moisture.datetime,'%H:00') as jam"))

            ->whereBetween('soil_moisture.datetime', [$yesterday, $dateToday])
            ->orderBy('soil_moisture.datetime')
            ->get()
            ->groupBy('jam');

        // dd($query);

        $listHour = array();
        $arrHour = array();
        foreach ($query as $key => $value) {
            $sum_hum = 0;
            $sum_temp = 0;
            $inc = 0;
            foreach ($value as $key2 => $data) {
                $sum_hum += $data->hum1;
                $sum_temp += $data->temp;
                $inc++;
            }
            $arrHour[$key]['hum'] = round($sum_hum / $inc, 2);
            $arrHour[$key]['temp'] = round($sum_temp / $inc, 2);
            $listHour[] = $key;
        }


        return view('soil_moisture.dashboard', ['arrHour' => $arrHour, 'listHour' => $listHour, 'dateNow' => $dateToday->format('d M Y')]);
    }

    public static function dashboard_ws(Request $request)
    {

        $dateToday = Carbon::now()->format('Y-m-d');
        $tglData = $request->has('tgl') ? $request->input('tgl') : $defaultHari = $dateToday;

        $convert = new DateTime($tglData);

        // dd($convert);
        // $convert->add(new DateInterval('PT7H'));

        $from = $convert->format('Y-m-d H:i:s');
        // 
        $from2 = Carbon::parse($from)->subMinutes()->subDays(7);

        // dd($from2);

        $from2 = $from2->format('Y-m-d H:i:s');
        // dd($to);
        $dateTo = Carbon::parse();

        // $dateFrom->add(new DateInterval('PT0H'));
        // dd($dateTo);
        $dateRaw = $dateTo->format('Y-m-d');
        $dateTo = $dateTo->format('Y-m-d') . ' 23:59:59';

        $to = date($dateTo);
        // dd($to);
        // dd($from2, $to);

        $sel_aws = DB::table('weather_station_list')
            ->join('db_aws_bke', 'weather_station_list.id', '=', 'db_aws_bke.idws')
            ->select('db_aws_bke.*', 'weather_station_list.rain_cal as rain_cal', 'weather_station_list.loc as loc')
            ->whereBetween('db_aws_bke.datetime', [$from2, $to])
            ->orderByDesc('db_aws_bke.id')
            ->where('db_aws_bke.idws', '=', 10)
            // ->take(1)
            ->get();


        $sel_aws = DB::table('weather_station_list')
            ->join('weather_station', 'weather_station_list.id', '=', 'weather_station.idws')
            ->select('weather_station.*', 'weather_station_list.rain_cal as rain_cal', 'weather_station_list.loc as loc')
            ->whereBetween('weather_station.date', [$from2, $to])
            ->orderByDesc('weather_station.id')
            ->where('weather_station.idws', '=', 10)
            // ->take(1)
            ->get();

        foreach ($sel_aws as $key => $value) {
            $formatted = Carbon::parse($value->date)->format('Y-m-d');
            if ($value->date == $formatted . ' 07:00:00' || $value->date == $formatted . ' 19:00:00') {
                unset($sel_aws[$key]);
            }
        }

        $sel_aws = $sel_aws->first();
        if ($sel_aws != '') {
            if ($sel_aws->rain_rate >= 0) {
                $icon = 'cloud-sun';
                $title = 'Berawan';
            } else {
                $icon = 'cloud-showers-water';
                $title = 'Hujan';
            }
            $sel_aws->date_format = Carbon::parse($sel_aws->date)->format('d M Y, H:i');
            $sel_aws->titleIcon = $title;
            $sel_aws->icon = $icon;
        }

        // dd($sel_aws);


        $aws_loc = DB::table('weather_station_list')->get();
        $aws_loc = json_decode(json_encode($aws_loc), true);

        $dateNow = Carbon::now()->format('H:i');
        // dd($aws_loc);
        $idws = 0;
        // $tglData = $request->has('tgl') ? $request->input('tgl') : $defaultHari = $dateToday;

        $date =  Carbon::now()->format('Y-m-d');

        $formatted = new DateTime($tglData);
        $formatted = $formatted->format('Y-m-d');

        $convert = $formatted . ' 00:00:00';;
        $convert = new DateTime($convert);

        $from =  $convert->format('Y-m-d H:i:s');

        $from = Carbon::parse($from)->addDays();

        $from =  $convert->format('Y-m-d H:i:s');

        $dateParse = Carbon::parse($from)->addDays(4);

        $dateParse = $dateParse->format('Y-m-d');

        $dateParse = $dateParse . ' 23:59:59';
        $to = new DateTime($dateParse);
        $to = $to->format('Y-m-d H:i:s');

        $queryPrediction =  DB::table('weather_station_list')
            ->join('db_aws_bke', 'weather_station_list.id', '=', 'db_aws_bke.idws')
            ->select('db_aws_bke.*', 'weather_station_list.rain_cal as rain_cal', 'weather_station_list.loc as loc', DB::raw("DATE_FORMAT(db_aws_bke.datetime,'%d-%m-%Y') as hari"))
            ->whereBetween('db_aws_bke.datetime', [$from, $to])
            ->get()
            ->groupBy('hari');



        $queryPredDetail =  DB::table('weather_station_list')
            ->join('db_aws_bke', 'weather_station_list.id', '=', 'db_aws_bke.idws')
            ->select('db_aws_bke.*', 'weather_station_list.rain_cal as rain_cal', 'weather_station_list.loc as loc', DB::raw("DATE_FORMAT(db_aws_bke.datetime,'%d-%m-%Y') as hari"))
            ->whereBetween('db_aws_bke.datetime', [$from, $to])
            ->where('idws', 1)
            ->get()
            ->groupBy('hari');


        $listStation = DB::table('weather_station_list')
            ->where('flags', 1)
            ->get()->toArray();


        $listStation = array_reverse($listStation);

        $dateNow = Carbon::parse()->format('Y-m-d');
        $hourNow = Carbon::now()->format('H:i:s');
        $dateNow = $dateNow . ' ' . $hourNow;


        $last12hour = Carbon::parse($dateNow)->subHours(12)->format('Y-m-d H:i:s');
        $next12hour = Carbon::parse($dateNow)->addHours(11)->format('Y-m-d H:i:s');


        $queryHistoryData =  DB::table('weather_station_list')
            ->join('weather_station', 'weather_station_list.id', '=', 'weather_station.idws')
            ->select('weather_station.*', 'weather_station_list.rain_cal as rain_cal', 'weather_station_list.loc as loc')
            ->whereBetween('weather_station.date', [$last12hour, $dateNow])
            ->where('idws', 15)
            ->orderBy('weather_station.date')
            ->get();


        $queryHistoryForecast =  DB::table('weather_station_list')
            ->join('db_aws_bke', 'weather_station_list.id', '=', 'db_aws_bke.idws')
            ->select('db_aws_bke.*', 'weather_station_list.rain_cal as rain_cal', 'weather_station_list.loc as loc')
            ->whereBetween('db_aws_bke.datetime', [$last12hour, $dateNow])
            ->where('idws', 50)
            ->orderBy('db_aws_bke.datetime')
            ->get();

        $test = $queryHistoryForecast->groupBy(function ($item) {
            return Carbon::parse($item->datetime)->format('H');
        });

        // dd($test);
        $arrHistoryDataTemp = array();
        foreach ($test as $key => $value) {
            $sum_rain_fall = 0;
            $sum_temp = 0;
            $inc = 0;

            foreach ($value as $key2 => $value2) {
                if (isset($value2->accu_rf_forecast) && isset($value2->accu_temp_forecast)) {
                    $sum_rain_fall += $value2->accu_rf_forecast;
                    $sum_temp += $value2->accu_temp_forecast;
                    $inc++;
                }
            }

            if ($sum_rain_fall == 0) {
                $icon = 'cloud-sun';
                $title = 'Berawan';
            } else if ($sum_rain_fall >= 0.1 && $sum_rain_fall < 0.5) {
                $icon = 'cloud-rain';
                $title = 'Hujan rintik';
            } else if ($sum_rain_fall >= 0.5 && $sum_rain_fall < 20) {
                $icon = 'cloud-showers-heavy';
                $title = 'Hujan ringan';
            } else if ($sum_rain_fall >= 20 && $sum_rain_fall < 50) {
                $icon = 'cloud-showers-heavy';
                $title = 'Hujan Sedang';
            } else if ($sum_rain_fall >= 50 && $sum_rain_fall < 100) {
                $icon = 'cloud-showers-heavy';
                $title = 'Hujan Lebat';
            } else if ($sum_rain_fall >= 100 && $sum_rain_fall < 150) {
                $icon = 'cloud-showers-water';
                $title = 'Hujan Sangat Lebat';
            } else {
                $icon = 'cloud-showers-water';
                $title = 'Hujan Ekstrem';
            }

            if ($inc == 0) {
                $arrHistoryDataTemp[$key . ':00']['temp'] = 0;
                $arrHistoryDataTemp[$key . ':00']['rain'] = 0;
            } else {
                $arrHistoryDataTemp[$key . ':00']['temp'] = round($sum_temp / $inc, 2);
                $arrHistoryDataTemp[$key . ':00']['rain'] = round($sum_rain_fall, 2);
            }

            $arrHistoryDataTemp[$key . ':00']['jam'] = $key . ':00';
            $arrHistoryDataTemp[$key . ':00']['icon'] = $icon;
            $arrHistoryDataTemp[$key . ':00']['title'] = $title;
        }

        $queryForecast12hour =  DB::table('weather_station_list')
            ->join('db_aws_bke', 'weather_station_list.id', '=', 'db_aws_bke.idws')
            ->select('db_aws_bke.*', 'weather_station_list.rain_cal as rain_cal', 'weather_station_list.loc as loc', DB::raw("DATE_FORMAT(db_aws_bke.datetime,'%H:%i') as hari"))
            ->whereBetween('db_aws_bke.datetime', [$dateNow, $next12hour])
            ->where('idws', 1)
            ->orderBy('db_aws_bke.datetime')
            ->get();

        $historyForecast12Hour = $queryHistoryData;

        $historyForecast12Hour = $historyForecast12Hour->groupBy(function ($item) {
            return Carbon::parse($item->date)->format('H');
        });
        $oneDay = ['00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23'];
        // dd($historyForecast12Hour);

        $arrHistoryForecast = array();
        foreach ($historyForecast12Hour as $key => $value) {
            // foreach ($value as $key2 => $val) {

            $formatted = Carbon::parse($value[0]->date)->format('Y-m-d');


            foreach ($oneDay as $key3 => $hour) {
                if ($value[0]->date == $formatted . ' ' . $hour . ':00:00') {
                    $arrHistoryForecast[$hour . ':00']['temp'] = $value[0]->accu_temp_forecast;
                    $arrHistoryForecast[$hour . ':00']['rain'] = $value[0]->accu_rf_forecast;
                }
            }
            // }
        }


        foreach ($queryHistoryData as $key => $value) {
            $formatted = Carbon::parse($value->date)->format('Y-m-d');
            if ($value->date == $formatted . ' 07:00:00' || $value->date == $formatted . ' 19:00:00') {
                unset($queryHistoryData[$key]);
            }
        }

        $queryHistoryData = $queryHistoryData->groupBy(function ($item) {
            return Carbon::parse($item->date)->format('H');
        });

        $queryForecast12hour = $queryForecast12hour->groupBy(function ($item) {
            return Carbon::parse($item->datetime)->format('H');
        });

        $arrHistoryData = array();

        $hourHistoryDate = array();
        $incAll = 1;
        foreach ($queryHistoryData as $key => $value) {
            $sum_rain_fall = 0;
            $sum_temp = 0;
            $inc = 0;

            foreach ($value as $key2 => $value2) {
                $sum_rain_fall += $value2->rain_rate;
                $sum_temp += $value2->temp_out;
                $inc++;
            }

            if ($sum_rain_fall == 0) {
                $icon = 'cloud-sun';
                $title = 'Berawan';
            } else if ($sum_rain_fall >= 0.1 && $sum_rain_fall < 0.5) {
                $icon = 'cloud-rain';
                $title = 'Hujan rintik';
            } else if ($sum_rain_fall >= 0.5 && $sum_rain_fall < 20) {
                $icon = 'cloud-showers-heavy';
                $title = 'Hujan ringan';
            } else if ($sum_rain_fall >= 20 && $sum_rain_fall < 50) {
                $icon = 'cloud-showers-heavy';
                $title = 'Hujan Sedang';
            } else if ($sum_rain_fall >= 50 && $sum_rain_fall < 100) {
                $icon = 'cloud-showers-heavy';
                $title = 'Hujan Lebat';
            } else if ($sum_rain_fall >= 100 && $sum_rain_fall < 150) {
                $icon = 'cloud-showers-water';
                $title = 'Hujan Sangat Lebat';
            } else {
                $icon = 'cloud-showers-water';
                $title = 'Hujan Ekstrem';
            }

            $arrHistoryData[$key . ':00']['temp'] = round($sum_temp / $inc, 2);
            $arrHistoryData[$key . ':00']['rain'] = round($sum_rain_fall, 2);
            $arrHistoryData[$key . ':00']['jam'] = $key . ':00';
            $arrHistoryData[$key . ':00']['icon'] = $icon;
            $arrHistoryData[$key . ':00']['title'] = $title;
            $arrHistoryData[$key . ':00']['counter'] = $incAll;
            $hourHistoryDate[] = $key . ':00';
            // $arrHistoryDataTemp[$key . ':00']['temp'] = 0;
            // $arrHistoryDataTemp[$key . ':00']['rain'] = 0;
            // $arrHistoryDataTemp[$key . ':00']['jam'] = $key . ':00';
            $incAll++;
        }

        // dd($arrHistoryDataTemp);

        $arrForecast12hour = array();
        $incAll = 1;
        $hourNext12hour = array();
        foreach ($queryForecast12hour as $key => $value) {
            $sum_rain_fall = 0;
            $sum_temp = 0;
            $inc = 0;

            foreach ($value as $key2 => $value2) {
                $sum_rain_fall += $value2->accu_rf_forecast;
                $sum_temp += $value2->accu_temp_forecast;
                $inc++;
            }

            if ($sum_rain_fall == 0) {
                $icon = 'cloud-sun';
                $title = 'Berawan';
            } else if ($sum_rain_fall >= 0.1 && $sum_rain_fall < 0.5) {
                $icon = 'cloud-rain';
                $title = 'Hujan rintik';
            } else if ($sum_rain_fall >= 0.5 && $sum_rain_fall < 20) {
                $icon = 'cloud-showers-heavy';
                $title = 'Hujan ringan';
            } else if ($sum_rain_fall >= 20 && $sum_rain_fall < 50) {
                $icon = 'cloud-showers-heavy';
                $title = 'Hujan Sedang';
            } else if ($sum_rain_fall >= 50 && $sum_rain_fall < 100) {
                $icon = 'cloud-showers-heavy';
                $title = 'Hujan Lebat';
            } else if ($sum_rain_fall >= 100 && $sum_rain_fall < 150) {
                $icon = 'cloud-showers-water';
                $title = 'Hujan Sangat Lebat';
            } else {
                $icon = 'cloud-showers-water';
                $title = 'Hujan Ekstrem';
            }

            $arrForecast12hour[$key . ':00']['temp'] = round($sum_temp / $inc, 2);
            $arrForecast12hour[$key . ':00']['rain'] = round($sum_rain_fall, 2);
            $arrForecast12hour[$key . ':00']['jam'] = $key . ':00';
            $arrForecast12hour[$key . ':00']['icon'] = $icon;
            $arrForecast12hour[$key . ':00']['title'] = $title;
            $arrForecast12hour[$key . ':00']['counter'] = $incAll;
            $hourNext12hour[] = $key . ':00';
            $incAll++;
        }

        // dd($arrForecast12hour);
        $arrOneDayForecast = array_merge($arrHistoryForecast, $arrForecast12hour);
        // dd($arrOneDayForecast);
        $loglast12hour = '';
        foreach ($arrHistoryData as $key => $value) {

            if ($value['temp'] > 30) {
                $warnaTemp = '#B50F19';
            } else if ($value['temp'] < 24) {
                $warnaTemp = '#B50F19';
            } else {
                $warnaTemp = '#C4101B';
            }

            if ($value['rain'] > 0 && $value['rain'] < 0.5) {
                $warnaRain = '#041C32';
            } else if ($value['rain'] >= 0.5 && $value['rain'] < 5) {
                $warnaRain = '#041C32';
            } else {
                $warnaRain = '#041C32';
            }

            $temp = round($value['temp'], 0);
            $jam   = $value['jam'];
            $loglast12hour .=
                "[{v:'" . $jam . "'}, {v:" . $value['rain'] . ", f:'" . $value['rain'] . " mm'},
                {v:'" . $warnaRain . "', f:'" . $warnaRain . "'}, 
                {v:" . $value['rain'] . ", f:'" . $value['rain'] . " mm '}, 
                {v:" . $temp . ", f:'" . $temp . " �� '},                        
                {v:'" . $warnaTemp . "', f:'" . $warnaTemp . "'}, 
                {v:" . $temp . ", f:'" . $temp . " �� '} 
            ],";
        }


        $arrlogLast12hour = [
            'plot1'     => 'Curah Hujan (mm)',
            'plot2'     => 'Temperatur (C)',
            'data'      => $loglast12hour
        ];




        $arrPagiMalam = array();
        $arrPred = array();
        foreach ($queryPredDetail as $key => $value) {
            $jamConvert = Carbon::parse($key)->format('D d');

            $inc = 1;
            $sum_rain = 0;
            $sum_hoursofrain = 0;
            foreach ($value as $key2 => $data) {
                $jam = Carbon::parse($data->datetime)->format('H:i:s');


                $sum_rain += $data->accu_rf_forecast;
                $sum_hoursofrain += $data->accu_hours_of_rain;

                if ($data->accu_rf_forecast >= 0 && $data->accu_rf_forecast < 0.5) {
                    $icon = 'cloud-sun';
                    $title = 'Cerah Berawan';
                } else if ($data->accu_rf_forecast >= 0.5 && $data->accu_rf_forecast < 20) {
                    $icon = 'cloud-rain';
                    $title = 'Hujan Ringan';
                } else if ($data->accu_rf_forecast >= 20 && $data->accu_rf_forecast < 50) {
                    $icon = 'cloud-rain';
                    $title = 'Hujan Sedang';
                } else if ($data->accu_rf_forecast >= 50 && $data->accu_rf_forecast < 100) {
                    $icon = 'cloud-showers-heavy';
                    $title = 'Hujan Lebat';
                } else if ($data->accu_rf_forecast >= 100 && $data->accu_rf_forecast < 150) {
                    $icon = 'cloud-showers-water';
                    $title = 'Hujan Sangat Lebat';
                } else {
                    $icon = 'cloud-showers-water';
                    $title = 'Hujan Ekstrem';
                }

                if ($jam == '07:00:00') {
                    $directions = array('N', 'NNE', 'NE', 'ENE', 'E', 'ESE', 'SE', 'SSE', 'S', 'SSW', 'SW', 'WSW', 'W', 'WNW', 'NW', 'NNW', 'N');
                    // $dir = $directions[round($data->accu_windir_forecast / 22.5)];
                    if ($data->accu_windir_forecast != '' || $data->accu_windir_forecast != 0) {
                        $dir = $data->accu_windir_forecast;
                    } else {
                        $dir = $directions[round($data->accu_windir_forecast / 22.5)];
                    }
                    $arrPagiMalam[$jamConvert]['Pagi']['temp'] = $data->accu_temp_forecast ?: 0;
                    $arrPagiMalam[$jamConvert]['Pagi']['ws'] = $data->accu_ws_forecast;
                    $arrPagiMalam[$jamConvert]['Pagi']['winddir'] = $dir;
                    $arrPagiMalam[$jamConvert]['Pagi']['rain'] = round($data->accu_rf_forecast, 2);
                    $arrPagiMalam[$jamConvert]['Pagi']['hoursOfRain'] = $data->accu_hours_of_rain ?: 0;
                    $arrPagiMalam[$jamConvert]['Pagi']['rain_probability'] = $data->accu_rain_probability ?: 0;
                    $arrPagiMalam[$jamConvert]['Pagi']['icon'] = $icon;
                    $arrPagiMalam[$jamConvert]['Pagi']['title'] = $title;
                    $arrPagiMalam[$jamConvert]['Pagi']['waktu'] = 'Pagi';
                    $arrPagiMalam[$jamConvert]['Pagi']['jam'] = '00:00 - 12:00';
                    $arrPred[$jamConvert]['max_temp'] = $data->accu_temp_forecast;
                } else if ($jam == '19:00:00') {
                    $directions = array('N', 'NNE', 'NE', 'ENE', 'E', 'ESE', 'SE', 'SSE', 'S', 'SSW', 'SW', 'WSW', 'W', 'WNW', 'NW', 'NNW', 'N');
                    // $dir = $directions[round($data->accu_windir_forecast / 22.5)];
                    if ($data->accu_windir_forecast != '' || $data->accu_windir_forecast != 0) {
                        $dir = $data->accu_windir_forecast;
                    } else {
                        $dir = $directions[round($data->accu_windir_forecast / 22.5)];
                    }
                    $arrPagiMalam[$jamConvert]['Malam']['temp'] =  $data->accu_temp_forecast ?: 0;
                    $arrPagiMalam[$jamConvert]['Malam']['ws'] = $data->accu_ws_forecast;
                    $arrPagiMalam[$jamConvert]['Malam']['winddir'] = $dir;
                    $arrPagiMalam[$jamConvert]['Malam']['rain'] = round($data->accu_rf_forecast, 2);
                    $arrPagiMalam[$jamConvert]['Malam']['hoursOfRain'] = $data->accu_hours_of_rain ?: 0;
                    $arrPagiMalam[$jamConvert]['Malam']['rain_probability'] = $data->accu_rain_probability ?: 0;
                    $arrPagiMalam[$jamConvert]['Malam']['icon'] = $icon;
                    $arrPagiMalam[$jamConvert]['Malam']['title'] = $title;
                    $arrPagiMalam[$jamConvert]['Malam']['waktu'] = 'Malam';
                    $arrPagiMalam[$jamConvert]['Malam']['jam'] = '12:00 - 23:59';
                    $arrPred[$jamConvert]['min_temp'] = $data->accu_temp_forecast;
                }
            }



            $sum_rain = round($sum_rain, 2);

            if ($sum_rain >= 0 && $sum_rain < 0.5) {
                $icon = 'cloud-sun';
                $title = 'Cerah Berawan';
            } else if ($sum_rain >= 0.5 && $sum_rain < 20) {
                $icon = 'cloud-rain';
                $title = 'Hujan Ringan';
            } else if ($sum_rain >= 20 && $sum_rain < 50) {
                $icon = 'cloud-rain';
                $title = 'Hujan Sedang';
            } else if ($sum_rain >= 50 && $sum_rain < 100) {
                $icon = 'cloud-showers-heavy';
                $title = 'Hujan Lebat';
            } else if ($sum_rain >= 100 && $sum_rain < 150) {
                $icon = 'cloud-showers-water';
                $title = 'Hujan Sangat Lebat';
            } else {
                $icon = 'cloud-showers-water';
                $title = 'Hujan Ekstrem';
            }
            $arrPred[$jamConvert]['rain_hours'] = $sum_hoursofrain;
            $arrPred[$jamConvert]['rain'] = round($sum_rain, 2);
            $arrPred[$jamConvert]['icon'] = $icon;
            $arrPred[$jamConvert]['title'] = $title;
            $inc++;
        }

        // dd($arrHistoryData);
        // dd($arrForecast12hour);

        $arrForecastNew12hour = array_merge($arrHistoryDataTemp, $arrForecast12hour);

        $dateToday =  Carbon::parse('');
        $yesterday = Carbon::parse($dateToday)->subDay();

        $query =  DB::table('soil_moisture')
            ->select('soil_moisture.*',  DB::raw("DATE_FORMAT(soil_moisture.datetime,'%H:00') as jam"))
            ->whereBetween('soil_moisture.datetime', [$yesterday, $dateToday])
            // ->where('soil_moisture.datetime', 'like', '%2023-01-06%')
            ->orderBy('soil_moisture.datetime')
            ->get()
            ->groupBy('jam');

        $listHour = array();
        $arrHour = array();
        foreach ($query as $key => $value) {
            $sum_hum = 0;
            $sum_temp = 0;
            $inc = 0;
            foreach ($value as $key2 => $data) {
                $sum_hum += $data->hum1;
                $sum_temp += $data->temp;
                $inc++;
            }
            $arrHour[$key]['hum'] = round($sum_hum / $inc, 2);
            $arrHour[$key]['temp'] = round($sum_temp / $inc, 2);
            $listHour[] = $key;
        }

        return view('weather_station/dashboard', ['arrForecastNew12hour' => $arrForecastNew12hour, 'arrForecast12hour' => $arrForecast12hour, 'hourHistoryDate' => $hourHistoryDate, 'arrPagiMalam' => $arrPagiMalam, 'aws_loc' => $aws_loc, 'aktual' => $sel_aws, 'date' => $convert->format('d M') . ' ' . $dateNow, 'forecasting' => $arrPred, 'arrlogLast12hour' => $arrlogLast12hour, 'arrHistoryData' => $arrHistoryData, 'arrOneDayForecast' => $arrOneDayForecast, 'listStation' => $listStation, 'listHour' => $listHour, 'arrHour' => $arrHour]);
    }

    public function compareWeather(Request $request)
    {
        if ($request->ajax()) {
            $query =  DB::table('weather_station_list')
                ->join('db_aws_bke', 'weather_station_list.id', '=', 'db_aws_bke.idws')
                ->select('db_aws_bke.*', 'weather_station_list.rain_cal as rain_cal', 'weather_station_list.loc as loc', DB::raw("DATE_FORMAT(db_aws_bke.datetime,'%Y-%m-%d') as hari"))
                ->get()
                ->groupBy('hari');

            $query = json_decode(json_encode($query), true);
            $arrAllData = array();
            $incArr = 0;
            foreach ($query as $key => $value) {
                $sum_wind_speed_real = 0;
                $sum_rain_fall_real = 0;
                $sum_temp_real = 0;
                $sum_hum_real = 0;
                $sum_rf_forecast  = 0;
                $sum_hum_forecast = 0;
                $sum_temp_forecast = 0;
                $sum_accu_rf_forecast = 0;
                $sum_accu_hum_foreacast = 0;
                $sum_accu_temp_foreacast = 0;
                $sum_accu_rf_forecast = 0;
                $sum_accu_hum_aktual = 0;
                $sum_accu_temp_aktual = 0;
                $sum_accu_rf_aktual = 0;
                $inc = 0;
                foreach ($value as $key2 => $data) {
                    $sum_wind_speed_real += $data['wind_speed_real'];
                    $sum_rain_fall_real += $data['rain_fall_real'];
                    $sum_temp_real += $data['temp_real'];
                    $sum_hum_real += $data['hum_real'];

                    $sum_rf_forecast += $data['rain_forecast'];
                    $sum_hum_forecast += $data['hum_forecast'];
                    $sum_temp_forecast += $data['temp_forecast'];

                    $sum_accu_rf_forecast += $data['accu_rf_forecast'];
                    $sum_accu_hum_foreacast += $data['accu_hum_forecast'];
                    $sum_accu_temp_foreacast += $data['accu_temp_forecast'];

                    $sum_accu_rf_aktual += $data['accu_aktual_rain'];
                    $sum_accu_temp_aktual += $data['accu_aktual_temp'];
                    $sum_accu_hum_aktual += $data['accu_aktual_hum'];

                    $inc++;
                }
                $arrAllData[$incArr]['tanggal'] = $key;
                $arrAllData[$incArr]['wind_speed'] = round($sum_wind_speed_real / $inc, 2);
                $arrAllData[$incArr]['rain'] =  $sum_rain_fall_real;
                $arrAllData[$incArr]['temp'] = round($sum_temp_real / $inc, 2);
                $arrAllData[$incArr]['hum'] = round($sum_hum_real / $inc, 2);

                $arrAllData[$incArr]['rain_forecast'] =   $sum_rf_forecast;
                $arrAllData[$incArr]['temp_forecast'] = round($sum_accu_temp_foreacast / $inc, 2);
                $arrAllData[$incArr]['hum_forecast'] =    round($sum_accu_hum_foreacast / $inc, 2);

                $arrAllData[$incArr]['accu_rain'] = $sum_accu_rf_aktual;
                $arrAllData[$incArr]['accu_temp'] = round($sum_accu_temp_aktual / $inc, 2);
                $arrAllData[$incArr]['accu_hum'] = round($sum_accu_hum_aktual / $inc, 2);

                $arrAllData[$incArr]['accu_rain_forecast'] =    $sum_accu_rf_forecast;
                $arrAllData[$incArr]['accu_temp_forecast'] =   round($sum_accu_temp_foreacast / $inc, 2);
                $arrAllData[$incArr]['accu_hum_forecast'] =   round($sum_accu_hum_foreacast / $inc, 2);
                $incArr++;
            }

            return DataTables::of($arrAllData)
                ->editColumn('akurasi_accu', function ($model) {
                    return '-';
                })
                ->editColumn('akurasi_srs', function ($model) {
                    return '-';
                })
                ->editColumn('accu_ws_forecast', function ($model) {
                    return '-';
                })
                ->editColumn('accu_winddir_forecast', function ($model) {
                    return '-';
                })
                ->editColumn('accu_ws', function ($model) {
                    return '-';
                })
                ->editColumn('accu_winddir', function ($model) {
                    return '-';
                })
                ->editColumn('wind_dir_forecast', function ($model) {
                    return '-';
                })
                ->editColumn('wind_speed_forecast', function ($model) {
                    return '-';
                })
                ->editColumn('rain_forecast', function ($model) {
                    return round($model['rain_forecast'], 2);
                })
                ->editColumn('rain', function ($model) {
                    return round($model['rain'], 2);
                })
                ->editColumn('wind_dir', function ($model) {
                    return '-';
                })
                ->make(true);
        }
        return view('weather_station.compare');
    }

    public function storeAktualWS(Request $request)
    {
        $messages = [
            'required' => ':attribute tidak boleh kosong!!!',
            'min' => ':attribute harus diisi minimal :min karakter ya cuy!!!',
            'max' => ':attribute harus diisi maksimal :max karakter ya cuy!!!',
        ];

        $request->validate([
            'temp' => 'required|numeric',
            'hum' => 'required|numeric',
            'tgl' => 'required',
            'windspeed' => 'required',
        ], $messages);

        $dt = $request->tgl . ' ' . $request->time . ':00';

        $minute = explode(':', $request->time);

        $hourNow = new DateTime();
        $date = new DateTime($request->timestamp);
        $dateInput = $date->format('Y-m-d') . ' ' . $hourNow->format('H:i:s');


        $dbCheck = DB::table('db_aws_bke')
            ->select('db_aws_bke.*')
            ->where('db_aws_bke.datetime', $dt)
            ->first();

        if (!empty($dbCheck)) {
            $id = (int)$dbCheck->id;
        }

        //check same date data 

        if ($minute[1] != '00') {
            return redirect()->route('aktualws.index')
                ->with('error', 'Data input format menit salah');
        }

        // dd($request->temp, $request->hum);

        DB::table('db_aws_bke')
            ->where('id', $id)
            ->update(
                // ['datetime' => $dt],
                ['temp_real' => $request->temp, 'rain_fall_real' => $request->ch, 'hum_real' => $request->hum,  'wind_direction_real' => $request->winddir, 'wind_speed_real' => $request->windspeed]

            );

        return redirect()->route('aktualws.index')
            ->with('success', 'Data Aktual ' . $dt . ' berhasil disimpan/update.');
    }

    public function getAktualDB(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('db_aws_bke')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
    }

    public function formAktualWS()
    {
        $data = DB::table('db_aws_bke')->take(20)->get();

        // dd($data[0]);

        // foreach ($data as $item) {
        //     $hari = Carbon::parse($item->timestamp)->locale('id');
        //     $hari->settings(['formatFunction' => 'translatedFormat']);
        //     $item->tanggal = $hari->format('j F Y');
        //     $item->tanggal = $hari->format('j F Y');
        // }
        return view('weather_station.aktual.index', ['data' => $data]);
    }
    public function deleteAktualWS($id)
    {
        // $data = DB::table('oer')->where('id', $id)->get();
        DB::delete('delete from oer where id = ?', [$id]);
        // dd($data);
        // $data->delete();
        return Redirect::back()->with(['success' => 'Berhasil menghapus data oer']);
    }

    public function getHistoryRainRate(Request $request)
    {
        $id_loc = $request->get('id_loc');

        $startDate = Carbon::now()->subDays(30)->format('Y-m-d H:i:s');
        $endDate = Carbon::now()->format('Y-m-d H:i:s');

        $query = DB::table('weather_station_list')
            ->join('weather_station', 'weather_station_list.id', '=', 'weather_station.idws')
            ->select('weather_station.*')
            ->whereBetween('weather_station.date', [$startDate, $endDate])
            ->where('weather_station.idws', $id_loc)
            ->get();

        $query = $query->groupBy(function ($item) {
            $date = Carbon::parse($item->date);
            $indonesianMonth = [
                1 => 'Jan',
                2 => 'Feb',
                3 => 'Mar',
                4 => 'Apr',
                5 => 'Mei',
                6 => 'Jun',
                7 => 'Jul',
                8 => 'Ags',
                9 => 'Sep',
                10 => 'Okt',
                11 => 'Nov',
                12 => 'Des',
            ];
            $formattedDate = $date->format('d') . ' ' . $indonesianMonth[$date->month];
            return $formattedDate;
        });

        $arrRainRate = array();
        foreach ($query as $key => $value) {
            $sum_rain_rate = 0;
            foreach ($value as $key1 => $value1) {
                $sum_rain_rate += $value1->rain_rate;
            }
            $arrRainRate[$key] = round($sum_rain_rate, 0);
        }

        $cumulativeSum = 0;
        foreach ($arrRainRate as $key => $value) {
            $cumulativeSum += $value;
            $arrRrNow[$key] =  round($cumulativeSum, 0);
        }

        $sum_month = 0;
        foreach ($arrRrNow as $key => $value) {
            $sum_month += round($value, 0);
        }
        $averageRrDay = round($sum_month / count($arrRrNow), 0);
        $lastIndex = end($arrRrNow);

        $arrData = array();
        $arrData['avgDaily'] = $averageRrDay;
        $arrData['sumMonth'] = $lastIndex;
        $arrData['dataChart1'] = $arrRrNow;
        $arrData['dataChart2'] = $arrRainRate;

        echo json_encode($arrData);
        exit();
    }

    public function getHistoryForecastDay(Request $request)
    {
        $id_loc = $request->get('id_loc');


        $dateToday = Carbon::now()->format('Y-m-d');

        $tglData = $request->has('tgl') ? $request->input('tgl') : $defaultHari = $dateToday;

        $formatted = new DateTime($tglData);
        $formatted = $formatted->format('Y-m-d');

        $convert = $formatted . ' 00:00:00';;
        $convert = new DateTime($convert);

        $from =  $convert->format('Y-m-d H:i:s');

        $from = Carbon::parse($from)->addDays();

        $from =  $convert->format('Y-m-d H:i:s');

        $dateParse = Carbon::parse($from)->addDays(4);

        $dateParse = $dateParse->format('Y-m-d');

        $dateParse = $dateParse . ' 23:59:59';
        $to = new DateTime($dateParse);
        $to = $to->format('Y-m-d H:i:s');


        $convert = new DateTime();


        $from = $convert->format('Y-m-d H:i:s');
        // 
        $from2 = Carbon::parse($from)->subMinutes()->subDays(7);

        // dd($from2);

        $from2 = $from2->format('Y-m-d H:i:s');
        // dd($to);
        $dateTo = Carbon::parse();

        // $dateFrom->add(new DateInterval('PT0H'));
        // dd($dateTo);
        $dateRaw = $dateTo->format('Y-m-d');
        $dateTo = $dateTo->format('Y-m-d') . ' 23:59:59';


        $to = date($dateTo);

        $listLocActive = DB::table('weather_station_list')
            ->where('weather_station_list.id', '!=', $id_loc)
            ->get();


        $last_update_each_device = [];
        foreach ($listLocActive as $key => $value) {
            $query = DB::table('weather_station')
                ->where('weather_station.idws', '=', $value->id)
                ->orderByDesc('id')
                ->first();

            // Check if the query result is not null
            if ($query) {
                $last_update_each_device[$key]['temp_out'] = $query->temp_out . ' °C' ?? '-';
                $last_update_each_device[$key]['hum_out'] = $query->hum_out ?? '-';
                $last_update_each_device[$key]['uv'] = $query->uv ?? '-';
                $last_update_each_device[$key]['rain_rate'] = $query->rain_rate ?? '-';
                $last_update_each_device[$key]['windspeedkmh'] = $query->windspeedkmh ?? '-';
                $last_update_each_device[$key]['location'] = $value->loc;
            } else {
                // Handle the case when the query result is null
                // You can set default values or take any other appropriate action
                $last_update_each_device[$key] = [
                    'temp_out' => '-',
                    'hum_out' => '-',
                    'uv' => '-',
                    'rain_rate' => '-',
                    'windspeedkmh' => '-',
                    'location' => $value->loc,
                ];
            }
        }

        $now = Carbon::now();
        $sixHoursAgo = $now->copy()->subHours(6);

        $lastRainDate = DB::table('weather_station_list')
            ->join('weather_station', 'weather_station_list.id', '=', 'weather_station.idws')
            ->where('weather_station.idws', '=', $id_loc)
            ->where('weather_station.rain_rate', '>', 0)
            ->orderBy('weather_station.date', 'desc')
            ->first();


        $avgLatestRain = 0;
        $lastIntensityRain = 0;
        $latestHourRainIntensity = [];
        $latestRainIntensity = [];

        $awalHujan = '';
        $akhirHujan = '';
        if ($lastRainDate) {
            $lastIntensityRain = $lastRainDate->rain_rate;
            $lastRainDate = $lastRainDate->date;
            $lastRainDateFormat = Carbon::parse($lastRainDate)->format('l - d M, H:i');
            $last12HourFromLastData = Carbon::parse($lastRainDate)->subHours(12);
            $latestRain = DB::table('weather_station_list')
                ->join('weather_station', 'weather_station_list.id', '=', 'weather_station.idws')
                ->where('weather_station.idws', '=', $id_loc)
                ->where('weather_station.date', '<=', $lastRainDate)
                ->where('weather_station.rain_rate', '>', 0)
                ->where('weather_station.date', '>=', $last12HourFromLastData)
                ->orderBy('weather_station.date', 'desc')
                ->get();

            $groupLatestRain = $latestRain->groupBy(function ($item) {
                // Extract the hour from the date
                return Carbon::parse($item->date)->format('H:00');
            });

            $groupLatestRain = json_decode($groupLatestRain, true);
            $dataDay = [];

            $inc = 0;
            $previousHour = null;
            foreach ($groupLatestRain as $key => $value) {

                $rain = 0;

                $akhirHujanPerJam = $value[0]['date'];
                $jumlahArr = count($value);
                $awalHujanPerJam = $value[$jumlahArr - 1]['date'];
                foreach ($value as $key2 => $value2) {
                    $rain += $value2['rain_rate'];
                }

                // if ($rain == 0) {
                //     break;
                // }
                $currentHour = Carbon::createFromFormat('H:i', $key);

                if ($previousHour !== null && !$currentHour->addHour()->eq($previousHour)) {
                    break;
                }

                $previousHour = $currentHour;

                $dataDay[$key]['rain'] = $rain;
                $dataDay[$key]['jamAwalHujan'] = $awalHujanPerJam;
                $dataDay[$key]['jamAkhirHujan'] = $akhirHujanPerJam;

                $inc++;
            }

            $awalHujan = array_values($dataDay)[count($dataDay) - 1]['jamAwalHujan'];
            $akhirHujan = array_values($dataDay)[0]['jamAkhirHujan'];



            foreach ($dataDay as $key => $value) {
                $latestHourRainIntensity[] = $key;
                $latestRainIntensity[] = round($value['rain'], 2);
                $avgLatestRain = round(($value['rain'] / $inc), 2);
            }
            $latestHourRainIntensity = array_reverse($latestHourRainIntensity);
            $latestRainIntensity = array_reverse($latestRainIntensity);
        }




        $lastDataDate = DB::table('weather_station_list')
            ->join('weather_station', 'weather_station_list.id', '=', 'weather_station.idws')
            ->where('weather_station.idws', '=', $id_loc)
            ->orderBy('weather_station.date', 'desc')
            ->first();

        if ($lastDataDate) {
            $lastDataDate = $lastDataDate->date;

            $latestWeatherData = DB::table('weather_station_list')
                ->join('weather_station', 'weather_station_list.id', '=', 'weather_station.idws')
                ->where('weather_station.idws', '=', $id_loc)
                ->where('weather_station.date', '>=', Carbon::parse($lastDataDate)->subHours(12))
                ->orderBy('weather_station.date', 'desc')
                ->get();

            $groupedWeatherData = $latestWeatherData->groupBy(function ($item) {
                // Extract the hour from the date
                return Carbon::parse($item->date)->format('H:00');
            });

            $groupedWeatherData = json_decode($groupedWeatherData, true);

            $dataDay = [];
            foreach ($groupedWeatherData as $key => $value) {

                $avg = 0;
                $temp = 0;
                $rain = 0;
                foreach ($value as $key2 => $value2) {
                    $avg = count($value);

                    $temp += $value2['temp_out'];
                    $rain += $value2['rain_rate'];
                }

                $dataDay[$key]['temp'] = round($temp / $avg, 2);
                $dataDay[$key]['rain'] = $rain;
            }

            foreach ($dataDay as $key => $value) {
                $keydata[] = $key;
                $valdata[] = $value['temp'];
                $valdatarain[] = round($value['rain'], 2);
            }

            $keydata = array_reverse($keydata);
            $valdata = array_reverse($valdata);
            $valdatarain = array_reverse($valdatarain);
        }







        $sel_aws = DB::table('weather_station_list')
            ->join('weather_station', 'weather_station_list.id', '=', 'weather_station.idws')
            ->select('weather_station.*', 'weather_station_list.rain_cal as rain_cal', 'weather_station_list.loc as loc')
            // ->whereBetween('weather_station.date', [$from2, $to])
            ->orderByDesc('weather_station.id')
            ->where('weather_station.idws', '=', $id_loc)
            // ->take(1)
            ->first();



        $formatted = Carbon::parse($sel_aws->date)->format('Y-m-d');
        if ($sel_aws->date == $formatted . ' 07:00:00' || $sel_aws->date == $formatted . ' 19:00:00') {
            unset($sel_aws[$key]);
        }



        // $sel_aws = $sel_aws->first();
        if ($sel_aws != '') {
            if ($sel_aws->rain_rate == 0) {
                $icon = 'fa-cloud-sun';
                $title = 'Berawan';
            } else {
                $icon = 'fa-cloud-showers-water';
                $title = 'Hujan';
            }
            $sel_aws->date_format = Carbon::parse($sel_aws->date)->format('d M, H:i');
            $sel_aws->titleIcon = $title;
            $sel_aws->icon = $icon;
            $directionsEnglish = array('N', 'NNE', 'NE', 'ENE', 'E', 'ESE', 'SE', 'SSE', 'S', 'SSW', 'SW', 'WSW', 'W', 'WNW', 'NW', 'NNW', 'N');
            $directionsIndonesian = array('Utara', 'Utara Timur Laut', 'Timur Laut', 'Timur Laut Timur', 'Timur', 'Tenggara Timur', 'Tenggara', 'Selatan Tenggara', 'Selatan', 'Barat Daya Selatan', 'Barat Daya', 'Barat Barat Daya', 'Barat', 'Barat Laut Barat', 'Barat Laut', 'Utara Barat Laut', 'Utara');

            $dirIndex = round($sel_aws->winddir / 22.5);
            $dirIndex = ($dirIndex % 16); // Ensure the index falls within the range

            $englishDirection = $directionsEnglish[$dirIndex];
            $indonesianDirection = $directionsIndonesian[$dirIndex];

            $sel_aws->windDirEnglish = $englishDirection;
            $sel_aws->windDirIndonesian = $indonesianDirection;
        }

        $carbonDate = Carbon::parse($sel_aws->date);
        $getdate = $carbonDate->format('Y-m-d');

        $queryDay = DB::table('weather_station_list')
            ->join('weather_station', 'weather_station_list.id', '=', 'weather_station.idws')
            ->select('weather_station.*', 'weather_station_list.rain_cal as rain_cal', 'weather_station_list.loc as loc', DB::raw("CONCAT(DATE_FORMAT(weather_station.date,'%H'), ':00') as jam_ke"))
            ->where('weather_station.idws', '=', $id_loc)
            ->where('weather_station.date', 'LIKE', '%' . $getdate . '%')
            ->get();

        $queryDay = $queryDay->groupBy('jam_ke');
        $queryDay = json_decode($queryDay, true);

        $arrData = array();
        $arrData['dataAktual'] = $sel_aws;

        $arrData['last_update_each_loc'] = $last_update_each_device;
        $arrData['keydata'] = $keydata;
        $arrData['valdata'] = $valdata;
        $arrData['rain'] = $valdatarain;
        $arrData['latestRainIntensity'] = $latestRainIntensity;
        $arrData['latestHourRainIntensity'] = $latestHourRainIntensity;
        $arrData['lastIntensityRain'] =  round($lastIntensityRain, 2);
        $arrData['avgLatestRain'] = $avgLatestRain;
        $arrData['lastRainDateFormat'] = $lastRainDateFormat;
        $arrData['awalHujan'] = Carbon::parse($awalHujan)->format('H:i');
        $arrData['akhirHujan'] = Carbon::parse($akhirHujan)->format('H:i');

        // dd($arrData);co


        echo json_encode($arrData);
    }

    public static function exportAktual()
    {
        $queryHistoryData =  DB::table('weather_station_list')
            ->join('db_aws_bke', 'weather_station_list.id', '=', 'db_aws_bke.idws')
            ->select('db_aws_bke.*', DB::raw("DATE_FORMAT(db_aws_bke.datetime, '%Y-%m-%d') as tgl"), DB::raw("DATE_FORMAT(db_aws_bke.datetime, '%H:%i') as jam"), 'weather_station_list.loc as loc')
            ->where('idws', 1)
            ->where('db_aws_bke.datetime', '!=', '')
            ->orderBy('db_aws_bke.datetime', 'asc')
            ->get();

        $his = json_decode($queryHistoryData, true);
        // dd($his);

        return view('exportAktual', ['historyData' => $his]);
    }

    public static function Grafik()
    {

        $listLoc = DB::table('weather_station_list')
            ->where('flags', '1')
            ->pluck('loc');

        $arrJam = ['00:00', '01:00', '02:00', '03:00', '04:00', '05:00', '06:00', '07:00', '08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00', '21:00', '22:00', '23:00'];
        return view('weather_station/grafik', ['listStation' => $listLoc, 'arrJam' => $arrJam]);
    }


    public static function get_data_24hour(Request $request)
    {

        $loc = $request->get('loc');
        $tgl = $request->get('tgl');
        $params = $request->get('params');

        $arrJam = ['00:00', '01:00', '02:00', '03:00', '04:00', '05:00', '06:00', '07:00', '08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00', '21:00', '22:00', '23:00'];
        $query = DB::table('weather_station_list')
            ->join('weather_station', 'weather_station_list.id', '=', 'weather_station.idws')
            ->select('weather_station.*', DB::raw('DATE_FORMAT(date, "%H:00") as hour'))

            ->where(DB::raw("(DATE_FORMAT(weather_station.date,'%Y-%m-%d'))"), '=', $tgl)
            ->where('weather_station_list.loc', '=', $loc)
            ->get()->groupBy('hour');



        $arr_per_hour = [];
        if ($query) {
            foreach ($query as $key => $value) {
                $sum = 0;
                $inc = 0;
                $result = 0;
                foreach ($value as $key2 => $value2) {

                    $value2 = json_decode(json_encode($value2), true);
                    $sum += $value2[$params];
                    $inc++;
                }

                $result = $sum;
                if ($params == 'temp_out' || $params == 'hum_out' || $params == 'uv' || $params == 'solar_radiation' || $params == 'windspeedkmh') {
                    $result = round($sum / $inc, 2);
                }

                $formattedNumber = number_format($result, 2);
                $floatValue = floatval($formattedNumber);
                $arr_per_hour[$key] = $floatValue;
            }
        }



        switch ($params) {
            case 'rain_rate':

                $params_name = 'Curah Hujan (mm/jam)';
                break;
            case 'temp_out':

                $params_name = 'Temperatur (°C)';
                break;
            case 'hum_out':
                $params_name = 'Kelembaban (%RH)';
                break;
            case 'uv':
                $params_name = 'UV';
                break;
            case 'solar_radiation':
                $params_name = 'Radiasi Matahari (W/m²)';
                break;
            case 'windspeedkmh':
                $params_name = 'Kecepatan Angin (km/jam)';
                break;

            default:
                // Handle the default case if needed
                break;
        }
        $resultArray = array_merge(array_fill_keys($arrJam, 0), $arr_per_hour);
        $resultArray = array_values($resultArray);

        $arrData = array();
        $arrData['data'] = $resultArray;
        $arrData['jam'] = $arrJam;
        $arrData['params'] = $params_name;

        echo json_encode($arrData);
    }

    public static function generateDataGrafik(Request $request)
    {

        $lokasi = $request->get('lokasi');
        $params = $request->get('params');
        $tgl = $request->get('tanggal');
        $startWeek = $request->get('tglAwalMinggu');
        $startWeek = explode(', ', $startWeek)[1];
        $endWeek = $request->get('tglAkhirMinggu');
        $endWeek = explode(', ', $endWeek)[1];
        $bulanTahun = $request->get('bulan');

        $arr = explode(' ', $bulanTahun);
        $bulan = $arr[0];
        $tahun = $arr[1];


        switch ($params) {
            case 'Curah Hujan':
                $params = 'rain_rate';
                break;
            case 'Temperatur':
                $params = 'temp_out';
                break;
            case 'Kelembaban':
                $params = 'hum_out';
                break;
            case 'UV':
                $params = 'uv';
                break;
            case 'Radiasi Matahari':
                $params = 'solar_radiation';
                break;
            case 'Kecepatan Angin':
                $params = 'windspeedkmh';
                break;

            default:
                # code...
                break;
        }

        $hours = [];
        for ($i = 0; $i < 24; $i++) {
            $hour = str_pad($i, 2, '0', STR_PAD_LEFT);
            $hours[] = $hour . ':00';
        }

        //nilai default
        $arrDayResult = array();
        foreach ($hours as $key => $value) {
            $arrDayResult[$value] = 0;
        }

        $queryID = DB::table('weather_station_list')
            ->where('loc', $lokasi)
            ->first()->id;

        $queryRawDay = DB::table('weather_station')
            ->select('weather_station.*', DB::raw('DATE_FORMAT(date, "%H:00") as hour'))

            ->where('weather_station.idws', '=', $queryID)
            ->whereRaw('DATE_FORMAT(date, "%Y-%m-%d") = ?', [$tgl])
            ->orderBy('weather_station.date', 'asc')
            ->get()
            ->groupBy('hour');

        if (!$queryRawDay->isEmpty()) {
            foreach ($queryRawDay as $key => $value) {
                $sum = 0;
                $inc = 0;
                foreach ($value as $key2 => $value2) {
                    $sum += $value2->$params;
                    $inc++;
                }

                if ($params != 'rain_rate') {
                    if ($params == 'uv') {
                        $sum = round($sum / $inc);
                    } else {
                        $sum = round($sum / $inc, 2);
                    }
                }

                $arrDayResult[$key] = $sum;
            }
        }


        //nilai default 0 dalam 1 week pada tanggal pilihan
        $arrWeekResult = [];
        // Map Indonesian month names to English month names
        $monthTranslations = [
            'Januari' => 'January',
            'Februari' => 'February',
            'Maret' => 'March',
            'April' => 'April',
            'Mei' => 'May',
            'Juni' => 'June',
            'Juli' => 'July',
            'Agustus' => 'August',
            'September' => 'September',
            'Oktober' => 'October',
            'November' => 'November',
            'Desember' => 'December',
        ];

        $reverseTranslations = array_flip($monthTranslations);
        $currentDate = Carbon::createFromFormat('d F Y', strtr($startWeek, $monthTranslations));
        $endDate = Carbon::createFromFormat('d F Y', strtr($endWeek, $monthTranslations));
        $startDateFormatted = $currentDate->format('Y-m-d');
        $endDateFormatted = $endDate->format('Y-m-d');

        while ($currentDate <= $endDate) {
            $formattedDate = $currentDate->format('d M');
            // Reverse translate the month name
            // $englishMonth = $currentDate->format('F');
            // $indonesianMonth = $reverseTranslations[$englishMonth];

            // $formattedDate = str_replace($englishMonth, $indonesianMonth, $formattedDate);
            $arrWeekResult[$formattedDate] = 0;
            $currentDate->addDay();
        }

        $queryRawWeek = DB::table('weather_station')
            // ->select('weather_station.*', DB::raw('DATE_FORMAT(date, "%d %M") as tgl'))
            ->where('weather_station.idws', '=', $queryID)
            ->whereRaw('DATE(date) BETWEEN ? AND ?', [$startDateFormatted, $endDateFormatted])
            ->orderBy('weather_station.date', 'asc')
            ->get();

        if (!$queryRawWeek->isEmpty()) {
            foreach ($queryRawWeek as $key => $value) {
                $date = Carbon::parse($value->date);
                $indonesianMonth = [
                    1 => 'Jan',
                    2 => 'Feb',
                    3 => 'Mar',
                    4 => 'Apr',
                    5 => 'Mei',
                    6 => 'Jun',
                    7 => 'Jul',
                    8 => 'Ags',
                    9 => 'Sep',
                    10 => 'Okt',
                    11 => 'Nov',
                    12 => 'Des',
                ];
                $value->tgl = $date->format('d') . ' ' . $indonesianMonth[$date->month];
            }

            $queryWeek = $queryRawWeek->groupBy('tgl');

            foreach ($queryWeek as $key => $value) {
                $sum = 0;
                $inc = 0;
                foreach ($value as $key2 => $value2) {
                    $sum += $value2->$params;
                    $inc++;
                }

                if ($params != 'rain_rate') {
                    if ($params == 'uv') {
                        $sum = round($sum / $inc);
                    } else {
                        $sum = round($sum / $inc, 2);
                    }
                }

                $arrWeekResult[$key] = $sum;
            }
        }

        //nilai default 0 per tanggal pada bulan pilihan
        // Get the first day of the month
        $startDate = Carbon::createFromFormat('F Y', strtr($bulanTahun, $monthTranslations))->startOfMonth();
        // Get the last day of the month
        $endDate = $startDate->copy()->endOfMonth();
        $arrMonthResult = [];
        $currentDate = $startDate;
        while ($currentDate <= $endDate) {
            $formattedDate = $currentDate->format('d M');

            // Reverse translate the month name
            $englishMonth = $currentDate->format('F');
            $indonesianMonth = $reverseTranslations[$englishMonth];

            $formattedDate = str_replace($englishMonth, $indonesianMonth, $formattedDate);

            $arrMonthResult[$formattedDate] = 0;
            $currentDate->addDay();
        }


        $translatedBulan = $monthTranslations[$bulan];
        $monthNumber = Carbon::parse($translatedBulan)->format('n');

        $queryRawMonth = DB::table('weather_station')
            ->where('weather_station.idws', '=', $queryID)
            ->whereMonth('weather_station.date', '=', $monthNumber) // Filter by month (June = 6)
            ->orderBy('weather_station.date', 'asc')
            ->get();

        if (!$queryRawMonth->isEmpty()) {
            foreach ($queryRawMonth as $key => $value) {
                $date = Carbon::parse($value->date);
                $indonesianMonth = [
                    1 => 'Jan',
                    2 => 'Feb',
                    3 => 'Mar',
                    4 => 'Apr',
                    5 => 'Mei',
                    6 => 'Jun',
                    7 => 'Jul',
                    8 => 'Ags',
                    9 => 'Sep',
                    10 => 'Okt',
                    11 => 'Nov',
                    12 => 'Des',
                ];
                $value->tgl = $date->format('d') . ' ' . $indonesianMonth[$date->month];
            }

            $queryMonth = $queryRawMonth->groupBy('tgl');

            foreach ($queryMonth as $key => $value) {
                $sum = 0;
                $inc = 0;
                foreach ($value as $key2 => $value2) {
                    $sum += $value2->$params;
                    $inc++;
                }

                if ($params != 'rain_rate') {
                    if ($params == 'uv') {
                        $sum = round($sum / $inc);
                    } else {
                        $sum = round($sum / $inc, 2);
                    }
                }

                $arrMonthResult[$key] = $sum;
            }
        }

        $arrResult['hari'] = $arrDayResult;
        $arrResult['minggu'] = $arrWeekResult;
        $arrResult['bulan'] = $arrMonthResult;

        return response()->json([
            'arrResult' => $arrResult,
        ]);
    }

    public static function Tabel()
    {
        $sel_aws = DB::table('weather_station_list')
            ->join('weather_station', 'weather_station_list.id', '=', 'weather_station.idws')
            ->select('weather_station.*', 'weather_station_list.rain_cal as rain_cal', 'weather_station_list.loc as loc')
            ->orderByDesc('weather_station.id')
            ->get();
        $sel_aws = json_decode(json_encode($sel_aws), true);

        // dd($sel_aws);

        $listStation = DB::table('weather_station_list')
            ->select('weather_station_list.*')
            ->orderBy('flags', 'desc')
            ->get();

        // dd($listStation);

        return view('weather_station/tabel', [
            'aws' => $sel_aws,
            'list' => $listStation
        ]);
    }

    public function gettabelaws(Request $request)
    {
        $loc = $request->input('lokasi');
        $date = $request->input('tanggal');

        $data = DB::table('weather_station')
            ->select('*')
            ->where('idws', $loc)
            ->where('date', 'LIKE', '%' . $date . '%')
            ->get();

        $data = json_decode($data, true);


        $arr = array();

        $arr['data'] = $data;


        echo json_encode($arr); //di decode ke dalam bentuk json dalam vaiavel arrview yang dapat menampung banyak isi array
        exit();
    }

    public function dashboard_wl(Request $request)
    {
        $dataWlperhari = '';
        $lastDataInDay = '';
        $defaultId = '';
        $idLoc = $request->has('id') ? $request->input('id') : $defaultId = 99;
        $listLoc = DB::table('water_level_list')->pluck('location', 'id');
        $dateToday = Carbon::now();
        $avg = '';
        $arrJam = ['00:00', '01:00', '02:00', '03:00', '04:00', '05:00', '06:00', '07:00', '08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00', '21:00', '22:00', '23:00'];
        $dataWlperhari = DB::table('water_level_list')
            ->join('water_level', 'water_level_list.id', '=', 'water_level.idwl')
            ->select('water_level.*', 'water_level_list.location as location')
            ->orderBy('water_level.datetime')
            ->where(DB::raw("(DATE_FORMAT(water_level.datetime,'%Y-%m-%d'))"), '=', $dateToday->format('Y-m-d'))
            ->where('water_level_list.id', '=', $idLoc)
            ->get();

        $queryMaps = DB::table('water_level_list')
            ->select('water_level_list.*')
            ->where('water_level_list.id', '=', $idLoc)
            ->first();

        if (!$dataWlperhari->isEmpty()) {
            $sumlvl_in = 0;
            $sumlvl_out = 0;
            $sumlvl_act = 0;
            foreach ($dataWlperhari as $item) {
                $sumlvl_in += $item->lvl_in;
                $sumlvl_out += $item->lvl_out;
                $sumlvl_act += $item->lvl_act;
            }

            $avg = [
                'lvl_in' => round(($sumlvl_in / count($dataWlperhari)), 2),
                'lvl_out' => round(($sumlvl_out / count($dataWlperhari)), 2),
                'lvl_act' =>  round(($sumlvl_act / count($dataWlperhari)), 2),
            ];

            //get last data in day
            $lastDataInDay = DB::table('water_level_list')
                ->join('water_level', 'water_level_list.id', '=', 'water_level.idwl')
                ->select('water_level.*', 'water_level_list.location as location')
                ->orderBy('water_level.datetime', 'desc')
                ->where(DB::raw("(DATE_FORMAT(water_level.datetime,'%Y-%m-%d'))"), '=', $dateToday->format('Y-m-d'))
                ->where('water_level_list.id', '=', $idLoc)
                ->first();

            $dataWlperhari = json_decode(json_encode($dataWlperhari), true);
        }

        $listWil =  DB::connection('mysql3')->table('wil')
            ->pluck('nama');

        return view('water_level/dashboard', [
            'dataWlperhari' => $dataWlperhari,
            'avg' => $avg,
            'timeToday' =>  Carbon::now()->format('d-m-Y H:i:s'),
            'listLoc' => $listLoc,
            'listWil' => $listWil,
            'maps' => $queryMaps,
            'defaultId' => $defaultId,
            'lastDataInDay' => $lastDataInDay,
            'arrJam' => $arrJam,
        ]);
    }

    public function grafik_wl(Request $request)
    {


        $listWil =  DB::connection('mysql3')->table('wil')
            ->pluck('nama');


        return view('water_level/grafik', [

            'listWil' => $listWil,

        ]);
    }

    public function get_estate(Request $request)
    {
        $tgl = $request->get('tgl');
        $wil = $request->get('wil');
        $excludeValues = ['Central Workshop', 'PLASMA'];
        $arrEstate =  DB::connection('mysql3')->table('wil')
            ->join('estate', 'wil.id', '=', 'estate.wil')
            ->where('wil.nama', $wil)
            ->whereNotIn('estate.nama', $excludeValues)
            ->get()->toArray();

        $listAllWaterPump = DB::table('water_level_list')->get()->toArray();

        $matchingWaterPumps = array_filter($listAllWaterPump, function ($item) use ($arrEstate) {
            // Check if 'location' contains any 'est' value
            foreach ($arrEstate as $estate) {
                if (strpos($item->location, $estate->est) !== false) {
                    return true; // Found a match
                }
            }
            return false; // No match found
        });

        $matchingLocations = array_map(function ($item) {
            return $item->location;
        }, $matchingWaterPumps);

        return response()->json($matchingLocations);
    }


    public function get_data_bulan(Request $request)
    {
        $tgl = $request->get('tgl');
        $titik = $request->get('titikPompa');
        $carbonDate = Carbon::parse($tgl);
        $numberOfDays = $carbonDate->daysInMonth;

        // dd($tgl);

        $formattedDates = [];

        for ($day = 1; $day <= $numberOfDays; $day++) {
            $formattedDates[] = $carbonDate->copy()->day($day)->format('d M');
        }

        $queryData = DB::table('water_level_list')
            ->select('water_level.*')
            ->join('water_level', 'water_level_list.id', '=', 'water_level.idwl')
            ->where('water_level_list.location', $titik)
            ->whereMonth('water_level.datetime', Carbon::parse($tgl)->month)
            ->whereYear('water_level.datetime', Carbon::parse($tgl)->year)
            ->get();

        $collection = collect($queryData);

        // dd($collection);

        $groupedByDate = $collection->groupBy(function ($item) {
            // You can adjust the date format based on your actual datetime column format
            return Carbon::parse($item->datetime)->toDateString();
        });

        // Get all the dates within the month
        $allDates = CarbonPeriod::create(
            Carbon::parse($tgl)->startOfMonth(),
            Carbon::parse($tgl)->endOfMonth()
        )->toArray();

        // Convert the dates to strings
        $allDateStrings = array_map(function ($date) {
            return $date->toDateString();
        }, $allDates);

        //group by setiap tanggal 
        $mergedCollection = collect($allDateStrings)->mapWithKeys(function ($date) use ($groupedByDate) {
            return [$date => $groupedByDate->get($date, collect([]))];
        });

        $averages = [
            'date' => $mergedCollection->keys()->toArray(),
            'avg_lvl_in' => [],
            'avg_lvl_out' => [],
            'avg_lvl_act' => [],
        ];

        foreach ($mergedCollection as $items) {
            if ($items->isNotEmpty()) {
                // Calculate the average for lvl_in, lvl_out, and lvl_act
                $avgLvlIn = round($items->avg('lvl_in'), 2);
                $avgLvlOut = round($items->avg('lvl_out'), 2);
                $avgLvlAct = round($items->avg('lvl_act'), 2);

                // Push the averages to the respective arrays
                $averages['avg_lvl_in'][] = $avgLvlIn;
                $averages['avg_lvl_out'][] = $avgLvlOut;
                $averages['avg_lvl_act'][] = $avgLvlAct;
            } else {
                // If there are no items for the current date, push 0 or any default value
                $averages['avg_lvl_in'][] = 0;
                $averages['avg_lvl_out'][] = 0;
                $averages['avg_lvl_act'][] = 0;
            }
        }
        $query = DB::table('water_level_list')
            ->select(
                'water_level.*',
                'water_level.datetime as datetime',
                DB::raw('DATE_FORMAT(water_level.datetime, "%Y-%m-%d") as tanggal'),
                DB::raw('CONCAT(LPAD(HOUR(water_level.datetime), 2, "0"), ":00") as jam')
            )

            ->join('water_level', 'water_level_list.id', '=', 'water_level.idwl')
            ->where('water_level_list.location', $titik)
            ->where('water_level.datetime', 'LIKE', '%' . $tgl . '%')
            ->get();

        $query = $query->groupBy('jam');

        $query = json_decode($query, true);


        $resultH = array();

        foreach ($query as $key => $value) {
            # code...
            $count = 0;
            $sumlvl_in = 0;
            $sumlvl_out = 0;
            $sumlvl_act = 0;
            foreach ($value as $key2 => $value2) {
                # code...
                $sumlvl_in += $value2['lvl_in'];
                $sumlvl_out += $value2['lvl_out'];
                $sumlvl_act += $value2['lvl_act'];

                $count = count($value);
            }


            $resultH[$key]['jumdata'] = $count;
            $resultH[$key]['total_lvlin'] = $sumlvl_in;
            $resultH[$key]['total_lvl_out'] = $sumlvl_out;
            $resultH[$key]['total_lvl_act'] = $sumlvl_act;
            $resultH[$key]['avg_lvlin'] = $count !== 0 ? round($sumlvl_in / $count, 2) : 0;
            $resultH[$key]['avg_lvlout'] = $count !== 0 ? round($sumlvl_out / $count, 2) : 0;
            $resultH[$key]['avg_lvlact'] = $sumlvl_act !== 0 ? round($sumlvl_in / $count, 2) : 0;
        }


        foreach ($resultH as $key => $value) {
            # code...
            $keyH[] = $key;
            $avg_lvlin[] = $value['avg_lvlin'];
            $avg_lvlout[] =  $value['avg_lvlout'];
            $avg_lvlact[] =  $value['avg_lvlact'];
        }

        $queryWeek = DB::table('water_level_list')
            ->select(
                'water_level.*',
                'water_level.datetime as datetime',
                DB::raw('DATE_FORMAT(water_level.datetime, "%Y-%m-%d") as tanggal'),
                DB::raw('CONCAT(LPAD(HOUR(water_level.datetime), 2, "0"), ":00") as jam')
            )

            ->join('water_level', 'water_level_list.id', '=', 'water_level.idwl')
            ->where('water_level_list.location', $titik)
            ->whereMonth('water_level.datetime', Carbon::parse($tgl)->month)
            ->whereYear('water_level.datetime', Carbon::parse($tgl)->year)
            ->get();

        $queryWeek = $queryWeek->groupBy('tanggal');

        $queryWeek = json_decode($queryWeek, true);


        $getmonth = Carbon::parse($tgl)->format('Y-m');

        $weeks = [];

        // Create Carbon instances for the given year and month
        $startOfMonth = Carbon::parse($getmonth)->startOfMonth();
        $endOfMonth = Carbon::parse($getmonth)->endOfMonth();

        $weekStart = $startOfMonth->copy()->startOfWeek(); // Start of the first week
        $weekNumber = 1;

        while ($weekStart->lte($endOfMonth)) {
            $weekEnd = $weekStart->copy()->endOfWeek();
            $weekDates = [];

            $currentDate = $weekStart->copy();
            while ($currentDate->lte($weekEnd)) {
                $weekDates[] = $currentDate->format('Y-m-d');
                $currentDate->addDay();
            }

            $weeks["week$weekNumber"] = $weekDates;
            $weekStart = $weekEnd->copy()->addDay(); // Move to the start of the next week
            $weekNumber++;
        }

        $dataweek = [];
        foreach ($weeks as $weekKey => $weekDates) {
            $dataweek[$weekKey] = [];
            foreach ($weekDates as $date) {
                $found = false; // Flag to track if the date is found in $queryWeek
                foreach ($queryWeek as $queryDate => $data) {
                    if ($date == $queryDate) {
                        $dataweek[$weekKey][] = $data;
                        $found = true;
                        break;
                    }
                }
            }
        }

        $resultweek = [];
        foreach ($dataweek as $key => $value) {
            # code...value
            $sumlvl_in2 = 0;
            $sumlvl_out2 = 0;
            $sumlvl_act2 = 0;
            $count2 = 0;
            foreach ($value as $key2 => $value2) if (is_array($value2)) {
                # code...
                $count = 0;
                $sumlvl_in = 0;
                $sumlvl_out = 0;
                $sumlvl_act = 0;
                foreach ($value2 as $key3 => $value3) if (is_array($value3)) {
                    # code...
                    # code...
                    $sumlvl_in += $value3['lvl_in'];
                    $sumlvl_out += $value3['lvl_out'];
                    $sumlvl_act += $value3['lvl_act'];

                    $count = count($value2);
                }

                $resultweek[$key][$key2]['jumdata'] = $count;
                $resultweek[$key][$key2]['total_lvlin'] = $sumlvl_in;
                $resultweek[$key][$key2]['total_lvl_out'] = $sumlvl_out;
                $resultweek[$key][$key2]['total_lvl_act'] = $sumlvl_act;
                $resultweek[$key][$key2]['avg_lvlin'] = $count !== 0 ? round($sumlvl_in / $count, 2) : 0;
                $resultweek[$key][$key2]['avg_lvlout'] = $count !== 0 ? round($sumlvl_out / $count, 2) : 0;
                $resultweek[$key][$key2]['avg_lvlact'] = $sumlvl_act !== 0 ? round($sumlvl_in / $count, 2) : 0;

                $sumlvl_in2 += $sumlvl_in;
                $sumlvl_out2 += $sumlvl_out;
                $sumlvl_act2 += $sumlvl_act;

                $count2 += $count;
            } else {
                $resultweek[$key][$key2]['jumdata'] = 0;
                $resultweek[$key][$key2]['total_lvlin'] = 0;
                $resultweek[$key][$key2]['total_lvl_out'] = 0;
                $resultweek[$key][$key2]['total_lvl_act'] = 0;
                $resultweek[$key][$key2]['avg_lvlin'] = 0;
                $resultweek[$key][$key2]['avg_lvlout'] = 0;
                $resultweek[$key][$key2]['avg_lvlact'] = 0;
            }

            $resultweek[$key]['jumdata'] = $count2;
            $resultweek[$key]['total_lvlin'] = ($sumlvl_in2 == 0) ? null : $sumlvl_in2;
            $resultweek[$key]['total_lvl_out'] = ($sumlvl_out2 == 0) ? null : $sumlvl_out2;
            $resultweek[$key]['total_lvl_act'] = ($sumlvl_act2 == 0) ? null : $sumlvl_act2;
            $resultweek[$key]['avg_lvlin'] = $count !== 0 ? round($sumlvl_in2 / $count, 2) : null;
            $resultweek[$key]['avg_lvlout'] = $count !== 0 ? round($sumlvl_out2 / $count, 2) : null;
            $resultweek[$key]['avg_lvlact'] = $sumlvl_act !== 0 ? round($sumlvl_act2 / $count, 2) : null;
        }


        foreach ($resultweek as $key => $value) {
            $keyWeek[] = $key;
            $week_lvlin[] = $value['avg_lvlin'];
            $week_lvlout[] = $value['avg_lvlout'];
            $week_lvlact[] = $value['avg_lvlact'];
        }

        return response()->json([
            'rangeDays' => $formattedDates,
            'lvl_in' => $averages['avg_lvl_in'],
            'lvl_out' => $averages['avg_lvl_out'],
            'lvl_act' => $averages['avg_lvl_act'],

            // perhour
            'ktgH' => $keyH,
            'avg_lvlin' => $avg_lvlin,
            'avg_lvlout' => $avg_lvlout,
            'avg_lvlact' => $avg_lvlact,


            // perweek
            'keyWeek' => $keyWeek,
            'week_lvlin' => $week_lvlin,
            'week_lvlout' => $week_lvlout,
            'week_lvlact' => $week_lvlact,

        ]);
    }

    public function month_weather_forecast()
    {
        $monthNow = Carbon::now()->month;
        $aws_loc = DB::table('weather_station_list')->get();
        $aws_loc = json_decode(json_encode($aws_loc), true);

        $dateNow =  Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now()->format('Y-m-d H:i:s'))->isoFormat('MMMM');

        // $query = DB::table("db_aws_bke")
        //     ->whereMonth('db_aws_bke.datetime', Carbon::now()->month)
        //     ->whereYear('db_aws_bke.datetime', '=', Carbon::now()->year)
        //     // ->take(4)
        //     ->get();


        $dataLog = DB::table('db_aws_bke')
            ->select('db_aws_bke.*',  DB::raw("DATE_FORMAT(db_aws_bke.datetime,'%Y-%d-%m') as hari"))
            ->orderBy('db_aws_bke.datetime', 'ASC')
            ->whereMonth('db_aws_bke.datetime', Carbon::now()->month)
            ->whereYear('db_aws_bke.datetime', Carbon::now()->year)
            ->get()
            ->groupBy('hari');

        $arrMonth = array();

        foreach ($dataLog as $inc =>  $value) {
            $count = 0;

            $sumRainF = 0;
            $sumTempF = 0;
            $sumHumF  = 0;
            foreach ($value as $key => $data) {
                $sumRainF += round($data->rain_forecast, 2);
                $sumTempF += round($data->temp_forecast, 2);
                $sumHumF += round($data->hum_forecast, 2);
                $count++;
            }
            // $arrMonth[$inc]['id'] = $count;
            $arrMonth[$inc]['timestamp'] = Carbon::createFromFormat('Y-m-d H:i:s', $data->datetime)->isoFormat('dddd, D MMMM Y');
            $arrMonth[$inc]['hari'] = $inc;
            $arrMonth[$inc]['rerata_rf'] = round($sumRainF / $count, 2);
            $arrMonth[$inc]['rerata_tf'] = round($sumTempF / $count, 2);
            $arrMonth[$inc]['rerata_hf'] = round($sumHumF / $count, 2);

            if ($arrMonth[$inc]['rerata_rf'] >= 0.5 && $arrMonth[$inc]['rerata_rf'] < 20) {
                $icon = 'cloudy-day.png';
            } else if ($arrMonth[$inc]['rerata_rf'] >= 20 && $arrMonth[$inc]['rerata_rf'] < 50) {
                $icon = 'cloudy.png';
            } else if ($arrMonth[$inc]['rerata_rf'] >= 50 && $arrMonth[$inc]['rerata_rf'] < 100) {
                $icon = 'rainy.png';
            } else if ($arrMonth[$inc]['rerata_rf'] >= 100 && $arrMonth[$inc]['rerata_rf'] < 150) {
                $icon = 'rainy.png';
            } else if ($arrMonth[$inc]['rerata_rf'] >= 150) {
                $icon = 'rainy.png';
            } else if ($arrMonth[$inc]['rerata_rf'] < 0.5) {
                $icon = 'sunny.png';
            }
            $arrMonth[$inc]['num_days'] =  (int)Carbon::createFromFormat('Y-m-d H:i:s', $data->datetime)->format('d');
            $arrMonth[$inc]['date'] = Carbon::createFromFormat('Y-m-d H:i:s', $data->datetime)->format('D d');
            $arrMonth[$inc]['icon'] = $icon;
        }
        // dd($arrMonth);
        $current = Carbon::now();

        $nextMonth = array();
        for ($i = 0; $i < 8; $i++) {
            $dateNext = Carbon::parse($current)->addMonth($i);
            if ($current->year < $dateNext->year && $dateNext->month == 1) {
                $nextMonth[] = $dateNext->format('M Y');
            } else {
                $nextMonth[] = $dateNext->format('M');
            }
        }


        return view('weather_station/month_view_forecast', ['loc' => $aws_loc, 'query' => $arrMonth, 'thisMonth' => $dateNow, 'nextMonth' => $nextMonth]);
    }

    public function get_wl_dashboard(Request $request)
    {
        $avg_lvlin = '-';
        $avg_lvlout = '-';
        $avg_lvlact = '-';
        $lastlvlin = '-';
        $lastlvlout = '-';
        $lastlvlact = '-';
        $lastDate = 'tidak ada';

        $tgl = $request->get('tgl');
        $namaLoc = $request->get('loc');



        $tglDate = Carbon::parse($tgl);
        $currentDate = Carbon::now();

        $isSameDay = $tglDate->isSameDay($currentDate);

        $query = DB::table('water_level_list')
            ->select('*')
            ->where('location', $namaLoc)
            ->first();

        $max = $query->max ?? '-';
        $min = $query->min ?? '-';

        $lat = $query->lat;
        $lon = $query->lon;


        $dataWlperhari = DB::table('water_level_list')
            ->leftJoin('water_level', 'water_level_list.id', '=', 'water_level.idwl')
            ->select('water_level.*', 'water_level_list.location as location')
            ->orderBy('water_level.datetime', 'desc')
            ->where(function ($query) use ($tgl, $namaLoc) {
                $query->whereDate('water_level.datetime', '=', $tgl)
                    ->where('water_level_list.location', '=', $namaLoc);
            })
            ->get();

        if ($dataWlperhari->isEmpty()) {
            if ($isSameDay) {
                $lastData = DB::table('water_level_list')
                    ->leftJoin('water_level', 'water_level_list.id', '=', 'water_level.idwl')
                    ->select('water_level.*', 'water_level_list.location as location')
                    ->orderBy('water_level.datetime', 'desc')
                    ->where('water_level_list.location', '=', $namaLoc)
                    ->first();

                if ($lastData) {
                    $getDate = Carbon::parse($lastData->datetime)->locale('id');
                    $getDate->settings(['formatFunction' => 'translatedFormat']);
                    $lastDate = $getDate->format('l, j F Y H:i');
                    $lastlvlin = $lastData->lvl_in;
                    $lastlvlout = $lastData->lvl_out;
                    $lastlvlact = $lastData->lvl_act;

                    $lastDataDate =    Carbon::parse($lastData->datetime)->format('Y-m-d');
                }

                $datas = DB::table('water_level_list')
                    ->leftJoin('water_level', 'water_level_list.id', '=', 'water_level.idwl')
                    ->select('water_level.*', 'water_level_list.location as location')
                    ->orderBy('water_level.datetime', 'desc')
                    ->where(function ($query) use ($lastDataDate, $namaLoc) {
                        $query->whereDate('water_level.datetime', '=', $lastDataDate)
                            ->where('water_level_list.location', '=', $namaLoc);
                    })->get();

                if ($datas) {
                    $sumlvl_in = 0;
                    $sumlvl_out = 0;
                    $sumlvl_act = 0;
                    foreach ($datas as $item) {
                        $sumlvl_in += $item->lvl_in;
                        $sumlvl_out += $item->lvl_out;
                        $sumlvl_act += $item->lvl_act;
                    }
                    $avg_lvlin = round(($sumlvl_in / count($datas)), 2);
                    $avg_lvlout = round(($sumlvl_out / count($datas)), 2);
                    $avg_lvlact  =  round(($sumlvl_act / count($datas)), 2);
                }
            } else {
                $avg_lvlin = '-';
                $avg_lvlout = '-';
                $avg_lvlact = '-';
                $lastlvlin = '-';
                $lastlvlout = '-';
                $lastlvlact = '-';
                $lastDate = 'tidak ada';
            }
        } else {
            $lastData = $dataWlperhari[0];
            $getDate = Carbon::parse($lastData->datetime)->locale('id');
            $getDate->settings(['formatFunction' => 'translatedFormat']);
            $lastDate = $getDate->format('l, j F Y H:i');
            $lastlvlin = $lastData->lvl_in;
            $lastlvlout = $lastData->lvl_out;
            $lastlvlact = $lastData->lvl_act;

            $sumlvl_in = 0;
            $sumlvl_out = 0;
            $sumlvl_act = 0;
            foreach ($dataWlperhari as $item) {
                $sumlvl_in += $item->lvl_in;
                $sumlvl_out += $item->lvl_out;
                $sumlvl_act += $item->lvl_act;
            }
            $avg_lvlin = round(($sumlvl_in / count($dataWlperhari)), 2);
            $avg_lvlout = round(($sumlvl_out / count($dataWlperhari)), 2);
            $avg_lvlact  =  round(($sumlvl_act / count($dataWlperhari)), 2);
        }

        $finalData = [
            'avgIn' =>      $avg_lvlin,
            'avgOut' =>      $avg_lvlout,
            'avgAct' =>      $avg_lvlact,
            'lastDate' => $lastDate,
            'lastlvlin' =>      $lastlvlin,
            'lastlvlout' =>      $lastlvlout,
            'lastlvlact' =>      $lastlvlact,
            'foto' => $query->foto_lokasi,
            'max' => $max,
            'min' => $min,
            'lat' => $lat,
            'lon' => $lon,
            'namePlot' => $query->location
        ];

        return response()->json($finalData);
    }


    public function tabel_wl(Request $request)
    {
        $defaultId = '';
        $idLoc = $request->has('id') ? $request->input('id') : $defaultId = 99;

        $data =  DB::table('water_level_list')
            ->join('water_level', 'water_level_list.id', '=', 'water_level.idwl')
            ->select('water_level.*')
            ->orderBy('water_level.datetime', 'desc')
            ->where('water_level_list.id', '=', $idLoc)
            ->get();



        $listLoc = DB::table('water_level_list')->pluck('location', 'id');
        $data =  json_decode(json_encode($data), true);
        return view('water_level/tabel', [
            'data' => $data,
            'listLoc' => $listLoc,
            'defaultId' => $defaultId,
        ]);
    }

    public static function FilterTabel(Request $request)
    {
        $tglMulai       = $request->tglMulai;
        $tglSelesai     = $request->tglSelesai;

        $rules          = [
            'tglMulai'      => 'required|date',
            'tglSelesai'    => 'required|date'
        ];

        $message        = [
            'tglMulai.required'     => 'TANGGAL MULAI WAJIB DIISI',
            'tglMulai.date'         => 'FORMAT PENGISIAN HARUS DIISI DENGAN TANGGAL',
            'tglSelesai.required'   => 'TANGGAL SELESAI HARUS DIISI',
            'tglSelesai.date'       => 'FORMAT PENGISIAN HARUS DIISI DENGAN TANGGAL'
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all())->with('error_select', 'Gagal');
        } else {
            $sel_aws = '';
            if (strtotime($tglMulai) < strtotime($tglSelesai)) {
                $sel_aws = DB::table('weather_station_list')
                    ->join('weather_station', 'weather_station_list.id', '=', 'weather_station.idws')
                    ->select('weather_station.*', 'weather_station_list.rain_cal as rain_cal', 'weather_station_list.loc as loc')
                    ->orderByDesc('weather_station.id')
                    ->where(DB::raw("(DATE_FORMAT(weather_station.datetime,'%Y-%m-%d'))"), ">=", $tglMulai)
                    ->where(DB::raw("(DATE_FORMAT(weather_station.datetime,'%Y-%m-%d'))"), "<=", $tglSelesai)
                    ->get();
            } elseif (strtotime($tglMulai) > strtotime($tglSelesai)) {
                $sel_aws = DB::table('weather_station_list')
                    ->join('weather_station', 'weather_station_list.id', '=', 'weather_station.idws')
                    ->select('weather_station.*', 'weather_station_list.rain_cal as rain_cal', 'weather_station_list.loc as loc')
                    ->orderByDesc('weather_station.id')
                    ->where(DB::raw("(DATE_FORMAT(weather_station.datetime,'%Y-%m-%d'))"), "<=", $tglMulai)
                    ->where(DB::raw("(DATE_FORMAT(weather_station.datetime,'%Y-%m-%d'))"), ">=", $tglSelesai)
                    ->get();
            } else {
                $sel_aws = DB::table('weather_station_list')
                    ->join('weather_station', 'weather_station_list.id', '=', 'weather_station.idws')
                    ->select('weather_station.*', 'weather_station_list.rain_cal as rain_cal', 'weather_station_list.loc as loc')
                    ->orderByDesc('weather_station.id')
                    ->where(DB::raw("(DATE_FORMAT(weather_station.datetime,'%Y-%m-%d'))"), "==", $tglMulai)
                    ->get();
            }

            $sel_aws = json_decode(json_encode($sel_aws), true);

            return view('water_level/tabel', ['data' => $sel_aws]);
        }
    }

    public static function stationList()
    {
        $query = DB::table('weather_station_list')->get();
        return view('weather_station.listStation', ['data' => $query]);
    }

    public function insertStation(Request $request)
    {
        $request->validate([
            'loc' => 'required',
            'flags' => 'required'
        ]);

        $check = DB::table('weather_station_list')->where('id', $request->input('id'))->pluck('id')->toArray();
        if (empty($check)) {
            DB::table('weather_station_list')
                ->insert(['rain_cal' => '0', 'loc' => $request->input('loc'), 'lat' => '0', 'lon' => '0', 'desc' => '', 'flags' => $request->input('flags')]);

            $version = DB::table("station_version")->where('id', 1)->first()->version;
            DB::table("station_version")->where('id', 1)->update(['version' => $version + 1]);

            return redirect('stationList')->with('status', 'Station berhasil ditambahkan!');
        } else {
            return redirect('stationList')->with('error', 'Station gagal ditambahkan!');
        }
    }

    public function updateStation(Request $request)
    {
        $request->validate([
            'loc' => 'required',
            'flags' => 'required'
        ]);

        $result = DB::table('weather_station_list')
            ->where('id', $request->input('id'))
            ->update(['loc' => $request->input('loc'), 'flags' => $request->input('flags')]);

        if ($result) {
            $version = DB::table("station_version")->where('id', 1)->first()->version;
            DB::table("station_version")->where('id', 1)->update(['version' => $version + 1]);

            return redirect('stationList')->with('status', 'Station berhasil diperbarui!');
        } else {
            return redirect('stationList')->with('error', 'Station gagal diperbarui!');
        }
    }

    public function deleteStation(Request $request)
    {
        $check = DB::table('weather_station_list')->where('id', $request->input('id'))->pluck('id')->toArray();

        if (isset($check)) {
            DB::table('weather_station_list')->where('id', $request->input('id'))->delete();

            $version = DB::table("station_version")->where('id', 1)->first()->version;
            DB::table("station_version")->where('id', 1)->update(['version' => $version + 1]);

            return redirect('stationList')->with('status', 'Station berhasil dihapus!');
        } else {
            return redirect('stationList')->with('error', 'Station gagal dihapus!');
        }
    }
}
