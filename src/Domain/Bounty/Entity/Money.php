<?php

declare(strict_types=1);

namespace BountyHunter\Domain;

/**
 * Class Money
 * @package BountyHunter\Domain
 */
class Money implements BountyInterface
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
        $this->amount = $amount;
        $this->type = BountyType::createMoneyType();
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
