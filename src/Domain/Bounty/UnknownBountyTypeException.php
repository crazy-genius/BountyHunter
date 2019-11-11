<?php

declare(strict_types=1);

namespace BountyHunter\Domain;

use Throwable;

/**
 * Class UnknownBountyTypeException
 * @package BountyHunter\Domain
 */
class UnknownBountyTypeException extends \Exception
{
    /**
     * UnknownBountyTypeException constructor.
     *
     * @param string $unknownType
     * @param Throwable|null $previous
     */
    public function __construct(string $unknownType, Throwable $previous = null)
    {
        parent::__construct("Type {$unknownType} is unknown", 0, $previous);
    }
}
