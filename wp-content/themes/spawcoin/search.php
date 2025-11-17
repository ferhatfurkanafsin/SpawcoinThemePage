<?php
/**
 * The template for displaying search results pages
 *
 * @package Spawcoin
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="container">
        <header class="page-header">
            <h1 class="page-title">
                <?php
                printf(
                    esc_html__('Search Results for: %s', 'spawcoin'),
                    '<span>' . get_search_query() . '</span>'
                );
                ?>
            </h1>
        </header>

        <?php if (have_posts()) : ?>

            <div class="grid grid-2">
                <?php
                while (have_posts()) :
                    the_post();
                    ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('card'); ?>>
                        <?php spawcoin_post_thumbnail(); ?>

                        <header class="entry-header">
                            <?php the_title('<h3 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h3>'); ?>

                            <div class="entry-meta">
                                <?php
                                spawcoin_posted_on();
                                spawcoin_posted_by();
                                ?>
                            </div>
                        </header>

                        <div class="entry-summary">
                            <?php the_excerpt(); ?>
                        </div>

                        <footer class="entry-footer">
                            <a href="<?php the_permalink(); ?>" class="btn btn-primary">
                                <?php esc_html_e('Read More', 'spawcoin'); ?>
                            </a>
                        </footer>
                    </article>
                    <?php
                endwhile;
                ?>
            </div>

            <?php
            the_posts_navigation(array(
                'prev_text' => __('&larr; Older results', 'spawcoin'),
                'next_text' => __('Newer results &rarr;', 'spawcoin'),
            ));

        else :
            ?>
            <section class="no-results not-found">
                <header class="page-header">
                    <h2 class="page-title"><?php esc_html_e('Nothing Found', 'spawcoin'); ?></h2>
                </header>

                <div class="page-content">
                    <p><?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with different keywords.', 'spawcoin'); ?></p>
                    <?php get_search_form(); ?>

                    <div class="mt-4">
                        <h3><?php esc_html_e('Try These Instead:', 'spawcoin'); ?></h3>
                        <ul>
                            <li><a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Go to Homepage', 'spawcoin'); ?></a></li>
                            <li><a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>"><?php esc_html_e('View All Posts', 'spawcoin'); ?></a></li>
                        </ul>
                    </div>
                </div>
            </section>
            <?php
        endif;
        ?>
    </div>
</main>

<?php
get_footer();
