<?php
/**
 * WC_QuickPay_Subscription class
 *
 * @class 		WC_QuickPay_Subscription
 * @version		1.0.0
 * @package		Woocommerce_QuickPay/Classes
 * @category	Class
 * @author 		PerfectSolution
 */

class WC_QuickPay_Subscription {
	/**
	 * Gets a parent order of a subscription
	 * @param  [type] $order [description]
	 * @return [type]        [description]
	 */
	public static function get_parent_order( $order ) {
		return wcs_get_subscriptions_for_renewal_order( $order );
	}

	/**
	 * Returns the transaction ID of the parent subscription.
	 * This ID is used to make all future renewal orders.
	 * @param  [type] $order [description]
	 * @return [type]        [description]
	 */
	public static function get_initial_subscription_transaction_id( $order ) {
		// Lets check if the current order IS the parent order. If so, return the subscription ID from current order.
		$is_subscription = wcs_is_subscription( $order->id );
		if( $is_subscription ) {
			$original_order = new WC_QuickPay_Order( $order->post->post_parent );
			return $original_order->get_transaction_id();
		} 
		else if( self::is_renewal( $order ) ) {
			$subscriptions = self::get_parent_order( $order );
			$subscription = end( $subscriptions );
			$original_order = new WC_QuickPay_Order( $subscription->post->post_parent );
			return $original_order->get_transaction_id();
		}

		// Nothing found
		return NULL;
	}

   /**
    * process_recurring_response function.
    *
    * Process a recurring response
    *
    * @access public static
    * @param  object $recurring_response
    * @param  object $order
    * @return void
    */
    public static function process_recurring_response( $recurring_response, $order )
    {
        // Process payment on subscription
        WC_Subscriptions_Manager::process_subscription_payments_on_order( $order->id );

        // Complete payment
        $order->payment_complete( $recurring_response->id );
    }

	/**
	 * Checks if a subscription is up for renewal.
	 * Ensures backwards compatability.
	 *
	 * @access public static
	 * @param  [WC_QuickPay_Order] $order [description]
	 * @return boolean
	 */
	public static function is_renewal( $order ) {
		return wcs_order_contains_renewal( $order );
	}
	/**
	* Checks if Woocommerce Subscriptions is enabled or not
	*
	* @access public static
	* @return string
	*/
	public static function plugin_is_active() {
		return class_exists( 'WC_Subscriptions' ) && WC_Subscriptions::$name = 'subscription';
	}
}