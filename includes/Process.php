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
        add_action('wp_ajax_dcms_get_available_hours',[ $this, 'get_available_hours' ]);

        add_action('wp_ajax_nopriv_dcms_save_new_user',[ $this, 'save_new_user' ]);
        add_action('wp_ajax_dcms_save_new_user',[ $this, 'save_new_user' ]);
    }

    // Front-end new user
    // -------------------

    // Fill data - Get hours specific day
    public function get_available_hours(){
        $type       = $_POST['type']??null;
        $date       = $_POST['date']??'';
        $day_name   = $_POST['dayname']??'';
        $hours      = [];

        $db = new Database();

        switch ($type) {
            case 'cal-new-user':
                $hours = $db->get_available_hours_new_user($date, $day_name);
                break;
            case 'cal-change-seats':
                // $hours = $db->get_available_hours_new_user($date, $day_name);
                break;
        }


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
        if ( $db->save_reservation_new_user($values) ){
            // Send email reservation new user
            $this->send_email_new_user($values['email'], $values['day'], $values['hour']);

            $res = [
                'status' => 1,
                'message' => "✅ Se ha realizado su reserva correctamente",
            ];

        } else {
            $res = [
                'status' => 0,
                'message' => "Ocurrió algún error al guardar la reserva",
            ];
        }

        echo json_encode($res);
        wp_die();
    }

    // Send email for new users (alta abonados)
    private function send_email_new_user( $email, $date, $hour ){
        $options = get_option( 'dcms_newusers_options' );

        add_filter( 'wp_mail_from', function(){
            $options = get_option( 'dcms_newusers_options' );
            return $options['dcms_sender_email'];
        });
        add_filter( 'wp_mail_from_name', function(){
            $options = get_option( 'dcms_newusers_options' );
            return $options['dcms_sender_name'];
        });

        $headers = ['Content-Type: text/html; charset=UTF-8'];
        $subject = $options['dcms_subject_email'];
        $body    = $options['dcms_text_email'];
        $body = str_replace( '%date%', $date, $body );
        $body = str_replace( '%hour%', $hour, $body );

        return wp_mail( $email, $subject, $body, $headers );
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

// TODO:
// Eliminar reservas de nuevos aboonados y de cambio de asientos.

