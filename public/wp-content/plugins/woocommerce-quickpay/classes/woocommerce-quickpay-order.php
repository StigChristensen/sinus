<?php

/**
 * WC_QuickPay_Order class
 *
 * @class        WC_QuickPay_Order
 * @version        1.0.0
 * @package        Woocommerce_QuickPay/Classes
 * @category    Class
 * @author        PerfectSolution
 */
class WC_QuickPay_Order extends WC_Order
{
    /** */
    const META_PAYMENT_METHOD_CHANGE_COUNT = '_quickpay_payment_method_change_count';
    /** */
    const META_FAILED_PAYMENT_COUNT = '_quickpay_failed_payment_count';

    /**
     * get_order_id_from_callback function.
     *
     * Returns the order ID based on the ID retrieved from the QuickPay callback.
     *
     * @access static public
     * @param object - the callback data
     * @return int
     */
    public static function get_order_id_from_callback($callback_data)
    {
        // Check for the post ID reference on the response object.
        // This should be available on all new orders.
        if (!empty($callback_data->variables) && !empty($callback_data->variables->order_post_id)) {
            return $callback_data->variables->order_post_id;
        } else if (isset($_GET['order_post_id'])) {
            return trim($_GET['order_post_id']);
        }

        // Fallback
        preg_match('/\d{4,}$/', $callback_data->order_id, $order_number);
        $order_number = (int)end($order_number);

        return $order_number;
    }

    /**
     * get_subscription_id_from_callback function.
     *
     * Returns the subscription ID based on the ID retrieved from the QuickPay callback, if present.
     *
     * @access static public
     * @param object - the callback data
     * @return int
     */
    public static function get_subscription_id_from_callback($callback_data)
    {
        // Check for the post ID reference on the response object.
        // This should be available on all new orders.
        if (!empty($callback_data->variables) && !empty($callback_data->variables->subscription_post_id)) {
            return $callback_data->variables->subscription_post_id;
        } else if (isset($_GET['subscription_post_id'])) {
            return trim($_GET['subscription_post_id']);
        }

        return NULL;
    }

    /**
     * get_transaction_id function
     *
     * If the order has a transaction ID, we will return it. If no transaction ID is set we return FALSE.
     *
     * @access public
     * @return string
     */
    public function get_transaction_id()
    {
        $transaction_id = parent::get_transaction_id();
        if (empty($transaction_id)) {
            // Search for original transaction ID. The transaction might be temporarily removed by
            // subscriptions. Use this one instead (if available).
            $transaction_id = get_post_meta($this->id, '_transaction_id_original', TRUE);
            if (empty($transaction_id)) {
                // Check if the old legacy TRANSACTION ID meta value is available.
                $transaction_id = get_post_meta($this->id, 'TRANSACTION_ID', TRUE);
            }
        }
        return $transaction_id;
    }

    /**
     * Sets the order transaction id
     * @param $transaction_id
     */
    public function set_transaction_id($transaction_id)
    {
        update_post_meta($this->id, '_transaction_id', $transaction_id);
    }

    /**
     * get_payment_id function
     *
     * If the order has a payment ID, we will return it. If no ID is set we return FALSE.
     *
     * @access public
     * @return string
     */
    public function get_payment_id()
    {
        return get_post_meta($this->id, 'QUICKPAY_PAYMENT_ID', TRUE);
    }

    /**
     * set_payment_id function
     *
     * Set the payment ID on an order
     *
     * @access public
     * @return void
     */
    public function set_payment_id($payment_link)
    {
        update_post_meta($this->id, 'QUICKPAY_PAYMENT_ID', $payment_link);
    }

    /**
     * delete_payment_id function
     *
     * Delete the payment ID on an order
     *
     * @access public
     * @return void
     */
    public function delete_payment_id()
    {
        delete_post_meta($this->id, 'QUICKPAY_PAYMENT_ID');
    }

    /**
     * get_payment_link function
     *
     * If the order has a payment link, we will return it. If no link is set we return FALSE.
     *
     * @access public
     * @return string
     */
    public function get_payment_link()
    {
        return get_post_meta($this->id, 'QUICKPAY_PAYMENT_LINK', TRUE);
    }

