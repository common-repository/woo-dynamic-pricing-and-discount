<?php
/**
 * Plugin Name:       Dynamic Pricing and Discount for WooCommerce
 * Plugin URI:        https://wordpress.org/plugins/woo-dynamic-pricing-and-discount/
 * Description:       With this plugin, you can create and manage complex discount rules in WooCommerce store without the help of a developer.
 * Version:           1.0.6
 * Author:            Thedotstore
 * Author URI:        https://www.thedotstore.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woo-dynamic-pricing-and-discount
 * Domain Path:       /languages
 */
// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    exit;
}
if (!defined('WDPAD_FREE_PLUGIN_VERSION')) {
    define('WDPAD_FREE_PLUGIN_VERSION', '1.0.6');
}
if (!defined('WDPAD_FREE_PLUGIN_URL')){
    define('WDPAD_FREE_PLUGIN_URL', plugin_dir_url(__FILE__));
}
if (!defined('WDPAD_PLUGIN_DIR')) {
    define('WDPAD_PLUGIN_DIR', dirname(__FILE__));
}
if (!defined('WDPAD_FREE_PLUGIN_DIR_PATH')) {
    define('WDPAD_FREE_PLUGIN_DIR_PATH', plugin_dir_path(__FILE__));
}
if (!defined('WDPAD_FREE_SLUG')) {
    define('WDPAD_FREE_SLUG', 'woo-dynamic-pricing-and-discount');
}
if (!defined('WDPAD_FREE_PLUGIN_BASENAME')) {
    define('WDPAD_FREE_PLUGIN_BASENAME', plugin_basename(__FILE__));
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-woo-dynamic-pricing-and-discount-activator.php
 */
function wdpad_activate_woocommerce_dynamic_pricing_and_discount_free() {
    require_once plugin_dir_path(__FILE__) . 'includes/class-woo-dynamic-pricing-and-discount-activator.php';
    WDPAD_Woo_Dynamic_Pricing_And_Discount_Free_Activator::wdpad_activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-woo-dynamic-pricing-and-discount-deactivator.php
 */
function wdpad_deactivate_woocommerce_dynamic_pricing_and_discount_free() {
    require_once plugin_dir_path(__FILE__) . 'includes/class-woo-dynamic-pricing-and-discount-deactivator.php';
    WDPAD_Woo_Dynamic_Pricing_And_Discount_Free_Deactivator::wdpad_deactivate();
}

register_activation_hook(__FILE__, 'wdpad_activate_woocommerce_dynamic_pricing_and_discount_free');
register_deactivation_hook(__FILE__, 'wdpad_deactivate_woocommerce_dynamic_pricing_and_discount_free');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-woo-dynamic-pricing-and-discount.php';

/**
 * The core plugin include constant file for set constant.
 */
require plugin_dir_path(__FILE__) . 'includes/constant.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function wdpad_run_woocommerce_dynamic_pricing_and_discount_free() {

    $plugin = new WDPAD_Woo_Dynamic_Pricing_And_Discount_Free();
    $plugin->wdpad_run();
}

wdpad_run_woocommerce_dynamic_pricing_and_discount_free();

function wdpad_woocommerce_dynamic_pricing_and_discount_free_path() {

    return untrailingslashit(plugin_dir_path(__FILE__));
}