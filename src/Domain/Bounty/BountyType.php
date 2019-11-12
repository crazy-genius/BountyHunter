<?php

declare(strict_types=1);

namespace BountyHunter\Domain\Bounty;

/**
 * Class BountyType
 * @package BountyHunter\Domain\Bounty
 */
final class BountyType
{
    private const MONEY = 'MONEY';
    private const BONUS = 'BONUS';
    private const GIFT = 'GIFT';

    /** @var string */
    private $value;

    /**
     * BountyType constructor.
     *
     * @param string $type
     */
    private function __construct(string $type)
    {
        $this->value = $type;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->value;
    }

    /**
     * @return BountyType
     */
    public static function createMoneyType(): BountyType
    {
        return new self(self::MONEY);
    }

    /**
     * @return BountyType
     */
    public static function createBonusType(): BountyType
    {
        return new self(self::BONUS);
    }

    /**
     * @return BountyType
     */
    public static function createGiftType(): BountyType
    {
        return new self(self::GIFT);
    }

    /**
     * @param string $type
     *
     * @return BountyType
     * @throws UnknownBountyTypeException
     */
    public function fromString(string $type): BountyType
    {
        $knownMap = [
            self::MONEY,
            self::BONUS,
            self::GIFT
        ];

        if (!\in_array($this, $knownMap, true)) {
            throw new UnknownBountyTypeException($type);
        }

        return new self($type);
    }

    /**
     * @param BountyType $subject
     *
     * @return bool
     */
    public function equals(BountyType $subject): bool
    {
        return $this->value === $subject->value;
    }
}
