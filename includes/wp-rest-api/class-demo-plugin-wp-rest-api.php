<?php
namespace DemoPlugin\Rest;

if (!defined('ABSPATH')) { exit; }

require_once __DIR__ . '/routes/oauth/class-demo-plugin-oauth-functions.php';
require_once __DIR__ . '/routes/oauth/class-demo-plugin-oauth-routes.php';

/**
 * Class Wp_Rest_Api
 *
 * # Super Comments
 * #1 WHY: Central place to initialize REST routes for the plugin.
 * #2 WHAT: Only loads OAuth route group per requirements.
 * #3 HOW: Registers namespaces under /demo-plugin/v1.
 */
final class Wp_Rest_Api
{
    private static ?Wp_Rest_Api $instance = null;

    public static function instance(): Wp_Rest_Api
    {
        return self::$instance ??= new self();
    }

    public function init(): void
    {
        add_action('rest_api_init', function () {
            $namespace = 'demo-plugin/' . DEMO_PLUGIN_VERSION_SLUG;
            (new OAuth_Routes($namespace))->register();
        });
    }
}
