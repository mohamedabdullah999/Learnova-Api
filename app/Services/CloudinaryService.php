<?php

namespace App\Services;

use Cloudinary\Cloudinary;

class CloudinaryService
{
    protected Cloudinary $cloudinary;

    public function __construct()
    {
        $this->cloudinary = new Cloudinary([
            'cloud' => [
                'cloud_name' => config('app.cloudinary.cloud_name'),
                'api_key' => config('app.cloudinary.api_key'),
                'api_secret' => config('app.cloudinary.api_secret'),
            ],
            'url' => ['secure' => true],
        ]);
    }

    public function store($filePath, $folder = 'users')
    {
        return $this->cloudinary->uploadApi()->upload($filePath, [
            'folder' => $folder,
            'resource_type' => 'auto',
            'transformation' => [
                'quality' => 'auto',
                'fetch_format' => 'auto',
            ],
        ]);
    }

    public function update($filePath, $oldPublicId = null, $folder = 'users')
    {
        if ($oldPublicId) {
            $this->cloudinary->uploadApi()->destroy($oldPublicId);
        }

        return $this->store($filePath, $folder);
    }

    public function delete($publicId)
    {
        $this->cloudinary->uploadApi()->destroy($publicId);
    }
}
