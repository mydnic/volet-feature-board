<?php

namespace Mydnic\VoletFeatureBoard\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Mydnic\VoletFeatureBoard\Models\Feature;
use Mydnic\VoletFeatureBoard\Models\Vote;

class VoteController extends Controller
{

    public function store(Request $request, Feature $feature): JsonResponse
    {
        $authorId = auth()->check() ? auth()->id() : $request->header('X-Guest-ID');

        if (!$authorId) {
            return response()->json(['error' => 'No author ID provided'], 400);
        }

        $vote = Vote::where('feature_id', $feature->id)
            ->where('author_id', $authorId)
            ->first();

        if ($vote) {
            $vote->delete();
            $action = 'removed';
        } else {
            Vote::create([
                'feature_id' => $feature->id,
                'author_id' => $authorId,
            ]);
            $action = 'added';
        }

        return response()->json([
            'action' => $action,
            'votes_count' => $feature->fresh()->votes()->count(),
        ]);
    }
}
