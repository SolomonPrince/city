<?php

namespace App\Repositories;

use App\Data\CityData;
use App\Models\City;

interface CityRepositoryInterface
{
    public function create(CityData $data): City;

    public function delete(int $id): bool;

    public function getById(int $id): ?CityData;

    public function getAll(): array;

    public function getBySlug(string $slug): ?City;
}