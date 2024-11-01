<?php
// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    exit;
}
require_once plugin_dir_path( __FILE__ ) . 'header/plugin-header.php';

$get_submit_fess = filter_input(INPUT_POST, 'submitFee', FILTER_SANITIZE_STRING);
$get_action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
$get_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);

if ( isset($get_submit_fess) && !empty($get_submit_fess) ) {
    $get_post = $_POST;
    $this->wdpad_free_dpad_conditions_save($get_post);
}
if (isset($get_action) && $get_action === 'edit') {
    $get_wpnonce = filter_input(INPUT_GET,'_wpnonce',FILTER_SANITIZE_STRING);
    $get_retrieved_nonce = isset($get_wpnonce) ? sanitize_text_field(wp_unslash($get_wpnonce)) : '';

    if (!wp_verify_nonce($get_retrieved_nonce, 'wdpadnonce')) {
        die('Failed security check');
    }
    $get_post_id        = $get_id;
    $btnValue           = esc_html__('Update', 'woo-dynamic-pricing-and-discount');
    $dpad_title         = esc_html__(get_the_title($get_post_id), 'woo-dynamic-pricing-and-discount');
    $getFeesCost        = esc_html__(get_post_meta($get_post_id, 'dpad_settings_product_cost', true), 'woo-dynamic-pricing-and-discount');
    $getFeesPerQtyFlag  = get_post_meta($get_post_id, 'dpad_chk_qty_price', true);
    $getFeesPerQty      = get_post_meta($get_post_id, 'dpad_per_qty', true);
    $extraProductCost   = get_post_meta($get_post_id, 'extra_product_cost', true);
    $getFeesType        = esc_html__(get_post_meta($get_post_id, 'dpad_settings_select_dpad_type', true), 'woo-dynamic-pricing-and-discount');
    $getFeesStartDate   = get_post_meta($get_post_id, 'dpad_settings_start_date', true);
    $getFeesEndDate     = get_post_meta($get_post_id, 'dpad_settings_end_date', true);
    $getFeesStatus      = get_post_meta($get_post_id, 'dpad_settings_status', true);
    $productFeesArray   = get_post_meta($get_post_id, 'dynamic_pricing_metabox', true);
    $getFeesOptional    = esc_html__(get_post_meta($get_post_id, 'dpad_settings_optional_gift', true), 'woo-dynamic-pricing-and-discount');
    $byDefaultChecked   = get_post_meta($get_post_id, 'by_default_checkbox_checked', true);
} else {
    $get_post_id            = '';
    $btnValue           = esc_html__('Submit', 'woo-dynamic-pricing-and-discount');
    $dpad_title          = '';
    $getFeesCost        = '';
    $getFeesPerQtyFlag  = '';
    $getFeesPerQty      = '';
    $extraProductCost   = '';
    $getFeesType        = '';
    $getFeesStartDate   = '';
    $getFeesEndDate     = '';
    $getFeesStatus      = '';
    $productFeesArray   = array();
    $getFeesOptional    = '';
    $byDefaultChecked   = '';
}
?>
<div class="text-condtion-is" style="display:none;">
    <select class="text-condition">
        <option value="is_equal_to"><?php esc_html_e('Equal to ( = )', 'woo-dynamic-pricing-and-discount'); ?></option>
        <option value="less_equal_to"><?php esc_html_e('Less or Equal to ( <= )', 'woo-dynamic-pricing-and-discount'); ?></option>
        <option value="less_then"><?php esc_html_e('Less than ( < )', 'woo-dynamic-pricing-and-discount'); ?></option>
        <option value="greater_equal_to"><?php esc_html_e('Greater or Equal to ( >= )', 'woo-dynamic-pricing-and-discount'); ?></option>
        <option value="greater_then"><?php esc_html_e('Greater than ( > )', 'woo-dynamic-pricing-and-discount'); ?></option>
        <option value="not_in"><?php esc_html_e('Not Equal to ( != )', 'woo-dynamic-pricing-and-discount'); ?></option>
    </select>
    <select class="select-condition">
        <option value="is_equal_to"><?php esc_html_e('Equal to ( = )', 'woo-dynamic-pricing-and-discount'); ?></option>
        <option value="not_in"><?php esc_html_e('Not Equal to ( != )', 'woo-dynamic-pricing-and-discount'); ?></option>
    </select>
