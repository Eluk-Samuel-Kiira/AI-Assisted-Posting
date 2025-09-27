<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CompaniesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'company_name' => 'Niajiri Platform LTD',
                'contact_name' => 'John Doe',
                'contact_email' => 'info@niajiri.co.tz',
                'contact_phone' => '+255 123 456 789',
                'url' => 'https://niajiri.co.tz/',
                'contact_fax' => null,
                'since' => 2020,
                'company_size' => '11-50 employees',
                'address1' => 'Dar es Salaam, Tanzania',
                'address2' => 'P.O. Box 1234',
                'logo' => 'niajiri-logo.png',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'company_name' => 'Tech Solutions Inc',
                'contact_name' => 'Jane Smith',
                'contact_email' => 'hr@techsolutions.com',
                'contact_phone' => '+255 987 654 321',
                'url' => 'https://techsolutions.com',
                'contact_fax' => '+255 22 123 456',
                'since' => 2018,
                'company_size' => '51-200 employees',
                'address1' => 'Arusha, Tanzania',
                'address2' => 'Njiro Complex',
                'logo' => 'tech-solutions-logo.png',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ];

        $this->db->table('companies')->insertBatch($data);
        
        echo "Companies seeded successfully!\n";
    }
}