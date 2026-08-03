<?php

use Illuminate\Support\Facades\Storage;

if (! function_exists('upload_asset')) {
    /**
     * Devuelve la URL pública de un archivo subido por el usuario (fotos de
     * perfil, banners de obras/teatros, códigos QR de tickets, etc).
     *
     * A diferencia de asset('storage/...'), esto respeta el disco configurado
     * en filesystems.uploads_disk (disco local en desarrollo, bucket de object
     * storage en producción), por lo que sigue funcionando aunque el archivo
     * no viva en el disco local.
     */
    function upload_asset(string $path): string
    {
        return Storage::disk(config('filesystems.uploads_disk', 'public'))->url($path);
    }
}
