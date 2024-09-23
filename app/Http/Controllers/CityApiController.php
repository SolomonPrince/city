<?php

namespace App\Http\Controllers;

use App\Data\CityData;
use App\Repositories\CityRepositoryInterface;
use App\Http\Responses\ApiBaseResponse;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Http\Requests\StoreCityRequest;

class CityApiController extends Controller
{
    public function __construct(
        protected CityRepositoryInterface $cityRepository
    ){}

    public function index(): ApiBaseResponse
    {
        try{
            $cities = $this->cityRepository->getAll();
            return SuccessApiResponse::make($cities);
        }catch (\Exception $e){
            return ErrorApiResponse::make($e->getMessage());
        }
    }

    public function store(StoreCityRequest $request): ApiBaseResponse
    {
        try{
            // Save city using the repository
            $cityData = $this->cityRepository->create($request->getData());

            return SuccessApiResponse::make(CityData::fromModel($cityData), 201);
        }catch (\Exception $e){
            return ErrorApiResponse::make($e->getMessage());
        }
    }

    public function destroy(int $id): ApiBaseResponse
    {
        try{
            $deleted = $this->cityRepository->delete($id);

            if (!$deleted) {
                return ErrorApiResponse::make(['message' => 'City not found'], 404);
            }

            return SuccessApiResponse::make([], 204);
        }catch (\Exception $e){
            return ErrorApiResponse::make($e->getMessage());
        }
    }
}
