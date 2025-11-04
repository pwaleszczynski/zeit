<?php

declare(strict_types=1);

namespace Domain\Service;

use Shared\TypedCollection;

final class VehicleDTOCollection extends TypedCollection
{
    protected function getType(): string
    {
        return VehicleDTO::class;
    }
}
