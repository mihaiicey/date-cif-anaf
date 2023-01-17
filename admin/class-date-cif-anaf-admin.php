<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://icey.dev
 * @since      1.0.0
 *
 * @package    Date_Cif_Anaf
 * @subpackage Date_Cif_Anaf/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Date_Cif_Anaf
 * @subpackage Date_Cif_Anaf/admin
 * @author     Icey Design <mihai@icey.ro>
 */
class Date_Cif_Anaf_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
        add_action('admin_menu', array($this, 'dateCifAnafSettings'), 9);
        add_action( 'admin_init', array( $this, 'create_settings_form_data_init' ) );
    }

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/date-cif-anaf-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/date-cif-anaf-admin.js', array( 'jquery' ), $this->version, false );

	}
    public function dateCifAnafSettings() {
        add_submenu_page(
            'options-general.php',
            'Plugin Name Settings',
            'Setari Date Anaf',
            'administrator',
            $this->plugin_name.'-settings',
            array( $this, 'displayAdminDashboard' )
        );
    }
    public function displayAdminDashboard() {
        require_once 'partials/date-cif-anaf-admin-display.php';
    }

    public function create_settings_form_data_init(){
        add_settings_section(
            // ID used to identify this section and with which to register options
            'settings_page_general_section',
            '',
            array( $this, 'print_section_info' ),
            // Page on which to add this section of options
            'date-cif-anaf-settings'
        );

        add_settings_field(
            'selectie_modul_pfjs',
            __( 'Modulul de Facturare', 'date-cif-anaf' ),
            array( $this, 'display_select_invoice_field' ),
            'date-cif-anaf-settings',
            'settings_page_general_section',
        );

        register_setting(
            'date_cif_anaf_options',
            'selectie_modul_pfjs',
            array(
                'sanitize_callback' => array( $this, 'sanitize')
            )
        );

    }

    public function print_section_info() {
        _e( 'Aici setezi modulul care îți creează câmpurile pentru facturarea Persoanei Fizice sau Juridice.', 'date-cif-anaf' );
    }

    public function display_select_invoice_field(){
        ?>
        <select name="selectie_modul_pfjs">
            <option value="0"><?php esc_attr_e( 'Selecteaza un modul', 'date-cif-anaf' ); ?></option>
            <option value="facturarepfpj" <?php selected( get_option( 'selectie_modul_pfjs' ), 'facturarepfpj' ); ?>> Facturare Pers Fizica / Jurdica de  George Ciobanu </option>
            <option value="smartbill" <?php selected( get_option( 'selectie_modul_pfjs' ), 'smartbill' ); ?>> Smart Bill </option>
            <option value="fgo" <?php selected( get_option( 'selectie_modul_pfjs' ), 'fgo' ); ?>> Fgo.ro </option>
            <option value="curiero" <?php selected( get_option( 'selectie_modul_pfjs' ), 'curiero' ); ?>> Curie.ro </option>
        </select>
        <?php
    }

    public function sanitize( $input ) {
        $allowed_options =  array(
            'facturarepfpj',
            'smartbill',
            'fgo',
            'curiero'
        );
        if ( false ===  in_array( $input, $allowed_options, true ) ) {
            add_settings_error(
                'selectie_modul_pfjs',
                'invalid_selection',
                esc_html__( 'Camp invalid sau nu ai selectat un modul', 'cliowp-settings-page' ),
            );
            return get_option('selectie_modul_pfjs');
        }
        return $input;

    }
}
