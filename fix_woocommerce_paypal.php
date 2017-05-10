<?php
/*
Plugin Name: Fix problem payment on Woocommerce
Plugin URI: https://tshirtecommerce.com/
Description: This plugin fix problem of payment with paypal on Woocommerce
Author: dangcv
Version: 1.0
Author URI: https://tshirtecommerce.com/
*/

add_filter( 'woocommerce_paypal_args', 'fix_woocommerce_paypal', 10, 2);
function fix_woocommerce_paypal($args, $order)
{
	$cancel_wp_id = base64_encode($order->get_cancel_order_url_raw());
	
	$cancel_return = add_query_arg( array('cancel_wp_id'=>$cancel_wp_id), site_url() );
	
	$args['cancel_return'] = esc_url_raw($cancel_return);
    return $args;
}

add_action( 'init', 'get_cancel_woocommerce_paypal' );
function get_cancel_woocommerce_paypal()
{
	if( isset($_GET['cancel_wp_id']) )
	{
		$cancel_wp_id = $_GET['cancel_wp_id'];
		$url = base64_decode($cancel_wp_id);
		if( strpos($url, site_url()) !== false)
		{
			wp_redirect(base64_decode($cancel_wp_id));
			exit;
		}
	}
}

?>
