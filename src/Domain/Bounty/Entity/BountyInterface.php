<?php

declare(strict_types=1);

namespace BountyHunter\Domain;

/**
 * Class BountyInterface
 * @package BountyHunter\Domain
 */
interface BountyInterface
{
    public function type(): BountyType;
    public function isAccepted(): bool;
    public function isSent(): bool;
}
