<?php

namespace Flocc\Helpers;

use Image;
use Storage;
use Session;

class ImageHelper
{
    public function generateName()
    {
        // use UUID and check uniqueness - db?
        $fileName = uniqid();
        return $fileName;
    }

    public function cloneSocial($url, $type = null)
    {
        if (empty($url))
            return null;

        $w = null;
        $h = null;
        $prefix = '';

        switch ($type) {
            case 'avatar':
            default:
                $h = 300;
                $prefix = "avatars";
                break;
        }

        $img = Image::make($url);
        $img->resize($w, $h, function($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        $fname = $this->generateName();
        preg_match('/^.*\.(jpg|jpeg|png|gif)$/i', $url, $ext);

        if (!empty($ext[0])) {
            $fname .= $ext[0];
        } else {
            // default extension, better use MIME
            $fname .= '.jpg';
        }

        switch (config('filesystems.default')) {
            case 'local':
                Storage::put("$prefix/$fname", $img);
                break;
            case 's3':
                Storage::put("$prefix/$fname", $img->stream()->__toString());
                break;
        }

        // storage_path always shows local path, even when filesystem set to s3
        // Storage facade does not return the path to remote file, hence for now - fixed one

        $path = "https://s3.eu-central-1.amazonaws.com/flocc";
        return "$path/$prefix/$fname";
    }

    public function uploadFile($file, $type = null)
    {
        $w      = null;
        $h      = null;

        switch ($type) {
            case 'avatar':
            default:
                $h      = 300;
                $prefix = "avatars";
                break;
        }

        include_once '../vendor/intervention/image/src/intervention/image/ImageManager.php';

        $image  = new \Intervention\Image\ImageManager();
        $img    = $image->make($file->getRealPath());
        $ext    = $file->getClientOriginalExtension();

        $img->resize($w, $h, function($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        $fname  = $this->generateName();
        $fname .= "." . $ext;

        switch (config('filesystems.default')) {
            case 'local':
                Storage::put($prefix . "/" . $fname, $img);
                break;
            case 's3':
                Storage::put($prefix . "/" . $fname, $img->stream()->__toString());
                break;
        }

        // storage_path always shows local path, even when filesystem set to s3
        // Storage facade does not return the path to remote file, hence for now - fixed one

        $path = "https://s3.eu-central-1.amazonaws.com/flocc";

        return $path . "/" . $prefix . "/" . $fname;
    }
}
