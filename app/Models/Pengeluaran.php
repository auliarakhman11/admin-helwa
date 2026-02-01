<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    use HasFactory;
    protected $table = 'pengeluaran';
    protected $fillable = ['kd_gabungan', 'cabang_id', 'akun_id', 'jenis', 'investor_id', 'jumlah', 'ket', 'tgl', 'user_id', 'void'];

    public function akun()
    {
        return $this->belongsTo(AkunPengeluaran::class, 'akun_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'cabang_id', 'id');
    }

    public function investor()
    {
        return $this->belongsTo(Investor::class, 'investor_id', 'id');
    }
}
