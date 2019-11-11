<?php

declare(strict_types=1);

namespace BountyHunter\Domain\Bounty\Generator;


/**
 * Class GiftBountyGenerator
 * @package BountyHunter\Domain\Bounty\Generator
 */
class GiftBountyGenerator implements BountyGeneratorInterface
{
    /**
     * @return int
     */
    public function generate(): int
    {
        try {
            return \random_int(10, 200);
        } catch (\Exception $exception) {

            //TODO throw custom exception !!
        }
    }
}
