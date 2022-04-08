<?php

namespace App\Utils\Mappers;

use App\Domain\Entity\FileRequestEntity;
use App\Utils\TypeMapperInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadedFileToRequestEntity implements TypeMapperInterface
{
    public function supports(string $sourceClass, string $targetClass): bool
    {
        return $sourceClass == UploadedFile::class && $targetClass == FileRequestEntity::class;
    }

    public function convert(object $source): object
    {
        /** @var UploadedFile $source */
        $request = new FileRequestEntity();
        $request->setName($source->getClientOriginalName());
        $request->setPath($source->getRealPath());
        return $request;
    }
}