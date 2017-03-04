<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Update extends CI_Migration {

    public function up() {
        $mod = array(
            'version' => array( 'name' => 'version', 'constraint' => '10' )
        );
        $this->dbforge->modify_column('settings', $mod);
    }

}