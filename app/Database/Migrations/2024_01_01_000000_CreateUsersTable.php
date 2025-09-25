<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
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
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
            ],
            'full_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false,
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'email_verified' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
            ],
            'magic_link_token' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'token_expires' => [
                'type' => 'DATETIME',
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

        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('username');
        $this->forge->addUniqueKey('email');
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}