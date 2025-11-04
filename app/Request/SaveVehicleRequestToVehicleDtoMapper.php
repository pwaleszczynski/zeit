<?php

declare(strict_types=1);

namespace App\Request;

use Domain\Service\VehicleDTO;
use Psr\Clock\ClockInterface;

class SaveVehicleRequestToVehicleDtoMapper
{
    public static function map(
        SaveVehicleRequest $request,
        ?int $id,
    ): VehicleDTO {
        return new VehicleDTO(
            $request->registrationNumber,
            $request->brand,
            $request->model,
            $request->type,
            $id,
        );
    }
}
