<?php

namespace App\Http\Middleware;

use App\Models\SiteSetting;
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
        $site = SiteSetting::current();

        return [
            ...parent::share($request),
            'site' => [
                'address' => $site->address,
                'phone' => $site->phone,
                'whatsapp' => $site->whatsapp,
                'email' => $site->email,
                'officeHours' => [
                    'weekday' => $site->office_hours_weekday,
                    'weekend' => $site->office_hours_weekend,
                ],
                'coordinates' => [
                    'lat' => (float) $site->office_lat,
                    'lng' => (float) $site->office_lng,
                ],
                'googleMapsUrl' => $site->google_maps_url,
                'social' => array_filter([
                    'facebook' => $site->facebook_url,
                    'instagram' => $site->instagram_url,
                    'youtube' => $site->youtube_url,
                ]),
            ],
            'village' => [
                'name' => config('village.name'),
                'officeName' => config('village.office_name'),
                'district' => config('village.district'),
                'regency' => config('village.regency'),
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
