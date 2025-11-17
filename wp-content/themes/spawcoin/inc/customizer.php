<?php
/**
 * Spawcoin Theme Customizer
 *
 * @package Spawcoin
 */

/**
 * Add postMessage support for site title and description
 */
function spawcoin_customize_register($wp_customize) {
    $wp_customize->get_setting('blogname')->transport = 'postMessage';
    $wp_customize->get_setting('blogdescription')->transport = 'postMessage';

    if (isset($wp_customize->selective_refresh)) {
        $wp_customize->selective_refresh->add_partial('blogname', array(
            'selector'        => '.site-logo',
            'render_callback' => 'spawcoin_customize_partial_blogname',
        ));

        $wp_customize->selective_refresh->add_partial('blogdescription', array(
            'selector'        => '.hero-subtitle',
            'render_callback' => 'spawcoin_customize_partial_blogdescription',
        ));
    }

    // Theme Colors Section
    $wp_customize->add_section('spawcoin_colors', array(
        'title'    => __('Theme Colors', 'spawcoin'),
        'priority' => 30,
    ));

    // Primary Color
    $wp_customize->add_setting('spawcoin_primary_color', array(
        'default'           => '#6366f1',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'spawcoin_primary_color', array(
        'label'    => __('Primary Color', 'spawcoin'),
        'section'  => 'spawcoin_colors',
        'settings' => 'spawcoin_primary_color',
    )));

    // Secondary Color
    $wp_customize->add_setting('spawcoin_secondary_color', array(
        'default'           => '#ec4899',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'spawcoin_secondary_color', array(
        'label'    => __('Secondary Color', 'spawcoin'),
        'section'  => 'spawcoin_colors',
        'settings' => 'spawcoin_secondary_color',
    )));

    // Accent Color
    $wp_customize->add_setting('spawcoin_accent_color', array(
        'default'           => '#14b8a6',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'spawcoin_accent_color', array(
        'label'    => __('Accent Color', 'spawcoin'),
        'section'  => 'spawcoin_colors',
        'settings' => 'spawcoin_accent_color',
    )));

    // Hero Section
    $wp_customize->add_section('spawcoin_hero', array(
        'title'    => __('Hero Section', 'spawcoin'),
        'priority' => 40,
    ));

    // Hero Title
    $wp_customize->add_setting('spawcoin_hero_title', array(
        'default'           => get_bloginfo('name'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('spawcoin_hero_title', array(
        'label'    => __('Hero Title', 'spawcoin'),
        'section'  => 'spawcoin_hero',
        'type'     => 'text',
    ));

    // Hero Subtitle
    $wp_customize->add_setting('spawcoin_hero_subtitle', array(
        'default'           => get_bloginfo('description'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('spawcoin_hero_subtitle', array(
        'label'    => __('Hero Subtitle', 'spawcoin'),
        'section'  => 'spawcoin_hero',
        'type'     => 'textarea',
    ));

    // Hero Button Text
    $wp_customize->add_setting('spawcoin_hero_button_text', array(
        'default'           => __('Get Started', 'spawcoin'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('spawcoin_hero_button_text', array(
        'label'    => __('Primary Button Text', 'spawcoin'),
        'section'  => 'spawcoin_hero',
        'type'     => 'text',
    ));

    // Hero Button URL
    $wp_customize->add_setting('spawcoin_hero_button_url', array(
        'default'           => '#features',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('spawcoin_hero_button_url', array(
        'label'    => __('Primary Button URL', 'spawcoin'),
        'section'  => 'spawcoin_hero',
        'type'     => 'url',
    ));

    // Social Links Section
    $wp_customize->add_section('spawcoin_social', array(
        'title'    => __('Social Links', 'spawcoin'),
        'priority' => 50,
    ));

    $social_networks = array(
        'twitter'  => __('Twitter', 'spawcoin'),
        'discord'  => __('Discord', 'spawcoin'),
        'telegram' => __('Telegram', 'spawcoin'),
        'github'   => __('GitHub', 'spawcoin'),
    );

    foreach ($social_networks as $network => $label) {
        $wp_customize->add_setting('spawcoin_' . $network . '_url', array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));

        $wp_customize->add_control('spawcoin_' . $network . '_url', array(
            'label'    => $label . ' ' . __('URL', 'spawcoin'),
            'section'  => 'spawcoin_social',
            'type'     => 'url',
        ));
    }

    // Footer Section
    $wp_customize->add_section('spawcoin_footer', array(
        'title'    => __('Footer Settings', 'spawcoin'),
        'priority' => 60,
    ));

    // Footer Copyright Text
    $wp_customize->add_setting('spawcoin_footer_text', array(
        'default'           => sprintf(__('© %s %s | All rights reserved', 'spawcoin'), date('Y'), get_bloginfo('name')),
        'sanitize_callback' => 'wp_kses_post',
    ));

    $wp_customize->add_control('spawcoin_footer_text', array(
        'label'    => __('Copyright Text', 'spawcoin'),
        'section'  => 'spawcoin_footer',
        'type'     => 'textarea',
    ));
}
add_action('customize_register', 'spawcoin_customize_register');

/**
 * Render the site title for the selective refresh partial
 */
function spawcoin_customize_partial_blogname() {
    bloginfo('name');
}

/**
 * Render the site tagline for the selective refresh partial
 */
function spawcoin_customize_partial_blogdescription() {
    bloginfo('description');
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously
 */
function spawcoin_customize_preview_js() {
    wp_enqueue_script('spawcoin-customizer',
        get_template_directory_uri() . '/assets/js/customizer.js',
        array('customize-preview'),
        '1.0.0',
        true
    );
}
add_action('customize_preview_init', 'spawcoin_customize_preview_js');

/**
 * Output custom colors CSS
 */
function spawcoin_custom_colors_css() {
    $primary_color = get_theme_mod('spawcoin_primary_color', '#6366f1');
    $secondary_color = get_theme_mod('spawcoin_secondary_color', '#ec4899');
    $accent_color = get_theme_mod('spawcoin_accent_color', '#14b8a6');

    $css = "
        :root {
            --color-primary: {$primary_color};
            --color-secondary: {$secondary_color};
            --color-accent: {$accent_color};
        }
    ";

    wp_add_inline_style('spawcoin-style', $css);
}
add_action('wp_enqueue_scripts', 'spawcoin_custom_colors_css');
