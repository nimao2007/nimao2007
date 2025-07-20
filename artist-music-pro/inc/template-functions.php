<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Artist_Music_Pro
 */

/**
 * Adds custom classes to the array of body classes.
 */
function artist_music_pro_body_classes($classes) {
    // Adds a class of hfeed to non-singular pages.
    if (!is_singular()) {
        $classes[] = 'hfeed';
    }

    // Adds a class of no-sidebar when there is no sidebar present.
    if (!is_active_sidebar('sidebar-1')) {
        $classes[] = 'no-sidebar';
    }

    // Add RTL class
    if (is_rtl()) {
        $classes[] = 'rtl-language';
    }

    // Add homepage class
    if (is_home() || is_front_page()) {
        $classes[] = 'homepage';
    }

    // Add music-related classes
    if (is_singular('music') || is_post_type_archive('music')) {
        $classes[] = 'music-page';
    }

    if (is_singular('album') || is_post_type_archive('album')) {
        $classes[] = 'album-page';
    }

    return $classes;
}
add_filter('body_class', 'artist_music_pro_body_classes');

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function artist_music_pro_pingback_header() {
    if (is_singular() && pings_open()) {
        printf('<link rel="pingback" href="%s">', esc_url(get_bloginfo('pingback_url')));
    }
}
add_action('wp_head', 'artist_music_pro_pingback_header');

/**
 * Fallback menu for when no menu is assigned
 */
function artist_music_pro_fallback_menu() {
    echo '<ul id="primary-menu" class="nav-menu fallback-menu">';
    
    // Detect if RTL/Persian
    $is_rtl = is_rtl() || (function_exists('get_locale') && in_array(get_locale(), ['fa_IR', 'fa_AF', 'ar']));
    
    // Home
    $home_text = $is_rtl ? 'خانه' : esc_html__('Home', 'artist-music-pro');
    echo '<li class="menu-item"><a href="' . esc_url(home_url('/')) . '">' . $home_text . '</a></li>';
    
    // Music
    if (post_type_exists('music')) {
        $music_text = $is_rtl ? 'موزیک' : esc_html__('Music', 'artist-music-pro');
        echo '<li class="menu-item"><a href="' . esc_url(get_post_type_archive_link('music')) . '">' . $music_text . '</a></li>';
    }
    
    // Albums
    if (post_type_exists('album')) {
        $albums_text = $is_rtl ? 'آلبوم‌ها' : esc_html__('Albums', 'artist-music-pro');
        echo '<li class="menu-item"><a href="' . esc_url(get_post_type_archive_link('album')) . '">' . $albums_text . '</a></li>';
    }
    
    // Blog
    $blog_text = $is_rtl ? 'وبلاگ' : esc_html__('Blog', 'artist-music-pro');
    $blog_page_id = get_option('page_for_posts');
    if ($blog_page_id) {
        echo '<li class="menu-item"><a href="' . esc_url(get_permalink($blog_page_id)) . '">' . $blog_text . '</a></li>';
    } else {
        echo '<li class="menu-item"><a href="' . esc_url(home_url('/blog/')) . '">' . $blog_text . '</a></li>';
    }
    
    // About
    $about_text = $is_rtl ? 'درباره من' : esc_html__('About', 'artist-music-pro');
    $about_page = get_page_by_path('about');
    if ($about_page) {
        echo '<li class="menu-item"><a href="' . esc_url(get_permalink($about_page)) . '">' . $about_text . '</a></li>';
    }
    
    // Contact
    $contact_text = $is_rtl ? 'تماس با من' : esc_html__('Contact', 'artist-music-pro');
    $contact_page = get_page_by_path('contact');
    if ($contact_page) {
        echo '<li class="menu-item"><a href="' . esc_url(get_permalink($contact_page)) . '">' . $contact_text . '</a></li>';
    }
    
    echo '</ul>';
}

/**
 * Custom logo function with fallback
 */
function artist_music_pro_custom_logo() {
    if (has_custom_logo()) {
        the_custom_logo();
    } else {
        echo '<h1 class="site-title"><a href="' . esc_url(home_url('/')) . '" rel="home">' . esc_html(get_bloginfo('name')) . '</a></h1>';
        $description = get_bloginfo('description', 'display');
        if ($description || is_customize_preview()) {
            echo '<p class="site-description">' . $description . '</p>';
        }
    }
}

/**
 * Get social media links
 */
function artist_music_pro_get_social_links() {
    $social_networks = array(
        'facebook', 'instagram', 'twitter', 'youtube', 
        'spotify', 'soundcloud', 'bandcamp', 'tiktok'
    );
    
    $social_links = array();
    
    foreach ($social_networks as $network) {
        $url = get_theme_mod("social_{$network}");
        if ($url) {
            $social_links[$network] = $url;
        }
    }
    
    return $social_links;
}

