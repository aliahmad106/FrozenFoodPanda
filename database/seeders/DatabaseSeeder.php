<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Review;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Seed Admin User first
        $this->call([
            AdminUserSeeder::class
        ]);

        // Seed Users
        $users = [
            [
                'email' => 'user1@example.com',
                'name' => 'John Doe',
                'password' => bcrypt('Test@123Password!'),
                'contact_info' => '1234567890',
                'created_at' => now()
            ],
            [
                'email' => 'user2@example.com',
                'name' => 'Jane Smith',
                'password' => bcrypt('Test@123Password!'),
                'contact_info' => '0987654321',
                'created_at' => now()
            ],
            [
                'email' => 'user3@example.com',
                'name' => 'Mike Johnson',
                'password' => bcrypt('Test@123Password!'),
                'contact_info' => '5555555555',
                'created_at' => now()
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }

        // Seed Categories
        $categories = [
            ['name' => 'Frozen Meals', 'description' => 'Ready to heat complete meals'],
            ['name' => 'Homemade Dishes', 'description' => 'Freshly prepared home-style dishes'],
            ['name' => 'Desserts', 'description' => 'Frozen desserts and sweet treats'],
            ['name' => 'Side Dishes', 'description' => 'Complementary dishes and sides']
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Seed Products with Reviews
        $products = [
            // Original products
            [
                'name' => 'Chicken Biryani',
                'description' => 'Traditional Pakistani style chicken biryani with aromatic rice and tender chicken pieces',
                'price' => 12.99,
                'category_id' => 1,
                'image_url' => '/images/products/biryani.jpg',
                'is_active' => true,
                'created_at' => now(),
                'reviews' => [
                    [
                        'user_id' => 1,
                        'rating' => 5,
                        'comment' => "Best biryani I've ever had! The spices are perfect.",
                        'created_at' => now()->subDays(5)
                    ],
                    [
                        'user_id' => 2,
                        'rating' => 4,
                        'comment' => 'Very flavorful and generous portions.',
                        'created_at' => now()->subDays(3)
                    ]
                ]
            ],
            [
                'name' => 'Beef Nihari',
                'description' => 'Slow-cooked beef in rich spicy gravy',
                'price' => 15.99,
                'category_id' => 1,
                'image_url' => '/images/products/nihari.jpg',
                'is_active' => true,
                'created_at' => now(),
                'reviews' => [
                    [
                        'user_id' => 3,
                        'rating' => 5,
                        'comment' => 'Melts in your mouth! Authentic taste.',
                        'created_at' => now()->subDays(2)
                    ]
                ]
            ],
            [
                'name' => 'Gulab Jamun',
                'description' => 'Sweet milk-solid-based spherical dumplings',
                'price' => 8.99,
                'category_id' => 3,
                'image_url' => '/images/products/gulab-jamun.jpg',
                'is_active' => true,
                'created_at' => now(),
                'reviews' => [
                    [
                        'user_id' => 1,
                        'rating' => 4,
                        'comment' => 'Perfect sweetness, just like homemade!',
                        'created_at' => now()->subDays(1)
                    ],
                    [
                        'user_id' => 2,
                        'rating' => 5,
                        'comment' => 'These are absolutely delicious!',
                        'created_at' => now()->subDays(4)
                    ]
                ]
            ],
            [
                'name' => 'Chicken Karahi',
                'description' => 'Spicy chicken curry cooked in a traditional karahi',
                'price' => 13.99,
                'category_id' => 1,
                'image_url' => '/images/products/karahi.jpg',
                'is_active' => true,
                'created_at' => now(),
                'reviews' => [
                    [
                        'user_id' => 3,
                        'rating' => 4,
                        'comment' => 'Great taste, very authentic!',
                        'created_at' => now()->subDays(2)
                    ]
                ]
            ],
            [
                'name' => 'Malai Boti',
                'description' => 'Creamy marinated chicken pieces',
                'price' => 11.99,
                'category_id' => 2,
                'image_url' => '/images/products/malai-boti.jpg',
                'is_active' => true,
                'created_at' => now(),
                'reviews' => []
            ],
            [
                'name' => 'Zarda',
                'description' => 'Sweet rice with nuts and dried fruits',
                'price' => 9.99,
                'category_id' => 3,
                'image_url' => '/images/products/zarda.jpg',
                'is_active' => true,
                'created_at' => now(),
                'reviews' => []
            ],
            [
                'name' => 'Naan',
                'description' => 'Traditional Pakistani bread',
                'price' => 2.99,
                'category_id' => 4,
                'image_url' => '/images/products/naan.jpg',
                'is_active' => true,
                'created_at' => now(),
                'reviews' => []
            ],
            
            // Additional Pakistani dishes
            [
                'name' => 'Mutton Haleem',
                'description' => 'A thick stew made with mutton, lentils, wheat, and spices, slow-cooked to perfection',
                'price' => 14.99,
                'category_id' => 1,
                'image_url' => '/images/products/haleem.jpg',
                'is_active' => true,
                'created_at' => now(),
                'reviews' => []
            ],
            [
                'name' => 'Chapli Kabab',
                'description' => 'Spicy minced beef patties with pomegranate seeds, tomatoes, and a blend of traditional spices',
                'price' => 11.99,
                'category_id' => 1,
                'image_url' => '/images/products/chapli-kabab.jpg',
                'is_active' => true,
                'created_at' => now(),
                'reviews' => []
            ],
            [
                'name' => 'Aloo Keema',
                'description' => 'Minced meat cooked with potatoes and traditional Pakistani spices',
                'price' => 10.99,
                'category_id' => 2,
                'image_url' => '/images/products/aloo-keema.jpg',
                'is_active' => true,
                'created_at' => now(),
                'reviews' => []
            ],
            [
                'name' => 'Chicken Handi',
                'description' => 'Chicken cooked in a clay pot with a rich, creamy gravy made from yogurt, cream, and aromatic spices',
                'price' => 13.49,
                'category_id' => 2,
                'image_url' => '/images/products/chicken-handi.jpg',
                'is_active' => true,
                'created_at' => now(),
                'reviews' => []
            ],
            [
                'name' => 'Daal Chawal',
                'description' => 'Traditional Pakistani lentils served with aromatic basmati rice',
                'price' => 8.99,
                'category_id' => 2,
                'image_url' => '/images/products/daal-chawal.jpg',
                'is_active' => true,
                'created_at' => now(),
                'reviews' => []
            ],
            [
                'name' => 'Kheer',
                'description' => 'Creamy rice pudding flavored with cardamom and garnished with nuts',
                'price' => 7.99,
                'category_id' => 3,
                'image_url' => '/images/products/kheer.jpg',
                'is_active' => true,
                'created_at' => now(),
                'reviews' => []
            ],
            [
                'name' => 'Jalebi',
                'description' => 'Deep-fried pretzel-shaped sweets soaked in sugar syrup',
                'price' => 6.99,
                'category_id' => 3,
                'image_url' => '/images/products/jalebi.jpg',
                'is_active' => true,
                'created_at' => now(),
                'reviews' => []
            ],
            [
                'name' => 'Raita',
                'description' => 'Yogurt mixed with cucumber, mint, and spices',
                'price' => 3.99,
                'category_id' => 4,
                'image_url' => '/images/products/raita.jpg',
                'is_active' => true,
                'created_at' => now(),
                'reviews' => []
            ],
            [
                'name' => 'Aloo Paratha',
                'description' => 'Flatbread stuffed with spiced mashed potatoes, then pan-fried to golden perfection',
                'price' => 4.99,
                'category_id' => 4,
                'image_url' => '/images/products/aloo-paratha.jpg',
                'is_active' => true,
                'created_at' => now(),
                'reviews' => []
            ]
        ];

        foreach ($products as $productData) {
            $reviews = $productData['reviews'];
            unset($productData['reviews']);
            
            $product = Product::create($productData);
            
            foreach ($reviews as $reviewData) {
                $product->reviews()->create($reviewData);
            }
        }
    }
}