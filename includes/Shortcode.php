<?php

namespace dcms\reservation\includes;

use dcms\reservation\includes\Database;

// Class for grouping shortcodes functionality
class Shortcode{

    public function __construct(){
        add_action( 'init', [$this, 'create_shortcodes'] );
    }

    // Function to add shortcodes
    public function create_shortcodes(){
        add_shortcode(DCMS_SHORTCODE_NEW_USER, [ $this, 'show_new_user_form' ]);
        add_shortcode(DCMS_SHORTCODE_CHANGE_SEATS, [ $this, 'show_change_seats_form' ]);
    }

    // Function show user account in the front-end
    public function show_new_user_form(){

        if ( is_user_logged_in() ){
            return "Para ver este formulario debes ser un usuario visitante";
        }

        wp_enqueue_script('moment-script');
        wp_enqueue_script('calendar-script');
        wp_enqueue_script('reservation-script');

        wp_enqueue_style('calendar-style');
        wp_enqueue_style('reservation-style');

        $db = new Database();
        $available_days = $db->get_available_days('new-users');
        $start_date = get_option(DCMS_RANGE_NEW_USERS_START);
        $end_date = get_option(DCMS_RANGE_NEW_USERS_END);

        wp_localize_script('reservation-script',
                            'dcms_new_user',
                            [ 'ajaxurl'=>admin_url('admin-ajax.php'),
                              'available_days' => $available_days,
                              'start_date' => $start_date,
                              'end_date' => $end_date,
                              'nonce' => wp_create_nonce('ajax-nonce-new-user')]);

        ob_start();
            include_once DCMS_RESERVATION_PATH.'views/form-new-users.php';
            $html_code = ob_get_contents();
        ob_end_clean();

        return $html_code;

    }

    // Function to show change seats in front-end
    public function show_change_seats_form(){

        if ( ! is_user_logged_in() ){
            return "Para ver este formulario debes ser un usuario conectado";
        }

        wp_enqueue_script('moment-script');
        wp_enqueue_script('calendar-script');
        wp_enqueue_script('reservation-script');

        wp_enqueue_style('calendar-style');
        wp_enqueue_style('reservation-style');

        $available_days = ['lunes', 'martes', 'miércoles'];
        $start_date = '2021-06-30';
        $end_date = '2021-07-30';

        wp_localize_script('reservation-script',
                            'dcms_change_seats',
                            [ 'ajaxurl'=>admin_url('admin-ajax.php'),
                            'available_days' => $available_days,
                            'start_date' => $start_date,
                            'end_date' => $end_date,
                            'nonce' => wp_create_nonce('ajax-nonce-change-seats')]);

        ob_start();
            include_once DCMS_RESERVATION_PATH.'views/form-change-seats.php';
            $html_code = ob_get_contents();
        ob_end_clean();

        return $html_code;
    }
}