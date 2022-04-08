<?php

namespace App\Repository;

use App\Domain\Entity\FileEntity;
use App\Domain\Interfaces\FileRepositoryInterface;
use App\Entity\StoredFile;
use App\Utils\TypeMapper;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method StoredFile|null find($id, $lockMode = null, $lockVersion = null)
 * @method StoredFile|null findOneBy(array $criteria, array $orderBy = null)
 * @method StoredFile[]    findAll()
 * @method StoredFile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StoredFileRepository extends ServiceEntityRepository implements FileRepositoryInterface
{
    private int $offset;

    public function __construct(int $lifetime, ManagerRegistry $registry)
    {
        $this->offset = (new DateTime())->getTimestamp() - abs($lifetime);
        parent::__construct($registry, StoredFile::class);
    }

    public function create(FileEntity $entity)
    {
        $file = TypeMapper::FileToStored($entity);
        $this->_em->persist($file);
        $this->_em->flush();
    }

    public function delete(FileEntity $entity)
    {
        $stored = $this->findOneBy(['uid' => $entity->getCode()]);
        if ($stored) {
            $this->_em->remove($stored);
            $this->_em->flush();
        }
    }

    public function findExpired(): array
    {
        $list = $this
            ->createQueryBuilder('f')
            ->andWhere('f.created < :offset')
            ->setParameter('offset', $this->offset)
            ->getQuery()
            ->getResult()
        ;
        foreach ($list as $item) {
            $result[] = TypeMapper::StoredToFile($item);
        }
        return $result ?? [];
    }

    public function findByUid(string $uid): ?FileEntity
    {
        $stored = $this->findOneBy(['uid' => $uid]);
        if ($stored) {
            return TypeMapper::StoredToFile($stored);
        }
        return null;
    }
}
