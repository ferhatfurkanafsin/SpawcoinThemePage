<?php
/**
 * Spawcoin Theme Functions
 *
 * @package Spawcoin
 * @version 1.0.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Theme Setup
 */
function spawcoin_setup() {
    // Add default posts and comments RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails
    add_theme_support('post-thumbnails');
    set_post_thumbnail_size(1200, 675, true);

    // Add custom image sizes
    add_image_size('spawcoin-featured', 1920, 1080, true);
    add_image_size('spawcoin-medium', 800, 600, true);
    add_image_size('spawcoin-thumbnail', 400, 300, true);

    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'spawcoin'),
        'footer' => __('Footer Menu', 'spawcoin'),
    ));

    // Switch default core markup to output valid HTML5
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));

    // Add theme support for selective refresh for widgets
    add_theme_support('customize-selective-refresh-widgets');

    // Add support for core custom logo
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
    ));

    // Add support for responsive embedded content
    add_theme_support('responsive-embeds');

    // Add support for editor styles
    add_theme_support('editor-styles');
    add_editor_style('assets/css/editor-style.css');

    // Add support for wide alignment
    add_theme_support('align-wide');

    // Add support for custom background
    add_theme_support('custom-background', array(
        'default-color' => '0f172a',
    ));

    // Add support for block styles
    add_theme_support('wp-block-styles');
}
add_action('after_setup_theme', 'spawcoin_setup');

/**
 * Set the content width
 */
function spawcoin_content_width() {
    $GLOBALS['content_width'] = apply_filters('spawcoin_content_width', 1400);
}
add_action('after_setup_theme', 'spawcoin_content_width', 0);

/**
 * Register Widget Areas
 */
