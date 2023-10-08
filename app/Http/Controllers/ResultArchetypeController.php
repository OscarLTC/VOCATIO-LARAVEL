<?php

namespace App\Http\Controllers;

use App\Models\ResultArchetype;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ResultArchetypeController extends Controller
{
    public function index(): JsonResponse
    {
        $results = ResultArchetype::with('groupArchetype', 'imageArchetype')->get();

        return response()->json($results);
    }

    public function findByIds($id1, $id2, $id3): JsonResponse
    {
        $orderedIds = collect([$id1, $id2, $id3]);

        // Retrieve the results and order them based on the provided IDs
        $results = ResultArchetype::whereIn('category_id', $orderedIds)
            ->with('groupArchetype', 'imageArchetype')
            ->get()
            ->sortBy(function ($result) use ($orderedIds) {
                return $orderedIds->search($result->id);
            });

        $resultsArray = $results->map(function ($result) {
            $imageNames = $result->imageArchetype->pluck('image')->toArray();

            return [
                'id' => $result->id,
                'category_id' => $result->category_id,
                'archetype' => $result->archetype,
                'concept' => $result->concept,
                'definition' => $result->definition,
                'characteristics' => $result->characteristics,
                'group_archetype' => [
                    'id' => $result->groupArchetype->id,
                    'hero' => $result->groupArchetype->hero,
                    'color' => $result->groupArchetype->color,
                ],
                'image_archetype' => $imageNames,
            ];
        });

        return response()->json($resultsArray);
    }
}
