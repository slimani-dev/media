<?php

namespace MohSlimani\Media\Helpers;

use MohSlimani\Media\Models\Media;
use ReflectionClass;
use ReflectionException;
use Spatie\MediaLibrary\Support\PathGenerator\DefaultPathGenerator;

class MediaPathGenerator extends DefaultPathGenerator
{
    /**
     * Get a unique base path for the given media.
     *
     * @throws ReflectionException
     */
    protected function getBasePath(Media|\Spatie\MediaLibrary\MediaCollections\Models\Media $media): string
    {
        $prefix = config('media-library.prefix', '');

        $model = $media->model;
        $reflectionClass = new ReflectionClass($model);

        $path = $prefix.'/';
        $path .= str($reflectionClass->getShortName())->plural()->value().'/';
        $path .= $model->id.'/';
        $path .= $media->collection_name;

        return $path;
    }
}
