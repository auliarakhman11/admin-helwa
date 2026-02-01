<?php

namespace App\Http\Controllers;

use App\Models\AkunPengeluaran;
use Illuminate\Http\Request;

class PengeluaranController extends Controller
{
    public function akunPengeluaran()
    {
        return view('pengeluaran.akunPengeluaran', [
            'title' => 'Pengeluaran',
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

        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }

}
