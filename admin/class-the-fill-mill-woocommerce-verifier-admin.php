<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://thefillmill.com
 * @since      1.0.0
 *
 * @package    The_Fill_Mill_Woocommerce_Verifier
 * @subpackage The_Fill_Mill_Woocommerce_Verifier/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    The_Fill_Mill_Woocommerce_Verifier
 * @subpackage The_Fill_Mill_Woocommerce_Verifier/admin
 * @author     The Fill Mill <support@thefillmill.com>
 */
class The_Fill_Mill_Woocommerce_Verifier_Admin {

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
		 * defined in The_Fill_Mill_Woocommerce_Verifier_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The The_Fill_Mill_Woocommerce_Verifier_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/the-fill-mill-woocommerce-verifier-admin.css', array(), $this->version, 'all' );

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
		 * defined in The_Fill_Mill_Woocommerce_Verifier_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The The_Fill_Mill_Woocommerce_Verifier_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		
		$page = isset($_GET['page']) ? $_GET['page'] : '';
        $tab = isset($_GET['tab']) ? $_GET['tab'] : '';
        $section = isset($_GET['section']) ? $_GET['section'] : '';
        if ($page == 'wc-settings' && $tab == "tfm_tab" && $section == "tfm-account-credentials") {

			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/the-fill-mill-woocommerce-verifier-admin.js', array( 'jquery' ), $this->version, false );
			$title_nonce = wp_create_nonce( 'tfm_nonce' );
		    wp_localize_script( $this->plugin_name, 'lt_ajax_obj', array(
		       'ajax_url' => admin_url( 'admin-ajax.php' ),
		       'nonce'    => $title_nonce,
		    ) );
		}

	}

	/**
	 * [init_tfm_tab description]
	 * @return [type] [description]
	 */
	public function init_tfm_tab()
	{
		if ( ! current_user_can('manage_options') ) {
			die('Unauthorized access.');
		}
		$plugin_name = $this->plugin_name;
		require_once('class-tfm-settings.php');
	}

	/**
	 * [admin_head description]
	 * @return [type] [description]
	 */
	public function admin_head()
	{
		$page = isset($_GET['page']) ? $_GET['page'] : '';
        $tab = isset($_GET['tab']) ? $_GET['tab'] : '';
        $section = isset($_GET['section']) ? $_GET['section'] : '';
        if ($page == 'wc-settings' && $tab == "tfm_tab") {
        	echo '<style>
				.woocommerce form .submit {
					display: none;
				}
				.woocommerce form h2 {
					display: none;
				}
        	</style>';
        }
	}

	/**
	 * [wp_ajax_tfm_save_api_credentials description]
	 * @return [type] [description]
	 */
	public function wp_ajax_tfm_save_api_credentials() {

		check_ajax_referer( 'tfm_nonce' );

		// Return if the user doesn't have the permissions.
		if ( ! current_user_can('manage_options') ) {
			die('Unauthorized access.');
		}

        $api_key = sanitize_text_field($_POST['api_key']);
        $company_name = sanitize_text_field($_POST['company_name']);
        $company_id = absint($_POST['company_id']);

        $data = array(
            'success' => true,
        );

        // validate if a parameter is not empty
        if (empty($api_key) || empty($api_key) || empty($api_key)) {
			$data = array(
	            'error' => true,
	            'message' => __('Please fill in all parameters.', $this->plugin_name),
	        );        	
        }

        $error_message = __('Error connecting to The Fill Mill. Please make sure that you\'ve entered all fields exactly as received (copy and paste for best results). If you are unsuccessful in making a connection please contact us.', $this->plugin_name);

        $response = $this->makeAPICall($api_key, $company_id);

        if (empty($response)) {
        	$data = array(
	            'error' => true,
	            'message' => $error_message,
	        );
        } else {
        	$response_encoded = json_decode($response);
        	if (!empty($response_encoded->label) && $company_name == $response_encoded->label) {
        		
		        update_option( 'tfm_api_key', $api_key );
		        update_option( 'tfm_company_name', $company_name );
		        update_option( 'tfm_company_id', $company_id );

		        $data = array(
		            'success' => true,
		        );

        	} else {
        		$data = array(
		            'error' => true,
		            'message' => $error_message,
		        );	
        	}
        }


        wp_send_json($data);
    }

    private function makeAPICall($api_key, $company_id)
    {
    	$base_url = 'https://thefillmill-test.infopluswms.com/infoplus-wms/api/beta';
    	$api_url = $base_url . '/lineOfBusiness/' . $company_id;

    	$headers = array(
            'API-Key' => $api_key,
        );
		 
		$args = array(
		    'headers' => $headers,
		);
		 
		$response = wp_remote_get( $api_url, $args );
		$http_code = wp_remote_retrieve_response_code( $response );

		if ($http_code != 200) {
			return false;
		}

		return wp_remote_retrieve_body($response);
    }

}
