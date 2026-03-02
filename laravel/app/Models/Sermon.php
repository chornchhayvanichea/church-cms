<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Sermon extends Model
{
    use HasSlug,SoftDeletes;

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()->generateSlugsFrom('title')->saveSlugsTo('slug');
    }

    protected $fillable = [
        'title',
        'slug',
        'speaker',
        'sermon_date',
        'description',
        'note',
        'scripture_reference',
        'video_url',
        'pdf_url',
        'thumbnail',
        'status',
        'view_count',
        'created_by',
        'series_id',
        'published_at',
    ];

    public function series()
    {
        return $this->belongsTo(Series::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'sermon_category');
    }
}
