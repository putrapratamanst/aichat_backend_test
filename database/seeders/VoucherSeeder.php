<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class VoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $faker = Faker::create();

        for ($i = 1; $i <= 1000; $i++) {
            // insert data to voucher table use Faker
            DB::table('voucher')->insert([
                'code'              => $faker->regexify("[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}"),
                'is_locked'         => false,
                'submission_time'   => NULL,
                'lockdown_time'     => NULL,
                'exception'         => ""
            ]);
        }
    }
}
