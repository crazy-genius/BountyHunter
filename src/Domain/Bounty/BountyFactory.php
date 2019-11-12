<?php

declare(strict_types=1);

namespace BountyHunter\Domain\Bounty;

use BountyHunter\Domain\Bounty\Entity\Bonus;
use BountyHunter\Domain\Bounty\Entity\BountyInterface;
use BountyHunter\Domain\Bounty\Entity\Gift;
use BountyHunter\Domain\Bounty\Entity\Money;
use BountyHunter\Domain\Bounty\Generator\RandomNumberGenerator;

/**
 * Class BountyFactory
 * @package BountyHunter\Domain\Bounty
 */
class BountyFactory
{
    /**
     * @var RandomNumberGenerator
     */
    private $randomGenerator;

    /**
     * BountyFactory constructor.
     *
     * @param RandomNumberGenerator $randomGenerator
     */
    public function __construct(RandomNumberGenerator $randomGenerator)
    {
        $this->randomGenerator = $randomGenerator;
    }

    /**
     * @param BountyType $bountyType
     *
     * @return BountyInterface
     * @throws UnknownBountyTypeException
     */
    public function create(BountyType $bountyType): BountyInterface
    {
        switch (true) {
            case $bountyType->equals(BountyType::createBonusType()):
                return $this->createBonusBounty();
            case $bountyType->equals(BountyType::createMoneyType()):
                return $this->createMoneyBounty();
            case $bountyType->equals(BountyType::createGiftType()):
                return $this->createGiftBounty();
        }

        throw new UnknownBountyTypeException((string)$bountyType);
    }

    private function createMoneyBounty(): BountyInterface
    {
        return new Money($this->randomGenerator->generate(100, 900));
    }

    private function createBonusBounty(): BountyInterface
    {
        return new Bonus($this->randomGenerator->generate(200, 300));
    }

    private function createGiftBounty(): BountyInterface
    {
        return new Gift();
    }
}
