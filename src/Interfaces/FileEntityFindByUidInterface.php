<?php

namespace App\Interfaces;

use App\Domain\Entity\FileEntity;

interface FileEntityFindByUidInterface
{
    public function findByUid(string $uid): ?FileEntity;
}