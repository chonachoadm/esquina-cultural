<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;

class ImageUploadService
{
    public const PROFILE_WIDTH = 500;
    public const PROFILE_HEIGHT = 500;

    public const BANNER_WIDTH = 1200;
    public const BANNER_HEIGHT = 675;

    protected ImageManager $manager;

    public function __construct()
    {
        $this->manager = ImageManager::gd();
    }

    /**
     * Recorta al centro, redimensiona y comprime una imagen subida, la guarda
     * en el disco indicado y devuelve el nombre de archivo generado.
     */
    public function storeResized(UploadedFile $file, string $directory, int $width, int $height, string $disk = 'public'): string
    {
        $encoded = $this->manager->read($file->getRealPath())
            ->cover($width, $height)
            ->toWebp(quality: 82);

        $filename = Str::random(40) . '.webp';

        Storage::disk($disk)->put($directory . '/' . $filename, (string) $encoded);

        return $filename;
    }

    /**
     * Foto de perfil (usuario): cuadrada.
     */
    public function storeProfileImage(UploadedFile $file, string $directory = 'images/profiles'): string
    {
        return $this->storeResized($file, $directory, self::PROFILE_WIDTH, self::PROFILE_HEIGHT);
    }

    /**
     * Imagen panorámica (obra o teatro).
     */
    public function storeBannerImage(UploadedFile $file, string $directory): string
    {
        return $this->storeResized($file, $directory, self::BANNER_WIDTH, self::BANNER_HEIGHT);
    }
}
