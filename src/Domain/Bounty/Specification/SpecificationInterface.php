<?php

declare(strict_types=1);

namespace BountyHunter\Domain\Bounty\Specification;

use Doctrine\ORM\QueryBuilder;

/**
 * Interface SpecificationInterface
 * @package BountyHunter\Domain\Bounty\Specification
 */
interface SpecificationInterface
{
    /**
     * @param QueryBuilder $builder
     *
     * @return QueryBuilder
     */
    public function toDoctrineQueryBuilder(QueryBuilder $builder): QueryBuilder;
}