<?php

namespace App\Http\Controllers;

use App\Models\InvoiceKasir;
use App\Models\PenjualanKarywan;
use App\Models\PenjualanKasir;
use App\Models\Stok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenjualanController extends Controller
{
    public function index(Request $request)
    {

        if ($request->query('tgl1')) {
            $tgl1 = $request->query('tgl1');
            $tgl2 = $request->query('tgl2');
        } else {
            $tgl1 = date('Y-m-d', strtotime("-30 day", strtotime(date("Y-m-d"))));
            $tgl2 = date('Y-m-d');
        }

        return view('penjualan.index', [
            'title' => 'Penjualan',
            'tgl1' => $tgl1,
            'tgl2' => $tgl2,
            'invoice' => InvoiceKasir::where('invoice_kasir.void', 0)->where('tgl', '>=', $tgl1)->where('tgl', '<=', $tgl2)->with(['penjualan', 'penjualan.getMenu', 'penjualan.cluster', 'penjualanKaryawan.karyawan', 'pembayaran'])->orderBy('invoice_kasir.pembayaran_id', 'ASC')->orderBy('invoice_kasir.id', 'DESC')->get(),
            'invoice_refund' => InvoiceKasir::where('invoice_kasir.void', 1)->where('tgl', '>=', $tgl1)->where('tgl', '<=', $tgl2)->with(['penjualan', 'penjualan.getMenu', 'penjualan.cluster', 'penjualanKaryawan.karyawan', 'pembayaran'])->orderBy('invoice_kasir.pembayaran_id', 'ASC')->orderBy('invoice_kasir.id', 'DESC')->get(),
        ]);
    }

    public function refundInvoice(Request $request)
    {
        InvoiceKasir::where('id', $request->invoice_id)->update([
            'void' => 1,
            'ket_void' => $request->ket_void,
            'user_void' => Auth::id(),
        ]);

        PenjualanKasir::where('invoice_id', $request->invoice_id)->update([
            'void' => 1,
        ]);

        Stok::where('invoice_id', $request->invoice_id)->update([
            'void' => 1,
        ]);

        PenjualanKarywan::where('invoice_id', $request->invoice_id)->update([
            'void' => 1,
        ]);

        return redirect()->back()->with('success', 'Invoice berhasil direfund');
    }

    public function kembalikanInvoice(Request $request)
    {
        InvoiceKasir::where('id', $request->invoice_id)->update([
            'void' => 0,
            'ket_void' => $request->ket_void,
            'user_void' => Auth::id(),
        ]);

        PenjualanKasir::where('invoice_id', $request->invoice_id)->update([
            'void' => 0,
        ]);

        Stok::where('invoice_id', $request->invoice_id)->update([
            'void' => 0,
        ]);

        PenjualanKarywan::where('invoice_id', $request->invoice_id)->update([
            'void' => 0,
        ]);

        return redirect()->back()->with('success', 'Invoice berhasil dikembalikan');
    }

    public function dashboard(Request $request)
    {
        if ($request->query('tgl1')) {
            $tgl1 = $request->query('tgl1');
            $tgl2 = $request->query('tgl2');
        } else {
            $tgl1 = date('Y-m-d', strtotime("-30 day", strtotime(date("Y-m-d"))));
            $tgl2 = date('Y-m-d');
        }

        $periode = PenjualanKasir::where('tgl', '>=', $tgl1)->where('tgl', '<=', $tgl2)->where('void', 0)->groupBy('tgl')->get();
        $penjualan = InvoiceKasir::select('invoice_kasir.*')->selectRaw("SUM(total) as ttl_penjualan, SUM(diskon) as ttl_diskon")->where('tgl', '>=', $tgl1)->where('tgl', '<=', $tgl2)->where('void', 0)->groupBy('tgl')->get();

        $data_periode = [];
        $data_penjuaalan = [];

        $total_penjualan = 0;

        foreach ($periode as $pr) {

            $dt_penjualan = $penjualan->where('tgl', $pr->tgl)->first();

            $data_periode[] =  date("d/m/Y", strtotime($pr->tgl));
            $data_penjuaalan[] =  $dt_penjualan ? ($dt_penjualan->ttl_penjualan - $dt_penjualan->ttl_diskon) : 0;
            $total_penjualan += $dt_penjualan ? ($dt_penjualan->ttl_penjualan - $dt_penjualan->ttl_diskon) : 0;
        }

        $dt_pr = json_encode($data_periode);

        $data_c = [];

        $dt_chart = [];
        $dt_chart['label'] = 'Grafik Penjualan';
        // $rc1 = str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
        // $rc2 = str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
        // $rc3 = str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
        $color = '2FA97C';
        $dt_chart['data'] =  $data_penjuaalan;
        $dt_chart['backgroundColor'] = '#' . $color;
        $dt_chart['borderColor'] = '#' . $color;
        $dt_chart['borderWidth'] = 1;
        $dt_chart['color'] = 'green';
        $data_c[] = $dt_chart;

        $dtc = json_encode($data_c);


        return view('penjualan.dashboard', [
            'title' => 'Dashboard',
            'tgl1' => $tgl1,
            'tgl2' => $tgl2,
            'chart' => $dtc,
            'periode' => $dt_pr,

        ]);
    }
}
