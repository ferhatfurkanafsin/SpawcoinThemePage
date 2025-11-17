<?php
/**
 * Custom template tags for this theme
 *
 * @package Spawcoin
 */

if (!function_exists('spawcoin_posted_on')) :
    /**
     * Prints HTML with meta information for the current post-date/time
     */
    function spawcoin_posted_on() {
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

        if (get_the_time('U') !== get_the_modified_time('U')) {
            $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
        }

        $time_string = sprintf(
            $time_string,
            esc_attr(get_the_date(DATE_W3C)),
            esc_html(get_the_date()),
            esc_attr(get_the_modified_date(DATE_W3C)),
            esc_html(get_the_modified_date())
        );

        $posted_on = sprintf(
            esc_html_x('Posted on %s', 'post date', 'spawcoin'),
            '<a href="' . esc_url(get_permalink()) . '" rel="bookmark">' . $time_string . '</a>'
        );

        echo '<span class="posted-on">' . $posted_on . '</span>';
    }
endif;

if (!function_exists('spawcoin_posted_by')) :
    /**
     * Prints HTML with meta information for the current author
     */
    function spawcoin_posted_by() {
        $byline = sprintf(
            esc_html_x('by %s', 'post author', 'spawcoin'),
            '<span class="author vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a></span>'
        );

        echo '<span class="byline"> ' . $byline . '</span>';
    }
endif;

if (!function_exists('spawcoin_entry_footer')) :
    /**
     * Prints HTML with meta information for the categories, tags and comments
     */
    function spawcoin_entry_footer() {
        // Hide category and tag text for pages
        if ('post' === get_post_type()) {
            $categories_list = get_the_category_list(esc_html__(', ', 'spawcoin'));
            if ($categories_list) {
                printf('<span class="cat-links">' . esc_html__('Posted in %1$s', 'spawcoin') . '</span>', $categories_list);
            }

            $tags_list = get_the_tag_list('', esc_html_x(', ', 'list item separator', 'spawcoin'));
            if ($tags_list) {
                printf('<span class="tags-links">' . esc_html__('Tagged %1$s', 'spawcoin') . '</span>', $tags_list);
            }
        }

        if (!is_single() && !post_password_required() && (comments_open() || get_comments_number())) {
            echo '<span class="comments-link">';
            comments_popup_link(
                sprintf(
                    wp_kses(
                        __('Leave a Comment<span class="screen-reader-text"> on %s</span>', 'spawcoin'),
                        array('span' => array('class' => array()))
                    ),
                    wp_kses_post(get_the_title())
                )
            );
            echo '</span>';
        }

        edit_post_link(
            sprintf(
                wp_kses(
                    __('Edit <span class="screen-reader-text">%s</span>', 'spawcoin'),
                    array('span' => array('class' => array()))
                ),
                wp_kses_post(get_the_title())
            ),
            '<span class="edit-link">',
            '</span>'
        );
    }
endif;

if (!function_exists('spawcoin_post_thumbnail')) :
    /**
     * Displays an optional post thumbnail
     */
    function spawcoin_post_thumbnail() {
        if (post_password_required() || is_attachment() || !has_post_thumbnail()) {
            return;
        }

        if (is_singular()) :
            ?>
            <div class="post-thumbnail">
                <?php the_post_thumbnail('spawcoin-featured'); ?>
            </div>
        <?php else : ?>
            <a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
                <?php
                the_post_thumbnail('spawcoin-medium', array(
                    'alt' => the_title_attribute(array('echo' => false)),
                ));
                ?>
            </a>
            <?php
        endif;
    }
endif;

if (!function_exists('spawcoin_get_social_links')) :
    /**
     * Get social media links from customizer
     */
    function spawcoin_get_social_links() {
        $social_networks = array(
            'twitter'  => __('Twitter', 'spawcoin'),
            'discord'  => __('Discord', 'spawcoin'),
            'telegram' => __('Telegram', 'spawcoin'),
            'github'   => __('GitHub', 'spawcoin'),
        );

        $links = array();

        foreach ($social_networks as $network => $label) {
            $url = get_theme_mod('spawcoin_' . $network . '_url', '');
            if (!empty($url)) {
                $links[$network] = array(
                    'url'   => esc_url($url),
                    'label' => $label,
                );
            }
        }

        return $links;
    }
endif;

if (!function_exists('spawcoin_breadcrumb')) :
    /**
     * Display breadcrumb navigation
     */
    function spawcoin_breadcrumb() {
        if (is_front_page()) {
            return;
        }

        echo '<nav class="breadcrumb" aria-label="breadcrumb">';
        echo '<a href="' . esc_url(home_url('/')) . '">' . esc_html__('Home', 'spawcoin') . '</a>';

        if (is_category() || is_single()) {
            echo ' / ';
            the_category(', ');

            if (is_single()) {
                echo ' / ' . get_the_title();
            }
        } elseif (is_page()) {
            echo ' / ' . get_the_title();
        } elseif (is_search()) {
            echo ' / ' . esc_html__('Search Results', 'spawcoin');
        } elseif (is_404()) {
            echo ' / ' . esc_html__('404 Error', 'spawcoin');
        }

        echo '</nav>';
    }
endif;

if (!function_exists('spawcoin_reading_time')) :
    /**
     * Calculate estimated reading time
     */
    function spawcoin_reading_time() {
        $content = get_post_field('post_content', get_the_ID());
        $word_count = str_word_count(strip_tags($content));
        $reading_time = ceil($word_count / 200);

        return sprintf(
            _n('%s min read', '%s mins read', $reading_time, 'spawcoin'),
            number_format_i18n($reading_time)
        );
    }
endif;
