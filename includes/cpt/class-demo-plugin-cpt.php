<?php
namespace DemoPlugin\CPT;

if (!defined('ABSPATH')) { exit; }

/**
 * Class Demo_CPT
 *
 * # Super Comments
 * #1 WHY: Registers a sample CPT named "demo-plugin".
 * #2 WHAT: Public CPT with REST support; adjust labels/args as needed.
 * #3 HOW: Called by Main during init and activation (for rewrites).
 */
final class Demo_CPT
{
    private static ?Demo_CPT $instance = null;

    public static function instance(): Demo_CPT
    {
        return self::$instance ??= new self();
    }

    public function init(): void
    {
        add_action('init', [$this, 'registerCPT']);
    }

    public function registerCPT(): void
    {
        $labels = [
            'name'          => __('Demo Items', 'demo-plugin'),
            'singular_name' => __('Demo Item', 'demo-plugin'),
        ];

        $args = [
            'label'         => __('Demo Items', 'demo-plugin'),
            'labels'        => $labels,
            'public'        => true,
            'show_in_rest'  => true,
            'supports'      => ['title', 'editor'],
            'has_archive'   => true,
            'rewrite'       => ['slug' => 'demo'],
            'menu_icon'     => 'dashicons-admin-post',
        ];

        register_post_type('demo-plugin', $args);
    }
}
