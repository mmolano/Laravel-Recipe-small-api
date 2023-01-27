<?php

namespace App\Http\Controllers;

use App\Facades\ErrorHandler;
use App\Http\Requests\store\StoreRatingRequest;
use App\Models\Rating;
use App\Models\Recipe;
use Illuminate\Http\JsonResponse;

class RatingController extends Controller
{
    public function __construct()
    {
        ErrorHandler::setCustom([
            'path' => class_basename(self::class),
        ], [
            1 => [
                'message' => 'Could not find the recipe',
                'status' => 400,
                'log' => null
            ],
            2 => [
                'message' => 'Request could not validate',
                'status' => 400,
                'log' => 'Error while sending parameters, could not validate'
            ],
            3 => [
                'message' => 'Could not create type',
                'status' => 400,
                'log' => null
            ]
        ]);
    }

    public function index(): JsonResponse
    {
        return response()->json(
            Rating::all()
        );
    }

    public function store(StoreRatingRequest $request): JsonResponse
    {
        if (!$recipe = Recipe::get($request->id)) {
            return ErrorHandler::write(1);
        } elseif (!$request->validated() || !$request->safe()->only('stars')) {
            return ErrorHandler::write(2);
        }

        if (!$rating = $recipe->rating()->create([
            'stars' => $request->stars
        ])) {
            return ErrorHandler::write(3);
        }

        return response()->json(
            $rating
        );
    }
}
