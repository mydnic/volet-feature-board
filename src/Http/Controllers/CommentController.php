<?php

namespace Mydnic\VoletFeatureBoard\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Mydnic\VoletFeatureBoard\Models\Comment;
use Mydnic\VoletFeatureBoard\Models\Feature;

class CommentController extends Controller
{
    public function store(Request $request, Feature $feature): JsonResponse
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $authorId = auth()->check() ? auth()->id() : $request->header('X-Guest-ID');

        if (! $authorId) {
            return response()->json(['error' => 'No author ID provided'], 400);
        }

        $comment = Comment::create([
            'feature_id' => $feature->id,
            'author_id' => $authorId,
            'content' => $request->input('content'),
        ]);

        return response()->json($comment);
    }
}
