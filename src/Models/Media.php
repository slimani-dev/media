<?php

namespace MohSlimani\Media\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Spatie\MediaLibrary\MediaCollections\Models\Media as BaseModel;

class Media extends BaseModel
{
    use SoftDeletes;

    /**
     * get the cast object
     */
    public function getCastObject(): array
    {
        $disk = $this->disk;

        if ($disk === 's3') {
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

        return [
            'id' => $this->id,
            'name' => $this->name,
            'url' => $url,
            'size' => $this->size,
            'mime' => $this->mime_type,
            'type' => $this->type,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
