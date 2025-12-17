<?php

namespace App\Http\Controllers;

use App\Models\Cluster;
use App\Models\Resep;
use App\Models\Ukuran;
use Illuminate\Http\Request;

class ClusterController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Cluster',
            'cluster' => Cluster::where('void', 0)->with('resep')->get(),
            'ukuran' => Ukuran::where('void',0)->get(),
        ];
        return view('cluster.index', $data);
    }

    public function addCluster(Request $request)
    {

        $cek = Cluster::where('nm_cluster', $request->nm_cluster)->where('void', 0)->first();

        if ($cek) {
            return redirect()->back()->with('error', 'Cluster sudah ada');
        } else {
            $data = [
                'nm_cluster' => $request->nm_cluster,
                'takaran1' => $request->takaran1,
                'takaran2' => $request->takaran2,
            ];
            $cluster = Cluster::create($data);

            $ukuran = $request->ukuran;
            $harga = $request->harga;

            if ($ukuran) {
                for ($count = 0; $count < count($ukuran); $count++) {
                    Resep::create([
                        'takaran1' => $request->takaran1,
                        'takaran2' => $request->takaran2,
                        'cluster_id' => $cluster->id,
                        'ukuran' => $ukuran[$count],
                        'harga' => $harga[$count] ? $harga[$count] : 0,
                    ]);
                }
            }

            return redirect()->back()->with('success', 'Data berhasil dibuat');
        }
    }

    public function editCluster(Request $request)
    {
        $cek = Cluster::where('id', '!=', $request->id)->where('nm_cluster', $request->nm_cluster)->where('void', 0)->first();
        if ($cek) {
            return redirect()->back()->with('error', 'Cluster sudah ada');
        } else {
            $data = [
                'nm_cluster' => $request->nm_cluster,
                'takaran1' => $request->takaran1,
                'takaran2' => $request->takaran2,
            ];
            Cluster::where('id', $request->id)->update($data);

            Resep::where('cluster_id', $request->id)->update([
                'takaran1' => $request->takaran1,
                'takaran2' => $request->takaran2,
            ]);

            $resep_id = $request->resep_id;
            $harga = $request->harga;

            if ($resep_id) {
                for ($count = 0; $count < count($resep_id); $count++) {
                    Resep::where('id',$resep_id[$count])->update([
                        'takaran1' => $request->takaran1,
                        'takaran2' => $request->takaran2,
                        'harga' => $harga[$count] ? $harga[$count] : 0,
                    ]);
                }
            }

            $ukuran_add = $request->ukuran_add;
            $harga_add = $request->harga_add;

            if ($ukuran_add) {
                for ($count = 0; $count < count($ukuran_add); $count++) {
                    Resep::create([
                        'takaran1' => $request->takaran1,
                        'takaran2' => $request->takaran2,
                        'cluster_id' => $request->id,
                        'ukuran' => $ukuran_add[$count],
                        'harga' => $harga_add[$count] ? $harga_add[$count] : 0,
                    ]);
                }
            }


            return redirect()->back()->with('success', 'Data berhasil diubah');
        }
    }

    public function deleteCluster($id)
    {
        $data = [
            'void' => 1
        ];

        Cluster::where('id', $id)->update($data);

        Resep::where('cluster_id', $id)->update($data);

        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}
