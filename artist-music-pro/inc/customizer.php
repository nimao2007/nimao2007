<?php
/**
 * Artist Music Pro Theme Customizer
 *
 * @package Artist_Music_Pro
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 */
function artist_music_pro_customize_register($wp_customize) {
    
    // Add custom sections
    artist_music_pro_add_hero_section($wp_customize);
    artist_music_pro_add_about_section($wp_customize);
    artist_music_pro_add_contact_section($wp_customize);
    artist_music_pro_add_social_section($wp_customize);
    artist_music_pro_add_footer_section($wp_customize);
    artist_music_pro_add_colors_section($wp_customize);
    artist_music_pro_add_typography_section($wp_customize);

    // Modify default sections
    $wp_customize->get_setting('blogname')->transport = 'postMessage';
    $wp_customize->get_setting('blogdescription')->transport = 'postMessage';
    $wp_customize->get_setting('header_textcolor')->transport = 'postMessage';

    if (isset($wp_customize->selective_refresh)) {
        $wp_customize->selective_refresh->add_partial('blogname', array(
            'selector'        => '.site-title a',
            'render_callback' => 'artist_music_pro_customize_partial_blogname',
        ));
        $wp_customize->selective_refresh->add_partial('blogdescription', array(
            'selector'        => '.site-description',
            'render_callback' => 'artist_music_pro_customize_partial_blogdescription',
        ));
    }
}
add_action('customize_register', 'artist_music_pro_customize_register');

/**
 * Hero Section Settings
 */
