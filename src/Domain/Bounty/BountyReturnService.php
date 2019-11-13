<?php

declare(strict_types=1);

namespace BountyHunter\Domain\Bounty;

use BountyHunter\Domain\Bounty\Entity\BountyInterface;

/**
 * Class BountyReturnService
 * @package BountyHunter\Domain\Bounty
 */
class BountyReturnService
{
    /**
     * @var BonusRepositoryInterface
     */
    private $bountyRepository;

    /**
     * @param BountyInterface $bounty
     *
     * @throws BountyReturnException
     */
    public function returnBounty(BountyInterface $bounty): void
    {
        if ($bounty->isSent()) {
            throw new BountyReturnException('You can\'t return sanded bonus', 400);
        }

        if ($bounty->type()->equals(BountyType::createBonusType())) {
            //TODO do logic on bonus
        } else {
            //TODO do increase amount of amount money or increase allowed list of gifts
        }

        $this->bountyRepository->remove($bounty);
    }
}
