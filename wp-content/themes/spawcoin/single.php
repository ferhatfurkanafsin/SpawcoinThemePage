<?php
/**
 * The template for displaying all single posts
 *
 * @package Spawcoin
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="container">
        <?php
        while (have_posts()) :
            the_post();
            ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class('single-post'); ?>>
                <?php spawcoin_breadcrumb(); ?>

                <header class="entry-header">
                    <?php the_title('<h1 class="entry-title">', '</h1>'); ?>

                    <div class="entry-meta">
                        <?php
                        spawcoin_posted_on();
                        spawcoin_posted_by();
                        ?>
                        <span class="reading-time">
                            <?php echo spawcoin_reading_time(); ?>
                        </span>
                    </div>
                </header>

                <?php spawcoin_post_thumbnail(); ?>

                <div class="entry-content">
                    <?php
                    the_content(
                        sprintf(
                            wp_kses(
                                __('Continue reading<span class="screen-reader-text"> "%s"</span>', 'spawcoin'),
                                array('span' => array('class' => array()))
                            ),
                            wp_kses_post(get_the_title())
                        )
                    );

                    wp_link_pages(
                        array(
                            'before' => '<div class="page-links">' . esc_html__('Pages:', 'spawcoin'),
                            'after'  => '</div>',
                        )
                    );
                    ?>
                </div>

                <footer class="entry-footer">
                    <?php spawcoin_entry_footer(); ?>
                </footer>
            </article>

            <?php
            // Author bio
            if (get_the_author_meta('description')) :
                ?>
                <div class="author-bio card">
                    <div class="author-avatar">
                        <?php echo get_avatar(get_the_author_meta('ID'), 80); ?>
                    </div>
                    <div class="author-info">
                        <h3 class="author-name"><?php echo esc_html(get_the_author()); ?></h3>
                        <p class="author-description"><?php echo wp_kses_post(get_the_author_meta('description')); ?></p>
                        <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>" class="author-link">
                            <?php _e('View all posts', 'spawcoin'); ?>
                        </a>
                    </div>
                </div>
                <?php
            endif;

            // Post navigation
            the_post_navigation(
                array(
                    'prev_text' => '<span class="nav-subtitle">' . esc_html__('Previous:', 'spawcoin') . '</span> <span class="nav-title">%title</span>',
                    'next_text' => '<span class="nav-subtitle">' . esc_html__('Next:', 'spawcoin') . '</span> <span class="nav-title">%title</span>',
                )
            );

            // Comments
            if (comments_open() || get_comments_number()) :
                comments_template();
            endif;

        endwhile;
        ?>
    </div>
</main>

<?php
get_footer();
