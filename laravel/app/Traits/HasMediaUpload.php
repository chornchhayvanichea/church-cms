<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait HasMediaUpload
{
    public function handleMediaUpload(Request $request, string $field, string $collection): void
    {

        if ($request->hasFile($field)) {

            $this->addMediaFromRequest($field)->toMediaCollection($collection);

        } elseif ($request->{$field.'_url'}) {
            $this->{$field} = $request->{$field.'_url'};
            $this->save();

        }

    }
}
