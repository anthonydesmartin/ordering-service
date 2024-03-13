<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class History extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['action', 'order_id'];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
