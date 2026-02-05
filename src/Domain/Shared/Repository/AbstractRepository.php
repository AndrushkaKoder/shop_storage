<?php

declare(strict_types=1);

namespace App\Domain\Shared\Repository;

use App\Domain\Shared\Entity\EntityInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

abstract class AbstractRepository extends ServiceEntityRepository
{
    protected string $entityClass;

    public function __construct(ManagerRegistry $registry, protected EntityManagerInterface $manager)
    {
        parent::__construct($registry, $this->entityClass);
    }

    public function findById(int $id): ?EntityInterface
    {
        return $this->findOneBy(['id' => $id]);
    }

    public function create(EntityInterface $entity): EntityInterface
    {
        $this->manager->persist($entity);

        $this->manager->flush();

        return $entity;
    }

    public function save(EntityInterface $entity): EntityInterface
    {
        $this->manager->flush();

        return $entity;
    }

    public function delete(EntityInterface $entity): bool
    {
        $this->getEntityManager()->remove($entity);

        return true;
    }
}
