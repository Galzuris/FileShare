<?php declare(strict_types=1);

namespace App\Tests\Utils\Mappers;

use App\Domain\Entity\FileRequestEntity;
use App\Domain\Interfaces\Input\FileUploadProcessorInterface;
use App\Domain\Interfaces\Output\FileRepositoryInterface;
use App\Interfaces\FileEntityFindByUidInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @covers \App\Domain\FileUploadProcessor
 * @package App\Tests\Utils\Mappers
 */
class UploadProcessorTest extends KernelTestCase
{
    private const TempFileName = 'test.txt';
    private const TempFilePath = '/tmp/test.txt';
    private const TempFileContent = '123456qwerty';

    private FileUploadProcessorInterface $uploadProcessor;
    private FileEntityFindByUidInterface $finder;
    private FileRepositoryInterface $repository;

    protected function setUp(): void
    {
        self::bootKernel();
        file_put_contents(self::TempFilePath, self::TempFileContent);
        $this->uploadProcessor = self::getContainer()->get(FileUploadProcessorInterface::class);
        $this->repository = self::getContainer()->get(FileRepositoryInterface::class);
        $this->finder = self::getContainer()->get(FileEntityFindByUidInterface::class);
    }

    public function testUpload()
    {
        $request = new FileRequestEntity();
        $request->setPath(self::TempFilePath);
        $request->setName(self::TempFileName);

        $upload = $this->uploadProcessor->processUpload($request);
        $this->assertNotNull($upload, 'результат загрузки null');
        $this->assertNotEmpty($upload->getCode(), 'code не сгенерирован');
        $this->assertNotEmpty($upload->getPath(), 'path не сгенерирован');

        $uploadStored = $this->finder->findByUid($upload->getCode());
        $this->assertNotNull($uploadStored, 'объект не загружен или не найден');
        $this->assertEquals($upload->getCode(), $uploadStored->getCode(), 'ошибка выборки из бд по code/uid');
    }
}
