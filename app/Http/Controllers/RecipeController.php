<?php

namespace App\Http\Controllers;

use App\Facades\ErrorHandler;
use App\Http\Requests\store\StoreRecipeRequest;
use App\Models\Recipe;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use function PHPUnit\Framework\isEmpty;

class RecipeController extends Controller
{
    public function __construct()
    {
        ErrorHandler::setCustom([
            'path' => class_basename(self::class),
        ], [
            1 => [
                'message' => 'Request could not find recipe',
                'status' => 400,
                'log' => null
            ],
            2 => [
                'message' => 'Could not find the recipe',
                'status' => 400,
                'log' => null
            ],
            3 => [
                'message' => 'Could not create recipe',
                'status' => 400,
                'log' => null
            ],
            4 => [
                'message' => 'Error while adding relation data',
                'status' => 400,
                'log' => null
            ]
        ]);
    }

    public function index(): JsonResponse
    {
        return response()->json(
            Recipe::with(['type', 'rating'])->get()
        );
    }

    public function show(Request $request): JsonResponse
    {
        $recipe = Recipe::with(['type', 'rating'])
            ->where('id', $request->id)
            ->first();

        if (!$recipe) {
            return ErrorHandler::write(1);
        }

        return response()
            ->json($recipe);
    }

    public function store(StoreRecipeRequest $request): JsonResponse
    {
        try {
            $valid = $request->safe()->only([
                'stars', 'type', 'name', 'difficultyType', 'timeToPrepare', 'ingredients', 'videoLink', 'foodCountry'
            ]);
            if (!$recipe = Recipe::create(
                $valid
            )) {
                return ErrorHandler::write(3);
            } elseif (!$recipe->rating()->create(['stars' => $request->stars])) {
                $recipe->delete();
                return ErrorHandler::write(3);
            } elseif (!$recipe->type()->create(['type' => $request->type])) {
                $recipe->rating()->delete();
                $recipe->delete();
                return ErrorHandler::write(3);
            }

            return response()->json(
                Recipe::with(['type', 'rating'])
                    ->where('id', $recipe->id)
                    ->first()
            );
        } catch (ValidationException $exception) {
            return ErrorHandler::setValidationError(0, json_encode($exception->getMessage()))
                ->write(0, true);
        }
    }

    public function update(StoreRecipeRequest $request): JsonResponse
    {
        try {
            $valid = $request->safe()->only([
                'stars', 'type', 'name', 'difficultyType', 'timeToPrepare', 'ingredients', 'videoLink', 'foodCountry'
            ]);

            if (!$recipe = Recipe::where('id', $request->id)->first()) {
                return ErrorHandler::write(1);
            } elseif (!$recipe->update($valid)) {
                return ErrorHandler::write(3);
            } elseif (isset($valid['stars']) && !$recipe->rating()->update(['stars' => $request->stars])) {
                return ErrorHandler::write(3);
            } elseif (isset($valid['type']) && !$recipe->type()->update(['type' => $request->type])) {
                return ErrorHandler::write(3);
            }

            return response()->json(
                Recipe::with(['type', 'rating'])
                    ->where('id', $recipe->id)
                    ->first()
            );
        } catch (ValidationException $exception) {
            return ErrorHandler::setValidationError(0, json_encode($exception->getMessage()))
                ->write(0, true);
        }
    }

}
