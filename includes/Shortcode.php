<?php

namespace dcms\reservation\includes;


// Class for grouping shortcodes functionality
class Shortcode{

    public function __construct(){
        add_action( 'init', [$this, 'create_shortcodes'] );
    }

    // Function to add shortcodes
    public function create_shortcodes(){
        add_shortcode(DCMS_SHORTCODE_NEW_USER, [ $this, 'show_new_user_form' ]);
    }

    // Function show user account in the front-end
    public function show_new_user_form(){

        wp_enqueue_script('moment-script');
        wp_enqueue_script('calendar-script');
        wp_enqueue_script('reservation-script');

        wp_enqueue_style('calendar-style');
        wp_enqueue_style('reservation-style');


        ob_start();
            include_once DCMS_RESERVATION_PATH.'views/form-new-users.php';
            $html_code = ob_get_contents();
        ob_end_clean();

        return $html_code;

    }

}