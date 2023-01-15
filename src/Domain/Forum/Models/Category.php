<?php

namespace Domain\Forum\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function threads(): HasMany
    {
        return $this->hasMany(Thread::class);
    }
}
