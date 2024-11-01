<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://thefillmill.com
 * @since      1.0.0
 *
 * @package    The_Fill_Mill_Woocommerce_Verifier
 * @subpackage The_Fill_Mill_Woocommerce_Verifier/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    The_Fill_Mill_Woocommerce_Verifier
 * @subpackage The_Fill_Mill_Woocommerce_Verifier/includes
 * @author     The Fill Mill <support@thefillmill.com>
 */
class The_Fill_Mill_Woocommerce_Verifier_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'the-fill-mill-woocommerce-verifier',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
