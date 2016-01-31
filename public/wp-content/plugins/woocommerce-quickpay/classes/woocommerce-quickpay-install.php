<?php
/**
 * WC_QuickPay_Install class
 *
 * @class 		WC_QuickPay_Install
 * @version		1.0.0
 * @package		Woocommerce_QuickPay/Classes
 * @category	Class
 * @author 		PerfectSolution
 */
class WC_QuickPay_Install 
{
	/**
	 * Contains version numbers and the path to the update files.
	 */
	private static $updates = array(
		'4.3' => 'updates/woocommerce-quickpay-update-4.3.php'	
	);
	
	
	/**
	 * Updates the version. 
	 * 
	 * @param string $version = NULL - The version number to update to
	 */
	private static function update_db_version( $version = NULL )
	{
		delete_option( 'woocommerce_quickpay_version' );
		add_option( 'woocommerce_quickpay_version', $version === NULL ? WCQP_VERSION : $version );
	}
	
	
	/**
	 * Get the current DB version stored in the database.
	 * 
	 * @return string - the stored version number.
	 */
	public static function get_db_version() 
	{
		return get_option( 'woocommerce_quickpay_version', TRUE );	
	}
	
	
	/**
	 * Checks if this is the first install.
	 * 
	 * @return bool
	 */
	public static function is_first_install() 
	{
		$settings = get_option( 'woocommerce_quickpay_settings', FALSE );	
		return $settings === FALSE;
	}
	
	
	/**
	 * Runs on first install
	 */
	public static function install()
	{
		// Install...
	}
	
	
	/**
	 * Loops through the updates and executes them.
	 */
	public static function update() 
	{
		$current_db_version = self::get_db_version();

		foreach ( self::$updates as $version => $updater ) {
			if ( version_compare( $current_db_version, $version, '<' ) ) {
				include( $updater );
				self::update_db_version( $version );
			}
		}
		
		self::update_db_version( WCQP_VERSION );
	}
}