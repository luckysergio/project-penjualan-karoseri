<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisDump extends Model
{
    use HasFactory;

    protected $table = 'jenis_dumps';

    protected $guarded = [];

    public function detailOrders()
    {
        return $this->hasMany(DetailOrder::class, 'id_jenis');
    }
}
