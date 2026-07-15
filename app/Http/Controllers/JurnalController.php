<?php

namespace App\Http\Controllers;

use App\Models\AkunPengeluaran;
use App\Models\Bahan;
use App\Models\Gapok;
use App\Models\InvoiceKasir;
use App\Models\Karyawan;
use App\Models\Pengeluaran;
use App\Models\PengeluaranInvestor;
use App\Models\PenjualanKasir;
use App\Models\Resep;
use App\Models\SaldoKas;
use App\Models\Stok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JurnalController extends Controller
{
    public function laporanKeuangan(Request $request)
    {

        if ($request->query('tgl1')) {
            $tgl1 = $request->query('tgl1');
            $tgl2 = $request->query('tgl2');
        } else {
            $tgl1 = date('Y-m-01');
            $tgl2 = date('Y-m-t');
        }

        $penjualan = InvoiceKasir::select('invoice_kasir.*')->selectRaw("SUM(total) as ttl_penjualan, SUM(diskon) as ttl_diskon, SUM(pembulatan) as ttl_pembulatan")->where('tgl', '>=', $tgl1)->where('tgl', '<=', $tgl2)->where('void', 0)->first();

        $stok_bahan = Stok::select('produk_id')
            ->selectRaw("SUM(IF(jenis = 1 AND tgl >= '$tgl1' AND tgl <= '$tgl2',harga,0)) as harga_beli, SUM(IF(jenis = 2 AND tgl >= '$tgl1' AND tgl <= '$tgl2',harga,0)) as harga_jual, SUM(IF(jenis = 1 AND tgl < '$tgl1',harga,0)) as harga_beli_lalu, SUM(IF(jenis = 2 AND tgl < '$tgl1',harga,0)) as harga_jual_lalu, dt_saldo.jml_pengeluaran as jml_pengeluaran, dt_saldo.jml_pengeluaran_lalu as jml_pengeluaran_lalu, dt_saldo.jml_saldo as jml_saldo")
            ->leftJoin(
                DB::raw("(SELECT akun_id, SUM(IF(tgl >= '$tgl1' AND tgl <= '$tgl2' AND jenis_saldo = 2,jumlah,0)) as jml_pengeluaran, SUM(IF(tgl < '$tgl1' AND jenis_saldo = 2,jumlah,0)) as jml_pengeluaran_lalu, SUM(IF(jenis_saldo = 1,jumlah,0)) as jml_saldo FROM saldo_kas WHERE tgl >= '2026-06-01' AND void = 0 AND jenis = 1 GROUP BY akun_id) dt_saldo"),
                'stok.produk_id',
                '=',
                'dt_saldo.akun_id'
            )
            ->where('void', 0)
            ->where('jenis_bahan', 2)
            ->where('tgl', '>=', '2026-06-01')
            ->groupBy('produk_id')
            ->with('bahan')
            ->get();

        $saldo_bahan = SaldoKas::selectRaw("SUM(IF(tgl >= '$tgl1' AND tgl <= '$tgl2' AND jenis_saldo = 2,jumlah,0)) as jml_pengeluaran, SUM(IF(tgl < '$tgl1' AND jenis_saldo = 2,jumlah,0)) as jml_pengeluaran_lalu, SUM(IF(jenis_saldo = 1,jumlah,0)) as jml_saldo")->where('tgl', '>=', '2026-06-01')->where('void', 0)->where('jenis', 1)->where('akun_id', 6)->first();

        $stok_produk = Stok::select('produk_id')
            ->selectRaw("SUM(IF(jenis = 1 AND tgl >= '$tgl1' AND tgl <= '$tgl2',harga,0)) as harga_beli, SUM(IF(jenis = 2 AND tgl >= '$tgl1' AND tgl <= '$tgl2',harga,0)) as harga_jual, SUM(IF(jenis = 1 AND tgl < '$tgl1',harga,0)) as harga_beli_lalu, SUM(IF(jenis = 2 AND tgl < '$tgl1',harga,0)) as harga_jual_lalu")
            ->where('void', 0)
            ->where('jenis_bahan', 1)
            ->where('tgl', '>=', '2026-06-01')
            ->with('produk')
            ->first();

        $pengeluaran = Pengeluaran::select('pengeluaran.akun_id')
            ->selectRaw("SUM(IF(tgl >= '$tgl1' AND tgl <= '$tgl2' AND jenis_pengeluaran = 0,jumlah,0)) as ttl_pengeluaran, SUM(IF(tgl >= '$tgl1' AND tgl <= '$tgl2' AND jenis_pengeluaran = 1,jumlah,0)) as ttl_pengeluaran_pokok, SUM(IF(tgl < '$tgl1' AND jenis_pengeluaran = 0,jumlah,0)) as ttl_pengeluaran_lalu, SUM(IF(tgl < '$tgl1' AND jenis_pengeluaran = 1,jumlah,0)) as ttl_pengeluaran_pokok_lalu, dt_saldo.jml_pengeluaran as jml_pengeluaran, dt_saldo.jml_pengeluaran_lalu as jml_pengeluaran_lalu, dt_saldo.jml_saldo as jml_saldo")
            ->leftJoin(
                DB::raw("(SELECT akun_id, SUM(IF(tgl >= '$tgl1' AND tgl <= '$tgl2' AND jenis_saldo = 2,jumlah,0)) as jml_pengeluaran, SUM(IF(tgl >= '2026-06-01' AND tgl < '$tgl1' AND jenis_saldo = 2,jumlah,0)) as jml_pengeluaran_lalu, SUM(IF(jenis_saldo = 1,jumlah,0)) as jml_saldo FROM saldo_kas WHERE tgl >= '2026-06-01' AND void = 0 AND jenis = 2 GROUP BY akun_id) dt_saldo"),
                'pengeluaran.akun_id',
                '=',
                'dt_saldo.akun_id'
            )
            ->where('tgl', '>=', '2026-06-01')->where('void', 0)->groupBy('akun_id')->with('akun')->get();

        $gapok = Gapok::select('karyawan_id')
            ->selectRaw("SUM(IF(tgl >= '$tgl1' AND tgl <= '$tgl2',jumlah,0)) as ttl_gapok, SUM(IF(tgl < '$tgl1',jumlah,0)) as ttl_gapok_lalu, dt_saldo.jml_pengeluaran as jml_pengeluaran, dt_saldo.jml_pengeluaran_lalu as jml_pengeluaran_lalu, dt_saldo.jml_saldo as jml_saldo")
            ->leftJoin(
                DB::raw("(SELECT akun_id, SUM(IF(tgl >= '$tgl1' AND tgl <= '$tgl2' AND jenis_saldo = 2,jumlah,0)) as jml_pengeluaran, SUM(IF(tgl < '$tgl1' AND jenis_saldo = 2,jumlah,0)) as jml_pengeluaran_lalu, SUM(IF(jenis_saldo = 1,jumlah,0)) as jml_saldo FROM saldo_kas WHERE tgl >= '2026-06-01' AND void = 0 AND jenis = 3 GROUP BY akun_id) dt_saldo"),
                'gapok.karyawan_id',
                '=',
                'dt_saldo.akun_id'
            )
            ->where('tgl', '>=', '2026-06-01')->where('tgl', '<=', $tgl2)->groupBy('karyawan_id')->with('karyawan')->get();

        $investor = PengeluaranInvestor::select('investor_id')->selectRaw('SUM(jumlah) as ttl_investor')->groupBy('investor_id')->with('investor')->get();

        $data = [
            'title' => 'Laporan Keuangan',
            'tgl1' => $tgl1,
            'tgl2' => $tgl2,
            'penjualan' => $penjualan,
            'stok_bahan' => $stok_bahan,
            'stok_produk' => $stok_produk,
            'pengeluaran' => $pengeluaran,
            'saldo_bahan' => $saldo_bahan,
            'gapok' => $gapok,
            'investor' => $investor,
            'akun_oprasional' => AkunPengeluaran::where('void', 0)->get(),
            'pegawai' => Karyawan::where('aktif', 1)->get(),
            'bahan' => Bahan::where('aktif', 'Y')->get(),
            'saldo_kas' => SaldoKas::where('tgl', '>=', $tgl1)->where('tgl', '<=', $tgl2)->where('void', 0)->with(['produk', 'bahan', 'akun', 'investor', 'karyawan'])->get(),
        ];
        return view('jurnal.index', $data);
    }

    public function perbaikanStok()
    {
        $penjualan = PenjualanKasir::where('void', 0)->where('tgl', '>=', '2026-06-01')->get();
        $resep = Resep::all();

        foreach ($penjualan as $d) {
            $dt_resep = $resep->where('id', $d->resep_id)->first();
            if ($dt_resep->takaran1 && $dt_resep->takaran2 && $dt_resep->takaran3 && $dt_resep->takaran4 && $dt_resep->ukuran) {
                $qty_alkohol = $dt_resep->takaran2 * $dt_resep->ukuran / 100;
                $qty_produk = $dt_resep->takaran1 * $dt_resep->ukuran / 100;
                $qty_fixactiv = $dt_resep->takaran3 * $dt_resep->ukuran / 100;
                $qty_metanol = $dt_resep->takaran4 * $dt_resep->ukuran / 100;
            } else {
                $qty_alkohol = 0;
                $qty_produk = 0;
                $qty_fixactiv = 0;
                $qty_metanol = 0;
            }


            if ($d->produk_id !== 0) {
                Stok::where('penjualan_id', $d->id)->delete();
                Stok::create([
                    'invoice_id' => $d->invoice_id,
                    'penjualan_id' => $d->id,
                    'produk_id' => $d->produk_id,
                    'cabang_id' => 1,
                    'qty' => $qty_produk,
                    'harga' => 600 * $qty_produk,
                    'tgl' => $d->tgl,
                    'admin' => $d->admin,
                    'jenis' => 2,
                    'jenis_bahan' => 1,
                    'void' => 0
                ]);
            } else {
                $stok = Stok::where('penjualan_id', $d->id)->where('produk_id', '!=', 0)->get();
                Stok::where('penjualan_id', $d->id)->delete();

                $panjang_mix = $stok->count();
                if ($qty_produk > 0 && $panjang_mix > 0) {
                    $qty_mix = $qty_produk / $panjang_mix;

                    foreach ($stok as $pmix) {
                        Stok::create([
                            'invoice_id' => $d->invoice_id,
                            'penjualan_id' => $d->id,
                            'produk_id' => $pmix['produk_id'],
                            'cabang_id' => 1,
                            'qty' => $qty_mix,
                            'harga' => 600 * $qty_mix,
                            'tgl' => $d->tgl,
                            'admin' => $d->admin,
                            'jenis' => 2,
                            'jenis_bahan' => 1,
                            'void' => 0
                        ]);
                    }
                }
            }


            //absolut
            Stok::create([
                'invoice_id' => $d->invoice_id,
                'penjualan_id' => $d->id,
                'produk_id' => 1,
                'cabang_id' => 1,
                'qty' => $qty_alkohol,
                'harga' => 25 * $qty_alkohol,
                'tgl' => $d->tgl,
                'admin' => $d->admin,
                'jenis' => 2,
                'jenis_bahan' => 2,
                'void' => 0
            ]);

            //Fixactiv
            Stok::create([
                'invoice_id' => $d->invoice_id,
                'penjualan_id' => $d->id,
                'produk_id' => 2,
                'cabang_id' => 1,
                'qty' => $qty_fixactiv,
                'harga' => 70 * $qty_fixactiv,
                'tgl' => $d->tgl,
                'admin' => $d->admin,
                'jenis_bahan' => 2,
                'jenis' => 2,
                'void' => 0
            ]);

            //metanol
            Stok::create([
                'invoice_id' => $d->invoice_id,
                'penjualan_id' => $d->id,
                'produk_id' => 3,
                'cabang_id' => 1,
                'qty' => $qty_metanol,
                'harga' => 25 * $qty_metanol,
                'tgl' => $d->tgl,
                'admin' => $d->admin,
                'jenis' => 2,
                'jenis_bahan' => 2,
                'void' => 0
            ]);


            //botol
            Stok::create([
                'invoice_id' => $d->invoice_id,
                'penjualan_id' => $d->id,
                'produk_id' => 4,
                'cabang_id' => 1,
                'qty' => 1,
                'harga' => $dt_resep->takaran5,
                'tgl' => $d->tgl,
                'admin' => $d->admin,
                'jenis' => 2,
                'jenis_bahan' => 2,
                'void' => 0
            ]);

            //Packaging
            Stok::create([
                'invoice_id' => $d->invoice_id,
                'penjualan_id' => $d->id,
                'produk_id' => 5,
                'cabang_id' => 1,
                'qty' => 1,
                'harga' => 1000,
                'tgl' => $d->tgl,
                'admin' => $d->admin,
                'jenis' => 2,
                'jenis_bahan' => 2,
                'void' => 0
            ]);
        }

        return 'ya';
    }

    public function inputGapok()
    {
        $dt_karyawan = Karyawan::where('gapok', '!=', 0)->where('aktif', 1)->get();

        for ($i = 1; $i <= 18; $i++) {
            foreach ($dt_karyawan as $d) {
                $gapok = $d->gapok / 30;
                Gapok::create([
                    'karyawan_id' => $d->id,
                    'jumlah' => $gapok,
                    'cabang_id' => 1,
                    'tgl' => "2026-06-" . $i,
                ]);
            }
        }

        return 'ya';
    }

    public function inputPengeluaranPokok()
    {
        $dt_akun = AkunPengeluaran::where('jumlah', '!=', 0)->where('void', 0)->get();

        for ($i = 1; $i <= 18; $i++) {
            foreach ($dt_akun as $d) {
                $jumlah = $d->jumlah / 30;
                Pengeluaran::create([
                    'cabang_id' => 1,
                    'akun_id' => $d->id,
                    'jenis' => 2,
                    'jumlah' => $jumlah,
                    'ket' => 'Pengeluaran Harian',
                    'tgl' => "2026-06-" . $i,
                    'user_id' => 1,
                    'void' => 0
                ]);
            }
        }

        return 'ya';
    }

    public function inputPokok()
    {
        $tgl = date('Y-m-d');
        $dt_karyawan = Karyawan::where('gapok', '!=', 0)->where('aktif', 1)->get();
        $dt_akun = AkunPengeluaran::where('jumlah', '!=', 0)->where('void', 0)->get();

        if (date('d') != '31' && date('m-d') != '02-29') {
            if (date('m-d') == '02-28') {

                foreach ($dt_karyawan as $d) {
                    $gapok = $d->gapok / 30;
                    Gapok::create([
                        'karyawan_id' => $d->id,
                        'jumlah' => $gapok,
                        'cabang_id' => 1,
                        'tgl' => $tgl,
                    ]);

                    Gapok::create([
                        'karyawan_id' => $d->id,
                        'jumlah' => $gapok,
                        'cabang_id' => 1,
                        'tgl' => $tgl,
                    ]);

                    Gapok::create([
                        'karyawan_id' => $d->id,
                        'jumlah' => $gapok,
                        'cabang_id' => 1,
                        'tgl' => $tgl,
                    ]);
                }

                foreach ($dt_akun as $d) {
                    $jumlah = $d->jumlah / 30;
                    Pengeluaran::create([
                        'cabang_id' => 1,
                        'akun_id' => $d->id,
                        'jenis' => 2,
                        'jumlah' => $jumlah,
                        'ket' => 'Pengeluaran Harian',
                        'tgl' => $tgl,
                        'user_id' => 1,
                        'void' => 0,
                        'jenis_pengeluaran' => 1,
                    ]);

                    Pengeluaran::create([
                        'cabang_id' => 1,
                        'akun_id' => $d->id,
                        'jenis' => 2,
                        'jumlah' => $jumlah,
                        'ket' => 'Pengeluaran Harian',
                        'tgl' => $tgl,
                        'user_id' => 1,
                        'void' => 0,
                        'jenis_pengeluaran' => 1,
                    ]);

                    Pengeluaran::create([
                        'cabang_id' => 1,
                        'akun_id' => $d->id,
                        'jenis' => 2,
                        'jumlah' => $jumlah,
                        'ket' => 'Pengeluaran Harian',
                        'tgl' => $tgl,
                        'user_id' => 1,
                        'void' => 0,
                        'jenis_pengeluaran' => 1,
                    ]);
                }
            } else {

                foreach ($dt_karyawan as $d) {
                    $gapok = $d->gapok / 30;
                    Gapok::create([
                        'karyawan_id' => $d->id,
                        'jumlah' => $gapok,
                        'cabang_id' => 1,
                        'tgl' => $tgl,
                    ]);
                }

                foreach ($dt_akun as $d) {
                    $jumlah = $d->jumlah / 30;
                    Pengeluaran::create([
                        'cabang_id' => 1,
                        'akun_id' => $d->id,
                        'jenis' => 2,
                        'jumlah' => $jumlah,
                        'ket' => 'Pengeluaran Harian',
                        'tgl' => $tgl,
                        'user_id' => 1,
                        'void' => 0,
                        'jenis_pengeluaran' => 1,
                    ]);
                }
            }
        }

        return true;
    }

    public function addSaldoKas(Request $request)
    {
        SaldoKas::create([
            'cabang_id' => 1,
            'akun_id' => $request->akun_id,
            'jenis' => $request->jenis,
            'jenis_saldo' => $request->jenis_saldo,
            'jumlah' => $request->jumlah,
            'ket' => $request->ket,
            'tgl' => $request->tgl,
            'void' => 0
        ]);

        return redirect()->back()->with('success', 'Data berhasil dibuat');
    }

    public function deleteSaldoKas($id)
    {
        SaldoKas::where('id', $id)->update(['void' => 1]);
        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}
