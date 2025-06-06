<?php

namespace Mydnic\VoletFeatureBoard;

use Mydnic\Volet\Features\BaseFeature;

class VoletFeatureBoard extends BaseFeature
{
    protected $categories = [];

    public function getId(): string
    {
        return 'volet-feature-board';
    }

    public function getLabel(): string
    {
        return $this->label ?? 'Feature Requests';
    }

    public function getIcon(): string
    {
        return 'https://api.iconify.design/lucide:lightbulb.svg?color=%23888888';
    }

    public function getComponentName(): ?string
    {
        return 'feature-board';
    }

    public function getScripts(): ?string
    {
        $scriptUrl = asset('vendor/volet-feature-board/volet-feature-board.js');

        return "<script src=\"{$scriptUrl}\"></script>";
    }

    public function addCategory(string $slug, string $name, string $icon): static
    {
        $this->categories[] = [
            'slug' => $slug,
            'name' => $name,
            'icon' => $icon,
        ];

        return $this;
    }

    public function getCategories(): array
    {
        return $this->categories;
    }

    public function getConfig(): array
    {
        return [
            'routes' => [
                'features' => route('volet.feature-board.features.index'),
                'store' => route('volet.feature-board.features.store'),
                'show' => route('volet.feature-board.features.show', ['feature' => '_feature_id_']),
                'vote' => route('volet.feature-board.features.vote', ['feature' => '_feature_id_']),
                'comments' => route('volet.feature-board.features.comments.store', ['feature' => '_feature_id_']),
            ],
            'labels' => trans('volet-feature-board::volet-feature-board'),
            'categories' => $this->getCategories(),
        ];
    }
}