</div>
<div class="default-country-box" style="display:none;">
    <?php echo wp_kses($this->wdpad_free_get_country_list(), WDPAD_Woo_Dynamic_Pricing_And_Discount_Free::wdpad_allowed_html_tags()); ?>
</div>
<div class="wdpad-main-table res-cl">
    <h2><?php esc_html_e('Fee Configuration', 'woo-dynamic-pricing-and-discount'); ?></h2>
    <form method="POST" name="dpadfrm" action="">
        <?php wp_nonce_field('wdpad_pro_save_action','wdpad_pro_conditions_save'); ?>
        <input type="hidden" name="post_type" value="wc_dynamic_pricing">
        <input type="hidden" name="dpad_post_id" value="<?php echo esc_attr($get_post_id); ?>">
        <table class="form-table table-outer product-fee-table">
            <tbody>
                <tr valign="top">
                    <th class="titledesc" scope="row"><label for="dpad_settings_product_dpad_title"><?php esc_html_e('Dynamic Discount Rule Title (Public)', 'woo-dynamic-pricing-and-discount'); ?> <span class="required-star">*</span></label></th>
                    <td class="forminp">
                        <input type="text" name="dpad_settings_product_dpad_title" class="text-class" id="dpad_settings_product_dpad_title" value="<?php echo isset($dpad_title) ? esc_attr($dpad_title) : ''; ?>" required="1" placeholder="<?php esc_html_e('Enter product dpad title', 'woo-dynamic-pricing-and-discount'); ?>">
                        <span class="woocommerce_conditional_product_dpad_checkout_tab_descirtion"></span>
                        <p class="description" style="display:none;">
                            <?php esc_html_e('This discount rule title is visible to the customer at the time of checkout.', 'woo-dynamic-pricing-and-discount'); ?>
                        </p>
                    </td>
                </tr>
                <tr valign="top">
                    <th class="titledesc" scope="row">	
                        <label for="dpad_settings_select_dpad_type"><?php esc_html_e('Select Discount Type', 'woo-dynamic-pricing-and-discount'); ?></label>
                    </th>
                    <td class="forminp">
                        <select name="dpad_settings_select_dpad_type" id="dpad_settings_select_dpad_type" class="">
                            <option value="fixed" <?php echo isset($getFeesType) && $getFeesType === 'fixed' ? 'selected="selected"' : '' ?>><?php esc_html_e('Fixed', 'woo-dynamic-pricing-and-discount'); ?></option>
                            <option value="percentage" <?php echo isset($getFeesType) && $getFeesType === 'percentage' ? 'selected="selected"' : '' ?>><?php esc_html_e('Percentage', 'woo-dynamic-pricing-and-discount'); ?></option>
                        </select>
                        <span class="woocommerce_conditional_product_dpad_checkout_tab_descirtion"></span>
                        <p class="description" style="display:none;">
                            <?php esc_html_e('you can give discount on fixed price or percentage based.', 'woo-dynamic-pricing-and-discount'); ?>
                        </p>
                    </td>
                </tr>
                <tr valign="top">
                    <th class="titledesc" scope="row"><label for="dpad_settings_product_cost"><?php esc_html_e('Discount value', 'woo-dynamic-pricing-and-discount'); ?> <span class="required-star">*</span></label></th>
                    <td class="forminp">
                        <div class="product_cost_left_div">
                            <input type="text" name="dpad_settings_product_cost" required="1" class="text-class" id="dpad_settings_product_cost" value="<?php echo isset($getFeesCost) ? esc_attr($getFeesCost) : ''; ?>" placeholder="<?php echo esc_attr(get_woocommerce_currency_symbol()); ?>">
                            <span class="woocommerce_conditional_product_dpad_checkout_tab_descirtion"></span>
                            <p class="description" style="display:none;">
                                <?php
                                echo sprintf( wp_kses( __( 'If you select fixed discount type then : you have add fixed discount value. (Eg. 10, 20) <br/>
                                If you select percentage based discount type then : you have add percentage of discount (Eg. 10, 15.20)',
                                        'woo-dynamic-pricing-and-discount' )
                                    , array('br' => array())));
                                ?>
                            </p>
                        </div>
                        <div class="product_cost_right_div">
                            
                            <div class="applyperqty-boxone">
                                <label for="dpad_chk_qty_price"><?php esc_html_e('Apply Per Quantity', 'woo-dynamic-pricing-and-discount'); ?></label>
                                <input type="checkbox" name="dpad_chk_qty_price" id="dpad_chk_qty_price" class="chk_qty_price_class" value="on" <?php checked( $getFeesPerQtyFlag, 'on' ); ?>>
                                <span class="woocommerce_conditional_product_dpad_checkout_tab_descirtion"></span>
                                <p class="description" style="display:none;"><?php esc_html_e('Apply this fee per quantity of products.', 'woo-dynamic-pricing-and-discount'); ?></p>
                            </div>
                            
                            <div class="applyperqty-boxtwo">
                                <label for="apply_per_qty_type"><?php esc_html_e('Calculate Quantity Based On', 'woo-dynamic-pricing-and-discount'); ?></label>
                                <select name="dpad_per_qty" id="price_cartqty_based" class="chk_qty_price_class" id="apply_per_qty_type">
                                    <option value="qty_cart_based" <?php selected($getFeesPerQty, 'qty_cart_based'); ?>><?php esc_html_e('Cart Based', 'woo-dynamic-pricing-and-discount'); ?></option>
                                    <option value="qty_product_based" <?php selected($getFeesPerQty, 'qty_product_based'); ?>><?php esc_html_e('Product Based', 'woo-dynamic-pricing-and-discount'); ?></option>
                                </select>
                                <span class="woocommerce_conditional_product_dpad_checkout_tab_descirtion"></span>
                                <p class="description" style="display:none;">
                                    <?php
                                    echo sprintf( wp_kses( __( 'If you want to apply the fee for each quantity - where quantity should calculated based on product/category/tag conditions, 
then select the "Product Based" option.<br> If you want to apply the fee for each quantity in the customer\'s cart, then select the "Cart Based" option.',
                                            'woo-dynamic-pricing-and-discount' )
                                        , array('br' => array())));
                                    ?>
                                </p>
                            </div>
                            <div class="applyperqty-boxthree">
                                <label for="extra_product_cost"><?php esc_html_e('Fee per Additional Quantity&nbsp;(' . get_woocommerce_currency_symbol() . ') ', 'woo-dynamic-pricing-and-discount'); ?><span class="required-star">*</span></label>
                                <input type="text" name="extra_product_cost" class="text-class" id="extra_product_cost" required value="<?php echo isset($extraProductCost) ? esc_attr($extraProductCost) : ''; ?>" placeholder="<?php echo esc_attr(get_woocommerce_currency_symbol()); ?>">
                                <span class="woocommerce_conditional_product_dpad_checkout_tab_descirtion"></span>
                                <p class="description" style="display:none;">
                                    <?php
                                    echo sprintf( wp_kses( __( 'You can add fee here to be charged for each additional quantity. E.g. if user has added 3 quantities and you have set 
                                            fee=$10 and fee per additional quantity=$5, then total extra fee=$10+$5+$5=$20.<br>'
                                            . 'The quantity will be calculated based on the option chosen in the "Calculate Quantity Based On" above dropdown. That means, 
                                            if you have chosen "Product Based" option - quantities will be calculated based on the products which are meeting the conditions 
                                            set for this fee, and if they are more than 1, fee will be calculated considering only its additional quantities. e.g. 5 items in cart, 
                                            and 3 are meeting the condition set, then additional fee of $5 will be charged on 2 quantities only, and not on 4 quantities.',
                                            'woo-dynamic-pricing-and-discount' )
                                        , array('br' => array())));
                                    ?>
                                </p>
                            </div>
                            
                        </div>
                    </td>
                </tr>
                <tr valign="top">
                    <th class="titledesc" scope="row"><label for="dpad_settings_start_date"><?php esc_html_e('Start Date', 'woo-dynamic-pricing-and-discount'); ?></label></th>
                    <td class="forminp">
                        <input type="text" name="dpad_settings_start_date" class="text-class" id="dpad_settings_start_date" value="<?php echo isset($getFeesStartDate) ? esc_attr($getFeesStartDate) : ''; ?>" placeholder="<?php esc_html_e('Select start date', 'woo-dynamic-pricing-and-discount'); ?>">
                        <span class="woocommerce_conditional_product_dpad_checkout_tab_descirtion"></span>
                        <p class="description" style="display:none;"><?php esc_html_e('Select start date which date product discount rules will enable on website.', 'woo-dynamic-pricing-and-discount'); ?></p>
                    </td>
                </tr>
                <tr valign="top">
                    <th class="titledesc" scope="row"><label for="dpad_settings_end_date"><?php esc_html_e('End Date', 'woo-dynamic-pricing-and-discount'); ?></label></th>
                    <td class="forminp">
                        <input type="text" name="dpad_settings_end_date" class="text-class" id="dpad_settings_end_date" value="<?php echo isset($getFeesEndDate) ? esc_attr($getFeesEndDate) : ''; ?>" placeholder="<?php esc_html_e('Select end date', 'woo-dynamic-pricing-and-discount'); ?>">
                        <span class="woocommerce_conditional_product_dpad_checkout_tab_descirtion"></span>
                        <p class="description" style="display:none;"><?php esc_html_e('Select ending date which date product discount rules will disable on website', 'woo-dynamic-pricing-and-discount'); ?></p>
                    </td>
                </tr>
                <tr valign="top">
                    <th class="titledesc" scope="row"><label for="onoffswitch"><?php esc_html_e('Status', 'woo-dynamic-pricing-and-discount'); ?></label></th>
                    <td class="forminp">
                        <label class="switch">
                            <input type="checkbox" name="dpad_settings_status" value="on" <?php echo (isset($getFeesStatus) && $getFeesStatus === 'off') ? '' : 'checked'; ?>>
                            <div class="slider round"></div>
                        </label>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="sub-title">
            <h2><?php esc_html_e('Dynamic Discount Rule', 'woo-dynamic-pricing-and-discount'); ?></h2>
            <div class="tap"><a id="fee-add-field" class="button button-primary button-large" href="javascript:;"><?php esc_html_e('+ Add Row', 'woo-dynamic-pricing-and-discount'); ?></a> </div>
        </div>
        <div class="tap">
            <table id="tbl-product-fee" class="tbl_product_fee table-outer tap-cas form-table product-fee-table">
                <tbody>
                    <?php
                    if (isset($productFeesArray) && !empty($productFeesArray)) {
                        $i = 2;
                        foreach ($productFeesArray as $key => $productdpad) {
                            $dpad_conditions = isset($productdpad['product_dpad_conditions_condition']) ? $productdpad['product_dpad_conditions_condition'] : '';
                            $condition_is = isset($productdpad['product_dpad_conditions_is']) ? $productdpad['product_dpad_conditions_is'] : '';
                            $condtion_value = isset($productdpad['product_dpad_conditions_values']) ? $productdpad['product_dpad_conditions_values'] : array();
                            ?>
                            <tr id="row_<?php echo esc_attr($i); ?>" valign="top">
                                <th class="titledesc th_product_dpad_conditions_condition" scope="row">
                                    <select rel-id="<?php echo esc_attr($i); ?>" id="product_dpad_conditions_condition_<?php echo esc_attr($i); ?>" name="dpad[product_dpad_conditions_condition][]" id="product_dpad_conditions_condition" class="product_dpad_conditions_condition">
                                        <optgroup label="<?php esc_html_e('Location Specific', 'woo-dynamic-pricing-and-discount'); ?>">
                                            <option value="country" <?php echo ($dpad_conditions === 'country' ) ? 'selected' : '' ?>><?php esc_html_e('Country', 'woo-dynamic-pricing-and-discount'); ?></option>
                                            <option value="state" <?php echo ($dpad_conditions === 'state' ) ? 'selected' : '' ?> disabled><?php esc_html_e('State (Available in Pro Version)',
		                                            'woo-dynamic-pricing-and-discount'); ?></option>
                                            <option value="postcode" <?php echo ($dpad_conditions === 'postcode' ) ? 'selected' : '' ?> disabled><?php esc_html_e('Postcode (Available in Pro Version)',
		                                            'woo-dynamic-pricing-and-discount'); ?></option>
                                            <option value="zone" <?php echo ($dpad_conditions === 'zone' ) ? 'selected' : '' ?> disabled><?php esc_html_e('Zone (Available in Pro Version)',
		                                            'woo-dynamic-pricing-and-discount'); ?></option>
                                        </optgroup>
                                        <optgroup label="<?php esc_html_e('Product Specific', 'woo-dynamic-pricing-and-discount'); ?>">
                                            <option value="product" <?php echo ($dpad_conditions === 'product' ) ? 'selected' : '' ?>><?php esc_html_e('Product', 'woo-dynamic-pricing-and-discount'); ?></option>
                                            <option value="variableproduct" <?php echo ($dpad_conditions === 'variableproduct' ) ? 'selected' : '' ?> disabled><?php esc_html_e('Variable 
                                            Product (Available in Pro Version)', 'woo-dynamic-pricing-and-discount'); ?></option>
                                            <option value="category" <?php echo ($dpad_conditions === 'category' ) ? 'selected' : '' ?>><?php esc_html_e('Category', 'woo-dynamic-pricing-and-discount'); ?></option>
                                            <option value="tag" <?php echo ($dpad_conditions === 'tag' ) ? 'selected' : '' ?> disabled><?php esc_html_e('Tag (Available in Pro Version)',
		                                            'woo-dynamic-pricing-and-discount'); ?></option>
                                        </optgroup>	
                                        <optgroup label="<?php esc_html_e('User Specific', 'woo-dynamic-pricing-and-discount'); ?>">
                                            <option value="user" <?php echo ($dpad_conditions === 'user' ) ? 'selected' : '' ?>><?php esc_html_e('User', 'woo-dynamic-pricing-and-discount'); ?></option>
                                            <option value="user_role" <?php echo ($dpad_conditions === 'user_role' ) ? 'selected' : '' ?> disabled><?php esc_html_e('User Role (Available in Pro Version)',
		                                            'woo-dynamic-pricing-and-discount'); ?></option>
                                        </optgroup>
                                        <optgroup label="<?php esc_html_e('Cart Specific', 'woo-dynamic-pricing-and-discount'); ?>">
                                            <?php
                                            $currency_symbol = get_woocommerce_currency_symbol();
                                            $currency_symbol = !empty($currency_symbol) ? '(' . $currency_symbol . ')' : '';

                                            $weight_unit = get_option('woocommerce_weight_unit');
                                            $weight_unit = !empty($weight_unit) ? '(' . $weight_unit . ')' : '';
                                            ?>	
                                            <option value="cart_total" <?php echo ($dpad_conditions === 'cart_total' ) ? 'selected' : '' ?>><?php esc_html_e('Cart Subtotal', 'woo-dynamic-pricing-and-discount'); ?></option>
                                            <option value="quantity" <?php echo ($dpad_conditions === 'quantity' ) ? 'selected' : '' ?>><?php esc_html_e('Quantity', 'woo-dynamic-pricing-and-discount'); ?></option>
                                            <option value="weight" <?php echo ($dpad_conditions === 'weight' ) ? 'selected' : '' ?> disabled><?php esc_html_e('Weight (Available in Pro Version)',
		                                            'woo-dynamic-pricing-and-discount'); ?><?php echo esc_attr($weight_unit); ?></option>
                                            <option value="coupon" <?php echo ($dpad_conditions === 'coupon' ) ? 'selected' : '' ?> disabled><?php esc_html_e('Coupon (Available in Pro Version)',
		                                            'woo-dynamic-pricing-and-discount'); ?></option>
                                            <option value="shipping_class" <?php echo ($dpad_conditions === 'shipping_class' ) ? 'selected' : '' ?> disabled><?php esc_html_e('Shipping Class (Available in Pro Version)',
		                                            'woo-dynamic-pricing-and-discount'); ?></option>
                                        </optgroup>
                                        <optgroup label="<?php esc_html_e('Payment Specific', 'woo-dynamic-pricing-and-discount'); ?>">
                                            <option value="payment" <?php echo ($dpad_conditions === 'payment' ) ? 'selected' : '' ?> disabled><?php esc_html_e('Payment Gateway (Available in Pro Version)',
		                                            'woo-dynamic-pricing-and-discount'); ?></option>
                                        </optgroup>
                                        <optgroup label="<?php esc_html_e('Shipping Specific', 'woo-dynamic-pricing-and-discount'); ?>">
                                            <option value="shipping_method" <?php echo ($dpad_conditions === 'shipping_method' ) ? 'selected' : '' ?> disabled><?php esc_html_e('Shipping Method (Available in Pro Version)',
		                                            'woo-dynamic-pricing-and-discount'); ?></option>
                                        </optgroup>
                                    </select>
                                </th>	
                                <td class="select_condition_for_in_notin">
                                    <?php if ($dpad_conditions === 'cart_total' || $dpad_conditions === 'cart_totalafter' || $dpad_conditions === 'quantity' || $dpad_conditions === 'weight') { ?>
                                        <select name="dpad[product_dpad_conditions_is][]" class="product_dpad_conditions_is_<?php echo esc_attr($i); ?>">
                                            <option value="is_equal_to" <?php echo ($condition_is === 'is_equal_to' ) ? 'selected' : '' ?>><?php esc_html_e('Equal to ( = )', 'woo-dynamic-pricing-and-discount'); ?></option>
                                            <option value="less_equal_to" <?php echo ($condition_is === 'less_equal_to' ) ? 'selected' : '' ?>><?php esc_html_e('Less or Equal to ( <= )', 'woo-dynamic-pricing-and-discount'); ?></option>
                                            <option value="less_then" <?php echo ($condition_is === 'less_then' ) ? 'selected' : '' ?>><?php esc_html_e('Less than ( < )', 'woo-dynamic-pricing-and-discount'); ?></option>
                                            <option value="greater_equal_to" <?php echo ($condition_is === 'greater_equal_to' ) ? 'selected' : '' ?>><?php esc_html_e('Greater or Equal to ( >= )', 'woo-dynamic-pricing-and-discount'); ?></option>
                                            <option value="greater_then" <?php echo ($condition_is === 'greater_then' ) ? 'selected' : '' ?>><?php esc_html_e('Greater than ( > )', 'woo-dynamic-pricing-and-discount'); ?></option>
                                            <option value="not_in" <?php echo ($condition_is === 'not_in' ) ? 'selected' : '' ?>><?php esc_html_e('Not Equal to ( != )', 'woo-dynamic-pricing-and-discount'); ?></option>
                                        </select>
                                    <?php } else { ?>
                                        <select name="dpad[product_dpad_conditions_is][]" class="product_dpad_conditions_is_<?php echo esc_attr($i); ?>">
                                            <option value="is_equal_to" <?php echo ($condition_is === 'is_equal_to' ) ? 'selected' : '' ?>><?php esc_html_e('Equal to ( = )', 'woo-dynamic-pricing-and-discount'); ?></option>
                                            <option value="not_in" <?php echo ($condition_is === 'not_in' ) ? 'selected' : '' ?>><?php esc_html_e('Not Equal to ( != )', 'woo-dynamic-pricing-and-discount'); ?> </option>
                                        </select>
                                    <?php } ?>
                                </td>
                                <td class="condition-value" id="column_<?php echo esc_attr($i); ?>">
                                    <?php
                                    $html = '';
                                    if ($dpad_conditions === 'country') {
                                        $html .= $this->wdpad_free_get_country_list($i, $condtion_value);
                                    } elseif ($dpad_conditions === 'product') {
                                        $html .= $this->wdpad_free_get_product_list($i, $condtion_value, 'edit');
                                    } elseif ($dpad_conditions === 'category') {
                                        $html .= $this->wdpad_free_get_category_list($i, $condtion_value);
                                    } elseif ($dpad_conditions === 'user') {
                                        $html .= $this->wdpad_free_get_user_list($i, $condtion_value);
                                    } elseif ($dpad_conditions === 'cart_total') {
                                        $html .= '<input type = "text" name = "dpad[product_dpad_conditions_values][value_' . esc_attr($i) . ']" id = "product_dpad_conditions_values" class = "product_dpad_conditions_values" value = "' . $condtion_value . '">';
                                    } elseif ($dpad_conditions === 'quantity') {
                                        $html .= '<input type = "text" name = "dpad[product_dpad_conditions_values][value_' . esc_attr($i) . ']" id = "product_dpad_conditions_values" class = "product_dpad_conditions_values" value = "' . $condtion_value . '">';
                                    }
                                    echo wp_kses($html, WDPAD_Woo_Dynamic_Pricing_And_Discount_Free::wdpad_allowed_html_tags());
                                    ?>
                                    <input type="hidden" name="condition_key[<?php echo 'value_' . esc_attr($i); ?>]" value="">
                                </td>
                                <td><a id="fee-delete-field" rel-id="<?php echo esc_attr($i); ?>" class="delete-row" href="javascript:;" title="Delete"><i class="fa fa-trash"></i></a></td>
                            </tr>
                            <?php
                            $i++;
                        }
                        ?>
                        <?php
                    } else {
                        $i = 1;
                        ?>	
                        <tr id="row_1" valign="top">
                            <th class="titledesc th_product_dpad_conditions_condition" scope="row">
                                <select rel-id="1" id="product_dpad_conditions_condition_1" name="dpad[product_dpad_conditions_condition][]" id="product_dpad_conditions_condition" class="product_dpad_conditions_condition">
                                    <optgroup label="<?php esc_html_e('Location Specific', 'woo-dynamic-pricing-and-discount'); ?>">
                                        <option value="country"><?php esc_html_e('Country', 'woo-dynamic-pricing-and-discount'); ?></option>
                                        <option value="state" disabled><?php esc_html_e('State (Available in Pro Version)', 'woo-dynamic-pricing-and-discount'); ?></option>
                                        <option value="postcode" disabled><?php esc_html_e('Postcode (Available in Pro Version)', 'woo-dynamic-pricing-and-discount'); ?></option>
                                        <option value="zone" disabled><?php esc_html_e('Zone (Available in Pro Version)', 'woo-dynamic-pricing-and-discount'); ?></option>
                                    </optgroup>
                                    <optgroup label="<?php esc_html_e('Product Specific', 'woo-dynamic-pricing-and-discount'); ?>">
                                        <option value="product"><?php esc_html_e('Product', 'woo-dynamic-pricing-and-discount'); ?></option>
                                        <option value="variableproduct" disabled><?php esc_html_e('Variable Product (Available in Pro Version)',
		                                        'woo-dynamic-pricing-and-discount'); ?></option>
                                        <option value="category"><?php esc_html_e('Category', 'woo-dynamic-pricing-and-discount'); ?></option>
                                        <option value="tag" disabled><?php esc_html_e('Tag (Available in Pro Version)', 'woo-dynamic-pricing-and-discount'); ?></option>
                                    </optgroup>	
                                    <optgroup label="<?php esc_html_e('User Specific', 'woo-dynamic-pricing-and-discount'); ?>">
                                        <option value="user"><?php esc_html_e('User', 'woo-dynamic-pricing-and-discount'); ?></option>
                                        <option value="user_role" disabled><?php esc_html_e('User Role (Available in Pro Version)', 'woo-dynamic-pricing-and-discount'); ?></option>
                                    </optgroup>
                                    <optgroup label="<?php esc_html_e('Cart Specific', 'woo-dynamic-pricing-and-discount'); ?>">
                                        <?php
                                        $currency_symbol = get_woocommerce_currency_symbol();
                                        $currency_symbol = !empty($currency_symbol) ? '(' . $currency_symbol . ')' : '';

                                        $weight_unit = get_option('woocommerce_weight_unit');
                                        $weight_unit = !empty($weight_unit) ? '(' . $weight_unit . ')' : '';
                                        ?>
                                        <option value="cart_total"><?php esc_html_e('Cart Subtotal', 'woo-dynamic-pricing-and-discount'); ?></option>
                                        <option value="quantity"><?php esc_html_e('Quantity', 'woo-dynamic-pricing-and-discount'); ?></option>
                                        <option value="weight" disabled><?php esc_html_e('Weight (Available in Pro Version)', 'woo-dynamic-pricing-and-discount'); ?> <?php echo esc_attr($weight_unit);
                                        ?></option>
                                        <option value="coupon" disabled><?php esc_html_e('Coupon (Available in Pro Version)', 'woo-dynamic-pricing-and-discount'); ?></option>
                                        <option value="shipping_class" disabled><?php esc_html_e('Shipping Class (Available in Pro Version)', 'woo-dynamic-pricing-and-discount'); ?></option>
                                    </optgroup>
                                    <optgroup label="<?php esc_html_e('Payment Specific', 'woo-dynamic-pricing-and-discount'); ?>">
                                        <option value="payment" disabled><?php esc_html_e('Payment Gateway (Available in Pro Version)',
		                                        'woo-dynamic-pricing-and-discount'); ?></option>
                                    </optgroup>
                                    <optgroup label="<?php esc_html_e('Shipping Specific', 'woo-dynamic-pricing-and-discount'); ?>">
                                        <option value="shipping_method" disabled><?php esc_html_e('Shipping Method (Available in Pro Version)',
		                                        'woo-dynamic-pricing-and-discount'); ?></option>
                                    </optgroup>
                                </select>
                                </td>		
                            <td class="select_condition_for_in_notin">
                                <select name="dpad[product_dpad_conditions_is][]" class="product_dpad_conditions_is product_dpad_conditions_is_1">
                                    <option value="is_equal_to"><?php esc_html_e('Equal to ( = )', 'woo-dynamic-pricing-and-discount'); ?></option>
                                    <option value="not_in"><?php esc_html_e('Not Equal to ( != )', 'woo-dynamic-pricing-and-discount'); ?></option>
                                </select>
                            </td>
                            <td id="column_1" class="condition-value">
                                <?php echo wp_kses($this->wdpad_free_get_country_list(), WDPAD_Woo_Dynamic_Pricing_And_Discount_Free::wdpad_allowed_html_tags()); ?>
                                <input type="hidden" name="condition_key[value_1][]" value="">
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <input type="hidden" name="total_row" id="total_row" value="<?php echo esc_attr($i); ?>">
        </div>
        <p class="submit"><input type="submit" name="submitFee" class="button button-primary button-large" value="<?php echo esc_attr($btnValue); ?>"></p>
    </form>
</div>
<?php
require_once plugin_dir_path( __FILE__ ) . 'header/plugin-sidebar.php';