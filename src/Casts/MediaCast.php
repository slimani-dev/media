<?php

namespace MohSlimani\Media\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use MohSlimani\Media\Models\Media;
use MohSlimani\Media\Traits\UseMediaModel;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

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
     * @param  mixed|UploadedFile|Media  $value
     * @param  array<string, mixed>  $attributes
     *
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     *
     * @uses HasMedia|UseMediaModel
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): ?Media
    {
        if ($value::class == Media::class) {
            return $value;
        }

        if (method_exists($model, 'clearMediaCollection')) {
            $model->clearMediaCollection($key);
        }

        if (method_exists($model, 'addMediaFiles')) {
            $model->addMediaFiles($value, $key);
        }

        return $model[$key];
    }
}
