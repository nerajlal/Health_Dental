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
            [
                'name' => 'Premium Medical Inc.',
                'email' => 'distributor4@dental.com',
                'password' => Hash::make('password'),
                'role' => 'distributor',
                'phone' => '5678901234',
                'address' => '321 Premium Road, Boston, MA 02101',
                'business_registration' => 'REG901234',
                'is_active' => true,
            ],
            [
                'name' => 'Budget Dental Supplies',
                'email' => 'distributor5@dental.com',
                'password' => Hash::make('password'),
                'role' => 'distributor',
                'phone' => '6789012345',
                'address' => '654 Economy St, Dallas, TX 75201',
                'business_registration' => 'REG567890',
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
                'phone' => '7890123456',
                'address' => '321 Dental Lane, Miami, FL 33101',
                'license_number' => 'LIC001',
                'is_active' => true,
            ],
            [
                'name' => 'Perfect Teeth Clinic',
                'email' => 'clinic2@dental.com',
                'password' => Hash::make('password'),
                'role' => 'clinic',
                'phone' => '8901234567',
                'address' => '654 Care Road, Houston, TX 77001',
                'license_number' => 'LIC002',
                'is_active' => true,
            ],
            [
                'name' => 'Family Dental Care',
                'email' => 'clinic3@dental.com',
                'password' => Hash::make('password'),
                'role' => 'clinic',
                'phone' => '9012345678',
                'address' => '987 Health Plaza, Phoenix, AZ 85001',
                'license_number' => 'LIC003',
                'is_active' => true,
            ],
        ];

        foreach ($clinics as $clinicData) {
            User::create($clinicData);
        }

        // Create Products with Competition
        $products = [
            // ========== DENTAL GLOVES - LATEX (Competition) ==========
            // Distributor 1 - Mid-range price
            [
                'distributor_id' => 2,
                'name' => 'Dental Gloves - Latex',
                'sku' => 'DG-LAT-100-M1',
                'description' => 'Premium quality latex dental gloves, powder-free',
                'company' => 'SafeGlove Inc.',
                'category' => 'PPE',
                'base_price' => 15.99,
                'admin_margin' => 3.00,
                'stock_quantity' => 500,
                'unit' => 'box',
                'is_active' => true,
                'status' => 'approved',
            ],
            // Distributor 3 - Highest price
            [
                'distributor_id' => 4,
                'name' => 'Dental Gloves - Latex Premium',
                'sku' => 'DG-LAT-100-G3',
                'description' => 'Ultra-premium latex gloves with superior fit',
                'company' => 'GloveMaster Pro',
                'category' => 'PPE',
                'base_price' => 18.99,
                'admin_margin' => 3.50,
                'stock_quantity' => 400,
                'unit' => 'box',
                'is_active' => true,
                'status' => 'approved',
            ],
            // Distributor 5 - LOWEST price (Winner!)
            [
                'distributor_id' => 6,
                'name' => 'Dental Gloves - Latex Economy',
                'sku' => 'DG-LAT-100-B5',
                'description' => 'Budget-friendly latex gloves, great value',
                'company' => 'ValueGlove Co.',
                'category' => 'PPE',
                'base_price' => 12.99,
                'admin_margin' => 2.50,
                'stock_quantity' => 1000,
                'unit' => 'box',
                'is_active' => true,
                'status' => 'approved',
            ],

            // ========== DENTAL GLOVES - NITRILE (Competition) ==========
            // Distributor 2 - Mid-range
            [
                'distributor_id' => 3,
                'name' => 'Dental Gloves - Nitrile',
                'sku' => 'DG-NIT-100-D2',
                'description' => 'High-quality nitrile dental gloves, powder-free',
                'company' => 'MedGlove Pro',
                'category' => 'PPE',
                'base_price' => 19.99,
                'admin_margin' => 3.50,
                'stock_quantity' => 750,
                'unit' => 'box',
                'is_active' => true,
                'status' => 'approved',
            ],
            // Distributor 4 - LOWEST price
            [
                'distributor_id' => 5,
                'name' => 'Dental Gloves - Nitrile Pro',
                'sku' => 'DG-NIT-100-P4',
                'description' => 'Professional-grade nitrile gloves',
                'company' => 'ProGlove Systems',
                'category' => 'PPE',
                'base_price' => 17.99,
                'admin_margin' => 3.00,
                'stock_quantity' => 600,
                'unit' => 'box',
                'is_active' => true,
                'status' => 'approved',
            ],
            // Distributor 1 - Highest price
            [
                'distributor_id' => 2,
                'name' => 'Dental Gloves - Nitrile Ultra',
                'sku' => 'DG-NIT-100-M1',
                'description' => 'Ultra-durable nitrile gloves',
                'company' => 'SafeGlove Inc.',
                'category' => 'PPE',
                'base_price' => 21.99,
                'admin_margin' => 4.00,
                'stock_quantity' => 500,
                'unit' => 'box',
                'is_active' => true,
                'status' => 'approved',
            ],

            // ========== COMPOSITE RESIN (Competition) ==========
            // Distributor 1 - Highest price
            [
                'distributor_id' => 2,
                'name' => 'Dental Composite Resin',
                'sku' => 'DCR-A2-5G-M1',
                'description' => 'Universal composite resin, A2 shade',
                'company' => 'RestoFill Pro',
                'category' => 'Restorative',
                'base_price' => 45.00,
                'admin_margin' => 8.00,
                'stock_quantity' => 200,
                'unit' => 'syringe',
                'is_active' => true,
                'status' => 'approved',
            ],
            // Distributor 2 - Mid-range
            [
                'distributor_id' => 3,
                'name' => 'Dental Composite Resin A2',
                'sku' => 'DCR-A2-5G-D2',
                'description' => 'Premium composite resin, shade A2',
                'company' => 'DentalFill Plus',
                'category' => 'Restorative',
                'base_price' => 42.00,
                'admin_margin' => 7.50,
                'stock_quantity' => 250,
                'unit' => 'syringe',
                'is_active' => true,
                'status' => 'approved',
            ],
            // Distributor 5 - LOWEST price
            [
                'distributor_id' => 6,
                'name' => 'Dental Composite Resin Economy',
                'sku' => 'DCR-A2-5G-B5',
                'description' => 'Value composite resin, A2 shade',
                'company' => 'EconoFill',
                'category' => 'Restorative',
                'base_price' => 38.00,
                'admin_margin' => 7.00,
                'stock_quantity' => 300,
                'unit' => 'syringe',
                'is_active' => true,
                'status' => 'approved',
            ],

            // ========== DISPOSABLE MASKS (Competition) ==========
            // Distributor 1 - LOWEST price
            [
                'distributor_id' => 2,
                'name' => 'Disposable Masks',
                'sku' => 'DM-3PLY-50-M1',
                'description' => '3-ply surgical masks, box of 50',
                'company' => 'SafeGuard Medical',
                'category' => 'PPE',
                'base_price' => 8.50,
                'admin_margin' => 1.50,
                'stock_quantity' => 1000,
                'unit' => 'box',
                'is_active' => true,
                'status' => 'approved',
            ],
            // Distributor 3 - Highest price
            [
                'distributor_id' => 4,
                'name' => 'Disposable Masks Premium',
                'sku' => 'DM-3PLY-50-G3',
                'description' => 'Premium 3-ply masks with ear loops',
                'company' => 'MaskMaster Pro',
                'category' => 'PPE',
                'base_price' => 11.99,
                'admin_margin' => 2.00,
                'stock_quantity' => 800,
                'unit' => 'box',
                'is_active' => true,
                'status' => 'approved',
            ],
            // Distributor 2 - Mid-range
            [
                'distributor_id' => 3,
                'name' => 'Disposable Masks Standard',
                'sku' => 'DM-3PLY-50-D2',
                'description' => 'Standard 3-ply surgical masks',
                'company' => 'HealthShield',
                'category' => 'PPE',
                'base_price' => 9.99,
                'admin_margin' => 1.75,
                'stock_quantity' => 900,
                'unit' => 'box',
                'is_active' => true,
                'status' => 'approved',
            ],

            // ========== LIDOCAINE ANESTHETIC (Competition) ==========
            // Distributor 2 - Mid-range
            [
                'distributor_id' => 3,
                'name' => 'Dental Anesthetic - Lidocaine',
                'sku' => 'DA-LID-50-D2',
                'description' => 'Lidocaine 2% with epinephrine',
                'company' => 'AnestheCare',
                'category' => 'Anesthetics',
                'base_price' => 35.00,
                'admin_margin' => 6.00,
                'stock_quantity' => 300,
                'unit' => 'cartridge',
                'is_active' => true,
                'status' => 'approved',
            ],
            // Distributor 4 - LOWEST price
            [
                'distributor_id' => 5,
                'name' => 'Dental Anesthetic - Lidocaine 2%',
                'sku' => 'DA-LID-50-P4',
                'description' => 'Professional lidocaine 2% solution',
                'company' => 'NumboMed',
                'category' => 'Anesthetics',
                'base_price' => 32.00,
                'admin_margin' => 5.50,
                'stock_quantity' => 400,
                'unit' => 'cartridge',
                'is_active' => true,
                'status' => 'approved',
            ],
            // Distributor 1 - Highest price
            [
                'distributor_id' => 2,
                'name' => 'Dental Anesthetic - Lidocaine Premium',
                'sku' => 'DA-LID-50-M1',
                'description' => 'Premium lidocaine with epinephrine',
                'company' => 'SafeGlove Inc.',
                'category' => 'Anesthetics',
                'base_price' => 38.00,
                'admin_margin' => 6.50,
                'stock_quantity' => 250,
                'unit' => 'cartridge',
                'is_active' => true,
                'status' => 'approved',
            ],

            // ========== DENTAL BURS KIT (Competition) ==========
            // Distributor 2 - Highest price
            [
                'distributor_id' => 3,
                'name' => 'Dental Burs Kit',
                'sku' => 'DBK-AST-20-D2',
                'description' => 'Assorted carbide burs, 20-piece set',
                'company' => 'PrecisionDrill Co.',
                'category' => 'Instruments',
                'base_price' => 65.00,
                'admin_margin' => 12.00,
                'stock_quantity' => 150,
                'unit' => 'kit',
                'is_active' => true,
                'status' => 'approved',
            ],
            // Distributor 5 - LOWEST price
            [
                'distributor_id' => 6,
                'name' => 'Dental Burs Kit Economy',
                'sku' => 'DBK-AST-20-B5',
                'description' => 'Budget carbide burs kit, 20 pieces',
                'company' => 'DrillBudget',
                'category' => 'Instruments',
                'base_price' => 55.00,
                'admin_margin' => 10.00,
                'stock_quantity' => 200,
                'unit' => 'kit',
                'is_active' => true,
                'status' => 'approved',
            ],
            // Distributor 4 - Mid-range
            [
                'distributor_id' => 5,
                'name' => 'Dental Burs Kit Professional',
                'sku' => 'DBK-AST-20-P4',
                'description' => 'Professional carbide burs, 20-pc',
                'company' => 'ProDrill Systems',
                'category' => 'Instruments',
                'base_price' => 60.00,
                'admin_margin' => 11.00,
                'stock_quantity' => 175,
                'unit' => 'kit',
                'is_active' => true,
                'status' => 'approved',
            ],

            // ========== UNIQUE PRODUCTS (No competition) ==========
            // Distributor 3
            [
                'distributor_id' => 4,
                'name' => 'Dental X-Ray Film',
                'sku' => 'DXF-D-100',
                'description' => 'Digital X-ray film, size D, pack of 100',
                'company' => 'ImageTech Dental',
                'category' => 'Imaging',
                'base_price' => 28.00,
                'admin_margin' => 5.00,
                'stock_quantity' => 400,
                'unit' => 'pack',
                'is_active' => true,
                'status' => 'approved',
            ],
            // Distributor 3
            [
                'distributor_id' => 4,
                'name' => 'Dental Cotton Rolls',
                'sku' => 'DCR-M-2000',
                'description' => 'Medium cotton rolls, pack of 2000',
                'company' => 'CottonCare',
                'category' => 'Consumables',
                'base_price' => 12.00,
                'admin_margin' => 2.00,
                'stock_quantity' => 800,
                'unit' => 'pack',
                'is_active' => true,
                'status' => 'approved',
            ],
            // Distributor 3
            [
                'distributor_id' => 4,
                'name' => 'Dental Articulating Paper',
                'sku' => 'DAP-BL-200',
                'description' => 'Blue articulating paper, 200 sheets',
                'company' => 'BiteCheck',
                'category' => 'Consumables',
                'base_price' => 9.50,
                'admin_margin' => 1.50,
                'stock_quantity' => 600,
                'unit' => 'book',
                'is_active' => true,
                'status' => 'approved',
            ],
            // Distributor 3
            [
                'distributor_id' => 4,
                'name' => 'Dental Impression Material',
                'sku' => 'DIM-VPS-SET',
                'description' => 'VPS impression material, fast set',
                'company' => 'ImpressionPro',
                'category' => 'Impression',
                'base_price' => 55.00,
                'admin_margin' => 10.00,
                'stock_quantity' => 250,
                'unit' => 'cartridge',
                'is_active' => true,
                'status' => 'approved',
            ],
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }

        echo "\n✅ Database seeded successfully with competition data!\n\n";
        echo "🏆 COMPETITION TEST DATA:\n";
        echo "==========================\n\n";
        
        echo "📦 PRODUCT COMPETITION OVERVIEW:\n";
        echo "--------------------------------\n";
        echo "1. Dental Gloves - Latex:\n";
        echo "   🥇 Budget Dental (Dist 5): \$12.99 - LOWEST ✅\n";
        echo "   🥈 MedSupply Co. (Dist 1): \$15.99\n";
        echo "   🥉 Global Dental (Dist 3): \$18.99 - HIGHEST\n\n";
        
        echo "2. Dental Gloves - Nitrile:\n";
        echo "   🥇 Premium Medical (Dist 4): \$17.99 - LOWEST ✅\n";
        echo "   🥈 DentalPro (Dist 2): \$19.99\n";
        echo "   🥉 MedSupply Co. (Dist 1): \$21.99 - HIGHEST\n\n";
        
        echo "3. Composite Resin:\n";
        echo "   🥇 Budget Dental (Dist 5): \$38.00 - LOWEST ✅\n";
        echo "   🥈 DentalPro (Dist 2): \$42.00\n";
        echo "   🥉 MedSupply Co. (Dist 1): \$45.00 - HIGHEST\n\n";
        
        echo "4. Disposable Masks:\n";
        echo "   🥇 MedSupply Co. (Dist 1): \$8.50 - LOWEST ✅\n";
        echo "   🥈 DentalPro (Dist 2): \$9.99\n";
        echo "   🥉 Global Dental (Dist 3): \$11.99 - HIGHEST\n\n";
        
        echo "5. Lidocaine Anesthetic:\n";
        echo "   🥇 Premium Medical (Dist 4): \$32.00 - LOWEST ✅\n";
        echo "   🥈 DentalPro (Dist 2): \$35.00\n";
        echo "   🥉 MedSupply Co. (Dist 1): \$38.00 - HIGHEST\n\n";
        
        echo "6. Dental Burs Kit:\n";
        echo "   🥇 Budget Dental (Dist 5): \$55.00 - LOWEST ✅\n";
        echo "   🥈 Premium Medical (Dist 4): \$60.00\n";
        echo "   🥉 DentalPro (Dist 2): \$65.00 - HIGHEST\n\n";
        
        echo "Login Credentials:\n";
        echo "===================\n";
        echo "Admin:\n";
        echo "  📧 Email: admin@dental.com\n";
        echo "  🔑 Password: password\n\n";
        
        echo "Distributors (5 total):\n";
        echo "  📧 Email: distributor1@dental.com (MedSupply Co.)\n";
        echo "  📧 Email: distributor2@dental.com (DentalPro Distributors)\n";
        echo "  📧 Email: distributor3@dental.com (Global Dental Supplies)\n";
        echo "  📧 Email: distributor4@dental.com (Premium Medical Inc.)\n";
        echo "  📧 Email: distributor5@dental.com (Budget Dental Supplies)\n";
        echo "  🔑 Password: password\n\n";
        
        echo "Clinics (3 total):\n";
        echo "  📧 Email: clinic1@dental.com / clinic2@dental.com / clinic3@dental.com\n";
        echo "  🔑 Password: password\n\n";
        
        echo "🧪 TEST THE COMPETITION FEATURE:\n";
        echo "=================================\n";
        echo "1. Login as distributor1@dental.com\n";
        echo "2. Go to Competition menu\n";
        echo "3. See all competitor products\n";
        echo "4. Click 'View Rankings' on any product\n";
        echo "5. See where you rank against competitors!\n\n";
    }
}