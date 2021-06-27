<?php

namespace dcms\reservation\includes;

use dcms\reservation\includes\Database;

// Class for the operations of plugin
class Process{

    public function __construct(){
        // Backend
        add_action('wp_ajax_dcms_save_config',[ $this, 'process_save_config' ]);

        // Front-end
        add_action('wp_ajax_nopriv_dcms_get_available_hours',[ $this, 'get_available_hours' ]);
        add_action('wp_ajax_nopriv_dcms_save_new_user',[ $this, 'save_new_user' ]);
    }

    // Front-end new user
    // -------------------

    // Fill data - Get hours specific day
    public function get_available_hours(){
        // $type       = $_POST['type']??null;
        $date       = $_POST['date']??'';
        $day_name   = $_POST['dayname']??'';

        $db = new Database();

        $hours = $db->get_available_hours_new_user($date, $day_name);

        $res = [];
        foreach ($hours as $hour) {
            if ( $hour->diff > 0 ){
                $res[$hour->range] = $hour->diff;
            }
        }

        echo json_encode($res);
        wp_die();
    }

    // Saving ajax new user reservation
    public function save_new_user(){
        $values = [
            'name'      => $_POST['name']??'',
            'lastname'  => $_POST['lastname']??'',
            'dni'       => $_POST['dni']??'',
            'email'     => $_POST['email']??'',
            'phone'     => $_POST['phone']??'',
            'day'       => $_POST['select_day']??'',
            'hour'      => $_POST['select_hour']??'',
        ];

        // Validate nonce
        $this->validate_nonce('ajax-nonce-new-user');

        // Validate fields
        $this->validate_fields_new_user($values);

        $db = new Database();
        if ( ! $db->save_reservation_new_user($values) ){
            $res = [
                'status' => 0,
                'message' => "Ocurrió algún error al guardar la reserva",
            ];
        } else {
            $res = [
                'status' => 1,
                'message' => "✅ Se ha realizado su reserva correctamente",
            ];
        }

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
                    $order = $item[3];
                    $id = md5($day.$hour.$type);

                    $db->save_config_calendar($id, $day, $hour, $qty, $order, $type);
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

    // Aux validate fields new user form
    private function validate_fields_new_user($values){
        foreach($values as $key => $value){
            if ($value == '' && $key != 'phone'){
                $res = [
                    'status' => 0,
                    'message' => "Falta algún campo requerido",
                ];
                echo json_encode($res);
                wp_die();
                break;
            }
        }
    }

    // Aux validate nonce
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