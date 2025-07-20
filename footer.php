    </div><!-- #content -->

    <footer id="colophon" class="site-footer" role="contentinfo">
        <div class="container">
            <div class="footer-content">
                <!-- About Section -->
                <div class="footer-section">
                    <h4><?php _e('About', 'artist-music-pro'); ?></h4>
                    <p><?php echo get_theme_mod('footer_about_text', __('Passionate singer-songwriter creating music that touches the soul. Follow my journey and stay updated with latest releases.', 'artist-music-pro')); ?></p>
                </div>

                <!-- Quick Links -->
                <div class="footer-section">
                    <h4><?php _e('Quick Links', 'artist-music-pro'); ?></h4>
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer',
                        'container'      => false,
                        'menu_class'     => 'footer-menu',
                        'fallback_cb'    => 'artist_music_pro_footer_menu_fallback',
                    ));
                    ?>
                </div>

                <!-- Contact Info -->
                <div class="footer-section">
                    <h4><?php _e('Contact', 'artist-music-pro'); ?></h4>
                    <div class="contact-info">
                        <?php if (get_theme_mod('contact_email')) : ?>
                            <p><strong><?php _e('Email:', 'artist-music-pro'); ?></strong> 
                                <a href="mailto:<?php echo esc_attr(get_theme_mod('contact_email')); ?>">
                                    <?php echo esc_html(get_theme_mod('contact_email')); ?>
                                </a>
                            </p>
                        <?php endif; ?>
                        
                        <?php if (get_theme_mod('contact_phone')) : ?>
                            <p><strong><?php _e('Phone:', 'artist-music-pro'); ?></strong> 
                                <a href="tel:<?php echo esc_attr(get_theme_mod('contact_phone')); ?>">
                                    <?php echo esc_html(get_theme_mod('contact_phone')); ?>
                                </a>
                            </p>
                        <?php endif; ?>
                        
                        <?php if (get_theme_mod('contact_address')) : ?>
                            <p><strong><?php _e('Address:', 'artist-music-pro'); ?></strong> 
                                <?php echo esc_html(get_theme_mod('contact_address')); ?>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Newsletter Signup -->
                <div class="footer-section">
                    <h4><?php _e('Stay Updated', 'artist-music-pro'); ?></h4>
                    <p><?php _e('Subscribe to get notified about new releases and upcoming shows.', 'artist-music-pro'); ?></p>
                    
                    <!-- Newsletter Form -->
                    <form class="newsletter-form" action="#" method="post">
                        <div class="form-group">
                            <input type="email" name="newsletter_email" placeholder="<?php _e('Your email address', 'artist-music-pro'); ?>" required>
                            <button type="submit" class="btn btn-primary"><?php _e('Subscribe', 'artist-music-pro'); ?></button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Social Media Links -->
            <div class="social-links">
                <?php if (get_theme_mod('social_facebook')) : ?>
                    <a href="<?php echo esc_url(get_theme_mod('social_facebook')); ?>" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>
                <?php endif; ?>

                <?php if (get_theme_mod('social_instagram')) : ?>
                    <a href="<?php echo esc_url(get_theme_mod('social_instagram')); ?>" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </a>
                <?php endif; ?>

                <?php if (get_theme_mod('social_twitter')) : ?>
                    <a href="<?php echo esc_url(get_theme_mod('social_twitter')); ?>" target="_blank" rel="noopener noreferrer" aria-label="Twitter">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                        </svg>
                    </a>
                <?php endif; ?>

                <?php if (get_theme_mod('social_youtube')) : ?>
                    <a href="<?php echo esc_url(get_theme_mod('social_youtube')); ?>" target="_blank" rel="noopener noreferrer" aria-label="YouTube">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                        </svg>
                    </a>
                <?php endif; ?>

                <?php if (get_theme_mod('social_spotify')) : ?>
                    <a href="<?php echo esc_url(get_theme_mod('social_spotify')); ?>" target="_blank" rel="noopener noreferrer" aria-label="Spotify">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 0C5.4 0 0 5.4 0 12s5.4 12 12 12 12-5.4 12-12S18.66 0 12 0zm5.521 17.34c-.24.359-.66.48-1.021.24-2.82-1.74-6.36-2.101-10.561-1.141-.418.122-.779-.179-.899-.539-.12-.421.18-.78.54-.9 4.56-1.021 8.52-.6 11.64 1.32.42.18.479.659.301 1.02zm1.44-3.3c-.301.42-.841.6-1.262.3-3.239-1.98-8.159-2.58-11.939-1.38-.479.12-1.02-.12-1.14-.6-.12-.48.12-1.021.6-1.141C9.6 9.9 15 10.561 18.72 12.84c.361.181.54.78.241 1.2zm.12-3.36C15.24 8.4 8.82 8.16 5.16 9.301c-.6.179-1.2-.181-1.38-.721-.18-.601.18-1.2.72-1.381 4.26-1.26 11.28-1.02 15.721 1.621.539.3.719 1.02.42 1.56-.299.421-1.02.599-1.559.3z"/>
                        </svg>
                    </a>
                <?php endif; ?>

                <?php if (get_theme_mod('social_soundcloud')) : ?>
                    <a href="<?php echo esc_url(get_theme_mod('social_soundcloud')); ?>" target="_blank" rel="noopener noreferrer" aria-label="SoundCloud">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M1.175 12.225c-.051 0-.094.046-.101.1l-.233 2.154.233 2.105c.007.058.05.098.101.098.05 0 .09-.04.099-.098l.255-2.105-.255-2.154c-.009-.057-.049-.1-.099-.1zm1.525.3c-.058 0-.106.053-.113.115l-.193 1.855.193 1.81c.007.067.055.115.113.115.057 0 .104-.048.113-.115l.214-1.81-.214-1.855c-.009-.062-.056-.115-.113-.115zm1.552.318c-.062 0-.111.058-.123.122l-.176 1.537.176 1.486c.012.066.061.117.123.117.061 0 .111-.051.124-.117l.194-1.486-.194-1.537c-.013-.064-.063-.122-.124-.122zm1.526.24c-.067 0-.121.063-.134.134l-.157 1.299.157 1.242c.013.075.067.134.134.134.066 0 .12-.059.133-.134l.175-1.242-.175-1.299c-.013-.071-.067-.134-.133-.134zm1.533.152c-.071 0-.129.068-.142.142l-.138 1.147.138 1.094c.013.078.071.14.142.14.07 0 .128-.062.14-.14l.155-1.094-.155-1.147c-.012-.074-.07-.142-.14-.142zm1.538.1c-.074 0-.133.072-.147.147l-.122.995.122.948c.014.079.073.147.147.147.073 0 .131-.068.145-.147l.139-.948-.139-.995c-.014-.075-.072-.147-.145-.147zm1.526.07c-.078 0-.14.077-.154.154l-.105.871.105.822c.014.081.076.154.154.154.077 0 .139-.073.153-.154l.12-.822-.12-.871c-.014-.077-.076-.154-.153-.154zm1.534.055c-.081 0-.147.081-.161.161l-.09.816.09.771c.014.084.08.16.161.16.08 0 .146-.076.16-.16l.102-.771-.102-.816c-.014-.08-.08-.161-.16-.161zm1.538.046c-.084 0-.151.085-.166.166l-.074.77.074.726c.015.087.082.166.166.166.083 0 .15-.079.164-.166l.086-.726-.086-.77c-.014-.081-.081-.166-.164-.166zm1.526.039c-.087 0-.155.089-.169.169l-.059.731.059.689c.014.09.082.169.169.169.086 0 .154-.079.168-.169l.067-.689-.067-.731c-.014-.08-.082-.169-.168-.169zm1.535.034c-.09 0-.159.094-.173.173l-.043.697.043.654c.014.093.083.173.173.173.089 0 .158-.08.172-.173l.05-.654-.05-.697c-.014-.079-.083-.173-.172-.173zm1.528.029c-.093 0-.162.098-.176.176l-.028.668.028.627c.014.096.083.176.176.176.092 0 .161-.08.175-.176l.033-.627-.033-.668c-.014-.078-.083-.176-.175-.176zm1.535.025c-.096 0-.165.102-.179.179l-.013.664.013.624c.014.099.083.179.179.179.095 0 .164-.08.178-.179l.015-.624-.015-.664c-.014-.077-.083-.179-.178-.179zm1.526.021c-.099 0-.168.106-.182.182l.001.661-.001.622c.014.102.083.182.182.182.098 0 .167-.08.181-.182l.002-.622-.002-.661c-.014-.076-.083-.182-.181-.182zm1.535.018c-.102 0-.171.11-.185.185v.658c0 .021.001.042.001.063l-.001.559c.014.105.083.185.185.185.101 0 .17-.08.184-.185v-.622c0-.021 0-.042 0-.063v-.595c-.014-.075-.083-.185-.184-.185zm4.079.294c-.48 0-.918.2-1.235.522a2.591 2.591 0 0 0-2.363-1.574c-.171 0-.338.017-.5.049v4.413h4.098c.48 0 .87-.39.87-.87s-.39-.87-.87-.87z"/>
                        </svg>
                    </a>
                <?php endif; ?>
            </div>

            <!-- Copyright -->
            <div class="site-info">
                <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. <?php _e('All rights reserved.', 'artist-music-pro'); ?></p>
                <p><?php _e('Designed with ♪ for music lovers', 'artist-music-pro'); ?></p>
            </div>
        </div>
    </footer>
</div><!-- #page -->

<?php wp_footer(); ?>

<?php
// Footer menu fallback function
function artist_music_pro_footer_menu_fallback() {
    echo '<ul class="footer-menu">';
    echo '<li><a href="' . esc_url(home_url('/')) . '">' . __('Home', 'artist-music-pro') . '</a></li>';
    echo '<li><a href="' . esc_url(home_url('/about')) . '">' . __('About', 'artist-music-pro') . '</a></li>';
    echo '<li><a href="' . esc_url(home_url('/music')) . '">' . __('Music', 'artist-music-pro') . '</a></li>';
    echo '<li><a href="' . esc_url(home_url('/contact')) . '">' . __('Contact', 'artist-music-pro') . '</a></li>';
    echo '<li><a href="' . esc_url(home_url('/privacy-policy')) . '">' . __('Privacy Policy', 'artist-music-pro') . '</a></li>';
    echo '</ul>';
}
?>

</body>
</html>