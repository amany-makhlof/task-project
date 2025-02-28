<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = ['Technology', 'Health', 'Business', 'Education', 'Entertainment'];

        foreach ($categories as $category) {
            Category::firstOrCreate(['name' => $category]);
        }
    }
}
