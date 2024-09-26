<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PmsSubscriptionIds;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class PackageExpire extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'packageexpire:packageexpires';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check package expire';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Log::info("update data start!");
        // Update status from 0 to 1
        PmsSubscriptionIds::where('status', 0)->update(['status' => 1]);
        Log::info("update data complete!");
        // Fetch all data
        $data = PmsSubscriptionIds::all();
        $currentDateTime = Carbon::now();

        foreach ($data as $value) {
            $endDateTime = Carbon::parse($value->end_date_time);
            if ($endDateTime->lessThan($currentDateTime)) {
                $value->status = 0;
                $value->save();
            }
        }

        //return Command::SUCCESS;
    }
}
