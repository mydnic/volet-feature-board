<?php

namespace Mydnic\VoletFeatureBoard\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Mydnic\VoletFeatureBoard\Models\Feature;
use Mydnic\VoletFeatureBoard\Models\Vote;
use Mydnic\VoletFeatureBoard\Traits\HasAuthor;

class VoteController extends Controller
{
    use HasAuthor;

    public function toggle(Feature $feature): JsonResponse
    {
        $authorId = $this->getAuthorId();

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
            'votes_count' => $feature->votesCount(),
        ]);
    }
}
