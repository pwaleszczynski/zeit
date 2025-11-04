<?php

namespace App\Controller;

use App\Request\SaveVehicleRequestSerializer;
use App\Request\SaveVehicleRequestToVehicleDtoMapper;
use Domain\Exception\VehicleDomainException;
use Domain\Exception\VehicleNotFoundException;
use Domain\Service\VehiclesBuilder;
use Domain\Service\VehiclesWriter;
use Persistence\Repository\VehicleListRepository;
use Persistence\Repository\VehicleRepository;
use Symfony\Component\HttpFoundation\{JsonResponse, Request, Response};

class VehicleController extends BaseController
{
    public function index(): Response
    {
        ob_start();
        include __DIR__ . '/../views/index.php';
        return (new Response(ob_get_clean()))->send();
    }

    public function list(): JsonResponse
    {
        $results = (new VehiclesBuilder(new VehicleListRepository()))->getList();

        return $this->toJsonResponse(['results' => $results->getItems()]);
    }

    public function save(?int $id, Request $request): JsonResponse
    {
        try {
            $saveVehicleRequest = SaveVehicleRequestSerializer::get($request);

            if (!$saveVehicleRequest->isValid()) {
                return $this->toJsonResponse([], Response::HTTP_BAD_REQUEST);
            }

            $vehicleDTO = SaveVehicleRequestToVehicleDtoMapper::map(
                $saveVehicleRequest,
                $id,
            );

            $writer = new VehiclesWriter(new VehicleRepository());
            $vehicleDTO = $writer->saveVehicle($vehicleDTO);

            return $this->toJsonResponse([$vehicleDTO]);
        } catch (VehicleNotFoundException $e) {
            return $this->errorResponse($e->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (VehicleDomainException $e) {
            return $this->errorResponse($e->getMessage());
        } catch (\Exception) {
            return $this->toJsonResponse([], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function delete(int $id): JsonResponse
    {
        try {
            (new VehiclesWriter(new VehicleRepository()))->deleteById($id);

            return $this->toJsonResponse([$id]);
        } catch (VehicleNotFoundException $e) {
            return $this->errorResponse($e->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (VehicleDomainException $e) {
            return $this->errorResponse($e->getMessage());
        } catch (\Exception) {
            return $this->toJsonResponse([], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
