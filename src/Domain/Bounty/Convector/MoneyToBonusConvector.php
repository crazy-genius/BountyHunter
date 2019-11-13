<?php

declare(strict_types=1);

namespace BountyHunter\Domain\Bounty\Convector;

use BountyHunter\Domain\Bounty\Entity\Bonus;
use BountyHunter\Domain\Bounty\Entity\Money;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

/**
 * Class MoneyToBonusConvector
 * @package BountyHunter\Domain\Bounty\Convector
 */
class MoneyToBonusConvector
{
    /** @var float */
    private $coefficient;
    /** @var EntityManager */
    private $entityManger;

    /**
     * @param Money $money
     *
     * @return Bonus
     * @throws ConvectorException
     */
    public function convert(Money $money): Bonus
    {
        if ($money->isSent() || $money->isRefused()) {
            throw new ConvectorException('You can\'t convert already sanded or refused bonus', 400);
        }

        $bonus = $money->toBonus($this->coefficient);

        $money->refuse();
        try {
            $this->entityManger->persist($money);
        } catch (ORMException $e) {
            throw new ConvectorException('Can\'t convert', 500, $e);
        }

        try {
            $this->entityManger->flush($money);
        } catch (OptimisticLockException|ORMException $e) {
            throw new ConvectorException('Can\'t convert', 500, $e);
        }

        return $bonus;
    }
}
