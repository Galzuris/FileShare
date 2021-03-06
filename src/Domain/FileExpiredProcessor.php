<?php

namespace App\Domain;

use App\Domain\Entity\FileEntity;
use App\Domain\Interfaces\Input\FileExpiredProcessorInterface;
use App\Domain\Interfaces\Output\FileRepositoryInterface;
use App\Domain\Interfaces\Output\FilesystemRepositoryInterface;

class FileExpiredProcessor implements FileExpiredProcessorInterface
{
    private FileRepositoryInterface $repository;
    private FilesystemRepositoryInterface $filesystem;
    private string $basePath;

    public function __construct(string $basePath, FileRepositoryInterface $repository, FilesystemRepositoryInterface $filesystem)
    {
        $this->basePath = $basePath;
        $this->repository = $repository;
        $this->filesystem = $filesystem;
    }

    public function processExpired()
    {
        /** @var FileEntity[] $expired */
        $expired = $this->repository->findExpired();
        foreach ($expired as $file) {
            $path = $file->getPath();
            $this->filesystem->remove($this->basePath . $path);
            $this->repository->delete($file);
        }
    }
}