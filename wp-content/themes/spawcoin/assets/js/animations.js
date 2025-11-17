/**
 * GSAP Animations for Spawcoin Theme
 * Handles scroll-based animations and smooth transitions
 */

(function() {
    'use strict';

    // Wait for GSAP and ScrollTrigger to be ready
    if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') {
        console.warn('GSAP or ScrollTrigger not loaded yet');
        return;
    }

    // Register ScrollTrigger plugin
    gsap.registerPlugin(ScrollTrigger);

    // Initialize on DOM ready
    const init = () => {
        // Animate cards on scroll
        const cards = document.querySelectorAll('.card, .animate-on-scroll');

        cards.forEach((card, index) => {
            gsap.from(card, {
                scrollTrigger: {
                    trigger: card,
                    start: 'top 80%',
                    end: 'top 20%',
                    toggleActions: 'play none none reverse',
                },
                y: 50,
                opacity: 0,
                duration: 0.8,
                delay: index * 0.1,
                ease: 'power3.out'
            });
        });

        // Parallax effect for sections
        const sections = document.querySelectorAll('.section');

        sections.forEach(section => {
            gsap.from(section, {
                scrollTrigger: {
                    trigger: section,
                    start: 'top bottom',
                    end: 'bottom top',
                    scrub: 1,
                },
                y: 100,
                ease: 'none'
            });
        });

        // Animate hero content
        const heroTitle = document.querySelector('.hero-title');
        const heroSubtitle = document.querySelector('.hero-subtitle');
        const heroButtons = document.querySelector('.hero-buttons');

        if (heroTitle) {
            gsap.from(heroTitle, {
                y: 50,
                opacity: 0,
                duration: 1,
                delay: 0.2,
                ease: 'power3.out'
            });
        }

        if (heroSubtitle) {
            gsap.from(heroSubtitle, {
                y: 50,
                opacity: 0,
                duration: 1,
                delay: 0.4,
                ease: 'power3.out'
            });
        }

        if (heroButtons) {
            gsap.from(heroButtons, {
                y: 50,
                opacity: 0,
                duration: 1,
                delay: 0.6,
                ease: 'power3.out'
            });
        }

        // Header scroll effect
        const header = document.querySelector('.site-header');

        if (header) {
            ScrollTrigger.create({
                start: 'top -80',
                end: 99999,
                toggleClass: {
                    className: 'scrolled',
                    targets: header
                }
            });
        }

        // Smooth scroll for anchor links
        const anchorLinks = document.querySelectorAll('a[href^="#"]');

        anchorLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                const href = link.getAttribute('href');

                if (href === '#' || href === '#!') {
                    return;
                }

                const target = document.querySelector(href);

                if (target) {
                    e.preventDefault();

                    gsap.to(window, {
                        duration: 1,
                        scrollTo: {
                            y: target,
                            offsetY: 80
                        },
                        ease: 'power3.inOut'
                    });
                }
            });
        });

        // Text reveal animation
        const textElements = document.querySelectorAll('.section-title');

        textElements.forEach(element => {
            gsap.from(element, {
                scrollTrigger: {
                    trigger: element,
                    start: 'top 85%',
                    toggleActions: 'play none none reverse',
                },
                opacity: 0,
                y: 30,
                duration: 0.8,
                ease: 'power3.out'
            });
        });

        // Stagger animation for grids
        const grids = document.querySelectorAll('.grid');

        grids.forEach(grid => {
            const items = grid.querySelectorAll('.card');

            gsap.from(items, {
                scrollTrigger: {
                    trigger: grid,
                    start: 'top 80%',
                    toggleActions: 'play none none reverse',
                },
                y: 50,
                opacity: 0,
                duration: 0.6,
                stagger: 0.15,
                ease: 'power3.out'
            });
        });

        // Image lazy load animation
        const images = document.querySelectorAll('img[loading="lazy"]');

        images.forEach(img => {
            img.addEventListener('load', () => {
                gsap.from(img, {
                    opacity: 0,
                    scale: 0.9,
                    duration: 0.6,
                    ease: 'power2.out'
                });
            });
        });

        // Counter animation
        const counters = document.querySelectorAll('[data-counter]');

        counters.forEach(counter => {
            const target = parseInt(counter.getAttribute('data-counter'));
            const obj = { val: 0 };

            gsap.to(obj, {
                scrollTrigger: {
                    trigger: counter,
                    start: 'top 80%',
                    toggleActions: 'play none none none',
                },
                val: target,
                duration: 2,
                ease: 'power2.out',
                onUpdate: function() {
                    counter.textContent = Math.ceil(obj.val);
                }
            });
        });

        // Hover animations for buttons
        const buttons = document.querySelectorAll('.btn');

        buttons.forEach(btn => {
            btn.addEventListener('mouseenter', () => {
                gsap.to(btn, {
                    scale: 1.05,
                    duration: 0.3,
                    ease: 'power2.out'
                });
            });

            btn.addEventListener('mouseleave', () => {
                gsap.to(btn, {
                    scale: 1,
                    duration: 0.3,
                    ease: 'power2.out'
                });
            });
        });

        // Refresh ScrollTrigger after images load
        window.addEventListener('load', () => {
            ScrollTrigger.refresh();
        });
    };

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

})();
