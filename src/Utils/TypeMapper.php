<?php

namespace App\Utils;

use App\Domain\Entity\FileEntity;
use App\Domain\Entity\FileRequestEntity;
use App\Entity\StoredFile;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class TypeMapper
{
    public static function UploadedToFileRequestEntity(UploadedFile $file): FileRequestEntity
    {
        $entity = new FileRequestEntity();
        $entity->setName($file->getClientOriginalName());
        $entity->setPath($file->getRealPath());
        return $entity;
    }

    public static function FileToStored(FileEntity $entity): StoredFile
    {
        $file = new StoredFile();
        $file->setCreated($entity->getCreatedTimestamp());
        $file->setUid($entity->getCode());
        $file->setData(serialize($entity));
        return $file;
    }

    public static function StoredToFile(StoredFile $stored): FileEntity
    {
        $file = unserialize($stored->getData());
        return $file;
    }
}
