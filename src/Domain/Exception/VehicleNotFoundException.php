<?php

declare(strict_types=1);

namespace Domain\Exception;

use DomainException;

final class VehicleNotFoundException extends DomainException
{
    protected $message = 'Vehicle not found.';
}
