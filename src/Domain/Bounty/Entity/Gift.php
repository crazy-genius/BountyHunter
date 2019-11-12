<?php

declare(strict_types=1);

namespace BountyHunter\Domain\Bounty\Entity;

use BountyHunter\Domain\Bounty\BountyType;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Gift
 * @package BountyHunter\Domain\Bounty\Entity
 * @ORM\Entity()
 */
class Gift extends AbstractBounty
{
    /** @inheritDoc */
    public function type(): BountyType
    {
        return BountyType::createGiftType();
    }
}
