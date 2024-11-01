<?php
// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    exit;
}
require_once plugin_dir_path( __FILE__ ) . 'header/plugin-header.php';
?>
<div class="wdpad-main-table res-cl">
    <h2><?php esc_html_e('Thanks For Installing Dynamic Pricing and Discount for WooCommerce', 'woo-dynamic-pricing-and-discount'); ?></h2>
    <table class="table-outer">
        <tbody>
            <tr>
                <td class="fr-2">
                    <p class="block gettingstarted"><strong><?php esc_html_e('Getting Started', 'woo-dynamic-pricing-and-discount'); ?> </strong></p>
                    <p class="block textgetting">
                        <?php esc_html_e('The plugin helps you quickly create dynamic discounts and pricing rules for your WooCommerce store.', 'woo-dynamic-pricing-and-discount'); ?>
                    </p>
	                <p class="block textgetting">
		                <?php esc_html_e('You can create any type of woocommerce dynamic discount such as Bulk discounts, Country based Discount, cart discounts, special offers, user role-based discounts and more.', 'woo-dynamic-pricing-and-discount'); ?>
	                </p>
	                <p class="block textgetting">
		                <?php esc_html_e('Main USP of this plugin is a very simple and easy to set discounts rules as compare other plugins.', 'woo-dynamic-pricing-and-discount'); ?>
	                </p>
	                <p class="block textgetting">
                        <?php
                        echo sprintf( wp_kses( __( '<strong>KEY FEATURES:</strong>', 'woo-dynamic-pricing-and-discount' )
                            , array('strong' => array())));
                        ?>
	                </p>
                    <p class="block textgetting">
                        <?php
                        echo sprintf( wp_kses( __( '- Bulk purchase discounts <br> - Product Specific discounts<br> - Category based discounts<br> - Cart subtotal based discounts<br> - Country based discounts <br> - User 
role-based discounts.<br> - Special offers (Holiday Discount Campaigns)', 'woo-dynamic-pricing-and-discount' )
                            , array('br' => array())));
                        ?>
                    </p>
	                <p class="block textgetting">
                        <?php
                        echo sprintf( wp_kses( __( '<strong>DISCOUNT TYPES:</strong>', 'woo-dynamic-pricing-and-discount' )
                            , array('strong' => array())));
                        ?>
	                </p>
	                <p class="block textgetting">
                        <?php
                        echo sprintf( wp_kses( __( '- Percent Discount <br> - Fixed Amount Discounts', 'woo-dynamic-pricing-and-discount' )
                            , array('br' => array())));
                        ?>
	                </p>
	                <p class="block textgetting">
                        <?php
                        echo sprintf( wp_kses( __( '<strong>SAMPLE EXAMPLE:</strong>', 'woo-dynamic-pricing-and-discount' )
                            , array('strong' => array())));
                        ?>
	                </p>
	                <p class="block textgetting">
                        <?php
                        echo sprintf( wp_kses( __( '<b>Bulk Discount</b>', 'woo-dynamic-pricing-and-discount' )
                            , array('b' => array())));
                        ?>
	                </p>
	                <p class="block textgetting">
		                <?php esc_html_e('Create bulk discounts on entire store /categories /products. It can also be based on the order total.', 'woo-dynamic-pricing-and-discount'); ?>
	                </p>
					<ul>
						<li><?php esc_html_e('Buy 10 quantity of any products in the store, get a 10% discount', 'woo-dynamic-pricing-and-discount'); ?></li>
						<li><?php esc_html_e('Buy any 6 quantity from Category A, get a 10% discount', 'woo-dynamic-pricing-and-discount'); ?></li>
						<li><?php esc_html_e('Buy 5 quantity of Product A and get a 10%  discount', 'woo-dynamic-pricing-and-discount'); ?></li>
					</ul>
	                <p class="block textgetting">
                        <?php
                        echo sprintf( wp_kses( __( '<b>Product Specific discounts</b>', 'woo-dynamic-pricing-and-discount' )
                            , array('b' => array())));
                        ?>
	                </p>
	                <ul>
		                <li><?php esc_html_e('Get 20% discount on T-Shirts.', 'woo-dynamic-pricing-and-discount'); ?></li>
		                <li><?php esc_html_e('Get a 15% discount for any quantities of Shoe.', 'woo-dynamic-pricing-and-discount'); ?></li>
		                <li><?php esc_html_e('Buy 2 or more Tshirt - get 5$ discount each.', 'woo-dynamic-pricing-and-discount'); ?></li>
	                </ul>
	                <p class="block textgetting">
                        <?php
                        echo sprintf( wp_kses( __( '<b>Category based discounts</b>', 'woo-dynamic-pricing-and-discount' )
                            , array('b' => array())));
                        ?>
	                </p>
	                <ul>
		                <li><?php esc_html_e('Get 20% discount on shoe category.', 'woo-dynamic-pricing-and-discount'); ?></li>
		                <li><?php esc_html_e('Get 25% discount on men\'s shirt.', 'woo-dynamic-pricing-and-discount'); ?></li>
	                </ul>
	                <p class="block textgetting">
                        <?php
                        echo sprintf( wp_kses( __( '<b>Cart subtotal based discounts</b>', 'woo-dynamic-pricing-and-discount' )
                            , array('b' => array())));
                        ?>
	                </p>
	                <ul>
		                <li><?php esc_html_e('If Cart subtotal is $100 - 199 = 10 % discount.', 'woo-dynamic-pricing-and-discount'); ?></li>
		                <li><?php esc_html_e('If Cart subtotal is $200 - 299 = 20 % discount.', 'woo-dynamic-pricing-and-discount'); ?></li>
		                <li><?php esc_html_e('If Cart subtotal is $300 - 499 = 30% discount.', 'woo-dynamic-pricing-and-discount'); ?></li>
	                </ul>
	                <p class="block textgetting">
                        <?php
                        echo sprintf( wp_kses( __( '<b>Country-based discounts</b>', 'woo-dynamic-pricing-and-discount' )
                            , array('b' => array())));
                        ?>
	                </p>
	                <ul>
		                <li><?php esc_html_e('Give 10% discount for US customer.', 'woo-dynamic-pricing-and-discount'); ?></li>
		                <li><?php esc_html_e('Give 20% discount for Canada customer.', 'woo-dynamic-pricing-and-discount'); ?></li>
	                </ul>
	                <p class="block textgetting">
                        <?php
                        echo sprintf( wp_kses( __( '<b>User role-based discounts</b>', 'woo-dynamic-pricing-and-discount' )
                            , array('b' => array())));
                        ?>
	                </p>
	                <ul>
		                <li><?php esc_html_e('20% discount to customers who belong to the user role "Subscriber".', 'woo-dynamic-pricing-and-discount'); ?></li>
		                <li><?php esc_html_e('10% discount to customers who belong to the user role "wholesaler ".', 'woo-dynamic-pricing-and-discount'); ?></li>
	                </ul>
                    <p class="block textgetting">
                        <?php esc_html_e('It is a valuable tool for store owners for set dynamic product new price and special discount offer for the customer.', 'woo-dynamic-pricing-and-discount'); ?>
                    </p>

                    <p class="block textgetting">
                        <strong><?php esc_html_e('Step 1', 'woo-dynamic-pricing-and-discount'); ?> :</strong> <?php esc_html_e('Add Dynamic Price and Discount Rule', 'woo-dynamic-pricing-and-discount'); ?>
                    </p>
                    <p class="block textgetting"><?php esc_html_e('Here we can see that there are so many conditions you can create based on your requirement by selecting your choice.',
		                    'woo-dynamic-pricing-and-discount'); ?>
                    </p>
                    <span class="gettingstarted">
                        <img style="border: 2px solid #e9e9e9;margin-top: 1%;margin-bottom: 2%;" src="<?php echo esc_url(WDPAD_FREE_PLUGIN_URL . 'admin/images/Getting_Started_01.png'); ?>">
                    </span>
                    <p class="block gettingstarted textgetting">
                        <strong><?php esc_html_e('Step 2', 'woo-dynamic-pricing-and-discount'); ?> :</strong> <?php esc_html_e('Add dynamic discount rule title, discount value and set dynamic discount rule as per your requirement.', 'woo-dynamic-pricing-and-discount'); ?>
                        <span class="gettingstarted">
                            <img style="border: 2px solid #e9e9e9;margin-top: 2%;margin-bottom: 2%;" src="<?php echo esc_url(WDPAD_FREE_PLUGIN_URL . 'admin/images/Getting_Started_02.png'); ?>">
                        </span>
                    </p>
                    <p class="block gettingstarted textgetting">
                        <strong><?php esc_html_e('Step 3', 'woo-dynamic-pricing-and-discount'); ?> :</strong> <?php esc_html_e('All dynamic discount rules display here. As per below screenshot', 'woo-dynamic-pricing-and-discount'); ?>
                        <span class="gettingstarted">
                            <img style="border: 2px solid #e9e9e9;margin-top: 3%;margin-bottom: 2%;" src="<?php echo esc_url(WDPAD_FREE_PLUGIN_URL . 'admin/images/Getting_Started_03.png');
                            ?>">
                        </span>
                    </p>
	                <p class="block gettingstarted textgetting">
		                <strong><?php esc_html_e('Step 4', 'woo-dynamic-pricing-and-discount'); ?> :</strong> <?php esc_html_e('View dynamic discount rules applied on the cart page as per below.', 'woo-dynamic-pricing-and-discount'); ?>
		                <span class="gettingstarted">
                            <img style="border: 2px solid #e9e9e9;margin-top: 2%;margin-bottom: 2%;" src="<?php echo esc_url(WDPAD_FREE_PLUGIN_URL . 'admin/images/Getting_Started_04.png');
                            ?>">
                        </span>
	                </p>
	                <p class="block gettingstarted textgetting">
		                <strong><?php esc_html_e('Step 5', 'woo-dynamic-pricing-and-discount'); ?> :</strong> <?php esc_html_e('View dynamic discount rules applied on the checkout page as per below.', 'woo-dynamic-pricing-and-discount'); ?>
		                <span class="gettingstarted">
                            <img style="border: 2px solid #e9e9e9;margin-top: 2%;" src="<?php echo esc_url(WDPAD_FREE_PLUGIN_URL . 'admin/images/Getting_Started_05.png'); ?>">
                        </span>
	                </p>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<?php
require_once plugin_dir_path( __FILE__ ) . 'header/plugin-sidebar.php';