<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gapok extends Model
{
    use HasFactory;

    protected $table = 'gapok';
    protected $fillable = ['karyawan_id', 'cabang_id', 'jumlah', 'tgl'];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id', 'id');
    }
}
