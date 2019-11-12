<?php

declare(strict_types=1);

namespace BountyHunter\Domain\Bounty\Entity;

use BountyHunter\Domain\Bounty\BountyType;

/**
 * Class Money
 * @package BountyHunter\Domain\Bounty\Entity
 */
class Money extends AbstractBounty
{
    /** @var int */
    private $amount;

    /**
     * Money constructor.
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
        return parent::__toString() . ' amount is ' . $this->amount . ' {that currency which you like}';
    }

    /** @inheritDoc */
    public function type(): BountyType
    {
        return BountyType::createMoneyType();
    }
}
