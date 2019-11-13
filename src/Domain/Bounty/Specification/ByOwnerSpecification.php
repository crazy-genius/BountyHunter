<?php

declare(strict_types=1);

namespace BountyHunter\Domain\Bounty\Specification;

use BountyHunter\Domain\User\Entity\User;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;

/**
 * Class ByOwnerSpecification
 * @package BountyHunter\Domain\Bounty\Specification
 */
class ByOwnerSpecification implements SpecificationInterface
{
    /** @var User */
    private $owner;

    /**
     * ByOwnerSpecification constructor.
     *
     * @param User $owner
     */
    public function __construct(User $owner)
    {
        $this->owner = $owner;
    }

    public function toDoctrineQueryBuilder(QueryBuilder $builder): QueryBuilder
    {
        $aliases = $builder->getRootAliases();
        $alias = \array_pop($aliases);

        return $builder
            ->andWhere((new Expr())->eq("{$alias}.owner", ':owner'))
            ->andWhere((new Expr())->eq("{$alias}.refused", ':refused'))
            ->setParameter('owner', $this->owner)
            ->setParameter('refused', false);
    }
}
