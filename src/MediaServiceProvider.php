<?php

namespace MohSlimani\Media;

use MohSlimani\Media\Commands\MediaCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class MediaServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('media');
        // ->hasCommand(MediaCommand::class)
        // ->hasMigration('create_media_table')
    }
}
