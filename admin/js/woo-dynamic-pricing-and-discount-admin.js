(function ($) {
    $(window).load(function () {
        $('a[href="admin.php?page=wdpad-pro-list"]').parent().addClass('current');
        $('a[href="admin.php?page=wdpad-pro-list"]').addClass('current');

        jQuery(".multiselect2").chosen();
        $("#dpad_settings_start_date").datepicker({
            dateFormat: 'dd-mm-yy',
            minDate: '0',
            onSelect: function (selected) {
                var dt = $(this).datepicker('getDate');
                dt.setDate(dt.getDate() + 1);
                $("#dpad_settings_end_date").datepicker("option", "minDate", dt);
            }
        });
        $("#dpad_settings_end_date").datepicker({
            dateFormat: 'dd-mm-yy',
            minDate: '0',
            onSelect: function (selected) {
                var dt = $(this).datepicker('getDate');
                dt.setDate(dt.getDate() - 1);
                $("#dpad_settings_start_date").datepicker("option", "maxDate", dt);
            }
        });
        var ele = $('#total_row').val();
        if (ele > 2) {
            var count = ele;
        } else {
            var count = 2;
        }
        $('body').on('click', '#fee-add-field', function () {
            var tds = '<tr id=row_' + count + '>';
            tds += '<td><select rel-id=' + count + ' id=product_dpad_conditions_condition_' + count + ' name="dpad[product_dpad_conditions_condition][]" class="product_dpad_conditions_condition"><optgroup label="Location Specific"><option value="country">Country</option><option value="state" disabled>State (Available in Pro Version)</option><option value="postcode" disabled>Postcode (Available in Pro Version)</option><option value="zone" disabled>Zone (Available in Pro Version)</option></optgroup><optgroup label="Product Specific"><option value="product">Product</option><option value="variableproduct" disabled>Variable Product (Available in Pro Version)</option><option value="category">Category</option><option value="tag" disabled>Tag (Available in Pro Version)</option></optgroup><optgroup label="User Specific"><option value="user">User</option><option value="user_role" disabled>User Role (Available in Pro Version)</option></optgroup><optgroup label="Cart Specific"><option value="cart_total">Cart Subtotal</option><option value="quantity">Quantity</option><option value="weight" disabled>Weight (Available in Pro Version)</option><option value="coupon" disabled>Coupon (Available in Pro Version)</option><option value="shipping_class" disabled>Shipping Class (Available in Pro Version)</option></optgroup><optgroup label="Payment Specific"><option value="payment" disabled>Payment Gateway (Available in Pro Version)</option></optgroup><optgroup label="Shipping Specific"><option value="shipping_method" disabled>Shipping Method (Available in Pro Version)</option></optgroup></select></td>';
            tds += '<td><select name="dpad[product_dpad_conditions_is][]" class="product_dpad_conditions_is product_dpad_conditions_is_' + count + '"><option value="is_equal_to">Equal to ( = )</option><option value="not_in">Not Equal to ( != )</option></select></td>';
            tds += '<td id=column_' + count + '><select name="dpad[product_dpad_conditions_values][value_' + count + '][]" class="product_dpad_conditions_values product_dpad_conditions_values_' + count + ' multiselect2" multiple="multiple"></select><input type="hidden" name="condition_key[value_' + count + '][]" value=""></td>';
            tds += '<td><a id="fee-delete-field" rel-id="' + count + '" title="Delete" class="delete-row" href="javascript:;"><i class="fa fa-trash"></i></a></td>';
            tds += '</tr>';
            $('#tbl-product-fee').append(tds);
            jQuery(".product_dpad_conditions_values_" + count).append(jQuery(".default-country-box select").html());
            jQuery(".product_dpad_conditions_values_" + count).trigger("chosen:updated");
            jQuery(".multiselect2").chosen();
            count++;
        });
        $('body').on('click', '#fee-delete-field', function () {
            var deleId = $(this).attr('rel-id');
            $("#row_" + deleId).remove();
        });
        $('body').on('change', '.product_dpad_conditions_condition', function () {
            var condition = $(this).val();
            var count = $(this).attr('rel-id');
            $('#column_' + count).html('<img src="' + coditional_vars.plugin_url + 'images/ajax-loader.gif">');

            $.ajax({
                type: 'GET',
                url: coditional_vars.ajaxurl,
                data: {
                    'action': 'wdpad_free_product_dpad_conditions_values_ajax',
                    'condition': condition,
                    'count': count
                },
                success: function(response) {
                    if (condition == 'cart_total' || condition == 'cart_totalafter' || condition == 'quantity' || condition == 'weight') {
                        jQuery('.product_dpad_conditions_is_' + count).html('');
                        jQuery('.product_dpad_conditions_is_' + count).append(jQuery(".text-condtion-is select.text-condition").html());
                        jQuery('.product_dpad_conditions_is_' + count).trigger("chosen:updated");
                    } else {
                        jQuery('.product_dpad_conditions_is_' + count).html('');
                        jQuery('.product_dpad_conditions_is_' + count).append(jQuery(".text-condtion-is select.select-condition").html());
                        jQuery('.product_dpad_conditions_is_' + count).trigger("chosen:updated");
                    }
                    $('#column_' + count).html('');
                    $('#column_' + count).append(response);
                    $('#column_' + count).append('<input type="hidden" name="condition_key[value_' + count + '][]" value="">');
                    jQuery(".multiselect2").chosen();
                    if (condition == 'product') {
                        $('#product_filter_chosen input').val('Please enter 3 or more characters');
                    }
                    if (condition == 'cart_total' || condition == 'cart_totalafter' || condition == 'quantity' || condition == 'weight') {
                        $( "#column_"+count+" input[type='text']" ).keypress( function( e ) {
                            //if the letter is not digit then display error and don't type anything
                            if ( e.which != 46 && e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) ) {
                                //display error message
                                return false;
                            }
                        } );
                    }
                }
            });
        });
        $('body').on('keyup', '#product_filter_chosen input', function () {
            countId = $(this).closest("td").attr('id');
            $('#product_filter_chosen ul li.no-results').html('Please enter 3 or more characters');
            var post_per_page = 3; // Post per page
            var page = 0; // What page we are on.
            var value = $(this).val();
            var valueLenght = value.replace(/\s+/g, '');
            var valueCount = valueLenght.length;
            var remainCount = 3 - valueCount;
            var selproductvalue = $('#' + countId + ' #product-filter').chosen().val();
            if (valueCount >= 3) {
                $('#product_filter_chosen ul li.no-results').html('<img src="' + coditional_vars.plugin_url + 'images/ajax-loader.gif">');

                $.ajax({
                    type: 'GET',
                    url: coditional_vars.ajaxurl,
                    data: {
                        'action': 'wdpad_free_product_dpad_conditions_values_product_ajax',
                        'value': value,
                        'post_per_page': post_per_page,
                        'offset': (page * post_per_page),
                    },
                    success: function(response) {
                        page++;
                        if (response.length != 0) {
                            $('#' + countId + ' #product-filter').append(response);
                        } else {
                            $('#product-filter option').not(':selected').remove();
                        }
                        $('#' + countId + ' #product-filter option').each(function () {
                            $(this).siblings("[value='" + this.value + "']").remove();
                        });
                        jQuery('#' + countId + ' #product-filter').trigger("chosen:updated");
                        $('#product_filter_chosen .search-field input').val(value);
                        $('#' + countId + ' #product-filter').chosen().change(function () {
                            var productVal = $('#' + countId + ' #product-filter').chosen().val();
                            jQuery('#' + countId + ' #product-filter option').each(function () {
                                $(this).siblings("[value='" + this.value + "']").remove();
                                if (jQuery.inArray(this.value, productVal) == -1) {
                                    jQuery(this).remove();
                                }
                            });
                            jQuery('#' + countId + ' #product-filter').trigger("chosen:updated");
                        });
                        $('#product_filter_chosen ul li.no-results').html('');
                    }
                });
            } else {
                if (remainCount > 0) {
                    $('#product_filter_chosen ul li.no-results').html('Please enter ' + remainCount + ' or more characters');
                }
            }
        });
        $('body').on('keyup', '#var_product_filter_chosen input', function () {
            countId = $(this).closest("td").attr('id');
            $('#var_product_filter_chosen ul li.no-results').html('Please enter 3 or more characters');
            var value = $(this).val();
            var valueLenght = value.replace(/\s+/g, '');
            var valueCount = valueLenght.length;
            var remainCount = 3 - valueCount;
            var selproductvalue = $('#' + countId + ' #var-product-filter').chosen().val();
            if (valueCount >= 3) {
                $('#var_product_filter_chosen ul li.no-results').html('<img src="' + coditional_vars.plugin_url + 'images/ajax-loader.gif">');
                $.ajax({
                    type: 'GET',
                    url: coditional_vars.ajaxurl,
                    data: {
                        'action': 'wdpad_free_product_dpad_conditions_varible_values_product_ajax',
                        'value': value,
                    },
                    success: function(response) {
                        if (response.length != 0) {
                            $('#' + countId + ' #var-product-filter').append(response);
                        } else {
                            $('#var-product-filter option').not(':selected').remove();
                        }
                        $('#' + countId + ' #var-product-filter option').each(function () {
                            $(this).siblings("[value='" + this.value + "']").remove();
                        });
                        jQuery('#' + countId + ' #var-product-filter').trigger("chosen:updated");
                        $('#var_product_filter_chosen .search-field input').val(value);
                        $('#' + countId + ' #var-product-filter').chosen().change(function () {
                            var productVal = $('#' + countId + ' #var-product-filter').chosen().val();
                            jQuery('#' + countId + ' #var-product-filter option').each(function () {
                                $(this).siblings("[value='" + this.value + "']").remove();
                                if (jQuery.inArray(this.value, productVal) == -1) {
                                    jQuery(this).remove();
                                }
                            });
                            jQuery('#' + countId + ' #var-product-filter').trigger("chosen:updated");
                        });
                        $('#var_product_filter_chosen ul li.no-results').html('');
                    }
                });
            } else {
                if (remainCount > 0) {
                    $('#var_product_filter_chosen ul li.no-results').html('Please enter ' + remainCount + ' or more characters');
                }
            }
        });
        $(".condition-check-all").click(function () {
            $('input.multiple_delete_fee:checkbox').not(this).prop('checked', this.checked);
        });
        $('#detete-conditional-fee').click(function () {
            if ($('.multiple_delete_fee:checkbox:checked').length == 0) {
                alert('Please select at least one checkbox');
                return false;
            }
            if (confirm('Are You Sure You Want to Delete?')) {
                var allVals = [];
                $(".multiple_delete_fee:checked").each(function () {
                    allVals.push($(this).val());
                });
                $.ajax({
                    type: 'GET',
                    url: coditional_vars.ajaxurl,
                    data: {
                        'action': 'wdpad_free_wc_multiple_delete_conditional_fee',
                        'allVals': allVals
                    },
                    success: function(response) {
                        if (response == 1) {
                            alert('Delete Successfully');
                            $(".multiple_delete_fee").prop("checked", false);
                            location.reload();
                        }
                    }
                });
            }
        });
        /* description toggle */
        $('span.woocommerce_conditional_product_dpad_checkout_tab_descirtion').click(function (event) {
            event.preventDefault();
            var data = $(this);
            $(this).next('p.description').toggle();
            //$('span.advance_extra_flate_rate_disctiption_tab').next('p.description').toggle();
        });
    });
    jQuery(document).ready(function ($) {
        $(".tablesorter").tablesorter({
            headers: {
                0: {
                    sorter: false
                },
                4: {
                    sorter: false
                }
            }
        });
        var fixHelperModified = function (e, tr) {
            var $originals = tr.children();
            var $helper = tr.clone();
            $helper.children().each(function (index)
            {
                $(this).width($originals.eq(index).width())
            });
            return $helper;
        };
        //Make diagnosis table sortable
        $("table#conditional-fee-listing tbody").sortable({
            helper: fixHelperModified
        });
        $("table#conditional-fee-listing tbody").disableSelection();

        /* Apply per quantity conditions start */
        if ($("#dpad_chk_qty_price").is(':checked')) {
            $(".wdpad-main-table .product_cost_right_div .applyperqty-boxtwo").show();
            $(".wdpad-main-table .product_cost_right_div .applyperqty-boxthree").show();
            $("#extra_product_cost").prop('required', true);
        } else {
            $(".wdpad-main-table .product_cost_right_div .applyperqty-boxtwo").hide();
            $(".wdpad-main-table .product_cost_right_div .applyperqty-boxthree").hide();
            $("#extra_product_cost").prop('required', false);
        }
        $(document).on('change', '#dpad_chk_qty_price', function () {
            if (this.checked) {
                $(".wdpad-main-table .product_cost_right_div .applyperqty-boxtwo").show();
                $(".wdpad-main-table .product_cost_right_div .applyperqty-boxthree").show();
                $("#extra_product_cost").prop('required', true);
            } else {
                $(".wdpad-main-table .product_cost_right_div .applyperqty-boxtwo").hide();
                $(".wdpad-main-table .product_cost_right_div .applyperqty-boxthree").hide();
                $("#extra_product_cost").prop('required', false);
            }
        });
        /* Apply per quantity conditions end */
        /* check price is should not negative */
        $( "#dpad_settings_product_cost" ).keypress( function( e ) {
            //if the letter is not digit then display error and don't type anything
            if ( e.which != 46 && e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) ) {
              //display error message
              return false;
            }
        } );
        /* check price is should not negative over */
    });
})(jQuery);