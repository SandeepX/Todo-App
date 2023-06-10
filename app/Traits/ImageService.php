<?php

namespace App\Traits;

use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;


Trait ImageService
{
    public function storeImage($file,$filePath,$width=800,$height=800) : string
    {
        $path = public_path($filePath);
        if (!file_exists($path) ) {
            mkdir($path, 0777, true);
        }
        $fileNameToStore = uniqid(true).'_'.trim($file->getClientOriginalName()) ;
        $success = $file->move($path, $fileNameToStore);
        if($success){
            Image::make($path."/". $fileNameToStore)->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path.'/Todo-'.$fileNameToStore);
            $this->removeOriginalImage($filePath,$fileNameToStore);
            return 'Todo-'.$fileNameToStore;
        }
        return $fileNameToStore;
    }

    public function removeImage($filePath,$fileName)
    {
        if(File::exists(public_path($filePath.$fileName))){
            File::delete(public_path($filePath.$fileName));
        }
    }

    private function removeOriginalImage($filePath,$fileName)
    {
        if(File::exists(public_path($filePath.$fileName))){
            File::delete(public_path($filePath.$fileName));
        }
    }



}
