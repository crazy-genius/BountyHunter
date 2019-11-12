<?php

declare(strict_types=1);

namespace BountyHunter\Domain\Bounty;

use BountyHunter\Domain\Bounty\Entity\Bonus;
use BountyHunter\Domain\Bounty\Entity\BountyInterface;
use BountyHunter\Domain\Bounty\Entity\Gift;
use BountyHunter\Domain\Bounty\Entity\Money;
use BountyHunter\Domain\Bounty\Generator\BountyGeneratorInterface;

/**
 * Class BountyFactory
 * @package BountyHunter\Domain\Bounty
 */
class BountyFactory
{
    /** @var BountyGeneratorInterface */
    private $moneyGenerator;

    /**
     * @var BountyGeneratorInterface
     */
    private $giftGenerator;

    /**
     * @var BountyGeneratorInterface
     */
    private $bonusGenerator;

    public function createMoneyBounty(): BountyInterface
    {
        return new Money($this->moneyGenerator->generate());
    }

    public function createBonusBounty(): BountyInterface
    {
        return new Bonus($this->bonusGenerator->generate());
    }

    public function createGiftBounty(): BountyInterface
    {
        return new Gift();
    }
}
