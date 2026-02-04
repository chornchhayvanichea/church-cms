<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Announcement extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'content',
        'start_date',
        'end_date',
        'priority',
        'status',
        'created_by',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class);
    }
}
