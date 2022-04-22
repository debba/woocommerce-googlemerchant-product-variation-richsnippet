<?php
/*
* Plugin Name: Woocommerce Product Variation Rich Snippet Fix for Google Merchant Center
* Plugin Uri: https://github.com/debba/woocommerce-googlemerchant-product-variation-richsnippet
* Description: Basic WooCommerce plugin that makes product variation rich snippets compliant with Google Merchant Center
* Author: Andrea Debernardi
* Author URI: https://www.dueclic.com
* Version: 1.0
* Tested up: 5.9.3
* WC requires at least: 5.0.0
* WC tested up to: 6.4.1
* License: GPL v3
*/

if ( ! defined( 'ABSPATH' ) ) {
    die;
}

/**
 * @param $markup
 * @param $product WC_Product
 *
 * @return mixed
 */

function merchant_richsnippet_data_product_variation_offer( $markup, $product ) {
    if ($product->get_type() == 'variable'){

        $data_store   = WC_Data_Store::load( 'product' );
        $variation_id = $data_store->find_matching_product_variation( $product, wp_unslash( $_GET ) );

        if ($variation_id !== 0){

            $price_valid_until = gmdate( 'Y-12-31', time() + YEAR_IN_SECONDS );
            $product_variation = new WC_Product_Variation($variation_id);
            $permalink = get_permalink( $product->get_id() );
            $shop_name = get_bloginfo( 'name' );
            $shop_url  = home_url();
            $currency = get_woocommerce_currency();

            if ( $product_variation->is_on_sale() && $product_variation->get_date_on_sale_to() ) {
                $price_valid_until = gmdate( 'Y-m-d', $product_variation->get_date_on_sale_to()->getTimestamp() );
            }

            return array(
                '@type'              => 'Offer',
                'price'              => wc_format_decimal( $product_variation->get_price(), wc_get_price_decimals() ),
                'priceValidUntil'    => $price_valid_until,
                'priceSpecification' => array(
                    'price'                 => wc_format_decimal( $product_variation->get_price(), wc_get_price_decimals() ),
                    'priceCurrency'         => $currency,
                    'valueAddedTaxIncluded' => wc_prices_include_tax() ? 'true' : 'false',
                ),
                'priceCurrency' => $currency,
                'availability'  => 'http://schema.org/' . ( $product->is_in_stock() ? 'InStock' : 'OutOfStock' ),
                'url'           => $permalink,
                'seller'        => array(
                    '@type' => 'Organization',
                    'name'  => $shop_name,
                    'url'   => $shop_url,
                )
            );


        }

    }
    return $markup;
}

add_filter( "woocommerce_structured_data_product_offer", "merchant_richsnippet_data_product_variation_offer", 10, 2 );