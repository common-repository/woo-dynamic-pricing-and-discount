<?php
// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    exit;
}
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.thedotstore.com
 * @since      1.0.0
 *
 * @package    WDPAD_Woo_Dynamic_Pricing_And_Discount_Free
 * @subpackage WDPAD_Woo_Dynamic_Pricing_And_Discount_Free/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    WDPAD_Woo_Dynamic_Pricing_And_Discount_Free
 * @subpackage WDPAD_Woo_Dynamic_Pricing_And_Discount_Free/admin
 * @author     Thedotstore <inquiry@multidots.in>
 */
class WDPAD_Woo_Dynamic_Pricing_And_Discount_Free_Admin {

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
    public function __construct($plugin_name, $version) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function wdpad_enqueue_styles() {
        $get_page = filter_input(INPUT_GET,'page',FILTER_SANITIZE_STRING);

        if (isset($get_page) && !empty($get_page) && ($get_page === 'wdpad-pro-list' || $get_page === 'wdpad-pro-add-new' || $get_page === 'wdpad-pro-get-started' || $get_page === 'wdpad-pro-information' || $get_page === 'wdpad-pro-edit-fee')) {
            wp_enqueue_style($this->plugin_name . '-choose-css', plugin_dir_url(__FILE__) . 'css/chosen.min.css', array(), $this->version, 'all');
            wp_enqueue_style($this->plugin_name . '-jquery-ui-css', plugin_dir_url(__FILE__) . 'css/jquery-ui.min.css', array(), $this->version, 'all');
            wp_enqueue_style($this->plugin_name . 'font-awesome', plugin_dir_url(__FILE__) . 'css/font-awesome.min.css', array(), $this->version, 'all');
            wp_enqueue_style($this->plugin_name . '-webkit-css', plugin_dir_url(__FILE__) . 'css/webkit.css', array(), $this->version, 'all');
            wp_enqueue_style($this->plugin_name . 'main-style', plugin_dir_url(__FILE__) . 'css/style.css', array(), 'all');
            wp_enqueue_style($this->plugin_name . 'media-css', plugin_dir_url(__FILE__) . 'css/media.css', array(), 'all');
        }
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function wdpad_enqueue_scripts() {
        $get_page = filter_input(INPUT_GET,'page',FILTER_SANITIZE_STRING);
        wp_enqueue_style('wp-jquery-ui-dialog');
        wp_enqueue_script('jquery-ui-accordion');
        if (isset($get_page) && !empty($get_page) && ($get_page === 'wdpad-pro-list' || $get_page === 'wdpad-pro-add-new' || $get_page === 'wdpad-pro-get-started' || $get_page === 'wdpad-pro-information' || $get_page === 'wdpad-pro-edit-fee')) {
            wp_enqueue_script($this->plugin_name . '-choose-js', plugin_dir_url(__FILE__) . 'js/chosen.jquery.min.js', array('jquery', 'jquery-ui-datepicker'), $this->version, false);
            wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/woo-dynamic-pricing-and-discount-admin.js', array('jquery', 'jquery-ui-dialog', 'jquery-ui-accordion', 'jquery-ui-sortable'), $this->version, false);
            wp_localize_script($this->plugin_name, 'coditional_vars', array(
                'ajaxurl'                           => admin_url( 'admin-ajax.php' ),
                'plugin_url' => plugin_dir_url(__FILE__))
            );
            wp_enqueue_script($this->plugin_name . '-tablesorter-js', plugin_dir_url(__FILE__) . 'js/jquery.tablesorter.js', array('jquery'), $this->version, false);
        }
    }

    public function wdpad_dot_store_menu_conditional_dpad() {
        global $GLOBALS;
        if (empty($GLOBALS['admin_page_hooks']['dots_store'])) {
            add_menu_page(
                    'DotStore Plugins', esc_html__('DotStore Plugins'), 'null', 'dots_store', array($this, 'wdpad_dot_store_menu_page'), WDPAD_FREE_PLUGIN_URL . 'admin/images/menu-icon.png', 25
            );
        }
        add_submenu_page('dots_store', 'Get Started', 'Get Started', 'manage_options', 'wdpad-pro-get-started', array($this, 'wdpad_free_get_started_page'));
        add_submenu_page('dots_store', 'Introduction', 'Introduction', 'manage_options', 'wdpad-pro-information', array($this, 'wdpad_free_information_page'));
        add_submenu_page('dots_store', 'Dynamic Pricing and Discount for WooCommerce', esc_html__('Dynamic Pricing and Discount for WooCommerce'), 'manage_options', 'wdpad-pro-list', array($this, 'wdpad_free_dpad_list_page'));
        add_submenu_page('dots_store', 'Add New', 'Add New', 'manage_options', 'wdpad-pro-add-new', array($this, 'wdpad_free_add_new_dpad_page'));
        add_submenu_page('dots_store', 'Edit Fee', 'Edit Fee', 'manage_options', 'wdpad-pro-edit-fee', array($this, 'wdpad_free_edit_dpad_page'));
    }

    public function wdpad_dot_store_menu_page() {
    }

    public function wdpad_free_information_page() {
        require_once plugin_dir_path( __FILE__ ) . 'partials/wdpad-pro-information-page.php';
    }

    public function wdpad_free_dpad_list_page() {
        require_once plugin_dir_path( __FILE__ ) . 'partials/wdpad-pro-list-page.php';
    }

    public function wdpad_free_add_new_dpad_page() {
        require_once plugin_dir_path( __FILE__ ) . 'partials/wdpad-pro-add-new-page.php';
    }

    public function wdpad_free_edit_dpad_page() {
        require_once plugin_dir_path( __FILE__ ) . 'partials/wdpad-pro-add-new-page.php';
    }

    public function wdpad_free_get_started_page() {
        require_once plugin_dir_path( __FILE__ ) . 'partials/wdpad-pro-get-started-page.php';
    }

    function wdpad_free_dpad_conditions_save($post) {
        if (empty($post)) {
            return false;
        }

        $get_post_type = filter_input(INPUT_POST,'post_type',FILTER_SANITIZE_STRING);
        $get_dpad_post_id = filter_input(INPUT_POST,'dpad_post_id',FILTER_SANITIZE_NUMBER_INT);
        $get_wdpad_pro_conditions_save = filter_input(INPUT_POST,'wdpad_pro_conditions_save',FILTER_SANITIZE_STRING);
        $get_dpad_settings_product_dpad_title = filter_input(INPUT_POST,'dpad_settings_product_dpad_title',FILTER_SANITIZE_STRING);
        $get_dpad_settings_product_cost = filter_input(INPUT_POST,'dpad_settings_product_cost',FILTER_SANITIZE_NUMBER_INT);
        $get_dpad_chk_qty_price = filter_input(INPUT_POST,'dpad_chk_qty_price',FILTER_SANITIZE_NUMBER_INT);
        $get_dpad_per_qty = filter_input(INPUT_POST,'dpad_per_qty',FILTER_SANITIZE_NUMBER_INT);
        $get_extra_product_cost = filter_input(INPUT_POST,'extra_product_cost',FILTER_SANITIZE_NUMBER_INT);
        $get_dpad_settings_select_dpad_type = filter_input(INPUT_POST,'dpad_settings_select_dpad_type',FILTER_SANITIZE_STRING);
        $get_dpad_settings_start_date = filter_input(INPUT_POST,'dpad_settings_start_date',FILTER_SANITIZE_STRING);
        $get_dpad_settings_end_date = filter_input(INPUT_POST,'dpad_settings_end_date',FILTER_SANITIZE_STRING);
        $get_dpad_settings_status = filter_input(INPUT_POST,'dpad_settings_status',FILTER_SANITIZE_STRING);
        $get_dpad_settings_optional_gift = filter_input(INPUT_POST,'dpad_settings_optional_gift',FILTER_SANITIZE_STRING);
        $get_by_default_checkbox_checked = filter_input(INPUT_POST,'by_default_checkbox_checked',FILTER_SANITIZE_STRING);

        $get_dpad = filter_input(INPUT_POST,'dpad',FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);
        $get_condition_key       = filter_input( INPUT_POST, 'condition_key', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY );

        if (isset($get_post_type) && 'wc_dynamic_pricing' === sanitize_text_field($get_post_type) &&
            wp_verify_nonce( sanitize_text_field( $get_wdpad_pro_conditions_save ),'wdpad_pro_save_action')) {
            if ($get_dpad_post_id === '') {
                $dpad_post = array(
                    'post_title' => sanitize_text_field($get_dpad_settings_product_dpad_title),
                    'post_status' => 'publish',
                    'post_type' => 'wc_dynamic_pricing',
                    'post_author'     => 1,
                );
                $post_id = wp_insert_post( $dpad_post);
            } else {
                $dpad_post = array(
                    'ID' => $get_dpad_post_id,
                    'post_title' => sanitize_text_field($get_dpad_settings_product_dpad_title),
                    'post_status' => 'publish'
                );
                $post_id = wp_update_post($dpad_post);
            }

            if (isset($get_dpad_settings_product_cost)) {
                update_post_meta($post_id, 'dpad_settings_product_cost', sanitize_text_field($get_dpad_settings_product_cost));
            }
            
            /* Apply per quantity postmeta start */
            if (isset($get_dpad_chk_qty_price)) {
                update_post_meta($post_id, 'dpad_chk_qty_price', 'on');
            } else {
                update_post_meta($post_id, 'dpad_chk_qty_price', 'off');
            }
            if (isset($get_dpad_per_qty)) {
                update_post_meta( $post_id, 'dpad_per_qty', sanitize_text_field($get_dpad_per_qty) );
            }
            if (isset($get_extra_product_cost)) {
                update_post_meta( $post_id, 'extra_product_cost', sanitize_text_field($get_extra_product_cost) );
            }
            /* Apply per quantity postmeta end */
            
            if (isset($get_dpad_settings_select_dpad_type)) {
                update_post_meta($post_id, 'dpad_settings_select_dpad_type', sanitize_text_field($get_dpad_settings_select_dpad_type));
            }
            if (isset($get_dpad_settings_start_date)) {
                update_post_meta($post_id, 'dpad_settings_start_date', sanitize_text_field($get_dpad_settings_start_date));
            }
            if (isset($get_dpad_settings_end_date)) {
                update_post_meta($post_id, 'dpad_settings_end_date', sanitize_text_field($get_dpad_settings_end_date));
            }
            if (isset($get_dpad_settings_status)) {
                update_post_meta($post_id, 'dpad_settings_status', 'on');
            } else {
                update_post_meta($post_id, 'dpad_settings_status', 'off');
            }
            if (isset($get_dpad_settings_optional_gift)) {
                update_post_meta($post_id, 'dpad_settings_optional_gift', sanitize_text_field($get_dpad_settings_optional_gift));
            }
            if (isset($get_by_default_checkbox_checked)) {
                update_post_meta($post_id, 'by_default_checkbox_checked', 'on');
            } else {
                update_post_meta($post_id, 'by_default_checkbox_checked', 'off');
            }
            
            $dpadArray = array();
            $dpad = isset($get_dpad) ? $get_dpad : array();
            $condition_key = isset($get_condition_key) ? $get_condition_key : array();
            $dpad_conditions = $dpad['product_dpad_conditions_condition'];
            $conditions_is = $dpad['product_dpad_conditions_is'];
            $conditions_values = isset($dpad['product_dpad_conditions_values']) && !empty($dpad['product_dpad_conditions_values']) ? $dpad['product_dpad_conditions_values'] : array();
            $size = count($dpad_conditions);
            foreach (array_keys($condition_key) as $key) {
                if (!array_key_exists($key, $conditions_values)) {
                    $conditions_values[$key] = array();
                }
            }
            $conditions_values_array = array();
            uksort($conditions_values, 'strnatcmp');
            foreach ($conditions_values as $v) {
                $conditions_values_array[] = $v;
            }
            for ($i = 0; $i < $size; $i++) {
                $dpadArray[] = array(
                    'product_dpad_conditions_condition' => $dpad_conditions[$i],
                    'product_dpad_conditions_is' => $conditions_is[$i],
                    'product_dpad_conditions_values' => $conditions_values_array[$i]
                );
            }

            update_post_meta($post_id, 'dynamic_pricing_metabox', $dpadArray);

	        if(is_network_admin()){
		        $admin_url = admin_url();
	        } else {
		        $admin_url = network_admin_url();
	        }
	        $admin_urls = $admin_url.'admin.php?page=wdpad-pro-list';
            wp_redirect( $admin_urls );
            exit();
        }
    }

    /**
     * Product spesifict starts
     */
    function wdpad_free_product_dpad_conditions_get_meta($value) {
        global $post;
        $field = get_post_meta($post->ID, $value, true);
        if (isset($field) && !empty($field)) {
            return is_array($field) ? stripslashes_deep($field) : stripslashes(wp_kses_decode_entities($field));
        } else {
            return false;
        }
    }

    public function wdpad_free_product_dpad_conditions_values_ajax() {
        $get_condition = filter_input(INPUT_GET, 'condition', FILTER_SANITIZE_STRING);
        $get_count = filter_input(INPUT_GET, 'count', FILTER_SANITIZE_NUMBER_INT);

        $condition = isset($get_condition) ? sanitize_text_field($get_condition) : '';
        $count = isset($get_count) ? sanitize_text_field($get_count) : '';

        $html = '';
        if ($condition === 'country') {
            $html .= $this->wdpad_free_get_country_list($count);
        }elseif ($condition === 'product') {
            $html .= $this->wdpad_free_get_product_list($count);
        } elseif ($condition === 'category') {
            $html .= $this->wdpad_free_get_category_list($count);
        } elseif ($condition === 'user') {
            $html .= $this->wdpad_free_get_user_list($count);
        }elseif ($condition === 'cart_total') {
            $html .= '<input type="text" name="dpad[product_dpad_conditions_values][value_' . esc_attr($count) . ']" id="product_dpad_conditions_values" class="product_dpad_conditions_values" value="">';
        }elseif ($condition === 'quantity') {
            $html .= '<input type="text" name="dpad[product_dpad_conditions_values][value_' . esc_attr($count) . ']" id="product_dpad_conditions_values" class="product_dpad_conditions_values" value="">';
        }
        echo wp_kses($html, WDPAD_Woo_Dynamic_Pricing_And_Discount_Free::wdpad_allowed_html_tags());
        wp_die(); // this is required to terminate immediately and return a proper response
    }

	/**
	 * Function for select country list
	 *
	 * @param string $count
	 * @param array $selected
	 *
	 * @return string
	 */
    public function wdpad_free_get_country_list($count = '', $selected = array()) {
        $countries_obj = new WC_Countries();
        $getCountries = $countries_obj->__get('countries');
        $html = '<select name="dpad[product_dpad_conditions_values][value_' . esc_attr($count) . '][]" class="product_dpad_conditions_values multiselect2 product_dpad_conditions_values_country" multiple="multiple">';
        if (!empty($getCountries)) {
            foreach ($getCountries as $code => $country) {
                $selectedVal = is_array($selected) && !empty($selected) && in_array($code, $selected) ? 'selected=selected' : '';
                $html .= '<option value="' . esc_attr($code) . '" ' . esc_attr($selectedVal) . '>' . esc_html($country) . '</option>';
            }
        }

        $html .= '</select>';
        return $html;
    }

	/**
	 * Function for select product list
	 *
	 * @param string $count
	 * @param array $selected
	 *
	 * @return string
	 */
    public function wdpad_free_get_product_list($count = '', $selected = array(), $action = '') {
        global $sitepress;
        
        if( !empty($sitepress) ) {
            $default_lang = $sitepress->get_default_language();
        }
        
        $post_in = '';
        if ($action === 'edit') {
            $post_in = $selected;
            $posts_per_page = -1;
        } else {
            $post_in = '';
            $posts_per_page = 10;
        }
        
        $product_args = array(
            'post_type' => 'product',
            'post_status' => 'publish',
            'orderby' => 'ID',
            'order' => 'ASC',
            'post__in' => $post_in,
            'posts_per_page' => $posts_per_page,
        );

        $get_all_products = new WP_Query($product_args);

        $html = '<select id="product-filter" rel-id="' . esc_attr($count) . '" name="dpad[product_dpad_conditions_values][value_' . esc_attr($count) . '][]" class="product_dpad_conditions_values multiselect2" multiple="multiple">';
        if (isset($get_all_products->posts) && !empty($get_all_products->posts)) {

            foreach ($get_all_products->posts as $get_all_product) {
                
                if( !empty($sitepress) ) {
                    $new_product_id = apply_filters( 'wpml_object_id', $get_all_product->ID, 'product', TRUE, $default_lang );
                } else {
                    $new_product_id = $get_all_product->ID;
                }

                $selectedVal = is_array($selected) && !empty($selected) && in_array($new_product_id, $selected) ? 'selected=selected' : '';
                if ($selectedVal !== '') {
                    $html .= '<option value="' . esc_attr($new_product_id) . '" ' . esc_attr($selectedVal) . '>' . '#' . esc_html($new_product_id) . ' - ' . esc_html(get_the_title($new_product_id)) . '</option>';
                }
            }
        }
        $html .= '</select>';
        return $html;
    }

	/**
	 * Function for select cat list
	 *
	 * @param string $count
	 * @param array $selected
	 *
	 * @return string
	 */
    public function wdpad_free_get_category_list($count = '', $selected = array()) {
        
        global $sitepress;
        $taxonomy = 'product_cat';
        $post_status = 'publish';
        $orderby = 'name';
        $hierarchical = 1;
        $empty = 0;
        
        if( !empty($sitepress) ) {
            $default_lang = $sitepress->get_default_language();
        }
        
        $args = array(
            'post_type' => 'product',
            'post_status' => $post_status,
            'taxonomy' => $taxonomy,
            'orderby' => $orderby,
            'hierarchical' => $hierarchical,
            'hide_empty' => $empty,
            'posts_per_page' => -1
        );
        $get_all_categories = get_categories($args);
        $html = '<select rel-id="' . esc_attr($count) . '" name="dpad[product_dpad_conditions_values][value_' . esc_attr($count) . '][]" class="product_dpad_conditions_values multiselect2" multiple="multiple">';
        if (isset($get_all_categories) && !empty($get_all_categories)) {
            foreach ($get_all_categories as $get_all_category) {
                
                if( !empty($sitepress) ) {
                    $new_cat_id = apply_filters( 'wpml_object_id', $get_all_category->term_id, 'product_cat', TRUE, $default_lang );
                } else {
                    $new_cat_id = $get_all_category->term_id;
                }
                
                $selectedVal = is_array($selected) && !empty($selected) && in_array($new_cat_id, $selected) ? 'selected=selected' : '';
                $category = get_term_by('id', $new_cat_id, 'product_cat');
                $parent_category = get_term_by('id', $category->parent, 'product_cat');

                if ($category->parent > 0) {
                    $html .= '<option value=' . esc_attr($category->term_id) . ' ' . esc_attr($selectedVal) . '>' . '#' . esc_html($parent_category->name) . '->' . esc_html($category->name) . '</option>';
                } else {
                    $html .= '<option value=' . esc_attr($category->term_id) . ' ' . esc_attr($selectedVal) . '>' . esc_html($category->name) . '</option>';
                }
            }
        }
        $html .= '</select>';
        return $html;
    }

    /**
     * Function for select user list
     *
     */
    public function wdpad_free_get_user_list($count = '', $selected = array()) {
        $get_all_users = get_users();
        $html = '<select rel-id="' . esc_attr($count) . '" name="dpad[product_dpad_conditions_values][value_' . esc_attr($count) . '][]" class="product_dpad_conditions_values multiselect2" multiple="multiple">';
        if (isset($get_all_users) && !empty($get_all_users)) {
            foreach ($get_all_users as $get_all_user) {
                $selectedVal = is_array($selected) && !empty($selected) && in_array($get_all_user->data->ID, $selected) ? 'selected=selected' : '';
                $html .= '<option value="' . esc_attr($get_all_user->data->ID) . '" ' . esc_attr($selectedVal) . '>' . esc_html($get_all_user->data->user_login) . '</option>';
            }
        }
        $html .= '</select>';
        return $html;
    }

    public function wdpad_free_wc_multiple_delete_conditional_fee() {
        $result = 0;
        $get_allVals   = filter_input(INPUT_GET, 'allVals', FILTER_SANITIZE_NUMBER_INT, FILTER_REQUIRE_ARRAY);
        $allVals = !empty($get_allVals) ? array_map( 'sanitize_text_field', wp_unslash($get_allVals) ) : array();
        if (!empty($allVals)) {
            foreach ($allVals as $val) {
                wp_delete_post($val);
                $result = 1;
            }
        }
        echo (int)$result;
        wp_die();
    }

    public function wdpad_free_welcome_conditional_dpad_screen_do_activation_redirect() {
        // if no activation redirect
        if (!get_transient('_welcome_screen_wdpad_free_mode_activation_redirect_data')) {
            return;
        }

        // Delete the redirect transient
        delete_transient('_welcome_screen_wdpad_free_mode_activation_redirect_data');

        // if activating from network, or bulk
        $get_activate_multi = filter_input(INPUT_GET,'activate-multi',FILTER_SANITIZE_STRING);
        if (is_network_admin() || isset($get_activate_multi)) {
            return;
        }
        // Redirect to extra cost welcome  page
        wp_safe_redirect(add_query_arg(array('page' => 'wdpad-pro-get-started'), admin_url('admin.php')));
        exit();
    }

    public function wdpad_free_remove_admin_submenus() {
        remove_submenu_page('dots_store', 'wdpad-pro-information');
        remove_submenu_page('dots_store', 'wdpad-pro-add-new');
        remove_submenu_page('dots_store', 'wdpad-pro-edit-fee');
        remove_submenu_page('dots_store', 'wdpad-pro-get-started');
    }

    public function wdpad_free_product_dpad_conditions_values_product_ajax() {
        global $sitepress;
        $request_value = filter_input(INPUT_GET,'value',FILTER_SANITIZE_STRING);
        $request_posts_per_page = filter_input(INPUT_GET,'posts_per_page',FILTER_SANITIZE_NUMBER_INT);
        $request_offset = filter_input(INPUT_GET,'offset',FILTER_SANITIZE_NUMBER_INT);

        $post_value = isset($request_value) ? $request_value : '';
        $posts_per_page = isset($request_posts_per_page) ? $request_posts_per_page : '';
        $offset = isset($request_offset) ? $request_offset : '';
        
        $baselang_product_ids = array();

        if( !empty($sitepress) ) {
            $default_lang = $sitepress->get_default_language();
        }

        function wcpfc_posts_where( $where, $wp_query ) {
            global $wpdb;
            $search_term = $wp_query->get('search_pro_title');
            if (!empty($search_term)) {
                $search_term_like = $wpdb->esc_like( $search_term );
                $where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql( $search_term_like ) . '%\'';
            }
            return $where;
        }

        $product_args = array(
            'post_type' => 'product',
            'posts_per_page' => $posts_per_page,
            'offset' => $offset,
            'search_free_title' => $post_value,
            'post_status' => 'publish',
            'orderby' => 'title',
            'order' => 'ASC'
        );

        add_filter( 'posts_where', 'wcpfc_posts_where', 10, 2 );
        $wp_query = new WP_Query($product_args);
        remove_filter( 'posts_where', 'wcpfc_posts_where', 10, 2 );

        $get_all_products = $wp_query->posts;

        if (isset($get_all_products) && !empty($get_all_products)) {
            foreach ($get_all_products as $get_all_product) {
                if( !empty($sitepress) ) {
                    $defaultlang_product_id = apply_filters( 'wpml_object_id', $get_all_product->ID, 'product', TRUE, $default_lang );
                } else {
                    $defaultlang_product_id = $get_all_product->ID;
                }
                $baselang_product_ids[]    = $defaultlang_product_id;
            }
        }

        $html = '';
        if (isset($baselang_product_ids) && !empty($baselang_product_ids)) {
            foreach ($baselang_product_ids as $baselang_product_id) {
                $html .= '<option value="' . esc_attr($baselang_product_id) . '">' . '#' . esc_html($baselang_product_id) . ' - ' . esc_html(get_the_title($baselang_product_id)) . '</option>';
            }
        }
        echo wp_kses($html, WDPAD_Woo_Dynamic_Pricing_And_Discount_Free::wdpad_allowed_html_tags());
        wp_die();
    }

    public function wdpad_free_product_dpad_conditions_varible_values_product_ajax() {
        global $sitepress;
        $request_value = filter_input(INPUT_GET,'value',FILTER_SANITIZE_STRING);
        $request_posts_per_page = filter_input(INPUT_GET,'posts_per_page',FILTER_SANITIZE_NUMBER_INT);
        $request_offset = filter_input(INPUT_GET,'offset',FILTER_SANITIZE_NUMBER_INT);

        $post_value = isset($request_value) ? $request_value : '';
        $posts_per_page = isset($request_posts_per_page) ? $request_posts_per_page : '';
        $offset = isset($request_offset) ? $request_offset : '';

        $baselang_product_ids = array();

        if (!empty($sitepress)) {
            $default_lang = $sitepress->get_default_language();
        }

        function wcpfc_posts_wheres($where, $wp_query) {
            global $wpdb;
            $search_term = $wp_query->get('search_pro_title');
            if (!empty($search_term)) {
                $search_term_like = $wpdb->esc_like($search_term);
                $where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql($search_term_like) . '%\'';
            }
            return $where;
        }

        $product_args = array(
            'post_type' => 'product',
            'posts_per_page' => $posts_per_page,
            'offset' => $offset,
            'search_free_title' => $post_value,
            'post_status' => 'publish',
            'orderby' => 'title',
            'order' => 'ASC'
        );

        add_filter('posts_where', 'wcpfc_posts_wheres', 10, 2);
        $get_all_products = new WP_Query($product_args);
        remove_filter('posts_where', 'wcpfc_posts_wheres', 10, 2);

        if (!empty($get_all_products)){
            foreach ($get_all_products->posts as $get_all_product){
                    $_product = wc_get_product($get_all_product->ID);
                    if ($_product->is_type('variable')) {
                        $variations = $_product->get_available_variations();
                        foreach ($variations as $value) {
                        if( !empty($sitepress) ) {
                            $defaultlang_product_id = apply_filters( 'wpml_object_id', $value['variation_id'], 'product', TRUE, $default_lang );
                        } else {
                            $defaultlang_product_id = $value['variation_id'];
                        }
                        $baselang_product_ids[]    = $defaultlang_product_id;
                 }   
             }
            }
        }
        $html = '';
        if (isset($baselang_product_ids) && !empty($baselang_product_ids)) {
            foreach ($baselang_product_ids as $baselang_product_id) {
                $html .= '<option value="' . esc_attr($baselang_product_id) . '">' . '#' . esc_html($baselang_product_id) . ' - ' . esc_html(get_the_title($baselang_product_id)) . '</option>';
            }
        }
        echo wp_kses($html, WDPAD_Woo_Dynamic_Pricing_And_Discount_Free::wdpad_allowed_html_tags());
        wp_die();
    }

    function wdpad_free_admin_footer_review() {
        echo sprintf( wp_kses( __( 'If you like <strong>Dynamic Pricing and Discount for WooCommerce</strong> plugin, please leave us ★★★★★ ratings on <a href="%1$s" target="_blank">DotStore</a>.', 'woo-dynamic-pricing-and-discount' ), array('strong' => array(), 'a' => array('href' => array()) )), esc_url('https://wordpress.org/plugins/woo-dynamic-pricing-and-discount/#reviews'));

    }
}