# A Media Model for laravel medialibrary

[![Latest Version on Packagist](https://img.shields.io/packagist/v/moh-slimani/media.svg?style=flat-square)](https://packagist.org/packages/moh-slimani/media)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/moh-slimani/media/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/moh-slimani/media/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/moh-slimani/media/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/moh-slimani/media/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/moh-slimani/media.svg?style=flat-square)](https://packagist.org/packages/moh-slimani/media)

This package simplifies the integration of Spatie MediaLibrary by offering a streamlined approach to registering
and managing media assets within Laravel applications,  effortlessly cast media to a simple format, leveraging a 
path generator that enhances readability and organization. Seamlessly handle media registration 
while maintaining all functionalities of The MediaLibrary package.

## Installation

You can install the package via composer:

```bash
composer require moh-slimani/media
```

You must publish and run the migrations,this will add soft delete to the media model

```bash
php artisan vendor:publish --tag="media-migrations"
php artisan migrate
```

change the media_model in the media library config file

`config/media-library.php`

```php

    ...
    /*
     * The fully qualified class name of the media model.
     */
    'media_model' => MohSlimani\Media\Models\Media::class,
    
    ...    

```

**Optional :** you can change the path generator in the media library config file

```php

    ...
    
    /*
     * The class that contains the strategy for determining a media file's path.
     */
    'path_generator' => MohSlimani\Media\Helpers\MediaPathGenerator::class,

    ...

```

## Usage

```php
use MohSlimani\Media\Traits\UseMediaModel
use MohSlimani\Media\Media
use Spatie\MediaLibrary\HasMedia;


class User extends Authenticatable implements HasMedia
{

    // you don't need to user InteractsWithMedia
    use HasApiTokens, HasFactory, Notifiable, UseMediaModel;


    /**
     * This array should contain the list of media keys to be registered.
     *
     * @var array $files
     * @example ['photo' => Media::SINGLE_FILE, 'files' => Media::MULTIPLE_FILES]
     */
    protected array $files = [
        'photo' => Media::SINGLE_FILE, 
        'cv', // Media::SINGLE_FILE is the default
        'files' => Media::MULTIPLE_FILES
    ];

    ...
```

After that you can add files it like you used to using the `medialibrary` package

```php

/** @var File $photo */
$user->addMedia($photo)->toMediaCollection('photo');

```

you can get the files like this

```php

    $user->photo
 
    [
        "id" => 15,
        "name" => "IMG_7833",
        "url" => "http://media.test/storage/Users/1/photo/IMG_7833.jpg",
        "size" => 249686,
        "mime" => "image/jpeg",
        "type" => "image",
        "created_at" => Illuminate\Support\Carbon @1705898712 {#6527
          date: 2024-02-19 00:00:00.0 UTC (+00:00),
        },
        "updated_at" => Illuminate\Support\Carbon @1705898712 {#6782
          date: 2024-02-19 00:00:00.0 UTC (+00:00),
        },
    ]



```


## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Mohamed slimani](https://github.com/moh-slimani)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
