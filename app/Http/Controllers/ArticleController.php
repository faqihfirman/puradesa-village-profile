<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ArticleController extends Controller
{
    public function index(Request $request): Response
    {
        $categorySlug = $request->query('kategori');
        $page = $request->integer('page', 1);

        $featured = Article::published()->with('category')->where('is_featured', true)->latest('published_at')->first()
            ?? Article::published()->with('category')->latest('published_at')->first();

        $query = Article::published()->with('category');

        if ($categorySlug) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $categorySlug));
        }

        if ($page === 1 && $featured) {
            $query->where('id', '!=', $featured->id);
        }

        $articles = $query->latest('published_at')
            ->paginate(9)
            ->withQueryString()
            ->through(fn (Article $article) => $this->toCard($article));

        return Inertia::render('Articles/Index', [
            'featured' => $featured ? $this->toCard($featured) : null,
            'categories' => Category::orderBy('order')->get(['name', 'slug']),
            'activeCategory' => $categorySlug,
            'articles' => $articles,
        ]);
    }

    public function show(string $slug, Request $request): Response
    {
        $article = Article::published()->with('category')
            ->where('slug', $slug)
            ->firstOrFail();

        $viewed = $request->session()->get('viewed_articles', []);
        if (! in_array($article->id, $viewed, true)) {
            $article->increment('views_count');
            $request->session()->push('viewed_articles', $article->id);
        }

        $related = Article::published()->with('category')
            ->where('id', '!=', $article->id)
            ->when($article->category_id, fn ($q) => $q->where('category_id', $article->category_id))
            ->latest('published_at')
            ->take(3)
            ->get();

        if ($related->count() < 3) {
            $exclude = $related->pluck('id')->push($article->id);
            $related = $related->concat(
                Article::published()->with('category')
                    ->whereNotIn('id', $exclude)
                    ->latest('published_at')
                    ->take(3 - $related->count())
                    ->get()
            );
        }

        return Inertia::render('Articles/Show', [
            'article' => [
                'slug' => $article->slug,
                'title' => $article->title,
                'content' => $article->content,
                'coverUrl' => $article->cover_url,
                'category' => $article->category ? [
                    'name' => $article->category->name,
                    'slug' => $article->category->slug,
                    'color' => $article->category->color,
                ] : null,
                'authorName' => $article->author_name,
                'publishedAt' => $article->published_at?->toIso8601String(),
            ],
            'related' => $related->map(fn (Article $a) => $this->toCard($a))->values(),
        ]);
    }

    private function toCard(Article $article): array
    {
        return [
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
        ];
    }
}
