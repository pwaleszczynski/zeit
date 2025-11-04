<?php

namespace Domain\Service;

use Application\Repository\VehicleListRepositoryInterface;

class VehiclesBuilder
{
    public function __construct(
        private readonly VehicleListRepositoryInterface $vehicleListRepository,
    ) {
    }

    public function getList(): VehicleDTOCollection
    {
        return $this->vehicleListRepository->getList();
    }
}
