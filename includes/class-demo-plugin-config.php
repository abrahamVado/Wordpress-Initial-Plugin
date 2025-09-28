<?php
namespace DemoPlugin;

if (!defined('ABSPATH')) { exit; }

/**
 * Class Config
 *
 * # Super Comments
 * #1 WHY: Provides centralized configuration & defines slug-based constants.
 * #2 WHAT: Exposes static properties and defines DEMO_PLUGIN_* constants
 *          derived from those values so any file can rely on them.
 * #3 HOW: Call Config::bootstrap() once (from init.php) during plugin load.
 */
final class Config
{
    public static string $version;
    public static string $slug;
    public static string $versionSlug;
    public static string $path;
    public static string $url;
    public static string $templatesPath;
    public static string $assetsUrl;
    public static string $textDomain = 'demo-plugin';
    public static string $siteUrl;

    /** #4 Entry: initialize values and define constants. */
    public static function bootstrap(array $args): void
    {
        self::$version     = $args['version']     ?? '1.0.0';
        self::$slug        = $args['slug']        ?? 'demo-plugin';
        self::$versionSlug = $args['versionSlug'] ?? 'v1';
        self::$siteUrl     = $args['siteUrl']     ?? 'https://example.com';

        self::$path          = plugin_dir_path(self::rootFile());
        self::$url           = plugins_url('/', self::rootFile());
        self::$templatesPath = self::$path . 'templates/';
        self::$assetsUrl     = self::$url . 'assets/';

        // #5 Define constants once so procedural WP APIs can reference them.
        self::defineIfNot('DEMO_PLUGIN_VERSION', self::$version);
        self::defineIfNot('DEMO_PLUGIN_SLUG', self::$slug);
        self::defineIfNot('DEMO_PLUGIN_VERSION_SLUG', self::$versionSlug);
        self::defineIfNot('DEMO_PLUGIN_PATH', self::$path);
        self::defineIfNot('DEMO_PLUGIN_URL', self::$url);
        self::defineIfNot('DEMO_PLUGIN_TEMPLATES_PATH', self::$templatesPath);
        self::defineIfNot('DEMO_PLUGIN_ASSETS_URL', self::$assetsUrl);
        self::defineIfNot('DEMO_PLUGIN_TEXT_DOMAIN', self::$textDomain);
        self::defineIfNot('DEMO_PLUGIN_SITE_URL', self::$siteUrl);
    }

    /** #6 Helper: define constant if not already defined. */
    private static function defineIfNot(string $name, $value): void
    {
        if (!defined($name)) {
            define($name, $value);
        }
    }

    /** #7 Resolve plugin root file (init.php). */
    public static function rootFile(): string
    {
        return dirname(__DIR__) . '/init.php';
    }
}
