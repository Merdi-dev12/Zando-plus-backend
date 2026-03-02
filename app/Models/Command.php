<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Command extends Model
{
    use HasFactory;
     protected $fillable = [
        'address',
        'cart_id'
    ];
     public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    public function payement(): HasOne
    {
        return $this->hasOne(Payement::class);
    }

}
