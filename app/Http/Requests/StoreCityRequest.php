<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Spatie\LaravelData\WithData;
use App\Data\CityData;

class StoreCityRequest extends FormRequest
{
    use WithData;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|unique:cities,name|min:3|max:255',
        ];
    }


    /**
     * Override the all() method to include additional parameters.
     *
     * @param null $keys
     * @return array
     */
    public function all($keys = null): array
    {
        $data = parent::all();

        $data['slug'] = Str::slug($data['name']);
       

        return $data;
    }

    protected function dataClass(): string
    {
        return CityData::class;
    }
}
