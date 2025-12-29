<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diskon extends Model
{
    use HasFactory;

    protected $table = 'diskon';
    protected $fillable = ['nm_diskon', 'jml_diskon', 'maksimal', 'exp_date', 'void'];
}
