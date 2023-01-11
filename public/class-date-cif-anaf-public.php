<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://icey.dev
 * @since      1.0.0
 *
 * @package    Date_Cif_Anaf
 * @subpackage Date_Cif_Anaf/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Date_Cif_Anaf
 * @subpackage Date_Cif_Anaf/public
 * @author     Icey Design <mihai@icey.ro>
 */
class Date_Cif_Anaf_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
//        if(is_checkout()) {
//            wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/date-cif-anaf-public.css', array(), $this->version, 'all');
//        }
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
//        if(is_checkout()){
//		    wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/date-cif-anaf-public.js', array( 'jquery' ), $this->version, true );
//        }
	}

}
