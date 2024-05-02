<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Carbon\Carbon;

class RankingContoller extends Controller
{
    private function getRanking($start, $end)
    {
        return Post::withCount('likes')
            ->whereHas('likes', function ($query) use ($start, $end) {
                $query->whereBetween('likes.created_at', [$start, $end]);
            })
            ->orderBy('likes_count', 'desc')
            ->take(30)
            ->get();
    }

    public function ranking_daily()
    {
        $daily_ranking = $this->getRanking(Carbon::now()->startOfDay(), Carbon::now()->endOfDay());
        return view('ranking.ranking_daily', compact('daily_ranking'));
    }

    public function ranking_weekly()
    {
        $weekly_ranking = $this->getRanking(Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek());
        return view('ranking.ranking_weekly', compact('weekly_ranking'));
    }

    public function ranking_monthly()
    {
        $monthly_ranking = $this->getRanking(Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth());
        return view('ranking.ranking_monthly', compact('monthly_ranking'));
    }

    public function ranking_all()
    {
        $all_ranking = Post::withCount('likes')->orderBy('likes_count', 'desc')->take(30)->get();
        return view('ranking.ranking_all', compact('all_ranking'));
    }
}