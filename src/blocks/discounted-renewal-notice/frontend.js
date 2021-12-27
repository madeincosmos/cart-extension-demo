/**
 * External dependencies
 */
import { __ } from '@wordpress/i18n';
import { registerCheckoutBlock } from '@woocommerce/blocks-checkout';
 
const Block = ( { cart } ) => {
    const { cartCoupons, cartItems, cartNeedsShipping } = cart;
 
    const hasProductsOnSale = cartItems.some( function( item ) {
        return item.prices.regular_price !== item.prices.sale_price;
    } );
    const hasCoupons = 0 < cartCoupons.length ? true : false;
    const shouldRenderNotice = ! cartNeedsShipping && ( hasProductsOnSale || hasCoupons );
 
    return (
        <div className="wccom-cart-discounted-renewal-notice">
            { shouldRenderNotice &&
                <span className="wccom-cart-discounted-renewal-notice__content">
                    { __(
                        'After one year, discounted products will renew at full price.',
                        'wccom',
                    ) }
                </span>
            }
        </div>
    );
};
 
 const options = {
     metadata: {
         name: 'wccom/discounted-renewal-notice',
         parent: [ 'woocommerce/cart-items-block' ],
     },
     component: Block,
 };
 
 registerCheckoutBlock( options );
 