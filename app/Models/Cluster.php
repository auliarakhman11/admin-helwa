<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cluster extends Model
{
    use HasFactory;
    protected $table = 'cluster';
    protected $fillable = ['nm_cluster', 'takaran1', 'takaran2', 'void'];

    public function resep()
    {
        return $this->hasMany(Resep::class, 'cluster_id', 'id');
    }

}
