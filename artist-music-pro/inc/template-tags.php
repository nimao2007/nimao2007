<?php
/**
 * Custom template tags for this theme
 *
 * @package Artist_Music_Pro
 */

if (!function_exists('artist_music_pro_posted_on')) :
    /**
     * Prints HTML with meta information for the current post-date/time.
     */
    function artist_music_pro_posted_on() {
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

        $posted_on = sprintf(
            /* translators: %s: post date. */
            esc_html_x('Posted on %s', 'post date', 'artist-music-pro'),
            '<a href="' . esc_url(get_permalink()) . '" rel="bookmark">' . $time_string . '</a>'
        );

        echo '<span class="posted-on">' . $posted_on . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
endif;

if (!function_exists('artist_music_pro_posted_by')) :
    /**
     * Prints HTML with meta information for the current author.
     */
    function artist_music_pro_posted_by() {
        $byline = sprintf(
            /* translators: %s: post author. */
            esc_html_x('by %s', 'post author', 'artist-music-pro'),
            '<span class="author vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a></span>'
        );

        echo '<span class="byline"> ' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
endif;

if (!function_exists('artist_music_pro_entry_footer')) :
    /**
     * Prints HTML with meta information for the categories, tags and comments.
     */
    function artist_music_pro_entry_footer() {
        // Hide category and tag text for pages.
        if ('post' === get_post_type()) {
            /* translators: used between list items, there is a space after the comma */
            $categories_list = get_the_category_list(esc_html__(', ', 'artist-music-pro'));
            if ($categories_list) {
                /* translators: 1: list of categories. */
                printf('<span class="cat-links">' . esc_html__('Posted in %1$s', 'artist-music-pro') . '</span>', $categories_list); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            }

            /* translators: used between list items, there is a space after the comma */
            $tags_list = get_the_tag_list('', esc_html_x(', ', 'list item separator', 'artist-music-pro'));
            if ($tags_list) {
                /* translators: 1: list of tags. */
                printf('<span class="tags-links">' . esc_html__('Tagged %1$s', 'artist-music-pro') . '</span>', $tags_list); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            }
        }

        if (!is_single() && !post_password_required() && (comments_open() || get_comments_number())) {
            echo '<span class="comments-link">';
            comments_popup_link(
                sprintf(
                    wp_kses(
                        /* translators: %s: post title */
                        __('Leave a Comment<span class="screen-reader-text"> on %s</span>', 'artist-music-pro'),
                        array(
                            'span' => array(
                                'class' => array(),
                            ),
                        )
                    ),
                    wp_kses_post(get_the_title())
                )
            );
            echo '</span>';
        }

        edit_post_link(
            sprintf(
                wp_kses(
                    /* translators: %s: Name of current post. Only visible to screen readers */
                    __('Edit <span class="screen-reader-text">%s</span>', 'artist-music-pro'),
                    array(
                        'span' => array(
                            'class' => array(),
                        ),
                    )
                ),
                wp_kses_post(get_the_title())
            ),
            '<span class="edit-link">',
            '</span>'
        );
    }
endif;

if (!function_exists('artist_music_pro_post_thumbnail')) :
    /**
     * Displays an optional post thumbnail.
     *
     * Wraps the post thumbnail in an anchor element on index views, or a div
     * element when on single views.
     */
    function artist_music_pro_post_thumbnail() {
        if (post_password_required() || is_attachment() || !has_post_thumbnail()) {
            return;
        }

        if (is_singular()) :
            ?>
            <div class="post-thumbnail">
                <?php the_post_thumbnail(); ?>
            </div><!-- .post-thumbnail -->
        <?php else : ?>
            <a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
                <?php
                the_post_thumbnail(
                    'post-thumbnail',
                    array(
                        'alt' => the_title_attribute(
                            array(
                                'echo' => false,
                            )
                        ),
                    )
                );
                ?>
            </a>
            <?php
        endif; // End is_singular().
    }
endif;

if (!function_exists('wp_body_open')) :
    /**
     * Shim for sites older than 5.2.
     *
     * @link https://core.trac.wordpress.org/ticket/12563
     */
    function wp_body_open() {
        do_action('wp_body_open');
    }
endif;

/**
 * Display music track information
 */
function artist_music_pro_track_meta() {
    if (get_post_type() !== 'music') {
        return;
    }

    $duration = get_post_meta(get_the_ID(), 'duration', true);
    $genre = get_post_meta(get_the_ID(), 'genre', true);
    $album = get_post_meta(get_the_ID(), 'album_name', true);
    $release_date = get_post_meta(get_the_ID(), 'release_date', true);

    echo '<div class="track-meta">';
    
    if ($duration) {
        echo '<span class="track-duration"><strong>' . __('Duration:', 'artist-music-pro') . '</strong> ' . esc_html(artist_music_pro_format_duration($duration)) . '</span>';
    }
    
    if ($genre) {
        echo '<span class="track-genre"><strong>' . __('Genre:', 'artist-music-pro') . '</strong> ' . esc_html($genre) . '</span>';
    }
    
    if ($album) {
        echo '<span class="track-album"><strong>' . __('Album:', 'artist-music-pro') . '</strong> ' . esc_html($album) . '</span>';
    }
    
    if ($release_date) {
        echo '<span class="track-release-date"><strong>' . __('Release Date:', 'artist-music-pro') . '</strong> ' . esc_html(date_i18n(get_option('date_format'), strtotime($release_date))) . '</span>';
    }
    
    echo '</div>';
}

/**
 * Display album information
 */
function artist_music_pro_album_meta() {
    if (get_post_type() !== 'album') {
        return;
    }

    $release_year = get_post_meta(get_the_ID(), 'release_year', true);
    $genre = get_post_meta(get_the_ID(), 'genre', true);
    $record_label = get_post_meta(get_the_ID(), 'record_label', true);
    $spotify_url = get_post_meta(get_the_ID(), 'spotify_url', true);
    $apple_music_url = get_post_meta(get_the_ID(), 'apple_music_url', true);

    echo '<div class="album-meta">';
    
    if ($release_year) {
        echo '<span class="album-year"><strong>' . __('Release Year:', 'artist-music-pro') . '</strong> ' . esc_html($release_year) . '</span>';
    }
    
    if ($genre) {
        echo '<span class="album-genre"><strong>' . __('Genre:', 'artist-music-pro') . '</strong> ' . esc_html($genre) . '</span>';
    }
    
    if ($record_label) {
        echo '<span class="album-label"><strong>' . __('Record Label:', 'artist-music-pro') . '</strong> ' . esc_html($record_label) . '</span>';
    }
    
    // Streaming links
    if ($spotify_url || $apple_music_url) {
        echo '<div class="streaming-links">';
        echo '<strong>' . __('Listen on:', 'artist-music-pro') . '</strong> ';
        
        if ($spotify_url) {
            echo '<a href="' . esc_url($spotify_url) . '" target="_blank" rel="noopener noreferrer" class="streaming-link spotify-link">' . __('Spotify', 'artist-music-pro') . '</a>';
        }
        
        if ($apple_music_url) {
            echo '<a href="' . esc_url($apple_music_url) . '" target="_blank" rel="noopener noreferrer" class="streaming-link apple-music-link">' . __('Apple Music', 'artist-music-pro') . '</a>';
        }
        
        echo '</div>';
    }
    
    echo '</div>';
}

/**
 * Display music player for track
 */
function artist_music_pro_track_player() {
    if (get_post_type() !== 'music') {
        return;
    }

    $audio_file = get_post_meta(get_the_ID(), 'audio_file', true);
    
    if (!$audio_file) {
        return;
    }

    $track_title = get_the_title();
    $artist_name = get_bloginfo('name');

    echo '<div class="single-track-player">';
    echo '<button class="btn btn-primary play-track-btn" onclick="playTrack(\'' . esc_url($audio_file) . '\', \'' . esc_attr($track_title) . '\', \'' . esc_attr($artist_name) . '\')">';
    echo '<span class="play-icon">▶</span> ' . __('Play Track', 'artist-music-pro');
    echo '</button>';
    echo '</div>';
}

/**
 * Display reading time estimate
 */
function artist_music_pro_reading_time() {
    $content = get_post_field('post_content', get_the_ID());
    $word_count = str_word_count(strip_tags($content));
    $reading_time = ceil($word_count / 200); // Assuming 200 words per minute

    if ($reading_time > 0) {
        printf(
            '<span class="reading-time">%s %s</span>',
            $reading_time,
            _n('min read', 'mins read', $reading_time, 'artist-music-pro')
        );
    }
}

/**
 * Display post navigation
 */
function artist_music_pro_post_navigation() {
    the_post_navigation(
        array(
            'prev_text'          => '<span class="nav-subtitle">' . esc_html__('Previous:', 'artist-music-pro') . '</span> <span class="nav-title">%title</span>',
            'next_text'          => '<span class="nav-subtitle">' . esc_html__('Next:', 'artist-music-pro') . '</span> <span class="nav-title">%title</span>',
            'in_same_term'       => false,
            'screen_reader_text' => __('Post navigation', 'artist-music-pro'),
        )
    );
}

/**
 * Display related posts
 */
function artist_music_pro_related_posts($posts_per_page = 3) {
    if (!is_single()) {
        return;
    }

    $current_post_id = get_the_ID();
    $current_post_type = get_post_type();
    
    // Get related posts based on categories for regular posts
    if ($current_post_type === 'post') {
        $categories = wp_get_post_categories($current_post_id);
        if (empty($categories)) {
            return;
        }
        
        $related_posts = get_posts(array(
            'category__in'   => $categories,
            'post__not_in'   => array($current_post_id),
            'posts_per_page' => $posts_per_page,
            'post_status'    => 'publish',
        ));
    } else {
        // For custom post types, get posts of the same type
        $related_posts = get_posts(array(
            'post_type'      => $current_post_type,
            'post__not_in'   => array($current_post_id),
            'posts_per_page' => $posts_per_page,
            'post_status'    => 'publish',
        ));
    }

    if (empty($related_posts)) {
        return;
    }

    echo '<section class="related-posts">';
    echo '<h3 class="related-posts-title">' . __('Related Posts', 'artist-music-pro') . '</h3>';
    echo '<div class="related-posts-grid">';

    foreach ($related_posts as $post) {
        setup_postdata($post);
        ?>
        <article class="related-post">
            <?php if (has_post_thumbnail($post->ID)) : ?>
                <a href="<?php echo get_permalink($post->ID); ?>" class="related-post-thumbnail">
                    <?php echo get_the_post_thumbnail($post->ID, 'medium'); ?>
                </a>
            <?php endif; ?>
            <div class="related-post-content">
                <h4 class="related-post-title">
                    <a href="<?php echo get_permalink($post->ID); ?>"><?php echo get_the_title($post->ID); ?></a>
                </h4>
                <div class="related-post-meta">
                    <?php echo get_the_date('', $post->ID); ?>
                </div>
            </div>
        </article>
        <?php
    }

    echo '</div>';
    echo '</section>';

    wp_reset_postdata();
}

/**
 * Display comments toggle for better mobile UX
 */
function artist_music_pro_comments_toggle() {
    if (!comments_open() && get_comments_number() == 0) {
        return;
    }

    $comments_number = get_comments_number();
    $comments_text = $comments_number == 1 ? __('1 Comment', 'artist-music-pro') : sprintf(__('%s Comments', 'artist-music-pro'), $comments_number);

    echo '<button class="comments-toggle" onclick="toggleComments()">';
    echo '<span class="comments-icon">💬</span> ';
    echo $comments_text;
    echo '</button>';
}

/**
 * Display custom logo with text fallback
 */
function artist_music_pro_site_logo() {
    if (has_custom_logo()) {
        echo '<div class="site-logo-wrapper">';
        the_custom_logo();
        echo '</div>';
    } else {
        echo '<div class="site-text-logo">';
        echo '<h1 class="site-title"><a href="' . esc_url(home_url('/')) . '" rel="home">' . esc_html(get_bloginfo('name')) . '</a></h1>';
        
        $description = get_bloginfo('description', 'display');
        if ($description || is_customize_preview()) {
            echo '<p class="site-description">' . $description . '</p>';
        }
        echo '</div>';
    }
}

/**
 * Display featured tracks carousel
 */
function artist_music_pro_featured_tracks_carousel() {
    $featured_tracks = artist_music_pro_get_featured_tracks(6);
    
    if (!$featured_tracks->have_posts()) {
        return;
    }

    echo '<div class="featured-tracks-carousel">';
    echo '<h3 class="carousel-title">' . __('Featured Tracks', 'artist-music-pro') . '</h3>';
    echo '<div class="tracks-carousel-wrapper">';
    echo '<div class="tracks-carousel">';

    while ($featured_tracks->have_posts()) {
        $featured_tracks->the_post();
        $audio_file = get_post_meta(get_the_ID(), 'audio_file', true);
        ?>
        <div class="carousel-track">
            <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('album-cover'); ?>
            <?php endif; ?>
            <div class="track-info">
                <h4><?php the_title(); ?></h4>
                <p><?php echo get_post_meta(get_the_ID(), 'album_name', true); ?></p>
                <?php if ($audio_file) : ?>
                    <button class="btn btn-sm btn-primary" onclick="playTrack('<?php echo esc_url($audio_file); ?>', '<?php the_title_attribute(); ?>', '<?php echo esc_attr(get_bloginfo('name')); ?>')">
                        <?php _e('Play', 'artist-music-pro'); ?>
                    </button>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }

    echo '</div>';
    echo '<button class="carousel-nav prev" onclick="moveCarousel(-1)">‹</button>';
    echo '<button class="carousel-nav next" onclick="moveCarousel(1)">›</button>';
    echo '</div>';
    echo '</div>';

    wp_reset_postdata();
}