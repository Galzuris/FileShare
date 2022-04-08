<?php

namespace App\Domain\Interfaces\Input;

interface FileExpiredProcessorInterface
{
    public function processExpired();
}