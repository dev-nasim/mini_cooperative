<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $accounts = DB::table('savings_accounts')->get();

        foreach ($accounts as $account) {
            for ($i = 1; $i <= 5; $i++) {
                $transactionDate = Carbon::now()->subMonths(5 - $i); // Generate a date for the last 5 months

                DB::table('transections')->insert([
                    'member_id'       => $account->member_id,
                    'group_id'        => rand(1, 10), // Random group ID (adjust logic as needed)
                    'coop_id'         => rand(1, 2),  // Random coop ID (adjust logic as needed)
                    's_account_id'    => $account->id,
                    'type'            => rand(1, 2), // 1=deposit, 2=withdraw
                    'transaction_date' => $transactionDate,
                    'amount'          => rand(100, 1000), // Random amount between 100 and 1000
                    'created_at'      => now(),
                    'updated_at'      => now(),
                ]);
            }
        }
    }
}
