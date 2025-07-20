<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    
    <!-- Preconnect to Google Fonts for better performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- Meta tags for better SEO -->
    <meta name="description" content="<?php echo get_bloginfo('description'); ?>">
    <meta name="keywords" content="<?php _e('music, artist, singer, songwriter, album, songs', 'artist-music-pro'); ?>">
    
    <!-- Open Graph Meta Tags for social sharing -->
    <meta property="og:title" content="<?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?>">
    <meta property="og:description" content="<?php echo get_bloginfo('description'); ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo home_url(); ?>">
    <meta property="og:image" content="<?php echo get_template_directory_uri(); ?>/assets/images/og-image.jpg">
    
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?>">
    <meta name="twitter:description" content="<?php echo get_bloginfo('description'); ?>">
    <meta name="twitter:image" content="<?php echo get_template_directory_uri(); ?>/assets/images/og-image.jpg">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?> <?php echo is_rtl() ? 'dir="rtl"' : 'dir="ltr"'; ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#primary"><?php _e('Skip to content', 'artist-music-pro'); ?></a>

    <header id="masthead" class="site-header" role="banner">
        <div class="container">
            <div class="header-content">
                <!-- Site Logo/Branding -->
                <div class="site-branding">
                    <?php if (has_custom_logo()) : ?>
                        <div class="site-logo">
                            <?php the_custom_logo(); ?>
                        </div>
                    <?php else : ?>
                        <h1 class="site-title">
                            <a href="<?php echo esc_url(home_url('/')); ?>" rel="home" class="site-logo">
                                <?php bloginfo('name'); ?>
                            </a>
                        </h1>
                        <?php if (get_bloginfo('description', 'display')) : ?>
                            <p class="site-description"><?php echo get_bloginfo('description', 'display'); ?></p>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>

                <!-- Primary Navigation -->
                <nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php _e('Primary Menu', 'artist-music-pro'); ?>">
                    <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                        <span class="sr-only"><?php _e('Primary Menu', 'artist-music-pro'); ?></span>
                        <span class="menu-icon">
                            <span></span>
                            <span></span>
                            <span></span>
                        </span>
                    </button>
                    
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_id'        => 'primary-menu',
                        'container'      => false,
                        'fallback_cb'    => 'artist_music_pro_default_menu',
                    ));
                    ?>

                    <!-- Language Switcher (if using WPML or Polylang) -->
                    <?php if (function_exists('pll_the_languages')) : ?>
                        <div class="language-switcher">
                            <?php pll_the_languages(array('dropdown' => 1)); ?>
                        </div>
                    <?php elseif (function_exists('icl_get_languages')) : ?>
                        <div class="language-switcher">
                            <?php do_action('wpml_add_language_selector'); ?>
                        </div>
                    <?php endif; ?>

                    <!-- RTL/LTR Toggle (for demonstration) -->
                    <div class="rtl-toggle">
                        <button id="rtl-toggle-btn" onclick="toggleRTL()" title="<?php _e('Toggle text direction', 'artist-music-pro'); ?>">
                            <?php _e('عربی/فارسی', 'artist-music-pro'); ?>
                        </button>
                    </div>
                </nav>
            </div>
        </div>
    </header>

    <?php
    // Default menu fallback function
    function artist_music_pro_default_menu() {
        echo '<ul id="primary-menu" class="menu">';
        echo '<li><a href="' . esc_url(home_url('/')) . '">' . __('Home', 'artist-music-pro') . '</a></li>';
        echo '<li><a href="#music">' . __('Music', 'artist-music-pro') . '</a></li>';
        echo '<li><a href="#about">' . __('About', 'artist-music-pro') . '</a></li>';
        echo '<li><a href="' . esc_url(home_url('/blog')) . '">' . __('Blog', 'artist-music-pro') . '</a></li>';
        echo '<li><a href="#contact">' . __('Contact', 'artist-music-pro') . '</a></li>';
        echo '</ul>';
    }
    ?>

    <div id="content" class="site-content">