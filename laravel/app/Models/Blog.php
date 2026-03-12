<?php

namespace App\Models;

use App\Traits\HasMediaUpload as TraitsHasMediaUpload;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Blog extends Model implements HasMedia
{
    use HasSlug, InteractsWithMedia, SoftDeletes, TraitsHasMediaUpload;

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('preview')->fit(Fit::Contain, 300, 300)->nonQueued();
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()->generateSlugsFrom('title')->saveSlugsTo('slug');
    }

    protected $fillable = [
        'title', 'slug', 'content', 'excerpt', 'thumbnail', 'status', 'author_id', 'published_at',
    ];

    public function author()
    {
        return $this->belongsTo(User::class);
    }
}