/**
 * Display social media links
 */
function artist_music_pro_social_links($before = '', $after = '') {
    $social_links = artist_music_pro_get_social_links();
    
    if (empty($social_links)) {
        return;
    }
    
    echo $before;
    
    foreach ($social_links as $network => $url) {
        $icon = artist_music_pro_get_social_icon($network);
        printf(
            '<a href="%s" target="_blank" rel="noopener noreferrer" aria-label="%s" class="social-link social-%s">%s</a>',
            esc_url($url),
            esc_attr(ucfirst($network)),
            esc_attr($network),
            $icon
        );
    }
    
    echo $after;
}

/**
 * Get social media icon SVG
 */
function artist_music_pro_get_social_icon($network) {
    $icons = array(
        'facebook' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>',
        'instagram' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>',
        'twitter' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>',
        'youtube' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>',
        'spotify' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.4 0 0 5.4 0 12s5.4 12 12 12 12-5.4 12-12S18.66 0 12 0zm5.521 17.34c-.24.359-.66.48-1.021.24-2.82-1.74-6.36-2.101-10.561-1.141-.418.122-.779-.179-.899-.539-.12-.421.18-.78.54-.9 4.56-1.021 8.52-.6 11.64 1.32.42.18.479.659.301 1.02zm1.44-3.3c-.301.42-.841.6-1.262.3-3.239-1.98-8.159-2.58-11.939-1.38-.479.12-1.02-.12-1.14-.6-.12-.48.12-1.021.6-1.141C9.6 9.9 15 10.561 18.72 12.84c.361.181.54.78.241 1.2zm.12-3.36C15.24 8.4 8.82 8.16 5.16 9.301c-.6.179-1.2-.181-1.38-.721-.18-.601.18-1.2.72-1.381 4.26-1.26 11.28-1.02 15.721 1.621.539.3.719 1.02.42 1.56-.299.421-1.02.599-1.559.3z"/></svg>',
        'soundcloud' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M1.175 12.225c-.051 0-.094.046-.101.1l-.233 2.154.233 2.105c.007.058.05.098.101.098.05 0 .09-.04.099-.098l.255-2.105-.255-2.154c-.009-.057-.049-.1-.099-.1zm1.525.3c-.058 0-.106.053-.113.115l-.193 1.855.193 1.81c.007.067.055.115.113.115.057 0 .104-.048.113-.115l.214-1.81-.214-1.855c-.009-.062-.056-.115-.113-.115z"/></svg>',
    );
    
    return isset($icons[$network]) ? $icons[$network] : '';
}

/**
 * Format music duration
 */
function artist_music_pro_format_duration($duration) {
    if (empty($duration)) {
        return '';
    }
    
    // If duration is already formatted (contains colon), return as is
    if (strpos($duration, ':') !== false) {
        return $duration;
    }
    
    // If duration is in seconds, format it
    if (is_numeric($duration)) {
        $minutes = floor($duration / 60);
        $seconds = $duration % 60;
        return sprintf('%d:%02d', $minutes, $seconds);
    }
    
    return $duration;
}

/**
 * Get music player HTML
 */
function artist_music_pro_music_player($track_url, $track_title, $track_artist = '') {
    if (empty($track_url)) {
        return '';
    }
    
    $artist = !empty($track_artist) ? $track_artist : get_bloginfo('name');
    
    return sprintf(
        '<button class="btn btn-primary play-track-btn" onclick="playTrack(\'%s\', \'%s\', \'%s\')">%s</button>',
        esc_url($track_url),
        esc_attr($track_title),
        esc_attr($artist),
        __('Play', 'artist-music-pro')
    );
}

/**
 * Get featured music tracks
 */
function artist_music_pro_get_featured_tracks($limit = 6) {
    $query = new WP_Query(array(
        'post_type' => 'music',
        'posts_per_page' => $limit,
        'meta_query' => array(
            array(
                'key' => 'featured',
                'value' => 'yes',
                'compare' => '='
            )
        )
    ));
    
    return $query;
}

/**
 * Display breadcrumbs
 */
function artist_music_pro_breadcrumbs() {
    if (is_home() || is_front_page()) {
        return;
    }
    
    $breadcrumbs = array();
    $breadcrumbs[] = '<a href="' . home_url('/') . '">' . __('Home', 'artist-music-pro') . '</a>';
    
    if (is_category()) {
        $breadcrumbs[] = single_cat_title('', false);
    } elseif (is_tag()) {
        $breadcrumbs[] = single_tag_title('', false);
    } elseif (is_archive()) {
        $breadcrumbs[] = get_the_archive_title();
    } elseif (is_search()) {
        $breadcrumbs[] = __('Search Results', 'artist-music-pro');
    } elseif (is_404()) {
        $breadcrumbs[] = __('Page Not Found', 'artist-music-pro');
    } elseif (is_singular()) {
        if (get_post_type() !== 'post') {
            $post_type_object = get_post_type_object(get_post_type());
            if ($post_type_object->has_archive) {
                $breadcrumbs[] = '<a href="' . get_post_type_archive_link(get_post_type()) . '">' . $post_type_object->labels->name . '</a>';
            }
        }
        $breadcrumbs[] = get_the_title();
    }
    
    if (!empty($breadcrumbs)) {
        echo '<nav class="breadcrumbs" aria-label="' . __('Breadcrumb Navigation', 'artist-music-pro') . '">';
        echo implode(' / ', $breadcrumbs);
        echo '</nav>';
    }
}

