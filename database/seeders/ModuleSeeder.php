<?php

namespace Database\Seeders;

use App\Models\Module;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    public function run(): void
    {
        $modules = [
            [
                'name' => 'Cardiovascular System',
                'slug' => 'cardiovascular',
                'description' => 'Heart, blood vessels, and circulatory system disorders.',
                'icon' => 'favorite',
                'image' => 'cardiovascular.png',
                'total_cases' => 0,
                'difficulty' => 'hard',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Respiratory System',
                'slug' => 'respiratory',
                'description' => 'Lungs, airways, and breathing-related disorders.',
                'icon' => 'air',
                'image' => 'respiratory.png',
                'total_cases' => 0,
                'difficulty' => 'medium',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Neurology',
                'slug' => 'neurology',
                'description' => 'Brain, spinal cord, and nervous system disorders.',
                'icon' => 'neurology',
                'image' => 'neurology.png',
                'total_cases' => 0,
                'difficulty' => 'hard',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Nephrology',
                'slug' => 'nephrology',
                'description' => 'Kidney function, renal disorders, and electrolyte balance.',
                'icon' => 'water_damage',
                'image' => 'nephrology.png',
                'total_cases' => 0,
                'difficulty' => 'medium',
                'order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Gastroenterology',
                'slug' => 'gastroenterology',
                'description' => 'Digestive system, liver, and gastrointestinal disorders.',
                'icon' => 'restaurant',
                'image' => 'gastroenterology.png',
                'total_cases' => 0,
                'difficulty' => 'medium',
                'order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Endocrinology',
                'slug' => 'endocrinology',
                'description' => 'Hormonal disorders, glands, and metabolic conditions.',
                'icon' => 'endocrinology',
                'image' => 'endocrinology.png',
                'total_cases' => 0,
                'difficulty' => 'medium',
                'order' => 6,
                'is_active' => true,
            ],
            [
                'name' => 'Hematology',
                'slug' => 'hematology',
                'description' => 'Blood disorders, anemia, and coagulation abnormalities.',
                'icon' => 'bloodtype',
                'image' => 'hematology.jpg',
                'total_cases' => 0,
                'difficulty' => 'medium',
                'order' => 7,
                'is_active' => true,
            ],
            [
                'name' => 'Pediatrics',
                'slug' => 'pediatrics',
                'description' => 'Child health, growth, development, and pediatric disorders.',
                'icon' => 'child_care',
                'image' => 'pediatrics.jpg',
                'total_cases' => 0,
                'difficulty' => 'medium',
                'order' => 8,
                'is_active' => true,
            ],
            [
                'name' => 'Immunology',
                'slug' => 'immunology',
                'description' => 'Immune system, allergies, and autoimmune disorders.',
                'icon' => 'immunology',
                'image' => 'immunology.png',
                'total_cases' => 0,
                'difficulty' => 'medium',
                'order' => 9,
                'is_active' => true,
            ],
            [
                'name' => 'Orthopedics',
                'slug' => 'orthopedics',
                'description' => 'Bone, joint, and musculoskeletal disorders.',
                'icon' => 'orthopedics',
                'image' => 'orthopedics.png',
                'total_cases' => 0,
                'difficulty' => 'medium',
                'order' => 10,
                'is_active' => true,
            ],
            [
                'name' => 'Dermatology',
                'slug' => 'dermatology',
                'description' => 'Skin conditions, rashes, and dermatological diseases.',
                'icon' => 'dermatology',
                'image' => 'dermatology.png',
                'total_cases' => 0,
                'difficulty' => 'easy',
                'order' => 11,
                'is_active' => true,
            ],
            [
                'name' => 'Ophthalmology',
                'slug' => 'ophthalmology',
                'description' => 'Eye diseases, vision disorders, and ocular conditions.',
                'icon' => 'ophthalmology',
                'image' => 'ophthalmology.png',
                'total_cases' => 0,
                'difficulty' => 'easy',
                'order' => 12,
                'is_active' => true,
            ],
            // ============ الموديولات الجديدة ============
            [
                'name' => 'Breast / Mammography',
                'slug' => 'breast-mammography',
                'description' => 'Breast diseases, mammography, and breast imaging.',
                'icon' => 'breast',
                'image' => 'breast.png',
                'total_cases' => 0,
                'difficulty' => 'medium',
                'order' => 13,
                'is_active' => true,
            ],
            [
                'name' => 'Dentistry',
                'slug' => 'dentistry',
                'description' => 'Dental, oral, and maxillofacial conditions.',
                'icon' => 'dentistry',
                'image' => 'dentistry.png',
                'total_cases' => 0,
                'difficulty' => 'easy',
                'order' => 14,
                'is_active' => true,
            ],
            [
                'name' => 'ENT (Ear, Nose, Throat)',
                'slug' => 'ent',
                'description' => 'Ear, nose, throat, head, and neck disorders.',
                'icon' => 'ent',
                'image' => 'ent.png',
                'total_cases' => 0,
                'difficulty' => 'medium',
                'order' => 15,
                'is_active' => true,
            ],
        ];

        foreach ($modules as $module) {
            Module::updateOrCreate(
                ['slug' => $module['slug']],
                $module
            );
        }

        $this->command->info('✅ ' . count($modules) . ' modules seeded successfully!');
    }
}