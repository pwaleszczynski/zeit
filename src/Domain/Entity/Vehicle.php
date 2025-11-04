<?php

namespace Domain\Entity;

use DateTimeImmutable;
use Domain\ValueObject\VehicleBrand;
use Domain\ValueObject\VehicleId;
use Domain\ValueObject\VehicleModel;
use Domain\ValueObject\VehicleRegistrationNumber;
use Domain\ValueObject\VehicleType;
use Psr\Clock\ClockInterface;

final class Vehicle
{
    private ?VehicleId $id = null;

    public function __construct(
        private VehicleRegistrationNumber $registrationNumber,
        private VehicleBrand $brand,
        private VehicleModel $model,
        private VehicleType $type,
        private readonly DateTimeImmutable $createdAt,
        private DateTimeImmutable $updatedAt,
    ) {
    }

    public static function create(
        VehicleRegistrationNumber $registrationNumber,
        VehicleBrand $brand,
        VehicleModel $model,
        VehicleType $type,
        ClockInterface $clock,
    ): self {
        return new self(
            registrationNumber: $registrationNumber,
            brand: $brand,
            model: $model,
            type: $type,
            createdAt: $clock->now(),
            updatedAt: $clock->now(),
        );
    }

    public function update(
        VehicleRegistrationNumber $registrationNumber,
        VehicleBrand $brand,
        VehicleModel $model,
        VehicleType $type,
        ClockInterface $clock,
    ): void {
        $this->registrationNumber = $registrationNumber;
        $this->brand = $brand;
        $this->model = $model;
        $this->type = $type;
        $this->updatedAt = $clock->now();
    }

    public function setId(VehicleId $id): void
    {
        if (\is_null($this->id)) {
            $this->id = $id;
        }
    }

    public function getId(): ?VehicleId
    {
        return $this->id;
    }

    public function getRegistrationNumber(): VehicleRegistrationNumber
    {
        return $this->registrationNumber;
    }

    public function getBrand(): VehicleBrand
    {
        return $this->brand;
    }

    public function getModel(): VehicleModel
    {
        return $this->model;
    }

    public function getType(): VehicleType
    {
        return $this->type;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
