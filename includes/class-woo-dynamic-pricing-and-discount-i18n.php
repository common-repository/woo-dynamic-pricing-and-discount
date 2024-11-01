<?php
// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    exit;
}
/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://www.thedotstore.com
 * @since      1.0.0
 *
 * @package    Woocommerce_Dynamic_Pricing_And_Discount_Free
 * @subpackage Woocommerce_Dynamic_Pricing_And_Discount_Free/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Woocommerce_Dynamic_Pricing_And_Discount_Free
 * @subpackage Woocommerce_Dynamic_Pricing_And_Discount_Free/includes
 * @author     Thedotstore <inquiry@multidots.in>
 */
class WDPAD_Woo_Dynamic_Pricing_And_Discount_Free_i18n {

	/**
	 * The domain specified for this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $domain The domain identifier for this plugin.
	 */
	private $domain;

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function wdpad_load_plugin_text_domain() {

		$locale = apply_filters( 'plugin_locale', get_locale(), $this->domain );
		$mofile = $this->domain . '-' . $locale . '.mo';
		$path   = WP_PLUGIN_DIR . '/' . trim( $this->domain . '/languages', '/' );
		load_textdomain( $this->domain, $path . '/' . $mofile );
		$plugin_rel_path = apply_filters( 'woocommerce_woocommerce_conditional_product_dpad_for_checkout_translation_file_rel_path', $this->domain . '/languages' );
		load_plugin_textdomain( $this->domain, false, $plugin_rel_path );

	}

	/**
	 * Set the domain equal to that of the specified domain.
	 *
	 * @since    1.0.0
	 *
	 * @param    string $domain The domain that represents the locale of this plugin.
	 */
	public function wdpad_set_domain( $domain ) {
		$this->domain = $domain;
	}
}