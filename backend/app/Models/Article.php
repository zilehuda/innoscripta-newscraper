<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'url',
        'description',
        'author',
        'source',
        'image',
        'category',
        'published_at',
    ];

    protected $casts = [
    'published_at' => 'datetime'
    ];
    public function getImageAttribute($value)
    {
        if (empty($value)) {
            return 'https://img.freepik.com/free-photo/top-view-old-french-newspaper-pieces_23-2149318857.jpg';
        }

        return $value;
    }
}
