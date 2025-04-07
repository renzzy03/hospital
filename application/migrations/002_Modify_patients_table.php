<?php

defined('BASEPATH') OR exit ('no direct script access allowed');

class Migration_Modify_patients_table extends CI_Migration 
{
    public function up()
    {
        $this->dbforge->modify_column('patients',[
            'name' => [
            'name' => 'firstname',
            'type' => 'varchar',
            'constraint' => 255,
            'null' => FALSE,
        ]
    ]);

        $fields = array(
            'middlename' => array(
                'type' => 'varchar',
                'constraint' =>255,
                'null' => TRUE,
            ),
            'lastname' => array(
                'type' =>'varchar',
                'constraint' =>255,
                'null' => FALSE,
            ),
        );

        $this->dbforge->add_column('patients', $fields);
    }

    public function down()
    {
        $this->dbforge->modify_column('patients',[
            'firstname' =>[
                'name' => 'name',
                'type' => 'varchar',
                'constraint' => 255,
                'null' => FALSE,
            ]
        ]);
            
        $this->dbforge->drop_column('patients','middlename');
        $this->dbforge->drop_column('patients','lastname');
    }
}
?>


