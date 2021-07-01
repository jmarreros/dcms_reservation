<?php

namespace dcms\reservation\includes;

// Custom post type class
class Enqueue{

    public function __construct(){
        add_action('wp_enqueue_scripts', [$this, 'register_scripts']);
        add_action('admin_enqueue_scripts', [$this, 'register_scripts_backend']);
    }

    // Front-end script
    public function register_scripts(){
        wp_register_script('reservation-script',
                DCMS_RESERVATION_URL.'/assets/script.js',
                ['jquery', 'calendar-script'],
                DCMS_RESERVATION_VERSION,
                true);

        wp_register_style('reservation-style',
                DCMS_RESERVATION_URL.'/assets/style.css',
                [],
                DCMS_RESERVATION_VERSION );

        // Calendar
        wp_register_script('moment-script',
                'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment-with-locales.min.js',
                [],
                DCMS_RESERVATION_VERSION,
                true);

        wp_register_script('calendar-script',
                DCMS_RESERVATION_URL.'/assets/calendar/tavo-calendar.js',
                ['moment-script'],
                DCMS_RESERVATION_VERSION,
                true);

        wp_register_style('calendar-style',
                DCMS_RESERVATION_URL.'/assets/calendar/tavo-calendar.css',
                [],
                DCMS_RESERVATION_VERSION );
    }

    // Backend scripts
    public function register_scripts_backend(){

        wp_register_script('admin-reservation-script',
                            DCMS_RESERVATION_URL.'/backend/assets/script.js',
                            ['jquery'],
                            DCMS_RESERVATION_VERSION,
                            true);

        wp_register_style('admin-reservation-style',
                            DCMS_RESERVATION_URL.'/backend/assets/style.css',
                            [],
                            DCMS_RESERVATION_VERSION );

    }

}