    /**
     * set_payment_link function
     *
     * Set the payment link on an order
     *
     * @access public
     * @return void
     */
    public function set_payment_link($payment_link)
    {
        update_post_meta($this->id, 'QUICKPAY_PAYMENT_LINK', $payment_link);
    }

    /**
     * delete_payment_link function
     *
     * Delete the payment link on an order
     *
     * @access public
     * @return void
     */
    public function delete_payment_link()
    {
        delete_post_meta($this->id, 'QUICKPAY_PAYMENT_LINK');
    }

    /**
     * get_transaction_order_id function
     *
     * If the order has a transaction order reference, we will return it. If no transaction order reference is set we return FALSE.
     *
     * @access public
     * @return string
     */
    public function get_transaction_order_id()
    {
        return get_post_meta($this->id, 'TRANSACTION_ORDER_ID', TRUE);
    }

    /**
     * set_transaction_order_id function
     *
     * Set the transaction order ID on an order
     *
     * @access public
     * @return void
     */
    public function set_transaction_order_id($transaction_order_id)
    {
        update_post_meta($this->id, 'TRANSACTION_ORDER_ID', $transaction_order_id);
    }

    /**
     * add_transaction_fee function.
     *
     * Adds order transaction fee to the order before sending out the order confirmation
     *
     * @access public
     * @param int $total_amount_with_fee
     * @return boolean
     */

    public function add_transaction_fee($fee_amount)
    {
        if ($fee_amount > 0) {
            $amount = $fee_amount / 100;
            $fee = (object) array(
                'name' => __('Payment Fee', 'woo-quickpay'),
                'amount' => wc_format_decimal($amount),
                'taxable' => FALSE,
                'tax_class' => NULL,
                'tax_data' => array(),
                'tax' => 0
            );
            $this->add_fee($fee);
            $this->set_total( $this->get_total() + $amount );
            return TRUE;
        }
        return FALSE;
    }

    /**
     * subscription_is_renewal_failure function.
     *
     * Checks if the order is currently in a failed renewal
     *
     * @access public
     * @return boolean
     */
    public function subscription_is_renewal_failure()
    {
        $renewal_failure = FALSE;

        if (WC_QuickPay_Subscription::plugin_is_active()) {
            $renewal_failure = (WC_QuickPay_Subscription::is_renewal($this) AND $this->status == 'failed');
        }

        return $renewal_failure;
    }

    /**
     * note function.
     *
     * Adds a custom order note
     *
     * @access public
     * @return void
     */
    public function note($message)
    {
        if (isset($message)) {
            $this->add_order_note('QuickPay: ' . $message);
        }
    }

    /**
     * get_transaction_params function.
     *
     * Returns the necessary basic params to send to QuickPay when creating a payment
     *
     * @access public
     * @return void
     */
    public function get_transaction_params()
    {
        $is_subscription = $this->contains_subscription() || $this->is_request_to_change_payment();

        $params_subscription = array();

        if ($is_subscription) {
            $params_subscription = array(
                'description' => 'woocommerce-subscription'
            );
        }

        $params = array_merge(array(
            'order_id' => $this->get_order_number_for_api(),
            'basket' => $this->get_transaction_basket_params(),
            'shipping_address' => $this->get_transaction_shipping_params(),
            'invoice_address' => $this->get_transaction_invoice_params()
        ), $this->get_custom_variables());

        return array_merge($params, $params_subscription);
    }

    /**
     * Creates an array of order items formatted as "QuickPay transaction basket" format.
     *
     * @return array
     */
    public function get_transaction_basket_params()
    {
        // Contains order items in QuickPay basket format
        $basket = array();

        // Order items
        $items = $this->get_items();
        foreach( $items as $key => $item ) {
            // Get expanded meta data for the item
            $item_meta = $this->expand_item_meta( $item );
            // Get tax rate
            $_product = get_product( $item['variation_id'] ? $item['variation_id'] : $item['product_id'] );
            // Get tax rates
            $taxes = WC_Tax::get_rates( $_product->get_tax_class() );
            //Get rates of the product
            $rates = array_shift($taxes);
            //Take only the item rate and round it.
            $vat_rate = round(array_shift($rates));
            // Fetch the product data
            $product = wc_get_product($item['product_id']);

            /**
                basket[][qty]	        Quantity	    form	integer		true
                basket[][item_no]	    Item reference  number	form	    string		true
                basket[][item_name]	    Item name	    form	string		true
                basket[][item_price]	Per item price (incl. VAT)	form	integer		true
                basket[][vat_rate]	    VAT rate
             */
            $basket_item = array(
                'qty' => $item_meta['qty'],
                'item_no' => $item_meta['product_id'], //
                'item_name' => esc_attr($item_meta['name']),
                'item_price' =>  WC_QuickPay_Helper::price_multiply( $product->get_price_including_tax() ),
                'vat_rate' => $vat_rate / 100 // Basket item VAT rate (ex. 0.25 for 25%)
            );

            $basket[] = $basket_item;
        }
        
        return apply_filters( 'woocommerce_quickpay_transaction_params_basket', $basket );
    }

