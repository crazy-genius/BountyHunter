<?php

declare(strict_types=1);

namespace BountyHunter\Domain\Bounty\Converter;

use BountyHunter\Domain\Bounty\Entity\Bonus;
use BountyHunter\Domain\Bounty\Entity\Money;
use BountyHunter\Domain\Money\RefundService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

/**
 * Class MoneyToBonusConvector
 * @package BountyHunter\Domain\Bounty\Convector
 */
class MoneyToBonusConverter
{
    /** @var float */
    private $coefficient;
    /** @var EntityManagerInterface */
    private $entityManger;
    /** @var RefundService */
    private $moneyRefund;

    /**
     * MoneyToBonusConvector constructor.
     *
     * @param float $coefficient
     * @param EntityManagerInterface $entityManger
     * @param RefundService $moneyRefund
     */
    public function __construct(float $coefficient, EntityManagerInterface $entityManger, RefundService $moneyRefund)
    {
        $this->coefficient = $coefficient;
        $this->entityManger = $entityManger;
        $this->moneyRefund = $moneyRefund;
    }

    /**
     * @param Money $money
     *
     * @return Bonus
     * @throws ConverterException
     */
    public function convert(Money $money): Bonus
    {
        if ($money->isSent() || $money->isRefused()) {
            throw new ConverterException('You can\'t convert already sanded or refused bonus', 400);
        }

        $bonus = $money->toBonus($this->coefficient);
        $money->refuse();

        try {
            $this->entityManger->persist($money);
        } catch (ORMException $e) {
            throw new ConverterException('Can\'t convert', 500, $e);
        }

        try {
            $this->entityManger->flush($money);
        } catch (OptimisticLockException|ORMException $e) {
            throw new ConverterException('Can\'t convert', 500, $e);
        }

        $this->moneyRefund->refund($money->amount());

        return $bonus;
    }
}
