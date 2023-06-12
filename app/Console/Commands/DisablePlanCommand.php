<?php

namespace App\Console\Commands;

use App\Models\AvailedPricingPlan;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DisablePlanCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:disable-plan-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $oneDayAgo = Carbon::now()->addDay();
        AvailedPricingPlan::where('pricing_plan_type', 1)
                    ->where('is_expired', false)
                    ->whereDate('created_at', '>', $oneDayAgo)
                    ->update([
                        'is_expired' => true
                    ]);

        $oneWeekAgo = Carbon::now()->addWeek();
        AvailedPricingPlan::where('pricing_plan_type', 1)
                    ->where('is_expired', false)
                    ->whereDate('created_at', '>', $oneWeekAgo)
                    ->update([
                        'is_expired' => true
                    ]);
    }
}
