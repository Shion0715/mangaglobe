<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\PostRanking;
use App\Models\UserPoints;

class CalculateUserPointsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'points:calculate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate and store user points based on total post views';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $cpmRate = 0.001; // 1000ビューあたり1ポイント

        $users = User::with('posts')->get();

        foreach ($users as $user) {
            $totalViewsForUser = PostRanking::whereHas('post', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->sum('page_view_count');

            $points = $totalViewsForUser * $cpmRate * 0.8;

            UserPoints::create([
                'user_id' => $user->id,
                'points' => $points,
                'period' => 'all_time',
            ]);
        }

        $this->info('User points calculated and stored successfully.');
    }
    
}
