<?php

namespace App\Http\Controllers;

use DateInterval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;
use Inertia\Response;

class TeamController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Teams/Index', []);
    }

    public function show()
    {

    }

    public function getTeams(Request $request)
    {
        $teamsCache = Cache::get('teams');
        $cacheUpdated = false;

        if (!$teamsCache) {
            $apiResponse = json_decode(
                Http::withHeaders([
                    'x-rapidapi-key' => 'c6c8794f708a9883aec31ea3d559d5ff',
                ])
                    ->acceptJson()
                    ->withQueryParameters(request()->query())
                    ->get('https://v3.football.api-sports.io/teams'));
            Cache::set('teams', $apiResponse, DateInterval::createFromDateString('1 day'));
            $cacheUpdated = true;
        }

        $teamsCache = Cache::get('teams');
        $teamsCache->cacheUpdated = $cacheUpdated;

        return response()->json([
            'data' => $teamsCache->response ?? [],
            'cache_updated' => $cacheUpdated,
        ]);
    }
}
