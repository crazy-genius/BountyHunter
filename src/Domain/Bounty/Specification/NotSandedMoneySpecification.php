<?php

declare(strict_types=1);

namespace BountyHunter\Domain\Bounty\Specification;

use BountyHunter\Domain\Bounty\Entity\Money;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;

/**
 * Class NotSandedMoneySpecification
 * @package BountyHunter\Domian\Bounty\Specification
 */
class NotSandedMoneySpecification implements SpecificationInterface
{
    /** @var int */
    protected $limit;
    /** @var int */
    protected $offset;

    /**
     * NotSandedMoneySpecification constructor.
     *
     * @param int $limit
     * @param int $offset
     */
    public function __construct(?int $limit = null, ?int $offset = null)
    {
        $this->limit = $limit;
        $this->offset = $offset;
    }

    /** @inheritDoc */
    public function toDoctrineQueryBuilder(QueryBuilder $builder): QueryBuilder
    {
        $aliases = $builder->getRootAliases();
        $alias = \array_pop($aliases);

        $builder
            ->andWhere((new Expr())->eq("{$alias}.sent", ':sent'))
            ->andWhere((new Expr())->eq("{$alias}.refused", ':refused'))
            ->andWhere((new Expr())->isInstanceOf($alias, Money::class))
            ->setParameters([
                'sent' => false,
                'refused' => false,
            ])
        ;

        if ($this->limit > 0) {
            $builder->setFirstResult($this->offset);
        }

        if ($this->offset > 0) {
            $builder->setMaxResults($this->limit);
        }

        return $builder;
    }
}
