<?php

namespace MohSlimani\Media\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \MohSlimani\Media\Media
 */
class Media extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \MohSlimani\Media\Media::class;
    }
}
