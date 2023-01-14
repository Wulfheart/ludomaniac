<?php

namespace Domain\Core\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BanLog extends Model
{
    //use HasFactory;

    protected $guarded = [
        'id',
    ];
}
