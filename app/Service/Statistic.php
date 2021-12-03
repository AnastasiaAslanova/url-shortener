<?php

declare(strict_types=1);

namespace App\Service;

use DateTimeImmutable;
use Illuminate\Support\Facades\DB;

class Statistic
{
    public function top10Links(int $month = null, int $year = null)
    {
        return $this->getTopQuery($month, $year)->get();
    }

    public function top10LinksByUser(int $userId, int $month = null, int $year = null)
    {
        return $this->getTopQuery($month, $year)->where('user_id', '=', $userId)->get();
    }

    private function getTopQuery(int $month = null, int $year = null, int $limit = 10)
    {
        $query = DB::table('stat_daily', 'sd')
            ->select(['sd.short_url_id', 'links.short_url'])
            ->selectRaw('sum(sd.count) sum')
            ->leftJoin('links', 'sd.short_url_id', '=', 'links.id')
            ->groupBy('sd.short_url_id')
            ->orderByDesc('sum')
            ->limit($limit);
        if ($month && $year) {
            $month = sprintf('%02d', $month);
            $startDate = new DateTimeImmutable("$year-$month-01");
            $endDate = $startDate->modify('+1 month')->modify('-1 day');
            $query->where(
                [
                    ['date', '>=', $startDate->format('Y-m-d')],
                    ['date', '<=', $endDate->format('Y-m-d')]
                ]
            );
        }
        return $query;
    }
}
