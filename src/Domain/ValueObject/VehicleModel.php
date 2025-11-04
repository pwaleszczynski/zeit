<?php

declare(strict_types=1);

namespace Domain\ValueObject;

use Domain\Exception\VehicleDomainException;

final class VehicleModel
{
    private const MAX_LENGTH = 60;

    private readonly string $model;

    public function __construct(
        string $model,
    ) {
        if (empty($model) || \mb_strlen($model) > self::MAX_LENGTH) {
            throw new VehicleDomainException('Invalid vehicle model');
        }
        $this->model = $model;
    }

    public static function fromString(string $model): self
    {
        return new self($model);
    }

    public function toString(): string
    {
        return $this->model;
    }
}
