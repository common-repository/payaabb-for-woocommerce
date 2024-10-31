<?php
if (!defined("ABSPATH")) {
    exit();
}

if (!defined("WP_UNINSTALL_PLUGIN")) {
    exit();
}

if (defined("WC_REMOVE_ALL_DATA") && true === WC_REMOVE_ALL_DATA) {
    delete_option("woocommerce_payaabb_settings");
    delete_option("wc_payaabb_latest_datetime_check_public_version_plugin");
    delete_option("wc_payaabb_show_phpver_notice");
    delete_option("wc_payaabb_show_wcver_notice");
    delete_option("wc_payaabb_show_curl_notice");
    delete_option("wc_payaabb_show_ssl_notice");
    delete_option("wc_payaabb_show_keys_notice");
    delete_option("wc_payaabb_version");
}
