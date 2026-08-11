<?php

namespace App\Http\Controllers;

use App\Models\Mission;
use App\Models\Official;
use App\Models\VillageProfile;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    public function __invoke(): Response
    {
        $profile = VillageProfile::current();

        return Inertia::render('Profile', [
            'profile' => [
                'historyContent' => $profile->history_content,
                'foundedYear' => $profile->founded_year,
                'illustrationUrl' => $profile->illustration_url,
                'vision' => $profile->vision,
                'areaSize' => (float) $profile->area_size,
                'areaUnit' => $profile->area_unit,
                'altitude' => $profile->altitude,
                'altitudeUnit' => $profile->altitude_unit,
                'totalPopulation' => $profile->total_population,
                'totalFamilies' => $profile->total_families,
                'populationDensity' => $profile->population_density,
                'populationByReligion' => $profile->population_by_religion ?? [],
                'populationByMaritalStatus' => $profile->population_by_marital_status ?? [],
                'populationByEducation' => $profile->population_by_education ?? [],
                'populationByOccupation' => $profile->population_by_occupation ?? [],
                'populationByAgeGroup' => $profile->population_by_age_group ?? [],
                'mapCenterLat' => (float) $profile->map_center_lat,
                'mapCenterLng' => (float) $profile->map_center_lng,
                'mapZoom' => $profile->map_zoom,
            ],
            'missions' => Mission::orderBy('order')
                ->get()
                ->map(fn (Mission $mission) => [
                    'title' => $mission->title,
                    'description' => $mission->description,
                ]),
            'officials' => Official::active()
                ->orderBy('level')
                ->orderBy('order')
                ->get()
                ->map(fn (Official $official) => [
                    'name' => $official->name,
                    'position' => $official->position,
                    'level' => $official->level,
                    'photoUrl' => $official->photo_url,
                    'phone' => $official->phone,
                ]),
        ]);
    }
}
