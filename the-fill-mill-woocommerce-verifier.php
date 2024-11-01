<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://thefillmill.com
 * @since             1.0.0
 * @package           The_Fill_Mill_Woocommerce_Verifier
 *
 * @wordpress-plugin
 * Plugin Name:       The Fill Mill
 * Plugin URI:        https://thefillmill.com
 * Description:       Plugin used to verify API credentials registered at "The Fill Mill" for a company
 * Version:           1.0.0
 * Author:            The Fill Mill
 * Author URI:        https://thefillmill.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       the-fill-mill-woocommerce-verifier
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'THE_FILL_MILL_WOOCOMMERCE_VERIFIER_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-the-fill-mill-woocommerce-verifier-activator.php
 */
function activate_the_fill_mill_woocommerce_verifier() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-the-fill-mill-woocommerce-verifier-activator.php';
	The_Fill_Mill_Woocommerce_Verifier_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-the-fill-mill-woocommerce-verifier-deactivator.php
 */
function deactivate_the_fill_mill_woocommerce_verifier() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-the-fill-mill-woocommerce-verifier-deactivator.php';
	The_Fill_Mill_Woocommerce_Verifier_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_the_fill_mill_woocommerce_verifier' );
register_deactivation_hook( __FILE__, 'deactivate_the_fill_mill_woocommerce_verifier' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-the-fill-mill-woocommerce-verifier.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_the_fill_mill_woocommerce_verifier() {

	$plugin = new The_Fill_Mill_Woocommerce_Verifier();
	$plugin->run();

}
run_the_fill_mill_woocommerce_verifier();
