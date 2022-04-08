<?php

namespace App\Utils;

interface TypeMapperInterface
{
    public function supports(string $sourceClass, string $targetClass): bool;
    public function convert(object $source): object;
}
