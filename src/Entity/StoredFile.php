<?php

namespace App\Entity;

use App\Repository\StoredFileRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StoredFileRepository::class)
 */
class StoredFile
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=10)
     */
    private ?string $uid;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $created;

    /**
     * @ORM\Column(type="text")
     */
    private ?string $data;

    /**
     * @return mixed
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * @param mixed $uid
     * @return StoredFile
     */
    public function setUid(?string $uid): self
    {
        $this->uid = $uid;

        return $this;
    }

    public function getCreated(): ?int
    {
        return $this->created;
    }

    public function setCreated(int $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getData(): ?string
    {
        return $this->data;
    }

    public function setData(string $data): self
    {
        $this->data = $data;

        return $this;
    }
}
