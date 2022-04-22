=== Woocommerce Product Variation Rich Snippet Fix for Google Merchant Center ===

Contributors: Andrea Debernardi
Tags: merchant,center,woocommerce,rich,snippet,product,variation,google
Requires at least: 4.7
Tested up to: 5.9.3
Stable tag: 1.0
WC requires at least: 5.0.0
WC tested up to: 6.4.1
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Basic WooCommerce plugin that makes product variation rich snippets compliant with Google Merchant Center

== Description ==

This plugin solves the problem of Google Merchant Center not being able to recognize product variations from WooCommerce structured data.

Specifically, for each product variation, Google Merchant Center will only recognize from WooCommerce structured data the main production variable only, assigning `lowPrice` and `highPrice` .
So some product variations will be marked by Google merchant center as "disapproved" (Mismatched value (page crawl): (price [price])) and won't be displayed in the search results.

This plugin identifies the product variation starting from attributes in single product page and adds the product variation price to the structured data.

== Changelog ==

= 1.0 =
* First release