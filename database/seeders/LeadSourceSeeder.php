<?php

namespace Database\Seeders;

use App\Models\LeadSource;
use Illuminate\Database\Seeder;

class LeadSourceSeeder extends Seeder
{
    public function run(): void
    {
        $sources = [
            'WhatsApp',
            'Website',
            'Referral',
            'Walk-in',
            'JustDial',
            'IndiaMART',
            'Social Media',
            'Phone Call',
            'Email',
            'Other',
        ];

        foreach ($sources as $source) {
            LeadSource::firstOrCreate(['name' => $source]);
        }
    }
}
