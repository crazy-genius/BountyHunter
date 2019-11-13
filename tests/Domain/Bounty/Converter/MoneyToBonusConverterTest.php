<?php

declare(strict_types=1);

namespace BountyHunter\Domain\Bounty\Converter;

use PHPUnit\Framework\TestCase;

/**
 * Class MoneyToBonusConvectorTest
 * @package BountyHunter\Domain\Bounty\Convector
 */
class MoneyToBonusConvectorTest extends TestCase
{
    public function testConvert()
    {
        $convertor = new MoneyToBonusConverter();

    }
}
