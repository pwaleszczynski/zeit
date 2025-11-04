<?php

declare(strict_types=1);

namespace App\Request;

final class SaveVehicleRequest
{
    public $registrationNumber;
    public $brand;
    public $model;
    public $type;

    public function isValid(): bool
    {
        $fields = [
            $this->registrationNumber,
            $this->brand,
            $this->model,
            $this->type,
        ];

        foreach ($fields as $field) {
            if (empty($field) || !\is_string($field)) {
                return false;
            }
        }

        return true;
    }
}
