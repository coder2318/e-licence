<?php

namespace App\Services;

use App\Repositories\ApplicationRepository;
use App\Traits\FilesUpload;
use Illuminate\Support\Facades\File;

class ApplicationService extends BaseService
{
    use FilesUpload;
    public function __construct(ApplicationRepository $repo)
    {
        $this->repo = $repo;
        $this->relation = ['user'];
        $this->filter_fields = [
            'name' => ['type' => 'string'], 'user_id' => ['type' => 'number'],
        ];
        $this->sort_fields = [];
        $this->attributes = ['*'];
    }

    public function create($params): object
    {
        foreach ($params as $key => $value) {
            if(File::isFile($value)){
                $params = $this->fileUpload($params, 'applications', $key);
            }
        }
        return $this->repo->store($params);
    }

}
