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
use Spatie\MediaLibrary\MediaCollections\Exceptions\MediaCannotBeDeleted;

class MediaCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param Model $model
     * @param string $key
     * @param mixed $value
     * @param array<string, mixed> $attributes
     * @return Media
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): Media
    {
        /** @var HasMedia $model */
        /** @var Media $media */
        $media = $model->getMedia($key)->last();

        return $media;
    }

    /**
     * Prepare the given value for storage.
     *
     * @param Model $model
     * @param string $key
     * @param mixed|UploadedFile $value
     * @param array<string, mixed> $attributes
     * @return Media
     *
     * @throws FileDoesNotExist|FileIsTooBig
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): Media
    {
        /** @var UseMediaModel $model */

        $model->clearMediaCollection($key);
        $model->addMediaFiles($value, $key);

        return $model[$key];
    }
}