/**
 * Custom excerpt with more link
 */
function artist_music_pro_excerpt_more($link) {
    if (is_admin()) {
        return $link;
    }

    $link = sprintf(
        '<p class="link-more"><a href="%1$s" class="more-link">%2$s</a></p>',
        esc_url(get_permalink()),
        sprintf(
            __('Continue reading<span class="screen-reader-text"> "%s"</span>', 'artist-music-pro'),
            get_the_title()
        )
    );
    return ' &hellip; ' . $link;
}
add_filter('excerpt_more', 'artist_music_pro_excerpt_more');

/**
 * Filter the except length to 20 words.
 */
function artist_music_pro_excerpt_length($length) {
    if (is_admin()) {
        return $length;
    }
    return 20;
}
add_filter('excerpt_length', 'artist_music_pro_excerpt_length');

/**
 * Display post meta information
 */
function artist_music_pro_post_meta() {
    $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
    if (get_the_time('U') !== get_the_modified_time('U')) {
        $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
    }

    $time_string = sprintf(
        $time_string,
        esc_attr(get_the_date(DATE_W3C)),
        esc_html(get_the_date()),
        esc_attr(get_the_modified_date(DATE_W3C)),
        esc_html(get_the_modified_date())
    );

    printf(
        '<span class="posted-on">%1$s <a href="%2$s" rel="bookmark">%3$s</a></span>',
        _x('Posted on', 'Used before publish date.', 'artist-music-pro'),
        esc_url(get_permalink()),
        $time_string
    );

    if (is_singular() || is_multi_author()) {
        printf(
            '<span class="byline"> %1$s <span class="author vcard"><a class="url fn n" href="%2$s">%3$s</a></span></span>',
            _x('by', 'Used before post author name.', 'artist-music-pro'),
            esc_url(get_author_posts_url(get_the_author_meta('ID'))),
            esc_html(get_the_author())
        );
    }

    if (!is_single() && !post_password_required() && (comments_open() || get_comments_number())) {
        echo '<span class="comments-link">';
        comments_popup_link(
            sprintf(
                wp_kses(
                    __('Leave a Comment<span class="screen-reader-text"> on %s</span>', 'artist-music-pro'),
                    array(
                        'span' => array(
                            'class' => array(),
                        ),
                    )
                ),
                get_the_title()
            )
        );
        echo '</span>';
    }
}

/**
 * Display post footer
 */
function artist_music_pro_entry_footer() {
    // Hide category and tag text for pages.
    if ('post' === get_post_type()) {
        /* translators: used between list items, there is a space after the comma */
        $categories_list = get_the_category_list(esc_html__(', ', 'artist-music-pro'));
        if ($categories_list) {
            /* translators: 1: list of categories. */
            printf('<span class="cat-links">' . esc_html__('Posted in %1$s', 'artist-music-pro') . '</span>', $categories_list); // WPCS: XSS OK.
        }

        /* translators: used between list items, there is a space after the comma */
        $tags_list = get_the_tag_list('', esc_html_x(', ', 'list item separator', 'artist-music-pro'));
        if ($tags_list) {
            /* translators: 1: list of tags. */
            printf('<span class="tags-links">' . esc_html__('Tagged %1$s', 'artist-music-pro') . '</span>', $tags_list); // WPCS: XSS OK.
        }
    }

    if (!is_single() && !post_password_required() && (comments_open() || get_comments_number())) {
        echo '<span class="comments-link">';
        comments_popup_link(
            sprintf(
                wp_kses(
                    __('Leave a Comment<span class="screen-reader-text"> on %s</span>', 'artist-music-pro'),
                    array(
                        'span' => array(
                            'class' => array(),
                        ),
                    )
                ),
                get_the_title()
            )
        );
        echo '</span>';
    }

    edit_post_link(
        sprintf(
            wp_kses(
                __('Edit <span class="screen-reader-text">%s</span>', 'artist-music-pro'),
                array(
                    'span' => array(
                        'class' => array(),
                    ),
                )
            ),
            get_the_title()
        ),
        '<span class="edit-link">',
        '</span>'
    );
}