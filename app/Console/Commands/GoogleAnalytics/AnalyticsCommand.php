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
            // プロパティIDを入力します。.envに書くと良いと思います。
            // $property_id = config('google.analytics.propertyId');
            $property_id = "439716669";

            // 秘密鍵のパスです。ここも.envに書くと良いと思います。
            // 'credentials' => config('google.analytics.credentials'),
            $client = new BetaAnalyticsDataClient([
                'credentials' => "storage/json/mangaglobe-analytics-73567e70a692.json",
            ]);

            $response = $client->runReport([
                // プロパティIDを指定します。
                'property'        => 'properties/' . $property_id,
                // 期間を指定します。
                'dateRanges'      => [
                    new DateRange([
                        'start_date' => '7daysAgo',
                        'end_date'   => 'today',
                    ]),
                ],
                // フィルタリング用にデータの属性を指定します。
                'dimensions'      => [
                    new Dimension([
                        'name' => 'pagePath',
                    ]),
                ],
                // データの属性で制限を掛けます。
                // 今回は、/techblog/articles/でフィルタリングを掛けてみます。
                'dimensionFilter' =>
                new FilterExpression([
                    'filter' => new Filter([
                        'field_name'    => 'pagePath',
                        'string_filter' => new Filter\StringFilter([
                            'match_type' => MatchType::PARTIAL_REGEXP,
                            'value' => '^/post/\d+/chapter/\d+$',
                        ]),
                    ]),
                ]),
                // 取得する測定値を指定します。
                'metrics'         => [
                    new Metric([
                        'name' => 'screenPageViews', // PV数
                    ]),
                    new Metric([
                        'name' => 'totalUsers', // 平均ページ滞在時間（秒）
                    ]),
                ],
                // 取得する順番を変更します。
                // 今回は、PV数が多い順に取ります。
                'orderBys'        => [
                    new OrderBy([
                        'metric' => new OrderBy\MetricOrderBy([
                            'metric_name' => 'screenPageViews',
                        ]),
                        'desc'   => true,
                    ]),
                ],
            ]);
            // 取得したReportを整形
            $result = collect();
            foreach ($response->getRows() as $key => $row) {
                // ディメンション
                $pageName = $row->getDimensionValues()[0]->getValue();

                // メトリクス
                $metricsValues = $row->getMetricValues();
                $viewCount     = $metricsValues[0]->getValue(); // PV数
                $time          = $metricsValues[1]->getValue(); // 平均ページ滞在時間（秒）
                $result->push(['rank' => $key + 1, 'page' => $pageName, 'page_view_count' => $viewCount]);
            }
            if ($result->isNotEmpty()) {
                // DBに保存
                PostRanking::query()->delete();
                PostRanking::upsert($result->toArray(), 'rank');
            }
        } catch (Exception $e) {
            dd($e);
        }
    }
}

