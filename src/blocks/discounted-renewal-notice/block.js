/**
 * External dependencies
 */
import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps } from '@wordpress/block-editor';

const Edit = () => {
	return (
		<div { ...useBlockProps() } >
            <div className="wccom-cart-discounted-renewal-notice">
                <span className="wccom-cart-discounted-renewal-notice__content">
                    { __(
                        'After one year, discounted products will renew at full price.',
                        'wccom',
                    ) }
                </span>
            </div>
        </div>
    );
};

const Save = () => {
	return <div { ...useBlockProps.save() } />;
};

registerBlockType(
    'wccom/discounted-renewal-notice',
    {
        title: __( 'Cart renewal notice', 'wccom' ),
        parent: [ 'woocommerce/cart-items-block' ],
        icon: 'info-outline',
        edit: Edit,
        save: Save,
    },
);
