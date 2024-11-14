<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPortfolio extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'mobile',
        'views',
        'video_path1',
        'image_path1',
        'video_path2',
        'image_path2',
        'video_path3',
        'image_path3',
        'video_path4',
        'image_path4',
        'video_path5',
        'image_path5',
        'video_path6',
        'image_path6',
    ];
}

