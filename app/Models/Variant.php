<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Variant extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function powers(): HasMany
    {
        return $this->hasMany(Power::class);
    }
}
