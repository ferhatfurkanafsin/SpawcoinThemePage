<?php
/**
 * The front page template file
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
                <?php echo esc_html(get_theme_mod('spawcoin_hero_title', get_bloginfo('name'))); ?>
            </h1>

            <p class="hero-subtitle">
                <?php echo esc_html(get_theme_mod('spawcoin_hero_subtitle', get_bloginfo('description'))); ?>
            </p>

            <div class="hero-buttons">
                <a href="<?php echo esc_url(get_theme_mod('spawcoin_hero_button_url', '#features')); ?>" class="btn btn-primary">
                    <?php echo esc_html(get_theme_mod('spawcoin_hero_button_text', __('Get Started', 'spawcoin'))); ?>
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
                <?php esc_html_e('Why Choose Spawcoin?', 'spawcoin'); ?>
            </h2>

            <div class="grid grid-3">
                <div class="card">
                    <div class="card-icon">🚀</div>
                    <h3 class="card-title"><?php esc_html_e('Lightning Fast', 'spawcoin'); ?></h3>
                    <p class="card-description">
                        <?php esc_html_e('Experience instant transactions with our cutting-edge blockchain technology.', 'spawcoin'); ?>
                    </p>
                </div>

                <div class="card">
                    <div class="card-icon">🔒</div>
                    <h3 class="card-title"><?php esc_html_e('Secure & Private', 'spawcoin'); ?></h3>
                    <p class="card-description">
                        <?php esc_html_e('Bank-level security ensures your assets and data are always protected.', 'spawcoin'); ?>
                    </p>
                </div>

                <div class="card">
                    <div class="card-icon">🌍</div>
                    <h3 class="card-title"><?php esc_html_e('Global Network', 'spawcoin'); ?></h3>
                    <p class="card-description">
                        <?php esc_html_e('Trade anywhere in the world with our decentralized global network.', 'spawcoin'); ?>
                    </p>
                </div>

                <div class="card">
                    <div class="card-icon">💎</div>
                    <h3 class="card-title"><?php esc_html_e('Low Fees', 'spawcoin'); ?></h3>
                    <p class="card-description">
                        <?php esc_html_e('Enjoy minimal transaction fees compared to traditional payment systems.', 'spawcoin'); ?>
                    </p>
                </div>

                <div class="card">
                    <div class="card-icon">🤝</div>
                    <h3 class="card-title"><?php esc_html_e('Community Driven', 'spawcoin'); ?></h3>
                    <p class="card-description">
                        <?php esc_html_e('Join thousands of users building the future of finance together.', 'spawcoin'); ?>
                    </p>
                </div>

                <div class="card">
                    <div class="card-icon">📈</div>
                    <h3 class="card-title"><?php esc_html_e('Growth Potential', 'spawcoin'); ?></h3>
                    <p class="card-description">
                        <?php esc_html_e('Get in early and benefit from the growing cryptocurrency market.', 'spawcoin'); ?>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section id="stats" class="section stats">
        <div class="container">
            <div class="grid grid-3">
                <div class="stat-item text-center">
                    <div class="stat-number" data-counter="50000">0</div>
                    <div class="stat-label"><?php esc_html_e('Active Users', 'spawcoin'); ?></div>
                </div>

                <div class="stat-item text-center">
                    <div class="stat-number" data-counter="1000000">0</div>
                    <div class="stat-label"><?php esc_html_e('Transactions', 'spawcoin'); ?></div>
                </div>

                <div class="stat-item text-center">
                    <div class="stat-number" data-counter="100">0</div>
                    <div class="stat-label"><?php esc_html_e('Countries', 'spawcoin'); ?></div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="section about">
        <div class="container">
            <div class="grid grid-2">
                <div class="about-content">
                    <h2><?php esc_html_e('About Spawcoin', 'spawcoin'); ?></h2>
                    <p>
                        <?php esc_html_e('Spawcoin is a revolutionary cryptocurrency designed for the future of digital finance. Built on cutting-edge blockchain technology, we provide fast, secure, and affordable transactions for users worldwide.', 'spawcoin'); ?>
                    </p>
                    <p>
                        <?php esc_html_e('Our mission is to make cryptocurrency accessible to everyone, from beginners to experienced traders. Join us in building the future of decentralized finance.', 'spawcoin'); ?>
                    </p>
                    <a href="#" class="btn btn-primary">
                        <?php esc_html_e('Read Our Whitepaper', 'spawcoin'); ?>
                    </a>
                </div>

                <div class="about-image animate-float">
                    <div class="card">
                        <div style="width: 100%; height: 300px; background: linear-gradient(135deg, var(--color-primary), var(--color-secondary)); border-radius: var(--radius-lg);"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php
    // Display recent blog posts
    $recent_posts = new WP_Query(array(
        'posts_per_page' => 3,
        'post_status'    => 'publish',
    ));

    if ($recent_posts->have_posts()) :
        ?>
        <section id="blog" class="section blog">
            <div class="container">
                <h2 class="section-title text-center">
                    <?php esc_html_e('Latest Updates', 'spawcoin'); ?>
                </h2>

                <div class="grid grid-3">
                    <?php
                    while ($recent_posts->have_posts()) :
                        $recent_posts->the_post();
                        ?>
                        <article <?php post_class('card'); ?>>
                            <?php if (has_post_thumbnail()) : ?>
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('spawcoin-medium'); ?>
                                </a>
                            <?php endif; ?>

                            <h3 class="card-title">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_title(); ?>
                                </a>
                            </h3>

                            <div class="card-description">
                                <?php the_excerpt(); ?>
                            </div>

                            <a href="<?php the_permalink(); ?>" class="btn btn-secondary">
                                <?php esc_html_e('Read More', 'spawcoin'); ?>
                            </a>
                        </article>
                        <?php
                    endwhile;
                    wp_reset_postdata();
                    ?>
                </div>
            </div>
        </section>
        <?php
    endif;
    ?>

    <!-- Call to Action -->
    <section class="section cta">
        <div class="container text-center">
            <h2 class="text-gradient">
                <?php esc_html_e('Ready to Get Started?', 'spawcoin'); ?>
            </h2>
            <p class="mt-2 mb-4">
                <?php esc_html_e('Join thousands of users already using Spawcoin. Create your wallet today.', 'spawcoin'); ?>
            </p>
            <a href="#signup" class="btn btn-primary">
                <?php esc_html_e('Create Your Wallet', 'spawcoin'); ?>
            </a>
        </div>
    </section>

</main>

<?php
get_footer();
