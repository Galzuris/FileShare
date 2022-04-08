<?php

namespace App\Domain;

use App\Domain\Interfaces\FileExpiredProcessorInterface;
use App\Domain\Interfaces\FileRepositoryInterface;

class FileExpiredProcessor implements FileExpiredProcessorInterface
{
    private FileRepositoryInterface $repository;

    public function __construct(FileRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function processExpired()
    {
        $expired = $this->repository->findExpired();
    }
}