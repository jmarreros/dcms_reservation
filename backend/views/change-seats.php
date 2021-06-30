<?php

// Validations
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if ( ! current_user_can( 'manage_options' ) ) return; // only administrator

// Tabs definitions
$plugin_tabs = Array();
$plugin_tabs['report'] = __('Reporte', 'dcms-reservation');
$plugin_tabs['config'] = __('Configuración', 'dcms-reservation');
$current_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : 'report';

// Interfaz header
echo "<div class='wrap'>"; //start wrap
echo "<h1>" . __('Cambio de Asientos', 'dcms-reservation') . "</h1>";

// Intefaz tabs
echo '<h2 class="nav-tab-wrapper">';
foreach ( $plugin_tabs as $tab_key => $tab_caption ) {
    $active = $current_tab == $tab_key ? 'nav-tab-active' : '';
    echo "<a data-tab='".$current_tab."' class='nav-tab " . $active . "' href='".admin_url( DCMS_RESERVATION_SUBMENU . "&page=seat-change&tab=" . $tab_key )."'>" . $tab_caption . '</a>';
}
echo '</h2>';

switch ($current_tab){
    case 'report':
        include_once('partials/change-seats-report.php');
        break;
    case 'config':
        include_once('partials/change-seats-config.php');
        break;
}

echo "</div>"; //end wrap