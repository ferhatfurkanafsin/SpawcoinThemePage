# Spawcoin WordPress Theme

![Version](https://img.shields.io/badge/version-1.0.0-blue.svg)
![WordPress](https://img.shields.io/badge/WordPress-6.0%2B-blue.svg)
![License](https://img.shields.io/badge/license-GPL--2.0%2B-green.svg)

A modern, responsive WordPress theme with 3D animations and smooth user experience, specifically designed for Spawcoin cryptocurrency platform.

## 🚀 Features

### Visual & Design
- **3D Animations**: Stunning Three.js powered 3D backgrounds with interactive particle systems
- **Smooth Animations**: GSAP-powered scroll animations and transitions
- **Responsive Design**: Fully responsive and mobile-optimized
- **Modern UI**: Clean, contemporary design with gradient effects
- **Dark Mode**: Beautiful dark color scheme optimized for cryptocurrency platforms

### Performance
- **Optimized Loading**: Lazy loading for images and async/defer script loading
- **Lightweight**: Minimal dependencies with optimized code
- **SEO Friendly**: Clean semantic HTML5 markup with Schema.org support
- **Fast Rendering**: Optimized CSS and JavaScript for quick page loads

### Functionality
- **Custom Post Types**: Portfolio and Testimonials post types
- **Widget Areas**: Multiple widget areas including footer widgets
- **Menu Support**: Primary and footer navigation menus
- **Theme Customizer**: Easy customization through WordPress Customizer
- **Translation Ready**: Fully translatable with .pot file included
- **Accessibility**: WCAG 2.1 compliant with keyboard navigation support

### Plugin Compatibility
- **WooCommerce**: Full WooCommerce support for e-commerce functionality
- **Elementor**: Compatible with Elementor page builder
- **Contact Form 7**: Styled support for popular contact forms
- **Yoast SEO**: Optimized for SEO plugins

## 📋 Requirements

- WordPress 5.0 or higher
- PHP 7.4 or higher
- Modern web browser with JavaScript enabled

## 🔧 Installation

### Method 1: WordPress Admin Panel

1. Download the theme ZIP file
2. Go to WordPress Admin Panel → Appearance → Themes
3. Click "Add New" → "Upload Theme"
4. Choose the ZIP file and click "Install Now"
5. Activate the theme

### Method 2: Manual Installation

1. Download and extract the theme files
2. Upload the `spawcoin` folder to `/wp-content/themes/`
3. Go to WordPress Admin Panel → Appearance → Themes
4. Find "Spawcoin" and click "Activate"

## ⚙️ Configuration

### Initial Setup

1. **Set Permalinks**: Go to Settings → Permalinks and choose "Post name"
2. **Create Menus**: Go to Appearance → Menus and create your navigation menus
3. **Configure Theme**: Go to Appearance → Customize to customize colors, hero section, and social links
4. **Add Widgets**: Go to Appearance → Widgets to populate footer widget areas

### Customization Options

Navigate to **Appearance → Customize** to access:

- **Site Identity**: Logo, site title, and favicon
- **Theme Colors**: Primary, secondary, and accent colors
- **Hero Section**: Customize hero title, subtitle, and button text/URL
- **Social Links**: Add Twitter, Discord, Telegram, and GitHub URLs
- **Footer Settings**: Customize copyright text
- **Menus**: Assign menus to theme locations
- **Widgets**: Configure sidebar and footer widgets

## 📄 Page Templates

The theme includes several page templates:

- **Front Page** (`front-page.php`): Feature-rich homepage with hero section, features, stats, and blog
- **Default Page** (`page.php`): Standard page template
- **Single Post** (`single.php`): Individual blog post layout with author bio
- **Blog Index** (`index.php`): Blog listing page
- **404 Page** (`404.php`): Custom error page
- **Search Results** (`search.php`): Search results layout

## 🎨 Customization

### Custom Colors

The theme uses CSS custom properties (CSS variables) for easy color customization:

```css
:root {
  --color-primary: #6366f1;
  --color-secondary: #ec4899;
  --color-accent: #14b8a6;
}
```

You can customize these through the WordPress Customizer or by adding custom CSS.

### Adding Custom Fonts

The theme uses Google Fonts (Inter, Outfit, JetBrains Mono). To change fonts, edit the font import in `functions.php`:

```php
wp_enqueue_style('spawcoin-fonts',
    'https://fonts.googleapis.com/css2?family=YourFont:wght@400;700&display=swap',
    array(),
    null
);
```

### Modifying 3D Animations

Edit `/assets/js/three-scene.js` to customize:
- Particle count and behavior
- Geometric shapes
- Colors and lighting
- Animation speed

## 🔌 Plugin Recommendations

### Essential Plugins
- **Yoast SEO** or **Rank Math**: For SEO optimization
- **WP Rocket** or **W3 Total Cache**: For performance optimization
- **Wordfence Security**: For security
- **Contact Form 7**: For contact forms

### Optional Plugins
- **WooCommerce**: For e-commerce functionality
- **Elementor**: For advanced page building
- **Advanced Custom Fields (ACF)**: For custom fields
- **WP Mail SMTP**: For reliable email delivery

## 🛠️ Development

### File Structure

```
spawcoin/
├── assets/
│   ├── css/
│   ├── js/
│   │   ├── three-scene.js      # 3D animations
│   │   ├── animations.js       # GSAP animations
│   │   └── main.js            # Main functionality
│   ├── images/
│   └── fonts/
├── inc/
│   ├── customizer.php         # Theme customizer
│   ├── template-tags.php      # Custom template tags
│   └── template-functions.php # Helper functions
├── template-parts/
│   └── content.php            # Content templates
├── style.css                  # Main stylesheet
├── functions.php              # Theme functions
├── header.php                 # Header template
├── footer.php                 # Footer template
├── index.php                  # Main template
├── front-page.php             # Front page template
├── single.php                 # Single post template
├── page.php                   # Page template
├── 404.php                    # 404 error template
├── search.php                 # Search template
└── README.md                  # This file
```

### Building Custom Features

#### Adding Custom Post Types

Edit `functions.php` to add new custom post types:

```php
register_post_type('your_post_type', array(
    'labels' => array(
        'name' => __('Your Post Type', 'spawcoin'),
    ),
    'public' => true,
    'show_in_rest' => true,
));
```

#### Adding Widget Areas

Add new widget areas in `functions.php`:

```php
register_sidebar(array(
    'name'          => __('Your Widget Area', 'spawcoin'),
    'id'            => 'your-widget-area',
    'before_widget' => '<div class="widget %2$s">',
    'after_widget'  => '</div>',
));
```

## 🐛 Troubleshooting

### 3D Animations Not Working

1. Check browser console for JavaScript errors
2. Ensure Three.js is loading correctly
3. Verify canvas element exists on the page
4. Check browser compatibility (requires WebGL support)

### Styling Issues

1. Clear browser cache
2. Clear WordPress cache (if using caching plugin)
3. Check for plugin conflicts by deactivating plugins
4. Verify theme files are uploaded correctly

### Performance Issues

1. Optimize images (use WebP format)
2. Enable caching plugin
3. Minify CSS and JavaScript
4. Use a CDN for static assets
5. Consider reducing particle count in Three.js scene

## 🔒 Security

The theme includes several security features:

- **No version info**: WordPress version removed from headers
- **XML-RPC disabled**: Reduces attack surface
- **Sanitized inputs**: All user inputs are sanitized
- **Escaped outputs**: All outputs are properly escaped
- **Nonce verification**: AJAX requests use nonce verification

## 📱 Browser Support

- Chrome (last 2 versions)
- Firefox (last 2 versions)
- Safari (last 2 versions)
- Edge (last 2 versions)
- Mobile browsers (iOS Safari, Chrome Mobile)

## 🤝 Contributing

Contributions are welcome! Please follow these guidelines:

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## 📝 Changelog

### Version 1.0.0 (2025-11-17)
- Initial release
- Three.js 3D animations
- GSAP scroll animations
- Responsive design
- WordPress Customizer integration
- WooCommerce compatibility
- Elementor support

## 📄 License

This theme is licensed under the GNU General Public License v2 or later.

## 👨‍💻 Credits

### Libraries & Frameworks
- [Three.js](https://threejs.org/) - 3D graphics library
- [GSAP](https://greensock.com/gsap/) - Animation library
- [WordPress](https://wordpress.org/) - Content management system

### Fonts
- [Inter](https://fonts.google.com/specimen/Inter) - Google Fonts
- [Outfit](https://fonts.google.com/specimen/Outfit) - Google Fonts
- [JetBrains Mono](https://fonts.google.com/specimen/JetBrains+Mono) - Google Fonts

## 📞 Support

For support, please:

1. Check the documentation above
2. Search existing issues
3. Create a new issue with detailed information
4. Contact the theme developer

## 🌟 Features Coming Soon

- [ ] More page templates
- [ ] Additional animation options
- [ ] Theme options panel
- [ ] More customizer controls
- [ ] RTL language support
- [ ] Additional post formats
- [ ] Integration with more plugins

---

**Made with ❤️ for the Spawcoin community**
