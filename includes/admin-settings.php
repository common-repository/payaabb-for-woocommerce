<?php
if (!defined("ABSPATH")) {
    exit();
}

return apply_filters("wc_payaabb_settings", [
    "enabled" => [
        "title" => __("Enable/Disable", "payaabb-for-woocommerce"),
        "label" => __("Enable PTPShopy", "payaabb-for-woocommerce"),
        "type" => "checkbox",
        "description" => "",
        "default" => "yes",
    ],
    "title" => [
        "title" => __("Title", "payaabb-for-woocommerce"),
        "type" => "text",
        "description" => __(
            "This controls the title which the user sees during checkout.",
            "payaabb-for-woocommerce"
        ),
        "default" => __("Crypto Payment PTPShopy", "payaabb-for-woocommerce"),
    ],
    "description" => [
        "title" => __("Description", "payaabb-for-woocommerce"),
        "type" => "text",
        "description" => __(
            "This controls the description which the user sees during checkout.",
            "payaabb-for-woocommerce"
        ),
        "default" => __(
            "Pay with crypto via PTPShopy payment gateway",
            "payaabb-for-woocommerce"
        ),
    ],
    "ipn_url" => [
        "title" => __("IPN Url", "payaabb-for-woocommerce"),
        "type" => "text",
        "description" => sprintf(
            __(
                'Copy this url to "IPN Url" field on %1$s',
                "payaabb-for-woocommerce"
            ),
            '<a target="_blank" href="https://merchant.payaabb.com">merchant.payaabb.com</a>'
        ),
        "default" => esc_url(
            get_site_url() . "?wc-api=wc_payaabb_gateway_payment"
        ),
        "custom_attributes" => ["readonly" => "readonly"],
    ],
    "api_key" => [
        "title" => __("API Code", "payaabb-for-woocommerce"),
        "type" => "text",
        "description" => __(
            "Get your API Code from your PTPShopy account.",
            "payaabb-for-woocommerce"
        ),
        "default" => "",
    ],
    "ipn_key" => [
        "title" => __("IPN Key", "payaabb-for-woocommerce"),
        "type" => "text",
        "description" => __(
            "Get your IPN Key from your PTPShopy account.",
            "payaabb-for-woocommerce"
        ),
        "default" => "",
    ],
]);
