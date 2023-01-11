<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://icey.dev
 * @since      1.0.0
 *
 * @package    Date_Cif_Anaf
 * @subpackage Date_Cif_Anaf/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Date_Cif_Anaf
 * @subpackage Date_Cif_Anaf/includes
 * @author     Icey Design <mihai@icey.ro>
 */
class Date_Cif_Anaf_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'date-cif-anaf',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
