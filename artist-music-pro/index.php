<?php
/**
 * The main template file
 *
 * @package Artist_Music_Pro
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

get_header(); ?>

<main id="primary" class="site-main">
    <?php if (is_home() || is_front_page()) : ?>
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="hero-content">
                <h1 class="hero-title"><?php echo get_theme_mod('hero_title', __('Welcome to My Music World', 'artist-music-pro')); ?></h1>
                <p class="hero-subtitle"><?php echo get_theme_mod('hero_subtitle', __('Singer • Songwriter • Artist', 'artist-music-pro')); ?></p>
                <div class="hero-buttons">
                    <a href="#music" class="btn btn-primary"><?php _e('Listen Now', 'artist-music-pro'); ?></a>
                    <a href="#about" class="btn btn-outline"><?php _e('About Me', 'artist-music-pro'); ?></a>
                </div>
            </div>
        </section>

        <!-- Music Section -->
        <section id="music" class="content-section">
            <div class="container">
                <h2 class="section-title"><?php _e('Latest Music', 'artist-music-pro'); ?></h2>
                
                <!-- Music Player -->
                <div class="music-player">
                    <div class="player-controls">
                        <button class="play-btn" onclick="togglePlay()">▶</button>
                        <div class="track-info">
                            <h4 id="current-track"><?php _e('Select a track', 'artist-music-pro'); ?></h4>
                            <p id="current-artist"><?php bloginfo('name'); ?></p>
                        </div>
                    </div>
                    <div class="progress-bar">
                        <div class="progress" id="progress"></div>
                    </div>
                    <audio id="audio-player" preload="metadata"></audio>
                </div>

                <!-- Music Grid -->
                <div class="music-grid">
                    <?php
                    // Query for music posts (you can create a custom post type for this)
                    $music_query = new WP_Query(array(
                        'post_type' => 'music',
                        'posts_per_page' => 6,
                        'meta_key' => 'featured',
                        'meta_value' => 'yes'
                    ));

                    if ($music_query->have_posts()) :
                        while ($music_query->have_posts()) : $music_query->the_post();
                    ?>
                        <div class="music-card">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('medium'); ?>
                            <?php else : ?>
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/default-album.jpg" alt="<?php the_title(); ?>">
                            <?php endif; ?>
                            <div class="music-card-content">
                                <h3><?php the_title(); ?></h3>
                                <p><?php echo get_post_meta(get_the_ID(), 'album_name', true); ?></p>
                                <?php
                                $audio_file = get_post_meta(get_the_ID(), 'audio_file', true);
                                if ($audio_file) :
                                ?>
                                    <button class="btn btn-primary" onclick="playTrack('<?php echo esc_url($audio_file); ?>', '<?php the_title(); ?>')">
                                        <?php _e('Play', 'artist-music-pro'); ?>
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php
                        endwhile;
                        wp_reset_postdata();
                    else :
                    ?>
                        <!-- Default music cards for demonstration -->
                        <div class="music-card">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/demo-album-1.jpg" alt="Demo Album 1">
                            <div class="music-card-content">
                                <h3><?php _e('My Latest Single', 'artist-music-pro'); ?></h3>
                                <p><?php _e('New Album 2024', 'artist-music-pro'); ?></p>
                                <button class="btn btn-primary"><?php _e('Play', 'artist-music-pro'); ?></button>
                            </div>
                        </div>
                        <div class="music-card">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/demo-album-2.jpg" alt="Demo Album 2">
                            <div class="music-card-content">
                                <h3><?php _e('Acoustic Sessions', 'artist-music-pro'); ?></h3>
                                <p><?php _e('Live Recordings', 'artist-music-pro'); ?></p>
                                <button class="btn btn-primary"><?php _e('Play', 'artist-music-pro'); ?></button>
                            </div>
                        </div>
                        <div class="music-card">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/demo-album-3.jpg" alt="Demo Album 3">
                            <div class="music-card-content">
                                <h3><?php _e('Greatest Hits', 'artist-music-pro'); ?></h3>
                                <p><?php _e('Best Of Collection', 'artist-music-pro'); ?></p>
                                <button class="btn btn-primary"><?php _e('Play', 'artist-music-pro'); ?></button>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <!-- About Section -->
        <section id="about" class="content-section about-section">
            <div class="container">
                <div class="about-content">
                    <div class="about-text">
                        <h2 class="section-title"><?php _e('About Me', 'artist-music-pro'); ?></h2>
                        <p><?php echo get_theme_mod('about_text', __('I am a passionate singer-songwriter who creates music that touches the soul. With over a decade of experience in the music industry, I blend traditional melodies with contemporary sounds to create something truly unique.', 'artist-music-pro')); ?></p>
                        <p><?php _e('My music tells stories of love, life, and human experiences that resonate with people from all walks of life.', 'artist-music-pro'); ?></p>
                        <a href="<?php echo get_permalink(get_page_by_path('about')); ?>" class="btn btn-primary"><?php _e('Read More', 'artist-music-pro'); ?></a>
                    </div>
                    <div class="about-image">
                        <img src="<?php echo get_theme_mod('about_image', get_template_directory_uri() . '/assets/images/artist-photo.jpg'); ?>" alt="<?php bloginfo('name'); ?>">
                    </div>
                </div>
            </div>
        </section>

        <!-- Blog Section -->
        <section class="content-section">
            <div class="container">
                <h2 class="section-title"><?php _e('Latest News', 'artist-music-pro'); ?></h2>
                <div class="music-grid">
                    <?php
                    $blog_query = new WP_Query(array(
                        'post_type' => 'post',
                        'posts_per_page' => 3
                    ));

                    if ($blog_query->have_posts()) :
                        while ($blog_query->have_posts()) : $blog_query->the_post();
                    ?>
                        <article class="music-card">
                            <?php if (has_post_thumbnail()) : ?>
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('medium'); ?>
                                </a>
                            <?php endif; ?>
                            <div class="music-card-content">
                                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                <p><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
                                <a href="<?php the_permalink(); ?>" class="btn btn-primary"><?php _e('Read More', 'artist-music-pro'); ?></a>
                            </div>
                        </article>
                    <?php
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>
            </div>
        </section>

    <?php else : ?>
        <!-- Regular blog posts -->
        <div class="container">
            <?php if (have_posts()) : ?>
                <div class="posts-container">
                    <?php while (have_posts()) : the_post(); ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>
                            <header class="post-header">
                                <h1 class="post-title">
                                    <?php if (is_singular()) : ?>
                                        <?php the_title(); ?>
                                    <?php else : ?>
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    <?php endif; ?>
                                </h1>
                                <div class="post-meta">
                                    <time datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date(); ?></time>
                                    <span class="meta-separator">•</span>
                                    <span class="post-author"><?php the_author(); ?></span>
                                    <?php if (has_category()) : ?>
                                        <span class="meta-separator">•</span>
                                        <?php the_category(', '); ?>
                                    <?php endif; ?>
                                </div>
                            </header>

                            <div class="post-content">
                                <?php if (is_singular()) : ?>
                                    <?php the_content(); ?>
                                <?php else : ?>
                                    <?php the_excerpt(); ?>
                                    <a href="<?php the_permalink(); ?>" class="btn btn-primary"><?php _e('Read More', 'artist-music-pro'); ?></a>
                                <?php endif; ?>
                            </div>

                            <?php if (is_singular() && (comments_open() || get_comments_number())) : ?>
                                <div class="comments-area">
                                    <?php comments_template(); ?>
                                </div>
                            <?php endif; ?>
                        </article>
                    <?php endwhile; ?>

                    <!-- Pagination -->
                    <div class="pagination-wrapper">
                        <?php
                        the_posts_pagination(array(
                            'prev_text' => __('Previous', 'artist-music-pro'),
                            'next_text' => __('Next', 'artist-music-pro'),
                        ));
                        ?>
                    </div>
                </div>
            <?php else : ?>
                <div class="no-posts">
                    <h2><?php _e('Nothing Found', 'artist-music-pro'); ?></h2>
                    <p><?php _e('It seems we can\'t find what you\'re looking for. Perhaps searching can help.', 'artist-music-pro'); ?></p>
                    <?php get_search_form(); ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</main>

<?php get_footer(); ?>