<?php

namespace App\Http\Controllers;

use App\Models\Bahan;
use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Cabang;
use App\Models\Cluster;
use App\Models\Gender;
use App\Models\ProdukCabang;
use App\Models\Resep;
use App\Models\Ukuran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Products',
            'kategori' => Kategori::orderBy('possition', 'ASC')->get(),
            'produk' => Produk::orderBy('possition', 'ASC')->with(['produkCabang', 'resep'])->where('hapus', 0)->get(),
            'bahan' => Bahan::orderBy('possition', 'ASC')->where('aktif', 'Y')->where('jenis', 1)->get(),
            'cabang' => Cabang::where('off', 0)->get(),
            'gender' => Gender::all(),
            'ukuran' => Ukuran::where('void', 0)->get(),
            'cluster' => Cluster::where('void', 0)->get(),
        ];
        // $produk = Produk::with(['kategori','getHarga.delivery'])->get();
        // dd($produk[0]);
        return view('produk.index', $data);
        // $produk = Produk::with(['kategori','getHarga'])->first();

    }

    public function addProduct(Request $request)
    {
        if ($request->cabang_id) {
            // $request->validate([
            //     'foto' => 'image|mimes:jpg,png,jpeg'
            // ]);


            // if ($request->hasFile('foto')) {
            //     $request->file('foto')->move('img-produk/', $request->file('foto')->getClientOriginalName());
            //     $foto = 'img-produk/' . $request->file('foto')->getClientOriginalName();
            // } else {
            //     $foto = '';
            // }

            $foto = '';


            $data = [
                'nm_produk' => $request->nm_produk,
                'gender_id' => $request->gender_id,
                'brand' => $request->brand,
                'ganti_nama' => $request->ganti_nama,
                'foto' => $foto,
                'diskon ' => 0,
                'status' => 'ON',
                'possition' => 0,
                'hapus' => 0,
            ];
            $produk = Produk::create($data);

            $cabang_id = $request->cabang_id;
            ProdukCabang::where('produk_id', $produk->id)->delete();
            for ($count = 0; $count < count($cabang_id); $count++) {


                ProdukCabang::create([
                    'produk_id' => $produk->id,
                    'cabang_id' => $cabang_id[$count]
                ]);
            }

            $takaran1 = $request->takaran1;
            $takaran2 = $request->takaran2;
            $cluster_id = $request->cluster_id;
            $ukuran = $request->ukuran;
            $harga = $request->harga;

            for ($count = 0; $count < count($takaran1); $count++) {
                Resep::create([
                    'produk_id' => $produk->id,
                    'takaran1' => $takaran1[$count],
                    'takaran2' => $takaran2[$count],
                    'cluster_id' => $cluster_id[$count],
                    'ukuran' => $ukuran[$count],
                    'harga' => $harga[$count] ? $harga[$count] : 0,
                ]);
            }

            return redirect(route('products'))->with('success', 'Data berhasil dibuat');
        } else {
            return redirect(route('products'))->with('error', 'Masukan data cabang terlebih dahulu');
        }
    }

    public function editProduk(Request $request)
    {
        if ($request->cabang_id) {

            // $request->validate([
            //     'foto' => 'image|mimes:jpg,png,jpeg'
            // ]);
            if ($request->file('foto')) {
                $request->file('foto')->move('img-produk/', $request->file('foto')->getClientOriginalName());
                $foto = 'img-produk/' . $request->file('foto')->getClientOriginalName();
                $data = [
                    'nm_produk' => $request->nm_produk,
                    'gender_id' => $request->gender_id,
                    'brand' => $request->brand,
                    'ganti_nama' => $request->ganti_nama,
                    'foto' => $foto
                ];
            } else {
                $data = [
                    'nm_produk' => $request->nm_produk,
                    'gender_id' => $request->gender_id,
                    'brand' => $request->brand,
                    'ganti_nama' => $request->ganti_nama,
                ];
            }


            Produk::where('id', $request->id)->update($data);


            $cabang_id = $request->cabang_id;
            ProdukCabang::where('produk_id', $request->id)->delete();
            for ($count = 0; $count < count($cabang_id); $count++) {


                ProdukCabang::create([
                    'produk_id' => $request->id,
                    'cabang_id' => $cabang_id[$count]
                ]);
            }

            $takaran1 = $request->takaran1_add;
            $takaran2 = $request->takaran2_add;
            $cluster_id = $request->cluster_id_add;
            $ukuran = $request->ukuran_add;
            $harga = $request->harga_add;

            // if (!empty($takaran1)) {
            //     for ($count = 0; $count < count($takaran1); $count++) {
            //         Resep::create([
            //             'produk_id' => $produk->id,
            //             'takaran1' => $takaran1[$count],
            //             'takaran2' => $takaran2[$count],
            //             'cluster_id' => $cluster_id[$count],
            //             'ukuran' => $ukuran[$count],
            //             'harga' => $harga[$count] ? $harga[$count] : 0,
            //         ]);
            //     }
            // }

            $resep_id = $request->resep_id;
            $harga = $request->harga;

            if (!empty($resep_id)) {
                for ($count = 0; $count < count($resep_id); $count++) {
                    Resep::where('id', $resep_id[$count])->update([
                        'harga' => $harga[$count]
                    ]);
                }
            }

            return redirect(route('products'))->with('success', 'Data berhasil diupdate');
        } else {
            return redirect(route('products'))->with('error', 'Masukan data outlet terlebih dahulu');
        }
    }


    public function addResep(Request $request)
    {
        $produk_id = $request->produk_id;
        $bahan_id = $request->bahan_id;
        $takaran = $request->takaran;

        for ($count = 0; $count < count($bahan_id); $count++) {
            $cek = Resep::where('produk_id', $produk_id)->where('bahan_id', $bahan_id[$count])->first();
            if ($cek) {
                continue;
            }
            $data  = [
                'produk_id' => $produk_id,
                'bahan_id' => $bahan_id[$count],
                'takaran' => $takaran[$count]
            ];
            Resep::create($data);
        }

        return true;
    }

    public function dropResep(Request $request)
    {
        Resep::find($request->id)->delete();

        return true;
    }

    public function deleteProduk($id)
    {
        Produk::where('id', $id)->update([
            'hapus' => 1,
            'status' => 'OFF'
        ]);

        return redirect(route('products'))->with('success', 'Data berhasil dihapus');
    }

    public function tambahKategori(Request $request)
    {
        Kategori::create([
            'kategori' => $request->kategori,
            'possition' => 0,
        ]);

        return redirect(route('products'))->with('success_kategori', 'Data berhasil ditambah');
    }

    public function editKategori(Request $request)
    {
        Kategori::where('id', $request->id)->update([
            'kategori' => $request->kategori
        ]);

        return redirect(route('products'))->with('success_kategori', 'Data berhasil diubah');
    }

    public function getHargaResep($produk_id)
    {
        $resep = Resep::select('resep.*', 'bahan.bahan')->selectRaw("dt_harga.ttl_harga, dt_harga.ttl_qty")->where('produk_id', $produk_id)
            ->leftJoin(
                DB::raw("(SELECT bahan_id, SUM(qty) as ttl_qty, SUM(harga) as ttl_harga FROM stok where transaksi = 1 AND jenis = 2 AND void = 0 AND qty > 0 AND harga > 0 GROUP BY bahan_id) dt_harga"),
                'resep.bahan_id',
                '=',
                'dt_harga.bahan_id'
            )
            ->leftJoin('bahan', 'resep.bahan_id', '=', 'bahan.id')
            ->where('bahan.aktif', 'Y')
            ->groupBy('resep.bahan_id')
            ->get();
        return view('produk.getHargaResep', [
            'resep' => $resep,
            'produk_id' => $produk_id,
            'bahan' => Bahan::orderBy('possition', 'ASC')->where('aktif', 'Y')->where('jenis', 1)->get(),

        ])->render();
    }
}
