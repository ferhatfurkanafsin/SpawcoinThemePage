<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Preconnect to optimize font loading -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- SEO Meta Tags -->
    <meta name="description" content="<?php bloginfo('description'); ?>">
    <meta name="theme-color" content="#6366f1">

    <!-- Open Graph Meta Tags -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?php wp_title('|', true, 'right'); bloginfo('name'); ?>">
    <meta property="og:description" content="<?php bloginfo('description'); ?>">
    <meta property="og:url" content="<?php echo esc_url(home_url('/')); ?>">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php wp_title('|', true, 'right'); bloginfo('name'); ?>">
    <meta name="twitter:description" content="<?php bloginfo('description'); ?>">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Skip to content', 'spawcoin'); ?></a>

    <header id="masthead" class="site-header">
        <div class="nav-container container">
            <div class="site-branding">
                <?php spawcoin_custom_logo(); ?>
            </div>

            <nav id="site-navigation" class="main-navigation">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'menu_id'        => 'primary-menu',
                    'container'      => false,
                    'fallback_cb'    => false,
                ));
                ?>
            </nav>

            <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                <span class="menu-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </button>
        </div>
    </header>

    <div id="content" class="site-content">
