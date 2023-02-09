<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NMR extends Model
{
    use HasFactory;

    protected $table = 'nmrs';

    protected $guarded = [
        'id',
    ];
}
