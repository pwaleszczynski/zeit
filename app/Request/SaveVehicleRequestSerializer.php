<?php

declare(strict_types=1);

namespace App\Request;

use Symfony\Component\HttpFoundation\Request;

class SaveVehicleRequestSerializer
{
    public static function get(Request $request): SaveVehicleRequest
    {
        $stdObj=  \json_decode($request->getContent());
        $requestClass = SaveVehicleRequest::class;
        $temp = \serialize($stdObj);
        $temp = \preg_replace('@^O:8:"stdClass":@','O:'.\strlen($requestClass).':"' . $requestClass . '":', $temp);

        return \unserialize($temp);
    }
}
