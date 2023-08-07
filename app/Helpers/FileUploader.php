<?php

namespace App\Helpers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FileUploader
{
    public static function uploadFile($file, string $path = "images", string $initials = "img"): string
    {
        try {
            $destinationPath =  $path;
            $req_file = $initials . '-' . rand(1, 1000) . sha1(time()) . "." . $file->getClientOriginalExtension();
            $file = $file->move($destinationPath, $req_file);
            return  str_replace('\\', '/', $file);
        } catch (Exception  $e) {
            \Log::info('Exception in image upload : ' . $e->getMessage());
            throw new Exception("Failed to upload image. error : " . $e->getMessage());
        }
    }

    public  function upload($file, string $path = "images", string $initials = "img"): string
    {
        try {
            $destinationPath =  $path;
            $req_file = $initials . '-' . rand(1, 1000) . sha1(time()) . "." . $file->getClientOriginalExtension();
            $file = $file->move($destinationPath, $req_file);
            return  str_replace('\\', '/', $file);
        } catch (Exception  $e) {
            \Log::info('Exception in image upload : ' . $e->getMessage());
            throw new Exception("Failed to upload image. error : " . $e->getMessage());
        }
    }


    public function storeFile($file, string $path, string $initials = "img"): string
    {
        return Storage::disk('local')
            ->putFileAs('public/images/' . $path, $file, $initials . '-' . rand(1, 1000) . sha1(time()) . "." . $file->getClientOriginalExtension());
    }

    //delete file from storage
    public static function deleteFile($file)
    {
        try {
            if (file_exists($file)) {
                unlink($file);
            }
        } catch (Exception $e) {
            \Log::info('Exception in image delete : ' . $e->getMessage());
            throw new Exception("Failed to delete image. error : " . $e->getMessage());
        }
    }
}
