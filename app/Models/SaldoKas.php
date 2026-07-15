<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaldoKas extends Model
{
    use HasFactory;

    protected $table = 'saldo_kas';
    protected $fillable = ['cabang_id', 'akun_id', 'jenis', 'jenis_saldo', 'jumlah', 'ket', 'tgl', 'void'];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'akun_id', 'id');
    }

    public function bahan()
    {
        return $this->belongsTo(Bahan::class, 'akun_id', 'id');
    }

    public function akun()
    {
        return $this->belongsTo(AkunPengeluaran::class, 'akun_id', 'id');
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'akun_id', 'id');
    }

    public function investor()
    {
        return $this->belongsTo(Investor::class, 'akun_id', 'id');
    }

    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'cabang_id', 'id');
    }
}
