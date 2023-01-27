<?php

namespace App\Http\Requests\store;

use Illuminate\Foundation\Http\FormRequest;

class StoreRecipeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return false;
    }

    //TODO: put a restriction on country to have a valid country

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'difficultyType' => ['required', 'string', 'in:novice,medium,advanced'],
            'timeToPrepare' => ['required', 'integer'],
            'ingredients' => ['required', 'string'],
            'videoLink' => ['string'],
            'foodCountry' => ['string'],
            'type' => StoreFoodTypeRequest::class,
            'stars' => StoreRatingRequest::class
        ];
    }
}
