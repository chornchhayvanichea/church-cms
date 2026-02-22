<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Blog extends Model
{
    use HasSlug, SoftDeletes;

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

    // Table blogs {
    //  id bigint [pk, increment]
    //  title varchar [not null]
    //  slug varchar [unique, not null]
    //  content longtext [not null, note: 'HTML content']
    //  excerpt text
    //  thumbnail varchar
    //  status varchar [default: 'draft', note: 'draft, published, archived']
    //  author_id bigint [not null]
    //  published_at timestamp
    //  created_at timestamp
    //  updated_at timestamp
    // }

}
