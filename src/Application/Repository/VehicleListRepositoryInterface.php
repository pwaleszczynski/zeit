<?php

declare(strict_types=1);

namespace Application\Repository;

use Domain\Service\VehicleDTOCollection;

interface VehicleListRepositoryInterface
{
    public function getList(): VehicleDTOCollection;
}
