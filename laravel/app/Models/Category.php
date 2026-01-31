<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name', 'slug', 'type',
    ];

    public function sermons()
    {
        return $this->belongsToMany(Sermon::class, 'sermon_category');
    }
}
