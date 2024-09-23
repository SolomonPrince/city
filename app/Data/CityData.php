<?php

namespace App\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Rule;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Illuminate\Support\Collection;
use App\Models\City;

class CityData extends Data
{
    public function __construct(
      public ?int $id,
      #[StringType]
      #[Rule('required', 'min:3', 'max:255')]
      public string $name,

      #[StringType]
      #[Rule('required', 'min:3', 'max:255')]
      #[Unique('cities', 'slug')] // Ensures uniqueness of the slug
      public string $slug
    ) {}



  public static function fromModel(City $city): self
  {
      return new self(
          $city->id,
          $city->name,
          $city->slug,
      );
  }

  public static function fromModels(Collection $cities): Collection
  {
      return $cities->map(fn (City $city) => self::fromModel($city));
  }
}
