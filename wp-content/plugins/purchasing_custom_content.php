<?php
/**
 * Purchasing Custom Content for Vendors
 * @author Michael Denny
 * @version 0.1
 */
/*
Plugin Name: Purchasing Vendors
Plugin URI: http://www.wrdsb.ca
Description: Purchasing Vendors
Author: Michael Denny
Version: 0.1
Author URI: 
*/



add_action( 'init', 'create_post_type' );
function create_post_type() {
	register_post_type( 'purchasing_vendor',
		array(
			'labels' => array(
				'name' => __( 'Vendors' ),
				'singular_name' => __( 'Vendor' )
			),
		'public' => true,
		'has_archive' => true,
		)
	);
}



?>
