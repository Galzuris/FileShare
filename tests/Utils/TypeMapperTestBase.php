<?php declare(strict_types=1);

namespace App\Tests\Utils;

use App\Utils\TypeMapper;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TypeMapperTestBase extends KernelTestCase
{
    protected TypeMapper $mapper;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->mapper = self::getContainer()->get(TypeMapper::class);
    }
}