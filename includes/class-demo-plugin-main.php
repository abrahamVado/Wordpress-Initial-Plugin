<?php
namespace DemoPlugin;

if (!defined('ABSPATH')) { exit; }

require_once __DIR__ . '/class-demo-plugin-admin.php';
require_once __DIR__ . '/cpt/class-demo-plugin-cpt.php';
require_once __DIR__ . '/wp-rest-api/class-demo-plugin-wp-rest-api.php';

/**
 * Class Main
 *
 * # Super Comments
 * #1 WHY: Orchestrates all subsystems (admin UI, CPT, REST, assets).
 * #2 WHAT: Singleton that wires hooks, enqueues scripts, and manages lifecycle.
 * #3 HOW: Main::instance()->init() is called from init.php on plugins_loaded.
 */
final class Main
{
    private static ?Main $instance = null;

    /** #4 Singleton accessor. */
    public static function instance(): Main
    {
        return self::$instance ??= new self();
    }

    /** #5 Wire everything. */
    public function init(): void
    {
        // i18n: load text domain from /languages if you add translations later.
        load_plugin_textdomain(DEMO_PLUGIN_TEXT_DOMAIN, false, dirname(plugin_basename(Config::rootFile())) . '/languages');

        // Admin UI (jQuery only, minimal).
        Admin::instance()->init();

        // Custom Post Type(s).
        CPT\Demo_CPT::instance()->init();

        // REST API (only OAuth routes enabled).
        Rest\Wp_Rest_Api::instance()->init();

        // Assets.
        add_action('wp_enqueue_scripts', [$this, 'enqueueFront']);
        add_action('admin_enqueue_scripts', [$this, 'enqueueAdmin']);
    }

    /** #6 Activation: register CPT then flush rewrites. */
    public function onActivate(): void
    {
        CPT\Demo_CPT::instance()->registerCPT();
        flush_rewrite_rules();
    }

    /** #7 Deactivation: flush rewrites (keep data). */
    public function onDeactivate(): void
    {
        flush_rewrite_rules();
    }

    /** #8 Front-end assets (no CSS; jQuery dependency). */
    public function enqueueFront(): void
    {
        wp_enqueue_script(
            DEMO_PLUGIN_SLUG . '-front',
            DEMO_PLUGIN_ASSETS_URL . 'js/front.js',
            ['jquery'],
            DEMO_PLUGIN_VERSION,
            true
        );
    }

    /** #9 Admin assets (no CSS; jQuery dependency). */
    public function enqueueAdmin(): void
    {
        wp_enqueue_script(
            DEMO_PLUGIN_SLUG . '-admin',
            DEMO_PLUGIN_ASSETS_URL . 'js/admin.js',
            ['jquery'],
            DEMO_PLUGIN_VERSION,
            true
        );
    }
}
