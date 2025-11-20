<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@dental.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '1234567890',
            'is_active' => true,
        ]);

        // Create Distributors
        $distributors = [
            [
                'name' => 'MedSupply Co.',
                'email' => 'distributor1@dental.com',
                'password' => Hash::make('password'),
                'role' => 'distributor',
                'phone' => '2345678901',
                'address' => '123 Medical Ave, New York, NY 10001',
                'business_registration' => 'REG123456',
                'is_active' => true,
            ],
            [
                'name' => 'DentalPro Distributors',
                'email' => 'distributor2@dental.com',
                'password' => Hash::make('password'),
                'role' => 'distributor',
                'phone' => '3456789012',
                'address' => '456 Healthcare Blvd, Los Angeles, CA 90001',
                'business_registration' => 'REG789012',
                'is_active' => true,
            ],
            [
                'name' => 'Global Dental Supplies',
                'email' => 'distributor3@dental.com',
                'password' => Hash::make('password'),
                'role' => 'distributor',
                'phone' => '4567890123',
                'address' => '789 Supply St, Chicago, IL 60601',
                'business_registration' => 'REG345678',
                'is_active' => true,
            ],
        ];

        foreach ($distributors as $distributorData) {
            User::create($distributorData);
        }

        // Create Clinics
        $clinics = [
            [
                'name' => 'Bright Smile Dental',
                'email' => 'clinic1@dental.com',
                'password' => Hash::make('password'),
                'role' => 'clinic',
                'phone' => '5678901234',
                'address' => '321 Dental Lane, Miami, FL 33101',
                'license_number' => 'LIC001',
                'is_active' => true,
            ],
            [
                'name' => 'Perfect Teeth Clinic',
                'email' => 'clinic2@dental.com',
                'password' => Hash::make('password'),
                'role' => 'clinic',
                'phone' => '6789012345',
                'address' => '654 Care Road, Houston, TX 77001',
                'license_number' => 'LIC002',
                'is_active' => true,
            ],
            [
                'name' => 'Family Dental Care',
                'email' => 'clinic3@dental.com',
                'password' => Hash::make('password'),
                'role' => 'clinic',
                'phone' => '7890123456',
                'address' => '987 Health Plaza, Phoenix, AZ 85001',
                'license_number' => 'LIC003',
                'is_active' => true,
            ],
        ];

        foreach ($clinics as $clinicData) {
            User::create($clinicData);
        }

        // Create Products
        $products = [
            // Distributor 1 Products
            [
                'distributor_id' => 2,
                'name' => 'Dental Gloves - Latex',
                'sku' => 'DG-LAT-100',
                'description' => 'Premium quality latex dental gloves, powder-free',
                'company' => 'SafeGlove Inc.',
                'category' => 'PPE',
                'base_price' => 15.99,
                'stock_quantity' => 500,
                'unit' => 'box',
                'is_active' => true,
            ],
            [
                'distributor_id' => 2,
                'name' => 'Dental Composite Resin',
                'sku' => 'DCR-A2-5G',
                'description' => 'Universal composite resin, A2 shade',
                'company' => 'RestoFill Pro',
                'category' => 'Restorative',
                'base_price' => 45.00,
                'stock_quantity' => 200,
                'unit' => 'syringe',
                'is_active' => true,
            ],
            [
                'distributor_id' => 2,
                'name' => 'Disposable Masks',
                'sku' => 'DM-3PLY-50',
                'description' => '3-ply surgical masks, box of 50',
                'company' => 'SafeGuard Medical',
                'category' => 'PPE',
                'base_price' => 8.50,
                'stock_quantity' => 1000,
                'unit' => 'box',
                'is_active' => true,
            ],
            
            // Distributor 2 Products
            [
                'distributor_id' => 3,
                'name' => 'Dental Gloves - Nitrile',
                'sku' => 'DG-NIT-100',
                'description' => 'High-quality nitrile dental gloves, powder-free',
                'company' => 'MedGlove Pro',
                'category' => 'PPE',
                'base_price' => 18.99,
                'stock_quantity' => 750,
                'unit' => 'box',
                'is_active' => true,
            ],
            [
                'distributor_id' => 3,
                'name' => 'Dental Anesthetic - Lidocaine',
                'sku' => 'DA-LID-50',
                'description' => 'Lidocaine 2% with epinephrine',
                'company' => 'AnestheCare',
                'category' => 'Anesthetics',
                'base_price' => 35.00,
                'stock_quantity' => 300,
                'unit' => 'cartridge',
                'is_active' => true,
            ],
            [
                'distributor_id' => 3,
                'name' => 'Dental Burs Kit',
                'sku' => 'DBK-AST-20',
                'description' => 'Assorted carbide burs, 20-piece set',
                'company' => 'PrecisionDrill Co.',
                'category' => 'Instruments',
                'base_price' => 65.00,
                'stock_quantity' => 150,
                'unit' => 'kit',
                'is_active' => true,
            ],
            
            // Distributor 3 Products
            [
                'distributor_id' => 4,
                'name' => 'Dental X-Ray Film',
                'sku' => 'DXF-D-100',
                'description' => 'Digital X-ray film, size D, pack of 100',
                'company' => 'ImageTech Dental',
                'category' => 'Imaging',
                'base_price' => 28.00,
                'stock_quantity' => 400,
                'unit' => 'pack',
                'is_active' => true,
            ],
            [
                'distributor_id' => 4,
                'name' => 'Dental Cotton Rolls',
                'sku' => 'DCR-M-2000',
                'description' => 'Medium cotton rolls, pack of 2000',
                'company' => 'CottonCare',
                'category' => 'Consumables',
                'base_price' => 12.00,
                'stock_quantity' => 800,
                'unit' => 'pack',
                'is_active' => true,
            ],
            [
                'distributor_id' => 4,
                'name' => 'Dental Articulating Paper',
                'sku' => 'DAP-BL-200',
                'description' => 'Blue articulating paper, 200 sheets',
                'company' => 'BiteCheck',
                'category' => 'Consumables',
                'base_price' => 9.50,
                'stock_quantity' => 600,
                'unit' => 'book',
                'is_active' => true,
            ],
            [
                'distributor_id' => 4,
                'name' => 'Dental Impression Material',
                'sku' => 'DIM-VPS-SET',
                'description' => 'VPS impression material, fast set',
                'company' => 'ImpressionPro',
                'category' => 'Impression',
                'base_price' => 55.00,
                'stock_quantity' => 250,
                'unit' => 'cartridge',
                'is_active' => true,
            ],
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }

        echo "\n✅ Database seeded successfully!\n\n";
        echo "Login Credentials:\n";
        echo "===================\n";
        echo "Admin:\n";
        echo "  Email: admin@dental.com\n";
        echo "  Password: password\n\n";
        echo "Distributors:\n";
        echo "  Email: distributor1@dental.com / distributor2@dental.com / distributor3@dental.com\n";
        echo "  Password: password\n\n";
        echo "Clinics:\n";
        echo "  Email: clinic1@dental.com / clinic2@dental.com / clinic3@dental.com\n";
        echo "  Password: password\n\n";
    }
}