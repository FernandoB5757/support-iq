<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::upsert(
            $this->getCatregories(),
            uniqueBy: ['name', 'slug'],
            update: ['name', 'slug']
        );
    }

    protected function getCatregories(): array
    {

        $categories = [
            'Billing',
            'Technical Support',
            'Account Management',
            'Product Inquiry',
            'Shipping & Delivery',
            'Returns & Refunds',
            'Feedback',
            'General Question',
        ];

        return array_map(
            fn (string $value) => [
                'name' => $value,
                'slug' => str($value)->slug(),
            ],
            $categories
        );
    }
}
