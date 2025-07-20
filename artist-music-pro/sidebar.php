<?php
/**
 * The sidebar containing the main widget area
 *
 * @package Artist_Music_Pro
 */

if (!is_active_sidebar('sidebar-1')) {
    return;
}
?>

<aside id="secondary" class="widget-area sidebar" role="complementary">
    <div class="sidebar-inner">
        <?php dynamic_sidebar('sidebar-1'); ?>
        
        <!-- Default widgets if no widgets are added -->
        <?php if (!wp_get_sidebars_widgets()['sidebar-1']) : ?>
            
            <!-- Search Widget -->
            <section class="widget widget_search">
                <h2 class="widget-title"><?php _e('Search', 'artist-music-pro'); ?></h2>
                <?php get_search_form(); ?>
            </section>

            <!-- Recent Posts Widget -->
            <section class="widget widget_recent_entries">
                <h2 class="widget-title"><?php _e('Recent Posts', 'artist-music-pro'); ?></h2>
                <ul>
                    <?php
                    $recent_posts = wp_get_recent_posts(array(
                        'numberposts' => 5,
                        'post_status' => 'publish'
                    ));
                    
                    foreach ($recent_posts as $post_item) :
                        $post_id = $post_item['ID'];
                        $post_title = $post_item['post_title'];
                        $post_date = $post_item['post_date'];
                        $permalink = get_permalink($post_id);
                    ?>
                        <li>
                            <a href="<?php echo esc_url($permalink); ?>">
                                <?php echo esc_html($post_title); ?>
                            </a>
                            <span class="post-date"><?php echo date_i18n(get_option('date_format'), strtotime($post_date)); ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </section>

            <!-- Categories Widget -->
            <section class="widget widget_categories">
                <h2 class="widget-title"><?php _e('Categories', 'artist-music-pro'); ?></h2>
                <ul>
                    <?php
                    $categories = get_categories(array(
                        'orderby' => 'count',
                        'order'   => 'DESC',
                        'number'  => 10,
                        'hide_empty' => true,
                    ));
                    
                    foreach ($categories as $category) :
                    ?>
                        <li class="cat-item">
                            <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>">
                                <?php echo esc_html($category->name); ?>
                            </a>
                            <span class="post-count">(<?php echo $category->count; ?>)</span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </section>

            <!-- Tags Widget -->
            <?php
            $tags = get_tags(array(
                'orderby' => 'count',
                'order'   => 'DESC',
                'number'  => 20,
                'hide_empty' => true,
            ));
            
            if (!empty($tags)) :
            ?>
                <section class="widget widget_tag_cloud">
                    <h2 class="widget-title"><?php _e('Tags', 'artist-music-pro'); ?></h2>
                    <div class="tagcloud">
                        <?php foreach ($tags as $tag) : ?>
                            <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" 
                               class="tag-link" 
                               title="<?php echo esc_attr($tag->count . ' ' . __('posts', 'artist-music-pro')); ?>">
                                <?php echo esc_html($tag->name); ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endif; ?>

            <!-- Archives Widget -->
            <section class="widget widget_archive">
                <h2 class="widget-title"><?php _e('Archives', 'artist-music-pro'); ?></h2>
                <ul>
                    <?php wp_get_archives(array(
                        'type' => 'monthly',
                        'limit' => 12,
                        'show_post_count' => true,
                    )); ?>
                </ul>
            </section>

            <!-- About Widget -->
            <section class="widget widget_text">
                <h2 class="widget-title"><?php _e('About', 'artist-music-pro'); ?></h2>
                <div class="textwidget">
                    <p><?php _e('Welcome to my blog! Here I share my thoughts about music, life, and creativity. Stay tuned for the latest updates and insights.', 'artist-music-pro'); ?></p>
                </div>
            </section>

        <?php endif; ?>
    </div>
</aside><!-- #secondary -->