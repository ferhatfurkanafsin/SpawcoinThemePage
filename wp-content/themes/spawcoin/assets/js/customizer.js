/**
 * Customizer live preview
 *
 * @package Spawcoin
 */

(function($) {
    'use strict';

    // Site title
    wp.customize('blogname', function(value) {
        value.bind(function(to) {
            $('.site-logo').text(to);
        });
    });

    // Site description
    wp.customize('blogdescription', function(value) {
        value.bind(function(to) {
            $('.hero-subtitle').text(to);
        });
    });

    // Primary color
    wp.customize('spawcoin_primary_color', function(value) {
        value.bind(function(to) {
            document.documentElement.style.setProperty('--color-primary', to);
        });
    });

    // Secondary color
    wp.customize('spawcoin_secondary_color', function(value) {
        value.bind(function(to) {
            document.documentElement.style.setProperty('--color-secondary', to);
        });
    });

    // Accent color
    wp.customize('spawcoin_accent_color', function(value) {
        value.bind(function(to) {
            document.documentElement.style.setProperty('--color-accent', to);
        });
    });

    // Hero title
    wp.customize('spawcoin_hero_title', function(value) {
        value.bind(function(to) {
            $('.hero-title').text(to);
        });
    });

    // Hero subtitle
    wp.customize('spawcoin_hero_subtitle', function(value) {
        value.bind(function(to) {
            $('.hero-subtitle').text(to);
        });
    });

})(jQuery);
