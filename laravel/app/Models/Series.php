<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Series extends Model
{
    use HasSlug;

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()->generateSlugsFrom('name')->saveSlugsTo('slug');
    }

    protected $fillable = [
        'name', 'slug', 'description', 'thumbnail', 'start_date', 'end_date',
    ];

    public function sermons()
    {
        return $this->hasMany(Sermon::class);
    }
}
