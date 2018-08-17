<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class GenerateController extends Controller
{
    public function transfer()
    {
        $users = User::all();
        $recordsImported = 0;
        $faker = Faker::create();
        $dateTo = Carbon::now();
        $dateFrom = Carbon::now()->subMonths(6);

        foreach ($users as $user) {
            $recordsNeeded = rand(50, 500);
            $transfers = [];

            $leftInterval = clone $dateFrom;
            $rightInterval = clone $leftInterval;
            $rightInterval->endOfMonth();

            for ($i=1; $i <= $recordsNeeded; $i++ ) {

                $transferredBytes = rand(100, 10000000000000);
                $resource = $faker->url;

                if ($rightInterval->gt($dateTo) ) {
                    $leftInterval = clone $dateFrom;
                    $rightInterval = clone $leftInterval;
                    $rightInterval->endOfMonth();
                } else {
                    $leftInterval->addMonth(1)->startOfMonth();
                    $rightInterval = clone $leftInterval;
                    $rightInterval->endOfMonth();
                }

                $transfer = [
                    'transferred' => $transferredBytes,
                    'resource' => $resource,
                    'user_id' => $user->id,
                    'date' => $faker->dateTimeBetween($leftInterval, $rightInterval),
                    'created_at' => $dateTo,
                    'updated_at' => $dateTo,
                ];

                $transfers[] = $transfer;
            }
            $recordsImported += count($transfers);
            DB::table('transfers')->insert($transfers);
        }

        return response()->json([
            'transfers_count' => $recordsImported,
        ]);
    }
}
