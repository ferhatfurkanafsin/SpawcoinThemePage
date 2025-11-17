<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package Spawcoin
 */

get_header();
?>

<main id="primary" class="site-main">
    <section class="error-404 not-found">
        <div class="container text-center">
            <header class="page-header">
                <h1 class="page-title" style="font-size: 8rem; margin-bottom: 1rem;">404</h1>
                <p class="page-description" style="font-size: 2rem; margin-bottom: 2rem;">
                    <?php esc_html_e('Oops! Page Not Found', 'spawcoin'); ?>
                </p>
            </header>

            <div class="page-content">
                <p style="font-size: 1.25rem; margin-bottom: 2rem; color: var(--color-gray-light);">
                    <?php esc_html_e('The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.', 'spawcoin'); ?>
                </p>

                <?php get_search_form(); ?>

                <div class="mt-4">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary">
                        <?php esc_html_e('Go to Homepage', 'spawcoin'); ?>
                    </a>
                </div>

                <div class="mt-4">
                    <h3><?php esc_html_e('Popular Pages', 'spawcoin'); ?></h3>
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'container'      => 'nav',
                        'container_class' => '404-menu',
                        'fallback_cb'    => false,
                    ));
                    ?>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
get_footer();
