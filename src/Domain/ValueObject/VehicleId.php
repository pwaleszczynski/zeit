<?php

declare(strict_types=1);

namespace Domain\ValueObject;

use Domain\Exception\VehicleDomainException;

final class VehicleId
{
    private readonly int $id;

    public function __construct(
        int $id,
    ) {
        if ($id <= 0) {
            throw new VehicleDomainException('Invalid vehicle id');
        }

        $this->id = $id;
    }

    public static function fromInt(int $id): self
    {
        return new self($id);
    }

    public function toInteger(): int
    {
        return $this->id;
    }
}
