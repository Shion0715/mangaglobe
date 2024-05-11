<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TotalViewCount extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_path',
        'view_count',
    ];
}
