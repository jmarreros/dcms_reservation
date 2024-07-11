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
        register_setting('dcms_change_seats_options_bd', 'dcms_changeseats_options' );

        $this->fields_new_user();
        $this->fields_change_seats();
    }

    // New user fields
    private function fields_new_user(){

        add_settings_section('dcms_email_section',
                        __('Texto por defecto en correo', 'dcms-reservation'),
                                [$this,'dcms_section_cb'],
                                'dcms_newusers_sfields' );

        add_settings_field('dcms_sender_email',
                            __('Correo Emisor', 'dcms-reservation'),
                            [$this, 'dcms_section_input_cb'],
                            'dcms_newusers_sfields',
                            'dcms_email_section',
                            [
                                'dcms_option' => 'dcms_newusers_options',
                                'label_for' => 'dcms_sender_email',
                                'required' => true
                            ]
        );

        add_settings_field('dcms_sender_name',
                            __('Nombre emisor', 'dcms-reservation'),
                            [$this, 'dcms_section_input_cb'],
                            'dcms_newusers_sfields',
                            'dcms_email_section',
                            [
                              'dcms_option' => 'dcms_newusers_options',
                              'label_for' => 'dcms_sender_name',
                              'required' => true
                            ]
        );

        add_settings_field('dcms_subject_email',
                            __('Asunto correo', 'dcms-reservation'),
                            [$this, 'dcms_section_input_cb'],
                            'dcms_newusers_sfields',
                            'dcms_email_section',
                            [
                              'dcms_option' => 'dcms_newusers_options',
                              'label_for' => 'dcms_subject_email',
                              'required' => true
                            ]
        );

        add_settings_field('dcms_text_email',
                            __('Texto correo', 'dcms-reservation'),
                            [$this, 'dcms_section_textarea_field'],
                            'dcms_newusers_sfields',
                            'dcms_email_section',
                            [
                             'dcms_option' => 'dcms_newusers_options',
                             'label_for' => 'dcms_text_email',
                             'description' => __('Puedes usar %name%, %date% y %hour% para reemplazar el nombre, la fecha y hora de la reserva', 'dcms-reservation')
                            ]
        );
    }

    // Change users fields
    private function fields_change_seats(){

        add_settings_section('dcms_email_section',
                        __('Texto por defecto en correo', 'dcms-reservation'),
                                [$this,'dcms_section_cb'],
                                'dcms_changeseats_sfields' );

        add_settings_field('dcms_sender_email',
                            __('Correo Emisor', 'dcms-reservation'),
                            [$this, 'dcms_section_input_cb'],
                            'dcms_changeseats_sfields',
                            'dcms_email_section',
                            [
                                'dcms_option' => 'dcms_changeseats_options',
                                'label_for' => 'dcms_sender_email',
                                'required' => true
                            ]
        );

        add_settings_field('dcms_sender_name',
                            __('Nombre emisor', 'dcms-reservation'),
                            [$this, 'dcms_section_input_cb'],
                            'dcms_changeseats_sfields',
                            'dcms_email_section',
                            [
                              'dcms_option' => 'dcms_changeseats_options',
                              'label_for' => 'dcms_sender_name',
                              'required' => true
                            ]
        );

        add_settings_field('dcms_subject_email',
                            __('Asunto correo', 'dcms-reservation'),
                            [$this, 'dcms_section_input_cb'],
                            'dcms_changeseats_sfields',
                            'dcms_email_section',
                            [
                              'dcms_option' => 'dcms_changeseats_options',
                              'label_for' => 'dcms_subject_email',
                              'required' => true
                            ]
        );

        add_settings_field('dcms_text_email',
                            __('Texto correo', 'dcms-reservation'),
                            [$this, 'dcms_section_textarea_field'],
                            'dcms_changeseats_sfields',
                            'dcms_email_section',
                            [
                             'dcms_option' => 'dcms_changeseats_options',
                             'label_for' => 'dcms_text_email',
                             'description' => __('Puedes usar %name%, %date%, %hour%, %type% para reemplazar el nombre, la fecha, hora, y tipo de reserva', 'dcms-reservation')
                            ]
        );
    }


    // Métodos auxiliares genéricos

    // Callback section
    public function dcms_section_cb(){
		echo '<hr/>';
	}

    // Callback input field callback
    public function dcms_section_input_cb($args){
        $dcms_option = $args['dcms_option'];
        $id = $args['label_for'];
        $req = isset($args['required']) ? 'required' : '';
        $class = isset($args['class']) ? "class='".$args['class']."'" : '';
        $desc = isset($args['description']) ? $args['description'] : '';

        $options = get_option( $dcms_option );
        $val = isset( $options[$id] ) ? $options[$id] : '';

        printf("<input id='%s' name='%s[%s]' class='regular-text' type='text' value='%s' %s %s>",
                $id, $dcms_option, $id, $val, $req, $class);

        if ( $desc ) printf("<p class='description'>%s</p> ", $desc);

    }


    public function dcms_section_textarea_field( $args ){
        $dcms_option = $args['dcms_option'];
        $id = $args['label_for'];
        $desc = isset($args['description']) ? $args['description'] : '';

        $options = get_option( $dcms_option );
        $val = $options[$id];
        printf("<textarea id='%s' name='%s[%s]' rows='5' cols='80' >%s</textarea><p class='description'>%s</p>", $id, $dcms_option, $id, $val, $desc);
	}

}
