<?php
// to check whether accessed directly
if (!defined('ABSPATH')) {
	exit;
}

require_once( WP_PLUGIN_DIR . '/woocommerce/includes/admin/settings/class-wc-settings-page.php' );

class TFM_Settings extends WC_Settings_Page {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

    public function __construct($plugin_name) {
        $this->init();
        $this->id = 'tfm_tab';
        $this->plugin_name = $plugin_name;
    }

    /**
     * [init description]
     * @return [type] [description]
     */
    public function init() {
        add_filter('woocommerce_settings_tabs_array', array($this, 'add_settings_tab'), 50);

        add_filter('woocommerce_sections_tfm_tab', array($this, 'output_sections'));
        add_filter('woocommerce_settings_tfm_tab', array($this, 'output_settings'));

        add_action('woocommerce_admin_field_setuptfm', array($this, 'admin_field_setuptfm')); //to add the first tab
        add_action('woocommerce_admin_field_credentialstfm', array($this, 'admin_field_credentialstfm')); //to add the second tab
    }

    /**
     * [get_sections description]
     * @return [type] [description]
     */
    public function get_sections() {
        $sections = array(
            '' => __('Setup Account', $this->plugin_name),
            'tfm-account-credentials' => __('Account Credentials', $this->plugin_name),
        );
        return $sections;
    }


    /**
     * [add_settings_tab description]
     * @param [type] $settings_tabs [description]
     */
    public static function add_settings_tab($settings_tabs) {
        $settings_tabs['tfm_tab'] = __('The Fill Mill', $this->plugin_name);
        return $settings_tabs;
    }

    /**
     * [output_settings description]
     * @return [type] [description]
     */
    public function output_settings() {
        global $current_section;
        if ($current_section == '') {
            $settings = $this->get_setup_account_tab($current_section);
            WC_Admin_Settings::output_fields($settings);
        } else if ($current_section == 'tfm-account-credentials') {
            $settings = $this->get_account_credentials_tab($current_section);
            WC_Admin_Settings::output_fields($settings);
        }
    }

    /**
     * [get_setup_account_tab description]
     * @return [type] [description]
     */
    public function get_setup_account_tab() {
        global $wp_roles;

        $user_roles = $wp_roles->role_names;
        $settings = array(
            'tfm_tab_user_role_title' => array(
                'title' => __('Setup account:', $this->plugin_name),
                'type' => 'title',
                'description' => '',
                'id' => 'tfm_tab_user_role'
            ),
            'setup_account' => array(
                'type' => 'setuptfm',
                'id' => 'tfm_setup_account',
            ),
        );
        return $settings;
    }

    /**
     * [get_account_credentials_tab description]
     * @return [type] [description]
     */
    public function get_account_credentials_tab() {
        $settings = array(
            'tfm_tab_unregistered_title' => array(
                'title' => __('Account Credentials:', $this->plugin_name),
                'type' => 'title',
                'description' => '',
                'id' => 'tfm_tab_unregistered'
            ),
            'account_credentials' => array(
                'type' => 'credentialstfm',
                'id' => 'tfm_account_credentials',
            ),
        );
        return $settings;
    }

    /**
     * [admin_field_setuptfm description]
     * @param  [type] $settings [description]
     * @return [type]           [description]
     */
    public function admin_field_setuptfm($settings) {
        include( 'partials/setup-account.php' );
    }

    /**
     * [admin_field_credentialstfm description]
     * @param  [type] $settings [description]
     * @return [type]           [description]
     */
    public function admin_field_credentialstfm($settings) {
        include( 'partials/account-credentials.php' );
    }
}

new TFM_Settings($plugin_name);
