<?php

namespace App\Http\Controllers;

use App\Models\Diskon;
use Illuminate\Http\Request;

class DiskonController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Diskon',
            'diskon' => Diskon::where('void', 0)->get(),

        ];
        return view('diskon.index', $data);
    }

    public function addDiskon(Request $request){
        Diskon::create([
            'nm_diskon' => $request->nm_diskon,
            'jml_diskon' => $request->jml_diskon,
            'maksimal' => $request->maksimal,
            'exp_date' => $request->exp_date,
            'void' => 0
        ]);

        return redirect()->back()->with('success', 'Data berhasil dibuat');
    }

    public function editDiskon(Request $request){
        Diskon::where('id',$request->id)->update([
            'nm_diskon' => $request->nm_diskon,
            'jml_diskon' => $request->jml_diskon,
            'maksimal' => $request->maksimal,
            'exp_date' => $request->exp_date
        ]);

        return redirect()->back()->with('success', 'Data berhasil diubah');
    }

    public function dropDiskon(Request $request){
        Diskon::where('id',$request->id)->update([
            'void' => 1,
        ]);

        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }

}
