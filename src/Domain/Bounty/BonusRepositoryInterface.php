<?php

declare(strict_types=1);

namespace BountyHunter\Domain\Bounty;

use BountyHunter\Domain\Bounty\Entity\BountyInterface;
use BountyHunter\Domain\Bounty\Specification\SpecificationInterface;
use Ramsey\Uuid\UuidInterface;

/**
 * Interface BonusRepositoryInterface
 * @package BountyHunter\Domain\Bounty
 */
interface BonusRepositoryInterface
{
    /**
     * @param UuidInterface $uuid
     *
     * @return BountyInterface
     * @throws BountyReturnException
     */
    public function get(UuidInterface $uuid): BountyInterface;

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

    /**
     * @param BountyInterface $bounty
     */
    public function remove(BountyInterface $bounty): void;

    /**
     * @param BountyInterface $bounty
     */
    public function save(BountyInterface $bounty): void;
}
