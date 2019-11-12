<?php

declare(strict_types=1);

namespace BountyHunter\Domain\Bounty\Generator;

/**
 * Class RandomGenerator
 * @package BountyHunter\Domain\Bounty\Generator
 */
class RandomNumberGenerator
{
    /**
     * @param int $min
     * @param int $max
     *
     * @return int
     */
    public function generate(int $min, int $max): int
    {
        try {
            return \random_int($min, $max);
        } catch (\Exception $exception) {
            //TODO throw custom exception !!
        }
    }
}
