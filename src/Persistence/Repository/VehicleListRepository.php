<?php

declare(strict_types=1);

namespace Persistence\Repository;

use App\SQLiteConnection;
use Application\Repository\VehicleListRepositoryInterface;
use DateTimeImmutable;
use Domain\Service\VehicleDTO;
use Domain\Service\VehicleDTOCollection;
use PDO;

class VehicleListRepository implements VehicleListRepositoryInterface
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = (new SQLiteConnection())->connect();
    }

    public function getList(): VehicleDTOCollection
    {
        $results = $this->pdo
            ->query('SELECT * FROM vehicles ORDER BY updated_at DESC')
            ->fetchAll()
        ;

        $items = \array_map(
            static fn(array $row) => new VehicleDTO(
                $row['registration_number'],
                $row['brand'],
                $row['model'],
                $row['type'],
                $row['id'],
                (new DateTimeImmutable())->setTimestamp($row['created_at']),
                (new DateTimeImmutable())->setTimestamp($row['updated_at']),
            ),
            $results,
        );


        return new VehicleDTOCollection($items);
    }
}
