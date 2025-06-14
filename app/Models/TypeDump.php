<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeDump extends Model
{
    use HasFactory;

    protected $table = 'type_dumps';

    protected $guarded = [];

    public function detailOrders()
    {
        return $this->hasMany(DetailOrder::class, 'id_type');
    }
}
