<?php

declare(strict_types=1);

namespace BountyHunter\Domain\Bounty\Generator;

use Throwable;

/**
 * Class NoMoreBountyException
 * @package BountyHunter\Domain\Bounty\Generator
 */
class NoMoreBountyException extends \Exception
{
    public function __construct(Throwable $previous = null)
    {
        parent::__construct('Sorry but no more bounty', 404, $previous);
    }

}
