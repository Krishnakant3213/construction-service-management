<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // Company settings
            ['key' => 'company_name', 'value' => 'Your Construction Company', 'group' => 'company'],
            ['key' => 'company_email', 'value' => 'info@example.com', 'group' => 'company'],
            ['key' => 'company_phone', 'value' => '+91 98765 43210', 'group' => 'company'],
            ['key' => 'company_address', 'value' => '123, Business Park, City, State - 400001', 'group' => 'company'],
            ['key' => 'company_gstin', 'value' => '', 'group' => 'company'],
            ['key' => 'company_pan', 'value' => '', 'group' => 'company'],

            // Tax settings
            ['key' => 'default_gst_percentage', 'value' => '18', 'group' => 'tax'],
            ['key' => 'tax_type', 'value' => 'intra_state', 'group' => 'tax'], // intra_state or inter_state

            // Quotation settings
            ['key' => 'quotation_prefix', 'value' => 'QT', 'group' => 'quotation'],
            ['key' => 'quotation_validity_days', 'value' => '30', 'group' => 'quotation'],
            ['key' => 'default_terms_and_conditions', 'value' => "1. Payment terms: 50% advance, 30% on material delivery, 20% on completion.\n2. Work will commence within 7 days of advance payment.\n3. Any additional work not mentioned in this quotation will be charged extra.\n4. Warranty: 1 year from date of completion.\n5. Prices are inclusive of material and labour charges.", 'group' => 'quotation'],

            // Notification settings
            ['key' => 'notify_on_new_lead', 'value' => 'true', 'group' => 'notification'],
            ['key' => 'notify_on_quotation_approved', 'value' => 'true', 'group' => 'notification'],
            ['key' => 'notify_on_payment_received', 'value' => 'true', 'group' => 'notification'],
        ];

        foreach ($settings as $setting) {
            Setting::setValue($setting['key'], $setting['value'], $setting['group']);
        }
    }
}
