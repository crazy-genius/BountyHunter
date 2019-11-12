<?php

declare(strict_types=1);

namespace BountyHunter\Domain\Bounty\Entity;

use BountyHunter\Domain\Bounty\BountyType;

/**
 * Class Bonus
 * @package BountyHunter\Domain\Bounty\Entity
 */
class Bonus extends AbstractBounty
{
    /** @var int */
    private $amount;

    /**
     * Bonus constructor.
     *
     * @param int $amount
     */
    public function __construct(int $amount)
    {
        parent::__construct();
        $this->amount = $amount;
    }

    /** @inheritDoc */
    public function __toString(): string
    {
        return parent::__toString() . ' amount is ' . $this->amount;
    }

    /** @inheritDoc */
    public function type(): BountyType
    {
        return BountyType::createBonusType();
    }
}
