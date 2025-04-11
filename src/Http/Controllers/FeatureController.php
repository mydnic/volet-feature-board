<?php

namespace Mydnic\VoletFeatureBoard\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Mydnic\Volet\Features\FeatureManager;
use Mydnic\VoletFeatureBoard\Enums\FeatureStatus;
use Mydnic\VoletFeatureBoard\Models\Feature;
use Mydnic\VoletFeatureBoard\Models\Vote;

class FeatureController extends Controller
{
    public function __construct(
        protected FeatureManager $featureManager
    ) {}

    public function index(Request $request): JsonResponse
    {
        $authorId = auth()->check() ? auth()->id() : $request->header('X-Guest-ID');

        $features = Feature::with(['comments', 'votes'])
            ->withCount('votes')
            ->orderByDesc('votes_count')
            ->get();

        $featureBoard = $this->featureManager->getFeature('volet-feature-board');
        $categories = collect($featureBoard->getCategories());

        $features->map(function ($feature) use ($categories, $authorId) {
            $feature->category = $categories->where('slug', $feature->category)->first();
            $feature->has_voted = $feature->votes->where('author_id', $authorId)->isNotEmpty();
            $feature->authorid = $authorId;
        });

        return response()->json($features);
    }

    public function store(Request $request): JsonResponse
    {
        /** @var FeatureBoard $featureBoard */
        $featureBoard = $this->featureManager->getFeature('volet-feature-board');

        $categories = collect($featureBoard->getCategories())
            ->pluck('slug')
            ->toArray();

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|in:'.implode(',', $categories),
        ]);

        $feature = Feature::create([
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'status' => FeatureStatus::PENDING,
            'author_id' => $this->getAuthorId(),
        ]);

        return response()->json($feature);
    }

    public function show(Request $request, Feature $feature): JsonResponse
    {
        $authorId = auth()->check() ? auth()->id() : $request->header('X-Guest-ID');

        $feature->load(['votes', 'comments']);
        $feature->has_voted = Vote::where('feature_id', $feature->id)
            ->where('author_id', $authorId)
            ->exists();

        return response()->json($feature);
    }
}
