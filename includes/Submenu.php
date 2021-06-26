<?php

namespace dcms\reservation\includes;

use dcms\reservation\includes\Database;
use dcms\reservation\helpers\Helper;

/**
 * Class for creating a dashboard submenu
 */
class Submenu{
    // Constructor
    public function __construct(){
        add_action('admin_menu', [$this, 'register_submenu']);
    }

    // Register submenu
    public function register_submenu(){
        add_submenu_page(
            DCMS_RESERVATION_SUBMENU,
            __('Configuracion Reservas','dcms-reservation'),
            __('Configuracion Reservas','dcms-reservation'),
            'manage_options',
            'reservation-settings',
            [$this, 'submenu_configuration_callback']
        );

        add_submenu_page(
            DCMS_RESERVATION_SUBMENU,
            __('Alta abonados','dcms-reservation'),
            __('Alta abonados','dcms-reservation'),
            'manage_options',
            'new-users',
            [$this, 'submenu_new_users_callback']
        );

        add_submenu_page(
            DCMS_RESERVATION_SUBMENU,
            __('Cambio asientos','dcms-reservation'),
            __('Cambio asientos','dcms-reservation'),
            'manage_options',
            'seat-change',
            [$this, 'submenu_seats_callback']
        );
    }

    // Callback, show view
    public function submenu_configuration_callback(){
        wp_enqueue_style('admin-reservation-style');
        wp_enqueue_script('admin-reservation-script');
        wp_localize_script('admin-reservation-script','dcms_res_config',[
                'ajaxurl'=>admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('ajax-nonce-config')
            ]);

        $db = new Database();
        $days = Helper::get_days();
        $hours = Helper::get_hours();

        include_once (DCMS_RESERVATION_PATH. '/backend/views/settings-main.php');
    }

    public function submenu_new_users_callback(){
        echo "nuevos usuarios";
    }

    public function submenu_seats_callback(){
        echo "Cambio de asientos";
    }
}