    public function get_transaction_invoice_params() {
        $params = array(
            'name' => $this->billing_first_name . ' ' . $this->billing_last_name,
            'street' => $this->billing_address_1,
            'city' => $this->billing_city,
            'region' => $this->billing_state,
            'zip_code' => $this->billing_postcode,
            'country_code' => WC_QuickPay_Countries::getAlpha3FromAlpha2($this->billing_country),
            'phone_number' => $this->billing_phone,
            'email' => $this->billing_email,
        );

        return apply_filters( 'woocommerce_quickpay_transaction_params_invoice', $params );
    }

    public function get_transaction_shipping_params() {
        $params = array(
            'name' => $this->shipping_first_name . ' ' . $this->shipping_last_name,
            'street' => $this->shipping_address_1,
            'city' => $this->shipping_city,
            'region' => $this->shipping_state,
            'zip_code' => $this->shipping_postcode,
            'country_code' => WC_QuickPay_Countries::getAlpha3FromAlpha2($this->shipping_country),
            'phone_number' => WC_QuickPay_Helper::value($this->shipping_phone, $this->billing_phone),
            'email' => WC_QuickPay_Helper::value($this->shipping_email, $this->billing_email),
        );

        return apply_filters( 'woocommerce_quickpay_transaction_params_shipping', $params );
    }

    /**
     * contains_subscription function
     *
     * Checks if an order contains a subscription product
     *
     * @access public
     * @return boolean
     */
    public function contains_subscription()
    {
        $has_subscription = FALSE;

        if (WC_QuickPay_Subscription::plugin_is_active()) {
            $has_subscription = wcs_order_contains_subscription($this);
        }

        return $has_subscription;
    }

    /**
     * is_request_to_change_payment
     *
     * Check if the current request is trying to change the payment gateway
     * @return bool
     */
    public function is_request_to_change_payment()
    {
        if (WC_QuickPay_Subscription::plugin_is_active()) {
            return WC_Subscriptions_Change_Payment_Gateway::$is_request_to_change_payment;
        }
        return FALSE;
    }

    /**
     * get_order_number_for_api function.
     *
     * Prefix the order number if necessary. This is done
     * because QuickPay requires the order number to contain at least
     * 4 chars.
     *
     * @access public
     * @return string
     */
    public function get_order_number_for_api($recurring = FALSE)
    {
        $minimum_length = 4;

        // When changing payment method on subscriptions
        if (WC_QuickPay_Subscription::is_subscription($this->id)) {
            $order_number = $this->id;
        }
        // On initial subscription authorizations
        else if ($this->contains_subscription() && !$recurring) {
            // Find all subscriptions
            $subscriptions = WC_QuickPay_Subscription::get_subscriptions_for_order($this->id);
            // Get the last one and base the transaction on it.
            $subscription = end($subscriptions);
            // Fetch the ID of the subscription, not the parent order.
            $order_number = $subscription->id;

            // If an initial payment on a subscription failed (recurring payment), create a new subscription with appended ID.
            if ($this->get_failed_quickpay_payment_count() > 0) {
                $order_number .= sprintf( '-%d', $this->get_failed_quickpay_payment_count() );
            }
        }
        // On recurring / payment attempts
        else {
            // Normal orders - get the order number
            $order_number = $this->get_clean_order_number();
            // If an initial payment on a subscription failed (recurring payment), create a new subscription with appended ID.
            if ($this->get_failed_quickpay_payment_count() > 0) {
                $order_number .= sprintf( '-%d', $this->get_failed_quickpay_payment_count() );
            }
            // If manual payment of renewal, append the order number to avoid duplicate order numbers.
            else if (WC_QuickPay_Subscription::cart_contains_failed_renewal_order_payment()) {
                // Get the last one and base the transaction on it.
                $subscription = WC_QuickPay_Subscription::get_subscriptions_for_renewal_order($this->id, TRUE);
                $order_number .= sprintf( '-%d', $subscription->get_failed_payment_count() );
            }
            // FIXME: This is for backwards compatability only. Before 4.5.6 orders were not set to 'FAILED' when a recurring payment failed.
            // FIXME: To allow customers to pay the outstanding, we must append a value to the order number to avoid errors with duplicate order numbers in the API.
            else if(WC_QuickPay_Subscription::cart_contains_renewal()) {
                $order_number .= sprintf('-%d', time());
            }
        }

        if ($this->is_request_to_change_payment()) {
            $order_number .= sprintf('-%d', $this->get_payment_method_change_count() );
        }

        $order_number_length = strlen($order_number);

        if ($order_number_length < $minimum_length) {
            preg_match('/\d+/', $order_number, $digits);

            if (!empty($digits)) {
                $missing_digits = $minimum_length - $order_number_length;
                $order_number = str_replace($digits[0], str_pad($digits[0], strlen($digits[0]) + $missing_digits, 0, STR_PAD_LEFT), $order_number);
            }
        }
        return $order_number;
    }

