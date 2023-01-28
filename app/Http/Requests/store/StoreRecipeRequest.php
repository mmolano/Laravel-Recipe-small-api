<?php

namespace App\Http\Requests\store;

use App\Facades\ErrorHandler;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class StoreRecipeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
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
            'stars' => (new StoreRatingRequest())->rules()['stars'],
            'type' => (new StoreFoodTypeRequest())->rules()['type'],
        ];
    }

    /*
     * The Error is returned in the catch function. This function must exist
     * */
    public function failedValidation(Validator $validator): string
    {
        return '';
    }
}
