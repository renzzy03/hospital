<?php
defined('BASEPATH') OR exit ('no direct script access allowed');

class Migration_alter_patients_img extends CI_Migration
{
    public function up()
    {
        $fields = [
            'profile_image' =>[
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE, 
            ],
        ];
        $this->dbforge->add_column('patients', $fields);
    }

    public function down()
    {
        $this->dbforge->drop_column('patients', 'profile_image');
    }
}


?>