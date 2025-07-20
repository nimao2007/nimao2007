<?php
/**
 * Custom widgets for Artist Music Pro theme
 *
 * @package Artist_Music_Pro
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register custom widgets
 */
function artist_music_pro_register_widgets() {
    register_widget('Artist_Music_Pro_Recent_Tracks_Widget');
    register_widget('Artist_Music_Pro_Social_Media_Widget');
    register_widget('Artist_Music_Pro_About_Widget');
}
add_action('widgets_init', 'artist_music_pro_register_widgets');

/**
 * Recent Tracks Widget
 */
class Artist_Music_Pro_Recent_Tracks_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'artist_music_pro_recent_tracks',
            __('Recent Tracks', 'artist-music-pro'),
            array(
                'description' => __('Display recent music tracks with play buttons.', 'artist-music-pro'),
                'classname' => 'widget_recent_tracks',
            )
        );
    }

    public function widget($args, $instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Recent Tracks', 'artist-music-pro');
        $number = !empty($instance['number']) ? absint($instance['number']) : 5;

        echo $args['before_widget'];

        if (!empty($title)) {
            echo $args['before_title'] . apply_filters('widget_title', $title) . $args['after_title'];
        }

        $tracks = new WP_Query(array(
            'post_type' => 'music',
            'posts_per_page' => $number,
            'post_status' => 'publish',
            'orderby' => 'date',
            'order' => 'DESC'
        ));

        if ($tracks->have_posts()) {
            echo '<div class="recent-tracks-widget">';
            while ($tracks->have_posts()) {
                $tracks->the_post();
                $audio_file = get_post_meta(get_the_ID(), 'audio_file', true);
                $duration = get_post_meta(get_the_ID(), 'duration', true);
                ?>
                <div class="track-widget-item">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="track-thumbnail">
                            <?php the_post_thumbnail('thumbnail'); ?>
                        </div>
                    <?php endif; ?>
                    <div class="track-details">
                        <h4 class="track-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h4>
                        <?php if ($duration) : ?>
                            <span class="track-duration"><?php echo esc_html(artist_music_pro_format_duration($duration)); ?></span>
                        <?php endif; ?>
                        <?php if ($audio_file) : ?>
                            <button class="btn btn-sm btn-primary widget-play-btn" onclick="playTrack('<?php echo esc_url($audio_file); ?>', '<?php the_title_attribute(); ?>', '<?php echo esc_attr(get_bloginfo('name')); ?>')">
                                ▶ <?php _e('Play', 'artist-music-pro'); ?>
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
                <?php
            }
            echo '</div>';
            wp_reset_postdata();
        } else {
            echo '<p>' . __('No tracks found.', 'artist-music-pro') . '</p>';
        }

        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Recent Tracks', 'artist-music-pro');
        $number = !empty($instance['number']) ? absint($instance['number']) : 5;
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title:', 'artist-music-pro'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('number')); ?>"><?php _e('Number of tracks to show:', 'artist-music-pro'); ?></label>
            <input class="tiny-text" id="<?php echo esc_attr($this->get_field_id('number')); ?>" name="<?php echo esc_attr($this->get_field_name('number')); ?>" type="number" step="1" min="1" value="<?php echo esc_attr($number); ?>" size="3">
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        $instance['number'] = (!empty($new_instance['number'])) ? absint($new_instance['number']) : 5;

        return $instance;
    }
}

/**
 * Social Media Widget
 */
class Artist_Music_Pro_Social_Media_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'artist_music_pro_social_media',
            __('Social Media Links', 'artist-music-pro'),
            array(
                'description' => __('Display social media links with icons.', 'artist-music-pro'),
                'classname' => 'widget_social_media',
            )
        );
    }

    public function widget($args, $instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Follow Me', 'artist-music-pro');
        $show_labels = !empty($instance['show_labels']) ? $instance['show_labels'] : false;

        echo $args['before_widget'];

        if (!empty($title)) {
            echo $args['before_title'] . apply_filters('widget_title', $title) . $args['after_title'];
        }

        $social_links = artist_music_pro_get_social_links();

        if (!empty($social_links)) {
            echo '<div class="social-media-widget">';
            foreach ($social_links as $network => $url) {
                $icon = artist_music_pro_get_social_icon($network);
                $label = $show_labels ? ucfirst($network) : '';
                
                printf(
                    '<a href="%s" target="_blank" rel="noopener noreferrer" class="social-link social-%s" aria-label="%s">%s%s</a>',
                    esc_url($url),
                    esc_attr($network),
                    esc_attr(ucfirst($network)),
                    $icon,
                    $label ? '<span class="social-label">' . esc_html($label) . '</span>' : ''
                );
            }
            echo '</div>';
        } else {
            echo '<p>' . __('No social media links configured.', 'artist-music-pro') . '</p>';
        }

        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Follow Me', 'artist-music-pro');
        $show_labels = !empty($instance['show_labels']) ? $instance['show_labels'] : false;
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title:', 'artist-music-pro'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <input class="checkbox" type="checkbox" <?php checked($show_labels); ?> id="<?php echo esc_attr($this->get_field_id('show_labels')); ?>" name="<?php echo esc_attr($this->get_field_name('show_labels')); ?>">
            <label for="<?php echo esc_attr($this->get_field_id('show_labels')); ?>"><?php _e('Show labels', 'artist-music-pro'); ?></label>
        </p>
        <p class="description">
            <?php _e('Configure social media URLs in the Customizer under "Social Media".', 'artist-music-pro'); ?>
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        $instance['show_labels'] = (!empty($new_instance['show_labels'])) ? 1 : 0;

        return $instance;
    }
}

