<h2>Shortcodes</h2>
<hr>
<section class="dcms-shortcode">
<small><?php _e('You can use this shortcode to show the form: ') ?></small>
<strong>[<?php echo DCMS_SHORTCODE_NEW_USER ?>]</strong>
</section>

<form action="options.php" method="post">
    <?php
        settings_fields('dcms_new_users_options_bd');
        do_settings_sections('dcms_newusers_sfields');
        submit_button();
    ?>
</form>