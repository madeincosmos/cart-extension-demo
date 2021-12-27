<?php
/**
 * Plugin Name: Cart Extension Demo
 */

defined( 'ABSPATH' ) || exit();

require_once __DIR__ . '/includes/class-integrate-wc-cart-block.php';
Integrate_WC_Cart_Block::load();

/**
 * Register the JS.
 */
function add_extension_register_script() {
	
	$script_path       = '/build/index.js';
	$script_asset_path = dirname( __FILE__ ) . '/build/index.asset.php';
	$script_asset      = file_exists( $script_asset_path )
		? require( $script_asset_path )
		: array( 'dependencies' => array(), 'version' => filemtime( $script_path ) );
	$script_url = plugins_url( $script_path, __FILE__ );

	wp_register_script(
		'cart-extension-demo',
		$script_url,
		$script_asset['dependencies'],
		$script_asset['version'],
		true
	);

	wp_register_style(
		'cart-extension-demo',
		plugins_url( '/build/index.css', __FILE__ ),
		// Add any dependencies styles may have, such as wp-components.
		array(),
		dirname( __FILE__ ) . '/build/index.css'
	);

	wp_enqueue_script( 'cart-extension-demo' );
	wp_enqueue_style( 'cart-extension-demo' );
	/*
	register_block_type(
		'wccom/discounted-renewal-notice',
		array(
			'editor_script'   => 'cart-extension-demo',
			'editor_style'    => 'cart-extension-demo',
			'style'           => 'cart-extension-demo',
		)
	);*/
}

add_action( 'wp_enqueue_scripts', 'add_extension_register_script' );

/**
 * @TODO either figure out how to properly include the discounted renewal notice block or remove this part completely.
 */
add_action( '__experimental_woocommerce_blocks_add_data_attributes_to_block', 'register_custom_woocommerce_cart_blocks' );

// Copied from WooCommerce Blocks. This action makes the Cart block's attributes available to this block.
function register_custom_woocommerce_cart_blocks( $whitelisted_blocks ) {
	$whitelisted_blocks[] = 'wccom/discounted-renewal-notice';
	return $whitelisted_blocks;
}