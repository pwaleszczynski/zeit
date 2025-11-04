<?php

namespace Domain\Repository;

use Domain\Entity\Vehicle;
use Domain\ValueObject\VehicleId;

interface VehicleRepositoryInterface
{
    public function getById(VehicleId $id): Vehicle;

    public function exists(VehicleId $id): bool;

    public function deleteById(VehicleId $id): void;

    public function persist(Vehicle $vehicle): Vehicle;
}
