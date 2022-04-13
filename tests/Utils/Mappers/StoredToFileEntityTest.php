<?php declare(strict_types=1);

namespace App\Tests\Utils\Mappers;

use App\Domain\Entity\FileEntity;
use App\Entity\StoredFile;
use App\Tests\Utils\TypeMapperTestBase;
use Throwable;

/**
 * @covers \App\Utils\Mappers\StoredToFileEntity
 * @package App\Tests\Utils\Mappers
 */
class StoredToFileEntityTest extends TypeMapperTestBase
{
    public function testStoredToFileEntityTest()
    {
        $code = '2000ABC';
        $timestamp = 100200;

        $fileEntity = new FileEntity();
        $fileEntity->setCode($code);
        $fileEntity->setName('test.txt');
        $fileEntity->setPath('./test.txt');
        $fileEntity->setCreatedTimestamp($timestamp);

        $stored = new StoredFile();
        $stored->setUid($code);
        $stored->setCreated($timestamp);
        $stored->setData(serialize($fileEntity));

        try {
            /** @var FileEntity $file */
            $file = $this->mapper->convert($stored, FileEntity::class);
            $this->assertNotNull($file, 'ошибка конвертирования не обработана');
            $this->assertEquals($file->getCode(), $stored->getUid(), 'code не совпадает');
            $this->assertEquals($file->getCreatedTimestamp(), $stored->getCreated(), 'timestamp не совпадает');
        }
        catch (Throwable $throwable) {
            $this->fail('Throw exception: ' . $throwable->getMessage());
        }
    }
}