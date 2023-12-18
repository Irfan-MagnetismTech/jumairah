<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

if (!function_exists('uploadFile')) {

    function uploadFile($file, $folder = '/'): ?string
    {
        if ($file) {
            $image_name = time() . "-" . Str::random(3) . '.' . $file->getClientOriginalExtension();
            return $file->storeAs($folder, $image_name);
        }
        return null;
    }

    /*function call example
    uploadFile($request->file('nid'), 'employee/nid');
    */
}

if (!function_exists('uploadImage')) {

    function uploadImage($imageName, $storeLocation, $oldImageName = null)
    {
        $path = public_path("/$storeLocation/");
        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }

        if ($oldImageName) {
            File::delete($path . $oldImageName);
        }

        $image_name = md5(time() . '_' . $imageName) . '.' . $imageName->getClientOriginalExtension();
        $imageName->move($path, $image_name);
        return $image_name;
    }
}

function watermarkImageSettings($size = '')
{
    return [
        'watermark_image_path'       =>  asset(config('company_info.logo')),
        'show_watermark_image'       => true,
        'watermark_image_alpha'      => 0.2,
        'watermark_image_size'       => $size ?? 'D',
        'watermark_image_position'   => 'P',
    ];
}
