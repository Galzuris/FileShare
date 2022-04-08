<?php

namespace App\Utils\Mappers;

use App\Domain\Entity\FileEntity;
use App\Entity\StoredFile;
use App\Utils\TypeMapperInterface;

class FileEntityToStored implements TypeMapperInterface
{
    public function supports(string $sourceClass, string $targetClass): bool
    {
        return $sourceClass == FileEntity::class && $targetClass == StoredFile::class;
    }

    public function convert(object $source): object
    {
        /** @var FileEntity $source */
        $result = new StoredFile();
        $result->setCreated($source->getCreatedTimestamp());
        $result->setUid($source->getCode());
        $result->setData(serialize($source));
        return $result;
    }
}
