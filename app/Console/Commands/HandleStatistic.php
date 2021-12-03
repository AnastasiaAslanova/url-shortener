<?php

namespace App\Console\Commands;

use DateTimeImmutable;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Throwable;

class HandleStatistic extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'statistic:handle:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Save statistic for all short link for previous day';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $currDay = (new DateTimeImmutable())->setTime(0, 0);
            $prevDay = $currDay->modify('-1 day');
            $rows = DB::table('stats', 's')
                ->select('short_url_id')
                ->selectRaw('count(short_url_id) count')
                ->where('date', '=', $prevDay->format('Y-m-d'))
                ->groupBy('short_url_id')
                ->get();

            $counter = 0;
            foreach ($rows as $row) {
                DB::table('stat_daily')
                    ->insert(
                        [
                            'short_url_id' => $row->short_url_id,
                            'date' => $prevDay->format('Y-m-d'),
                            'count' => $row->count
                        ]
                    );
                DB::table('stats')
                    ->where(
                        [
                            'short_url_id' => $row->short_url_id,
                            'date' => $prevDay->format('Y-m-d')
                        ]
                    )
                    ->delete();

                $counter++;
                if ($counter > 99) {
                    sleep(10);
                    $counter = 0;
                }
            }
        } catch (Throwable) {
            echo 'Some problems by handle statistic' . PHP_EOL;
            return Command::FAILURE;
        }
        echo 'Statistic successfully handled' . PHP_EOL;
        return Command::SUCCESS;
    }
}
