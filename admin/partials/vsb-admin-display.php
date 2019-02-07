<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.elk-lab.com
 * @since      1.0.0
 *
 * @package    Vsb
 * @subpackage Vsb/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap">
    <h1><?= __('Visa Simple Booking', 'visa-simple-booking') ?></h1>

    <form method="post" action="options.php">
        <?php settings_fields('vsb_options'); ?>
        <?php do_settings_sections('vsb'); ?>
        <?php submit_button(); ?>
    </form>
</div>