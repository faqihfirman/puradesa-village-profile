<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Inertia\Inertia;
use Inertia\Response;

class DestinationController extends Controller
{
    public function index(): Response
    {
        $destinations = Destination::orderBy('order')
            ->paginate(9)
            ->withQueryString()
            ->through(fn (Destination $d) => $this->toCard($d));

        $slides = Destination::orderBy('order')
            ->get()
            ->map(fn (Destination $d) => $this->toCard($d))
            ->values();

        return Inertia::render('Destinations/Index', [
            'slides' => $slides,
            'destinations' => $destinations,
        ]);
    }

    public function show(string $slug): Response
    {
        $destination = Destination::where('slug', $slug)->firstOrFail();

        $related = Destination::where('id', '!=', $destination->id)
            ->orderBy('order')
            ->take(3)
            ->get();

        return Inertia::render('Destinations/Show', [
            'destination' => [
                'slug' => $destination->slug,
                'name' => $destination->name,
                'description' => $destination->description,
                'coverUrl' => $destination->cover_url,
                'categoryLabel' => $destination->category_label,
                'hamletName' => $destination->hamlet_name,
                'mapsUrl' => "https://www.google.com/maps?q={$destination->latitude},{$destination->longitude}",
            ],
            'related' => $related->map(fn (Destination $d) => $this->toCard($d))->values(),
        ]);
    }

    private function toCard(Destination $d): array
    {
        return [
            'slug' => $d->slug,
            'name' => $d->name,
            'shortDescription' => $d->short_description,
            'coverUrl' => $d->cover_url,
            'categoryLabel' => $d->category_label,
            'hamletName' => $d->hamlet_name,
        ];
    }
}
