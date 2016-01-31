<?php

class WC_QuickPay_Paii extends WC_QuickPay_Instance {
    
    public $main_settings = NULL;
    
    public function __construct() {
        parent::__construct();
        
        // Get gateway variables
        $this->id = 'paii';
        
        $this->method_title = 'QuickPay - Paii';
        
        $this->setup();
        
        $this->title = $this->s('title');
        $this->description = $this->s('description');
        
        add_filter( 'woocommerce_quickpay_cardtypelock_paii', array( $this, 'filter_cardtypelock' ) );
		add_filter( 'woocommerce_quickpay_transaction_link_params', array( $this, 'filter_transaction_link_params' ), 10, 3 );
    }

    
    /**
    * init_form_fields function.
    *
    * Initiates the plugin settings form fields
    *
    * @access public
    * @return array
    */
    public function init_form_fields()
    {
        $this->form_fields = array(
            'enabled' => array(
                'title' => __( 'Enable/Disable', 'woo-quickpay' ), 
                'type' => 'checkbox', 
                'label' => __( 'Enable Paii payment', 'woo-quickpay' ), 
                'default' => 'no'
            ), 
            '_Shop_setup' => array(
                'type' => 'title',
                'title' => __( 'Shop setup', 'woo-quickpay' ),
            ),
                'title' => array(
                    'title' => __( 'Title', 'woo-quickpay' ), 
                    'type' => 'text', 
                    'description' => __( 'This controls the title which the user sees during checkout.', 'woo-quickpay' ), 
                    'default' => __('Paii', 'woo-quickpay')
                ),
                'description' => array(
                    'title' => __( 'Customer Message', 'woo-quickpay' ), 
                    'type' => 'textarea', 
                    'description' => __( 'This controls the description which the user sees during checkout.', 'woo-quickpay' ), 
                    'default' => __('Pay with your mobile phone', 'woo-quickpay')
                ),
                'paii_category' => array(
                    'title' => __( 'Category', 'woo-quickpay' ), 
                    'type' => 'text', 
                    'description' => sprintf( __( 'Example %s. Refer to QuickPay or Paii if you are not sure what to type in here.', 'woo-quickpay' ), 'SC08' ), 
                    'default' => ''
                ),
                'paii_product_id' => array(
                    'title' => __( 'Category', 'woo-quickpay' ), 
                    'type' => 'text', 
                    'description' => sprintf( __( 'Example %s. Refer to QuickPay or Paii if you are not sure what to type in here.', 'woo-quickpay' ), 'P03' ), 
                    'default' => __('', 'woo-quickpay')
                ),
                'paii_reference_title' => array(
                    'title' => __( 'Reference Title', 'woo-quickpay' ), 
                    'type' => 'text', 
                    'description' => __( 'We recommend to use the name of your webshop.', 'woo-quickpay' ), 
                    'default' => get_bloginfo( 'name' )
                ),
        );
    }
  
    
    /**
    * filter_cardtypelock function.
    *
    * Sets the cardtypelock
    *
    * @access public
    * @param  string - ID of the payment gateway chosen for order payment
    * @param  string - The cardtypelock from settings
    * @return string
    */
    public function filter_cardtypelock()
    {
        return 'paii';
    }
	
	
    /**
    * filter_transaction_link_params function.
    *
    * Sets gateway specific data used when creating payment links
    *
    * @access public
    * @param  array - Fields used for creating payment links
    * @param  string - The gateway ID
    * @return array
    */	
	public function filter_transaction_link_params( $fields, $order, $gateway )
	{
		if( $gateway === $this->id ) 
		{
			$fields['product_id'] = $this->s( 'paii_product_id' );
			$fields['category'] = $this->s( 'paii_category' );
			$fields['reference_title'] = $this->s( 'paii_reference_title' );
			$fields['vat_amount'] = WC_QuickPay_Helper::price_multiply( $order->get_total_tax() );
		}
		
		return $fields;
	}
}
