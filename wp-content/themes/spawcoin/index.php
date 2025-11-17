<?php
/**
 * The main template file
 *
 * @package Spawcoin
 */

get_header();
?>

<main id="primary" class="site-main">

    <!-- Hero Section with 3D Background -->
    <section class="hero">
        <canvas id="three-canvas"></canvas>
        <div class="hero-content">
            <h1 class="hero-title">
                <?php
                if (is_front_page() && is_home()) :
                    bloginfo('name');
                elseif (is_front_page()) :
                    bloginfo('name');
                elseif (is_home()) :
                    single_post_title();
                else :
                    the_title();
                endif;
                ?>
            </h1>

            <p class="hero-subtitle">
                <?php
                if (is_front_page()) :
                    bloginfo('description');
                else :
                    esc_html_e('Discover the future of cryptocurrency', 'spawcoin');
                endif;
                ?>
            </p>

            <div class="hero-buttons">
                <a href="#features" class="btn btn-primary">
                    <?php esc_html_e('Get Started', 'spawcoin'); ?>
                </a>
                <a href="#about" class="btn btn-secondary">
                    <?php esc_html_e('Learn More', 'spawcoin'); ?>
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="section features">
        <div class="container">
            <h2 class="section-title text-center">
                <?php esc_html_e('Features', 'spawcoin'); ?>
            </h2>

            <div class="grid grid-3">
                <div class="card animate-on-scroll">
                    <div class="card-icon">🚀</div>
                    <h3 class="card-title"><?php esc_html_e('Fast Transactions', 'spawcoin'); ?></h3>
                    <p class="card-description">
                        <?php esc_html_e('Lightning-fast blockchain technology ensures instant transactions with minimal fees.', 'spawcoin'); ?>
                    </p>
                </div>

                <div class="card animate-on-scroll">
                    <div class="card-icon">🔒</div>
                    <h3 class="card-title"><?php esc_html_e('Secure & Private', 'spawcoin'); ?></h3>
                    <p class="card-description">
                        <?php esc_html_e('Military-grade encryption keeps your assets safe and your transactions private.', 'spawcoin'); ?>
                    </p>
                </div>

                <div class="card animate-on-scroll">
                    <div class="card-icon">🌍</div>
                    <h3 class="card-title"><?php esc_html_e('Global Access', 'spawcoin'); ?></h3>
                    <p class="card-description">
                        <?php esc_html_e('Trade and transact anywhere in the world with our decentralized network.', 'spawcoin'); ?>
                    </p>
                </div>

                <div class="card animate-on-scroll">
                    <div class="card-icon">💎</div>
                    <h3 class="card-title"><?php esc_html_e('Low Fees', 'spawcoin'); ?></h3>
                    <p class="card-description">
                        <?php esc_html_e('Enjoy minimal transaction fees compared to traditional payment methods.', 'spawcoin'); ?>
                    </p>
                </div>

                <div class="card animate-on-scroll">
                    <div class="card-icon">🤝</div>
                    <h3 class="card-title"><?php esc_html_e('Community Driven', 'spawcoin'); ?></h3>
                    <p class="card-description">
                        <?php esc_html_e('Join a thriving community of users and developers shaping the future.', 'spawcoin'); ?>
                    </p>
                </div>

                <div class="card animate-on-scroll">
                    <div class="card-icon">📈</div>
                    <h3 class="card-title"><?php esc_html_e('Growth Potential', 'spawcoin'); ?></h3>
                    <p class="card-description">
                        <?php esc_html_e('Early adoption opportunities with significant growth potential.', 'spawcoin'); ?>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <?php if (have_posts()) : ?>

        <!-- Blog Section -->
        <section id="blog" class="section blog">
            <div class="container">
                <h2 class="section-title text-center">
                    <?php
                    if (is_home() && !is_front_page()) :
                        single_post_title();
                    else :
                        esc_html_e('Latest Updates', 'spawcoin');
                    endif;
                    ?>
                </h2>

                <div class="grid grid-2">
                    <?php
                    while (have_posts()) :
                        the_post();
                        ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class('card'); ?>>
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="post-thumbnail">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('spawcoin-medium'); ?>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <header class="entry-header">
                                <?php
                                if (is_singular()) :
                                    the_title('<h1 class="entry-title">', '</h1>');
                                else :
                                    the_title('<h3 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h3>');
                                endif;
                                ?>

                                <div class="entry-meta">
                                    <span class="posted-on">
                                        <time class="entry-date published" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                            <?php echo esc_html(get_the_date()); ?>
                                        </time>
                                    </span>
                                    <span class="byline">
                                        <?php esc_html_e('by', 'spawcoin'); ?>
                                        <span class="author vcard">
                                            <a class="url fn n" href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                                                <?php echo esc_html(get_the_author()); ?>
                                            </a>
                                        </span>
                                    </span>
                                </div>
                            </header>

                            <div class="entry-content">
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
                    'prev_text' => __('&larr; Older posts', 'spawcoin'),
                    'next_text' => __('Newer posts &rarr;', 'spawcoin'),
                ));
                ?>
            </div>
        </section>

    <?php
    else :
        ?>
        <section class="section no-results">
            <div class="container">
                <h2><?php esc_html_e('Nothing Found', 'spawcoin'); ?></h2>
                <p><?php esc_html_e('It seems we can\'t find what you\'re looking for.', 'spawcoin'); ?></p>
                <?php get_search_form(); ?>
            </div>
        </section>
        <?php
    endif;
    ?>

    <!-- Call to Action Section -->
    <section class="section cta">
        <div class="container text-center">
            <h2 class="text-gradient">
                <?php esc_html_e('Ready to Get Started?', 'spawcoin'); ?>
            </h2>
            <p class="mt-2 mb-4">
                <?php esc_html_e('Join thousands of users already using Spawcoin', 'spawcoin'); ?>
            </p>
            <a href="#signup" class="btn btn-primary">
                <?php esc_html_e('Create Your Wallet', 'spawcoin'); ?>
            </a>
        </div>
    </section>

</main>

<?php
get_footer();
