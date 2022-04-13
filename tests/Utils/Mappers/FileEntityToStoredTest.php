<?php declare(strict_types=1);

namespace App\Tests\Utils\Mappers;

use App\Domain\Entity\FileEntity;
use App\Entity\StoredFile;
use App\Tests\Utils\TypeMapperTestBase;
use Throwable;

/**
 * @covers \App\Utils\Mappers\FileEntityToStored
 * @package App\Tests\Utils\Mappers
 */
class FileEntityToStoredTest extends TypeMapperTestBase
{
    public function testFileEntityToStoredTest()
    {
        $code = '2000ABC';
        $timestamp = 100200;

        $fileEntity = new FileEntity();
        $fileEntity->setCode($code);
        $fileEntity->setName('test.txt');
        $fileEntity->setPath('./test.txt');
        $fileEntity->setCreatedTimestamp($timestamp);

        try {
            /** @var StoredFile $stored */
            $stored = $this->mapper->convert($fileEntity, StoredFile::class);
            $this->assertNotNull($stored, 'ошибка конвертирования не обработана');
            $this->assertEquals($fileEntity->getCode(), $stored->getUid(), 'code не совпадает');
            $this->assertEquals($fileEntity->getCreatedTimestamp(), $stored->getCreated(), 'timestamp не совпадает');
        }
        catch (Throwable $throwable) {
            $this->fail('Throw exception: ' . $throwable->getMessage());
        }
    }
}