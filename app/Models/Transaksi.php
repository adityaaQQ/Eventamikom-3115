<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transactions';

    protected $fillable = [
        'user_id',
        'event_id',
        'quantity',
        'total_price',
        'status',
        'pembeli',
        'email',
        'telepon',
        'order_id',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}