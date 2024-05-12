<?php

namespace App\Console\Commands\GoogleAnalytics;

use Exception;
use App\Models\PostRanking;
use Illuminate\Console\Command;
use Google\Analytics\Data\V1beta\BetaAnalyticsDataClient;
use Google\Analytics\Data\V1beta\Filter;
use Google\Analytics\Data\V1beta\Filter\StringFilter\MatchType;
use Google\Analytics\Data\V1beta\FilterExpression;
use Google\Analytics\Data\V1beta\OrderBy;
use Google\Analytics\Data\V1beta\DateRange;
use Google\Analytics\Data\V1beta\Dimension;
use Google\Analytics\Data\V1beta\Metric;
use App\Models\DailyViewCount;
use App\Models\WeeklyViewCount;
use App\Models\MonthlyViewCount;
use App\Models\TotalViewCount;


class AnalyticsCommand extends Command
{
    protected $signature   = 'analytics';
    protected $description = 'Command description';

    /**
     * consoleコマンドの実行
     *
     * @return void
     */
    public function handle(): void
    {
        $this->postRanking();
    }

    /**
     * テックブログのランキングを集計してDBに保存
     *
     * @return void
     */
    public function postRanking(): void
    {
        try {
            $property_id = "439716669";
            $client = new BetaAnalyticsDataClient([
                'credentials' => "storage/json/mangaglobe-analytics-73567e70a692.json",
            ]);

            $dateRanges = [
                ['today', 'today', DailyViewCount::class], // 今日のビュー数を DailyViewCount に保存
                ['7daysAgo', 'today', WeeklyViewCount::class], // 今週のビュー数を WeeklyViewCount に保存
                [date('Y-m-01'), 'today', MonthlyViewCount::class], // 今月のビュー数を MonthlyViewCount に保存
                ['2024-04-01', 'today', TotalViewCount::class], // 全期間のビュー数を TotalViewCount に保存
            ];

            foreach ($dateRanges as [$startDate, $endDate, $modelClass]) {
                $response = $client->runReport([
                    'property'        => 'properties/' . $property_id,
                    'dateRanges'      => [
                        new DateRange([
                            'start_date' => $startDate,
                            'end_date'   => $endDate,
                        ]),
                    ],
                    'dimensions'      => [
                        new Dimension([
                            'name' => 'pagePath',
                        ]),
                    ],
                    'dimensionFilter' => new FilterExpression([
                        'filter' => new Filter([
                            'field_name'    => 'pagePath',
                            'string_filter' => new Filter\StringFilter([
                                'match_type' => MatchType::PARTIAL_REGEXP,
                                'value'      => '^/post/\d+/chapter/\d+$',
                            ]),
                        ]),
                    ]),
                    'metrics'         => [
                        new Metric([
                            'name' => 'screenPageViews',
                        ]),
                    ],
                    'orderBys'        => [
                        new OrderBy([
                            'metric' => new OrderBy\MetricOrderBy([
                                'metric_name' => 'screenPageViews',
                            ]),
                            'desc'   => true,
                        ]),
                    ],
                ]);

                foreach ($response->getRows() as $key => $row) {
                    $pageName = $row->getDimensionValues()[0]->getValue();
                    $metricsValues = $row->getMetricValues();
                    $viewCount = $metricsValues[0]->getValue();

                    // URLからpost_idを抽出
                    preg_match('/^\/post\/(\d+)\/chapter\/\d+$/', $pageName, $matches);
                    $postId = $matches[1] ?? null;

                    $modelClass::updateOrCreate(
                        ['page_path' => $pageName],
                        ['view_count' => $viewCount, 'post_id' => $postId]
                    );
                }
            }
        } catch (Exception $e) {
            dd($e);
        }
    }
}
