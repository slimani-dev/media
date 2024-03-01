<?php

namespace MohSlimani\Media\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use MohSlimani\Media\Models\Media;
use Spatie\MediaLibrary\HasMedia;

class MediaCollectionCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     * @return Media[]
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): array
    {

        $files = [];

        /** @var HasMedia $model */
        if (method_exists($model, 'getMedia')) {
            $model->getMedia($key)->each(function (Media $media) use (&$files) {
                $files[] = $media;
            });
        }

        return $files;
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array|UploadedFile[]|Media[]  $value
     * @param  array<string, mixed>  $attributes
     * @return Media[]
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): array
    {

        if (! is_array($value) or empty($value) or $value[0]::class === Media::class) {
            return $value;
        }

        if (method_exists($model, 'clearMediaCollection')) {
            $model->clearMediaCollection($key);
        }

        if (method_exists($model, 'addMediaFiles')) {
            foreach ($value as $file) {
                $model->addMediaFiles($file, $key);
            }
        }

        return $model[$key];
    }
}
