<?php

namespace dcms\reservation\includes;

use dcms\reservation\includes\Database;

// Class for the operations of plugin
class Process{

    public function __construct(){
        add_action('wp_ajax_dcms_save_config',[ $this, 'process_save_config' ]);
    }

    public function process_save_config(){

        $calendar       = $_POST['calendar']??null;
        $type           = $_POST['type']??'';
        $range_start    = $_POST['range_start']??'';
        $range_end      = $_POST['range_end']??'';

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

}