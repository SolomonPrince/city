<?php

namespace App\Repositories;

use App\Data\CityData;
use App\Models\City;
use Illuminate\Support\Facades\DB;

class CityRepository implements CityRepositoryInterface
{
    public function __construct(
        protected City $model
    ){}

    public function create(CityData $data): City
    {
        return DB::transaction(function () use ($data) {
            return $this->model->create([
                'name' => $data->name,
                'slug' => $data->slug
            ]);
        });
    }

    

    public function delete(int $id): bool
    {
        $city = $this->model->find($id);
        return $city ? $city->delete() : false;
    }

    public function getById(int $id): ?CityData
    {
        $city = $this->model->find($id);

        return $city ? CityData::from($city) : null;
    }

    public function getAll(): array
    {
        return CityData::fromModels($this->model->all())->toArray();
    }

    public function getBySlug(string $slug): ?City
    {
        return $this->model->where('slug', $slug)->first();
    }
}