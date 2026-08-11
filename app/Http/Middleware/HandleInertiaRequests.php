<?php

namespace App\Http\Middleware;

use App\Models\VisitorStat;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'village' => [
                'name' => config('village.name'),
                'officeName' => config('village.office_name'),
                'district' => config('village.district'),
                'regency' => config('village.regency'),
                'contact' => [
                    'address' => config('village.contact.address'),
                    'phone' => config('village.contact.phone'),
                    'email' => config('village.contact.email'),
                    'mapsUrl' => config('village.contact.maps_url'),
                    'hours' => config('village.contact.hours'),
                    'social' => config('village.contact.social'),
                ],
            ],
            'visitors' => [
                'today' => VisitorStat::whereDate('date', today())->value('visits') ?? 0,
            ],
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'error' => fn () => $request->session()->get('error'),
            ],
        ];
    }
}
