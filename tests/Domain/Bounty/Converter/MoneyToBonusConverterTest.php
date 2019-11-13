<?php

declare(strict_types=1);

namespace BountyHunter\Domain\Bounty\Converter;

use BountyHunter\Domain\Bounty\BountyType;
use BountyHunter\Domain\Bounty\Entity\Bonus;
use BountyHunter\Domain\Bounty\Entity\Money;
use BountyHunter\Domain\Money\RefundService;
use BountyHunter\Domain\User\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class MoneyToBonusConverterTest
 * @package BountyHunter\Domain\Bounty\Converter
 */
class MoneyToBonusConverterTest extends TestCase
{
    public function testConvert()
    {
        $ownerMock = $this->createMock(User::class);
        $money = new Money($ownerMock, 10000);

        $managerMock = $this->createMock(EntityManagerInterface::class);
        $managerMock->expects($this->once())->method('persist')->with($money);
        $managerMock->expects($this->once())->method('flush');

        $refundServiceMock = $this->createMock(RefundService::class);
        $refundServiceMock->expects($this->once())->method('refund')->with($money->amount());

        $converter = new MoneyToBonusConverter(0.5, $managerMock, $refundServiceMock);

        $bonus = $converter->convert($money);
        $this->assertEquals(BountyType::createBonusType(), $bonus->type());
        $this->assertEquals((int)($money->amount() * 0.5), $bonus->amount());
    }
}
