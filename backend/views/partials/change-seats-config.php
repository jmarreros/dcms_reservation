<h2>Shortcodes</h2>
<hr>
<section class="dcms-shortcode">
<small><?php _e('You can use this shortcode to show the form: ') ?></small>
<strong>[<?php echo DCMS_SHORTCODE_CHANGE_SEATS ?>]</strong>
</section>

<form action="options.php" method="post">
    <?php
        settings_fields('dcms_change_seats_options_bd');
        do_settings_sections('dcms_changeseats_sfields');
        submit_button();
    ?>
</form>