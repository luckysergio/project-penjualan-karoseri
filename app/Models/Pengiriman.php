<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengiriman extends Model
{
    protected $table = 'pengirimans';
    protected $guarded = [];

    public function order()
    {
        return $this->belongsTo(Order::class, 'id_order');
    }

    public function sales()
    {
        return $this->hasOneThrough(
            Karyawan::class,
            Order::class,
            'id',           // foreign key di Order (id_order)
            'id',           // primary key di Karyawan
            'id_order',     // foreign key di Pengiriman
            'id_sales'      // foreign key di Order
        );
    }
}
