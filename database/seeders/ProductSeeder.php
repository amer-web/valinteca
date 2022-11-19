<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Faker\Factory;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $range = range(1, 100000);
        $chunksize = 1000;

        foreach (array_chunk($range, $chunksize) as $chunk) {
            $products = [];
            foreach ($chunk as $i) {
                $products[] = [
                    'name' => $faker->unique()->name,
                ];
            }
           \DB::table('products')->insert($products);
        }
    }
}
