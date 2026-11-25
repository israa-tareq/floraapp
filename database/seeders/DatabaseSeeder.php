<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Flower;
use App\Models\PreMadeBouquet;
use App\Models\PackagingOption;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | FLOWERS
        |--------------------------------------------------------------------------
        */

        $flowers = [
            [
                'name' => 'Red Rose',
                'color' => 'Red',
                'price_per_stem' => 5.00,
                'stock_quantity' => 50,
                'image_path' => null,
                'is_available' => true,
            ],
            [
                'name' => 'Pink Rose',
                'color' => 'Pink',
                'price_per_stem' => 5.50,
                'stock_quantity' => 35,
                'image_path' => null,
                'is_available' => true,
            ],
            [
                'name' => 'White Tulip',
                'color' => 'White',
                'price_per_stem' => 7.00,
                'stock_quantity' => 8,
                'image_path' => null,
                'is_available' => true,
            ],
            [
                'name' => 'Yellow Sunflower',
                'color' => 'Yellow',
                'price_per_stem' => 8.00,
                'stock_quantity' => 20,
                'image_path' => null,
                'is_available' => true,
            ],
            [
                'name' => 'White Lily',
                'color' => 'White',
                'price_per_stem' => 12.00,
                'stock_quantity' => 6,
                'image_path' => null,
                'is_available' => true,
            ],
            [
                'name' => 'Purple Orchid',
                'color' => 'Purple',
                'price_per_stem' => 15.00,
                'stock_quantity' => 15,
                'image_path' => null,
                'is_available' => true,
            ],
            [
                'name' => 'Pink Carnation',
                'color' => 'Pink',
                'price_per_stem' => 6.00,
                'stock_quantity' => 4,
                'image_path' => null,
                'is_available' => true,
            ],
            [
                'name' => 'Baby Breath',
                'color' => 'White',
                'price_per_stem' => 4.00,
                'stock_quantity' => 40,
                'image_path' => null,
                'is_available' => true,
            ],
        ];

        foreach ($flowers as $flower) {
            Flower::updateOrCreate(
                ['name' => $flower['name']],
                $flower
            );
        }


        /*
        |--------------------------------------------------------------------------
        | PRE-MADE BOUQUETS
        |--------------------------------------------------------------------------
        */

        $bouquets = [
            [
                'name' => 'Romantic Red Roses',
                'description' => 'A beautiful arrangement of fresh red roses, perfect for romantic occasions.',
                'price' => 150.00,
                'stock_quantity' => 12,
                'image_path' => null,
                'is_featured' => true,
            ],
            [
                'name' => 'Pink Dream Bouquet',
                'description' => 'A soft and elegant combination of pink roses and delicate flowers.',
                'price' => 180.00,
                'stock_quantity' => 7,
                'image_path' => null,
                'is_featured' => true,
            ],
            [
                'name' => 'Sunshine Bouquet',
                'description' => 'A cheerful arrangement featuring bright yellow sunflowers.',
                'price' => 120.00,
                'stock_quantity' => 10,
                'image_path' => null,
                'is_featured' => false,
            ],
            [
                'name' => 'White Elegance',
                'description' => 'An elegant white floral arrangement suitable for weddings and special events.',
                'price' => 220.00,
                'stock_quantity' => 5,
                'image_path' => null,
                'is_featured' => true,
            ],
            [
                'name' => 'Spring Garden Bouquet',
                'description' => 'A colorful mix of seasonal flowers inspired by a spring garden.',
                'price' => 175.00,
                'stock_quantity' => 9,
                'image_path' => null,
                'is_featured' => false,
            ],
        ];

        foreach ($bouquets as $bouquet) {
            PreMadeBouquet::updateOrCreate(
                ['name' => $bouquet['name']],
                $bouquet
            );
        }


        /*
        |--------------------------------------------------------------------------
        | PACKAGING OPTIONS
        |--------------------------------------------------------------------------
        */

        $packagingOptions = [
            [
                'type' => 'wrap',
                'name' => 'Kraft Paper Wrap',
                'color' => 'Brown',
                'price' => 8.00,
                'stock_quantity' => 30,
                'image_path' => null,
            ],
            [
                'type' => 'wrap',
                'name' => 'Pink Floral Wrap',
                'color' => 'Pink',
                'price' => 12.00,
                'stock_quantity' => 5,
                'image_path' => null,
            ],
            [
                'type' => 'wrap',
                'name' => 'Transparent Wrap',
                'color' => 'Transparent',
                'price' => 6.00,
                'stock_quantity' => 25,
                'image_path' => null,
            ],
            [
                'type' => 'ribbon',
                'name' => 'Satin Ribbon',
                'color' => 'Pink',
                'price' => 5.00,
                'stock_quantity' => 40,
                'image_path' => null,
            ],
            [
                'type' => 'ribbon',
                'name' => 'Golden Ribbon',
                'color' => 'Gold',
                'price' => 7.00,
                'stock_quantity' => 8,
                'image_path' => null,
            ],
            [
                'type' => 'ribbon',
                'name' => 'White Silk Ribbon',
                'color' => 'White',
                'price' => 6.00,
                'stock_quantity' => 20,
                'image_path' => null,
            ],
            [
                'type' => 'box',
                'name' => 'Small Gift Box',
                'color' => 'White',
                'price' => 25.00,
                'stock_quantity' => 15,
                'image_path' => null,
            ],
            [
                'type' => 'box',
                'name' => 'Luxury Pink Box',
                'color' => 'Pink',
                'price' => 40.00,
                'stock_quantity' => 3,
                'image_path' => null,
            ],
            [
                'type' => 'box',
                'name' => 'Heart Shape Box',
                'color' => 'Red',
                'price' => 35.00,
                'stock_quantity' => 11,
                'image_path' => null,
            ],
        ];

        foreach ($packagingOptions as $option) {
            PackagingOption::updateOrCreate(
                ['name' => $option['name']],
                $option
            );
        }
    }
}