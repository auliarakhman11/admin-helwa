<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Member',
            'member' => Member::where('void', 0)->get(),

        ];
        return view('member.index', $data);
    }

    public function addMember(Request $request)
    {
        $cek = Member::where('no_tlp', $request->no_tlp)->first();
        if ($cek) {
            return redirect()->back()->with('error', 'Data nomor wa sudah ada');
        } else {
            Member::create([
                'no_tlp' => $request->no_tlp,
                'nm_member' => $request->nm_member,
                'diskon' => $request->diskon,
                'void' => 0,
            ]);

            return redirect()->back()->with('success', 'Data member berhasil dibuat');
        }
    }

    public function editMember(Request $request)
    {
        Member::where('id', $request->id)->update([
            'no_tlp' => $request->no_tlp,
            'nm_member' => $request->nm_member,
            'diskon' => $request->diskon,
        ]);

        return redirect()->back()->with('success', 'Data member berhasil diubah');
    }

    public function dropMember(Request $request)
    {
        Member::where('id', $request->id)->update([
            'void' => 1,
        ]);

        return redirect()->back()->with('success', 'Data member berhasil dihapus');
    }
}
