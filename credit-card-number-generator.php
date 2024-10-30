<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.weblineindia.com/
 * @since             1.0.0
 * @package           Credit_Card_Number_Generator
 *
 * @wordpress-plugin
 * Plugin Name:       Credit Card Number Generator
 * Description:       Generate credit card numbers for all well-known card issuers like MasterCard, Visa, JCB, Discover, American Express etc.
 * Version:           1.0.7
 * Author:            Weblineindia
 * Author URI:        https://www.weblineindia.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       credit-card-number-generator
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) { exit; } // Exit on direct access.

// Define Plugin and Plugin Assets Path
if ( ! defined( 'CCNG_CARD_GENERATOR_ASSESTS_URL' ) ) {

	define('CCNG_CARD_GENERATOR_ASSESTS_URL', plugin_dir_url(__FILE__).'assets/');

}

// Include Admin Page
require 'admin/class-credit-card-number-generator-admin.php';

// Register Plugin activation hook
register_activation_hook(__FILE__, 'ccng_credit_card_generator_enable_plugin');

// Set default plugin state - TRUE
function ccng_credit_card_generator_enable_plugin() {

    update_option( 'CCNG_DUMMY_CARD_status', 'true');
	update_option('ccng_activation_date', time());

}

/* Check update hook Start */
add_filter('pre_set_site_transient_update_plugins', 'update_ccng_credit_card_generator');
function update_ccng_credit_card_generator($transient)
{
    if (empty($transient->checked)) {
        return $transient;
    }
    $plugin_folder = plugin_basename(__FILE__);
    if (isset($transient->checked[$plugin_folder])) {
        update_option('ccng_activation_date', time());
    }
    return $transient;
}   
/* Check update hook End */

$wli_plugin_status = get_option( 'CCNG_DUMMY_CARD_status' );

if( "true" == $wli_plugin_status) {

	// Include Generator Widget File
	require 'admin/class-credit-card-number-generator-widget.php';

	// Include Validator Widget File
	require 'admin/class-credit-card-number-validator-widget.php';

	// Include Shortcode File
	require 'public/credit-card-number-generator-public.php';
}

?>