<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CashController extends Controller
{
    public function index()
    {
        return view('mypage.cash');
    }

    public function calculateRoyalty($views, $cpm, $royaltyRate) {
        $revenue = ($views / 1000) * $cpm;
        $royalty = $revenue * $royaltyRate;
        return $royalty;
    }

    public function showRoyalty() {
        $views = 10000;
        $cpm = 1; // 中間のCPM
        $royaltyRate = 0.8; // 還元率

        $royalty = $this->calculateRoyalty($views, $cpm, $royaltyRate);

        return view('royalty', ['royalty' => $royalty]);
    }

}