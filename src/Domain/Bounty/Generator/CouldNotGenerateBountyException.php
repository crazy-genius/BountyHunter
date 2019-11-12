<?php

declare(strict_types=1);

namespace BountyHunter\Domain\Bounty\Generator;

use Throwable;

/**
 * Class CouldNotGenerateBountyException
 * @package BountyHunter\Domain\Bounty\Generator
 */
class CouldNotGenerateBountyException extends \Exception
{
    public function __construct(Throwable $previous = null)
    {
        parent::__construct('CouldNotGenerateBounty', 500, $previous);
    }
}
