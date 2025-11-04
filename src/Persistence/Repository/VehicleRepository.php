<?php

namespace Persistence\Repository;

use App\SQLiteConnection;
use DateTimeImmutable;
use Domain\Entity\Vehicle;
use Domain\Exception\VehicleNotFoundException;
use Domain\Repository\VehicleRepositoryInterface;
use Domain\ValueObject\VehicleBrand;
use Domain\ValueObject\VehicleId;
use Domain\ValueObject\VehicleModel;
use Domain\ValueObject\VehicleRegistrationNumber;
use Domain\ValueObject\VehicleType;

class VehicleRepository implements VehicleRepositoryInterface
{
    private \PDO $pdo;

    public function __construct()
    {
        $this->pdo = (new SQLiteConnection())->connect();
    }

    public function getById(VehicleId $id): Vehicle
    {
        $stmt = $this->pdo->prepare("SELECT * FROM vehicles WHERE id=?");
        $stmt->execute([$id->toInteger()]);
        $row = $stmt->fetch();

        if (false === $row) {
            throw new VehicleNotFoundException();
        }

        return $this->rowToEntity($row);
    }

    public function exists(VehicleId $id): bool
    {
        $stmt = $this->pdo->prepare("SELECT * FROM vehicles WHERE id=?");
        $stmt->execute([$id->toInteger()]);
        $row = $stmt->fetch();

        if (false === $row) {
            return false;
        }

        return true;
    }

    public function deleteById(VehicleId $id): void
    {
        $this->pdo->prepare("DELETE FROM vehicles WHERE id=?")->execute([$id->toInteger()]);
    }

    public function persist(Vehicle $vehicle): Vehicle
    {
        if (\is_null($vehicle->getId())) {
            return $this->create($vehicle);
        }

        return $this->update($vehicle);
    }

    private function create(Vehicle $vehicle): Vehicle
    {
        $sql =
            "INSERT INTO vehicles "
            ." (registration_number,brand,model,`type`,created_at,updated_at)"
            ." VALUES (:registrationNumber,:brand,:model,:type,:createdAt,:updatedAt)";
        $stmt= $this->pdo->prepare($sql);
        $stmt->execute([
            'registrationNumber' => $vehicle->getRegistrationNumber()->toString(),
            'brand' => $vehicle->getBrand()->toString(),
            'model' => $vehicle->getModel()->toString(),
            'type' => $vehicle->getType()->value,
            'createdAt' => $vehicle->getCreatedAt()->getTimestamp(),
            'updatedAt' => $vehicle->getUpdatedAt()->getTimestamp(),
        ]);

        $vehicle->setId(VehicleId::fromInt(
            (int) $this->pdo->lastInsertId(),
        ));

        return $vehicle;
    }

    private function update(Vehicle $vehicle): Vehicle
    {
        $sql = "UPDATE vehicles
                SET registration_number=:registrationNumber, brand=:brand, model=:model, `type`=:type, updated_at=:updatedAt  
                WHERE id=:id";
        $stmt= $this->pdo->prepare($sql);
        $stmt->execute([
            'registrationNumber' => $vehicle->getRegistrationNumber()->toString(),
            'brand' => $vehicle->getBrand()->toString(),
            'model' => $vehicle->getModel()->toString(),
            'type' => $vehicle->getType()->value,
            'updatedAt' => $vehicle->getUpdatedAt()->getTimestamp(),
            'id' => $vehicle->getId()->toInteger(),
        ]);

        return $vehicle;
    }

    private function rowToEntity(array $row): Vehicle
    {
        $vehicle =  new Vehicle(
            registrationNumber: VehicleRegistrationNumber::fromString($row['registration_number']),
            brand: VehicleBrand::fromString($row['brand']),
            model: VehicleModel::fromString($row['model']),
            type: VehicleType::from($row['type']),
            createdAt: (new DateTimeImmutable())->setTimestamp($row['created_at']),
            updatedAt: (new DateTimeImmutable())->setTimestamp($row['updated_at']),
        );

        $vehicle->setId(VehicleId::fromInt($row['id']));

        return $vehicle;
    }
}
