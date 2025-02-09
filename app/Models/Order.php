<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'jumlah',
        'total_harga',
        'status',
        'payment_name',
        'payment_number'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'id_order');
    }
}
