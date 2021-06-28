<?php

namespace dcms\reservation\includes;

/**
 * Class for creating the settings email new users and change seats
 */
class Settings{

    public function __construct(){
        add_action('admin_init', [$this, 'init_configuration']);
    }

    // Register seccions and fields
    public function init_configuration(){
        register_setting('dcms_new_users_options_bd', 'dcms_newusers_options' );


        // New User
        add_settings_section('dcms_email_section',
                        __('Texto por defecto en correo', 'dcms-reservation'),
                                [$this,'dcms_section_cb'],
                                'dcms_newusers_sfields' );

        add_settings_field('dcms_sender_email',
                                __('Correo Emisor', 'dcms-reservation'),
                                [$this, 'dcms_section_input_cb'],
                                'dcms_newusers_sfields',
                                'dcms_email_section',
                                ['label_for' => 'dcms_sender_email',
                                    'required' => true]
        );

        add_settings_field('dcms_sender_name',
                            __('Nombre emisor', 'dcms-reservation'),
                            [$this, 'dcms_section_input_cb'],
                            'dcms_newusers_sfields',
                            'dcms_email_section',
                            ['label_for' => 'dcms_sender_name',
                                'required' => true]
        );

        add_settings_field('dcms_subject_email',
                            __('Asunto correo', 'dcms-reservation'),
                            [$this, 'dcms_section_input_cb'],
                            'dcms_newusers_sfields',
                            'dcms_email_section',
                            ['label_for' => 'dcms_subject_email',
                                'required' => true]
        );

        add_settings_field('dcms_text_email',
                            __('Texto correo', 'dcms-reservation'),
                            [$this, 'dcms_section_textarea_field'],
                            'dcms_newusers_sfields',
                            'dcms_email_section',
                            ['label_for' => 'dcms_text_email',
                             'description' => __('You can use <strong>%id%</strong> and <strong>%pin%</strong> to include the Identify and the PIN number between the text', 'dcms-reservation')]
        );
    }

    // Callback section
    public function dcms_section_cb(){
		echo '<hr/>';
	}

    // Callback input field callback
    public function dcms_section_input_cb($args){
        $id = $args['label_for'];
        $req = isset($args['required']) ? 'required' : '';
        $class = isset($args['class']) ? "class='".$args['class']."'" : '';
        $desc = isset($args['description']) ? $args['description'] : '';

        $options = get_option( 'dcms_newusers_options' );
        $val = isset( $options[$id] ) ? $options[$id] : '';

        printf("<input id='%s' name='dcms_newusers_options[%s]' class='regular-text' type='text' value='%s' %s %s>",
                $id, $id, $val, $req, $class);

        if ( $desc ) printf("<p class='description'>%s</p> ", $desc);

    }


    public function dcms_section_textarea_field( $args ){

        $id = $args['label_for'];
        $desc = isset($args['description']) ? $args['description'] : '';
        $options = get_option( 'dcms_newusers_options' );
        $val = $options[$id];
        printf("<textarea id='%s' name='dcms_newusers_options[%s]' rows='5' cols='80' >%s</textarea><p class='description'>%s</p>", $id, $id, $val, $desc);
	}

}
