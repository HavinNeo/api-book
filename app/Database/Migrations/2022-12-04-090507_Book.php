<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Book extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'judul' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'kode' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'pengarang' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'penerbit' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'tahun_terbit' =>
            [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'kota_terbit' =>
            [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'kota_terbit' =>
            [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'isi_konten' =>
            [
                'type' => 'VARCHAR',
                'constraint' => 10000
            ],
            'created_at' => [
                'type'           => 'DATETIME',
                'null'           => true,
            ],
            'updated_at' => [
                'type'           => 'DATETIME',
                'null'           => true,
            ]

        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('book');
    }

    public function down()
    {
        $this->forge->dropTable('book');
    }
}
