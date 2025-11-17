<?php
/**
 * The template for displaying archive pages
 *
 * @package Spawcoin
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="container">
        <?php if (have_posts()) : ?>

            <header class="page-header">
                <?php
                the_archive_title('<h1 class="page-title">', '</h1>');
                the_archive_description('<div class="archive-description">', '</div>');
                ?>
            </header>

            <div class="grid grid-2">
                <?php
                while (have_posts()) :
                    the_post();
                    get_template_part('template-parts/content', get_post_type());
                endwhile;
                ?>
            </div>

            <?php
            the_posts_navigation(array(
                'prev_text' => __('&larr; Older posts', 'spawcoin'),
                'next_text' => __('Newer posts &rarr;', 'spawcoin'),
            ));

        else :
            ?>
            <section class="no-results not-found">
                <header class="page-header">
                    <h1 class="page-title"><?php esc_html_e('Nothing Found', 'spawcoin'); ?></h1>
                </header>
                <div class="page-content">
                    <p><?php esc_html_e('It seems we can\'t find what you\'re looking for.', 'spawcoin'); ?></p>
                    <?php get_search_form(); ?>
                </div>
            </section>
            <?php
        endif;
        ?>
    </div>
</main>

<?php
get_footer();
