<?php

declare(strict_types=1);

namespace BountyHunter\Domain\Bounty;

/**
 * Interface AllowedBountyTypesProviderInterface
 * @package BountyHunter\Domain\Bounty
 */
interface AllowedBountyTypesProviderInterface
{
    /**
     * @return BountyType[]
     */
    public function provide(): array;
}