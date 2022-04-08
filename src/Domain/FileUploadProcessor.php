<?php

namespace App\Domain;

use App\Domain\Entity\FileEntity;
use App\Domain\Entity\FileRequestEntity;
use App\Domain\Interfaces\FileRepositoryInterface;
use App\Domain\Interfaces\FilesystemRepositoryInterface;
use App\Domain\Interfaces\FileUploadProcessorInterface;
use DateTime;

class FileUploadProcessor implements FileUploadProcessorInterface
{
    private FileRepositoryInterface $repository;
    private FilesystemRepositoryInterface $filesystem;
    private string $storage;

    public function __construct(string $storage, FileRepositoryInterface $repository, FilesystemRepositoryInterface $filesystem)
    {
        $this->storage = $storage;
        $this->repository = $repository;
        $this->filesystem = $filesystem;
    }

    public function processUpload(FileRequestEntity $request): FileEntity
    {
        $time = (new DateTime())->getTimestamp();
        $code = base_convert($time * 10000 + rand(0, 9000), 10, 32);

        $info = pathinfo($request->getName());
        $name = $code . '.' . $info['extension'];
        $path = $this->storage . $name;
        $this->filesystem->move($request->getPath(), $path);

        $file = new FileEntity();
        $file->setCreatedTimestamp($time);
        $file->setCode($code);
        $file->setPath($path);
        $file->setName($request->getName());
        $this->repository->create($file);

        return $file;
    }
}