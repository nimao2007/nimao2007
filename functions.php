<?php
/**
 * Artist Music Pro functions and definitions
 *
 * @package Artist_Music_Pro
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Theme version
 */
define('ARTIST_MUSIC_PRO_VERSION', '1.0.0');

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function artist_music_pro_setup() {
    // Make theme available for translation
    load_theme_textdomain('artist-music-pro', get_template_directory() . '/languages');

    // Add default posts and comments RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails on posts and pages
    add_theme_support('post-thumbnails');

    // Custom image sizes for the theme
    add_image_size('album-cover', 300, 300, true);
    add_image_size('artist-photo', 400, 500, true);
    add_image_size('hero-bg', 1920, 1080, true);

    // Register navigation menus
    register_nav_menus(array(
        'primary' => esc_html__('Primary Menu', 'artist-music-pro'),
        'footer'  => esc_html__('Footer Menu', 'artist-music-pro'),
    ));

    // Switch default core markup for search form, comment form, and comments
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));

    // Set up the WordPress core custom background feature
    add_theme_support('custom-background', apply_filters('artist_music_pro_custom_background_args', array(
        'default-color' => 'ffffff',
        'default-image' => '',
    )));

    // Add theme support for selective refresh for widgets
    add_theme_support('customize-selective-refresh-widgets');

    // Add support for core custom logo
    add_theme_support('custom-logo', array(
        'height'      => 250,
        'width'       => 250,
        'flex-width'  => true,
        'flex-height' => true,
    ));

    // Add support for Block Editor
    add_theme_support('wp-block-styles');
    add_theme_support('align-wide');
    add_theme_support('editor-styles');
    add_editor_style('assets/css/editor-style.css');

    // Add support for responsive embedded content
    add_theme_support('responsive-embeds');

    // RTL language support
    add_theme_support('rtl-language-support');
}
add_action('after_setup_theme', 'artist_music_pro_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 */
function artist_music_pro_content_width() {
    $GLOBALS['content_width'] = apply_filters('artist_music_pro_content_width', 1200);
}
add_action('after_setup_theme', 'artist_music_pro_content_width', 0);

/**
 * Enqueue scripts and styles.
 */
function artist_music_pro_scripts() {
    // Theme stylesheet
    wp_enqueue_style('artist-music-pro-style', get_stylesheet_uri(), array(), ARTIST_MUSIC_PRO_VERSION);
    
    // RTL stylesheet
    if (is_rtl()) {
        wp_enqueue_style('artist-music-pro-rtl', get_template_directory_uri() . '/rtl.css', array('artist-music-pro-style'), ARTIST_MUSIC_PRO_VERSION);
    }

    // Custom JavaScript
    wp_enqueue_script('artist-music-pro-script', get_template_directory_uri() . '/assets/js/theme.js', array('jquery'), ARTIST_MUSIC_PRO_VERSION, true);

    // Music player functionality
    wp_enqueue_script('artist-music-pro-player', get_template_directory_uri() . '/assets/js/music-player.js', array('jquery'), ARTIST_MUSIC_PRO_VERSION, true);

    // Navigation script
    wp_enqueue_script('artist-music-pro-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), ARTIST_MUSIC_PRO_VERSION, true);

    // Comment reply script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    // Localize script for AJAX and translations
    wp_localize_script('artist-music-pro-script', 'artist_music_pro_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('artist_music_pro_nonce'),
        'strings'  => array(
            'loading' => __('Loading...', 'artist-music-pro'),
            'error'   => __('Something went wrong. Please try again.', 'artist-music-pro'),
        ),
    ));
}
add_action('wp_enqueue_scripts', 'artist_music_pro_scripts');

/**
 * Register widget areas.
 */
function artist_music_pro_widgets_init() {
    register_sidebar(array(
        'name'          => esc_html__('Sidebar', 'artist-music-pro'),
        'id'            => 'sidebar-1',
        'description'   => esc_html__('Add widgets here.', 'artist-music-pro'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));

    register_sidebar(array(
        'name'          => esc_html__('Footer Widget Area 1', 'artist-music-pro'),
        'id'            => 'footer-1',
        'description'   => esc_html__('Add widgets here for the first footer column.', 'artist-music-pro'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    register_sidebar(array(
        'name'          => esc_html__('Footer Widget Area 2', 'artist-music-pro'),
        'id'            => 'footer-2',
        'description'   => esc_html__('Add widgets here for the second footer column.', 'artist-music-pro'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    register_sidebar(array(
        'name'          => esc_html__('Footer Widget Area 3', 'artist-music-pro'),
        'id'            => 'footer-3',
        'description'   => esc_html__('Add widgets here for the third footer column.', 'artist-music-pro'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'artist_music_pro_widgets_init');

/**
 * Custom Post Type: Music
 */
function artist_music_pro_register_music_post_type() {
    $labels = array(
        'name'                  => _x('Music', 'Post type general name', 'artist-music-pro'),
        'singular_name'         => _x('Track', 'Post type singular name', 'artist-music-pro'),
        'menu_name'             => _x('Music', 'Admin Menu text', 'artist-music-pro'),
        'name_admin_bar'        => _x('Track', 'Add New on Toolbar', 'artist-music-pro'),
        'add_new'               => __('Add New', 'artist-music-pro'),
        'add_new_item'          => __('Add New Track', 'artist-music-pro'),
        'new_item'              => __('New Track', 'artist-music-pro'),
        'edit_item'             => __('Edit Track', 'artist-music-pro'),
        'view_item'             => __('View Track', 'artist-music-pro'),
        'all_items'             => __('All Tracks', 'artist-music-pro'),
        'search_items'          => __('Search Tracks', 'artist-music-pro'),
        'parent_item_colon'     => __('Parent Tracks:', 'artist-music-pro'),
        'not_found'             => __('No tracks found.', 'artist-music-pro'),
        'not_found_in_trash'    => __('No tracks found in Trash.', 'artist-music-pro'),
        'featured_image'        => _x('Track Cover Image', 'Overrides the "Featured Image" phrase', 'artist-music-pro'),
        'set_featured_image'    => _x('Set cover image', 'Overrides the "Set featured image" phrase', 'artist-music-pro'),
        'remove_featured_image' => _x('Remove cover image', 'Overrides the "Remove featured image" phrase', 'artist-music-pro'),
        'use_featured_image'    => _x('Use as cover image', 'Overrides the "Use as featured image" phrase', 'artist-music-pro'),
        'archives'              => _x('Track archives', 'The post type archive label', 'artist-music-pro'),
        'insert_into_item'      => _x('Insert into track', 'Overrides the "Insert into post" phrase', 'artist-music-pro'),
        'uploaded_to_this_item' => _x('Uploaded to this track', 'Overrides the "Uploaded to this post" phrase', 'artist-music-pro'),
        'filter_items_list'     => _x('Filter tracks list', 'Screen reader text', 'artist-music-pro'),
        'items_list_navigation' => _x('Tracks list navigation', 'Screen reader text', 'artist-music-pro'),
        'items_list'            => _x('Tracks list', 'Screen reader text', 'artist-music-pro'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'music'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'menu_icon'          => 'dashicons-format-audio',
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'show_in_rest'       => true, // Enable Gutenberg editor
    );

    register_post_type('music', $args);
}
add_action('init', 'artist_music_pro_register_music_post_type');

/**
 * Custom Post Type: Albums
 */
function artist_music_pro_register_album_post_type() {
    $labels = array(
        'name'                  => _x('Albums', 'Post type general name', 'artist-music-pro'),
        'singular_name'         => _x('Album', 'Post type singular name', 'artist-music-pro'),
        'menu_name'             => _x('Albums', 'Admin Menu text', 'artist-music-pro'),
        'add_new_item'          => __('Add New Album', 'artist-music-pro'),
        'edit_item'             => __('Edit Album', 'artist-music-pro'),
        'view_item'             => __('View Album', 'artist-music-pro'),
        'all_items'             => __('All Albums', 'artist-music-pro'),
        'search_items'          => __('Search Albums', 'artist-music-pro'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'albums'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'menu_icon'          => 'dashicons-album',
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'show_in_rest'       => true,
    );

    register_post_type('album', $args);
}
add_action('init', 'artist_music_pro_register_album_post_type');

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Custom Widgets
 */
require get_template_directory() . '/inc/widgets.php';

/**
 * Load Custom Functions
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Load Template Tags
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Add meta boxes for custom post types
 */
function artist_music_pro_add_meta_boxes() {
    add_meta_box(
        'music_details',
        __('Music Details', 'artist-music-pro'),
        'artist_music_pro_music_meta_box',
        'music',
        'normal',
        'high'
    );

    add_meta_box(
        'album_details',
        __('Album Details', 'artist-music-pro'),
        'artist_music_pro_album_meta_box',
        'album',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'artist_music_pro_add_meta_boxes');

/**
 * Music meta box callback
 */
function artist_music_pro_music_meta_box($post) {
    wp_nonce_field(basename(__FILE__), 'music_meta_nonce');
    
    $audio_file = get_post_meta($post->ID, 'audio_file', true);
    $album_name = get_post_meta($post->ID, 'album_name', true);
    $duration = get_post_meta($post->ID, 'duration', true);
    $genre = get_post_meta($post->ID, 'genre', true);
    $release_date = get_post_meta($post->ID, 'release_date', true);
    $featured = get_post_meta($post->ID, 'featured', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="audio_file"><?php _e('Audio File URL', 'artist-music-pro'); ?></label></th>
            <td><input type="url" id="audio_file" name="audio_file" value="<?php echo esc_attr($audio_file); ?>" class="regular-text" /></td>
        </tr>
        <tr>
            <th><label for="album_name"><?php _e('Album Name', 'artist-music-pro'); ?></label></th>
            <td><input type="text" id="album_name" name="album_name" value="<?php echo esc_attr($album_name); ?>" class="regular-text" /></td>
        </tr>
        <tr>
            <th><label for="duration"><?php _e('Duration', 'artist-music-pro'); ?></label></th>
            <td><input type="text" id="duration" name="duration" value="<?php echo esc_attr($duration); ?>" placeholder="3:45" class="regular-text" /></td>
        </tr>
        <tr>
            <th><label for="genre"><?php _e('Genre', 'artist-music-pro'); ?></label></th>
            <td><input type="text" id="genre" name="genre" value="<?php echo esc_attr($genre); ?>" class="regular-text" /></td>
        </tr>
        <tr>
            <th><label for="release_date"><?php _e('Release Date', 'artist-music-pro'); ?></label></th>
            <td><input type="date" id="release_date" name="release_date" value="<?php echo esc_attr($release_date); ?>" class="regular-text" /></td>
        </tr>
        <tr>
            <th><label for="featured"><?php _e('Featured Track', 'artist-music-pro'); ?></label></th>
            <td><input type="checkbox" id="featured" name="featured" value="yes" <?php checked($featured, 'yes'); ?> /> <?php _e('Mark as featured', 'artist-music-pro'); ?></td>
        </tr>
    </table>
    <?php
}

/**
 * Album meta box callback
 */
function artist_music_pro_album_meta_box($post) {
    wp_nonce_field(basename(__FILE__), 'album_meta_nonce');
    
    $release_year = get_post_meta($post->ID, 'release_year', true);
    $genre = get_post_meta($post->ID, 'genre', true);
    $record_label = get_post_meta($post->ID, 'record_label', true);
    $spotify_url = get_post_meta($post->ID, 'spotify_url', true);
    $apple_music_url = get_post_meta($post->ID, 'apple_music_url', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="release_year"><?php _e('Release Year', 'artist-music-pro'); ?></label></th>
            <td><input type="number" id="release_year" name="release_year" value="<?php echo esc_attr($release_year); ?>" min="1900" max="<?php echo date('Y'); ?>" /></td>
        </tr>
        <tr>
            <th><label for="genre"><?php _e('Genre', 'artist-music-pro'); ?></label></th>
            <td><input type="text" id="genre" name="genre" value="<?php echo esc_attr($genre); ?>" class="regular-text" /></td>
        </tr>
        <tr>
            <th><label for="record_label"><?php _e('Record Label', 'artist-music-pro'); ?></label></th>
            <td><input type="text" id="record_label" name="record_label" value="<?php echo esc_attr($record_label); ?>" class="regular-text" /></td>
        </tr>
        <tr>
            <th><label for="spotify_url"><?php _e('Spotify URL', 'artist-music-pro'); ?></label></th>
            <td><input type="url" id="spotify_url" name="spotify_url" value="<?php echo esc_attr($spotify_url); ?>" class="regular-text" /></td>
        </tr>
        <tr>
            <th><label for="apple_music_url"><?php _e('Apple Music URL', 'artist-music-pro'); ?></label></th>
            <td><input type="url" id="apple_music_url" name="apple_music_url" value="<?php echo esc_attr($apple_music_url); ?>" class="regular-text" /></td>
        </tr>
    </table>
    <?php
}

/**
 * Save meta box data
 */
function artist_music_pro_save_meta_boxes($post_id) {
    if (!isset($_POST['music_meta_nonce']) && !isset($_POST['album_meta_nonce'])) {
        return;
    }

    if (!wp_verify_nonce($_POST['music_meta_nonce'] ?? '', basename(__FILE__)) && 
        !wp_verify_nonce($_POST['album_meta_nonce'] ?? '', basename(__FILE__))) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save music meta
    if (get_post_type($post_id) === 'music') {
        $fields = array('audio_file', 'album_name', 'duration', 'genre', 'release_date', 'featured');
        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
            }
        }
    }

    // Save album meta
    if (get_post_type($post_id) === 'album') {
        $fields = array('release_year', 'genre', 'record_label', 'spotify_url', 'apple_music_url');
        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
            }
        }
    }
}
add_action('save_post', 'artist_music_pro_save_meta_boxes');

/**
 * Custom excerpt length
 */
function artist_music_pro_excerpt_length($length) {
    return 20;
}
add_filter('excerpt_length', 'artist_music_pro_excerpt_length');

// Excerpt more function moved to inc/template-functions.php to avoid duplication

// Body classes function moved to inc/template-functions.php to avoid duplication

/**
 * Admin styles for better UX
 */
function artist_music_pro_admin_styles() {
    echo '<style>
        .form-table th { width: 200px; }
        .form-table input[type="text"], 
        .form-table input[type="url"], 
        .form-table input[type="date"] { width: 100%; }
    </style>';
}
add_action('admin_head', 'artist_music_pro_admin_styles');

/**
 * Flush rewrite rules on theme activation
 */
function artist_music_pro_flush_rewrite_rules() {
    artist_music_pro_register_music_post_type();
    artist_music_pro_register_album_post_type();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'artist_music_pro_flush_rewrite_rules');