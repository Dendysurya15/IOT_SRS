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
    //
    public static function Dashboard()
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
        $idLoc = $request->has('id') ? $request->input('id') : $defaultId = 1;
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
        $idLoc = $request->has('id') ? $request->input('id') : $defaultId = 1;

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
        $idLoc = $request->has('id') ? $request->input('id') : $defaultId = 1;

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
