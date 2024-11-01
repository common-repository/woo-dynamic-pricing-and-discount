<?php
// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    exit;
}
/**
 * Fired during plugin activation
 *
 * @link       https://www.thedotstore.com
 * @since      1.0.0
 *
 * @package    WDPAD_Woo_Dynamic_Pricing_And_Discount_Free
 * @subpackage WDPAD_Woo_Dynamic_Pricing_And_Discount_Free/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    WDPAD_Woo_Dynamic_Pricing_And_Discount_Free
 * @subpackage WDPAD_Woo_Dynamic_Pricing_And_Discount_Free/includes
 * @author     Thedotstore <inquiry@multidots.in>
 */
class WDPAD_Woo_Dynamic_Pricing_And_Discount_Free_Activator {

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public static function wdpad_activate() {
        set_transient('_welcome_screen_wdpad_free_mode_activation_redirect_data', true, 30);
        add_option('wcpfc_version', WDPAD_Woo_Dynamic_Pricing_And_Discount_Free::WDPAD_VERSION);

        if (!in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')), true) && !is_plugin_active_for_network('woocommerce/woocommerce.php')) {
            wp_die("<strong> WooCommerce Conditional Product Dynamic Pricings for Checkout</strong> Plugin requires <strong>WooCommerce</strong> <a href='" . esc_url(get_admin_url(null, 'plugins.php')) . "'>Plugins page</a>.");
        } else {
            set_transient('_welcome_screen_activation_redirect_data', true, 30);
        }
    }
}