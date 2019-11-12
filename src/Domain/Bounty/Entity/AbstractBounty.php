<?php

declare(strict_types=1);

namespace BountyHunter\Domain\Bounty\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class AbstractBounty
 * @package BountyHunter\Domain\Bounty\Entity
 * @ORM\MappedSuperclass()
 */
abstract class AbstractBounty implements BountyInterface
{
    /**
     * @var bool
     * @ORM\Column(name="refused", type="boolean")
     */
    protected $refused;

    /**
     * @var bool
     * @ORM\Column(name="sent", type="boolean")
     */
    protected $sent;

    /**
     * AbstractBounty constructor.
     */
    public function __construct()
    {
        $this->refused = false;
        $this->sent = false;
    }

    /** @inheritDoc */
    public function __toString(): string
    {
        return 'The bounty is ' . $this->type();
    }

    /** @inheritDoc */
    public function isRefused(): bool
    {
        return $this->refused;
    }

    /** @inheritDoc */
    public function isSent(): bool
    {
        return $this->sent;
    }
}
