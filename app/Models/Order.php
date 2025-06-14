<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $guarded = [];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pemesan');
    }

    public function sales()
    {
        return $this->belongsTo(Karyawan::class, 'id_sales');
    }

    public function detailOrders()
    {
        return $this->hasMany(DetailOrder::class, 'id_order');
    }

    public function pengiriman()
    {
        return $this->hasOne(Pengiriman::class, 'id_order', 'id');
    }

    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class, 'id_order', 'id');
    }
}
