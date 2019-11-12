<?php

declare(strict_types=1);

namespace BountyHunter\Domain\Bounty;

use BountyHunter\Domain\Bounty\Entity\BountyInterface;
use BountyHunter\Domain\Bounty\Specification\SpecificationInterface;

/**
 * Interface BonusRepositoryInterface
 * @package BountyHunter\Domain\Bounty
 */
interface BonusRepositoryInterface
{
    /**
     * @return BountyInterface[]
     */
    public function all(): array;

    /**
     * @param SpecificationInterface $specification
     *
     * @return BountyInterface[]
     */
    public function match(SpecificationInterface $specification): array;

    /**
     * @param SpecificationInterface|null $specification
     *
     * @return int
     */
    public function count(?SpecificationInterface $specification = null): int;
}
