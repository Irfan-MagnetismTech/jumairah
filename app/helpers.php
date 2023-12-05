<?php
use Illuminate\Support\Str;

if (!function_exists('uploadFile')) {

    function uploadFile($file, $folder = '/'): ?string
    {
        if ($file) {
            $image_name = time()."-".Str::random(3). '.' . $file->getClientOriginalExtension();
            return $file->storeAs($folder, $image_name);
        }
        return null;
    }

    /*function call example
    uploadFile($request->file('nid'), 'employee/nid');
    */
}

