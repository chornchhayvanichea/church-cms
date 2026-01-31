<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Series extends Model
{
    use HasSlug,SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'description', 'thumbnail', 'start_date', 'end_date',
    ];

    public function sermons()
    {
        return $this->hasMany(Sermon::class);
    }
}
