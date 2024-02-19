<?php

namespace MohSlimani\Media\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use MohSlimani\Media\Models\Media;
use Spatie\MediaLibrary\HasMedia;

class MediaCollectionCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): array
    {
        /** @var HasMedia $model */
        $files = [];

        /** @var Media $media */
        $model->getMedia($key)->each(function (Media $media) use (&$files) {
            $files[] = $media->getCastObject();
        });

        return $files;
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return $value;
    }
}