    /**
     * Increase the amount of payment attemtps done through QuickPay
     * @return int
     */
    public function get_failed_quickpay_payment_count() {
        $count = get_post_meta( $this->id, self::META_FAILED_PAYMENT_COUNT, TRUE );
        if (empty($count)) {
            $count = 0;
        }
        return $count;
    }

    /**
     * Increase the amount of payment attemtps done through QuickPay
     * @return int
     */
    public function increase_failed_quickpay_payment_count() {
        $count = $this->get_failed_quickpay_payment_count();
        update_post_meta( $this->id, self::META_FAILED_PAYMENT_COUNT, ++$count );
        return $count;
    }

    /**
     * Reset the failed payment attempts made through the QuickPay gateway
     */
    public function reset_failed_quickpay_payment_count() {
        delete_post_meta( $this->id, self::META_FAILED_PAYMENT_COUNT );
    }

    /**
     * get_clean_order_number function
     *
     * Returns the order number without leading #
     *
     * @access public
     * @return integer
     */
    public function get_clean_order_number()
    {
        return str_replace('#', '', $this->get_order_number());
    }

    /**
     * get_custom_variables function.
     *
     * Returns custom variables chosen in the gateway settings. This information will
     * be sent to QuickPay and stored with the transaction.
     *
     * @access public
     * @return void
     */
    public function get_custom_variables()
    {
        $custom_vars_settings = (array)WC_QP()->s('quickpay_custom_variables');
        $custom_vars = array();

        // Single: Order Email
        if (in_array('customer_email', $custom_vars_settings)) {
            $custom_vars[__('Customer Email', 'woo-quickpay')] = $this->billing_email;
        }

        // Single: Order Phone
        if (in_array('customer_phone', $custom_vars_settings)) {
            $custom_vars[__('Customer Phone', 'woo-quickpay')] = $this->billing_phone;
        }

        // Single: Browser User Agent
        if (in_array('browser_useragent', $custom_vars_settings)) {
            $custom_vars[__('User Agent', 'woo-quickpay')] = $this->customer_user_agent;
        }

        // Single: Shipping Method
        if (in_array('shipping_method', $custom_vars_settings)) {
            $custom_vars[__('Shipping Method', 'woo-quickpay')] = $this->get_shipping_method();
        }

        // Save a POST ID reference on the transaction
        $custom_vars['order_post_id'] = $this->id;

        // Get the correct order_post_id. We want to fetch the ID of the subscription to store data on subscription (if available).
        // But only on the first attempt. In case of failed auto capture on the initial order, we dont want to add the subscription ID.
        $subscription_id = WC_QuickPay_Subscription::get_subscription_id($this);
        if ($subscription_id) {
            $custom_vars['subscription_post_id'] = $subscription_id;
        }

        if ($this->is_request_to_change_payment()) {
            $custom_vars['change_payment'] = TRUE;
        }

        ksort($custom_vars);

        return array('variables' => $custom_vars);
    }

