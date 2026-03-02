<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PayementMethod extends Model
{
    use HasFactory;
    protected $fillable = [

        'description'
    ];
    public function payements(): HasMany
    {
        return $this->hasMany(Payement::class);
    }


}
