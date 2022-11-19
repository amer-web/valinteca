<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;

class MailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $range = range(1, 1000);
        $chunksize = 3;

        foreach (array_chunk($range, $chunksize) as $chunk) {
            $emails = [];
            foreach ($chunk as $i) {
                $emails[] = [
                    'email' => $faker->unique()->email,
                    'done' => 0
                ];
            }
            \DB::table('emails')->insert($emails);
        }
    }
}
