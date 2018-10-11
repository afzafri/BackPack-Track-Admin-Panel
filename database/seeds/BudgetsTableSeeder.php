<?php

use Illuminate\Database\Seeder;

class BudgetsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('budgets')->insert([
            ['type' => "Food"],
            ['type' => "Transportation"],
            ['type' => "Accommodation"],
            ['type' => "Sightseeing"],
            ['type' => "Shopping"],
            ['type' => "Activity Fee"],
            ['type' => "Other"],
        ]);
    }
}
