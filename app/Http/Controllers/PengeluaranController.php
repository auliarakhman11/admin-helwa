<?php

namespace App\Http\Controllers;

use App\Models\AkunPengeluaran;
use App\Models\Cabang;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            $tgl1 = date('Y-m-d');
            $tgl2 = date('Y-m-t');
        }

        return view('pengeluaran.pengeluaran', [
            'title' => 'Pengeluaran',
            'tgl1' => $tgl1,
            'tgl2' => $tgl2,
            'cabang' => Cabang::where('off', 0)->get(),
            'akun' => AkunPengeluaran::where('void', 0)->get(),
            'pengeluaran' => Pengeluaran::where('tgl', '>=', $tgl1)->where('tgl', '<=', $tgl2)->where('void', 0)->orderBy('tgl', 'ASC')->orderBy('id', 'DESC')->with(['akun', 'user', 'cabang'])->get(),
        ]);
    }

    public function addPengeluaran(Request $request)
    {
        Pengeluaran::create([
            'cabang_id' => $request->cabang_id,
            'akun_id' => $request->akun_id,
            'jenis' => $request->jenis,
            'jumlah' => $request->jumlah,
            'ket' => $request->ket,
            'tgl' => $request->tgl,
            'user_id' => Auth::id(),
            'void' => 0
        ]);

        return redirect()->back()->with('success', 'Data berhasil dibuat');
    }

    public function editPengeluaran(Request $request)
    {
        Pengeluaran::where('id', $request->id)->update([
            'cabang_id' => $request->cabang_id,
            'akun_id' => $request->akun_id,
            'jumlah' => $request->jumlah,
            'ket' => $request->ket,
            'tgl' => $request->tgl,
            'jenis' => $request->jenis,
            'user_id' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Data berhasil diubah');
    }

    public function dropPengeluaran(Request $request)
    {

        Pengeluaran::where('id', $request->id)->update([
            'void' => 1,
        ]);

        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}
