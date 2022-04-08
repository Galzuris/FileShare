<?php

namespace App\Repository;

use App\Domain\Entity\FileEntity;
use App\Domain\Interfaces\Input\FileRepositoryInterface;
use App\Entity\StoredFile;
use App\Interfaces\FileEntityFindByUidInterface;
use App\Utils\TypeMapper;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

/**
 * @method StoredFile|null find($id, $lockMode = null, $lockVersion = null)
 * @method StoredFile|null findOneBy(array $criteria, array $orderBy = null)
 * @method StoredFile[]    findAll()
 * @method StoredFile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StoredFileRepository extends ServiceEntityRepository implements FileRepositoryInterface, FileEntityFindByUidInterface
{
    private int $offset;
    private TypeMapper $mapper;

    public function __construct(int $lifetime, ManagerRegistry $registry, TypeMapper $mapper)
    {
        $this->mapper = $mapper;
        $this->offset = (new DateTime())->getTimestamp() - abs($lifetime);
        parent::__construct($registry, StoredFile::class);
    }

    /**
     * @param FileEntity $entity
     * @throws Exception
     */
    public function create(FileEntity $entity)
    {
        $file = $this->mapper->convert($entity, StoredFile::class);
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

    /**
     * @return array
     * @throws Exception
     */
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
            $result[] = $this->mapper->convert($item, FileEntity::class);
        }
        return $result ?? [];
    }

    /**
     * @param string $uid
     * @return FileEntity|null|object
     * @throws Exception
     */
    public function findByUid(string $uid): ?FileEntity
    {
        $stored = $this->findOneBy(['uid' => $uid]);
        if ($stored) {
            $data = $this->mapper->convert($stored, FileEntity::class);
            return $data;
        }
        return null;
    }
}
