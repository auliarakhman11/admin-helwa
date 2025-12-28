<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanKasir extends Model
{
    use HasFactory;

    protected $table = 'penjualan_kasir';
    protected $fillable = ['invoice_id', 'produk_id', 'resep_id', 'cluster_id', 'ukuran', 'qty', 'harga', 'diskon', 'total', 'void', 'admin', 'cabang_id', 'tgl', 'catatan', 'mix', 'ket_mix', 'harga_normal', 'pembayaran_id', 'online'];

    public function getMenu()
    {
        return $this->belongsTo(Produk::class, 'produk_id', 'id');
    }

    public function penjualanVarian()
    {
        return $this->hasMany(PenjualanVarian::class, 'penjualan_id', 'id');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id', 'id');
    }

    public function cluster()
    {
        return $this->belongsTo(Cluster::class, 'cluster_id', 'id');
    }
}
