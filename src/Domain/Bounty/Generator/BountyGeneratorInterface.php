<?php

declare(strict_types=1);

namespace BountyHunter\Domain\Bounty\Generator;

/**
 * Interface BountyGeneratorInterface
 * @package BountyHunter\Domain\Bounty\Generator
 */
interface BountyGeneratorInterface
{
    public function generate(): int;
}
