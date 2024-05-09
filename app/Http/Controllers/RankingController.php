<?php

namespace App\Http\Controllers;

use Google\Analytics\Data\V1beta\BetaAnalyticsDataClient;
use Google\Analytics\Data\V1beta\DateRange;
use Google\Analytics\Data\V1beta\Dimension;
use Google\Analytics\Data\V1beta\Metric;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class RankingController extends Controller
{
    public function index()
    {
        $json_path = storage_path('storage/json/mangaglobe-ae0ac283b1da.json');
        $property_id = '439716669';

        $ranking_urls = $this->getRankingUrls($json_path, $property_id);

        dd($ranking_urls);
    }

    private function getRankingUrls($json_path, $property_id, $limit = 25)
    {
        $seconds = 60 * 60 * 24; // 1 day

        return Cache::remember('users', $seconds, function () use ($json_path, $property_id) {

            $urls = [];

            $client = new BetaAnalyticsDataClient(['credentials' => $json_path]);
            $start_dt = today()->subDays(7);

            try {

                $response = $client->runReport([
                    'property' => 'properties/' . $property_id,
                    'dateRanges' => [
                        new DateRange([
                            'start_date' => $start_dt->format('Y-m-d'),
                            'end_date' => 'today',
                        ]),
                    ],
                    'dimensions' => [
                        new Dimension(['name' => 'pagePath']),
                    ],
                    'metrics' => [new Metric(['name' => 'activeUsers'])]
                ]);
            } catch (\Exception) {

                return [];
            }

            foreach ($response->getRows() as $row) {

                $path = $row->getDimensionValues()[0]->getValue();

                // 本来は、ここで正規表現を使って IDを切り出しDBから該当のデータを取得する
                $urls[] = 'https://mangaglobe.com' . $path;
            }

            return $urls;
        });
    }
}
