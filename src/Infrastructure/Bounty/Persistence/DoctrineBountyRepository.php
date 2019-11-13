<?php

declare(strict_types=1);

namespace BountyHunter\Infrastructure\Bounty\Persistence;

use BountyHunter\Domain\Bounty\BonusRepositoryInterface;
use BountyHunter\Domain\Bounty\Entity\AbstractBounty;
use BountyHunter\Domain\Bounty\Entity\BountyInterface;
use BountyHunter\Domain\Bounty\Specification\SpecificationInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;

/**
 * Class DoctrineRepository
 * @package BountyHunter\Infrastructure\Bounty\Persistence
 */
class DoctrineBountyRepository implements BonusRepositoryInterface
{
    private const ALIAS = 'bounty';
    private const ENTITY_CLASS_NAME = AbstractBounty::class;

    /** @var EntityManagerInterface */
    private $entityManager;

    /**
     * DoctrineBountyRepository constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /** @inheritDoc */
    public function all(): array
    {
        return $this->createQueryBuilder()->getQuery()->getResult();
    }

    /** @inheritDoc */
    public function match(SpecificationInterface $specification): array
    {
        return $specification->toDoctrineQueryBuilder($this->createQueryBuilder())->getQuery()->getResult();
    }

    /** @inheritDoc */
    public function count(?SpecificationInterface $specification= null): int
    {
        if ($specification === null) {
            return $this->entityManager->getUnitOfWork()->getEntityPersister(self::ENTITY_CLASS_NAME)->count([]);
        }

        $alias = self::ALIAS;

        $countResults = $specification
            ->toDoctrineQueryBuilder(
                $this->entityManager->createQueryBuilder()
                    ->select("COUNT({$alias}.id) as cnt")
                    ->from(self::ENTITY_CLASS_NAME, $alias)
            )
            ->setMaxResults(null)
            ->setFirstResult(null)
            ->getQuery()
            ->getScalarResult()
        ;

        $countResult = \array_pop($countResults);

        return !empty($countResult) && isset($countResult['cnt']) ? (int)$countResult['cnt'] : 0;
    }

    /** @inheritDoc */
    public function remove(BountyInterface $bounty): void
    {
        $this->entityManager->remove($bounty);
    }

    /** @inheritDoc */
    public function add(BountyInterface $bounty): void
    {
        $this->entityManager->persist($bounty);
        $this->entityManager->flush($bounty);
    }

    private function createQueryBuilder(): QueryBuilder
    {
        return $this->entityManager->createQueryBuilder()
            ->select(self::ALIAS)
            ->from(self::ENTITY_CLASS_NAME, self::ALIAS)
        ;
    }
}
