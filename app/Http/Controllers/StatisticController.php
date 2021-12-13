<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Service\Statistic;
use Illuminate\Http\Request;

class StatisticController extends Controller
{
    public function index(Request $request, Statistic $statistic)
    {

        $month = $request->input('month');
        $year = $request->input('year', date('Y'));

        $statistic = $statistic->top10Links((int)$month, (int)$year);
        return view('statistics', ['statistic' => $statistic->toArray(), 'month' => $month, 'year' => $year]);
    }
}
