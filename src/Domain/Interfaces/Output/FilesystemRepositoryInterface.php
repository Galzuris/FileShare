<?php

namespace App\Domain\Interfaces\Output;

interface FilesystemRepositoryInterface
{
    public function move(string $from, string $to);
    public function remove(string $file);
    public function exists(string $file): bool;
}
