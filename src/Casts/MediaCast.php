<?php

namespace MohSlimani\Media\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use MohSlimani\Media\Models\Media;
use Spatie\MediaLibrary\HasMedia;

class MediaCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): ?Media
    {
        /** @var HasMedia $model */
        /** @var Media $media */
        $media = $model->getMedia($key)->last();

        return $media;
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     *
     * @uses HasMedia|UseMediaModel
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): ?Media
    {
        return $value;
    }
}
