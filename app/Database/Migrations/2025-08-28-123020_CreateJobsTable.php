<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateJobsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'job_title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'company_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'company' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'job_description' => [
                'type' => 'TEXT',
            ],
            'location' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'employment_type' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'experience_level' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'salary_range' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'work_arrangement' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'contact_info' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'application_deadline' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'education_requirements' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'skills' => [
                'type' => 'TEXT', // Changed from JSON to TEXT for better compatibility
                'null' => true,
            ],
            'requirements' => [
                'type' => 'TEXT', // Changed from JSON to TEXT for better compatibility
                'null' => true,
            ],
            'responsibilities' => [
                'type' => 'TEXT', // Changed from JSON to TEXT for better compatibility
                'null' => true,
            ],
            'benefits' => [
                'type' => 'TEXT', // Changed from JSON to TEXT for better compatibility
                'null' => true,
            ],
            'preferred_qualifications' => [
                'type' => 'TEXT', // Changed from JSON to TEXT for better compatibility
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('jobs');
    }

    public function down()
    {
        $this->forge->dropTable('jobs');
    }
}