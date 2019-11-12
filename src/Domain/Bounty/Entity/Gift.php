<?php

declare(strict_types=1);

namespace BountyHunter\Domain\Bounty\Entity;

use BountyHunter\Domain\Bounty\BountyType;

/**
 * Class Gift
 * @package BountyHunter\Domain\Bounty\Entity
 */
class Gift implements BountyInterface
{
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
