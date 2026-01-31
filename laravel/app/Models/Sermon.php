<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Model;

class Sermon extends Model
{
    use HasSlug;

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
        'audio_url',
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
