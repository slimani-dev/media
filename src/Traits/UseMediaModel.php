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
 */
trait UseMediaModel
{
    use InteractsWithMedia;

    /**
     * This array should contain the list of media keys to be registered.
     *
     * @var array<string, int>
     *
     * @example ['photo' => Media::SINGLE_FILE, 'files' => Media::MULTIPLE_FILES]
     */
    protected array $files = [];

    /**
     * This method is called upon instantiation of the Eloquent Model.
     * It adds fields to the "$casts" and "$appends" arrays. of the model.
     */
    public function initializeSEOTrait(): void
    {
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

    public function registerMediaCollections(): void
    {
        foreach ($this->files as $key => $value) {
            if ($value === Media::SINGLE_FILE) {
                $this->addMediaCollection($key)->singleFile();
            } else {
                $this->addMediaCollection($key);
            }
        }
    }
}
