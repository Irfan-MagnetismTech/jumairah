<?php

namespace Database\Seeders;

use App\Accounts\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['Current Asset','Assets'],
            ['Non Current Asset','Assets'],
            ['Current Liability','Liabilities'],
            ['Non Current Liability','Liabilities'],
            ['Operating Income','Income'],
            ['Non Operating Income','Income'],
            ['Operating Expense','Expense'],
            ['Non Operating Expense','Expense'],
        ];
        foreach ($categories as $category) {
            Category::create([
                'name' => $category[0],
                'type' => $category[1],
            ]);
        }
    }
}
