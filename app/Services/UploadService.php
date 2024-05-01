<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class UploadService
{
    /**
     * Upload resource.
     *
     * @param $file
     * @param $filePath
     * @return string
     */
    public static function upload($file, $filePath)
    {
        $file_name = $filePath . '/' . time() . rand() . "." . $file->getClientOriginalExtension();
        self::setFile($file_name, file_get_contents($file));
        return $file_name;
    }

    /**
     * Set resource.
     *
     * @param $file_name
     * @param $file
     * @return bool
     */
    public static function setFile($file_name, $file)
    {
        return Storage::put($file_name, $file);
    }

    /**
     * Delete resource.
     *
     * @param $file_name
     * @return void
     */
    public static function cleanFile($file_name)
    {
        if (Storage::exists($file_name)) {
            Storage::delete($file_name);
        }
    }
}
