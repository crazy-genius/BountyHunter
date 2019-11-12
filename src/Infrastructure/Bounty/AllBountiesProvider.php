<?php

declare(strict_types=1);

namespace BountyHunter\Infrastructure\Bounty;

use BountyHunter\Domain\Bounty\AllowedBountyTypesProviderInterface;
use BountyHunter\Domain\Bounty\BountyType;

/**
 * Class AllBountiesProvider
 */
class AllBountiesProvider implements AllowedBountyTypesProviderInterface
{
    /** @inheritDoc */
    public function provide(): array
    {
        return [
            BountyType::createMoneyType(),
            BountyType::createBonusType(),
            BountyType::createGiftType(),
        ];
    }
}
