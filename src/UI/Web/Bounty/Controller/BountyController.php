<?php

declare(strict_types=1);

namespace BountyHunter\UI\Web\Bounty\Controller;

use BountyHunter\Domain\Bounty\BonusRepositoryInterface;
use BountyHunter\Domain\Bounty\BountyReturnException;
use BountyHunter\Domain\Bounty\BountyReturnService;
use BountyHunter\Domain\Bounty\Generator\BountyGenerator;
use BountyHunter\Domain\Bounty\Generator\CouldNotGenerateBountyException;
use BountyHunter\Domain\Bounty\Generator\NoMoreBountyException;
use BountyHunter\Domain\Bounty\Specification\ByOwnerSpecification;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class BountyController
 * @package BountyHunter\UI\Web\Bounty\Controller
 * @Route("/", name="bounty")
 */
class BountyController extends AbstractController
{
    /** @var BonusRepositoryInterface */
    private $bountyRepository;
    /** @var BountyReturnService */
    private $bountyReturnService;

    /** @var Security $security */
    private $security;

    /**
     * BountyController constructor.
     *
     * @param BonusRepositoryInterface $bountyRepository
     * @param Security $security
     * @param BountyReturnService $bountyReturnService
     */
    public function __construct(
        BonusRepositoryInterface $bountyRepository,
        Security $security,
        BountyReturnService $bountyReturnService
    ) {
        $this->bountyRepository = $bountyRepository;
        $this->security = $security;
        $this->bountyReturnService = $bountyReturnService;
    }

    /**
     * @Route("/", name="hello_bounty_hunter")
     * @return Response
     */
    public function greeting(): Response
    {
        $currentUser = $this->security->getUser();

        if ($currentUser === null) {
            return new Response('No user found', Response::HTTP_NOT_FOUND);
        }

        $bounties = $this->bountyRepository->match(new ByOwnerSpecification($currentUser));

        if (!empty($bounties)) {
            return $this->render('bounty/already_exists.html.twig', ['bounty' => \array_pop($bounties)]);
        }

        return $this->render('bounty/hello.html.twig', []);
    }

    /**
     * @Route("/bounty/get", name="get_bounty")
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
            return new Response('You already has bounty!', 400);
        }

        try {
            $bounty = $bountyGenerator->generate();
        } catch (CouldNotGenerateBountyException $e) {
            return new Response('Something goes wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (NoMoreBountyException $e) {
            return new Response($e->getMessage(), Response::HTTP_NOT_FOUND);
        }

        $this->bountyRepository->save($bounty);

        return $this->render('bounty/new.html.twig', ['bounty' => $bounty]);
    }

    /**
     * @Route("/bounty/refuse/{bountyCode}", name="refuse_bounty")
     * @param string $bountyCode
     *
     * @return Response
     */
    public function refuseBounty(string $bountyCode): Response
    {
        if (empty($bountyCode)) {
            return new Response('No bounty code provided', 400);
        }

        try {
            $bounty = $this->bountyRepository->get(Uuid::fromString($bountyCode));
        } catch (BountyReturnException $e) {
            //TODO make logic to decide status code
            return new Response('No bounty found', 404);
        }

        try {
            $this->bountyReturnService->returnBounty($bounty);
        } catch (BountyReturnException $e) {
            return new Response('Could\'t reject bounty', 500);
        }

        return new RedirectResponse('/');
    }
}
