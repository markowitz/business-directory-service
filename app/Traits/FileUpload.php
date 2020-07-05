<?php


namespace App\Traits;


trait FileUpload
{
    /**
     * @param $file
     * @param $uploadPath
     * @return mixed
     */
    public static function singleUpload($file, $uploadPath)
    {
        $path = $file->store("public/$uploadPath");

        return 'storage/' . explode('public/', $path)[1];
    }

    /**
     * @param $files
     * @param $uploadPath
     * @return array
     */
    public static function multipleUpload($files, $uploadPath)
    {
        if(count($files) <= 0) return [];

        $path = [];
        foreach($files as $file) {
            $path[] = self::singleUpload($file, $uploadPath);
        }

        return $path;
    }
}
