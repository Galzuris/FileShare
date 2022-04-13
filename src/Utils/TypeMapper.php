<?php

namespace App\Utils;

use App\Exception\TypeMapper\ClassNotFoundException;
use App\Exception\TypeMapper\ConverterNotFoundException;
use Exception;

class TypeMapper
{
    private static iterable $strategies;

    public function __construct(iterable $strategies)
    {
        self::$strategies = $strategies;
    }

    /**
     * @param $source
     * @param string $targetClass
     * @return object
     * @throws Exception
     */
    public function convert($source, string $targetClass): object {
        if (false == class_exists($targetClass)) {
            throw new ClassNotFoundException('Class ' . $targetClass . ' not exists');
        }

        $sourceClass = get_class($source);
        foreach (self::$strategies as $strategy) {
            if ($strategy->supports($sourceClass, $targetClass)) {
                return $strategy->convert($source);
            }
        }

        throw new ConverterNotFoundException('Converter from ' . $sourceClass . ' to ' . $targetClass . ' not found');
    }
}
