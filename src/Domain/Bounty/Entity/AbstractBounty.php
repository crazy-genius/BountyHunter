<?php

declare(strict_types=1);

namespace BountyHunter\Domain\Bounty\Entity;

use BountyHunter\Domain\User\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * Class AbstractBounty
 * @package BountyHunter\Domain\Bounty\Entity
 * @ORM\Entity()
 * @ORM\Table(name="bounty")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name = "discr", type = "string")
 * @ORM\DiscriminatorMap({
 *     "BONUS" = "BountyHunter\Domain\Bounty\Entity\Bonus",
 *     "MONEY" = "BountyHunter\Domain\Bounty\Entity\Money",
 *     "GIFT" = "BountyHunter\Domain\Bounty\Entity\Gift",
 * })
 */
abstract class AbstractBounty implements BountyInterface
{
    /**
     * @var UuidInterface
     * @ORM\Id()
     * @ORM\Column(name="id", type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="NONE")
     */
    protected $id;

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
     * @var User
     * @ORM\ManyToOne(targetEntity="BountyHunter\Domain\User\Entity\User")
     * @ORM\JoinColumn(name="owner", referencedColumnName="id")
     */
    protected $owner;

    /**
     * AbstractBounty constructor.
     *
     * @param User $owner
     */
    public function __construct(User $owner)
    {
        $this->id = Uuid::uuid4();
        $this->refused = false;
        $this->sent = false;
        $this->owner = $owner;
    }

    /** @inheritDoc */
    public function __toString(): string
    {
        return 'The bounty is ' . $this->type();
    }

    /**
     * @return UuidInterface
     */
    public function getId(): UuidInterface
    {
        return $this->id;
    }

    /** @inheritDoc */
    public function refuse(): void
    {
        $this->refused = true;
    }

    /**
     * @inheritDoc
     */
    public function send(): void
    {
        $this->sent = true;
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
