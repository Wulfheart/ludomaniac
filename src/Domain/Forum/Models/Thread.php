<?php

namespace Domain\Forum\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Thread extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
