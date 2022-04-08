<?php

namespace App\Domain\Entity;

class FileEntity
{
    private string $code;
    private string $name;
    private string $path;
    private int $createdTimestamp;

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    /**
     * @return int
     */
    public function getCreatedTimestamp(): int
    {
        return $this->createdTimestamp;
    }

    /**
     * @param int $createdTimestamp
     */
    public function setCreatedTimestamp(int $createdTimestamp): void
    {
        $this->createdTimestamp = $createdTimestamp;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath(string $path): void
    {
        $this->path = $path;
    }
}