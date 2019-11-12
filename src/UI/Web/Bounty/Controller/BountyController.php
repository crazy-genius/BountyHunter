<?php

declare(strict_types=1);

namespace BountyHunter\UI\Web\Bounty\Controller;

use BountyHunter\Domain\Bounty\Generator\BountyGenerator;
use BountyHunter\Domain\Bounty\Generator\CouldNotGenerateBountyException;
use BountyHunter\Domain\Bounty\Generator\NoMoreBountyException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BountyController
 * @package BountyHunter\UI\Web\Bounty\Controller
 * @Route("/", name="bounty")
 */
class BountyController
{
    /**
     * @Route("/", name="get_bounty")
     * @param BountyGenerator $bountyGenerator
     *
     * @return Response
     */
    public function getBounty(BountyGenerator $bountyGenerator): Response
    {
        try {
            $bounty = $bountyGenerator->generate();
        } catch (CouldNotGenerateBountyException $e) {
            return new Response('Something goes wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (NoMoreBountyException $e) {
            return new Response($e->getMessage(), Response::HTTP_NOT_FOUND);
        }

        return new Response('You got bounty!' . '<br>' . $bounty);
    }
}
