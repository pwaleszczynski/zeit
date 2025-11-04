<?php

namespace Domain\Service;

use Domain\Entity\Vehicle;
use Domain\Exception\VehicleDomainException;
use Domain\Exception\VehicleNotFoundException;
use Domain\Repository\VehicleRepositoryInterface;
use Domain\ValueObject\VehicleBrand;
use Domain\ValueObject\VehicleId;
use Domain\ValueObject\VehicleModel;
use Domain\ValueObject\VehicleRegistrationNumber;
use Domain\ValueObject\VehicleType;
use Shared\Clock;

class VehiclesWriter
{
    public function __construct(
        private readonly VehicleRepositoryInterface $vehicleRepository,
    ) {
    }

    public function saveVehicle(VehicleDTO $vehicleDTO): VehicleDTO
    {
        $vehicle = $this->getVehicleEntity($vehicleDTO);
        $vehicle = $this->vehicleRepository->persist($vehicle);
        $vehicleDTO->id = $vehicle->getId()->toInteger();
        $vehicleDTO->createdAt = $vehicle->getCreatedAt();
        $vehicleDTO->updatedAt = $vehicle->getUpdatedAt();

        return $vehicleDTO;
    }

    public function deleteById(int $id)
    {
        $vehicleId = VehicleId::fromInt($id);

        if (false === $this->vehicleRepository->exists($vehicleId)) {
            throw new VehicleNotFoundException();
        }

        $this->vehicleRepository->deleteById($vehicleId);
    }

    private function getVehicleEntity(VehicleDTO $vehicleDTO): Vehicle
    {
        $clock = new Clock();
        $registrationNumber = VehicleRegistrationNumber::fromString($vehicleDTO->registrationNumber);
        $brand = VehicleBrand::fromString($vehicleDTO->brand);
        $model = VehicleModel::fromString($vehicleDTO->model);
        $type = VehicleType::tryFrom($vehicleDTO->type);

        if (\is_null($type)) {
            throw new VehicleDomainException('Invalid vehicle type.');
        }

        if (\is_null($vehicleDTO->id)) {
            return Vehicle::create(
                $registrationNumber,
                $brand,
                $model,
                $type,
                $clock,
            );
        }

        $id = VehicleId::fromInt($vehicleDTO->id);
        $vehicle = $this->vehicleRepository->getById($id);
        $vehicle->update(
            $registrationNumber,
            $brand,
            $model,
            $type,
            $clock,
        );

        return $vehicle;
    }
}
