<?php declare(strict_types=1);

namespace App\Tests\Utils\Mappers;

use App\Domain\Entity\FileRequestEntity;
use App\Tests\Utils\TypeMapperTestBase;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Throwable;

/**
 * @covers \App\Utils\Mappers\UploadedFileToRequestEntity
 * @package App\Tests\Utils\Mappers
 */
class UploadedFileToRequestEntityTest extends TypeMapperTestBase
{
    public function testUploadedFileToRequestEntityTest()
    {
        $uploaded = new UploadedFile('./readme.md', 'readme.md', 'text/txt');
        try {
            /** @var FileRequestEntity $request */
            $request = $this->mapper->convert($uploaded, FileRequestEntity::class);
            $this->assertNotNull($request, 'ошибка конвертирования не обработана');
            $this->assertEquals($request->getPath(), $uploaded->getRealPath(), 'путь не совпадает');
            $this->assertEquals($request->getName(), $uploaded->getClientOriginalName(), 'имя не совпадает');
        }
        catch (Throwable $throwable) {
            $this->fail('Throw exception: ' . $throwable->getMessage());
        }
    }
}