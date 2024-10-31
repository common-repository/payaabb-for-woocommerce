<?php
use Automattic\WooCommerce\Blocks\Payments\PaymentMethodRegistry;

if (!defined("ABSPATH")) {
    exit();
}

function woocommerce_payaabb_missing_wc_notice()
{
    echo '<div class="error"><p><strong>' .
        esc_html__(
            'PTPShopy requires WooCommerce to be installed and active. You can download <a href="https://woocommerce.com/" target="_blank">WooCommerce</a> here.',
            "payaabb-for-woocommerce"
        ) .
        "</strong></p></div>";
}

function woocommerce_payaabb_gateway_init()
{
    if (!class_exists("WooCommerce")) {
        add_action("admin_notices", "woocommerce_payaabb_missing_wc_notice");
        return;
    }

    if (!class_exists("WC_Payaabb")):
        class WC_Payaabb
        {
            /**
             * @var Singleton The reference the *Singleton* instance of this class
             */
            private static $instance;

            /**
             * @var Reference to logging class.
             */
            private static $log;

            /**
             * Returns the *Singleton* instance of this class.
             *
             * @return Singleton The *Singleton* instance.
             */
            public static function get_instance()
            {
                if (self::$instance === null) {
                    self::$instance = new self();
                }
                return self::$instance;
            }

            /**
             * Private clone method to prevent cloning of the instance of the
             * *Singleton* instance.
             *
             * @return void
             */
            private function __clone()
            {
            }

            /**
             * Private unserialize method to prevent unserializing of the *Singleton*
             * instance.
             *
             * @return void
             */
            public function __wakeup()
            {
            }

            /**
             * Protected constructor to prevent creating a new instance of the
             * *Singleton* via the `new` operator from outside of this class.
             */
            private function __construct()
            {
                add_action("admin_init", [$this, "install"]);
                $this->init();
            }

            /**
             * Init the plugin after plugins_loaded so environment variables are set.
             */
            public function init()
            {
                require_once dirname(__FILE__) . "/gateway.php";

                if (is_admin()) {
                    require_once dirname(__FILE__) . "/admin-notices.php";
                }

                add_filter("woocommerce_payment_gateways", [
                    $this,
                    "add_gateways",
                ]);
                add_filter("plugin_action_links_" . plugin_basename(__FILE__), [
                    $this,
                    "plugin_action_links",
                ]);

                if (version_compare(WC_VERSION, "3.4", "<")) {
                    add_filter("woocommerce_get_sections_checkout", [
                        $this,
                        "filter_gateway_order_admin",
                    ]);
                }
            }

            /**
             * Updates the plugin version in db
             */
            public function update_plugin_version()
            {
                delete_option("wc_payaabb_version");
                update_option("wc_payaabb_version", WC_PAYAABB_VERSION);
            }

            /**
             * Handles upgrade routines.
             */
            public function install()
            {
                if (!is_plugin_active(plugin_basename(__FILE__))) {
                    return;
                }

                if (
                    !defined("IFRAME_REQUEST") &&
                    WC_PAYAABB_VERSION !== get_option("wc_payaabb_version")
                ) {
                    do_action("woocommerce_payaabb_updated");

                    if (!defined("WC_PAYAABB_INSTALLING")) {
                        define("WC_PAYAABB_INSTALLING", true);
                    }

                    $this->update_plugin_version();
                }
            }

            /**
             * Adds plugin action links.
             */
            public function plugin_action_links($links)
            {
                $links[] =
                    '<a href="admin.php?page=wc-settings&tab=checkout&section=payaabb">' .
                    esc_html__("Settings", "payaabb-for-woocommerce") .
                    "</a>";
                return $links;
            }

            /**
             * Add the gateways to WooCommerce.
             */
            public function add_gateways($methods)
            {
                $methods[] = "WC_Payaabb_Gateway";
                return $methods;
            }

            /**
             * Modifies the order of the gateways displayed in admin.
             */
            public function filter_gateway_order_admin($sections)
            {
                unset($sections["payaabb"]);
                $sections["payaabb"] = "PTPShopy";
                return $sections;
            }
        }

        WC_Payaabb::get_instance();
    endif;
}
add_action("plugins_loaded", "woocommerce_payaabb_gateway_init", 0);

function woocommerce_payaabb_blocks_support()
{
    if (
        class_exists(
            "Automattic\WooCommerce\Blocks\Payments\Integrations\AbstractPaymentMethodType"
        )
    ) {
        require_once dirname(__FILE__) . "/blocks-support.php";
        add_action(
            "woocommerce_blocks_payment_method_type_registration",
            function (
                Automattic\WooCommerce\Blocks\Payments\PaymentMethodRegistry $payment_method_registry
            ) {
                $payment_method_registry->register(
                    new WC_Payaabb_Blocks_Support()
                );
            }
        );
    }
}
add_action("woocommerce_blocks_loaded", "woocommerce_payaabb_blocks_support");
