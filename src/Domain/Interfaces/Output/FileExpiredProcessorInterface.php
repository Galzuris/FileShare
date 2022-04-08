<?php

namespace App\Domain\Interfaces\Output;

interface FileExpiredProcessorInterface
{
    public function processExpired();
}