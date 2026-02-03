<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsenController extends Controller
{
    public function index(Request $request)
    {

        if ($request->query('tgl1')) {
            $tgl1 = $request->query('tgl1');
            $tgl2 = $request->query('tgl2');
        } else {
            $tgl1 = date('Y-m-d', strtotime("-7 day", strtotime(date("Y-m-d"))));
            $tgl2 = date('Y-m-d');
        }

        $data = [
            'title' => 'Absen',
            'absen' => Absen::where('void', 0)->where('tgl', '>=', $tgl1)->where('tgl', '<=', $tgl2)->with(['karyawan'])->get(),
            'potongan' => Absen::select('absen.*')->selectRaw('SUM(potongan) as jml_potongan')->where('void', 0)->where('tgl', '>=', $tgl1)->where('tgl', '<=', $tgl2)->with(['karyawan'])->groupBy('karyawan_id')->get(),
            'tgl1' => $tgl1,
            'tgl2' => $tgl2,
        ];
        return view('absen.index', $data);
    }
}
