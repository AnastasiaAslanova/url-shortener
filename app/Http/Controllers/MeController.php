<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Service\Statistic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MeController extends Controller
{
    public function statistic(Request $request, Statistic $statistic)
    {
        $month = $request->input('month');
        $year = $request->input('year', date('Y'));
        $userId = Auth::id();

        $statistic = $statistic->top10LinksByUser($userId, (int)$month, (int)$year);
        return view('statistics', ['statistic' => $statistic->toArray(), 'month' => $month, 'year' => $year]);
    }
}
