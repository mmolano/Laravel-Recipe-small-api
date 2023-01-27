<?php

namespace App\Http\Controllers;

use App\Facades\ErrorHandler;
use App\Http\Requests\store\StoreRecipeRequest;
use App\Models\Recipe;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function __construct()
    {
        ErrorHandler::setCustom([
            'Path' => class_basename(self::class),
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
                'message' => 'Could not validate parameters',
                'status' => 400,
                'log' => null
            ],
            4 => [
                'message' => 'Could not create recipe',
                'status' => 400,
                'log' => null
            ],
            5 => [
                'message' => 'Error while adding relation data',
                'status' => 400,
                'log' => null
            ]
        ]);
    }

    public function index(): JsonResponse
    {
        return response()->json(
            Recipe::with('rating, type')->get()
        );
    }

    public function show(Request $request): JsonResponse
    {
        $recipe = Recipe::with('rating', 'type')
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
        if (!$request->validated() || !$request->safe()->only([
                'stars', 'type', 'name', 'difficultyType', 'timeToPrepare', 'ingredients', 'videoLink', 'foodCountry'
            ])) {
            return ErrorHandler::write(3);
        }

        if (!$recipe = Recipe::create([
            $request->all()
        ])) {
            return ErrorHandler::write(4);
        } elseif (!$recipe->rating()->create(['stars' => $request->stars])) {
            $recipe->delete();
            return ErrorHandler::write(4);
        } elseif (!$recipe->type()->create(['type' => $request->type])) {
            $recipe->rating()->delete();
            $recipe->delete();
            return ErrorHandler::write(4);
        }

        return response()->json(
            Recipe::with('type', 'rating')
                ->where('id', $recipe->id)
                ->first()
        );

    }
}
