<?php

namespace dcms\reservation\includes;

use dcms\reservation\includes\Database;

// Class for the operations of plugin
class Process{

    public function __construct(){
        // Backend
        add_action('wp_ajax_dcms_save_config',[ $this, 'process_save_config' ]);

        // Front-end
        add_action('wp_ajax_dcms_get_available_hours',[ $this, 'get_available_hours' ]);
    }

    // Front-end
    // ----------

    // Ajax callback - Get hours specific day
    public function get_available_hours(){
        $type       = $_POST['type']??null;
        $date       = $_POST['date']??'';
        $day_name   = $_POST['dayname']??'';

        error_log(print_r($day_name,true));
        error_log(print_r($date,true));
        error_log(print_r($type,true));


        $res = [
            '8:00-9:00' => 2,
            '9:00-10:00' => 3,
            '10:00-11:00' => 1,
        ];

        echo json_encode($res);
        wp_die();
    }

    // Backend
    // -------

    // Process save config
    public function process_save_config(){

        $calendar       = $_POST['calendar']??null;
        $type           = $_POST['type']??'';
        $range_start    = $_POST['range_start']??'';
        $range_end      = $_POST['range_end']??'';

        // Validate nonce
        $this->validate_nonce('ajax-nonce-config');

        try {
            // Save option mathematics
            update_option('dcms_start_'.$type, $range_start);
            update_option('dcms_end_'.$type, $range_end);

            $db = new Database();

            if ( $calendar ){
                foreach ($calendar as $str) {
                    $item = explode('|', $str);

                    $day = $item[0];
                    $hour = $item[1];
                    $qty = $item[2]?$item[2]:0;
                    $id = md5($day.$hour.$type);

                    $db->save_config_calendar($id, $day, $hour, $qty, $type);
                }
            }

            $res = [
                'status' => 1,
                'message' => "Se grabó correctamente",
            ];
        } catch (\Exception $e) {
            error_log($e->getMessage());
            $res = [
                'status' => 0,
                'message' => "Hubo un error - ".$e->getMessage(),
            ];
        }

        echo json_encode($res);
        wp_die();
    }


    private function validate_nonce( $nonce_name ){
        if ( ! wp_verify_nonce( $_POST['nonce'], $nonce_name ) ) {
            $res = [
                'status' => 0,
                'message' => '✋ Error nonce validation!!'
            ];
            echo json_encode($res);
            wp_die();
        }
    }

}