function artist_music_pro_add_hero_section($wp_customize) {
    // Hero Section
    $wp_customize->add_section('hero_section', array(
        'title'    => __('Hero Section', 'artist-music-pro'),
        'priority' => 30,
    ));

    // Hero Title
    $wp_customize->add_setting('hero_title', array(
        'default'           => __('Welcome to My Music World', 'artist-music-pro'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('hero_title', array(
        'label'   => __('Hero Title', 'artist-music-pro'),
        'section' => 'hero_section',
        'type'    => 'text',
    ));

    // Hero Subtitle
    $wp_customize->add_setting('hero_subtitle', array(
        'default'           => __('Singer • Songwriter • Artist', 'artist-music-pro'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('hero_subtitle', array(
        'label'   => __('Hero Subtitle', 'artist-music-pro'),
        'section' => 'hero_section',
        'type'    => 'text',
    ));

    // Hero Background Image
    $wp_customize->add_setting('hero_background_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'hero_background_image', array(
        'label'   => __('Hero Background Image', 'artist-music-pro'),
        'section' => 'hero_section',
    )));
}

/**
 * About Section Settings
 */
function artist_music_pro_add_about_section($wp_customize) {
    // About Section
    $wp_customize->add_section('about_section', array(
        'title'    => __('About Section', 'artist-music-pro'),
        'priority' => 35,
    ));

    // About Text
    $wp_customize->add_setting('about_text', array(
        'default'           => __('I am a passionate singer-songwriter who creates music that touches the soul. With over a decade of experience in the music industry, I blend traditional melodies with contemporary sounds to create something truly unique.', 'artist-music-pro'),
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('about_text', array(
        'label'   => __('About Text', 'artist-music-pro'),
        'section' => 'about_section',
        'type'    => 'textarea',
    ));

    // About Image
    $wp_customize->add_setting('about_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'about_image', array(
        'label'   => __('About Image', 'artist-music-pro'),
        'section' => 'about_section',
    )));
}

/**
 * Contact Section Settings
 */
function artist_music_pro_add_contact_section($wp_customize) {
    // Contact Section
    $wp_customize->add_section('contact_section', array(
        'title'    => __('Contact Information', 'artist-music-pro'),
        'priority' => 40,
    ));

    // Contact Email
    $wp_customize->add_setting('contact_email', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_email',
    ));

    $wp_customize->add_control('contact_email', array(
        'label'   => __('Email Address', 'artist-music-pro'),
        'section' => 'contact_section',
        'type'    => 'email',
    ));

    // Contact Phone
    $wp_customize->add_setting('contact_phone', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('contact_phone', array(
        'label'   => __('Phone Number', 'artist-music-pro'),
        'section' => 'contact_section',
        'type'    => 'tel',
    ));

    // Contact Address
    $wp_customize->add_setting('contact_address', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('contact_address', array(
        'label'   => __('Address', 'artist-music-pro'),
        'section' => 'contact_section',
        'type'    => 'text',
    ));
}

/**
 * Social Media Settings
 */
function artist_music_pro_add_social_section($wp_customize) {
    // Social Media Section
    $wp_customize->add_section('social_section', array(
        'title'    => __('Social Media', 'artist-music-pro'),
        'priority' => 45,
    ));

    $social_networks = array(
        'facebook'    => __('Facebook URL', 'artist-music-pro'),
        'instagram'   => __('Instagram URL', 'artist-music-pro'),
        'twitter'     => __('Twitter URL', 'artist-music-pro'),
        'youtube'     => __('YouTube URL', 'artist-music-pro'),
        'spotify'     => __('Spotify URL', 'artist-music-pro'),
        'soundcloud'  => __('SoundCloud URL', 'artist-music-pro'),
        'bandcamp'    => __('Bandcamp URL', 'artist-music-pro'),
        'tiktok'      => __('TikTok URL', 'artist-music-pro'),
    );

    foreach ($social_networks as $network => $label) {
        $wp_customize->add_setting("social_{$network}", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));

        $wp_customize->add_control("social_{$network}", array(
            'label'   => $label,
            'section' => 'social_section',
            'type'    => 'url',
        ));
    }
}

/**
 * Footer Section Settings
 */
function artist_music_pro_add_footer_section($wp_customize) {
    // Footer Section
    $wp_customize->add_section('footer_section', array(
        'title'    => __('Footer Settings', 'artist-music-pro'),
        'priority' => 50,
    ));

    // Footer About Text
    $wp_customize->add_setting('footer_about_text', array(
        'default'           => __('Passionate singer-songwriter creating music that touches the soul. Follow my journey and stay updated with latest releases.', 'artist-music-pro'),
        'sanitize_callback' => 'wp_kses_post',
    ));

    $wp_customize->add_control('footer_about_text', array(
        'label'   => __('Footer About Text', 'artist-music-pro'),
        'section' => 'footer_section',
        'type'    => 'textarea',
    ));

    // Copyright Text
    $wp_customize->add_setting('footer_copyright', array(
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
    ));

    $wp_customize->add_control('footer_copyright', array(
        'label'   => __('Custom Copyright Text', 'artist-music-pro'),
        'section' => 'footer_section',
        'type'    => 'textarea',
        'description' => __('Leave empty to use default copyright text.', 'artist-music-pro'),
    ));
}

/**
 * Colors Section Settings
 */
function artist_music_pro_add_colors_section($wp_customize) {
    // Custom Colors Section
    $wp_customize->add_section('custom_colors', array(
        'title'    => __('Theme Colors', 'artist-music-pro'),
        'priority' => 55,
    ));

    $colors = array(
        'primary_color'   => array(
            'label'   => __('Primary Color', 'artist-music-pro'),
            'default' => '#1a1a1a',
        ),
        'secondary_color' => array(
            'label'   => __('Secondary Color', 'artist-music-pro'),
            'default' => '#ff6b35',
        ),
        'accent_color'    => array(
            'label'   => __('Accent Color', 'artist-music-pro'),
            'default' => '#ffd700',
        ),
    );

    foreach ($colors as $color_id => $color_data) {
        $wp_customize->add_setting($color_id, array(
            'default'           => $color_data['default'],
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage',
        ));

        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, $color_id, array(
            'label'   => $color_data['label'],
            'section' => 'custom_colors',
        )));
    }
}

/**
 * Typography Section Settings
 */
function artist_music_pro_add_typography_section($wp_customize) {
    // Typography Section
    $wp_customize->add_section('typography_section', array(
        'title'    => __('Typography', 'artist-music-pro'),
        'priority' => 60,
    ));

    // Font Selection for Headings
    $wp_customize->add_setting('heading_font', array(
        'default'           => 'Vazirmatn',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('heading_font', array(
        'label'   => __('Heading Font', 'artist-music-pro'),
        'section' => 'typography_section',
        'type'    => 'select',
        'choices' => array(
            'Vazirmatn'        => 'Vazirmatn (Persian/Farsi)',
            'Noto Sans Arabic' => 'Noto Sans Arabic',
            'Inter'            => 'Inter',
            'Georgia'          => 'Georgia',
            'Times New Roman'  => 'Times New Roman',
        ),
    ));

    // Font Selection for Body
    $wp_customize->add_setting('body_font', array(
        'default'           => 'Vazirmatn',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('body_font', array(
        'label'   => __('Body Font', 'artist-music-pro'),
        'section' => 'typography_section',
        'type'    => 'select',
        'choices' => array(
            'Vazirmatn'        => 'Vazirmatn (Persian/Farsi)',
            'Noto Sans Arabic' => 'Noto Sans Arabic',
            'Inter'            => 'Inter',
            'Arial'            => 'Arial',
            'Helvetica'        => 'Helvetica',
        ),
    ));

    // Font Size
    $wp_customize->add_setting('base_font_size', array(
        'default'           => '16',
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('base_font_size', array(
        'label'       => __('Base Font Size (px)', 'artist-music-pro'),
        'section'     => 'typography_section',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 14,
            'max'  => 24,
            'step' => 1,
        ),
    ));
}

/**
 * Render the site title for the selective refresh partial.
 */
function artist_music_pro_customize_partial_blogname() {
    bloginfo('name');
}

/**
 * Render the site tagline for the selective refresh partial.
 */
function artist_music_pro_customize_partial_blogdescription() {
    bloginfo('description');
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function artist_music_pro_customize_preview_js() {
    wp_enqueue_script('artist-music-pro-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array('customize-preview'), ARTIST_MUSIC_PRO_VERSION, true);
}
add_action('customize_preview_init', 'artist_music_pro_customize_preview_js');

/**
 * Enqueue customizer control scripts
 */
function artist_music_pro_customize_controls_js() {
    wp_enqueue_script('artist-music-pro-customizer-controls', get_template_directory_uri() . '/assets/js/customizer-controls.js', array('customize-controls'), ARTIST_MUSIC_PRO_VERSION, true);
}
add_action('customize_controls_enqueue_scripts', 'artist_music_pro_customize_controls_js');

/**
 * Add custom CSS based on customizer settings
 */
function artist_music_pro_customizer_css() {
    $primary_color = get_theme_mod('primary_color', '#1a1a1a');
    $secondary_color = get_theme_mod('secondary_color', '#ff6b35');
    $accent_color = get_theme_mod('accent_color', '#ffd700');
    $heading_font = get_theme_mod('heading_font', 'Vazirmatn');
    $body_font = get_theme_mod('body_font', 'Vazirmatn');
    $base_font_size = get_theme_mod('base_font_size', 16);

    $custom_css = "
        :root {
            --primary-color: {$primary_color};
            --secondary-color: {$secondary_color};
            --accent-color: {$accent_color};
            --font-primary: '{$body_font}', 'Noto Sans Arabic', 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            --font-display: '{$heading_font}', 'Noto Sans Arabic', 'Inter', Georgia, serif;
        }
        
        body {
            font-size: {$base_font_size}px;
        }
    ";

    // Add hero background image if set
    $hero_bg = get_theme_mod('hero_background_image');
    if ($hero_bg) {
        $custom_css .= "
            .hero-section {
                background-image: linear-gradient(rgba(26, 26, 26, 0.7), rgba(255, 107, 53, 0.7)), url('{$hero_bg}');
                background-size: cover;
                background-position: center;
                background-attachment: fixed;
            }
        ";
    }

    wp_add_inline_style('artist-music-pro-style', $custom_css);
}
add_action('wp_enqueue_scripts', 'artist_music_pro_customizer_css');