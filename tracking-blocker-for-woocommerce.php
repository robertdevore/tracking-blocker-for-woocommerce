<?php

/**
  * The plugin bootstrap file
  *
  * @link              https://robertdevore.com
  * @since             5.0.0
  * @package           TBWC
  *
  * @wordpress-plugin
  *
  * Plugin Name: Tracking Blocker for WooCommerce®
  * Description: Blocks all outbound HTTP requests to tracking.woocommerce.com/v1/ and logs the original data.
  * Plugin URI:  https://github.com/robertdevore/tracking-blocker-for-woocommerce/
  * Version:     1.0.0
  * Author:      Robert DeVore
  * Author URI:  https://robertdevore.com/
  * License:     GPL-2.0+
  * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
  * Text Domain: tracking-blocker-for-woocommerce
  * Domain Path: /languages
  * Update URI:  https://github.com/robertdevore/tracking-blocker-for-woocommerce/
  */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

require 'vendor/plugin-update-checker/plugin-update-checker.php';
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$myUpdateChecker = PucFactory::buildUpdateChecker(
	'https://github.com/robertdevore/tracking-blocker-for-woocommerce/',
	__FILE__,
	'tracking-blocker-for-woocommerce'
);

// Set the branch that contains the stable release.
$myUpdateChecker->setBranch( 'main' );

// Define the plugin version.
define( 'TBWC_PLUGIN_VERSION', '5.0.0' );
define( 'TBWC_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

// Check if Composer's autoloader is already registered globally.
if ( ! class_exists( 'RobertDevore\WPComCheck\WPComPluginHandler' ) ) {
    require_once __DIR__ . '/vendor/autoload.php';
}

use RobertDevore\WPComCheck\WPComPluginHandler;

new WPComPluginHandler( plugin_basename( __FILE__ ), 'https://robertdevore.com/why-this-plugin-doesnt-support-wordpress-com-hosting/' );

/**
 * Load plugin text domain for localization.
 *
 * @since  1.1.0
 * @return void
 */
function tbwp_load_textdomain() {
    load_plugin_textdomain( 'tracking-blocker-for-woocommerce', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'tbwp_load_textdomain' );

/**
 * Blocks outbound HTTP requests to a specific WooCommerce tracking URL and logs the original data.
 *
 * This function intercepts HTTP requests made by WordPress, checks if the URL matches
 * `tracking.woocommerce.com/v1/`, and blocks the request. It logs the URL and the data
 * that was intended to be sent for debugging and analysis.
 *
 * @param array  $args The HTTP request arguments.
 * @param string $url  The URL of the HTTP request.
 * 
 * @since  1.0.0
 * @return array Modified HTTP request arguments to block the request if the URL matches.
 */
function block_woocommerce_tracker_requests( $args, $url ) {
    // Check if the request is targeting the WooCommerce tracking endpoint.
    if ( strpos( $url, 'tracking.woocommerce.com/v1/' ) !== false ) {
        // Log the blocked request details.
        error_log( "Blocked outbound request to: $url" );

        // Log the original data being sent.
        if ( ! empty( $args['body'] ) ) {
            $body_data = is_array( $args['body'] ) ? json_encode( $args['body'], JSON_PRETTY_PRINT ) : $args['body'];
            error_log( "Original data sent: " . $body_data );
        }

        // Return empty arguments to effectively block the request.
        return [
            'blocking' => true,
            'headers'  => [],
            'body'     => '',
            'cookies'  => [],
        ];
    }

    // Return the original arguments if the URL does not match.
    return $args;
}
add_filter( 'http_request_args', 'block_woocommerce_tracker_requests', 10, 2 );
