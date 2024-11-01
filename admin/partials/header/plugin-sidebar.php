<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}
$image_url = WDPAD_FREE_PLUGIN_URL . 'admin/images/right_click.png';
?>
<div class="dotstore_plugin_sidebar">

    <div class="dotstore-important-link">
        <div class="video-detail important-link">
            <a href="#" target="_blank">
                <img width="100%" src="<?php echo esc_url(WDPAD_FREE_PLUGIN_URL . 'admin/images/plugin-videodemo.png'); ?>" alt="<?php esc_html_e('WooCommerce Conditional Product Dynamic Pricings For Checkout', 'woo-dynamic-pricing-and-discount'); ?>">
            </a>
        </div>
    </div>

    <div class="dotstore-important-link">
        <h2><span class="dotstore-important-link-title"><?php esc_html_e('Important link', 'woo-dynamic-pricing-and-discount'); ?></span></h2>
        <div class="video-detail important-link">
            <ul>
                <li>
                    <img src="<?php echo esc_url($image_url); ?>">
                    <a target="_blank" href="<?php echo esc_url("https://www.wordpress.org/plugins/woo-dynamic-pricing-and-discout/"); ?>"><?php esc_html_e('Plugin documentation', 'woo-dynamic-pricing-and-discount'); ?></a>
                </li>
                <li>
                    <img src="<?php echo esc_url($image_url); ?>">
                    <a target="_blank" href="<?php echo esc_url("https://www.thedotstore.com/support/"); ?>"><?php esc_html_e('Support platform', 'woo-dynamic-pricing-and-discount'); ?></a>
                </li>
                <li>
                    <img src="<?php echo esc_url($image_url); ?>">
                    <a target="_blank" href="<?php echo esc_url("https://www.thedotstore.com/support/"); ?>"><?php esc_html_e('Suggest A Feature', 'woo-dynamic-pricing-and-discount'); ?></a>
                </li>
                <li>
                    <img src="<?php echo esc_url($image_url); ?>">
                    <a  target="_blank" href="<?php echo esc_url("https://www.wordpress.org/plugins/woo-dynamic-pricing-and-discout/"); ?>"><?php esc_html_e('Change log',
		                    'woo-dynamic-pricing-and-discount'); ?></a>
                </li>
            </ul>
        </div>
    </div>
    
    <!-- html for popular plugin !-->
    <div class="dotstore-important-link">
        <h2><span class="dotstore-important-link-title"><?php esc_html_e('OUR POPULAR PLUGINS', 'woo-dynamic-pricing-and-discount'); ?></span></h2>
        <div class="video-detail important-link">
            <ul>
                <li>
                    <img class="sidebar_plugin_icone" src="<?php echo esc_url(WDPAD_FREE_PLUGIN_URL . 'admin/images/advance-flat-rate.png'); ?>">
                    <a target="_blank" href="<?php echo esc_url("https://www.thedotstore.com/advanced-flat-rate-shipping-method-for-woocommerce");?>"><?php esc_html_e('Advanced Flat Rate Shipping Method', 'woo-dynamic-pricing-and-discount'); ?></a>
                </li> 
                <li>
                    <img class="sidebar_plugin_icone" src="<?php echo esc_url(WDPAD_FREE_PLUGIN_URL . 'admin/images/wc-conditional-product-fees.png'); ?>">
                    <a  target="_blank" href="<?php echo esc_url("https://www.thedotstore.com/woocommerce-conditional-product-fees-checkout/"); ?>"><?php esc_html_e('Conditional Product Fees For WooCommerce Checkout', 'woo-dynamic-pricing-and-discount'); ?></a>
                </li>
                <li>
                    <img class="sidebar_plugin_icone" src="<?php echo esc_url(WDPAD_FREE_PLUGIN_URL . 'admin/images/advance-menu-manager.png'); ?>">
                    <a  target="_blank" href="<?php echo esc_url("https://www.thedotstore.com/advance-menu-manager-wordpress/"); ?>"><?php esc_html_e('Advance Menu Manager', 'woo-dynamic-pricing-and-discount'); ?></a>
                </li>
                <li>
                    <img class="sidebar_plugin_icone" src="<?php echo esc_url(WDPAD_FREE_PLUGIN_URL . 'admin/images/wc-enhanced-ecommerce-analytics-integration.png'); ?>">
                    <a target="_blank" href="<?php echo esc_url("https://www.thedotstore.com/woocommerce-enhanced-ecommerce-analytics-integration-with-conversion-tracking"); ?>"><?php esc_html_e('Enhanced Ecommerce Google Analytics for WooCommerce', 'woo-dynamic-pricing-and-discount'); ?></a>
                </li>
                <li>
                    <img  class="sidebar_plugin_icone" src="<?php echo esc_url(WDPAD_FREE_PLUGIN_URL . 'admin/images/advanced-product-size-charts.png'); ?>">
                    <a target="_blank" href="<?php echo esc_url("https://www.thedotstore.com/woocommerce-advanced-product-size-charts/"); ?>"><?php esc_html_e('Advanced Product Size Charts', 'woo-dynamic-pricing-and-discount'); ?></a>
                </li>
                <li>
                    <img  class="sidebar_plugin_icone" src="<?php echo esc_url(WDPAD_FREE_PLUGIN_URL . 'admin/images/wc-blocker-prevent-fake-orders.png'); ?>">
                    <a target="_blank" href="<?php echo esc_url("https://www.thedotstore.com/woocommerce-blocker-lite-prevent-fake-orders-blacklist-fraud-customers/"); ?>"><?php esc_html_e('"Blocker – Prevent Fake Orders And Blacklist Fraud Customers for WooCommerce', 'woo-dynamic-pricing-and-discount'); ?></a>
                </li>
                </br>
            </ul>
        </div>
        <div class="view-button">
            <a class="view_button_dotstore" target="_blank" href="<?php echo esc_url("https://www.thedotstore.com/plugins/"); ?>"><?php esc_html_e('VIEW ALL', 'woo-dynamic-pricing-and-discount'); ?></a>
        </div>
    </div>
    <!-- html end for popular plugin !-->
</div>
</div>
</body>
</html>