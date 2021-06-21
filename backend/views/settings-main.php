<?php
// $db

// Validations
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if ( ! current_user_can( 'manage_options' ) ) return; // only administrator

// Tabs definitions
$plugin_tabs = Array();
$plugin_tabs['new-users'] = __('Alta abonados', 'dcms-reservation');
$plugin_tabs['change-seats'] = __('Cambio de asientos', 'dcms-reservation');
$current_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : 'new-users';

// Get calendar data
$data = $db->get_calendar_config($current_tab);

// Interfaz header
echo "<div class='wrap'>"; //start wrap
echo "<h1>" . __('Configuración Reservas', 'dcms-reservation') . "</h1>";

// Intefaz tabs
echo '<h2 class="nav-tab-wrapper">';
foreach ( $plugin_tabs as $tab_key => $tab_caption ) {
    $active = $current_tab == $tab_key ? 'nav-tab-active' : '';
    echo "<a data-tab='".$current_tab."' class='nav-tab " . $active . "' href='".admin_url( DCMS_RESERVATION_SUBMENU . "&page=reservation-settings&tab=" . $tab_key )."'>" . $tab_caption . '</a>';
}
echo '</h2>';

// Fill content
include_once('partials/calendar.php');

echo "</div>"; //end wrap


