<?php

namespace App\Http\Controllers;

use DateInterval;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class MatchController extends Controller
{
    public function getTodaysMatches(Request $request): JsonResponse
    {
        $fixturesCache = Cache::get('fixtures');
        $cacheUpdated = false;

        if (!$fixturesCache) {
            $apiResponse = json_decode(
                Http::withHeaders([
                    'x-rapidapi-key' => 'c6c8794f708a9883aec31ea3d559d5ff'
                ])
                    ->acceptJson()
                    ->withQueryParameters($request->query())
                    ->get('https://v3.football.api-sports.io/fixtures')
            );

            Cache::set('fixtures', $apiResponse, DateInterval::createFromDateString('300 seconds'));
            $cacheUpdated = true;
            $fixturesCache = $apiResponse;
        }

        $page = $request->input('page', 1);
        $perPage = $request->input('perPage', 10);

        $fixtures = $fixturesCache->response ?? [];
        $totalItems = count($fixtures);
        $totalPages = ceil($totalItems / $perPage);

        $startIndex = ($page - 1) * $perPage;

        if ($startIndex >= $totalItems) {
            $startIndex = $totalItems - 1;
        }

        $pagedFixtures = array_slice($fixtures, $startIndex, $perPage);

        return response()->json([
            'data' => $pagedFixtures,
            'meta' => [
                'current_page' => (int) $page,
                'per_page' => (int) $perPage,
                'total_items' => $totalItems,
                'total_pages' => $totalPages,
                'cache_updated' => $cacheUpdated,
            ]
        ]);
    }
}
