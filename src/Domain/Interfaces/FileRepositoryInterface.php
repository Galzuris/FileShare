<?php

namespace App\Domain\Interfaces;

use App\Domain\Entity\FileEntity;

/**
 * Управление FileEntity.
 *
 * Interface FileRepositoryInterface
 * @package App\Domain\Interfaces
 */
interface FileRepositoryInterface
{
    public function create(FileEntity $entity);
    public function delete(FileEntity $entity);
    public function findByUid(string $uid): ?FileEntity;
    public function findExpired(): array;
}
