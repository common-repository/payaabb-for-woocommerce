<?php
/**
 * Plugin Name: PayAABB For WooCommerce
 * Description: PayAABB is the best crypto gateway, which allows users to checkout with popular cryptocurrencies.
 * Author: PayAABB
 * Author URI: https://payaabb.com/
 * Version: 1.0.1
 * Requires at least: 5.4
 * Requires PHP: 7.4
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:       payaabb-for-woocommerce
 * Domain Path:       /languages
 * Tags: ecommerce, e-commerce, store, sales, sell, shop, cart, checkout, payment, btc, eth, usdt, usdc, bnb, ltc, payment gateway, crypto
 **/

if (!defined("ABSPATH")) {
    exit();
}

define("WC_PAYAABB_VERSION", "1.0.1");
define("WC_PAYAABB_MIN_PHP_VER", "7.4.0");
define("WC_PAYAABB_MIN_WC_VER", "7.7");
define("WC_PAYAABB_PLUGIN_PATH", untrailingslashit(plugin_dir_path(__FILE__)));
define(
    "WC_PAYAABB_PLUGIN_URL",
    untrailingslashit(
        plugins_url(basename(plugin_dir_path(__FILE__)), basename(__FILE__))
    )
);

require_once "includes/woocommerce.php";
