/**
 * Main JavaScript for Spawcoin Theme
 * Handles general functionality, mobile menu, and interactive features
 */

(function($) {
    'use strict';

    /**
     * Mobile Menu Toggle
     */
    const initMobileMenu = () => {
        const menuToggle = $('.menu-toggle');
        const navigation = $('.main-navigation');

        menuToggle.on('click', function(e) {
            e.preventDefault();
            $(this).toggleClass('active');
            navigation.toggleClass('active');

            const expanded = $(this).attr('aria-expanded') === 'true';
            $(this).attr('aria-expanded', !expanded);
        });

        // Close menu when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.site-header').length) {
                menuToggle.removeClass('active');
                navigation.removeClass('active');
                menuToggle.attr('aria-expanded', 'false');
            }
        });

        // Close menu on escape key
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape' && navigation.hasClass('active')) {
                menuToggle.removeClass('active');
                navigation.removeClass('active');
                menuToggle.attr('aria-expanded', 'false');
            }
        });
    };

    /**
     * Scroll to Top Button
     */
    const initScrollToTop = () => {
        // Create button if it doesn't exist
        if (!$('#scroll-to-top').length) {
            $('body').append('<button id="scroll-to-top" class="scroll-to-top" aria-label="Scroll to top">↑</button>');
        }

        const scrollBtn = $('#scroll-to-top');

        // Show/hide button based on scroll position
        $(window).on('scroll', function() {
            if ($(this).scrollTop() > 300) {
                scrollBtn.addClass('visible');
            } else {
                scrollBtn.removeClass('visible');
            }
        });

        // Scroll to top on click
        scrollBtn.on('click', function(e) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: 0
            }, 600);
        });
    };

    /**
     * Add CSS for scroll-to-top button
     */
    const addScrollToTopStyles = () => {
        if (!$('#scroll-to-top-styles').length) {
            const styles = `
                <style id="scroll-to-top-styles">
                    .scroll-to-top {
                        position: fixed;
                        bottom: 2rem;
                        right: 2rem;
                        width: 50px;
                        height: 50px;
                        background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));
                        color: var(--color-light);
                        border: none;
                        border-radius: var(--radius-lg);
                        font-size: 1.5rem;
                        cursor: pointer;
                        opacity: 0;
                        visibility: hidden;
                        transform: translateY(20px);
                        transition: all var(--transition-base);
                        z-index: 999;
                        box-shadow: var(--shadow-xl);
                    }
                    .scroll-to-top.visible {
                        opacity: 1;
                        visibility: visible;
                        transform: translateY(0);
                    }
                    .scroll-to-top:hover {
                        transform: translateY(-5px);
                        box-shadow: 0 0 30px rgba(99, 102, 241, 0.5);
                    }
                    @media (max-width: 768px) {
                        .scroll-to-top {
                            bottom: 1rem;
                            right: 1rem;
                            width: 40px;
                            height: 40px;
                            font-size: 1.2rem;
                        }
                    }
                </style>
            `;
            $('head').append(styles);
        }
    };

    /**
     * Smooth Scroll for Anchor Links (fallback for non-GSAP)
     */
    const initSmoothScroll = () => {
        if (typeof gsap === 'undefined') {
            $('a[href^="#"]').on('click', function(e) {
                const href = $(this).attr('href');

                if (href === '#' || href === '#!') {
                    return;
                }

                const target = $(href);

                if (target.length) {
                    e.preventDefault();

                    $('html, body').animate({
                        scrollTop: target.offset().top - 80
                    }, 800);
                }
            });
        }
    };

    /**
     * Lazy Load Images (native loading)
     */
    const initLazyLoad = () => {
        const images = document.querySelectorAll('img:not([loading])');

        images.forEach(img => {
            img.setAttribute('loading', 'lazy');
        });
    };

    /**
     * Form Validation
     */
    const initFormValidation = () => {
        $('form').on('submit', function(e) {
            let isValid = true;
            const form = $(this);

            // Remove previous error messages
            form.find('.error-message').remove();

            // Check required fields
            form.find('[required]').each(function() {
                const field = $(this);
                const value = field.val().trim();

                if (!value) {
                    isValid = false;
                    field.addClass('error');
                    field.after('<span class="error-message">This field is required</span>');
                } else {
                    field.removeClass('error');
                }
            });

            // Email validation
            form.find('[type="email"]').each(function() {
                const field = $(this);
                const value = field.val().trim();
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                if (value && !emailRegex.test(value)) {
                    isValid = false;
                    field.addClass('error');
                    field.after('<span class="error-message">Please enter a valid email</span>');
                }
            });

            if (!isValid) {
                e.preventDefault();
            }
        });
    };

    /**
     * Accessibility Enhancements
     */
    const initAccessibility = () => {
        // Add skip link functionality
        $('.skip-link').on('click', function(e) {
            const target = $($(this).attr('href'));

            if (target.length) {
                e.preventDefault();
                target.attr('tabindex', '-1').focus();

                $('html, body').animate({
                    scrollTop: target.offset().top
                }, 300);
            }
        });

        // Improve keyboard navigation for dropdown menus
        $('.menu-item-has-children > a').on('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                $(this).next('.sub-menu').toggleClass('active');
            }
        });
    };

    /**
     * Dynamic Year in Footer
     */
    const updateFooterYear = () => {
        const currentYear = new Date().getFullYear();
        $('.footer-bottom').find('p').first().html(function(i, html) {
            return html.replace(/&copy; \d{4}/, '&copy; ' + currentYear);
        });
    };

    /**
     * AJAX Load More for Blog Posts
     */
    const initLoadMore = () => {
        if (typeof spawcoinData === 'undefined') {
            return;
        }

        let page = 2;

        $(document).on('click', '.load-more', function(e) {
            e.preventDefault();

            const button = $(this);
            const container = $('.blog .grid');

            button.text('Loading...').prop('disabled', true);

            $.ajax({
                url: spawcoinData.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'load_more_posts',
                    page: page,
                    nonce: spawcoinData.nonce
                },
                success: function(response) {
                    if (response.success && response.data.html) {
                        container.append(response.data.html);
                        page++;

                        if (!response.data.has_more) {
                            button.remove();
                        } else {
                            button.text('Load More').prop('disabled', false);
                        }

                        // Refresh ScrollTrigger if available
                        if (typeof ScrollTrigger !== 'undefined') {
                            ScrollTrigger.refresh();
                        }
                    } else {
                        button.remove();
                    }
                },
                error: function() {
                    button.text('Error loading posts').prop('disabled', true);
                }
            });
        });
    };

    /**
     * Initialize Tooltips
     */
    const initTooltips = () => {
        $('[data-tooltip]').each(function() {
            const element = $(this);
            const text = element.data('tooltip');

            element.on('mouseenter', function() {
                const tooltip = $('<div class="tooltip"></div>').text(text);
                $('body').append(tooltip);

                const pos = element.offset();
                tooltip.css({
                    top: pos.top - tooltip.outerHeight() - 10,
                    left: pos.left + (element.outerWidth() / 2) - (tooltip.outerWidth() / 2)
                });
            });

            element.on('mouseleave', function() {
                $('.tooltip').remove();
            });
        });
    };

    /**
     * Initialize everything when DOM is ready
     */
    $(document).ready(function() {
        initMobileMenu();
        addScrollToTopStyles();
        initScrollToTop();
        initSmoothScroll();
        initLazyLoad();
        initFormValidation();
        initAccessibility();
        updateFooterYear();
        initLoadMore();
        initTooltips();

        // Add loaded class to body
        $('body').addClass('loaded');

        console.log('Spawcoin Theme initialized successfully');
    });

    /**
     * Window load event
     */
    $(window).on('load', function() {
        // Hide preloader if exists
        $('.preloader').fadeOut();

        // Recalculate any dynamic heights
        $(window).trigger('resize');
    });

})(jQuery);
