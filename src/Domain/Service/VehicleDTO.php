<?php

namespace Domain\Service;

use DateTimeImmutable;
use Domain\ValueObject\VehicleId;
use JetBrains\PhpStorm\Internal\TentativeType;
use JsonSerializable;

class VehicleDTO implements JsonSerializable
{
    public function __construct(
    public string $registrationNumber,
    public string $brand,
    public string $model,
    public string $type,
    public ?int $id = null,
    public ?DateTimeImmutable $createdAt = null,
    public ?DateTimeImmutable $updatedAt = null,
    ) {
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'registrationNumber' => $this->registrationNumber,
            'brand' => $this->brand,
            'model' => $this->model,
            'type' => $this->type,
            'createdAt' => $this->createdAt instanceof DateTimeImmutable ? $this->createdAt->format('Y-m-d H:i'): null,
            'updatedAt' => $this->updatedAt instanceof DateTimeImmutable ? $this->updatedAt->format('Y-m-d H:i'): null,
        ];
    }
}
