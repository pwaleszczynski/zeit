<?php

declare(strict_types=1);

namespace Domain\ValueObject;

use Domain\Exception\VehicleDomainException;

final class VehicleRegistrationNumber
{
    private const MAX_LENGTH = 16;

    private readonly string $registrationNumber;

    public function __construct(
        string $registrationNumber,
    ) {
        if (!preg_match('/^[A-Z0-9]+$/', $registrationNumber) || \mb_strlen($registrationNumber) > self::MAX_LENGTH) {
            throw new VehicleDomainException('Invalid vehicle registration number');
        }
        $this->registrationNumber = $registrationNumber;
    }

    public static function fromString(string $registrationNumber): self
    {
        return new self($registrationNumber);
    }

    public function toString(): string
    {
        return $this->registrationNumber;
    }
}
