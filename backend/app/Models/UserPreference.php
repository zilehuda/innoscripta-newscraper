<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPreference extends Model
{
    use HasFactory;

    protected $fillable = [
        'preferred_sources',
        'preferred_categories',
        'preferred_authors',
    ];

    protected $casts = [
        'preferred_sources' => 'array',
        'preferred_categories' => 'array',
        'preferred_authors' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sources()
    {
        return $this->preferred_sources ?? [];
    }

    public function categories()
    {
        return $this->preferred_categories ?? [];
    }

    public function authors()
    {
        return $this->preferred_authors ?? [];
    }
}
