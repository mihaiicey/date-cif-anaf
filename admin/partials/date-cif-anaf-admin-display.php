<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://icey.dev
 * @since      1.0.0
 *
 * @package    Date_Cif_Anaf
 * @subpackage Date_Cif_Anaf/admin/partials
 */
?>

<div class="wrap">
    <div id="icon-themes" class="icon32"></div>
    <?php
    $options = get_option( 'selectie_modul_pfjs' );
    print_r($options)
    ?>
    <h2>Setari Date CUI Anaf</h2>
    <!--NEED THE settings_errors below so that the errors/success messages are shown after submission - wasn't working once we started using add_menu_page and stopped using add_options_page so needed this-->
    <?php settings_errors(); ?>

    <form method="POST" action="options.php" class="campPfPj">
        <?php
        settings_fields( 'date_cif_anaf_options' );
        do_settings_sections( 'date-cif-anaf-settings' );
        ?>
        <?php submit_button(); ?>
    </form>
</div>