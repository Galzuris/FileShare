<?php

namespace App\Repository;

use App\Domain\Interfaces\Input\FilesystemRepositoryInterface;
use Exception;

class FilesystemRepository implements FilesystemRepositoryInterface
{
    /**
     * @param string $from
     * @param string $to
     * @throws Exception
     */
    public function move(string $from, string $to)
    {
        $dirName = dirname($to);
        if (false == file_exists($dirName)) {
            mkdir($dirName, 0777, true);
        }

        if (file_exists($from)) {
            rename($from, $to);
            chmod($to, 0777);
        } else {
            throw new Exception("Файл для перемещения не найден");
        }
    }

    public function remove(string $file)
    {
        $slash = str_starts_with($file, '/');
        $point = str_starts_with($file, '.');
        if ($slash || $point) {
            unlink($file);
        } else {
            unlink('./' . $file);
        }
    }

    public function exists(string $file): bool
    {
        return file_exists($file);
    }
}
