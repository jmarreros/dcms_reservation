<?php

namespace dcms\reservation\includes;

// use dcms\reservation\includes\Database;

// Class for the operations of plugin
class Process{

    public function __construct(){
        add_action('wp_ajax_dcms_save_config',[ $this, 'process_save_config' ]);
    }

    public function process_save_config(){
        $res = [
            'status' => 0,
            'message' => "Mensaje recibido",
        ];

        echo json_encode($res);
        wp_die();
    }

}