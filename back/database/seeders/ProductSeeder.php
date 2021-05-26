<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            // free weights
            [
                'name' => 'Olympic Barbell',
                'price' => 120,
                'description' => '20kg - Stainless Steel',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Dumbbell',
                'price' => 40,
                'description' => '15kg - Steel',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Kettlebell',
                'price' => 69.9,
                'description' => '27.5kg - Steel',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Plate',
                'price' => 40,
                'description' => '20kg - Steel',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Fitness Band',
                'price' => 22.5,
                'description' => '5kg resistance - Rubber',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Hexagon Dumbbell',
                'price' => 20,
                'description' => '10kg - Steel',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Bike Weights',
                'price' => 12,
                'description' => '2.5kg - Steel',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            // racks
            [
                'name' => 'Power Personal',
                'price' => 2500,
                'description' => 'The core solution for your strength workout at home. Includes Dumbbells, Barbell, Bench, Discs kit and Smith Machine Rack',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Flat Bench Personal',
                'price' => 330.5,
                'description' => 'Modern manufacturing technology embraces elegance and craftsmanship, using machined aluminium to represent a new standard in the industry.',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Adjustable Bench',
                'price' => 430.5,
                'description' => "This multi-purpose bench has a simple, compact design created specifically for barbell and dumbbell workouts. It's easy to store and move around, even at home, with integrated wheels and handle.",
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            // tools
            [
                'name' => 'Exercise Floor Mat',
                'price' => 85,
                'description' => "The thick foam and anti-slip surface make the Exercise Mat a convenient tool to perform both stretching and strength exercises safely and comfortably on the floor, without it shifting, folding or moving during exercise.",
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Foam Roller',
                'price' => 65,
                'description' => "The foam is more firm in the center and softer at the edges, providing variable stimulation.",
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            // more
            [
                'name' => 'Dumbbell',
                'price' => 75,
                'description' => '30kg - Steel',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Kettlebell',
                'price' => 45,
                'description' => '16 - Steel',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Bike Weights',
                'price' => 28,
                'description' => '5kg - Steel',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Bike Weights',
                'price' => 9,
                'description' => '1.2kg - Steel',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Fitness Band',
                'price' => 42.5,
                'description' => '10kg resistance - Rubber',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Plate',
                'price' => 60,
                'description' => '25kg - Steel',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Bumper Plate',
                'price' => 25,
                'description' => '10kg - Steel',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Bumper Plate',
                'price' => 17.5,
                'description' => '5kg - Steel',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
        ];

        DB::table('products')->insert($products);
    }
}
