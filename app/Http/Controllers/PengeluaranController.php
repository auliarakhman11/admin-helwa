<?php

namespace App\Http\Controllers;

use App\Models\AkunPengeluaran;
use App\Models\Cabang;
use App\Models\Investor;
use App\Models\Pengeluaran;
use App\Models\PengeluaranInvestor;
use App\Models\PersenInvestor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PengeluaranController extends Controller
{
    public function akunPengeluaran()
    {
        return view('pengeluaran.akunPengeluaran', [
            'title' => 'Akun',
            'akun' => AkunPengeluaran::where('void', 0)->get(),
        ]);
    }

    public function addAkun(Request $request)
    {
        AkunPengeluaran::create([
            'nm_akun' => $request->nm_akun,
            'void' => 0
        ]);

        return redirect()->back()->with('success', 'Data berhasil dibuat');
    }

    public function editAkun(Request $request)
    {
        AkunPengeluaran::where('id', $request->id)->update([
            'nm_akun' => $request->nm_akun,
        ]);

        return redirect()->back()->with('success', 'Data berhasil diubah');
    }

    public function dropAkun(Request $request)
    {
        AkunPengeluaran::where('id', $request->id)->update([
            'void' => 1,
        ]);

        Pengeluaran::where('akun_id', $request->id)->update([
            'void' => 1,
        ]);

        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }

    public function pengeluaran(Request $request)
    {
        if ($request->query('tgl1')) {
            $tgl1 = $request->query('tgl1');
            $tgl2 = $request->query('tgl2');
        } else {
            $tgl1 = date('Y-m-d', strtotime("-30 day", strtotime(date("Y-m-d"))));
            $tgl2 = date('Y-m-d');
        }

        return view('pengeluaran.pengeluaran', [
            'title' => 'Pengeluaran',
            'tgl1' => $tgl1,
            'tgl2' => $tgl2,
            'cabang' => Cabang::where('off', 0)->get(),
            'investor' => Investor::where('void', 0)->get(),
            'akun' => AkunPengeluaran::where('void', 0)->get(),
            'pengeluaran' => Pengeluaran::where('tgl', '>=', $tgl1)->where('tgl', '<=', $tgl2)->where('void', 0)->orderBy('tgl', 'ASC')->orderBy('id', 'DESC')->with(['akun', 'user', 'cabang', 'investor'])->get(),
        ]);
    }

    public function addPengeluaran(Request $request)
    {
        $kd_gabungan = date('Ymd') . strtoupper(Str::random(3));
        Pengeluaran::create([
            'kd_gabungan' => $kd_gabungan,
            'cabang_id' => $request->cabang_id,
            'akun_id' => $request->akun_id,
            'jenis' => $request->jenis,
            'investor_id' => $request->investor_id,
            'jumlah' => $request->jumlah,
            'ket' => $request->ket,
            'tgl' => $request->tgl,
            'user_id' => Auth::id(),
            'void' => 0
        ]);

        if ($request->jenis == 0) {
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

            $cek = PersenInvestor::where('cabang_id', $request->cabang_id)->where('tgl', '>=', $request->tgl)->groupBy('tgl')->get();

            if ($cek) {
                PersenInvestor::where('cabang_id', $request->cabang_id)->where('tgl', '>=', $request->tgl)->delete();

                $dt_cabang = PengeluaranInvestor::select('cabang.nama', 'cabang.id')->selectRaw("SUM(jumlah) as jml_pengeluaran")->leftJoin('cabang', 'pengeluaran_investor.cabang_id', '=', 'cabang.id')->where('void', 0)->where('cabang.off', 0)->groupBy('cabang_id')->get();
                $dt_investor = PengeluaranInvestor::select('cabang_id', 'investor_id', 'cabang.nama', 'investor.nm_investor')->selectRaw("SUM(jumlah) as jml_pengeluaran")->leftJoin('cabang', 'pengeluaran_investor.cabang_id', '=', 'cabang.id')->leftJoin('investor', 'pengeluaran_investor.investor_id', '=', 'investor.id')->where('pengeluaran_investor.void', 0)->where('cabang.off', 0)->where('investor.void', 0)->groupBy('cabang_id')->groupBy('investor_id')->get();
                foreach ($cek as $dtgl) {
                    foreach ($dt_cabang as $c) {
                        $dat_investor = $dt_investor->where('cabang_id', $c->id)->all();
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
        }

        return redirect()->back()->with('success', 'Data berhasil dibuat');
    }

    public function editPengeluaran(Request $request)
    {
        Pengeluaran::where('id', $request->id)->update([
            'cabang_id' => $request->cabang_id,
            'akun_id' => $request->akun_id,
            'jumlah' => $request->jumlah,
            'ket' => $request->ket,
            'user_id' => Auth::id(),
        ]);


        $dt_pengeluaran = Pengeluaran::where('id', $request->id)->first();

        if ($dt_pengeluaran->jenis == 0) {
            PengeluaranInvestor::where('kd_gabungan', $dt_pengeluaran->kd_gabungan)->update([
                'jumlah' => $request->jumlah,
                'ket' => $request->ket,
                'user_id' => Auth::id()
            ]);

            $cek = PersenInvestor::where('cabang_id', $dt_pengeluaran->cabang_id)->where('tgl', '>=', $dt_pengeluaran->tgl)->groupBy('tgl')->get();

            if ($cek) {
                PersenInvestor::where('cabang_id', $dt_pengeluaran->cabang_id)->where('tgl', '>=', $dt_pengeluaran->tgl)->delete();

                $dt_cabang = PengeluaranInvestor::select('cabang.nama', 'cabang.id')->selectRaw("SUM(jumlah) as jml_pengeluaran")->leftJoin('cabang', 'pengeluaran_investor.cabang_id', '=', 'cabang.id')->where('void', 0)->where('cabang.off', 0)->groupBy('cabang_id')->get();
                $dt_investor = PengeluaranInvestor::select('cabang_id', 'investor_id', 'cabang.nama', 'investor.nm_investor')->selectRaw("SUM(jumlah) as jml_pengeluaran")->leftJoin('cabang', 'pengeluaran_investor.cabang_id', '=', 'cabang.id')->leftJoin('investor', 'pengeluaran_investor.investor_id', '=', 'investor.id')->where('pengeluaran_investor.void', 0)->where('cabang.off', 0)->where('investor.void', 0)->groupBy('cabang_id')->groupBy('investor_id')->get();
                foreach ($cek as $dtgl) {
                    foreach ($dt_cabang as $c) {
                        $dat_investor = $dt_investor->where('cabang_id', $c->id)->all();
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
        }

        return redirect()->back()->with('success', 'Data berhasil diubah');
    }

    public function dropPengeluaran(Request $request)
    {

        Pengeluaran::where('id', $request->id)->update([
            'void' => 1,
        ]);

        $dt_pengeluaran = Pengeluaran::where('id', $request->id)->first();

        if ($dt_pengeluaran->jenis == 0) {
            PengeluaranInvestor::where('kd_gabungan', $dt_pengeluaran->kd_gabungan)->update([
                'user_id' => Auth::id(),
                'void' => 1,
            ]);

            $cek = PersenInvestor::where('cabang_id', $dt_pengeluaran->cabang_id)->where('tgl', '>=', $dt_pengeluaran->tgl)->groupBy('tgl')->get();

            if ($cek) {
                PersenInvestor::where('cabang_id', $dt_pengeluaran->cabang_id)->where('tgl', '>=', $dt_pengeluaran->tgl)->delete();

                $dt_cabang = PengeluaranInvestor::select('cabang.nama', 'cabang.id')->selectRaw("SUM(jumlah) as jml_pengeluaran")->leftJoin('cabang', 'pengeluaran_investor.cabang_id', '=', 'cabang.id')->where('void', 0)->where('cabang.off', 0)->groupBy('cabang_id')->get();
                $dt_investor = PengeluaranInvestor::select('cabang_id', 'investor_id', 'cabang.nama', 'investor.nm_investor')->selectRaw("SUM(jumlah) as jml_pengeluaran")->leftJoin('cabang', 'pengeluaran_investor.cabang_id', '=', 'cabang.id')->leftJoin('investor', 'pengeluaran_investor.investor_id', '=', 'investor.id')->where('pengeluaran_investor.void', 0)->where('cabang.off', 0)->where('investor.void', 0)->groupBy('cabang_id')->groupBy('investor_id')->get();
                foreach ($cek as $dtgl) {
                    foreach ($dt_cabang as $c) {
                        $dat_investor = $dt_investor->where('cabang_id', $c->id)->all();
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
        }

        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}
