<?php

declare(strict_types=1);

namespace Domain\ValueObject;

enum VehicleType: string
{
    case BUS = 'bus';
    case PASSENGER = 'passenger';
    case TRUCK = 'truck';
}
