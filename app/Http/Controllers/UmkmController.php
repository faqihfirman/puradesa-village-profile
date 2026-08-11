<?php

namespace App\Http\Controllers;

use App\Models\EconomicPotential;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class UmkmController extends Controller
{
    public function index(Request $request): Response
    {
        $sector = $request->query('sektor');

        $query = EconomicPotential::query();

        if ($sector) {
            $query->where('sector', $sector);
        }

        $potentials = $query->orderBy('order')
            ->paginate(9)
            ->withQueryString()
            ->through(fn (EconomicPotential $item) => $this->toCard($item));

        $slides = EconomicPotential::orderBy('order')
            ->get()
            ->map(fn (EconomicPotential $item) => $this->toCard($item))
            ->values();

        return Inertia::render('Umkm/Index', [
            'slides' => $slides,
            'sectors' => collect(EconomicPotential::SECTORS)
                ->map(fn (string $label, string $value) => ['label' => $label, 'value' => $value])
                ->values(),
            'activeSector' => $sector,
            'potentials' => $potentials,
        ]);
    }

    public function show(string $slug): Response
    {
        $potential = EconomicPotential::where('slug', $slug)->firstOrFail();

        $related = EconomicPotential::where('id', '!=', $potential->id)
            ->orderBy('order')
            ->take(3)
            ->get();

        return Inertia::render('Umkm/Show', [
            'potential' => [
                'slug' => $potential->slug,
                'title' => $potential->title,
                'content' => $potential->detail_content,
                'imageUrl' => $potential->image_url,
                'sector' => $potential->sector,
                'sectorLabel' => $potential->sector_label,
                'mapsUrl' => $potential->maps_url,
            ],
            'related' => $related->map(fn (EconomicPotential $item) => $this->toCard($item))->values(),
        ]);
    }

    private function toCard(EconomicPotential $item): array
    {
        return [
            'slug' => $item->slug,
            'title' => $item->title,
            'description' => $item->description,
            'sector' => $item->sector,
            'sectorLabel' => $item->sector_label,
            'imageUrl' => $item->image_url,
        ];
    }
}
