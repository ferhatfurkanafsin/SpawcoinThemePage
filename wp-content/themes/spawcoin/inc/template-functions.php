<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Spawcoin
 */

/**
 * Adds custom classes to the array of body classes
 */
function spawcoin_body_classes_filter($classes) {
    // Adds a class of hfeed to non-singular pages
    if (!is_singular()) {
        $classes[] = 'hfeed';
    }

    // Adds a class of no-sidebar when there is no sidebar present
    if (!is_active_sidebar('sidebar-1')) {
        $classes[] = 'no-sidebar';
    }

    // Add class for front page
    if (is_front_page()) {
        $classes[] = 'front-page';
    }

    return $classes;
}
add_filter('body_class', 'spawcoin_body_classes_filter');

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments
 */
function spawcoin_pingback_header() {
    if (is_singular() && pings_open()) {
        printf('<link rel="pingback" href="%s">', esc_url(get_bloginfo('pingback_url')));
    }
}
add_action('wp_head', 'spawcoin_pingback_header');

/**
 * Add preload for critical assets
 */
function spawcoin_preload_assets() {
    // Preload key resources
    echo '<link rel="preload" href="' . get_template_directory_uri() . '/assets/css/main.css" as="style">';
    echo '<link rel="dns-prefetch" href="//fonts.googleapis.com">';
    echo '<link rel="dns-prefetch" href="//cdn.jsdelivr.net">';
}
add_action('wp_head', 'spawcoin_preload_assets', 1);

/**
 * Add async/defer to script tags
 */
function spawcoin_add_async_defer_attribute($tag, $handle, $src) {
    $async_scripts = array('threejs', 'gsap', 'gsap-scrolltrigger');
    $defer_scripts = array('spawcoin-three-scene', 'spawcoin-animations');

    if (in_array($handle, $async_scripts)) {
        return str_replace(' src', ' async src', $tag);
    }

    if (in_array($handle, $defer_scripts)) {
        return str_replace(' src', ' defer src', $tag);
    }

    return $tag;
}
add_filter('script_loader_tag', 'spawcoin_add_async_defer_attribute', 10, 3);

/**
 * AJAX handler for loading more posts
 */
function spawcoin_load_more_posts() {
    check_ajax_referer('spawcoin-nonce', 'nonce');

    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;

    $args = array(
        'post_type'      => 'post',
        'posts_per_page' => 6,
        'paged'          => $page,
        'post_status'    => 'publish',
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        ob_start();

        while ($query->have_posts()) {
            $query->the_post();
            get_template_part('template-parts/content', get_post_type());
        }

        $html = ob_get_clean();

        wp_send_json_success(array(
            'html'     => $html,
            'has_more' => $query->max_num_pages > $page,
        ));
    } else {
        wp_send_json_error();
    }

    wp_reset_postdata();
    wp_die();
}
add_action('wp_ajax_load_more_posts', 'spawcoin_load_more_posts');
add_action('wp_ajax_nopriv_load_more_posts', 'spawcoin_load_more_posts');

/**
 * Modify the excerpt more link
 */
function spawcoin_excerpt_more_filter($more) {
    if (!is_single()) {
        $more = sprintf(
            '... <a class="read-more" href="%1$s">%2$s</a>',
            esc_url(get_permalink(get_the_ID())),
            __('Read More', 'spawcoin')
        );
    }

    return $more;
}
add_filter('excerpt_more', 'spawcoin_excerpt_more_filter');

/**
 * Add custom image sizes to media library
 */
function spawcoin_custom_image_sizes($sizes) {
    return array_merge($sizes, array(
        'spawcoin-featured'   => __('Featured (1920x1080)', 'spawcoin'),
        'spawcoin-medium'     => __('Medium (800x600)', 'spawcoin'),
        'spawcoin-thumbnail'  => __('Thumbnail (400x300)', 'spawcoin'),
    ));
}
add_filter('image_size_names_choose', 'spawcoin_custom_image_sizes');

/**
 * Add support for SVG uploads
 */
function spawcoin_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    $mimes['svgz'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'spawcoin_mime_types');

/**
 * Fix SVG thumbnails
 */
function spawcoin_fix_svg_thumb_display() {
    echo '<style>
        td.media-icon img[src$=".svg"],
        img[src$=".svg"].attachment-post-thumbnail {
            width: 100% !important;
            height: auto !important;
        }
    </style>';
}
add_action('admin_head', 'spawcoin_fix_svg_thumb_display');

/**
 * Improve WordPress security
 */
function spawcoin_security_headers() {
    // Remove version info from scripts and styles
    return '';
}
add_filter('style_loader_src', 'spawcoin_security_headers', 9999);
add_filter('script_loader_src', 'spawcoin_security_headers', 9999);

/**
 * Disable XML-RPC for security
 */
add_filter('xmlrpc_enabled', '__return_false');

/**
 * Remove WordPress version from RSS feeds
 */
add_filter('the_generator', '__return_empty_string');

/**
 * Add custom query vars
 */
function spawcoin_add_query_vars($vars) {
    $vars[] = 'spawcoin_action';
    return $vars;
}
add_filter('query_vars', 'spawcoin_add_query_vars');

/**
 * Customize archive titles
 */
function spawcoin_archive_title($title) {
    if (is_category()) {
        $title = single_cat_title('', false);
    } elseif (is_tag()) {
        $title = single_tag_title('', false);
    } elseif (is_author()) {
        $title = '<span class="vcard">' . get_the_author() . '</span>';
    } elseif (is_post_type_archive()) {
        $title = post_type_archive_title('', false);
    } elseif (is_tax()) {
        $title = single_term_title('', false);
    }

    return $title;
}
add_filter('get_the_archive_title', 'spawcoin_archive_title');

/**
 * Add schema.org markup
 */
function spawcoin_add_schema_markup() {
    $schema = 'https://schema.org/';

    if (is_single()) {
        $type = 'Article';
    } elseif (is_author()) {
        $type = 'ProfilePage';
    } elseif (is_search()) {
        $type = 'SearchResultsPage';
    } else {
        $type = 'WebPage';
    }

    echo 'itemscope itemtype="' . esc_attr($schema . $type) . '"';
}

/**
 * Optimize WordPress performance
 */
function spawcoin_optimize_performance() {
    // Disable emojis
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');

    // Remove query strings from static resources
    add_filter('script_loader_src', 'spawcoin_remove_script_version', 15, 1);
    add_filter('style_loader_src', 'spawcoin_remove_script_version', 15, 1);
}
add_action('init', 'spawcoin_optimize_performance');

function spawcoin_remove_script_version($src) {
    if (strpos($src, '?ver=')) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
}
