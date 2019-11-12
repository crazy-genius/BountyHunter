<?php

declare(strict_types=1);

namespace BountyHunter\Domain\Bounty\Generator;

use BountyHunter\Domain\Bounty\AllowedBountyTypesProviderInterface;
use BountyHunter\Domain\Bounty\BountyFactory;
use BountyHunter\Domain\Bounty\Entity\BountyInterface;
use BountyHunter\Domain\Bounty\UnknownBountyTypeException;

/**
 * Class BountyGeneratorInterface
 * @package BountyHunter\Domain\Bounty\Generator
 */
class BountyGenerator
{
    /**
     * @var AllowedBountyTypesProviderInterface
     */
    protected $bountyTypeProvider;

    /**
     * @var BountyFactory
     */
    private $bountyFactory;

    /**
     * BountyGenerator constructor.
     *
     * @param AllowedBountyTypesProviderInterface $bountyTypeProvider
     * @param BountyFactory $bountyFactory
     */
    public function __construct(AllowedBountyTypesProviderInterface $bountyTypeProvider, BountyFactory $bountyFactory)
    {
        $this->bountyTypeProvider = $bountyTypeProvider;
        $this->bountyFactory = $bountyFactory;
    }

    /**
     * @return BountyInterface
     * @throws CouldNotGenerateBountyException
     * @throws NoMoreBountyException
     */
    public function generate(): BountyInterface
    {
        $bountyTypes = $this->bountyTypeProvider->provide();

        if (empty($bountyTypes)) {
            throw new NoMoreBountyException();
        }

        $type = $bountyTypes[\array_rand($bountyTypes, 1)];

        try {
            return $this->bountyFactory->create($type);
        } catch (UnknownBountyTypeException $e) {
            throw new CouldNotGenerateBountyException($e);
        }
    }
}
