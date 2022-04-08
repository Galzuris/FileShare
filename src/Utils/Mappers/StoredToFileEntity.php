<?php

namespace App\Utils\Mappers;

use App\Domain\Entity\FileEntity;
use App\Entity\StoredFile;
use App\Utils\TypeMapperInterface;

class StoredToFileEntity implements TypeMapperInterface
{
    public function supports(string $sourceClass, string $targetClass): bool
    {
        return $sourceClass == StoredFile::class && $targetClass == FileEntity::class;
    }

    public function convert(object $source): object
    {
        /** @var StoredFile $source */
        $result = unserialize($source->getData());
        return $result;
    }
}
