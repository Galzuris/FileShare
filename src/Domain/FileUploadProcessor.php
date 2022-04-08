<?php

namespace App\Domain;

use App\Domain\Entity\FileEntity;
use App\Domain\Entity\FileRequestEntity;
use App\Domain\Interfaces\Output\FileRepositoryInterface;
use App\Domain\Interfaces\Output\FilesystemRepositoryInterface;
use App\Domain\Interfaces\Input\FileUploadProcessorInterface;
use DateTime;

class FileUploadProcessor implements FileUploadProcessorInterface
{
    private FileRepositoryInterface $repository;
    private FilesystemRepositoryInterface $filesystem;
    private string $storage;
    private string $basePath;

    public function __construct(string $storage, string $basePath, FileRepositoryInterface $repository, FilesystemRepositoryInterface $filesystem)
    {
        $this->storage = $storage;
        $this->basePath = $basePath;
        $this->repository = $repository;
        $this->filesystem = $filesystem;
    }

    public function processUpload(FileRequestEntity $request): FileEntity
    {
        $time = (new DateTime())->getTimestamp();
        $code = base_convert($time * 10000 + rand(0, 9000), 10, 32);

        $info = pathinfo($request->getName());
        $name = $code . '.' . $info['extension'];
        $storagePath = $this->storage . $name;
        $fullPath = $this->basePath . $storagePath;
        $this->filesystem->move($request->getPath(), $fullPath);

        $file = new FileEntity();
        $file->setCreatedTimestamp($time);
        $file->setCode($code);
        $file->setPath($storagePath);
        $file->setName($request->getName());
        $this->repository->create($file);

        return $file;
    }
}