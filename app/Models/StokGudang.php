<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokGudang extends Model
{
    use HasFactory;

    protected $table = 'stok_gudang';
    protected $fillable = ['no_invoice', 'kd_gabungan', 'produk_id', 'cabang_id', 'qty', 'harga', 'harga_normal', 'tgl', 'admin', 'jenis', 'jenis_bahan', 'void'];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id', 'id');
    }

    public function bahan()
    {
        return $this->belongsTo(Bahan::class, 'produk_id', 'id');
    }

    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'cabang_id', 'id');
    }
}
