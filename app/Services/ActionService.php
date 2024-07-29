<?php

namespace App\Services;

use App\Repositories\ActionRepository;
use App\Traits\FilesUpload;
use Illuminate\Support\Facades\File;

class ActionService extends BaseService
{
    use FilesUpload;
    public function __construct(ActionRepository $repo)
    {
        $this->repo = $repo;
        $this->relation = [];
        $this->filter_fields = [
            'user_id' => ['type' => 'number'], 'application_id' => ['type' => 'number'], 'signed' => ['type' => 'bool'],
        ];
        $this->sort_fields = [];
        $this->attributes = ['*'];
    }

}
