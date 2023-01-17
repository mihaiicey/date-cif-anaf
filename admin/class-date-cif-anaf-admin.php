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
        add_action( 'admin_init', array( $this, 'create_settings_form_data' ) );
    }

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Date_Cif_Anaf_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Date_Cif_Anaf_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/date-cif-anaf-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Date_Cif_Anaf_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Date_Cif_Anaf_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

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
    
    public function create_settings_form_data(){
        register_setting(
            'date_cif_anaf_options',
            'date_cif_anaf_name',
            array( $this, 'sanitize' )
        );

        add_settings_section(
            'setting_section_id',
            __( 'Modulul de Facturare', 'date-cif-anaf' ),
            array( $this, 'print_section_info' ),
            'date_cif_anaf_general_settings'
        );
        
        add_settings_field(
            'selected_module_pfPj',
            __( 'Modul', 'date-cif-anaf' ),
            array( $this, 'display_select_invoice_field' ),
            'date_cif_anaf_general_settings',
            'date_cif_anaf_options',
            array(
                'options' => array(
                    'facturarepfpj' => 'Facturare Pers Fizica / Jurdica',
                    'smartbill' => 'Smart Bill',
                    'fgo' => 'Fgo.ro',
                    'curiero' => 'Curie.ro'
                ),
                'selected' => get_option( 'selected_module_pfPj' ),
            )
        );

    }
    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input ){
        $new_input = array();
        $allowed_options = array( 'facturarepfpj', 'smartbill', 'fgo', 'curiero' );

        if( isset( $input['id_modul'] ) )
            $new_input['title'] = sanitize_text_field( $input['id_modul'] );

        if( isset( $input['selected_module_pfPj'] ) )
            if ( ! in_array( $input['selected_module_pfPj'], $allowed_options, true ) ) {
                return 'option1';
            }

        return $new_input;
    }

    /**
     * Print the Title Section
     */
    public function print_section_info(){
        _e( 'Aici setezi modulul care îți creează câmpurile pentru facturarea Persoanei Fizice sau Juridice.', 'date-cif-anaf' );
    }

    /**
     * Get the plugins list option array and create a select list
     */
    public function display_select_invoice_field( $args ){
        $options = $args['options'];
        $selected = $args['selected'];
        printf( '<select id="selected_module_pfPj" name="selected_module_pfPj">' );
        foreach ( $options as $value => $label ) {
            printf( '<option value="%s" %s>%s</option>', $value, selected( $selected, $value, false ), $label );
        }
        printf( '</select>' );
    }
}
