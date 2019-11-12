<?php

declare(strict_types=1);

namespace BountyHunter\Domain\Bounty\Entity;

use BountyHunter\Domain\Bounty\BountyType;
use BountyHunter\Domain\User\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Money
 * @package BountyHunter\Domain\Bounty\Entity
 * @ORM\Entity()
 */
class Money extends AbstractBounty
{
    /** @var int */
    private $amount;

    /**
     * Money constructor.
     *
     * @param User $owner
     * @param int $amount
     */
    public function __construct(User $owner, int $amount)
    {
        parent::__construct($owner);
        $this->amount = $amount;
    }

    /** @inheritDoc */
    public function __toString(): string
    {
        return parent::__toString() . ' amount is ' . $this->amount . ' {that currency which you like}';
    }

    /** @inheritDoc */
    public function type(): BountyType
    {
        return BountyType::createMoneyType();
    }
}