function spawcoin_widgets_init() {
    register_sidebar(array(
        'name'          => __('Sidebar', 'spawcoin'),
        'id'            => 'sidebar-1',
        'description'   => __('Add widgets here to appear in your sidebar.', 'spawcoin'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    register_sidebar(array(
        'name'          => __('Footer Widget Area 1', 'spawcoin'),
        'id'            => 'footer-1',
        'description'   => __('Appears in the footer section of the site.', 'spawcoin'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    register_sidebar(array(
        'name'          => __('Footer Widget Area 2', 'spawcoin'),
        'id'            => 'footer-2',
        'description'   => __('Appears in the footer section of the site.', 'spawcoin'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    register_sidebar(array(
        'name'          => __('Footer Widget Area 3', 'spawcoin'),
        'id'            => 'footer-3',
        'description'   => __('Appears in the footer section of the site.', 'spawcoin'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'spawcoin_widgets_init');

/**
 * Enqueue scripts and styles
 */
function spawcoin_scripts() {
    // Main stylesheet
    wp_enqueue_style('spawcoin-style', get_stylesheet_uri(), array(), '1.0.0');

    // Google Fonts
    wp_enqueue_style('spawcoin-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500;600&display=swap',
        array(),
        null
    );

    // Three.js for 3D animations
    wp_enqueue_script('threejs',
        'https://cdn.jsdelivr.net/npm/three@0.160.0/build/three.min.js',
        array(),
        '0.160.0',
        true
    );

    // GSAP for advanced animations
    wp_enqueue_script('gsap',
        'https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js',
        array(),
        '3.12.5',
        true
    );

    wp_enqueue_script('gsap-scrolltrigger',
        'https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js',
        array('gsap'),
        '3.12.5',
        true
    );

    // Custom JavaScript
    wp_enqueue_script('spawcoin-three-scene',
        get_template_directory_uri() . '/assets/js/three-scene.js',
        array('threejs'),
        '1.0.0',
        true
    );

    wp_enqueue_script('spawcoin-animations',
        get_template_directory_uri() . '/assets/js/animations.js',
        array('gsap', 'gsap-scrolltrigger'),
        '1.0.0',
        true
    );

    wp_enqueue_script('spawcoin-main',
        get_template_directory_uri() . '/assets/js/main.js',
        array('jquery'),
        '1.0.0',
        true
    );

    // Localize script for AJAX
    wp_localize_script('spawcoin-main', 'spawcoinData', array(
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('spawcoin-nonce'),
        'themeUrl' => get_template_directory_uri(),
    ));

    // Comments script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'spawcoin_scripts');

/**
 * Custom Header Configuration
 */
function spawcoin_custom_header_setup() {
    add_theme_support('custom-header', array(
        'default-image'      => '',
        'default-text-color' => 'ffffff',
        'width'              => 1920,
        'height'             => 1080,
        'flex-height'        => true,
        'flex-width'         => true,
    ));
}
add_action('after_setup_theme', 'spawcoin_custom_header_setup');

/**
 * Customizer additions
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Custom template tags
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Add custom post types
 */
function spawcoin_custom_post_types() {
    // Portfolio Post Type
    register_post_type('portfolio', array(
        'labels' => array(
            'name' => __('Portfolio', 'spawcoin'),
            'singular_name' => __('Portfolio Item', 'spawcoin'),
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'menu_icon' => 'dashicons-portfolio',
        'show_in_rest' => true,
    ));

    // Testimonials Post Type
    register_post_type('testimonials', array(
        'labels' => array(
            'name' => __('Testimonials', 'spawcoin'),
            'singular_name' => __('Testimonial', 'spawcoin'),
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
        'menu_icon' => 'dashicons-format-quote',
        'show_in_rest' => true,
    ));
}
add_action('init', 'spawcoin_custom_post_types');

/**
 * Add body classes
 */
function spawcoin_body_classes($classes) {
    // Adds a class of hfeed to non-singular pages
    if (!is_singular()) {
        $classes[] = 'hfeed';
    }

    // Adds a class of no-sidebar when there is no sidebar present
    if (!is_active_sidebar('sidebar-1')) {
        $classes[] = 'no-sidebar';
    }

    return $classes;
}
add_filter('body_class', 'spawcoin_body_classes');

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles
 */
function spawcoin_pingback_header() {
    if (is_singular() && pings_open()) {
        printf('<link rel="pingback" href="%s">', esc_url(get_bloginfo('pingback_url')));
    }
}
add_action('wp_head', 'spawcoin_pingback_header');

/**
 * Excerpt length
 */
function spawcoin_excerpt_length($length) {
    return 30;
}
add_filter('excerpt_length', 'spawcoin_excerpt_length', 999);

/**
 * Excerpt more
 */
function spawcoin_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'spawcoin_excerpt_more');

/**
 * Add async/defer attributes to enqueued scripts
 */
function spawcoin_script_loader_tag($tag, $handle, $src) {
    $async_scripts = array('threejs', 'gsap', 'gsap-scrolltrigger');

    if (in_array($handle, $async_scripts)) {
        $tag = str_replace(' src', ' defer src', $tag);
    }

    return $tag;
}
add_filter('script_loader_tag', 'spawcoin_script_loader_tag', 10, 3);

/**
 * Security: Remove WordPress version info
 */
remove_action('wp_head', 'wp_generator');

/**
 * Optimize WordPress performance
 */
function spawcoin_optimize() {
    // Remove emoji scripts
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');

    // Remove jQuery migrate
    if (!is_admin()) {
        wp_deregister_script('jquery');
        wp_register_script('jquery',
            'https://code.jquery.com/jquery-3.7.1.min.js',
            array(),
            '3.7.1',
            true
        );
        wp_enqueue_script('jquery');
    }
}
add_action('init', 'spawcoin_optimize');

/**
 * Enable shortcodes in widgets
 */
add_filter('widget_text', 'do_shortcode');

/**
 * Custom logo output
 */
function spawcoin_custom_logo() {
    if (has_custom_logo()) {
        the_custom_logo();
    } else {
        echo '<a href="' . esc_url(home_url('/')) . '" class="site-logo">';
        echo esc_html(get_bloginfo('name'));
        echo '</a>';
    }
}

/**
 * Plugin compatibility
 */

// WooCommerce support
if (class_exists('WooCommerce')) {
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}

// Elementor support
if (did_action('elementor/loaded')) {
    function spawcoin_register_elementor_locations($elementor_theme_manager) {
        $elementor_theme_manager->register_all_core_location();
    }
    add_action('elementor/theme/register_locations', 'spawcoin_register_elementor_locations');
}

// Contact Form 7 support
if (function_exists('wpcf7')) {
    add_filter('wpcf7_autop_or_not', '__return_false');
}
