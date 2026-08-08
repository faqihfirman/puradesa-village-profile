<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\SiteSetting;
use App\Models\VillageHeadMessage;
use App\Models\VillageProfile;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function __invoke(): Response
    {
        $villageHead = VillageHeadMessage::first();
        $profile = VillageProfile::first();
        $siteSetting = SiteSetting::first();

        return Inertia::render('Home', [
            'hero' => [
                'title' => config('village.hero.title'),
                'subtitle' => config('village.hero.subtitle'),
                'ctaPrimary' => config('village.hero.cta_primary'),
                'ctaSecondary' => config('village.hero.cta_secondary'),
                'imageUrl' => $siteSetting?->hero_image_url,
            ],
            'villageHead' => $villageHead ? [
                'name' => $villageHead->name,
                'position' => $villageHead->position,
                'message' => $villageHead->message,
                'photoUrl' => $villageHead->photo_url,
            ] : null,
            'stats' => $profile ? [
                'population' => $profile->total_population,
                'families' => $profile->total_families,
                'hamlets' => $profile->total_hamlets,
                'areaSize' => (float) $profile->area_size,
                'areaUnit' => $profile->area_unit,
            ] : null,
            'latestArticles' => Article::published()
                ->with('category')
                ->latest('published_at')
                ->take(3)
                ->get()
                ->map(fn (Article $article) => [
                    'slug' => $article->slug,
                    'title' => $article->title,
                    'excerpt' => $article->excerpt,
                    'coverUrl' => $article->cover_url,
                    'category' => $article->category ? [
                        'name' => $article->category->name,
                        'color' => $article->category->color,
                    ] : null,
                    'authorName' => $article->author_name,
                    'publishedAt' => $article->published_at?->toIso8601String(),
                ]),
        ]);
    }
}