/**
 * About Artist Widget
 */
class Artist_Music_Pro_About_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'artist_music_pro_about',
            __('About Artist', 'artist-music-pro'),
            array(
                'description' => __('Display artist information with photo and bio.', 'artist-music-pro'),
                'classname' => 'widget_about_artist',
            )
        );
    }

    public function widget($args, $instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('About', 'artist-music-pro');
        $image = !empty($instance['image']) ? $instance['image'] : '';
        $bio = !empty($instance['bio']) ? $instance['bio'] : '';
        $read_more_text = !empty($instance['read_more_text']) ? $instance['read_more_text'] : __('Read More', 'artist-music-pro');
        $read_more_url = !empty($instance['read_more_url']) ? $instance['read_more_url'] : '';

        echo $args['before_widget'];

        if (!empty($title)) {
            echo $args['before_title'] . apply_filters('widget_title', $title) . $args['after_title'];
        }

        echo '<div class="about-artist-widget">';

        if (!empty($image)) {
            echo '<div class="artist-photo">';
            echo '<img src="' . esc_url($image) . '" alt="' . esc_attr(get_bloginfo('name')) . '">';
            echo '</div>';
        }

        if (!empty($bio)) {
            echo '<div class="artist-bio">';
            echo '<p>' . wp_kses_post($bio) . '</p>';
            if (!empty($read_more_url)) {
                echo '<a href="' . esc_url($read_more_url) . '" class="read-more-link">' . esc_html($read_more_text) . '</a>';
            }
            echo '</div>';
        }

        echo '</div>';

        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('About', 'artist-music-pro');
        $image = !empty($instance['image']) ? $instance['image'] : '';
        $bio = !empty($instance['bio']) ? $instance['bio'] : '';
        $read_more_text = !empty($instance['read_more_text']) ? $instance['read_more_text'] : __('Read More', 'artist-music-pro');
        $read_more_url = !empty($instance['read_more_url']) ? $instance['read_more_url'] : '';
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title:', 'artist-music-pro'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('image')); ?>"><?php _e('Artist Photo URL:', 'artist-music-pro'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('image')); ?>" name="<?php echo esc_attr($this->get_field_name('image')); ?>" type="url" value="<?php echo esc_attr($image); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('bio')); ?>"><?php _e('Bio:', 'artist-music-pro'); ?></label>
            <textarea class="widefat" rows="5" id="<?php echo esc_attr($this->get_field_id('bio')); ?>" name="<?php echo esc_attr($this->get_field_name('bio')); ?>"><?php echo esc_textarea($bio); ?></textarea>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('read_more_text')); ?>"><?php _e('Read More Text:', 'artist-music-pro'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('read_more_text')); ?>" name="<?php echo esc_attr($this->get_field_name('read_more_text')); ?>" type="text" value="<?php echo esc_attr($read_more_text); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('read_more_url')); ?>"><?php _e('Read More URL:', 'artist-music-pro'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('read_more_url')); ?>" name="<?php echo esc_attr($this->get_field_name('read_more_url')); ?>" type="url" value="<?php echo esc_attr($read_more_url); ?>">
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        $instance['image'] = (!empty($new_instance['image'])) ? esc_url_raw($new_instance['image']) : '';
        $instance['bio'] = (!empty($new_instance['bio'])) ? wp_kses_post($new_instance['bio']) : '';
        $instance['read_more_text'] = (!empty($new_instance['read_more_text'])) ? sanitize_text_field($new_instance['read_more_text']) : '';
        $instance['read_more_url'] = (!empty($new_instance['read_more_url'])) ? esc_url_raw($new_instance['read_more_url']) : '';

        return $instance;
    }
}