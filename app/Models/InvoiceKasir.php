<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceKasir extends Model
{
    use HasFactory;

    protected $table = 'invoice_kasir';
    protected $fillable = ['no_invoice', 'nm_customer', 'total', 'pembulatan', 'dibayar', 'diskon', 'no_tlp', 'void', 'ket_void', 'admin', 'user_void', 'tgl', 'pembayaran_id', 'cabang_id', 'print', 'online'];

    public function penjualan()
    {
        return $this->hasMany(PenjualanKasir::class, 'invoice_id', 'id');
    }

    public function penjualanKaryawan()
    {
        return $this->hasMany(PenjualanKarywan::class, 'invoice_id', 'id');
    }

    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'cabang_id', 'id');
    }

    public function pembayaran()
    {
        return $this->belongsTo(Pembayaran::class, 'pembayaran_id', 'id');
    }
}
