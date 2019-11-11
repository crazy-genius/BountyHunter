<?php

declare(strict_types=1);

namespace BountyHunter\Domain\Bounty\Generator;

/**
 * Class MoneyBountyGenerator
 * @package BountyHunter\Domain\Bounty\Generator
 */
class MoneyBountyGenerator implements BountyGeneratorInterface
{
    /** @var int */
    private $min;
    /** @var int */
    private $max;

    /**
     * MoneyBountyGenerator constructor.
     *
     * @param int $min
     * @param int $max
     */
    public function __construct(int $min, int $max)
    {
        $this->min = $min;
        $this->max = $max;
    }

    /**
     * @return int
     */
    public function generate(): int
    {
        try {
            return \random_int($this->min, $this->max);
        } catch (\Exception $exception) {
            //TODO throw custom exception !!
        }
    }
}
