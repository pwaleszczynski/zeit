<?php

declare(strict_types=1);

namespace Domain\ValueObject;

use Domain\Exception\VehicleDomainException;

final class VehicleBrand
{
    private const MAX_LENGTH = 60;

    private readonly string $brand;

    public function __construct(
        string $brand,
    ) {
        if (empty($brand) || \mb_strlen($brand) > self::MAX_LENGTH) {
            throw new VehicleDomainException('Invalid vehicle brand');
        }
        $this->brand = $brand;
    }

    public static function fromString(string $brand): self
    {
        return new self($brand);
    }

    public function toString(): string
    {
        return $this->brand;
    }
}
