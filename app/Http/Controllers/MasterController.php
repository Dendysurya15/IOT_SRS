<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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

    public static function dashboard_ws()
    {
        $sel_aws = DB::table('weather_station_list')
            ->join('weather_station', 'weather_station_list.id', '=', 'weather_station.idws')
            ->select('weather_station.*', 'weather_station_list.rain_cal as rain_cal', 'weather_station_list.loc as loc')
            ->orderByDesc('weather_station.id')
            ->take(1)
            ->get();
        $sel_aws = json_decode(json_encode($sel_aws), true);

        $aws_loc = DB::table('weather_station_list')->get();
        $aws_loc = json_decode(json_encode($aws_loc), true);

        $aws_tanggal    = '';
        $aws_jam        = '';
        $aws_hari       = '';
        foreach ($sel_aws as $value) {
            $aws_tanggal    = date('d-m-Y', strtotime($value['datetime']));
            $aws_jam        = date('H:i:s', strtotime($value['datetime']));
            $aws_hari       = date('D', strtotime($value['datetime']));
        }
        $aws_hari       = app('App\Http\Controllers\MasterController')->hari_ini($sel_aws);
        $aws_terakhir   = [
            'tanggal'   => $aws_tanggal,
            'jam'       => $aws_jam,
            'hari'      => $aws_hari
        ];
        return view('weather_station/dashboard', ['aws' => $sel_aws, 'aws_loc' => $aws_loc, 'updateterakhir' => $aws_terakhir, '']);
    }

    public static function Grafik()
    {
        $sel_aws = DB::table('weather_station_list')
            ->join('weather_station', 'weather_station_list.id', '=', 'weather_station.idws')
            ->select('weather_station.*', 'weather_station_list.rain_cal as rain_cal', 'weather_station_list.loc as loc')
            ->orderByDesc('weather_station.id')
            ->get();
        $sel_aws = json_decode(json_encode($sel_aws), true);


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
        $filHariini         = date('d-m-Y', strtotime("2021-11-13"));

        foreach ($sel_aws as $value) {
            $perBulan   = date('m', strtotime($value['datetime']));

            #PERHARIINI            
            $perHariini  = date('d-m-Y', strtotime($value['datetime']));

            if (strtotime($perHariini) > strtotime($filHariini)) {

                $tanggal    = date('H:i d-m-Y', strtotime($value['datetime']));
                $jam        = date('H:i', strtotime($value['datetime']));
                $awsPerhariini .= "[{v: '" . $jam . "', f:'" . $tanggal . "'}, {v:" . $value['t'] . ", f:'" . $value['t'] . " °C " . $value['loc'] . "'}                                      
                                ],";
            }

            #PERMINGGU
            $perMinggu  = date('d-m-Y', strtotime($value['datetime']));
            if (strtotime($perMinggu) > strtotime($filMinggu)) {
                $tanggal    = date('H:i d-m-Y', strtotime($value['datetime']));
                $jam        = date('H:i', strtotime($value['datetime']));
                $awsPerminggu .= "[{v: '" . $jam . "', f:'" . $tanggal . "'}, {v:" . $value['t'] . ", f:'" . $value['t'] . " °C " . $value['loc'] . "'}                                
                                ],";
            }

            #PERBULAN
            if ($filBulan == $perBulan) {
                $tanggal    = date('H:i d-m-Y', strtotime($value['datetime']));
                $jam        = date('H:i', strtotime($value['datetime']));
                $awsPerbulan .= "[{v: '" . $jam . "', f:'" . $tanggal . "'}, {v:" . $value['t'] . ", f:'" . $value['t'] . " °C " . $value['loc'] . "'}                                     
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

        return view('weather_station/grafik', [
            'arrAwsHariIni'     => $arrAwsPerhariini,
            'arrAwsPerminggu'   => $arrAwsPerminggu,
            'arrAwsPerbulan'    => $arrAwsPerbulan,
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
        // dd($queryFoto->foto_udara);

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

            $dataWlperhari = json_decode(json_encode($dataWlperhari), true);
        }

        return view('water_level/dashboard', [
            'dataWlperhari' => $dataWlperhari,
            'avg' => $avg,
            'timeToday' =>  Carbon::now()->format('d-m-Y H:i:s'),
            'listLoc' => $listLoc,
            'maps' => $queryMaps,
            'defaultId' => $defaultId,
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

        //get all data per hari
        $dataWlperhari = DB::table('water_level_list')
            ->join('water_level', 'water_level_list.id', '=', 'water_level.idwl')
            ->select('water_level.*', 'water_level_list.location as location')
            ->orderBy('water_level.datetime')
            ->where(DB::raw("(DATE_FORMAT(water_level.datetime,'%Y-%m-%d'))"), '=', $dateToday->format('Y-m-d'))
            ->where('water_level_list.id', '=', $idLoc)
            ->get();


        if (!$dataWlperhari->isEmpty()) {
            $dataWlperhari = json_decode(json_encode($dataWlperhari), true);
            foreach ($dataWlperhari as $value) {

                //Perhari
                $jam        = date('H:i', strtotime($value['datetime']));
                $wlhariini .=
                    "[{v:'" . $jam . "'}, {v:" . $value['lvl_in'] . ", f:'" . $value['lvl_in'] . "'},
                         {v:" . $value['lvl_out'] . ", f:'" . $value['lvl_out'] . "'},
                         {v:" . $value['lvl_act'] . ", f:'" . $value['lvl_act'] . "'}                                      
                     ],";
            }

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

            $latestDataToday =  Carbon::parse($latestDataToday->datetime)->format('d-m-Y H:i:s');
        }

        $dataWlperminggu = DB::table('water_level_list')
            ->join('water_level', 'water_level_list.id', '=', 'water_level.idwl')
            ->select('water_level.*', 'water_level_list.location as location', DB::raw("DATE_FORMAT(water_level.datetime,'%d-%m-%Y') as datetime"))
            ->whereBetween('water_level.datetime', [$dateToday->startOfWeek()->format('Y-m-d'), $dateToday->endOfWeek()->format('Y-m-d')])
            ->where('water_level_list.id', '=', $idLoc)
            ->orderBy('datetime', 'asc')
            ->get()
            ->groupBy(function ($item) {
                return $item->datetime;
            });

        if (!$dataWlperminggu->isEmpty()) {
            foreach ($dataWlperminggu as $sub_array) {
                foreach ($sub_array as $data) {
                    $data->nameDay = Carbon::parse($data->datetime)->format('l');
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

            //ubah skema array per minggu menjadi ploting pada grafik
            foreach ($arrDataPerminggu as $key => $data) {
                $hari = $data['nameDay'];
                $wlperminggu .=
                    "[{v:'" . $hari . "'}, {v:" . $data['lvl_in'] . ", f:'" . $data['lvl_in'] . "'},
                {v:" . $data['lvl_out'] . ", f:'" . $data['lvl_out'] . "'},
                {v:" . $data['lvl_act'] . ", f:'" . $data['lvl_act'] . "'}
            ],";
            }

            $arrWlPermingguView = [
                'plot1'     => 'Level_in (cm)',
                'plot2'     => 'Level_out (cm)',
                'plot3'     => 'Level Actual (cm)',
                'data'      => $wlperminggu
            ];
        }


        $dataWlperbulan = DB::table('water_level_list')
            ->join('water_level', 'water_level_list.id', '=', 'water_level.idwl')
            ->select('water_level.*', 'water_level_list.location as location',  DB::raw("DATE_FORMAT(water_level.datetime,'%d-%m') as day_month"))
            ->where('water_level_list.id', '=', $idLoc)
            ->whereYear('water_level.datetime', $dateToday->format('Y'))
            ->whereMonth('water_level.datetime', $dateToday->format('m'))
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
            'dateToday' => $latestDataToday ?: Carbon::now()->format('d-m-Y H:i:s'),
            'listLoc' => $listLoc,
            'defaultId' => $defaultId
        ]);
    }

    public function tabel_wl(Request $request)
    {
        $defaultId = '';
        $idLoc = $request->has('id') ? $request->input('id') : $defaultId = 99;

        $data =  DB::table('water_level_list')
            ->join('water_level', 'water_level_list.id', '=', 'water_level.idwl')
            ->select('water_level.*')
            ->orderBy('water_level.id', 'desc')
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
