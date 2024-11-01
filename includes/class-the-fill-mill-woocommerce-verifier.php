<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://thefillmill.com
 * @since      1.0.0
 *
 * @package    The_Fill_Mill_Woocommerce_Verifier
 * @subpackage The_Fill_Mill_Woocommerce_Verifier/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    The_Fill_Mill_Woocommerce_Verifier
 * @subpackage The_Fill_Mill_Woocommerce_Verifier/includes
 * @author     The Fill Mill <support@thefillmill.com>
 */
class The_Fill_Mill_Woocommerce_Verifier {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      The_Fill_Mill_Woocommerce_Verifier_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'THE_FILL_MILL_WOOCOMMERCE_VERIFIER_VERSION' ) ) {
			$this->version = THE_FILL_MILL_WOOCOMMERCE_VERIFIER_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'the-fill-mill-woocommerce-verifier';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - The_Fill_Mill_Woocommerce_Verifier_Loader. Orchestrates the hooks of the plugin.
	 * - The_Fill_Mill_Woocommerce_Verifier_i18n. Defines internationalization functionality.
	 * - The_Fill_Mill_Woocommerce_Verifier_Admin. Defines all hooks for the admin area.
	 * - The_Fill_Mill_Woocommerce_Verifier_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-the-fill-mill-woocommerce-verifier-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-the-fill-mill-woocommerce-verifier-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-the-fill-mill-woocommerce-verifier-admin.php';

		$this->loader = new The_Fill_Mill_Woocommerce_Verifier_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the The_Fill_Mill_Woocommerce_Verifier_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new The_Fill_Mill_Woocommerce_Verifier_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new The_Fill_Mill_Woocommerce_Verifier_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		// Register "The Fill Mill" tab in Woocommerce > Settings
		$this->loader->add_action( 'init', $plugin_admin, 'init_tfm_tab' );

		// Some conditional styles
		$this->loader->add_action( 'admin_head', $plugin_admin, 'admin_head' );

		// Ajax action to save API key
		$this->loader->add_action('wp_ajax_tfm_save_api_credentials', $plugin_admin, 'wp_ajax_tfm_save_api_credentials');
		$this->loader->add_action('wp_ajax_nopriv_tfm_save_api_credentials', $plugin_admin, 'wp_ajax_tfm_save_api_credentials');
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    The_Fill_Mill_Woocommerce_Verifier_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
