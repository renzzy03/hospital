<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_alter_patients_add_column_birthdate_sex extends CI_Migration
{
    public function up()
    {
        $fields = [
            'birthdate' => [
                'type' => 'DATE',
                'null' => FALSE,
            ],
            'sex' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => FALSE, 
            ],
        ];

        $this->dbforge->add_column('patients', $fields);
    }

    public function down()
    {
        $this->dbforge->drop_column('patients', 'birthdate');
        $this->dbforge->drop_column('patients', 'sex');
    }
}


?>