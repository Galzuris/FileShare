<?php declare(strict_types=1);

namespace App\Tests\Utils;

use App\Domain\Entity\FileEntity;
use App\Entity\StoredFile;
use App\Exception\TypeMapper\ClassNotFoundException;
use App\Exception\TypeMapper\ConverterNotFoundException;
use App\Utils\Mappers\FileEntityToStored;
use App\Utils\TypeMapper;
use stdClass;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Throwable;

/**
 * @covers \App\Utils\TypeMapper
 * @package App\Tests\Utils
 */
class TypeMapperTest extends KernelTestCase
{
    protected function setUp(): void
    {
        self::bootKernel();
    }

    public function testTypeMapper()
    {
        $converters = [
            new FileEntityToStored(),
        ];

        $temp = new FileEntity();
        $temp->setCreatedTimestamp(123456);
        $temp->setName('name');
        $temp->setPath('path');
        $temp->setCode('code');

        $mapper = new TypeMapper($converters);
        try {
            $stored = $mapper->convert($temp, StoredFile::class);
            $this->assertNotNull($stored, 'объект не сконвертирован');
        } catch (Throwable $e) {
            $this->fail('ошибочная выборка конвертера: ' . $e->getMessage());
        }
    }

    public function testConverterNotFound()
    {
        $temp = new stdClass();
        $mapper = new TypeMapper([]);
        $this->expectException(ConverterNotFoundException::class);
        $mapper->convert($temp, TypeMapperTest::class);
    }

    public function testClassNotFound()
    {
        $temp = new stdClass();
        $mapper = new TypeMapper([]);
        $this->expectException(ClassNotFoundException::class);
        $mapper->convert($temp, 'NotExistsClassName');
    }
}