    /**
     * get_transaction_link_params function.
     *
     * Returns the necessary basic params to send to QuickPay when creating a payment link
     *
     * @access public
     * @return void
     */
    public function get_transaction_link_params()
    {
        $is_subscription = $this->contains_subscription($this) || $this->is_request_to_change_payment();
        $amount = $this->get_total();

        if ($is_subscription) {
            $amount = $this->get_total();
        }

        return array(
            'order_id' => $this->get_order_number_for_api(),
            'continueurl' => $this->get_continue_url(),
            'cancelurl' => $this->get_cancellation_url(),
            'amount' => WC_QuickPay_Helper::price_multiply($amount),
        );
    }


    /**
     * get_continue_url function
     *
     * Returns the order's continue callback url
     *
     * @access public
     * @return string
     */
    public function get_continue_url()
    {
        if (method_exists($this, 'get_checkout_order_received_url')) {
            return $this->get_checkout_order_received_url();
        }

        return add_query_arg('key', $this->order_key, add_query_arg(
                'order', $this->id,
                get_permalink(get_option('woocommerce_thanks_page_id'))
            )
        );
    }

    /**
     * get_cancellation_url function
     *
     * Returns the order's cancellation callback url
     *
     * @access public
     * @return string
     */
    public function get_cancellation_url()
    {
        if (method_exists($this, 'get_cancel_order_url')) {
            return str_replace('&amp;', '&', $this->get_cancel_order_url());
        }

        return add_query_arg('key', $this->order_key, add_query_arg(
                array(
                    'order' => $this->id,
                    'payment_cancellation' => 'yes'
                ),
                get_permalink(get_option('woocommerce_cart_page_id')))
        );
    }

    /**
     * Determine if we should enable autocapture on the order. This is based on both the
     * plugin configuration and the product types. If the order contains both virtual
     * and non-virtual products,  we will default to the 'quickpay_autocapture'-setting.
     */
    public function get_autocapture_setting()
    {
        // Get the autocapture settings
        $autocapture_default = WC_QP()->s('quickpay_autocapture');
        $autocapture_virtual = WC_QP()->s('quickpay_autocapture_virtual');

        $has_virtual_products = FALSE;
        $has_nonvirtual_products = FALSE;

        // If the two options are the same, return immediately.
        if ($autocapture_default === $autocapture_virtual) {
            return $autocapture_default;
        }

        // Check order items type.
        $order_items = $this->get_items('line_item');

        // Loop through the order items
        foreach ($order_items as $order_item) {
            // Get the product
            $product = $this->get_product_from_item($order_item);

            // Is this product virtual?
            if ($product->is_virtual()) {
                $has_virtual_products = TRUE;
            } // This was a non-virtual product.
            else {
                $has_nonvirtual_products = TRUE;
            }
        }

        // If the order contains both virtual and nonvirtual products,
        // we use the 'quickpay_autopay' as the option of choice.
        if ($has_virtual_products AND $has_nonvirtual_products) {
            return $autocapture_default;
        } // Or check if the order contains virtual products only
        else if ($has_virtual_products) {
            return $autocapture_virtual;
        } // Or default
        else {
            return $autocapture_default;
        }
    }

    /**
     * has_quickpay_payment function
     *
     * Checks if the order is paid with the QuickPay module.
     *
     * @since  4.5.0
     * @access public
     * @return bool
     */
    public function has_quickpay_payment()
    {
        return in_array(get_post_meta($this->post->ID, '_payment_method', TRUE), array('quickpay', 'mobilepay', 'viabill', 'sofort', 'swipp', 'klarna'));
    }

    /**
     * Gets the amount of times the customer has updated his card.
     *
     * @return int
     */
    public function get_payment_method_change_count() {
        $count = get_post_meta( $this->id, self::META_PAYMENT_METHOD_CHANGE_COUNT, TRUE );

        if( !empty( $count ) ) {
            return $count;
        }

        return 0;
    }

    /**
     * Increases the amount of times the customer has updated his card.
     *
     * @return int
     */
    public function increase_payment_method_change_count() {
        $count = $this->get_payment_method_change_count();

        update_post_meta( $this->id, self::META_PAYMENT_METHOD_CHANGE_COUNT, ++$count );

        return $count;
    }
}