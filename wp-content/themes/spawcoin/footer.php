    </div><!-- #content -->

    <footer id="colophon" class="site-footer">
        <div class="container">
            <div class="footer-content">
                <?php if (is_active_sidebar('footer-1')) : ?>
                    <div class="footer-section">
                        <?php dynamic_sidebar('footer-1'); ?>
                    </div>
                <?php else : ?>
                    <div class="footer-section">
                        <h3><?php esc_html_e('About Spawcoin', 'spawcoin'); ?></h3>
                        <p><?php bloginfo('description'); ?></p>
                    </div>
                <?php endif; ?>

                <?php if (is_active_sidebar('footer-2')) : ?>
                    <div class="footer-section">
                        <?php dynamic_sidebar('footer-2'); ?>
                    </div>
                <?php else : ?>
                    <div class="footer-section">
                        <h3><?php esc_html_e('Quick Links', 'spawcoin'); ?></h3>
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'footer',
                            'menu_id'        => 'footer-menu',
                            'container'      => false,
                            'fallback_cb'    => false,
                        ));
                        ?>
                    </div>
                <?php endif; ?>

                <?php if (is_active_sidebar('footer-3')) : ?>
                    <div class="footer-section">
                        <?php dynamic_sidebar('footer-3'); ?>
                    </div>
                <?php else : ?>
                    <div class="footer-section">
                        <h3><?php esc_html_e('Connect', 'spawcoin'); ?></h3>
                        <ul>
                            <li><a href="#" target="_blank" rel="noopener"><?php esc_html_e('Twitter', 'spawcoin'); ?></a></li>
                            <li><a href="#" target="_blank" rel="noopener"><?php esc_html_e('Discord', 'spawcoin'); ?></a></li>
                            <li><a href="#" target="_blank" rel="noopener"><?php esc_html_e('Telegram', 'spawcoin'); ?></a></li>
                            <li><a href="#" target="_blank" rel="noopener"><?php esc_html_e('GitHub', 'spawcoin'); ?></a></li>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>

            <div class="footer-bottom">
                <p>
                    &copy; <?php echo date('Y'); ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>">
                        <?php bloginfo('name'); ?>
                    </a>
                    <?php esc_html_e('| All rights reserved', 'spawcoin'); ?>
                </p>
                <p>
                    <?php
                    printf(
                        esc_html__('Powered by %1$s | Theme: %2$s', 'spawcoin'),
                        '<a href="https://wordpress.org/" target="_blank" rel="noopener">WordPress</a>',
                        '<a href="https://spawcoin.com" target="_blank" rel="noopener">Spawcoin</a>'
                    );
                    ?>
                </p>
            </div>
        </div>
    </footer>
</div><!-- #page -->

<?php wp_footer(); ?>

<!-- Scroll to top button -->
<button id="scroll-to-top" class="scroll-to-top" aria-label="<?php esc_attr_e('Scroll to top', 'spawcoin'); ?>">
    ↑
</button>

</body>
</html>
