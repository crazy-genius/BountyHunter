<?php

declare(strict_types=1);

namespace BountyHunter\Domain\Bounty\Entity;

use BountyHunter\Domain\Bounty\BountyType;

/**
 * Class BountyInterface
 * @package BountyHunter\Domain\Bounty\Entity
 */
interface BountyInterface
{
    public function type(): BountyType;
    public function isAccepted(): bool;
    public function isSent(): bool;
}
