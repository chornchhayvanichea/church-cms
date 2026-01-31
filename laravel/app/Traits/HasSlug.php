<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasSlug
{
    protected static function bootHasSlug()
    {
        static::created(function ($model) {
            $model->slug = $model->id.'-'.Str::slug($model->title);
            $model->saveQuietly();
        });
    }
}
