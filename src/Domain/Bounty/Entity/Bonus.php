<?php

declare(strict_types=1);

namespace BountyHunter\Domain;

/**
 * Class Bonus
 * @package BountyHunter\Domain
 */
class Bonus implements BountyInterface
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
        $this->amount = $amount;
    }

    public function type(): BountyType
    {
        // TODO: Implement type() method.
    }

    public function isAccepted(): bool
    {
        // TODO: Implement isAccepted() method.
    }

    public function isSent(): bool
    {
        // TODO: Implement isSent() method.
    }
}
