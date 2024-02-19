<?php

namespace MohSlimani\Media\Traits;

use MohSlimani\Media\Casts\MediaCast;
use MohSlimani\Media\Casts\MediaCollectionCast;
use MohSlimani\Media\Media;
use Spatie\MediaLibrary\InteractsWithMedia;

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
                if ($value === Media::SINGLE_FILE) {
                    $this->addMediaCollection($key)->singleFile();
                } else {
                    $this->addMediaCollection($key);
                }
            }
        }
    }
}
