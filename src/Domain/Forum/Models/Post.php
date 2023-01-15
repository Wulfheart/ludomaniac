<?php

namespace Domain\Forum\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function thread(): BelongsTo
    {
        return $this->belongsTo(Thread::class);
    }
}
