<?php
// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    exit;
}
$plugin_name = WOO_DYNAMIC_PRICING_AND_DISCOUNT_FREE_PLUGIN_NAME;
$plugin_version = WDPAD_FREE_PLUGIN_VERSION;
?>
<div id="dotsstoremain">
    <div class="all-pad">
        <header class="dots-header">
            <div class="dots-logo-main">
                <img  src="<?php echo esc_url(WDPAD_FREE_PLUGIN_URL . 'admin/images/wc-conditional-product-dpad.png'); ?>">
            </div>
            <div class="dots-header-right">
                <div class="logo-detail">
                    <strong><?php esc_html_e($plugin_name, 'woo-dynamic-pricing-and-discount'); ?> </strong>
                    <span><?php esc_html_e('Free Version', 'woo-dynamic-pricing-and-discount'); ?> <?php echo esc_html($plugin_version); ?></span>
                </div>

                <div class="button-dots">
	                <span class="upgrade_free_image" style="display: none;">
                        <a target="_blank" href="<?php echo esc_url('https://www.thedotstore.com/woo-dynamic-pricing-and-discount-rule'); ?>">
                            <img src="<?php echo esc_url(WDPAD_FREE_PLUGIN_URL . 'admin/images/upgrade_new.png'); ?>">
                        </a>
                    </span>
                    <span class="support_dotstore_image"><a  target = "_blank" href="https://www.thedotstore.com/support/" >
                            <img src="<?php echo esc_url(WDPAD_FREE_PLUGIN_URL . 'admin/images/support_new.png'); ?>"></a>
                    </span>
                </div>
            </div>

            <?php
            $get_page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_STRING);
            $get_action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);

            $dpad_list = isset($get_page) && $get_page === 'wdpad-pro-list' ? 'active' : '';
            $dpad_add = isset($get_page) && $get_page === 'wdpad-pro-add-new' ? 'active' : '';
            $dpad_getting_started = isset($get_page) && $get_page === 'wdpad-pro-get-started' ? 'active' : '';
            $dpad_information = isset($get_page) && $get_page === 'wdpad-pro-information' ? 'active' : '';

            if (isset($get_page) && $get_page === 'wdpad-pro-information' || isset($get_page) && $get_page === 'wdpad-pro-get-started') {
                $dpad_about = 'active';
            } else {
                $dpad_about = '';
            }

            if (!empty($get_action)) {
                if ($get_action === 'add' || $get_action === 'edit') {
                    $dpad_add = 'active';
                }
            }
            if(is_network_admin()){
	            $admin_url = admin_url();
            } else {
	            $admin_url = network_admin_url();
            }
            ?>
            <div class="dots-menu-main">
                <nav>
                    <ul>
                        <li>
                            <a class="dotstore_plugin <?php echo esc_attr($dpad_list); ?>"  href="<?php echo esc_url($admin_url.'admin.php?page=wdpad-pro-list'); ?>"><?php esc_html_e('Manage Dynamic Pricing', 'woo-dynamic-pricing-and-discount'); ?></a>
                        </li>
                        <li>
                            <a class="dotstore_plugin <?php echo esc_attr($dpad_add); ?>"  href="<?php echo esc_url($admin_url.'admin.php?page=wdpad-pro-add-new'); ?>"> <?php esc_html_e('Add Dynamic Pricing', 'woo-dynamic-pricing-and-discount'); ?></a>
                        </li>
                        <li>
                            <a class="dotstore_plugin <?php echo esc_attr($dpad_about); ?>"  href="<?php echo esc_url($admin_url.'admin.php?page=wdpad-pro-get-started'); ?>"><?php esc_html_e('About Plugin', 'woo-dynamic-pricing-and-discount'); ?></a>
                            <ul class="sub-menu">
                                <li><a  class="dotstore_plugin <?php echo esc_attr($dpad_getting_started); ?>" href="<?php echo esc_url($admin_url.'admin.php?page=wdpad-pro-get-started'); ?>"><?php esc_html_e('Getting Started', 'woo-dynamic-pricing-and-discount'); ?></a></li>
                                <li><a class="dotstore_plugin <?php echo esc_attr($dpad_information); ?>" href="<?php echo esc_url($admin_url.'admin.php?page=wdpad-pro-information'); ?>"><?php esc_html_e('Quick info', 'woo-dynamic-pricing-and-discount'); ?></a></li>
                            </ul>
                        </li>
                        <li>
                            <a class="dotstore_plugin"><?php esc_html_e('Dotstore', 'woo-dynamic-pricing-and-discount'); ?></a>
                            <ul class="sub-menu">
                                <li><a target="_blank" href="<?php echo esc_url("https://www.thedotstore.com/woocommerce-plugins/"); ?>"><?php esc_html_e('WooCommerce Plugins', 'woo-dynamic-pricing-and-discount'); ?></a></li>
                                <li><a target="_blank" href="<?php echo esc_url("https://www.thedotstore.com/wordpress-plugins/");?>"><?php esc_html_e('Wordpress Plugins', 'woo-dynamic-pricing-and-discount'); ?></a></li><br>
                                <li><a target="_blank" href="<?php echo esc_url("https://www.thedotstore.com/support/");?>"><?php esc_html_e('Contact Support', 'woo-dynamic-pricing-and-discount'); ?></a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </header>