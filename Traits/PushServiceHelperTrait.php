<?php

namespace Modules\PushService\Traits;

use App\Models\Image;
use App\Models\FileManager;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

trait PushServiceHelperTrait
{
    // protected $path_prefix = 'public';
    public function UploadImageCreate($image, $path, $returnType=null)
    {
        if ($image && is_file($image)) {

            $extension = $image->guessExtension();
            $filename  = time() . '.' . $extension;

            $image_record       = new Image();
            if (setting('file_system') == 's3') {
                $filePath       = s3Upload($path, $image);
                $imagePostSuccess = Storage::disk('s3')->exists($filePath);
                $image_record->path = $filePath;
            }else{
                $image->move($path, $filename);
                $image_record->path = $path .'/'. $filename;
            }
            $image_record->save();

            return $returnType == 'path' ? ApiAsset($image_record->path) : $image_record->id;

        }
        return null;
    }
    public function UploadFileCreate($file, $path, $returnType=null)
    {
        if ($file && is_file($file)) {
            $extension = $file->guessExtension();
            $filename  = time() . '.' . $extension;

            $file_record       = new FileManager();
            if (setting('file_system') == 's3') {
                $filePath       = s3Upload($path, $file);
                $filePostSuccess = Storage::disk('s3')->exists($filePath);
                $file_record->path = $filePath;
            }else{
                $file->move($path, $filename);
                $file_record->path = $path .'/'. $filename;
            }
            $file_record->save();

            return $returnType == 'path' ? ApiAsset($file_record->path) : $file_record->id;

        }
        return null;
    }

    public function UploadImageUpdate($image, $path, $image_id)
    {
        if ($image && is_file($image)) {

            if($image_id){
                $image_record = Image::find($image_id);
                if (setting('file_system') == 's3') {
                    Storage::disk('s3')->delete($image_record->path);
                }else{
                    $file_path    = public_path($image_record->path);
                    if(file_exists($file_path)){
                        File::delete($file_path);
                    }
                }
            }else{
                $image_record = new Image();
            }

            $extension          = $image->guessExtension();
            $filename           = time() . '.' . $extension;
            if (setting('file_system') == 's3') {
                $filePath       = s3Upload($path, $image);
                $image_record->path = $filePath;
            }else{
                $image->move($path, $filename);
                $image_record->path = $path .'/'. $filename;
            }

            $image_record->save();
            return $image_record->id;
        }
        return $image_id;
    }

    public function UploadFileUpdate($file, $path, $file_id)
    {
        if ($file && is_file($file)) {

            if($file_id){
                $file_record = FileManager::find($file_id);
                if (setting('file_system') == 's3') {
                    Storage::disk('s3')->delete($file_record->path);
                }else{
                    $file_path    = public_path($file_record->path);
                    if(file_exists($file_path)){
                        File::delete($file_path);
                    }
                }
            }else{
                $file_record = new FileManager();
            }

            $extension          = $file->guessExtension();
            $filename           = time() . '.' . $extension;
            if (setting('file_system') == 's3') {
                $filePath       = s3Upload($path, $file);
                $file_record->path = $filePath;
            }else{
                $file->move($path, $filename);
                $file_record->path = $path .'/'. $filename;
            }

            $file_record->save();
            return $file_record->id;
        }
        return $file_id;
    }

    public function UploadImageDelete($image_id)
    {
        if($image_id){
            $image_record = Image::find($image_id);
            $file_path    = public_path($image_record->path);
            if(file_exists($file_path)){
                File::delete($file_path);
            }
            $image_record->delete();
        }
        return true;
    }

    public function UploadFileDelete($file_id)
    {
        if($file_id){
            $file_record = FileManager::find($file_id);
            $file_path    = public_path($file_record->path);
            if(file_exists($file_path)){
                File::delete($file_path);
            }
            $file_record->delete();
        }
        return true;
    }
}
