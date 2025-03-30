<?php

namespace Mydnic\VoletFeatureBoard\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Mydnic\Volet\Features\FeatureManager;
use Mydnic\VoletFeatureBoard\Enums\FeatureStatus;
use Mydnic\VoletFeatureBoard\Models\Feature;
use Mydnic\VoletFeatureBoard\Traits\HasAuthor;

class FeatureController extends Controller
{
    use HasAuthor;

    public function __construct(
        protected FeatureManager $featureManager
    ) {}

    public function index(): JsonResponse
    {
        $features = Feature::with(['votes', 'comments'])
            ->withCount('votes')
            ->orderByDesc('votes_count')
            ->get()
            ->groupBy('category');

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

    public function show(Feature $feature): JsonResponse
    {
        $feature->load(['votes', 'comments']);

        return response()->json($feature);
    }
}
