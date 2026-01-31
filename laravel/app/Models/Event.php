<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'event_date',
        'event_time',
        'location',
        'image',
        'registration_link',
        'status',
        'created_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
