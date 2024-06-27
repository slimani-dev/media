<?php

namespace MohSlimani\Media\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Spatie\MediaLibrary\MediaCollections\Models\Media as BaseModel;

class Media extends BaseModel
{
    use SoftDeletes;

    /**
     * get the cast object
     */
    public function toArray(): array
    {
        $attributes = $this->only([
            'id', 'uuid', 'name',
            'file_name', 'disk',
            'type', 'size', 'mime',
            'url', 'created_at', 'updated_at',
            'type', 'mime_type',
        ]);

        if (app()->environment(['local', 'staging', 'testing'])) {
            $attributes['path'] = $this->getPath();
        }

        return $attributes;
    }

    protected $appends = [
        'url',
        'mime',
    ];

    public function url(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->disk === 's3') {
                    if (Cache::has('s3_temporary_url_'.$this->id)) {
                        $url = Cache::get('s3_temporary_url_'.$this->id);
                    } else {
                        $time = now()->addHours(4);
                        $url = $this->getTemporaryUrl($time);
                        Cache::put('s3_temporary_url_'.$this->id, $url, $time);
                    }
                } else {
                    $url = $this->getFullUrl();
                }

                return $url;
            },
        );
    }

    public function mime(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => $attributes['mime_type'],
        );
    }
}
