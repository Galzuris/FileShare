<?php

namespace App\Domain\Interfaces;

interface FileExpiredProcessorInterface
{
    public function processExpired();
}