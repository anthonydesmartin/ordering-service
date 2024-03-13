<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MenuOrder extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['menu_id', 'order_id', 'quantity'];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
