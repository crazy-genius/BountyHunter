<?php

declare(strict_types=1);

namespace BountyHunter\UI\Web\Bounty\Controller;

use BountyHunter\Domain\Bounty\BonusRepositoryInterface;
use BountyHunter\Domain\Bounty\Generator\BountyGenerator;
use BountyHunter\Domain\Bounty\Generator\CouldNotGenerateBountyException;
use BountyHunter\Domain\Bounty\Generator\NoMoreBountyException;
use BountyHunter\Domain\Bounty\Specification\ByOwnerSpecification;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * Class BountyController
 * @package BountyHunter\UI\Web\Bounty\Controller
 * @Route("/", name="bounty")
 */
class BountyController
{
    /** @var BonusRepositoryInterface */
    private $bountyRepository;
    /** @var Security $security */
    private $security;

    /**
     * BountyController constructor.
     *
     * @param BonusRepositoryInterface $bountyRepository
     * @param Security $security
     */
    public function __construct(BonusRepositoryInterface $bountyRepository, Security $security)
    {
        $this->bountyRepository = $bountyRepository;
        $this->security = $security;
    }

    /**
     * @Route("/", name="get_bounty")
     * @param BountyGenerator $bountyGenerator
     *
     * @return Response
     */
    public function getBounty(BountyGenerator $bountyGenerator): Response
    {
        $currentUser = $this->security->getUser();

        if ($currentUser === null) {
            return new Response('No user found', Response::HTTP_NOT_FOUND);
        }

        $bounties = $this->bountyRepository->match(new ByOwnerSpecification($currentUser));

        if (!empty($bounties)) {
            return new Response('You already has bounty!' . '<br>' . \array_pop($bounties));
        }

        try {
            $bounty = $bountyGenerator->generate();
        } catch (CouldNotGenerateBountyException $e) {
            return new Response('Something goes wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (NoMoreBountyException $e) {
            return new Response($e->getMessage(), Response::HTTP_NOT_FOUND);
        }

        $this->bountyRepository->add($bounty);

        return new Response('You got bounty!' . '<br>' . $bounty);
    }
}
