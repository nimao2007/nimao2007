<?php
/**
 * The template for displaying archive pages
 *
 * @package Artist_Music_Pro
 */

get_header(); ?>

<main id="primary" class="site-main">
    <div class="container">
        
        <!-- Archive Header -->
        <header class="archive-header">
            <?php if (is_category()) : ?>
                <div class="archive-title-wrapper">
                    <h1 class="archive-title">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M17.63 5.84C17.27 5.33 16.67 5 16 5L5 5.01C3.9 5.01 3 5.9 3 7v10c0 1.1.9 1.99 2 1.99L16 19c.67 0 1.27-.33 1.63-.84L22 12l-4.37-6.16z"/>
                        </svg>
                        <?php _e('Category:', 'artist-music-pro'); ?> <?php single_cat_title(); ?>
                    </h1>
                    <?php if (category_description()) : ?>
                        <div class="archive-description">
                            <?php echo category_description(); ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php elseif (is_tag()) : ?>
                <div class="archive-title-wrapper">
                    <h1 class="archive-title">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M21.41 11.58l-9-9C12.05 2.22 11.55 2 11 2H4c-1.1 0-2 .9-2 2v7c0 .55.22 1.05.59 1.42l9 9c.36.36.86.58 1.41.58.55 0 1.05-.22 1.41-.59l7-7c.37-.36.59-.86.59-1.41 0-.55-.23-1.06-.59-1.42zM5.5 7C4.67 7 4 6.33 4 5.5S4.67 4 5.5 4 7 4.67 7 5.5 6.33 7 5.5 7z"/>
                        </svg>
                        <?php _e('Tag:', 'artist-music-pro'); ?> <?php single_tag_title(); ?>
                    </h1>
                    <?php if (tag_description()) : ?>
                        <div class="archive-description">
                            <?php echo tag_description(); ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php elseif (is_author()) : ?>
                <div class="archive-title-wrapper">
                    <h1 class="archive-title">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                        </svg>
                        <?php _e('Author:', 'artist-music-pro'); ?> <?php echo get_the_author(); ?>
                    </h1>
                    <?php if (get_the_author_meta('description')) : ?>
                        <div class="archive-description">
                            <?php echo get_the_author_meta('description'); ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php elseif (is_date()) : ?>
                <div class="archive-title-wrapper">
                    <h1 class="archive-title">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
                        </svg>
                        <?php
                        if (is_year()) {
                            printf(__('Year: %s', 'artist-music-pro'), get_the_date('Y'));
                        } elseif (is_month()) {
                            printf(__('Month: %s', 'artist-music-pro'), get_the_date('F Y'));
                        } elseif (is_day()) {
                            printf(__('Day: %s', 'artist-music-pro'), get_the_date());
                        }
                        ?>
                    </h1>
                </div>
            <?php else : ?>
                <div class="archive-title-wrapper">
                    <h1 class="archive-title">
                        <?php the_archive_title(); ?>
                    </h1>
                    <?php if (get_the_archive_description()) : ?>
                        <div class="archive-description">
                            <?php the_archive_description(); ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </header>

        <!-- Category Filter (for main blog archive) -->
        <?php if (is_home() || (is_archive() && !is_author() && !is_date())) : ?>
            <div class="category-filter">
                <div class="filter-buttons">
                    <a href="<?php echo esc_url(get_post_type_archive_link('post')); ?>" 
                       class="filter-btn <?php echo !is_category() ? 'active' : ''; ?>">
                        <?php _e('All Posts', 'artist-music-pro'); ?>
                    </a>
                    <?php
                    $categories = get_categories(array(
                        'orderby' => 'count',
                        'order'   => 'DESC',
                        'number'  => 8,
                        'hide_empty' => true,
                    ));
                    
                    foreach ($categories as $category) :
                        $is_current = is_category($category->term_id);
                    ?>
                        <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" 
                           class="filter-btn <?php echo $is_current ? 'active' : ''; ?>">
                            <?php echo esc_html($category->name); ?>
                            <span class="post-count">(<?php echo $category->count; ?>)</span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Posts Grid -->
        <?php if (have_posts()) : ?>
            <div class="posts-grid">
                <?php while (have_posts()) : the_post(); ?>
                    
                    <article id="post-<?php the_ID(); ?>" <?php post_class('post-card'); ?>>
                        
                        <!-- Featured Image -->
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="post-card-image">
                                <a href="<?php the_permalink(); ?>" class="post-image-link">
                                    <?php the_post_thumbnail('medium_large', array('class' => 'post-thumbnail')); ?>
                                </a>
                                
                                <!-- Category Badge -->
                                <?php if (has_category()) : ?>
                                    <div class="post-categories-badge">
                                        <?php 
                                        $categories = get_the_category();
                                        if (!empty($categories)) {
                                            $primary_category = $categories[0];
                                            echo '<span class="category-badge">' . esc_html($primary_category->name) . '</span>';
                                        }
                                        ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <!-- Post Content -->
                        <div class="post-card-content">
                            
                            <!-- Post Meta -->
                            <div class="post-card-meta">
                                <span class="post-date">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
                                    </svg>
                                    <?php echo get_the_date(); ?>
                                </span>
                                
                                <span class="post-author">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                    </svg>
                                    <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                                        <?php the_author(); ?>
                                    </a>
                                </span>

                                <span class="reading-time">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M16.2,16.2L11,13V7H12.5V12.2L17,14.9L16.2,16.2Z"/>
                                    </svg>
                                    <?php artist_music_pro_reading_time(); ?>
                                </span>
                            </div>

                            <!-- Post Title -->
                            <h2 class="post-card-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>

                            <!-- Post Excerpt -->
                            <div class="post-card-excerpt">
                                <?php the_excerpt(); ?>
                            </div>

                            <!-- Post Footer -->
                            <div class="post-card-footer">
                                <a href="<?php the_permalink(); ?>" class="read-more-btn">
                                    <?php _e('Read More', 'artist-music-pro'); ?>
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M8.59,16.58L13.17,12L8.59,7.41L10,6L16,12L10,18L8.59,16.58Z"/>
                                    </svg>
                                </a>

                                <!-- Comments Count -->
                                <?php if (comments_open() || get_comments_number()) : ?>
                                    <span class="comments-count">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M9,22A1,1 0 0,1 8,21V18H4A2,2 0 0,1 2,16V4C2,2.89 2.9,2 4,2H20A2,2 0 0,1 22,4V16A2,2 0 0,1 20,18H13.9L10.2,21.71C10,21.9 9.75,22 9.5,22V22H9Z"/>
                                        </svg>
                                        <?php comments_number('0', '1', '%'); ?>
                                    </span>
                                <?php endif; ?>
                            </div>

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
                    'screen_reader_text' => __('Posts navigation', 'artist-music-pro'),
                ));
                ?>
            </nav>

        <?php else : ?>
            
            <!-- No Posts Found -->
            <div class="no-posts-found">
                <div class="no-posts-content">
                    <svg width="64" height="64" viewBox="0 0 24 24" fill="currentColor" class="no-posts-icon">
                        <path d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M12,4A8,8 0 0,1 20,12A8,8 0 0,1 12,20A8,8 0 0,1 4,12A8,8 0 0,1 12,4M12,6A6,6 0 0,0 6,12A6,6 0 0,0 12,18A6,6 0 0,0 18,12A6,6 0 0,0 12,6M12,8A4,4 0 0,1 16,12A4,4 0 0,1 12,16A4,4 0 0,1 8,12A4,4 0 0,1 12,8Z"/>
                    </svg>
                    <h2><?php _e('No posts found', 'artist-music-pro'); ?></h2>
                    <p>
                        <?php 
                        if (is_search()) {
                            _e('Sorry, no posts matched your search criteria. Please try different keywords.', 'artist-music-pro');
                        } else {
                            _e('It looks like there are no posts in this category yet.', 'artist-music-pro');
                        }
                        ?>
                    </p>
                    <div class="no-posts-actions">
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary">
                            <?php _e('Go to Homepage', 'artist-music-pro'); ?>
                        </a>
                        <?php if (!is_search()) : ?>
                            <a href="<?php echo esc_url(home_url('/blog')); ?>" class="btn btn-outline">
                                <?php _e('View All Posts', 'artist-music-pro'); ?>
                            </a>
                        <?php endif; ?>
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