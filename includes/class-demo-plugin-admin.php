<?php
namespace DemoPlugin;

if (!defined('ABSPATH')) { exit; }

/**
 * Class Admin
 *
 * # Super Comments
 * #1 WHY: Provides a minimal admin menu and page for configuration or info.
 * #2 WHAT: Creates a top-level "Demo Plugin" page under WP Admin.
 * #3 HOW: Hooked during plugin init; renders a basic, extensible screen.
 */
final class Admin
{
    private static ?Admin $instance = null;

    public static function instance(): Admin
    {
        return self::$instance ??= new self();
    }

    public function init(): void
    {
        add_action('admin_menu', [$this, 'registerMenu']);
    }

    /** #4 Register a top-level admin menu. */
    public function registerMenu(): void
    {
        add_menu_page(
            __('Demo Plugin', DEMO_PLUGIN_TEXT_DOMAIN),
            __('Demo Plugin', DEMO_PLUGIN_TEXT_DOMAIN),
            'manage_options',
            DEMO_PLUGIN_SLUG,
            [$this, 'renderPage'],
            'dashicons-admin-generic',
            58
        );
    }

    /** #5 Render admin page (plain HTML + jQuery hooks). */
    public function renderPage(): void
    {
        ?>
        <div class="wrap">
            <h1><?php echo esc_html__('Demo Plugin', DEMO_PLUGIN_TEXT_DOMAIN); ?></h1>
            <p><?php echo esc_html__('This is a minimal admin screen. Use jQuery to enhance.', DEMO_PLUGIN_TEXT_DOMAIN); ?></p>

            <button id="demo-plugin-ping" class="button button-primary">
                <?php echo esc_html__('Ping OAuth Endpoint', DEMO_PLUGIN_TEXT_DOMAIN); ?>
            </button>

            <pre id="demo-plugin-output"></pre>
        </div>
        <?php
    }
}
