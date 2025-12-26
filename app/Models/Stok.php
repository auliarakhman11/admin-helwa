<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    use HasFactory;

    protected $table = 'stok';
    protected $fillable = ['invoice_id', 'penjualan_id', 'produk_id', 'cabang_id', 'qty', 'harga', 'tgl', 'admin', 'jenis', 'void'];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id', 'id');
    }

    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'cabang_id', 'id');
    }
}
