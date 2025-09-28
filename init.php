<?php
/**
 * Plugin Name: Demo Plugin
 * Plugin URI:  https://example.com/marketplace
 * Description: Minimal, robust scaffolding for a WordPress plugin with PSR-4, CPT, and OAuth-only REST routes.
 * Author:      Abraham Gomez
 * Author URI:  https://example.com/abraham-gomez
 * Version:     1.0.0
 * Text Domain: demo-plugin
 * License:     GPL-3.0-or-later
 *
 * @package demo-plugin
 */

// #0 SAFETY CHECK --------------------------------------------------------------
// Prevent direct web access to this file (important in WordPress plugins).
if (!defined('ABSPATH')) {
    exit;
}

// #1 AUTOLOAD (COMPOSER) -------------------------------------------------------
// If composer autoloader exists, load it. This enables PSR-4 namespacing.
$autoload = __DIR__ . '/vendor/autoload.php';
if (file_exists($autoload)) {
    require_once $autoload;
}

// #2 CORE BOOTSTRAP ------------------------------------------------------------
// Load Config and Main orchestrator (kept outside Composer to guarantee boot).
require_once __DIR__ . '/includes/class-demo-plugin-config.php';
require_once __DIR__ . '/includes/class-demo-plugin-main.php';

use DemoPlugin\Config;
use DemoPlugin\Main;

// #3 CONFIG INITIALIZATION -----------------------------------------------------
// Super comment: Centralized configuration so you can change slug, version,
// URLs, etc., without hunting through the codebase.
Config::bootstrap([
    'version'     => '1.0.0',
    'slug'        => 'demo-plugin',
    'versionSlug' => 'v1',
    'siteUrl'     => 'https://example.com',
]);

// #3.1 Backward-compat constant (optional) ------------------------------------
// Super comment: If legacy code expects MARKETPLACE_SITE_URL, keep an alias.
if (!defined('MARKETPLACE_SITE_URL')) {
    define('MARKETPLACE_SITE_URL', DEMO_PLUGIN_SITE_URL);
}

// #4 WORDPRESS LIFECYCLE HOOKS -------------------------------------------------
// Super comment: Hook plugin init *after* plugins_loaded for reliability.
add_action('plugins_loaded', static function () {
    Main::instance()->init();
}, 11);

// Activation/deactivation are registered at file scope.
register_activation_hook(__FILE__, static function () {
    Main::instance()->onActivate();
});

register_deactivation_hook(__FILE__, static function () {
    Main::instance()->onDeactivate();
});
