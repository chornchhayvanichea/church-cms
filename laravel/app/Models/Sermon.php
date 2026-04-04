<?php

namespace App\Models;

use App\Traits\HasMediaUpload;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Sermon extends Model implements HasMedia
{
    use HasMediaUpload,HasSlug,InteractsWithMedia,SoftDeletes;

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('preview')->fit(Fit::Contain, 300, 300)->nonQueued();
    }

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
        'video',
        'audio',
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
        return $this->belongsTo(User::class, 'created_by');
    }
}
