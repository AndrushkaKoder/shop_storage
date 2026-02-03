<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine;

use App\Domain\Shared\Entity\EntityInterface;
use App\Domain\Shared\Repository\AbstractRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

abstract class AbstractRepository extends ServiceEntityRepository implements AbstractRepositoryInterface
{
    protected string $entityClass;

    public function __construct(ManagerRegistry $registry, protected EntityManagerInterface $manager)
    {
        parent::__construct($registry, $this->entityClass);
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
}
