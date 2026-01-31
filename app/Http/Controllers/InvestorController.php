<?php

namespace App\Http\Controllers;

use App\Models\Investor;
use Illuminate\Http\Request;

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
}
