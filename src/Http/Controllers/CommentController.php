<?php

namespace Mydnic\VoletFeatureBoard\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Mydnic\VoletFeatureBoard\Models\Feature;
use Mydnic\VoletFeatureBoard\Models\Comment;
use Mydnic\VoletFeatureBoard\Traits\HasAuthor;

class CommentController extends Controller
{
    use HasAuthor;

    public function store(Request $request, Feature $feature): JsonResponse
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $comment = Comment::create([
            'feature_id' => $feature->id,
            'author_id' => $this->getAuthorId(),
            'content' => $request->input('content'),
        ]);

        return response()->json($comment);
    }
}
