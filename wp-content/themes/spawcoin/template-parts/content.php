<?php
/**
 * Template part for displaying posts
 *
 * @package Spawcoin
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('card'); ?>>
    <?php spawcoin_post_thumbnail(); ?>

    <header class="entry-header">
        <?php
        if (is_singular()) :
            the_title('<h1 class="entry-title">', '</h1>');
        else :
            the_title('<h3 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h3>');
        endif;
        ?>

        <?php if ('post' === get_post_type()) : ?>
            <div class="entry-meta">
                <?php
                spawcoin_posted_on();
                spawcoin_posted_by();
                ?>
            </div>
        <?php endif; ?>
    </header>

    <div class="entry-content">
        <?php
        if (is_singular()) :
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
        else :
            the_excerpt();
        ?>
            <a href="<?php the_permalink(); ?>" class="btn btn-primary">
                <?php esc_html_e('Read More', 'spawcoin'); ?>
            </a>
            <?php
        endif;
        ?>
    </div>

    <?php if (!is_singular()) : ?>
        <footer class="entry-footer">
            <?php spawcoin_entry_footer(); ?>
        </footer>
    <?php endif; ?>
</article>
