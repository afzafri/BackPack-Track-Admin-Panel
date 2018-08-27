<?php

use Illuminate\Database\Seeder;
use App\Country;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $json = File::get("database/data/countries.json");
        $data = json_decode($json);
        foreach ($data as $obj)
        {
          Country::create(array(
            'code' => $obj->code,
            'name' => $obj->name,
            'currency' => $obj->currency
          ));
        }
    }
}
