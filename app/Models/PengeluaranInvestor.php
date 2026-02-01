<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengeluaranInvestor extends Model
{
    use HasFactory;
    protected $table = 'pengeluaran_investor';
    protected $fillable = ['kd_gabungan','investor_id', 'cabang_id','jumlah','ket','tgl','void','user_id'];

    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'cabang_id', 'id');
    }

    public function investor()
    {
        return $this->belongsTo(Investor::class, 'investor_id', 'id');
    }

}
