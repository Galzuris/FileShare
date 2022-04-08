<?php

namespace App\Domain\Interfaces\Input;

use App\Domain\Entity\FileEntity;
use App\Domain\Entity\FileRequestEntity;

interface FileUploadProcessorInterface
{
    public function processUpload(FileRequestEntity $request): FileEntity;
}