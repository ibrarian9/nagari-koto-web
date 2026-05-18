<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Format;
use Intervention\Image\Interfaces\ImageInterface;

/**
 * Centralized image optimization service.
 * Auto-resizes, compresses, and converts uploads to WebP format.
 */
class ImageOptimizer
{
    protected ImageManager $manager;

    /**
     * Preset configurations for different image contexts.
     * Each preset defines max dimensions and compression quality.
     */
    protected array $presets = [
        'banner'    => ['width' => 1200, 'height' => 400,  'quality' => 80],
        'thumbnail' => ['width' => 800,  'height' => 600,  'quality' => 80],
        'photo'     => ['width' => 800,  'height' => 800,  'quality' => 80],
        'logo'      => ['width' => 300,  'height' => 300,  'quality' => 85],
        'avatar'    => ['width' => 400,  'height' => 400,  'quality' => 80],
    ];

    public function __construct()
    {
        $this->manager = new ImageManager(new Driver());
    }

    /**
     * Optimize an uploaded file.
     *
     * @param  UploadedFile  $file     The uploaded file
     * @param  string        $folder   Storage sub-folder (e.g. 'posts', 'village')
     * @param  string        $preset   Preset name (banner, thumbnail, photo, logo, avatar)
     * @return string                  Storage path of the optimized file
     */
    public function optimize(UploadedFile $file, string $folder, string $preset = 'photo'): string
    {
        $config = $this->presets[$preset] ?? $this->presets['photo'];
        $image = $this->manager->decode($file);

        // Scale down proportionally (never upscale)
        $image = $this->scaleDown($image, $config['width'], $config['height']);

        // Encode to WebP
        $encoded = $image->encodeUsingFormat(Format::WEBP, quality: $config['quality']);

        // Generate unique filename
        $filename = $folder . '/' . uniqid() . '_' . time() . '.webp';

        // Store to public disk
        Storage::disk('public')->put($filename, (string) $encoded);

        return $filename;
    }

    /**
     * Optimize a raw base64 image string (e.g. from Cropper.js).
     *
     * @param  string  $base64Data  Data URL (data:image/jpeg;base64,...)
     * @param  string  $folder      Storage sub-folder
     * @param  string  $preset      Preset name
     * @return string               Storage path of the optimized file
     */
    public function optimizeBase64(string $base64Data, string $folder, string $preset = 'banner'): string
    {
        $config = $this->presets[$preset] ?? $this->presets['photo'];

        // Parse base64 data URL
        $data = explode(',', $base64Data, 2);
        $binary = base64_decode($data[1]);

        $image = $this->manager->decodeBinary($binary);
        $image = $this->scaleDown($image, $config['width'], $config['height']);
        
        $encoded = $image->encodeUsingFormat(Format::WEBP, quality: $config['quality']);

        $filename = $folder . '/banner_' . time() . '.webp';
        Storage::disk('public')->put($filename, (string) $encoded);

        return $filename;
    }

    /**
     * Scale image down proportionally. Never upscale.
     */
    protected function scaleDown(ImageInterface $image, int $maxWidth, int $maxHeight): ImageInterface
    {
        $width = $image->width();
        $height = $image->height();

        if ($width > $maxWidth || $height > $maxHeight) {
            $image = $image->scaleDown($maxWidth, $maxHeight);
        }

        return $image;
    }
}
