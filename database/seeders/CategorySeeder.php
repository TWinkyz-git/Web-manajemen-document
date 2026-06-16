<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Reports', 'slug' => 'reports', 'description' => 'Business and analytical reports'],
            ['name' => 'Contracts', 'slug' => 'contracts', 'description' => 'Legal agreements and contracts'],
            ['name' => 'Invoices', 'slug' => 'invoices', 'description' => 'Invoice and billing documents'],
            ['name' => 'Presentations', 'slug' => 'presentations', 'description' => 'Slides and presentation files'],
            ['name' => 'Archive', 'slug' => 'archive', 'description' => 'Old or archived documents'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}