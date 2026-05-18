<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some users or create test users
        $users = User::all();
        
        if ($users->isEmpty()) {
            $users = User::factory(5)->create();
        }

        $sampleItems = [
            [
                'title' => 'Advanced Calculus Textbook',
                'description' => 'Comprehensive calculus textbook with practice problems and solutions. Excellent for engineering students.',
                'category' => 'Books & Textbooks',
                'condition' => 'Slightly Used',
                'item_type' => 'Barter',
            ],
            [
                'title' => 'Engineering Uniform Set',
                'description' => 'Complete engineering uniform set including polo shirt and pants. Size M. Never worn.',
                'category' => 'Uniforms & Apparel',
                'condition' => 'New',
                'item_type' => 'Barter',
            ],
            [
                'title' => 'Laptop Stand Aluminum',
                'description' => 'Ergonomic aluminum laptop stand for better screen positioning. Adjustable height.',
                'category' => 'Electronics',
                'condition' => 'New',
                'item_type' => 'Barter',
            ],
            [
                'title' => 'Programming Guide Book',
                'description' => 'Learn C++ and Python with practical examples. Great for beginners and intermediate learners.',
                'category' => 'Books & Textbooks',
                'condition' => 'Slightly Used',
                'item_type' => 'Donation',
            ],
            [
                'title' => 'Lab Coat Size M',
                'description' => 'White lab coat for chemistry and biology labs. Includes multiple pockets. Clean condition.',
                'category' => 'Uniforms & Apparel',
                'condition' => 'Slightly Used',
                'item_type' => 'Barter',
            ],
            [
                'title' => 'Organic Chemistry Notes',
                'description' => 'Hand-written comprehensive notes for Organic Chemistry 101. Covers first 8 chapters.',
                'category' => 'Books & Textbooks',
                'condition' => 'Slightly Used',
                'item_type' => 'Barter',
            ],
            [
                'title' => 'Physics Lab Equipment Kit',
                'description' => 'Complete physics lab kit with measuring instruments, prism, and lenses.',
                'category' => 'Lab Supplies',
                'condition' => 'Used',
                'item_type' => 'Barter',
            ],
            [
                'title' => 'Mathematics Handbook',
                'description' => 'Formula reference book for mathematics. Includes calculus, algebra, and statistics.',
                'category' => 'Books & Textbooks',
                'condition' => 'Slightly Used',
                'item_type' => 'Donation',
            ],
            [
                'title' => 'Design Software Bundle',
                'description' => 'License for Adobe Creative Suite (Photoshop, Illustrator). Valid for 1 year.',
                'category' => 'Art & Craft Supplies',
                'condition' => 'New',
                'item_type' => 'Barter',
            ],
            [
                'title' => 'Drawing Materials Set',
                'description' => 'Complete drawing set with pencils, erasers, charcoal, and sketch pads.',
                'category' => 'Art & Craft Supplies',
                'condition' => 'Slightly Used',
                'item_type' => 'Barter',
            ],
            [
                'title' => 'Biology Microscope',
                'description' => '40x-1000x optical microscope with glass slides and cover slips included.',
                'category' => 'Lab Supplies',
                'condition' => 'Slightly Used',
                'item_type' => 'Barter',
            ],
            [
                'title' => 'Computer Science Textbook',
                'description' => 'Data Structures and Algorithms in Python. Great reference for CSC courses.',
                'category' => 'Books & Textbooks',
                'condition' => 'Slightly Used',
                'item_type' => 'Barter',
            ],
            [
                'title' => 'Wireless Mechanical Keyboard',
                'description' => 'RGB backlit mechanical keyboard, blue switches. Perfect for gaming and coding.',
                'category' => 'Electronics',
                'condition' => 'Slightly Used',
                'item_type' => 'Barter',
            ],
            [
                'title' => 'Study Desk Organization Kit',
                'description' => 'Complete desk organizer with drawers, shelves, and pen holders.',
                'category' => 'Furniture',
                'condition' => 'Used',
                'item_type' => 'Barter',
            ],
            [
                'title' => 'Wireless Mouse USB',
                'description' => 'Silent wireless mouse with long battery life. Perfect for lectures and coding.',
                'category' => 'Electronics',
                'condition' => 'Slightly Used',
                'item_type' => 'Barter',
            ],
            [
                'title' => 'Scientific Calculator',
                'description' => 'Scientific calculator with graphing capabilities. Model: Casio FX-9860GII.',
                'category' => 'Electronics',
                'condition' => 'Slightly Used',
                'item_type' => 'Barter',
            ],
            [
                'title' => 'Art Canvas Pack',
                'description' => '5 blank canvas pads in various sizes. Perfect for painting and sketching.',
                'category' => 'Art & Craft Supplies',
                'condition' => 'New',
                'item_type' => 'Donation',
            ],
            [
                'title' => 'Headphones Studio Quality',
                'description' => 'Professional studio monitor headphones. Excellent sound quality for music production.',
                'category' => 'Electronics',
                'condition' => 'Slightly Used',
                'item_type' => 'Barter',
            ],
            [
                'title' => 'Chemistry Lab Manual',
                'description' => 'Complete chemistry lab procedures and safety guidelines. Full of diagrams.',
                'category' => 'Books & Textbooks',
                'condition' => 'Used',
                'item_type' => 'Donation',
            ],
            [
                'title' => 'Book Shelf Storage',
                'description' => 'Wooden book shelf with 5 compartments. Great for organizing textbooks.',
                'category' => 'Furniture',
                'condition' => 'Slightly Used',
                'item_type' => 'Barter',
            ],
            [
                'title' => 'USB Hub 7-Port',
                'description' => 'High-speed USB 3.0 hub. Compatible with all laptops and computers.',
                'category' => 'Electronics',
                'condition' => 'New',
                'item_type' => 'Barter',
            ],
            [
                'title' => 'Engineering Calculator',
                'description' => 'Full-function engineering calculator suitable for math and science courses.',
                'category' => 'Electronics',
                'condition' => 'New',
                'item_type' => 'Barter',
            ],
            [
                'title' => 'Student Desk Lamp',
                'description' => 'LED desk lamp with 3 brightness levels. Energy efficient. White color.',
                'category' => 'Furniture',
                'condition' => 'Slightly Used',
                'item_type' => 'Barter',
            ],
            [
                'title' => 'Library Research Handbook',
                'description' => 'Guide to academic research, citations, and documentation styles.',
                'category' => 'Books & Textbooks',
                'condition' => 'Used',
                'item_type' => 'Donation',
            ],
            [
                'title' => 'Stationary Supply Pack',
                'description' => 'Complete pack with notebooks, pens, markers, and highlighters.',
                'category' => 'Office Supplies',
                'condition' => 'New',
                'item_type' => 'Barter',
            ],
        ];

        // Image keywords based on categories
        $imageKeywords = [
            'Books & Textbooks' => ['textbook', 'book', 'study', 'reading'],
            'Uniforms & Apparel' => ['clothing', 'uniform', 'shirt', 'apparel'],
            'Lab Supplies' => ['laboratory', 'microscope', 'science', 'equipment'],
            'Electronics' => ['laptop', 'keyboard', 'technology', 'gadget'],
            'Furniture' => ['desk', 'furniture', 'shelf', 'storage'],
            'Art & Craft Supplies' => ['art', 'drawing', 'painting', 'canvas'],
            'Office Supplies' => ['stationery', 'notebook', 'pen', 'supplies'],
        ];

        $itemIndex = 0;
        foreach ($sampleItems as $itemData) {
            $itemData['user_id'] = $users->random()->id;
            
            // Generate stock image URL from Unsplash
            $keywords = $imageKeywords[$itemData['category']] ?? ['student', 'study'];
            $randomKeyword = $keywords[array_rand($keywords)];
            // Add some randomness with a number to get different images
            $randomNum = rand(1, 100);
            $itemData['image_url'] = "https://source.unsplash.com/400x300/?{$randomKeyword}&sig={$randomNum}";
            
            $itemData['views'] = rand(10, 500);
            $itemData['wishlist_count'] = rand(0, 50);
            $itemData['seller_rating'] = rand(40, 50) / 10;
            $itemData['status'] = 'Active';
            $itemData['posted_at'] = now()->subDays(rand(1, 30));

            Item::create($itemData);
            $itemIndex++;
        }
    }
}
