<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

trait FilesUpload
{
    public function fileUpload($params, $path, $column, $model = null)
    {
        $pathFile = $path.'/'.Carbon::now()->format('Y-m').'/';
        $folder = storage_path().'/app/public/'. $pathFile;
        if (!File::exists($folder)) {
            File::makeDirectory($folder, 0775, true, true);
        }

        if (isset($params[$column]) && $params[$column]) {
            if ($model) {
                if (isset($model->$column)){
                    $this->deleteFile($model, $pathFile, $column);
                }
            }
            $fileName = $column.'_'.time() . '.' . $params[$column]->extension();
            $this->storeToPath($params[$column], $pathFile.$fileName); // save to path

            $params[$column] = 'storage/'.$pathFile.$fileName;

        }

//        if (isset($params['files']) && count($params['files'])) {
//            $fileNames = [];
//            if ($model) {
//                if ($model->files) {
//                    $i = explode(',', $model->getRawOriginal('files'));
//                    $fileNames = $i;
//                }
//            }
//            foreach ($params['files'] as $key => $item) {
//                $fileName = time() . '_' . $key . '.' . $item->extension();
////                $item->storeAs('public/'.$pathFile, $fileName);
//                $this->storeToPath('storage/'.$pathFile.'/'.$fileName, $item); // save to minio AWS
//                $fileNames[] = 'storage/'.$pathFile.'/'.$fileName;
//            }
//
//            $fileString = implode(',', $fileNames);
//            $params['files'] = $fileString;
//        }

        return $params;
    }

    public function storeToPath($file, $path): void
    {
        try {
            $file->storeAs('public/'.$path);
        } catch (\Exception $exception){
            info('catch_storage_file', [$path]);
        }
    }

    public function deleteFile($model, $path, $column): bool
    {
        if($model->$column){
            unlink($path.$model->$column);
        }

        if($model->$column){
            $old_images = explode(',', $model->$column);
            foreach($old_images as $old_image){
                unlink($path.$old_image);
            }
        }

        return true;
    }
}
