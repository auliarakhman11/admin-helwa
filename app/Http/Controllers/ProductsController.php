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
            'produk' => Produk::orderBy('possition', 'ASC')->with(['produkCabang'])->where('hapus', 0)->get(),
            'bahan' => Bahan::orderBy('possition', 'ASC')->where('aktif', 'Y')->where('jenis', 1)->get(),
            'cabang' => Cabang::where('off', 0)->get(),
            'gender' => Gender::all(),
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
                'kategori_id' => $request->kategori_id,
                'brand' => $request->brand,
                'ganti_nama' => $request->ganti_nama,
                'inspired_by' => $request->inspired_by,
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
                    'kategori_id' => $request->kategori_id,
                    'brand' => $request->brand,
                    'ganti_nama' => $request->ganti_nama,
                    'inspired_by' => $request->inspired_by,
                    'foto' => $foto
                ];
            } else {
                $data = [
                    'nm_produk' => $request->nm_produk,
                    'gender_id' => $request->gender_id,
                    'kategori_id' => $request->kategori_id,
                    'brand' => $request->brand,
                    'ganti_nama' => $request->ganti_nama,
                    'inspired_by' => $request->inspired_by,
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

            return redirect(route('products'))->with('success', 'Data berhasil diupdate');
        } else {
            return redirect(route('products'))->with('error', 'Masukan data outlet terlebih dahulu');
        }
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
}
