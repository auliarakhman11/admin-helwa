<?php

namespace App\Http\Controllers;

use App\Models\Bahan;
use App\Models\Produk;
use App\Models\Stok;
use App\Models\StokGudang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StokController extends Controller
{
    public function stokOutlet(Request $request)
    {
        if ($request->query('tgl1')) {
            $tgl1 = $request->query('tgl1');
            $tgl2 = $request->query('tgl2');
        } else {
            $tgl1 = date('Y-m-01');
            $tgl2 = date('Y-m-t');
        }

        $bahan = Bahan::select('bahan.bahan', 'bahan.id')->selectRaw("dt_stok.qty_masuk, dt_stok.qty_masuk_lalu, dt_stok.qty_keluar, dt_stok.qty_keluar_lalu")
            ->leftJoin(
                DB::raw("(SELECT produk_id, SUM(IF(tgl >= '2026-06-01' AND tgl < '$tgl1' AND jenis = 1,qty,0)) as qty_masuk_lalu, SUM(IF(tgl >= '$tgl1' AND tgl <= '$tgl2' AND jenis = 1,qty,0)) as qty_masuk, SUM(IF(tgl >= '2026-06-01' AND tgl < '$tgl1' AND jenis = 1,qty,0)) as qty_keluar_lalu, SUM(IF(tgl >= '$tgl1' AND tgl <= '$tgl2' AND jenis = 2,qty,0)) as qty_keluar FROM stok WHERE tgl >= '2026-06-01' AND tgl <= '$tgl2' AND void = 0 AND jenis_bahan = 2 GROUP BY produk_id) dt_stok"),
                'bahan.id',
                '=',
                'dt_stok.produk_id'
            )->where('aktif', 'Y')->get();

        $produk = Produk::select('produk.nm_produk', 'produk.id')->selectRaw("dt_stok.qty_masuk, dt_stok.qty_masuk_lalu, dt_stok.qty_keluar, dt_stok.qty_keluar_lalu")
            ->leftJoin(
                DB::raw("(SELECT produk_id, SUM(IF(tgl >= '2026-06-01' AND tgl < '$tgl1' AND jenis = 1,qty,0)) as qty_masuk_lalu, SUM(IF(tgl >= '$tgl1' AND tgl <= '$tgl2' AND jenis = 1,qty,0)) as qty_masuk, SUM(IF(tgl >= '2026-06-01' AND tgl < '$tgl1' AND jenis = 1,qty,0)) as qty_keluar_lalu, SUM(IF(tgl >= '$tgl1' AND tgl <= '$tgl2' AND jenis = 2,qty,0)) as qty_keluar FROM stok WHERE tgl >= '2026-06-01' AND tgl <= '$tgl2' AND void = 0 AND jenis_bahan = 1 GROUP BY produk_id) dt_stok"),
                'produk.id',
                '=',
                'dt_stok.produk_id'
            )->where('hapus', 0)->get();

        $data = [
            'title' => 'Stok Outlet',
            'tgl1' => $tgl1,
            'tgl2' => $tgl2,
            'bahan' => $bahan,
            'produk' => $produk
        ];
        return view('stok.index', $data);
    }

    public function stokGudang(Request $request)
    {
        if ($request->query('tgl1')) {
            $tgl1 = $request->query('tgl1');
            $tgl2 = $request->query('tgl2');
        } else {
            $tgl1 = date('Y-m-01');
            $tgl2 = date('Y-m-t');
        }

        $bahan = Bahan::select('bahan.bahan', 'bahan.id')->selectRaw("dt_stok.qty_masuk, dt_stok.qty_masuk_lalu, dt_stok.qty_keluar, dt_stok.qty_keluar_lalu")
            ->leftJoin(
                DB::raw("(SELECT produk_id, SUM(IF(tgl >= '2026-06-01' AND tgl < '$tgl1' AND jenis = 1,qty,0)) as qty_masuk_lalu, SUM(IF(tgl >= '$tgl1' AND tgl <= '$tgl2' AND jenis = 1,qty,0)) as qty_masuk, SUM(IF(tgl >= '2026-06-01' AND tgl < '$tgl1' AND jenis = 1,qty,0)) as qty_keluar_lalu, SUM(IF(tgl >= '$tgl1' AND tgl <= '$tgl2' AND jenis = 2,qty,0)) as qty_keluar FROM stok_gudang WHERE tgl >= '2026-06-01' AND tgl <= '$tgl2' AND void = 0 AND jenis_bahan = 2 GROUP BY produk_id) dt_stok"),
                'bahan.id',
                '=',
                'dt_stok.produk_id'
            )->where('aktif', 'Y')->get();

        $produk = Produk::select('produk.nm_produk', 'produk.id')->selectRaw("dt_stok.qty_masuk, dt_stok.qty_masuk_lalu, dt_stok.qty_keluar, dt_stok.qty_keluar_lalu")
            ->leftJoin(
                DB::raw("(SELECT produk_id, SUM(IF(tgl >= '2026-06-01' AND tgl < '$tgl1' AND jenis = 1,qty,0)) as qty_masuk_lalu, SUM(IF(tgl >= '$tgl1' AND tgl <= '$tgl2' AND jenis = 1,qty,0)) as qty_masuk, SUM(IF(tgl >= '2026-06-01' AND tgl < '$tgl1' AND jenis = 1,qty,0)) as qty_keluar_lalu, SUM(IF(tgl >= '$tgl1' AND tgl <= '$tgl2' AND jenis = 2,qty,0)) as qty_keluar FROM stok_gudang WHERE tgl >= '2026-06-01' AND tgl <= '$tgl2' AND void = 0 AND jenis_bahan = 1 GROUP BY produk_id) dt_stok"),
                'produk.id',
                '=',
                'dt_stok.produk_id'
            )->where('hapus', 0)->get();

        $data = [
            'title' => 'Stok Gudang',
            'tgl1' => $tgl1,
            'tgl2' => $tgl2,
            'bahan' => $bahan,
            'produk' => $produk
        ];
        return view('stok.stokGudang', $data);
    }

    public function addStokMasukGudang(Request $request)
    {

        $admin = Auth::id();

        $data_stok = [];

        $produk_id = $request->produk_id;
        $qty = $request->qty;
        $harga = $request->harga;

        $no_invoice = 'INV' . date('dmy') . strtoupper(Str::random(5));

        for ($count = 0; $count < count($produk_id); $count++) {

            $data_barang = explode("|", $produk_id[$count]);

            $id_produk = $data_barang[0];
            $jenis_bahan = $data_barang[1];

            $data_stok[] = [
                'no_invoice' => $no_invoice,
                'produk_id' => $id_produk,
                'cabang_id' => 1,
                'qty' => $qty[$count],
                'harga' => $harga[$count],
                'tgl' => $request->tgl,
                'admin' => $admin,
                'jenis' => 1,
                'jenis_bahan' => $jenis_bahan,
                'void' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }

        StokGudang::insert($data_stok);

        return redirect()->back()->with('success', 'Data berhasil dibuat');
    }

    public function addStokKeluarGudang(Request $request)
    {

        $admin = Auth::id();

        $data_stok = [];

        $data_stok_outlet = [];

        $produk_id = $request->produk_id;
        $qty = $request->qty;
        $harga = $request->harga;
        $harga_normal = $request->harga_normal;

        $no_invoice = 'INV' . date('dmy') . strtoupper(Str::random(5));

        for ($count = 0; $count < count($produk_id); $count++) {

            $kd_gabungan = 'GB' . date('dmy') . strtoupper(Str::random(5));

            $data_barang = explode("|", $produk_id[$count]);

            $id_produk = $data_barang[0];
            $jenis_bahan = $data_barang[1];

            $data_stok[] = [
                'no_invoice' => $no_invoice,
                'kd_gabungan' => $kd_gabungan,
                'produk_id' => $id_produk,
                'cabang_id' => 1,
                'qty' => $qty[$count],
                'harga' => $harga[$count],
                'harga_normal' => $harga_normal[$count],
                'tgl' => $request->tgl,
                'admin' => $admin,
                'jenis' => 2,
                'jenis_bahan' => $jenis_bahan,
                'void' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            $data_stok_outlet[] = [
                'kd_gabungan' => $kd_gabungan,
                'produk_id' => $id_produk,
                'cabang_id' => 1,
                'qty' => $qty[$count],
                'harga' => $harga[$count],
                'tgl' => $request->tgl,
                'admin' => $admin,
                'jenis' => 1,
                'jenis_bahan' => $jenis_bahan,
                'void' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }

        StokGudang::insert($data_stok);
        Stok::insert($data_stok_outlet);

        return redirect()->back()->with('success', 'Data berhasil dibuat');
    }

    public function getHarga(Request $request)
    {
        $dt_harga = StokGudang::where('produk_id', $request->produk_id)->where('jenis_bahan', $request->jenis_bahan)->where('jenis', 1)->where('void', 0)->where('qty', '>', 0)->where('tgl', '>=', '2026-06-01')
            ->max(DB::raw('COALESCE(harga, 0)  / qty'));

        if ($dt_harga) {
            // $harga_beli = ($dt_harga->ttl_harga + $dt_harga->ttl_harga_hutang) / $dt_harga->ttl_qty;
            // $real_harga = $harga_beli ? $harga_beli + ($harga_beli * 20 / 100) : 0;
            $harga_beli = $dt_harga;
            $real_harga = $dt_harga ? $dt_harga + ($dt_harga * 10 / 100) : 0;

            return response()->json([
                'status' => 'success',
                'harga_jual' => ceil($real_harga),
                'harga_beli' => ceil($harga_beli)
            ], 200);
        } else {

            if ($request->jenis_bahan == 1) {
                $harga_jual = 1500;
            } else {
                if ($request->produk_id == 1 || $request->produk_id == 2 || $request->produk_id == 3) {
                    $harga_jual = 100;
                } else {
                    $harga_jual = 5000;
                }
            }

            return response()->json([
                'status' => 'success',
                'harga_jual' => $harga_jual,
                'harga_beli' =>  $harga_jual
            ], 200);
        }
    }

    public function getInvoiceGudang(Request $request)
    {

        $dt_invoice = StokGudang::select('no_invoice', 'tgl', 'jenis')->selectRaw("SUM(harga) as ttl_harga")->where('tgl', '>=', $request->tgl1)->where('tgl', '<=', $request->tgl2)->where('void', 0)->groupBy('jenis')->groupBy('no_invoice')->orderBy('tgl', 'ASC')->get();

        $data = [
            'title' => 'Stok Gudang',
            'tgl1' => $request->tgl1,
            'tgl2' => $request->tgl2,
            'dt_invoice' => $dt_invoice
        ];
        return view('stok.invoiceGudang', $data);
    }

    public function getDetailInvoiceGudang(Request $request)
    {

        $dt_invoice = StokGudang::where('no_invoice', $request->no_invoice)->where('void', 0)->with(['produk', 'bahan'])->get();

        $data = [
            'title' => 'Stok Gudang',
            'tgl1' => $request->tgl1,
            'tgl2' => $request->tgl2,
            'dt_invoice' => $dt_invoice
        ];
        return view('stok.getDetailInvoiceGudang', $data);
    }

    public function deleteInvoice($no_invoice)
    {
        $dt_invoice = StokGudang::where('no_invoice', $no_invoice)->get();

        StokGudang::where('no_invoice', $no_invoice)->update(['void' => 1]);

        foreach ($dt_invoice as $d) {
            if ($d->kd_gabungan) {
                Stok::where('kd_gabungan', $d->kd_gabungan)->update(['void' => 1]);
            }
        }

        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}
