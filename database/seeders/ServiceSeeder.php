<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            ['name' => 'POP False Ceiling', 'category' => 'Ceiling Work', 'unit' => 'sq.ft', 'default_rate' => 75.00, 'hsn_code' => '9954', 'gst_percentage' => 18.00],
            ['name' => 'Gypsum False Ceiling', 'category' => 'Ceiling Work', 'unit' => 'sq.ft', 'default_rate' => 110.00, 'hsn_code' => '9954', 'gst_percentage' => 18.00],
            ['name' => 'Grid False Ceiling', 'category' => 'Ceiling Work', 'unit' => 'sq.ft', 'default_rate' => 65.00, 'hsn_code' => '9954', 'gst_percentage' => 18.00],
            ['name' => 'Wall Painting (Interior)', 'category' => 'Painting', 'unit' => 'sq.ft', 'default_rate' => 18.00, 'hsn_code' => '9954', 'gst_percentage' => 18.00],
            ['name' => 'Wall Painting (Exterior)', 'category' => 'Painting', 'unit' => 'sq.ft', 'default_rate' => 22.00, 'hsn_code' => '9954', 'gst_percentage' => 18.00],
            ['name' => 'Texture Painting', 'category' => 'Painting', 'unit' => 'sq.ft', 'default_rate' => 35.00, 'hsn_code' => '9954', 'gst_percentage' => 18.00],
            ['name' => 'Modular Kitchen', 'category' => 'Kitchen', 'unit' => 'sq.ft', 'default_rate' => 1500.00, 'hsn_code' => '9403', 'gst_percentage' => 18.00],
            ['name' => 'Wardrobe (Sliding)', 'category' => 'Furniture', 'unit' => 'sq.ft', 'default_rate' => 950.00, 'hsn_code' => '9403', 'gst_percentage' => 18.00],
            ['name' => 'Wardrobe (Hinged)', 'category' => 'Furniture', 'unit' => 'sq.ft', 'default_rate' => 850.00, 'hsn_code' => '9403', 'gst_percentage' => 18.00],
            ['name' => 'Electrical Wiring', 'category' => 'Electrical', 'unit' => 'point', 'default_rate' => 350.00, 'hsn_code' => '9954', 'gst_percentage' => 18.00],
            ['name' => 'Plumbing Work', 'category' => 'Plumbing', 'unit' => 'point', 'default_rate' => 450.00, 'hsn_code' => '9954', 'gst_percentage' => 18.00],
            ['name' => 'Flooring (Tiles)', 'category' => 'Flooring', 'unit' => 'sq.ft', 'default_rate' => 55.00, 'hsn_code' => '9954', 'gst_percentage' => 18.00],
            ['name' => 'Flooring (Wooden)', 'category' => 'Flooring', 'unit' => 'sq.ft', 'default_rate' => 120.00, 'hsn_code' => '9954', 'gst_percentage' => 18.00],
            ['name' => 'Civil Work', 'category' => 'Civil', 'unit' => 'sq.ft', 'default_rate' => 200.00, 'hsn_code' => '9954', 'gst_percentage' => 18.00],
            ['name' => 'Demolition Work', 'category' => 'Civil', 'unit' => 'lump sum', 'default_rate' => 5000.00, 'hsn_code' => '9954', 'gst_percentage' => 18.00],
        ];

        foreach ($services as $service) {
            Service::firstOrCreate(['name' => $service['name']], $service);
        }
    }
}
