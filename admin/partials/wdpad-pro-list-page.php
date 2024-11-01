<?php
// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    exit;
}
require_once plugin_dir_path( __FILE__ ) . 'header/plugin-header.php';
if(is_network_admin()){
	$admin_url = admin_url();
} else {
	$admin_url = network_admin_url();
}

$get_action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
$get_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
$get_wpnonce = filter_input(INPUT_GET,'_wpnonce',FILTER_SANITIZE_STRING);
$retrieved_nonce = isset($get_wpnonce) ? sanitize_text_field(wp_unslash($get_wpnonce)) : '';
$wdpadnonce = wp_create_nonce('wdpadnonce');

if (isset($get_action) && 'delete' === sanitize_text_field(wp_unslash($get_action))) {
    if (!wp_verify_nonce($wdpadnonce, 'wdpadnonce')) {
        die( 'Failed security check' );
    }
    $get_post_id = $get_id;
	$admin_urls = $admin_url.'admin.php?page=wdpad-pro-list';
    wp_delete_post($get_post_id);
    wp_redirect($admin_urls);
    exit;
}

$get_alldpad_args = array(
                            'post_type'         => 'wc_dynamic_pricing',
                            'post_status'       => 'publish',
                            'posts_per_page'    => -1,
);
$get_all_dpad = get_posts( $get_alldpad_args );
?>
<div class="wdpad-main-table res-cl">
    <div class="product_header_title">
        <h2>
            <?php esc_html_e('Product Dynamic Pricings', 'woo-dynamic-pricing-and-discount'); ?>
            <a class="add-new-btn" href="<?php echo esc_url($admin_url.'admin.php?page=wdpad-pro-add-new'); ?>"><?php esc_html_e('Add Product Dynamic Pricings', 'woo-dynamic-pricing-and-discount'); ?></a>
            <a id="detete-conditional-fee" class="detete-conditional-fee"><?php esc_html_e('Delete (Selected)', 'woo-dynamic-pricing-and-discount'); ?></a>
        </h2>
    </div>
    <table id="conditional-fee-listing" class="table-outer form-table conditional-fee-listing tablesorter">
        <thead>
            <tr class="wdpad-head">
                <th><input type="checkbox" name="check_all" class="condition-check-all"></th>
                <th><?php esc_html_e('Name', 'woo-dynamic-pricing-and-discount'); ?></th>
                <th><?php esc_html_e('Amount', 'woo-dynamic-pricing-and-discount'); ?></th>
                <th><?php esc_html_e('Status', 'woo-dynamic-pricing-and-discount'); ?></th>
                <th><?php esc_html_e('Action', 'woo-dynamic-pricing-and-discount'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($get_all_dpad)) {
                $i = 1;
                foreach ($get_all_dpad as $dpad) {
                    $get_title          = get_the_title($dpad->ID) ? get_the_title($dpad->ID) : 'Fee';
                    $get_dpad_type   = get_post_meta($dpad->ID, 'dpad_settings_select_dpad_type', true);
                    $get_dpad_type   = ( isset($get_dpad_type) && !empty($get_dpad_type) ) ? $get_dpad_type : '';
                    $getFeesCost    = get_post_meta($dpad->ID, 'dpad_settings_product_cost', true);
                    $getFeesStatus  = get_post_meta($dpad->ID, 'dpad_settings_status', true);
                    ?>
                    <tr>
                        <td width="10%">
                            <input type="checkbox" name="multiple_delete_fee[]" class="multiple_delete_fee" value="<?php echo esc_attr($dpad->ID); ?>">
                        </td>
                        <td>
                            <a href="<?php echo esc_url($admin_url.'admin.php?page=wdpad-pro-edit-fee&id=' . esc_attr($dpad->ID) . '&action=edit&_wpnonce=' . esc_attr($wdpadnonce)); ?>"><?php esc_html_e($get_title, 'woo-dynamic-pricing-and-discount'); ?></a>
                        </td>
                        <td>
                            <?php
                                if( $get_dpad_type === 'percentage' ) {
                                    echo esc_attr($getFeesCost) . ' %';
                                } else {
                                    echo esc_attr(get_woocommerce_currency_symbol()) . '&nbsp;' . esc_attr($getFeesCost);
                                }
                            ?>
                        </td>
                        <td>
                            <?php echo (isset($getFeesStatus) && $getFeesStatus === 'on') ? '<span class="active-status">' . esc_html_e('Enabled', 'woo-dynamic-pricing-and-discount') . '</span>' : '<span class="inactive-status">' . esc_html_e('Disabled', 'woo-dynamic-pricing-and-discount') . '</span>'; ?>
                        </td>
                        <td>
                            <a class="fee-action-button button-primary" href="<?php echo esc_url($admin_url.'admin.php?page=wdpad-pro-edit-fee&id=' . esc_attr($dpad->ID) . '&action=edit&_wpnonce=' . esc_attr($wdpadnonce)); ?>"><?php esc_html_e('Edit', 'woo-dynamic-pricing-and-discount'); ?></a>
                            <a class="fee-action-button button-primary" href="<?php echo esc_url($admin_url.'admin.php?page=wdpad-pro-list&id=' . esc_attr($dpad->ID) . '&action=delete&_wpnonce=' . esc_attr($wdpadnonce)); ?>"><?php esc_html_e('Delete', 'woo-dynamic-pricing-and-discount'); ?></a>
                        </td>
                    </tr>
                    <?php
                    $i++;
                }
            }
            ?>
        </tbody>
    </table>
</div>
<?php
require_once plugin_dir_path( __FILE__ ) . 'header/plugin-sidebar.php';