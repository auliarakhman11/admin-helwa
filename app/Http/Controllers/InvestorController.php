<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\Investor;
use App\Models\PengeluaranInvestor;
use App\Models\PersenInvestor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class InvestorController extends Controller
{
    public function index()
    {
        return view('investor.index', [
            'title' => 'Investor',
            'investor' => Investor::where('void', 0)->get(),
        ]);
    }

    public function addInvestor(Request $request)
    {
        Investor::create([
            'nm_investor' => $request->nm_investor,
            'void' => 0
        ]);

        return redirect()->back()->with('success', 'Data berhasil dibuat');
    }

    public function editInvestor(Request $request)
    {
        Investor::where('id', $request->id)->update([
            'nm_investor' => $request->nm_investor,
        ]);

        return redirect()->back()->with('success', 'Data berhasil diubah');
    }

    public function dropInvestor(Request $request)
    {
        Investor::where('id', $request->id)->update([
            'void' => 1,
        ]);

        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }

    public function pengeluaranInvestor(){
        $dt_cabang = PengeluaranInvestor::select('cabang.nama','cabang.id')->selectRaw("SUM(jumlah) as jml_pengeluaran")->leftJoin('cabang','pengeluaran_investor.cabang_id','=','cabang.id')->where('void', 0)->where('cabang.off',0)->groupBy('cabang_id')->get();
        $dt_investor = PengeluaranInvestor::select('cabang_id','investor_id','cabang.nama','investor.nm_investor')->selectRaw("SUM(jumlah) as jml_pengeluaran")->leftJoin('cabang','pengeluaran_investor.cabang_id','=','cabang.id')->leftJoin('investor','pengeluaran_investor.investor_id','=','investor.id')->where('pengeluaran_investor.void', 0)->where('cabang.off',0)->where('investor.void',0)->groupBy('cabang_id')->groupBy('investor_id')->get();
        return view('investor.pengeluaranInvestor', [
            'title' => 'Investor',
            'investor' => Investor::where('void', 0)->get(),
            'pengeluaran' => PengeluaranInvestor::where('void', 0)->orderBy('tgl','DESC')->orderBy('id','DESC')->with(['investor','cabang'])->get(),
            'dt_cabang' => $dt_cabang,
            'cabang' => Cabang::where('off',0)->get(),
            'dt_investor' => $dt_investor
        ]);
    }

    public function addPengeluaranInvestor(Request $request)
    {
        $kd_gabungan = date('Ymd').strtoupper(Str::random(3));

        PengeluaranInvestor::create([
            'kd_gabungan' => $kd_gabungan,
            'investor_id' => $request->investor_id,
            'cabang_id' => $request->cabang_id,
            'jumlah' => $request->jumlah,
            'ket' => $request->ket,
            'tgl' => $request->tgl,
            'void' => 0,
            'user_id' => Auth::id()
        ]);

        $cek = PersenInvestor::where('cabang_id',$request->cabang_id)->where('tgl','>=',$request->tgl)->groupBy('tgl')->get();

        if ($cek) {
            PersenInvestor::where('cabang_id',$request->cabang_id)->where('tgl','>=',$request->tgl)->delete();

            $dt_cabang = PengeluaranInvestor::select('cabang.nama','cabang.id')->selectRaw("SUM(jumlah) as jml_pengeluaran")->leftJoin('cabang','pengeluaran_investor.cabang_id','=','cabang.id')->where('void', 0)->where('cabang.off',0)->groupBy('cabang_id')->get();
            $dt_investor = PengeluaranInvestor::select('cabang_id','investor_id','cabang.nama','investor.nm_investor')->selectRaw("SUM(jumlah) as jml_pengeluaran")->leftJoin('cabang','pengeluaran_investor.cabang_id','=','cabang.id')->leftJoin('investor','pengeluaran_investor.investor_id','=','investor.id')->where('pengeluaran_investor.void', 0)->where('cabang.off',0)->where('investor.void',0)->groupBy('cabang_id')->groupBy('investor_id')->get();
            foreach ($cek as $dtgl) {
                foreach ($dt_cabang as $c) {
                    $dat_investor = $dt_investor->where('cabang_id',$c->id)->all();
                    foreach ($dat_investor as $d) {
                        PersenInvestor::create([
                            'investor_id' => $d->investor_id,
                            'cabang_id' => $d->cabang_id,
                            'jml_persen' => $d->jml_pengeluaran > 0 && $c->jml_pengeluaran > 0 ? $d->jml_pengeluaran / $c->jml_pengeluaran * 100 : 0,
                            'tgl' => $dtgl->tgl
                        ]);
                    }
                }
            }
        }

        return redirect()->back()->with('success', 'Data berhasil dibuat');
    }

    public function editPengeluaranInvestor(Request $request)
    {
        PengeluaranInvestor::where('id',$request->id)->update([
            'investor_id' => $request->investor_id,
            'cabang_id' => $request->cabang_id,
            'jumlah' => $request->jumlah,
            'ket' => $request->ket,
            // 'tgl' => $request->tgl,
            'user_id' => Auth::id()
        ]);

        return redirect()->back()->with('success', 'Data berhasil dibuat');
    }

    public function dropPengeluaranInvestor(Request $request)
    {
        PengeluaranInvestor::where('id', $request->id)->update([
            'void' => 1,
            'user_id' => Auth::id()
        ]);

        $cek = PersenInvestor::where('cabang_id',$request->cabang_id)->where('tgl','>=',$request->tgl)->groupBy('tgl')->get();

        if ($cek) {
            PersenInvestor::where('cabang_id',$request->cabang_id)->where('tgl','>=',$request->tgl)->delete();

            $dt_cabang = PengeluaranInvestor::select('cabang.nama','cabang.id')->selectRaw("SUM(jumlah) as jml_pengeluaran")->leftJoin('cabang','pengeluaran_investor.cabang_id','=','cabang.id')->where('void', 0)->where('cabang.off',0)->groupBy('cabang_id')->get();
            $dt_investor = PengeluaranInvestor::select('cabang_id','investor_id','cabang.nama','investor.nm_investor')->selectRaw("SUM(jumlah) as jml_pengeluaran")->leftJoin('cabang','pengeluaran_investor.cabang_id','=','cabang.id')->leftJoin('investor','pengeluaran_investor.investor_id','=','investor.id')->where('pengeluaran_investor.void', 0)->where('cabang.off',0)->where('investor.void',0)->groupBy('cabang_id')->groupBy('investor_id')->get();
            foreach ($cek as $dtgl) {
                foreach ($dt_cabang as $c) {
                    $dat_investor = $dt_investor->where('cabang_id',$c->id)->all();
                    foreach ($dat_investor as $d) {
                        PersenInvestor::create([
                            'investor_id' => $d->investor_id,
                            'cabang_id' => $d->cabang_id,
                            'jml_persen' => $d->jml_pengeluaran > 0 && $c->jml_pengeluaran > 0 ? $d->jml_pengeluaran / $c->jml_pengeluaran * 100 : 0,
                            'tgl' => $dtgl->tgl
                        ]);
                    }
                }
            }
        }

        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }

    public function inputPersenInvestor(){

        $tgl = '2026-01-31';

        $dt_cabang = PengeluaranInvestor::select('cabang.nama','cabang.id')->selectRaw("SUM(jumlah) as jml_pengeluaran")->leftJoin('cabang','pengeluaran_investor.cabang_id','=','cabang.id')->where('void', 0)->where('cabang.off',0)->groupBy('cabang_id')->get();
        $dt_investor = PengeluaranInvestor::select('cabang_id','investor_id','cabang.nama','investor.nm_investor')->selectRaw("SUM(jumlah) as jml_pengeluaran")->leftJoin('cabang','pengeluaran_investor.cabang_id','=','cabang.id')->leftJoin('investor','pengeluaran_investor.investor_id','=','investor.id')->where('pengeluaran_investor.void', 0)->where('cabang.off',0)->where('investor.void',0)->groupBy('cabang_id')->groupBy('investor_id')->get();

        foreach ($dt_cabang as $c) {
           $dat_investor = $dt_investor->where('cabang_id',$c->id)->all();
           foreach ($dat_investor as $d) {
             PersenInvestor::create([
                'investor_id' => $d->investor_id,
                'cabang_id' => $d->cabang_id,
                'jml_persen' => $d->jml_pengeluaran > 0 && $c->jml_pengeluaran > 0 ? $d->jml_pengeluaran / $c->jml_pengeluaran * 100 : 0,
                'tgl' => $tgl
             ]);
           }
        }

        return true;

    }

}
