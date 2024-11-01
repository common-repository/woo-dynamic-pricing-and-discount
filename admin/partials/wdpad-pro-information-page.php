<?php
// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    exit;
}
require_once plugin_dir_path( __FILE__ ) . 'header/plugin-header.php';
?>
<div class="wdpad-main-table res-cl">
    <h2><?php esc_html_e('Quick info', 'woo-dynamic-pricing-and-discount'); ?></h2>
    <table class="table-outer">
        <tbody>
            <tr>
                <td class="fr-1"><?php esc_html_e('Product Type', 'woo-dynamic-pricing-and-discount'); ?></td>
                <td class="fr-2"><?php esc_html_e('WooCommerce Plugin', 'woo-dynamic-pricing-and-discount'); ?></td>
            </tr>
            <tr>
                <td class="fr-1"><?php esc_html_e('Product Name', 'woo-dynamic-pricing-and-discount'); ?></td>
                <td class="fr-2"><?php esc_html_e($plugin_name, 'woo-dynamic-pricing-and-discount'); ?></td>
            </tr>
            <tr>
                <td class="fr-1"><?php esc_html_e('Installed Version', 'woo-dynamic-pricing-and-discount'); ?></td>
                <td class="fr-2"><?php esc_html_e('Free Version', 'woo-dynamic-pricing-and-discount'); ?> <?php echo esc_attr($plugin_version); ?></td>
            </tr>
            <tr>
                <td class="fr-1"><?php esc_html_e('License & Terms of use', 'woo-dynamic-pricing-and-discount'); ?></td>
                <td class="fr-2"><a target="_blank"  href="<?php echo esc_url("https://www.thedotstore.com/terms-and-conditions/"); ?>"><?php esc_html_e('Click here', 'woo-dynamic-pricing-and-discount'); ?></a><?php esc_html_e(' to view license and terms of use.', 'woo-dynamic-pricing-and-discount'); ?></td>
            </tr>
            <tr>
                <td class="fr-1"><?php esc_html_e('Help & Support', 'woo-dynamic-pricing-and-discount'); ?></td>
                <td class="fr-2">
                    <ul style="margin: 0px;">
                        <li><a target="_blank" href="<?php echo esc_url(site_url('wp-admin/admin.php?page=wdpad-pro-get-started')); ?>"><?php esc_html_e('Quick Start', 'woo-dynamic-pricing-and-discount'); ?></a></li>
                        <li><a target="_blank" href="#"><?php esc_html_e('Guide Documentation', 'woo-dynamic-pricing-and-discount'); ?></a></li>
                        <li><a target="_blank" href="<?php echo esc_url("http://t.signauxdeux.com/e1t/c/5/f18dQhb0SmZ58dDMPbW2n0x6l2B9nMJW7sM9dn7dK_MMdBzM2-04?t=https%3A%2F%2Fstore.multidots.com%2Fdotstore-support-panel%2F&si=4973901068632064&pi=61378fda-f5e5-4125-c521-28a4597b13d6"); ?>"><?php esc_html_e('Support Forum', 'woo-dynamic-pricing-and-discount'); ?></a></li>
                    </ul>
                </td>
            </tr>
            <tr>
                <td class="fr-1"><?php esc_html_e('Localization', 'woo-dynamic-pricing-and-discount'); ?></td>
                <td class="fr-2"><?php esc_html_e('English, Spanish', 'woo-dynamic-pricing-and-discount'); ?></td>
            </tr>

        </tbody>
    </table>
</div>
<?php
require_once plugin_dir_path( __FILE__ ) . 'header/plugin-sidebar.php';