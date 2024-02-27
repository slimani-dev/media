<?php

namespace MohSlimani\Media\Traits;

use Illuminate\Http\UploadedFile;
use MohSlimani\Media\Casts\MediaCast;
use MohSlimani\Media\Casts\MediaCollectionCast;
use MohSlimani\Media\Media;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Spatie\MediaLibrary\MediaCollections\Exceptions\MediaCannotBeDeleted;
use Spatie\MediaLibrary\MediaCollections\Models\Media as OriginalMedia;

/**
 * @property array $casts
 * @property array $hidden
 * @property array $appends
 * @property array $files
 */
trait UseMediaModel
{
    use InteractsWithMedia;

    /**
     * This method is called upon instantiation of the Eloquent Model.
     * It adds fields to the "$casts" and "$appends" arrays. of the model.
     */
    public function initializeUseMediaModel(): void
    {
        if (isset($this->files)) {
            foreach ($this->files as $key => $value) {
                if (is_int($key)) {
                    $this->casts[$value] = MediaCast::class;
                    $this->appends[] = $value;
                } else {
                    $this->casts[$key] = $value === Media::SINGLE_FILE ? MediaCast::class : MediaCollectionCast::class;
                    $this->appends[] = $key;
                }
            }

            /**
             * hiding the media to prevent error
             */
            $this->hidden[] = 'media';
        }
    }

    public function registerMediaCollections(): void
    {
        if (isset($this->files)) {
            foreach ($this->files as $key => $value) {
                if (is_int($key)) {
                    $this->addMediaCollection($value)->singleFile();
                } elseif ($value === Media::SINGLE_FILE) {
                    $this->addMediaCollection($key)->singleFile();
                } else {
                    $this->addMediaCollection($key);
                }
            }
        }
    }

    /**
     * add the media files
     *
     * @throws FileDoesNotExist|FileIsTooBig|MediaCannotBeDeleted
     */
    public function addMediaFiles(UploadedFile $file, string $collection, bool $keep = false): OriginalMedia
    {
        if (! $keep) {
            $this->getMedia($collection)->each(fn (OriginalMedia $media) => $this->deleteMedia($media));
        }

        $fileName = $file->getClientOriginalName();

        $milliseconds = floor(microtime(true) * 1000);
        $code = str(base_convert(strval($milliseconds), 10, 36))->upper()->value();

        return $this->addMedia($file)->usingFileName($code.'-'.$fileName)->toMediaCollection($collection);
    }
}
