<?php

namespace MohSlimani\Media\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use MohSlimani\Media\Models\Media;
use MohSlimani\Media\Traits\UseMediaModel;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use function PHPUnit\Framework\isEmpty;

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
        /** @var HasMedia $model */
        $files = [];

        /** @var Media $media */
        $model->getMedia($key)->each(function (Media $media) use (&$files) {
            $files[] = $media;
        });

        return $files;
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  mixed[]|UploadedFile[]|Media[]  $value
     * @param  array<string, mixed>  $attributes
     * @return Media[]
     *
     * @throws FileDoesNotExist|FileIsTooBig
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): array
    {

        if (! is_array($value) or isEmpty($value) or $value[0]::class === Media::class) {
            return $value;
        }

        /** @var UseMediaModel $model */
        $model->clearMediaCollection($key);
        $keep = false;

        /** @var \Illuminate\Http\UploadedFile[] $value */
        foreach ($value as $file) {
            $model->addMediaFiles($file, $key, $keep);
            $keep = true;
        }

        return $model[$key];
    }
}
