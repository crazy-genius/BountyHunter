<?php

declare(strict_types=1);

namespace BountyHunter\Domain\Money;

/**
 * Class RefundService
 * @package BountyHunter\Domain\Money
 */
class RefundService
{
    /**
     * @param int $amount
     */
    public function refund(int $amount): void
    {
        //TODO up amount of money allowed for bonus
    }
}
