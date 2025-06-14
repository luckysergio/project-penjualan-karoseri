<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailOrder extends Model
{
    use HasFactory;

    protected $table = 'detail_orders';

    protected $guarded = [];

    public function order()
    {
        return $this->belongsTo(Order::class, 'id_order');
    }

    public function typeDump()
    {
        return $this->belongsTo(TypeDump::class, 'id_type');
    }

    public function jenisDump()
    {
        return $this->belongsTo(JenisDump::class, 'id_jenis');
    }

    public function chassis()
    {
        return $this->belongsTo(Chassis::class, 'id_chassis');
    }
}
