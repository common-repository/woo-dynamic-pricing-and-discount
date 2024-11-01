<?php
// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    exit;
}
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.thedotstore.com
 * @since      1.0.0
 *
 * @package    WDPAD_Woo_Dynamic_Pricing_And_Discount_Free
 * @subpackage WDPAD_Woo_Dynamic_Pricing_And_Discount_Free/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    WDPAD_Woo_Dynamic_Pricing_And_Discount_Free
 * @subpackage WDPAD_Woo_Dynamic_Pricing_And_Discount_Free/public
 * @author     Thedotstore <inquiry@multidots.in>
 */
class WDPAD_Woo_Dynamic_Pricing_And_Discount_Free_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * WDPAD_Woo_Dynamic_Pricing_And_Discount_Free_Public constructor.
	 *
	 * @since    1.0.0
	 *
	 * @param $plugin_name
	 * @param $version
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function wdpad_enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in WDPAD_Woo_Dynamic_Pricing_And_Discount_Free_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The WDPAD_Woo_Dynamic_Pricing_And_Discount_Free_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/woo-dynamic-pricing-and-discount-public.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function wdpad_enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in WDPAD_Woo_Dynamic_Pricing_And_Discount_Free_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The WDPAD_Woo_Dynamic_Pricing_And_Discount_Free_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/woo-dynamic-pricing-and-discount-public.js', array( 'jquery' ), $this->version, false );

		wp_localize_script( $this->plugin_name, 'my_ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
	}

	/** check all the condition based on selection by the user
	 *
	 * @since    1.0.0
	 *
	 * @param $template
	 * @param $template_name
	 * @param $template_path
	 *
	 * @return string
	 */
	function wdpad_woocommerce_locate_template_product_dpad_conditions( $template, $template_name, $template_path ) {

		global $woocommerce;

		$_template = $template;

		if ( ! $template_path ) {
			$template_path = $woocommerce->template_url;
		}

		$plugin_path = wdpad_woocommerce_dynamic_pricing_and_discount_free_path() . '/woocommerce/';

		$template = locate_template(
			array(
				$template_path . $template_name,
				$template_name,
			)
		);

		// Modification: Get the template from this plugin, if it exists
		if ( ! $template && file_exists( $plugin_path . $template_name ) ) {
			$template = $plugin_path . $template_name;
		}

		if ( ! $template ) {
			$template = $_template;
		}

		// Return what we found
		return $template;
	}

	/** Check price condition before add to cart
	 *
	 * @since    1.0.0
	 *
	 * @param $package
	 */
	public function wdpad_conditional_dpad_add_to_cart( $package ) {
		global $woocommerce, $woocommerce_wpml, $sitepress;

		if ( ! empty( $sitepress ) ) {
			$default_lang = $sitepress->get_default_language();
		}

		$dpad_args = array(
			'post_type'      => 'wc_dynamic_pricing',
			'post_status'    => 'publish',
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
			'posts_per_page' => - 1,
		);

		$get_all_dpad = get_posts( $dpad_args );

		$cart_array                = $woocommerce->cart->get_cart();
		$cart_sub_total            = $woocommerce->cart->subtotal;
		$cart_final_products_array = array();
		$cart_products_subtotal    = 0;

		if ( ! empty( $get_all_dpad ) ) {
			foreach ( $get_all_dpad as $dpad ) {
				$is_passed = array();

				$cart_based_qty = 0;
				foreach ( $cart_array as $woo_cart_item_key => $woo_cart_item_for_qty ) {
					$cart_based_qty += $woo_cart_item_for_qty['quantity'];
				}

				$dpad_title          = get_the_title( $dpad->ID );
				$title               = ! empty( $dpad_title ) ? esc_html__( $dpad_title, 'woo-dynamic-pricing-and-discount' ) : esc_html__( 'Fee', 'woo-dynamic-pricing-and-discount' );
				$getFeesCostOriginal = get_post_meta( $dpad->ID, 'dpad_settings_product_cost', true );
				$getFeeType          = get_post_meta( $dpad->ID, 'dpad_settings_select_dpad_type', true );

				if ( isset( $woocommerce_wpml ) && ! empty( $woocommerce_wpml->multi_currency ) ) {
					if ( isset( $getFeeType ) && ! empty( $getFeeType ) && 'fixed' == $getFeeType ) {
						$getFeesCost = $woocommerce_wpml->multi_currency->prices->convert_price_amount( $getFeesCostOriginal );
					} else {
						$getFeesCost = $getFeesCostOriginal;
					}
				} else {
					$getFeesCost = $getFeesCostOriginal;
				}

				$getFeesPerQtyFlag        = get_post_meta( $dpad->ID, 'dpad_chk_qty_price', true );
				$getFeesPerQty            = get_post_meta( $dpad->ID, 'dpad_per_qty', true );
				$extraProductCostOriginal = get_post_meta( $dpad->ID, 'extra_product_cost', true );

				if ( isset( $woocommerce_wpml ) && ! empty( $woocommerce_wpml->multi_currency ) ) {
					$extraProductCost = $woocommerce_wpml->multi_currency->prices->convert_price_amount( $extraProductCostOriginal );
				} else {
					$extraProductCost = $extraProductCostOriginal;
				}

				$getFeetaxable   = get_post_meta( $dpad->ID, 'dpad_settings_select_taxable', true );
				$getFeeStartDate = get_post_meta( $dpad->ID, 'dpad_settings_start_date', true );
				$getFeeEndDate   = get_post_meta( $dpad->ID, 'dpad_settings_end_date', true );
				$getFeeStatus    = get_post_meta( $dpad->ID, 'dpad_settings_status', true );

				if ( isset( $getFeeStatus ) && $getFeeStatus == 'off' ) {
					continue;
				}

				$get_condition_array = get_post_meta( $dpad->ID, 'dynamic_pricing_metabox', true );

				/* Percentage Logic Start */
				if ( isset( $getFeesCost ) && ! empty( $getFeesCost ) ) {

					if ( ! empty( $get_condition_array ) ) {

						$cart_products_subtotal     = 0;
						$cart_cat_products_subtotal = 0;
						$cart_tag_products_subtotal = 0;

						$product_based_percentage_subtotal = 0;
						$percentage_subtotal               = 0;

						$product_specific_flag = 0;
						$products_based_qty    = 0;

						foreach ( $get_condition_array as $key => $condition ) {
							if ( array_search( 'product', $condition ) ) {

								$site_product_id           = '';
								$cart_final_products_array = array();

								/* Product Condition Start */
								if ( $condition['product_dpad_conditions_is'] == 'is_equal_to' ) {
									if ( ! empty( $condition['product_dpad_conditions_values'] ) ) {
										foreach ( $condition['product_dpad_conditions_values'] as $product_id ) {
											foreach ( $cart_array as $key => $value ) {

												if ( ! empty( $sitepress ) ) {
													$site_product_id = apply_filters( 'wpml_object_id', $value['product_id'], 'product', true, $default_lang );
												} else {
													$site_product_id = $value['product_id'];
												}

												if ( $product_id == $site_product_id ) {
													$cart_final_products_array[] = $value;
												}
											}
										}
									}
								} elseif ( $condition['product_dpad_conditions_is'] == 'not_in' ) {
									if ( ! empty( $condition['product_dpad_conditions_values'] ) ) {
										foreach ( $condition['product_dpad_conditions_values'] as $product_id ) {
											foreach ( $cart_array as $key => $value ) {

												if ( ! empty( $sitepress ) ) {
													$site_product_id = apply_filters( 'wpml_object_id', $value['product_id'], 'product', true, $default_lang );
												} else {
													$site_product_id = $value['product_id'];
												}

												if ( $product_id != $site_product_id ) {
													$cart_final_products_array[] = $value;
												}
											}
										}
									}
								}

								if ( ! empty( $cart_final_products_array ) ) {
									$product_specific_flag = 1;
									foreach ( $cart_final_products_array as $cart_item ) {

										$products_based_qty += $cart_item['quantity'];

										$line_item_subtotal     = $cart_item['line_subtotal'] + $cart_item['line_subtotal_tax'];
										$cart_products_subtotal += $line_item_subtotal;
									}
								}
								/* Product Condition End */
							}

							if ( array_search( 'category', $condition ) ) {

								/* Category Condition Start */
								$final_cart_products_cats_ids  = array();
								$cart_final_cat_products_array = array();

								$all_cats = get_terms(
									array(
										'taxonomy' => 'product_cat',
										'fields'   => 'ids',
									)
								);

								if ( $condition['product_dpad_conditions_is'] == 'is_equal_to' ) {
									if ( ! empty( $condition['product_dpad_conditions_values'] ) ) {
										foreach ( $condition['product_dpad_conditions_values'] as $category_id ) {
											$final_cart_products_cats_ids[] = $category_id;
										}
									}
								} elseif ( $condition['product_dpad_conditions_is'] == 'not_in' ) {
									if ( ! empty( $condition['product_dpad_conditions_values'] ) ) {
										$final_cart_products_cats_ids = array_diff( $all_cats, $condition['product_dpad_conditions_values'] );
									}
								}

								$cat_args         = array(
									'post_type'      => 'product',
									'posts_per_page' => - 1,
									'order'          => 'ASC',
									'fields'         => 'ids',
									'tax_query'      => array(
										array(
											'taxonomy' => 'product_cat',
											'field'    => 'term_id',
											'terms'    => $final_cart_products_cats_ids,
										),
									),
								);
								$cat_products_ids = get_posts( $cat_args );

								foreach ( $cart_array as $key => $value ) {
									if ( in_array( $value['product_id'], $cat_products_ids ) ) {
										$cart_final_cat_products_array[] = $value;
									}
								}

								if ( ! empty( $cart_final_cat_products_array ) ) {
									$product_specific_flag = 1;
									foreach ( $cart_final_cat_products_array as $cart_item ) {

										$products_based_qty += $cart_item['quantity'];

										$line_item_subtotal         = $cart_item['line_subtotal'] + $cart_item['line_subtotal_tax'];
										$cart_cat_products_subtotal += $line_item_subtotal;
									}
								}
								/* Category Condition End */
							}
							$product_based_percentage_subtotal = $cart_products_subtotal + $cart_cat_products_subtotal;
						}

						if ( $product_specific_flag == 1 ) {
							$percentage_subtotal = $product_based_percentage_subtotal;
						} else {
							$products_based_qty  = $cart_based_qty;
							$percentage_subtotal = $cart_sub_total;
						}
					}

					if ( isset( $getFeeType ) && ! empty( $getFeeType ) && $getFeeType == 'percentage' ) {

						$percentage_fee = ( $percentage_subtotal * $getFeesCost ) / 100;

						if ( $getFeesPerQtyFlag == 'on' ) {
							if ( $getFeesPerQty == 'qty_cart_based' ) {
								$dpad_cost = $percentage_fee + ( ( $cart_based_qty - 1 ) * $extraProductCost );
							} else if ( $getFeesPerQty == 'qty_product_based' ) {
								$dpad_cost = $percentage_fee + ( ( $products_based_qty - 1 ) * $extraProductCost );
							}
						} else {
							$dpad_cost = $percentage_fee;
						}
					} else {
						$fixed_fee = $getFeesCost;
						if ( $getFeesPerQtyFlag == 'on' ) {
							if ( $getFeesPerQty == 'qty_cart_based' ) {
								$dpad_cost = $fixed_fee + ( ( $cart_based_qty - 1 ) * $extraProductCost );
							} else if ( $getFeesPerQty == 'qty_product_based' ) {
								$dpad_cost = $fixed_fee + ( ( $products_based_qty - 1 ) * $extraProductCost );
							}
						} else {
							$dpad_cost = $fixed_fee;
						}
					}
				} else {
					$dpad_cost = '';
				}

				if ( ! empty( $get_condition_array ) ) {
					$country_array    = array();
					$product_array    = array();
					$category_array   = array();
					$user_array       = array();
					$cart_total_array = array();
					$quantity_array   = array();


					foreach ( $get_condition_array as $key => $value ) {
						if ( array_search( 'country', $value ) ) {
							$country_array[ $key ] = $value;
						}
						if ( array_search( 'product', $value ) ) {
							$product_array[ $key ] = $value;
						}
						if ( array_search( 'category', $value ) ) {
							$category_array[ $key ] = $value;
						}
						if ( array_search( 'user', $value ) ) {
							$user_array[ $key ] = $value;
						}
						if ( array_search( 'cart_total', $value ) ) {
							$cart_total_array[ $key ] = $value;
						}
						if ( array_search( 'quantity', $value ) ) {
							$quantity_array[ $key ] = $value;
						}
					}

					//Check if is country exist
					if ( is_array( $country_array ) && isset( $country_array ) && ! empty( $country_array ) && ! empty( $cart_array ) ) {
						$selected_country                       = $woocommerce->customer->get_shipping_country();
						$is_passed['has_dpad_based_on_country'] = '';
						$passed_country                         = array();
						$notpassed_country                      = array();
						foreach ( $country_array as $country ) {
							if ( $country['product_dpad_conditions_is'] == 'is_equal_to' ) {
								if ( ! empty( $country['product_dpad_conditions_values'] ) ) {
									foreach ( $country['product_dpad_conditions_values'] as $country_id ) {
										$passed_country[] = $country_id;
										if ( $country_id == $selected_country ) {
											$is_passed['has_dpad_based_on_country'] = 'yes';
										}
									}
								}
							}
							if ( $country['product_dpad_conditions_is'] == 'not_in' ) {
								if ( ! empty( $country['product_dpad_conditions_values'] ) ) {
									foreach ( $country['product_dpad_conditions_values'] as $country_id ) {
										$notpassed_country[] = $country_id;
										if ( $country_id == 'all' || $country_id == $selected_country ) {
											$is_passed['has_dpad_based_on_country'] = 'no';
										}
									}
								}
							}
						}
						if ( empty( $is_passed['has_dpad_based_on_country'] ) && empty( $passed_country ) ) {
							$is_passed['has_dpad_based_on_country'] = 'yes';
						} elseif ( empty( $is_passed['has_dpad_based_on_country'] ) && ! empty( $passed_country ) ) {
							$is_passed['has_dpad_based_on_country'] = 'no';
						}
					}
					if ( is_array( $product_array ) && isset( $product_array ) && ! empty( $product_array ) && ! empty( $cart_array ) ) {

						$cart_products_array = array();
						$cart_product        = $this->dpad_array_column( $cart_array, 'product_id' );

						if ( isset( $cart_product ) && ! empty( $cart_product ) ) {
							foreach ( $cart_product as $key => $cart_product_id ) {
								if ( ! empty( $sitepress ) ) {
									$cart_products_array[] = apply_filters( 'wpml_object_id', $cart_product_id, 'product', true, $default_lang );
								} else {
									$cart_products_array[] = $cart_product_id;
								}
							}
						}

						$is_passed['has_dpad_based_on_product'] = '';
						$passed_product                         = array();
						$notpassed_product                      = array();
						foreach ( $product_array as $product ) {
							if ( $product['product_dpad_conditions_is'] == 'is_equal_to' ) {
								if ( ! empty( $product['product_dpad_conditions_values'] ) ) {
									foreach ( $product['product_dpad_conditions_values'] as $product_id ) {

										$passed_product[] = $product_id;
										if ( in_array( $product_id, $cart_products_array ) ) {
											$is_passed['has_dpad_based_on_product'] = 'yes';
										}
									}
								}
							}
							if ( $product['product_dpad_conditions_is'] == 'not_in' ) {
								if ( ! empty( $product['product_dpad_conditions_values'] ) ) {
									foreach ( $product['product_dpad_conditions_values'] as $product_id ) {
										$notpassed_product = $product_id;
										if ( in_array( $product_id, $cart_product ) ) {
											$is_passed['has_dpad_based_on_product'] = 'no';
										}
									}
								}
							}
						}
						if ( empty( $is_passed['has_dpad_based_on_product'] ) && empty( $passed_product ) ) {
							$is_passed['has_dpad_based_on_product'] = 'yes';
						} elseif ( empty( $is_passed['has_dpad_based_on_product'] ) && ! empty( $passed_product ) ) {
							$is_passed['has_dpad_based_on_product'] = 'no';
						}
					}

					//Check if is Category exist
					if ( is_array( $category_array ) && isset( $category_array ) && ! empty( $category_array ) && ! empty( $cart_array ) ) {
						$cart_product           = $this->dpad_array_column( $cart_array, 'product_id' );
						$cart_category_id_array = array();
						$cart_products_array    = array();

						if ( isset( $cart_product ) && ! empty( $cart_product ) ) {
							foreach ( $cart_product as $key => $cart_product_id ) {
								if ( ! empty( $sitepress ) ) {
									$cart_products_array[] = apply_filters( 'wpml_object_id', $cart_product_id, 'product', true, $default_lang );
								} else {
									$cart_products_array[] = $cart_product_id;
								}
							}
						}

						if ( ! empty( $cart_products_array ) ) {
							foreach ( $cart_products_array as $product ) {
								$cart_product_category = wp_get_post_terms( $product, 'product_cat', array( 'fields' => 'ids' ) );
								if ( isset( $cart_product_category ) && ! empty( $cart_product_category ) && is_array( $cart_product_category ) ) {
									$cart_category_id_array[] = $cart_product_category;
								}
							}
							$get_cat_all                             = array_unique( $this->wdpad_array_flatten( $cart_category_id_array ) );
							$is_passed['has_dpad_based_on_category'] = '';
							$passed_category                         = array();
							$notpassed_category                      = array();
							foreach ( $category_array as $category ) {
								if ( $category['product_dpad_conditions_is'] == 'is_equal_to' ) {
									if ( ! empty( $category['product_dpad_conditions_values'] ) ) {
										foreach ( $category['product_dpad_conditions_values'] as $category_id ) {
											$passed_category[] = $category_id;
											if ( in_array( $category_id, $get_cat_all ) ) {
												$is_passed['has_dpad_based_on_category'] = 'yes';
											}
										}
									}
								}
								if ( $category['product_dpad_conditions_is'] == 'not_in' ) {
									if ( ! empty( $category['product_dpad_conditions_values'] ) ) {
										foreach ( $category['product_dpad_conditions_values'] as $category_id ) {
											$notpassed_category[] = $category_id;
											if ( in_array( $category_id, $get_cat_all ) ) {
												$is_passed['has_dpad_based_on_category'] = 'no';
											}
										}
									}
								}
							}
							if ( empty( $is_passed['has_dpad_based_on_category'] ) && empty( $passed_category ) ) {
								$is_passed['has_dpad_based_on_category'] = 'yes';
							} elseif ( empty( $is_passed['has_dpad_based_on_category'] ) && ! empty( $passed_category ) ) {
								$is_passed['has_dpad_based_on_category'] = 'no';
							}
						}
					}
					//Check if is user exist
					if ( is_array( $user_array ) && isset( $user_array ) && ! empty( $user_array ) && ! empty( $cart_array ) ) {
						if ( ! is_user_logged_in() ) {
							return false;
						}
						$current_user_id = get_current_user_id();
						foreach ( $user_array as $user ) {
							if ( $user['product_dpad_conditions_is'] == 'is_equal_to' ) {
								if ( in_array( $current_user_id, $user['product_dpad_conditions_values'] ) ) {
									$is_passed['has_dpad_based_on_user'] = 'yes';
								}
							}
							if ( $user['product_dpad_conditions_is'] == 'not_in' ) {
								if ( in_array( $current_user_id, $user['product_dpad_conditions_values'] ) ) {
									$is_passed['has_dpad_based_on_user'] = 'no';
								} else {
									$is_passed['has_dpad_based_on_user'] = 'yes';
								}
							}
						}
					}
					//Check if is Cart Subtotal (Before Discount) exist
					if ( is_array( $cart_total_array ) && isset( $cart_total_array ) && ! empty( $cart_total_array ) && ! empty( $cart_array ) ) {
						$total = $woocommerce->cart->subtotal;
						if ( isset( $woocommerce_wpml ) && ! empty( $woocommerce_wpml->multi_currency ) ) {
							$new_total = $woocommerce_wpml->multi_currency->prices->unconvert_price_amount( $total );
						} else {
							$new_total = $total;
						}

						foreach ( $cart_total_array as $cart_total ) {
							if ( $cart_total['product_dpad_conditions_is'] == 'is_equal_to' ) {
								if ( ! empty( $cart_total['product_dpad_conditions_values'] ) ) {
									if ( $cart_total['product_dpad_conditions_values'] == $new_total ) {
										$is_passed['has_dpad_based_on_cart_total'] = 'yes';
									} else {
										$is_passed['has_dpad_based_on_cart_total'] = 'no';
										break;
									}
								}
							}
							if ( $cart_total['product_dpad_conditions_is'] == 'less_equal_to' ) {
								if ( ! empty( $cart_total['product_dpad_conditions_values'] ) ) {
									if ( $cart_total['product_dpad_conditions_values'] >= $new_total ) {
										$is_passed['has_dpad_based_on_cart_total'] = 'yes';
									} else {
										$is_passed['has_dpad_based_on_cart_total'] = 'no';
										break;
									}
								}
							}
							if ( $cart_total['product_dpad_conditions_is'] == 'less_then' ) {
								if ( ! empty( $cart_total['product_dpad_conditions_values'] ) ) {
									if ( $cart_total['product_dpad_conditions_values'] > $new_total ) {
										$is_passed['has_dpad_based_on_cart_total'] = 'yes';
									} else {
										$is_passed['has_dpad_based_on_cart_total'] = 'no';
										break;
									}
								}
							}
							if ( $cart_total['product_dpad_conditions_is'] == 'greater_equal_to' ) {
								if ( ! empty( $cart_total['product_dpad_conditions_values'] ) ) {
									if ( $cart_total['product_dpad_conditions_values'] <= $new_total ) {
										$is_passed['has_dpad_based_on_cart_total'] = 'yes';
									} else {
										$is_passed['has_dpad_based_on_cart_total'] = 'no';
										break;
									}
								}
							}
							if ( $cart_total['product_dpad_conditions_is'] == 'greater_then' ) {
								if ( ! empty( $cart_total['product_dpad_conditions_values'] ) ) {
									if ( $cart_total['product_dpad_conditions_values'] < $new_total ) {
										$is_passed['has_dpad_based_on_cart_total'] = 'yes';
									} else {
										$is_passed['has_dpad_based_on_cart_total'] = 'no';
										break;
									}
								}
							}
							if ( $cart_total['product_dpad_conditions_is'] == 'not_in' ) {
								if ( ! empty( $cart_total['product_dpad_conditions_values'] ) ) {
									if ( $new_total == $cart_total['product_dpad_conditions_values'] ) {
										$is_passed['has_dpad_based_on_cart_total'] = 'no';
										break;
									} else {
										$is_passed['has_dpad_based_on_cart_total'] = 'yes';
									}
								}
							}
						}
					}
					//Check if is quantity exist
					if ( is_array( $quantity_array ) && isset( $quantity_array ) && ! empty( $quantity_array ) && ! empty( $cart_array ) ) {
						$woo_cart_array = array();
						$woo_cart_array = WC()->cart->get_cart();
						$quantity_total = 0;

						foreach ( $woo_cart_array as $woo_cart_item_key => $woo_cart_item ) {
							$quantity_total += $woo_cart_item['quantity'];
						}
						foreach ( $quantity_array as $quantity ) {
							if ( $quantity['product_dpad_conditions_is'] == 'is_equal_to' ) {
								if ( ! empty( $quantity['product_dpad_conditions_values'] ) ) {
									if ( $quantity_total == $quantity['product_dpad_conditions_values'] ) {
										$is_passed['has_dpad_based_on_quantity'] = 'yes';
									} else {
										$is_passed['has_dpad_based_on_quantity'] = 'no';
										break;
									}
								}
							}
							if ( $quantity['product_dpad_conditions_is'] == 'less_equal_to' ) {
								if ( ! empty( $quantity['product_dpad_conditions_values'] ) ) {
									if ( $quantity['product_dpad_conditions_values'] >= $quantity_total ) {
										$is_passed['has_dpad_based_on_quantity'] = 'yes';
									} else {
										$is_passed['has_dpad_based_on_quantity'] = 'no';
										break;
									}
								}
							}
							if ( $quantity['product_dpad_conditions_is'] == 'less_then' ) {
								if ( ! empty( $quantity['product_dpad_conditions_values'] ) ) {
									if ( $quantity['product_dpad_conditions_values'] > $quantity_total ) {
										$is_passed['has_dpad_based_on_quantity'] = 'yes';
									} else {
										$is_passed['has_dpad_based_on_quantity'] = 'no';
										break;
									}
								}
							}
							if ( $quantity['product_dpad_conditions_is'] == 'greater_equal_to' ) {
								if ( ! empty( $quantity['product_dpad_conditions_values'] ) ) {
									if ( $quantity['product_dpad_conditions_values'] <= $quantity_total ) {
										$is_passed['has_dpad_based_on_quantity'] = 'yes';
									} else {
										$is_passed['has_dpad_based_on_quantity'] = 'no';
										break;
									}
								}
							}
							if ( $quantity['product_dpad_conditions_is'] == 'greater_then' ) {
								if ( ! empty( $quantity['product_dpad_conditions_values'] ) ) {
									if ( $quantity['product_dpad_conditions_values'] < $quantity_total ) {
										$is_passed['has_dpad_based_on_quantity'] = 'yes';
									} else {
										$is_passed['has_dpad_based_on_quantity'] = 'no';
										break;
									}
								}
							}
							if ( $quantity['product_dpad_conditions_is'] == 'not_in' ) {
								if ( ! empty( $quantity['product_dpad_conditions_values'] ) ) {
									if ( $quantity_total == $quantity['product_dpad_conditions_values'] ) {
										$is_passed['has_dpad_based_on_quantity'] = 'no';
										break;
									} else {
										$is_passed['has_dpad_based_on_quantity'] = 'yes';
									}
								}
							}
						}
					}
				}
				if ( isset( $is_passed ) && ! empty( $is_passed ) && is_array( $is_passed ) ) {
					if ( ! in_array( 'no', $is_passed ) ) {

						$texable      = ( isset( $getFeetaxable ) && ! empty( $getFeetaxable ) && $getFeetaxable == 'yes' ) ? true : false;
						$currentDate  = strtotime( date( 'd-m-Y' ) );
						$feeStartDate = isset( $getFeeStartDate ) && $getFeeStartDate != '' ? strtotime( $getFeeStartDate ) : '';
						$feeEndDate   = isset( $getFeeEndDate ) && $getFeeEndDate != '' ? strtotime( $getFeeEndDate ) : '';
						if ( ( $currentDate >= $feeStartDate || $feeStartDate == '' ) && ( $currentDate <= $feeEndDate || $feeEndDate == '' ) ) {
							$woocommerce->cart->add_fee( $title, ( - 1 * $dpad_cost ), $texable, '' );; //'Reduced rate',
						}
					}
				}
			}
		}
	}

	/**
	 * @since    1.0.0
	 *
	 * @param array  $input
	 * @param string $columnKey
	 * @param null   $indexKey
	 *
	 * @return array|bool
	 */
	public function dpad_array_column( array $input, $columnKey, $indexKey = null ) {
        $array = array();
        foreach ($input as $value) {
            if (!isset($value[$columnKey])) {
                wp_die(sprintf(esc_html_x('Key %d does not exist in array', esc_attr($columnKey), 'woo-dynamic-pricing-and-discount')));
                return false;
            }
            if (is_null($indexKey)) {
                $array[] = $value[$columnKey];
            } else {
                if (!isset($value[$indexKey])) {
                    wp_die(sprintf(esc_html_x('Key %d does not exist in array', esc_attr($indexKey), 'woo-dynamic-pricing-and-discount')));
                    return false;
                }
                if (!is_scalar($value[$indexKey])) {
                    wp_die(sprintf(esc_html_x('Key %d does not contain scalar value', esc_attr($indexKey), 'woo-dynamic-pricing-and-discount')));
                    return false;
                }
                $array[$value[$indexKey]] = $value[$columnKey];
            }
        }
        return $array;
	}

	/**
	 * @param $array
	 *
	 * @since    1.0.0
	 * @return array|bool
	 */
	public function wdpad_array_flatten( $array ) {
		if ( ! is_array( $array ) ) {
			return false;
		}
		$result = array();
		foreach ( $array as $key => $value ) {
			if ( is_array( $value ) ) {
				$result = array_merge( $result, $this->wdpad_array_flatten( $value ) );
			} else {
				$result[ $key ] = $value;
			}
		}

		return $result;
	}
}