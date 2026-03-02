<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payement extends Model
{
    use HasFactory;
     protected $fillable = [
        'command_id',
        'payement_method_id'
    ];
     public function command(): BelongsTo
    {
        return $this->belongsTo(Command::class);
    }

    public function payementMethod(): BelongsTo
    {
        return $this->belongsTo(PayementMethod::class);
    }

}
