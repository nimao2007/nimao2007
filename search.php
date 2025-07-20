<?php
/**
 * The template for displaying search results pages
 *
 * @package Artist_Music_Pro
 */

get_header(); ?>

<main id="primary" class="site-main">
    <div class="container">
        
        <!-- Search Header -->
        <header class="search-header archive-header">
            <div class="archive-title-wrapper">
                <h1 class="archive-title search-title">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                    </svg>
                    <?php
                    printf(
                        esc_html__('Search Results for: %s', 'artist-music-pro'),
                        '<span class="search-query">' . get_search_query() . '</span>'
                    );
                    ?>
                </h1>
                
                <?php if (have_posts()) : ?>
                    <div class="search-results-count">
                        <?php
                        global $wp_query;
                        printf(
                            esc_html(_n(
                                'Found %d result',
                                'Found %d results',
                                $wp_query->found_posts,
                                'artist-music-pro'
                            )),
                            number_format_i18n($wp_query->found_posts)
                        );
                        ?>
                    </div>
                <?php endif; ?>
            </div>
        </header>

        <!-- Search Form -->
        <div class="search-form-container">
            <div class="search-form-wrapper">
                <?php get_search_form(); ?>
                <p class="search-form-help">
                    <?php _e('Try different keywords or browse our categories below.', 'artist-music-pro'); ?>
                </p>
            </div>
        </div>

        <!-- Search Results -->
        <?php if (have_posts()) : ?>
            
            <!-- Results Type Filter -->
            <div class="search-filter">
                <div class="filter-buttons">
                    <?php
                    $current_post_type = get_query_var('post_type') ?: 'all';
                    
                    // Count results by post type
                    $post_counts = array();
                    $temp_query = new WP_Query(array(
                        's' => get_search_query(),
                        'post_type' => array('post', 'music', 'album'),
                        'posts_per_page' => -1,
                        'fields' => 'ids'
                    ));
                    
                    while ($temp_query->have_posts()) {
                        $temp_query->the_post();
                        $type = get_post_type();
                        $post_counts[$type] = isset($post_counts[$type]) ? $post_counts[$type] + 1 : 1;
                    }
                    wp_reset_postdata();
                    
                    $total_count = array_sum($post_counts);
                    ?>
                    
                    <a href="<?php echo esc_url(add_query_arg('post_type', '', get_search_link())); ?>" 
                       class="filter-btn <?php echo ($current_post_type === 'all') ? 'active' : ''; ?>">
                        <?php _e('All Results', 'artist-music-pro'); ?>
                        <span class="post-count">(<?php echo $total_count; ?>)</span>
                    </a>
                    
                    <?php if (isset($post_counts['post'])) : ?>
                        <a href="<?php echo esc_url(add_query_arg('post_type', 'post', get_search_link())); ?>" 
                           class="filter-btn <?php echo ($current_post_type === 'post') ? 'active' : ''; ?>">
                            <?php _e('Blog Posts', 'artist-music-pro'); ?>
                            <span class="post-count">(<?php echo $post_counts['post']; ?>)</span>
                        </a>
                    <?php endif; ?>
                    
                    <?php if (isset($post_counts['music'])) : ?>
                        <a href="<?php echo esc_url(add_query_arg('post_type', 'music', get_search_link())); ?>" 
                           class="filter-btn <?php echo ($current_post_type === 'music') ? 'active' : ''; ?>">
                            <?php _e('Music', 'artist-music-pro'); ?>
                            <span class="post-count">(<?php echo $post_counts['music']; ?>)</span>
                        </a>
                    <?php endif; ?>
                    
                    <?php if (isset($post_counts['album'])) : ?>
                        <a href="<?php echo esc_url(add_query_arg('post_type', 'album', get_search_link())); ?>" 
                           class="filter-btn <?php echo ($current_post_type === 'album') ? 'active' : ''; ?>">
                            <?php _e('Albums', 'artist-music-pro'); ?>
                            <span class="post-count">(<?php echo $post_counts['album']; ?>)</span>
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Search Results Grid -->
            <div class="search-results-grid">
                <?php while (have_posts()) : the_post(); ?>
                    
                    <article id="post-<?php the_ID(); ?>" <?php post_class('search-result-item'); ?>>
                        
                        <!-- Post Type Badge -->
                        <div class="post-type-badge">
                            <?php
                            $post_type = get_post_type();
                            switch ($post_type) {
                                case 'music':
                                    echo '<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z"/></svg>';
                                    echo esc_html__('Music', 'artist-music-pro');
                                    break;
                                case 'album':
                                    echo '<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M12,4A8,8 0 0,1 20,12A8,8 0 0,1 12,20A8,8 0 0,1 4,12A8,8 0 0,1 12,4M12,6A6,6 0 0,0 6,12A6,6 0 0,0 12,18A6,6 0 0,0 18,12A6,6 0 0,0 12,6M12,8A4,4 0 0,1 16,12A4,4 0 0,1 12,16A4,4 0 0,1 8,12A4,4 0 0,1 12,8Z"/></svg>';
                                    echo esc_html__('Album', 'artist-music-pro');
                                    break;
                                default:
                                    echo '<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>';
                                    echo esc_html__('Post', 'artist-music-pro');
                            }
                            ?>
                        </div>

                        <!-- Featured Image -->
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="search-result-image">
                                <a href="<?php the_permalink(); ?>" class="post-image-link">
                                    <?php the_post_thumbnail('medium', array('class' => 'search-thumbnail')); ?>
                                </a>
                            </div>
                        <?php endif; ?>

                        <!-- Content -->
                        <div class="search-result-content">
                            
                            <!-- Meta -->
                            <div class="search-result-meta">
                                <span class="post-date">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
                                    </svg>
                                    <?php echo get_the_date(); ?>
                                </span>
                                
                                <?php if (get_post_type() === 'post' && has_category()) : ?>
                                    <span class="post-categories">
                                        <?php the_category(', '); ?>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <!-- Title -->
                            <h2 class="search-result-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>

                            <!-- Excerpt -->
                            <div class="search-result-excerpt">
                                <?php 
                                $excerpt = get_the_excerpt();
                                $search_query = get_search_query();
                                
                                // Highlight search terms
                                if ($search_query) {
                                    $excerpt = preg_replace('/(' . preg_quote($search_query, '/') . ')/i', '<mark>$1</mark>', $excerpt);
                                }
                                
                                echo $excerpt;
                                ?>
                            </div>

                            <!-- Special meta for music/album -->
                            <?php if (get_post_type() === 'music') : ?>
                                <div class="music-meta">
                                    <?php
                                    $duration = get_post_meta(get_the_ID(), '_music_duration', true);
                                    $genre = get_post_meta(get_the_ID(), '_music_genre', true);
                                    
                                    if ($duration) :
                                    ?>
                                        <span class="music-duration">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M16.2,16.2L11,13V7H12.5V12.2L17,14.9L16.2,16.2Z"/>
                                            </svg>
                                            <?php echo esc_html($duration); ?>
                                        </span>
                                    <?php endif; ?>
                                    
                                    <?php if ($genre) : ?>
                                        <span class="music-genre">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z"/>
                                            </svg>
                                            <?php echo esc_html($genre); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            <?php elseif (get_post_type() === 'album') : ?>
                                <div class="album-meta">
                                    <?php
                                    $release_date = get_post_meta(get_the_ID(), '_album_release_date', true);
                                    $tracks_count = get_post_meta(get_the_ID(), '_album_tracks_count', true);
                                    
                                    if ($release_date) :
                                    ?>
                                        <span class="album-release">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
                                            </svg>
                                            <?php echo esc_html($release_date); ?>
                                        </span>
                                    <?php endif; ?>
                                    
                                    <?php if ($tracks_count) : ?>
                                        <span class="album-tracks">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M15,6H3V8H15V6M15,10H3V12H15V10M3,16H11V14H3V16Z"/>
                                            </svg>
                                            <?php printf(_n('%d track', '%d tracks', $tracks_count, 'artist-music-pro'), $tracks_count); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                        </div>
                    </article>

                <?php endwhile; ?>
            </div>

            <!-- Pagination -->
            <nav class="pagination-nav">
                <?php
                the_posts_pagination(array(
                    'mid_size'  => 2,
                    'prev_text' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M15.41,16.58L10.83,12L15.41,7.41L14,6L8,12L14,18L15.41,16.58Z"/></svg>' . __('Previous', 'artist-music-pro'),
                    'next_text' => __('Next', 'artist-music-pro') . '<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M8.59,16.58L13.17,12L8.59,7.41L10,6L16,12L10,18L8.59,16.58Z"/></svg>',
                    'screen_reader_text' => __('Search results navigation', 'artist-music-pro'),
                ));
                ?>
            </nav>

        <?php else : ?>
            
            <!-- No Search Results -->
            <div class="no-search-results">
                <div class="no-results-content">
                    <svg width="64" height="64" viewBox="0 0 24 24" fill="currentColor" class="no-results-icon">
                        <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                        <path d="M6.47 10.82l-.95-.95L4.5 10.89l.95.95-.47.47-.95-.95-1.02 1.02.95.95-.47.47-.95-.95L1 13.88l.95.95z" opacity="0.5"/>
                    </svg>
                    <h2><?php _e('No results found', 'artist-music-pro'); ?></h2>
                    <p>
                        <?php
                        printf(
                            esc_html__('Sorry, no results were found for "%s". Please try different keywords or browse our content below.', 'artist-music-pro'),
                            '<strong>' . get_search_query() . '</strong>'
                        );
                        ?>
                    </p>
                    
                    <!-- Search Suggestions -->
                    <div class="search-suggestions">
                        <h3><?php _e('Search Suggestions:', 'artist-music-pro'); ?></h3>
                        <ul>
                            <li><?php _e('Check your spelling', 'artist-music-pro'); ?></li>
                            <li><?php _e('Try more general keywords', 'artist-music-pro'); ?></li>
                            <li><?php _e('Try different keywords', 'artist-music-pro'); ?></li>
                            <li><?php _e('Browse our categories below', 'artist-music-pro'); ?></li>
                        </ul>
                    </div>
                    
                    <!-- Popular Categories -->
                    <?php
                    $popular_categories = get_categories(array(
                        'orderby' => 'count',
                        'order' => 'DESC',
                        'number' => 6,
                        'hide_empty' => true,
                    ));
                    
                    if (!empty($popular_categories)) :
                    ?>
                        <div class="popular-categories">
                            <h3><?php _e('Popular Categories:', 'artist-music-pro'); ?></h3>
                            <div class="category-links">
                                <?php foreach ($popular_categories as $category) : ?>
                                    <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" class="category-link">
                                        <?php echo esc_html($category->name); ?>
                                        <span class="category-count">(<?php echo $category->count; ?>)</span>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <div class="no-results-actions">
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary">
                            <?php _e('Go to Homepage', 'artist-music-pro'); ?>
                        </a>
                        <a href="<?php echo esc_url(home_url('/blog')); ?>" class="btn btn-outline">
                            <?php _e('Browse Blog', 'artist-music-pro'); ?>
                        </a>
                    </div>
                </div>
            </div>

        <?php endif; ?>

    </div>
</main>

<?php
get_sidebar();
get_footer();
?>