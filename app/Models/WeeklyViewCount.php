<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeeklyViewCount extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_path',
        'view_count',
        'start_date',
        'end_date',
        'post_id'
    ];
}
