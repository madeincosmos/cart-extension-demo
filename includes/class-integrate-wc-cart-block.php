<?php

defined( 'ABSPATH' ) || exit();

use Automattic\WooCommerce\Blocks\Package;
use Automattic\WooCommerce\Blocks\Domain\Services\ExtendRestApi;
use Automattic\WooCommerce\Blocks\StoreApi\Schemas\CartItemSchema;

class Integrate_WC_Cart_Block {
	public static function load() {
		add_action( 'woocommerce_blocks_loaded', [ __CLASS__, 'extend_rest_api' ] );
	}

	public static function extend_rest_api() {
		// ExtendRestApi is stored in the container as a shared instance between the API and consumers.
		// You shouldn't initiate your own ExtendRestApi instance using `new ExtendRestApi` but should
		// always use the shared instance from the Package dependency injection container.
		$extend = Package::container()->get( ExtendRestApi::class );

		// More information about extending API here:
		// https://github.com/woocommerce/woocommerce-gutenberg-products-block/blob/trunk/docs/extensibility/extend-rest-api-add-data.md

		$extend->register_endpoint_data(
			array(
				'endpoint'        => CartItemSchema::IDENTIFIER,
				'namespace'       => 'wccom',
				'data_callback'   => [ __CLASS__, 'extend_cart_item_data' ],
				'schema_callback' => [ __CLASS__, 'extend_cart_item_schema' ],
				'schema_type'     => ARRAY_A,
			)
		);
	}

	public static function extend_cart_item_data( $cart_item = null ) {
		$product_id = $cart_item['product_id'];
		return [
			'priceSuffix' => self::get_billing_period( $product_id ),
		];
	}

	public static function extend_cart_item_schema() {
		return array(
			'priceSuffix' => [
				'description' => __( 'Price suffix', 'wccom' ),
				'type'        => 'string',
				'context'     => [ 'view', 'edit' ],
				'readonly'    => true,
			],
		);
	}

	public static function get_billing_period( $product_id ) {
		$product = wc_get_product( $product_id );
		if ( ! $product->is_virtual() ) {
			return '';
		}

		if ( $product->is_on_sale() ) {
			return __( 'first year*', 'wccom' );
		}
		return __( 'annually', 'wccom' );
	}
}