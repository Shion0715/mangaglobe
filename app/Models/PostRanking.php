<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostRanking extends Model
{
    use HasFactory;

    protected $primaryKey = 'rank';
    public $incrementing  = false;
    protected $fillable   = [
        'rank',
        'page_view_count',
    ];
}
