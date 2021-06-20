<?php

namespace dcms\reservation\includes;

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
            [$this, 'submenu_page_callback']
        );

        add_submenu_page(
            DCMS_RESERVATION_SUBMENU,
            __('Alta abonados','dcms-reservation'),
            __('Alta abonados','dcms-reservation'),
            'manage_options',
            'new-users',
            [$this, 'submenu_page_callback']
        );

        add_submenu_page(
            DCMS_RESERVATION_SUBMENU,
            __('Cambio asientos','dcms-reservation'),
            __('Cambio asientos','dcms-reservation'),
            'manage_options',
            'seat-change',
            [$this, 'submenu_page_callback']
        );
    }

    // Callback, show view
    public function submenu_page_callback(){
        // include_once (DCMS_RESERVATION_PATH. '/views/settings-main.php');
        echo "hola";
    }
}