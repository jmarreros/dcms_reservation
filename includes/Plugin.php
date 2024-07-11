<?php

namespace dcms\reservation\includes;

use dcms\reservation\includes\Database;

// Class for the operations of plugin
class Plugin{

    public function __construct(){
        // Activation/Deactivation
        register_activation_hook( DCMS_RESERVATION_BASE_NAME, [ $this, 'dcms_activation_plugin'] );
        register_deactivation_hook( DCMS_RESERVATION_BASE_NAME, [ $this, 'dcms_deactivation_plugin'] );
    }

    public function dcms_activation_plugin(){
        // Create table
        $db = new Database();
        $db->create_table_config();
        $db->create_table_new_user();
        $db->create_table_change_seats();
    }

    public function dcms_deactivation_plugin(){

    }
}
