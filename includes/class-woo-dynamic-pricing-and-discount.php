<?php
// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    exit;
}
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://www.thedotstore.com
 * @since      1.0.0
 *
 * @package    WDPAD_Woo_Dynamic_Pricing_And_Discount_Free
 * @subpackage WDPAD_Woo_Dynamic_Pricing_And_Discount_Free/includes
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
 * @package    WDPAD_Woo_Dynamic_Pricing_And_Discount_Free
 * @subpackage WDPAD_Woo_Dynamic_Pricing_And_Discount_Free/includes
 * @author     Thedotstore <inquiry@multidots.in>
 */
class WDPAD_Woo_Dynamic_Pricing_And_Discount_Free {

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      WDPAD_Woo_Dynamic_Pricing_And_Discount_Free_Loader    $loader    Maintains and registers all hooks for the plugin.
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

    const WDPAD_VERSION = WDPAD_FREE_PLUGIN_VERSION;

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

        $this->plugin_name = 'woo-dynamic-pricing-and-discount';
        $this->version = WDPAD_FREE_PLUGIN_VERSION;

        $this->wdpad_load_dependencies();
        $this->wdpad_set_locale();
        $this->wdpad_define_admin_hooks();
        $this->wdpad_define_public_hooks();
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - WDPAD_Woo_Dynamic_Pricing_And_Discount_Free_Loader. Orchestrates the hooks of the plugin.
     * - WDPAD_Woo_Dynamic_Pricing_And_Discount_Free_i18n. Defines internationalization functionality.
     * - WDPAD_Woo_Dynamic_Pricing_And_Discount_Free_Admin. Defines all hooks for the admin area.
     * - WDPAD_Woo_Dynamic_Pricing_And_Discount_Free_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function wdpad_load_dependencies() {

        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-woo-dynamic-pricing-and-discount-loader.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-woo-dynamic-pricing-and-discount-i18n.php';

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-woo-dynamic-pricing-and-discount-admin.php';

        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-woo-dynamic-pricing-and-discount-public.php';

        $this->loader = new WDPAD_Woo_Dynamic_Pricing_And_Discount_Free_Loader();
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the WDPAD_Woo_Dynamic_Pricing_And_Discount_Free_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function wdpad_set_locale() {

        $plugin_i18n = new WDPAD_Woo_Dynamic_Pricing_And_Discount_Free_i18n();

        $plugin_i18n->wdpad_set_domain($this->wdpad_get_plugin_name());

        $this->loader->wdpad_add_action('plugins_loaded', $plugin_i18n, 'wdpad_load_plugin_text_domain');
    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function wdpad_define_admin_hooks() {
        $get_page = filter_input(INPUT_GET,'page',FILTER_SANITIZE_STRING);

        $plugin_admin = new WDPAD_Woo_Dynamic_Pricing_And_Discount_Free_Admin($this->wdpad_get_plugin_name(), $this->wdpad_get_version());

        $this->loader->wdpad_add_action('admin_enqueue_scripts', $plugin_admin, 'wdpad_enqueue_styles');
        $this->loader->wdpad_add_action('admin_enqueue_scripts', $plugin_admin, 'wdpad_enqueue_scripts');
        $this->loader->wdpad_add_action('admin_menu', $plugin_admin, 'wdpad_dot_store_menu_conditional_dpad');
        $this->loader->wdpad_add_action('wp_ajax_wdpad_free_product_dpad_conditions_values_ajax', $plugin_admin, 'wdpad_free_product_dpad_conditions_values_ajax');
        $this->loader->wdpad_add_action('wp_ajax_nopriv_wdpad_free_product_dpad_conditions_values_ajax', $plugin_admin, 'wdpad_free_product_dpad_conditions_values_ajax');
        $this->loader->wdpad_add_action('wp_ajax_wdpad_free_product_dpad_conditions_values_product_ajax', $plugin_admin, 'wdpad_free_product_dpad_conditions_values_product_ajax');
        $this->loader->wdpad_add_action('wp_ajax_nopriv_wdpad_free_product_dpad_conditions_values_product_ajax', $plugin_admin, 'wdpad_free_product_dpad_conditions_values_product_ajax');
        $this->loader->wdpad_add_action('wp_ajax_wdpad_free_product_dpad_conditions_varible_values_product_ajax', $plugin_admin, 'wdpad_free_product_dpad_conditions_varible_values_product_ajax');
        $this->loader->wdpad_add_action('wp_ajax_nopriv_wdpad_free_product_dpad_conditions_varible_values_product_ajax', $plugin_admin, 'wdpad_free_product_dpad_conditions_varible_values_product_ajax');
        $this->loader->wdpad_add_action('wp_ajax_wdpad_free_wc_multiple_delete_conditional_fee', $plugin_admin, 'wdpad_free_wc_multiple_delete_conditional_fee');
        $this->loader->wdpad_add_action('wp_ajax_nopriv_wdpad_free_wc_multiple_delete_conditional_fee', $plugin_admin, 'wdpad_free_wc_multiple_delete_conditional_fee');
        $this->loader->wdpad_add_action('admin_head', $plugin_admin, 'wdpad_free_remove_admin_submenus');
        $this->loader->wdpad_add_action('admin_init', $plugin_admin, 'wdpad_free_welcome_conditional_dpad_screen_do_activation_redirect');
        if(!empty($get_page) && (($get_page === 'wdpad-pro-list') || ($get_page === 'wdpad-pro-add-new') || ($get_page === 'wdpad-pro-edit-fee') ||
                ($get_page === 'wdpad-pro-get-started') || ($get_page === 'wdpad-pro-information') ) ) {
            $this->loader->wdpad_add_filter('admin_footer_text', $plugin_admin, 'wdpad_free_admin_footer_review');
        }
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function wdpad_define_public_hooks() {

        $plugin_public = new WDPAD_Woo_Dynamic_Pricing_And_Discount_Free_Public($this->wdpad_get_plugin_name(), $this->wdpad_get_version());

        $this->loader->wdpad_add_action('wp_enqueue_scripts', $plugin_public, 'wdpad_enqueue_styles');
        $this->loader->wdpad_add_action('wp_enqueue_scripts', $plugin_public, 'wdpad_enqueue_scripts');
        $this->loader->wdpad_add_action('woocommerce_cart_calculate_fees', $plugin_public, 'wdpad_conditional_dpad_add_to_cart');
        $this->loader->wdpad_add_action('woocommerce_locate_template', $plugin_public, 'wdpad_woocommerce_locate_template_product_dpad_conditions', 1, 3);
    }

    /**
     * Return the plugin action links.  This will only be called if the plugin
     * is active.
     *
     * @since 1.0.0
     * @param array $actions associative array of action names to anchor tags
     * @return array associative array of plugin action links
     */

    public function wdpad_plugin_action_links($actions, $plugin_file, $plugin_data, $context) {
        $custom_actions = array(
            'configure' => sprintf('<a href="%s">%s</a>', admin_url('admin.php?page=wdpad-pro-get-started'), esc_html__('Settings', $this->plugin_name)),
            'premium'   => sprintf('<a href="%s" target="_blank" style="color: rgba(10, 154, 62, 1); font-weight: bold; font-size: 13px;">%s</a>', 'https://www.thedotstore.com/woo-dynamic-pricing-and-discount-rule', esc_html__('Upgrade To Pro', $this->plugin_name))
	    );
        // add the links to the front of the actions list
        return array_merge($custom_actions, $actions);
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function wdpad_run() {
        $this->loader->wdpad_run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function wdpad_get_plugin_name() {
        return $this->plugin_name;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function wdpad_get_version() {
        return $this->version;
    }

    /**
     * Allowed html tags used for wp_kses function
     *
     * @since     1.0.0
     *
     * @param array add custom tags
     *
     * @return array
     */
    public static function wdpad_allowed_html_tags(){
        $allowed_tags = array(
            'a' => array(
                'href' => array(),
                'title' => array(),
                'class' => array(),
                'target' => array(),
                'data-tooltip' => array()
            ),
            'ul' => array('class' => array()),
            'li' => array('class' => array()),
            'div' => array('class' => array(),'id' => array()),
            'select' => array('rel-id' => array(),'id' => array(),'name'=> array(),'class' => array(),'multiple' => array(),'style' => array()),
            'input' => array('id' => array(),'value'=>array(),'name'=> array(),'class' => array(),'type' => array(), 'data-index' => array()),
            'textarea' => array('id' => array(),'name'=> array(),'class' => array()),
            'option' => array('id' => array(),'selected'=>array(),'name'=> array(),'value' => array()),
            'br' => array(),
            'p' => array(),
            'b' => array('style' => array()),
            'em' => array(),
            'strong' => array(),
            'i' => array('class' => array()),
            'span' => array('class' => array()),
            'small' => array('class' => array()),
            'label' => array('class' => array(), 'id' => array(), 'for' => array()),
        );
        return $allowed_tags;
    }
}