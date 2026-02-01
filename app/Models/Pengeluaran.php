<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    use HasFactory;
    protected $table = 'pengeluaran';
    protected $fillable = ['kd_gabungan','akun_id','jenis','jumlah','ket','tgl','user_id','void'];

}
