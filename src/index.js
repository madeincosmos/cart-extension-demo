import { __experimentalRegisterCheckoutFilters } from '@woocommerce/blocks-checkout';

const appendTextToPriceInCart = ( value, extensions, args ) => {
	if ( 'cart' !== args?.context ) {
		// Return early since this filter is not being applied in the Cart context.
		// We must return the original value we received here.
		return value;
	}

	if ( extensions.wccom && extensions.wccom.priceSuffix ) {
		return '<price/> ' + extensions.wccom.priceSuffix;
	}

	return value;
};

__experimentalRegisterCheckoutFilters( 'wccom-cart-price-suffix', {
	subtotalPriceFormat: appendTextToPriceInCart,
} );