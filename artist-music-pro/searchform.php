<?php
/**
 * Custom search form template
 *
 * @package Artist_Music_Pro
 */
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
    <div class="search-form-wrapper">
        <label for="search-field-<?php echo uniqid(); ?>" class="screen-reader-text">
            <?php _e('Search for:', 'artist-music-pro'); ?>
        </label>
        
        <div class="search-input-wrapper">
            <input type="search" 
                   id="search-field-<?php echo uniqid(); ?>" 
                   class="search-field" 
                   placeholder="<?php echo esc_attr__('Search posts, music, albums...', 'artist-music-pro'); ?>" 
                   value="<?php echo get_search_query(); ?>" 
                   name="s" 
                   autocomplete="off" />
            
            <button type="submit" class="search-submit" aria-label="<?php echo esc_attr__('Search', 'artist-music-pro'); ?>">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                </svg>
                <span class="search-text"><?php _e('Search', 'artist-music-pro'); ?></span>
            </button>
        </div>
        
        <!-- Advanced Search Options (initially hidden) -->
        <div class="search-options" style="display: none;">
            <div class="search-filters">
                <label class="search-filter-label">
                    <input type="radio" name="post_type" value="" checked>
                    <span><?php _e('All Content', 'artist-music-pro'); ?></span>
                </label>
                
                <label class="search-filter-label">
                    <input type="radio" name="post_type" value="post">
                    <span><?php _e('Blog Posts', 'artist-music-pro'); ?></span>
                </label>
                
                <label class="search-filter-label">
                    <input type="radio" name="post_type" value="music">
                    <span><?php _e('Music', 'artist-music-pro'); ?></span>
                </label>
                
                <label class="search-filter-label">
                    <input type="radio" name="post_type" value="album">
                    <span><?php _e('Albums', 'artist-music-pro'); ?></span>
                </label>
            </div>
        </div>
        
        <button type="button" class="search-options-toggle" aria-expanded="false">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                <path d="M3,17V19H9V17H3M3,5V7H13V5H3M13,21V19H21V17H13V15H11V21H13M7,9V11H3V13H7V15H9V9H7M21,13V11H11V13H21M15,9H17V7H21V5H17V3H15V9Z"/>
            </svg>
            <span><?php _e('Advanced', 'artist-music-pro'); ?></span>
        </button>
    </div>
</form>