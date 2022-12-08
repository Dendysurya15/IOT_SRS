<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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
            ->where('db_aws_bke.idws', '=', 1)
            // ->take(1)
            ->get();


        foreach ($sel_aws as $key => $value) {
            $formatted = Carbon::parse($value->datetime)->format('Y-m-d');
            if ($value->datetime == $formatted . ' 07:00:00' || $value->datetime == $formatted . ' 19:00:00') {
                unset($sel_aws[$key]);
            }
        }

        $sel_aws = $sel_aws->first();
        if ($sel_aws != '') {
            if ($sel_aws->rain_fall_real >= 0 && $sel_aws->rain_fall_real < 0.5) {
                $icon = 'cloud-sun';
                $title = 'Berawan';
            } else if ($sel_aws->rain_fall_real >= 0.5 && $sel_aws->rain_fall_real < 20) {
                $icon = 'cloud-rain';
                $title = 'Hujan ringan';
            } else if ($sel_aws->rain_fall_real >= 20 && $sel_aws->rain_fall_real < 50) {
                $icon = 'cloud-rain';
                $title = 'Hujan Sedang';
            } else if ($sel_aws->rain_fall_real >= 50 && $sel_aws->rain_fall_real < 100) {
                $icon = 'cloud-showers-heavy';
                $title = 'Hujan Lebat';
            } else if ($sel_aws->rain_fall_real >= 100 && $sel_aws->rain_fall_real < 150) {
                $icon = 'cloud-showers-water';
                $title = 'Hujan Sangat Lebat';
            } else {
                $icon = 'cloud-showers-water';
                $title = 'Hujan Ekstrem';
            }
            $sel_aws->date_format = Carbon::parse($sel_aws->datetime)->format('d M Y, H:i');
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



        $dateNow = Carbon::parse()->format('Y-m-d');
        $hourNow = Carbon::now()->format('H:i:s');
        $dateNow = $dateNow . ' ' . $hourNow;


        $last12hour = Carbon::parse($dateNow)->subHours(12)->format('Y-m-d H:i:s');
        $next12hour = Carbon::parse($dateNow)->addHours(11)->format('Y-m-d H:i:s');


        $queryHistoryData =  DB::table('weather_station_list')
            ->join('db_aws_bke', 'weather_station_list.id', '=', 'db_aws_bke.idws')
            ->select('db_aws_bke.*', 'weather_station_list.rain_cal as rain_cal', 'weather_station_list.loc as loc')
            ->whereBetween('db_aws_bke.datetime', [$last12hour, $dateNow])
            ->where('idws', 1)
            ->orderBy('db_aws_bke.datetime')
            ->get();

        // dd($queryHistoryData[91]);

        $queryForecast12hour =  DB::table('weather_station_list')
            ->join('db_aws_bke', 'weather_station_list.id', '=', 'db_aws_bke.idws')
            ->select('db_aws_bke.*', 'weather_station_list.rain_cal as rain_cal', 'weather_station_list.loc as loc', DB::raw("DATE_FORMAT(db_aws_bke.datetime,'%H:%i') as hari"))
            ->whereBetween('db_aws_bke.datetime', [$dateNow, $next12hour])
            ->where('idws', 1)
            ->orderBy('hari')
            ->get();

        // dd($queryForecast12hour);

        foreach ($queryHistoryData as $key => $value) {
            $formatted = Carbon::parse($value->datetime)->format('Y-m-d');
            if ($value->datetime == $formatted . ' 07:00:00' || $value->datetime == $formatted . ' 19:00:00') {
                unset($queryHistoryData[$key]);
            }
        }

        $queryHistoryData = $queryHistoryData->groupBy(function ($item) {
            return Carbon::parse($item->datetime)->format('H');
        });

        $queryForecast12hour = $queryForecast12hour->groupBy(function ($item) {
            return Carbon::parse($item->datetime)->format('H');
        });


        // dd($queryForecast12hour);

        $arrHistoryData = array();
        $arrHistoryDataTemp = array();
        $hourHistoryDate = array();
        $incAll = 1;
        foreach ($queryHistoryData as $key => $value) {
            $sum_rain_fall = 0;
            $sum_temp = 0;
            $inc = 0;

            foreach ($value as $key2 => $value2) {
                $sum_rain_fall += $value2->rain_fall_real;
                $sum_temp += $value2->temp_real;
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
            $arrHistoryDataTemp[$key . ':00']['temp'] = 0;
            $arrHistoryDataTemp[$key . ':00']['rain'] = 0;
            $arrHistoryDataTemp[$key . ':00']['jam'] = $key . ':00';
            $incAll++;
        }

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
                {v:" . $temp . ", f:'" . $temp . " ° '},                        
                {v:'" . $warnaTemp . "', f:'" . $warnaTemp . "'}, 
                {v:" . $temp . ", f:'" . $temp . " ° '} 
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
                    $dir = $directions[round($data->accu_windir_forecast / 22.5)];
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
                    $dir = $directions[round($data->accu_windir_forecast / 22.5)];
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
        // dd($arrForecastNew12hour);

        return view('weather_station/dashboard', ['arrForecastNew12hour' => $arrForecastNew12hour, 'arrForecast12hour' => $arrForecast12hour, 'hourHistoryDate' => $hourHistoryDate, 'arrPagiMalam' => $arrPagiMalam, 'aws_loc' => $aws_loc, 'aktual' => $sel_aws, 'date' => $convert->format('d M') . ' ' . $dateNow, 'forecasting' => $arrPred, 'arrlogLast12hour' => $arrlogLast12hour, 'arrHistoryData' => $arrHistoryData]);
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

            // dd($arrAllData);
            return DataTables::of($arrAllData)

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
        // dd($request->winddir);
        $request->winddir == null ? '---' : $request->winddir;

        DB::table('db_aws_bke')
            ->where('id', $id)
            ->update(
                [
                    'temp_real' => $request->temp, 'rain_fall_real' => $request->winddir == null ? '---' : $request->winddir, 'hum_real' => $request->hum,
                    'wind_direction_real' => $request->winddir == null ? '---' : $request->winddir, 'wind_speed_real' => $request->windspeed
                ],

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

    public function getDataDashboard(Request $request)
    {
        $id_loc = $request->get('id_loc');

        $tglData = $request->get('tgl');

        $convert = new DateTime($tglData);

        // $convert->add(new DateInterval('PT7H'));

        $from = $convert->format('Y-m-d H:i:s');
        // 
        $from2 = Carbon::parse($from)->subMinutes();

        $from2 = $from2->format('Y-m-d H:i:s');
        // dd($to);
        $dateTo = Carbon::parse($from2)->addDays();

        // $dateFrom->add(new DateInterval('PT0H'));
        // dd($dateTo);
        $dateTo = $dateTo->format('Y-m-d H:i:s');

        $to = date($dateTo);

        $sel_aws = DB::table('weather_station_list')
            ->join('db_aws_bke', 'weather_station_list.id', '=', 'db_aws_bke.idws')
            ->select('db_aws_bke.*', 'weather_station_list.rain_cal as rain_cal', 'weather_station_list.loc as loc')
            ->whereBetween('db_aws_bke.datetime', [$from, $to])
            ->orderByDesc('db_aws_bke.id')
            ->where('db_aws_bke.idws', '=', $id_loc)
            ->take(1)
            ->get();

        if ($sel_aws->first() != null) {
            echo json_encode($sel_aws[0]);
        } else {
            echo 'no data';
        };
        exit();
    }

    public static function Grafik()
    {
        $sel_aws = DB::table('weather_station_list')
            ->join('db_aws_bke', 'weather_station_list.id', '=', 'db_aws_bke.idws')
            ->select('db_aws_bke.*', 'weather_station_list.rain_cal as rain_cal', 'weather_station_list.loc as loc')
            ->orderByDesc('db_aws_bke.id')
            ->get();

        $date =  Carbon::now()->format('Y-m-d');

        $formatted = new DateTime($date);
        $formatted = $formatted->format('Y-m-d');

        $date = $formatted . ' 00:00:00';

        $convert = new DateTime($date);

        $from = $convert->format('Y-m-d H:i:s');

        $parse = Carbon::parse($from)->subDays(6);
        $parse = $parse->format('Y-m-d');

        $pastWeek = $parse . ' 00:00:00';
        $toToday = $formatted . ' 23:59:59';
        // dd($toToday);
        $dateParse = Carbon::parse($from)->addDays(6);
        $dateParse = $dateParse->format('Y-m-d');

        $dateParse = $dateParse . ' 23:59:59';
        $to = new DateTime($dateParse);
        $to = $to->format('Y-m-d H:i:s');

        $queryPrediction =  DB::table('weather_station_list')
            ->join('db_aws_bke', 'weather_station_list.id', '=', 'db_aws_bke.idws')
            ->select('db_aws_bke.*', 'weather_station_list.rain_cal as rain_cal', 'weather_station_list.loc as loc')
            ->whereBetween('db_aws_bke.datetime', [$from, $to])
            // ->orderByDesc('db_aws_bke.id')
            ->get();

        $queryPrediction = json_decode(json_encode($queryPrediction), true);

        // dd($queryPrediction);
        $queryHistory =  DB::table('weather_station_list')
            ->join('db_aws_bke', 'weather_station_list.id', '=', 'db_aws_bke.idws')
            ->select('db_aws_bke.*', 'weather_station_list.rain_cal as rain_cal', 'weather_station_list.loc as loc')
            ->whereBetween('db_aws_bke.datetime', [$pastWeek, $toToday])
            ->get();

        $queryHistory = json_decode(json_encode($queryHistory), true);

        $dateToday = Carbon::now()->format('Y-m-d');

        $sel_aws = json_decode(json_encode($sel_aws), true);
        $forecastMingguan = '';
        $AktualPastWeekRF = '';
        #PERBULAN
        $awsPerbulan        = '';
        $arrAwsPerbulan     = '';
        $filBulan           = date('m');

        #PERMINGGU
        $awsPerminggu       = '';
        $arrAwsPerminggu    = '';
        $filMinggu          = date('d-m-Y', strtotime("-2 week"));

        #PERHARIINI
        $awsPerhariini      = '';
        $arrAwsPerhariini   = '';
        // $filHariini         = date('d-m-Y', strtotime("2021-11-13"));

        foreach ($queryPrediction as $key => $value) {
            $formatted = new DateTime($value['datetime']);
            $tanggal = $formatted->format('d M');
            $jam        = date('H:i', strtotime($value['datetime']));
            $forecastMingguan .= "[{v: '" . $tanggal . "', f:'" . $tanggal . "'}, {v:" . $value['rain_forecast'] . ", f:'" . $value['rain_forecast'] . " mm " . "'}                                
                            ],";
        }

        foreach ($queryHistory as $key => $value) {
            $formatted = new DateTime($value['datetime']);
            $tanggal = $formatted->format('d M');
            $jam        = date('H:i', strtotime($value['datetime']));
            $AktualPastWeekRF .= "[{v: '" . $tanggal . "', f:'" . $tanggal . "'}, {v:" . $value['rain_fall'] . ", f:'" . $value['rain_fall'] . " mm " . "'}                                
                            ],";
        }

        foreach ($sel_aws as $value) {
            $perBulan   = date('m', strtotime($value['datetime']));

            #PERHARIINI            
            $perHariini  = date('d-m-Y', strtotime($value['datetime']));

            if (strtotime($perHariini) > strtotime($dateToday)) {

                $tanggal    = date('H:i d-m-Y', strtotime($value['datetime']));
                $jam        = date('H:i', strtotime($value['datetime']));
                $awsPerhariini .= "[{v: '" . $jam . "', f:'" . $tanggal . "'}, {v:" . $value['temperature'] . ", f:'" . $value['temperature'] . " °C " . $value['loc'] . "'}                                      
                                ],";
            }

            #PERMINGGU
            $perMinggu  = date('d-m-Y', strtotime($value['datetime']));
            if (strtotime($perMinggu) > strtotime($filMinggu)) {
                $tanggal    = date('H:i d-m-Y', strtotime($value['datetime']));
                $jam        = date('H:i', strtotime($value['datetime']));
                $awsPerminggu .= "[{v: '" . $jam . "', f:'" . $tanggal . "'}, {v:" . $value['temperature'] . ", f:'" . $value['temperature'] . " °C " . $value['loc'] . "'}                                
                                ],";
            }

            #PERBULAN
            if ($filBulan == $perBulan) {
                $tanggal    = date('H:i d-m-Y', strtotime($value['datetime']));
                $jam        = date('H:i', strtotime($value['datetime']));
                $awsPerbulan .= "[{v: '" . $jam . "', f:'" . $tanggal . "'}, {v:" . $value['temperature'] . ", f:'" . $value['temperature'] . " °C " . $value['loc'] . "'}                                     
                                ],";
            }
        }
        $arrAwsPerhariini = [
            'judul'     => 'Suhu Udara',
            'data'      => $awsPerhariini
        ];

        $arrAwsPerminggu = [
            'judul'     => 'Suhu Udara',
            'data'      => $awsPerminggu
        ];

        $arrAwsPerbulan = [
            'judul'     => 'Suhu Udara',
            'data'      => $awsPerbulan
        ];

        $arrForecast = [
            'title' => 'Prediksi Curah Hujan',
            'data' => $forecastMingguan,
        ];

        $arrPastWeekRF = [
            'title' => 'Aktual Curah Hujan',
            'data' => $AktualPastWeekRF,
        ];

        // dd($arrForecast);
        return view('weather_station/grafik', [
            'arrAwsHariIni'     => $arrAwsPerhariini,
            'arrAwsPerminggu'   => $arrAwsPerminggu,
            'arrAwsPerbulan'    => $arrAwsPerbulan,
            'arrForecast' => $arrForecast,
            'arrPastWeekRF' => $arrPastWeekRF,
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

        return view('weather_station/tabel', ['aws' => $sel_aws]);
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

        // dd($dataWlperhari);

        return view('water_level/dashboard', [
            'dataWlperhari' => $dataWlperhari,
            'avg' => $avg,
            'timeToday' =>  Carbon::now()->format('d-m-Y H:i:s'),
            'listLoc' => $listLoc,
            'maps' => $queryMaps,
            'defaultId' => $defaultId,
            'lastDataInDay' => $lastDataInDay,
        ]);
    }

    public function grafik_wl(Request $request)
    {
        $defaultId = '';
        //deklarasi default empty
        $wlhariini      = '';
        $wlperminggu = '';
        $wlperbulan = '';
        $latestDataToday = '';
        $avgLvlActHariIni = '';
        $arrWlPerhariiniView = [
            'plot1'     => '',
            'plot2'     => '',
            'plot3'     => '',
            'data'      => ''
        ];

        $arrWlPermingguView = [
            'plot1'     => 'Level In',
            'plot2'     => 'Level Out',
            'plot3'     => 'Level Actual',
            'data'      => $wlperminggu
        ];

        $arrWlPerbulanView = [
            'plot1'     => 'Level In',
            'plot2'     => 'Level Out',
            'plot3'     => 'Level Actual',
            'data'      => $wlperbulan
        ];;

        //mendapatkan id lokasi di table water level list atau default id record paling pertama
        $idLoc = $request->has('id') ? $request->input('id') : $defaultId = 99;

        $dateToday = Carbon::now();

        //get all list lokasi
        $listLoc = DB::table('water_level_list')->pluck('location', 'id');

        $lastData = DB::table('water_level_list')
            ->join('water_level', 'water_level_list.id', '=', 'water_level.idwl')
            ->select('water_level.*', 'water_level_list.location as location')
            ->orderBy('water_level.datetime', 'desc')
            // ->where(DB::raw("(DATE_FORMAT(water_level.datetime,'%Y-%m-%d'))"), '=', $dateToday->format('Y-m-d'))
            ->where('water_level_list.id', '=', $idLoc)
            ->first();

        // dd($lastData);
        $to = $lastData->datetime;

        $convert = new DateTime($to);
        $to = $convert->format('Y-m-d H:i:s');

        $dateFrom = Carbon::parse($to)->subDays();
        $dateFrom = $dateFrom->format('Y-m-d H:i:s');

        $from = date($dateFrom);
        $to = date($lastData->datetime);

        $dataWlperhari = DB::table('water_level_list')
            ->join('water_level', 'water_level_list.id', '=', 'water_level.idwl')
            ->select('water_level.*', 'water_level_list.location as location')
            ->orderBy('water_level.datetime')
            ->whereBetween('water_level.datetime', [$from, $to])
            // ->where(DB::raw("(DATE_FORMAT(water_level.datetime,'%Y-%m-%d'))"), '=', $dateToday->format('Y-m-d'))
            ->where('water_level_list.id', '=', $idLoc)
            ->get();

        // dd($dataWlperhari[0  ]);

        $totalHariIni = 0;
        $counterLvlAct = 0;
        if (!$dataWlperhari->isEmpty()) {

            //mencari lvl act max
            foreach ($dataWlperhari as  $value) {
                $query[] = $value->lvl_act;
            }
            $maxValueLvlAct = max($query);
            $dataWlperhari = json_decode(json_encode($dataWlperhari), true);

            foreach ($dataWlperhari as  $value) {

                //Perhari
                $jam        = date('H:i', strtotime($value['datetime']));
                $wlhariini .=
                    "[{v:'" . $jam . "'}, {v:" . $value['lvl_in'] . ", f:'" . $value['lvl_in'] . "'},
                         {v:" . $value['lvl_out'] . ", f:'" . $value['lvl_out'] . "'";
                if ($maxValueLvlAct == 0) {
                    $wlhariini .= "}],";
                } else {
                    $wlhariini .= "},{v:" . $value['lvl_act'] . ", f:'" . $value['lvl_act'] . "'}],";
                }

                $counterLvlAct += $value['lvl_act'];
                $totalHariIni++;
            }
            $avgLvlActHariIni = $counterLvlAct / $totalHariIni;

            $arrWlPerhariiniView = [
                'plot1'     => 'Level_in (cm)',
                'plot2'     => 'Level_out (cm)',
                'plot3'     => 'Level Actual (cm)',
                'data'      => $wlhariini
            ];

            $latestDataToday = DB::table('water_level_list')
                ->join('water_level', 'water_level_list.id', '=', 'water_level.idwl')
                ->select('water_level.*', 'water_level_list.location as location')
                ->orderBy('water_level.id', 'desc')
                ->where(DB::raw("(DATE_FORMAT(water_level.datetime,'%Y-%m-%d'))"), '=', $dateToday->format('Y-m-d'))
                ->where('water_level_list.id', '=', $idLoc)
                ->limit(1)
                ->first();

            // $latestDataToday =  Carbon::parse($latestDataToday->datetime)->format('d-m-Y H:i:s');
        }

        $dateParse = Carbon::parse($to)->subDays(7);
        $dateParse = $dateParse->format('Y-m-d H:i:s');

        $pastWeek = date($dateParse);
        $dataWlperminggu = DB::table('water_level_list')
            ->join('water_level', 'water_level_list.id', '=', 'water_level.idwl')
            ->select('water_level.*', 'water_level_list.location as location', DB::raw("DATE_FORMAT(water_level.datetime,'%d-%m-%Y') as datetime"))
            ->whereBetween('water_level.datetime', [$pastWeek, $to])
            // ->whereBetween('water_level.datetime', [$dateToday->startOfWeek()->format('Y-m-d'), $dateToday->endOfWeek()->format('Y-m-d')])
            ->where('water_level_list.id', '=', $idLoc)
            ->get()
            ->groupBy(function ($item) {
                return $item->datetime;
            });

        if (!$dataWlperminggu->isEmpty()) {
            foreach ($dataWlperminggu as $sub_array) {
                foreach ($sub_array as $data) {
                    $data->nameDay = Carbon::parse($data->datetime)->format('D d M');
                }
            }

            $arrDataPerminggu = array();

            $dataWlpermingguJson = json_decode($dataWlperminggu, true);

            $counterLvlinminggu = 0;
            $counterLvloutminggu = 0;
            $counterLvlactminggu = 0;
            $totaldataLevelinminggu = 0;
            $totaldataLeveloutminggu = 0;
            $totaldataLevelactminggu = 0;

            foreach ($dataWlpermingguJson as $index => $sub_array) {
                foreach ($sub_array as $data) {
                    $counterLvlinminggu += $data['lvl_in'];
                    $counterLvloutminggu += $data['lvl_out'];
                    $counterLvlactminggu += $data['lvl_act'];
                    $totaldataLevelinminggu++;
                    $totaldataLeveloutminggu++;
                    $totaldataLevelactminggu++;

                    $arrDataPerminggu[$index]['nameDay'] = $data['nameDay'];
                    $arrDataPerminggu[$index]['datetime'] = $data['datetime'];
                    $arrDataPerminggu[$index]['lvl_in'] = round(($counterLvlinminggu / $totaldataLevelinminggu), 2);
                    $arrDataPerminggu[$index]['lvl_out'] = round(($counterLvloutminggu / $totaldataLeveloutminggu), 2);
                    $arrDataPerminggu[$index]['lvl_act'] = round(($counterLvlactminggu / $totaldataLevelactminggu), 2);
                }
            }

            $sumLvlActMinggu = 0;
            foreach ($arrDataPerminggu as $key => $value) {
                $sumLvlActMinggu += $value['lvl_act'];
            }

            //ubah skema array per minggu menjadi ploting pada grafik
            foreach ($arrDataPerminggu as $key => $data) {
                $hari = $data['nameDay'];
                $wlperminggu .=
                    "[{v:'" . $hari . "'}, {v:" . $data['lvl_in'] . ", f:'" . $data['lvl_in'] . "'},
                {v:" . $data['lvl_out'] . ", f:'" . $data['lvl_out'] .  "'";
                if ($sumLvlActMinggu == 0) {
                    $wlperminggu .= "}],";
                } else {
                    $wlperminggu .= "},{v:" . $data['lvl_act'] . ", f:'" . $data['lvl_act'] . "'}],";
                }
            }

            $arrWlPermingguView = [
                'plot1'     => 'Level_in (cm)',
                'plot2'     => 'Level_out (cm)',
                'plot3'     => 'Level Actual (cm)',
                'data'      => $wlperminggu
            ];
        }

        $dateParse = Carbon::parse($to)->subDays(30);
        $dateParse = $dateParse->format('Y-m-d H:i:s');

        $pastMonth = date($dateParse);

        $dataWlperbulan = DB::table('water_level_list')
            ->join('water_level', 'water_level_list.id', '=', 'water_level.idwl')
            ->select('water_level.*', 'water_level_list.location as location',  DB::raw("DATE_FORMAT(water_level.datetime,'%d-%m') as day_month"))
            ->where('water_level_list.id', '=', $idLoc)
            ->whereBetween('water_level.datetime', [$pastMonth, $to])
            ->orderBy('water_level.datetime', 'asc')
            ->get()
            ->groupBy('day_month');


        $arrDataPerbulan = array();

        $wlperbulan = '';
        if (!$dataWlperbulan->isEmpty()) {
            foreach ($dataWlperbulan as $sub_array) {
                foreach ($sub_array as $data) {
                    $data->nameDay = $data->datetime;
                    // $data->date = $data->datetime;
                }
            }
            //perhitungan rata-rata semua data per hari dalam satu bulan
            $dataWlperbulanJson = json_decode($dataWlperbulan, true);

            $counterLvlinbulan = 0;
            $counterLvloutbulan = 0;
            $counterLvlactbulan = 0;
            $totaldataLevelinbulan = 0;
            $totaldataLeveloutbulan = 0;
            $totaldataLevelactbulan = 0;

            foreach ($dataWlperbulanJson as $index => $sub_array) {
                foreach ($sub_array as $data) {
                    $counterLvlinbulan += $data['lvl_in'];
                    $counterLvloutbulan += $data['lvl_out'];
                    $counterLvlactbulan += $data['lvl_act'];
                    $totaldataLevelinbulan++;
                    $totaldataLeveloutbulan++;
                    $totaldataLevelactbulan++;

                    $arrDataPerbulan[$index]['datetime'] = Carbon::parse($data['datetime'])->format('D d');
                    $arrDataPerbulan[$index]['lvl_in'] = round(($counterLvlinbulan / $totaldataLevelinbulan), 2);
                    $arrDataPerbulan[$index]['lvl_out'] = round(($counterLvloutbulan / $totaldataLeveloutbulan), 2);
                    $arrDataPerbulan[$index]['lvl_act'] = round(($counterLvlactbulan / $totaldataLevelactbulan), 2);
                }
            }

            // dd($arrDataPerbulan);
            // $sumLvlActBulan = 0;
            // foreach ($arrDataPerbulan as $key => $value) {
            //     $sumLvlActBulan += $value['lvl_act'];
            // }

            // dd($sumLvlActBulan);
            // dd($sumLvlActBulan);
            //ubah skema array per bulan menjadi ploting pada grafik
            foreach ($arrDataPerbulan as $key => $data) {
                //
                $hari = $data['datetime'];
                $wlperbulan .=
                    "[{v:'" . $hari . "'}, {v:" . $data['lvl_in'] . ", f:'" . $data['lvl_in'] . "'},
                    {v:" . $data['lvl_out'] . ", f:'" . $data['lvl_out'] . "'},
                    {v:" . $data['lvl_act'] . ", f:'" . $data['lvl_act'] . "'}
                ],";
            }

            $arrWlPerbulanView = [
                'plot1'     => 'Level In',
                'plot2'     => 'Level Out',
                'plot3'     => 'Level Actual',
                'data'      => $wlperbulan
            ];
        }


        return view('water_level/grafik', [
            'arrWlPerhariiniView' => $arrWlPerhariiniView,
            'arrWlPermingguView' => $arrWlPermingguView,
            'arrWlPerbulanView' => $arrWlPerbulanView,
            'avgLvlActHariIni' => $avgLvlActHariIni,
            'sumLvlActMinggu' => $sumLvlActMinggu,
            // 'sumLvlActBulan' => $sumLvlActBulan,
            'dateToday' =>  Carbon::now()->format('d-m-Y H:i:s'),
            'listLoc' => $listLoc,
            'defaultId' => $defaultId,
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

        // dd($dataLog);
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
}
