<?php
/**
 * Template Name: Musical Showcase
 * 
 * Special template showcasing unique musical elements and premium Farsi typography
 */

get_header(); ?>

<div class="musical-showcase-page">
    <!-- Musical Hero Section -->
    <section class="musical-hero" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%); min-height: 60vh; display: flex; align-items: center; position: relative; overflow: hidden;">
        
        <!-- Floating Musical Notes -->
        <div class="floating-notes" style="position: absolute; width: 100%; height: 100%; pointer-events: none;">
            <span class="musical-note" style="position: absolute; top: 10%; left: 10%; animation-delay: 0s;">♪</span>
            <span class="musical-note" style="position: absolute; top: 30%; right: 15%; animation-delay: 1s;">♫</span>
            <span class="musical-note" style="position: absolute; top: 50%; left: 80%; animation-delay: 2s;">♪</span>
            <span class="musical-note" style="position: absolute; top: 70%; left: 20%; animation-delay: 3s;">♬</span>
            <span class="musical-note" style="position: absolute; top: 20%; left: 60%; animation-delay: 4s;">♭</span>
            <span class="musical-note" style="position: absolute; top: 80%; right: 30%; animation-delay: 2.5s;">♯</span>
        </div>

        <div class="container">
            <div class="musical-hero-content" style="text-align: center; color: white; z-index: 2; position: relative;">
                <h1 style="font-size: 3.5rem; margin-bottom: var(--spacing-lg); text-shadow: 0 4px 15px rgba(0,0,0,0.3); background: linear-gradient(45deg, #fff, #f0f0f0); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                    <?php _e('🎵 موزیک و هنر 🎵', 'artist-music-pro'); ?>
                </h1>
                <p style="font-size: 1.4rem; margin-bottom: var(--spacing-xl); opacity: 0.95; font-family: var(--font-artistic);">
                    <?php _e('تجربه‌ای منحصر به فرد از موسیقی و هنر با طراحی زیبا', 'artist-music-pro'); ?>
                </p>
                <div style="display: flex; gap: var(--spacing-md); justify-content: center; flex-wrap: wrap;">
                    <a href="#music" class="btn btn-gold" style="font-family: var(--font-primary);">
                        🎼 <?php _e('موزیک‌ها', 'artist-music-pro'); ?>
                    </a>
                    <a href="#albums" class="btn btn-outline">
                        💿 <?php _e('آلبوم‌ها', 'artist-music-pro'); ?>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Musical Section Divider -->
    <div class="section-divider"></div>

    <!-- Featured Content with Musical Cards -->
    <section class="musical-features" style="padding: var(--spacing-xxxl) 0; background: var(--surface-color);">
        <div class="container">
            <h2 style="text-align: center; margin-bottom: var(--spacing-xxl); font-family: var(--font-artistic);" dir="rtl">
                ✨ ویژگی‌های منحصر به فرد ✨
            </h2>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: var(--spacing-xl); margin-bottom: var(--spacing-xxl);">
                
                <!-- Premium Typography Card -->
                <div class="musical-card" style="background: white; border-radius: var(--radius-xl); padding: var(--spacing-xl); box-shadow: var(--shadow-lg); transition: all var(--transition-normal); border: 1px solid var(--border-color);">
                    <div style="text-align: center; margin-bottom: var(--spacing-lg);">
                        <span style="font-size: 3rem; display: block; margin-bottom: var(--spacing-md);">🎨</span>
                        <h3 style="font-family: var(--font-artistic); color: var(--primary-color);" dir="rtl">
                            فونت‌های فارسی پریمیوم
                        </h3>
                    </div>
                    <p style="font-family: var(--font-primary); line-height: 1.9; text-align: right;" dir="rtl">
                        استفاده از بهترین فونت‌های فارسی شامل وزیر، شهرزاد نو، امیری و نستعلیق برای نمایش زیبای متن‌های فارسی
                    </p>
                </div>

                <!-- Musical Design Card -->
                <div class="musical-card" style="background: white; border-radius: var(--radius-xl); padding: var(--spacing-xl); box-shadow: var(--shadow-lg); transition: all var(--transition-normal); border: 1px solid var(--border-color);">
                    <div style="text-align: center; margin-bottom: var(--spacing-lg);">
                        <span style="font-size: 3rem; display: block; margin-bottom: var(--spacing-md);">🎵</span>
                        <h3 style="font-family: var(--font-artistic); color: var(--primary-color);" dir="rtl">
                            طراحی موزیکال منحصر به فرد
                        </h3>
                    </div>
                    <p style="font-family: var(--font-primary); line-height: 1.9; text-align: right;" dir="rtl">
                        المان‌های موزیکال زیبا با انیمیشن‌های نرم، گرادیانت‌های هنری و سایه‌های حرفه‌ای برای تجربه‌ای فوق‌العاده
                    </p>
                </div>

                <!-- RTL Support Card -->
                <div class="musical-card" style="background: white; border-radius: var(--radius-xl); padding: var(--spacing-xl); box-shadow: var(--shadow-lg); transition: all var(--transition-normal); border: 1px solid var(--border-color);">
                    <div style="text-align: center; margin-bottom: var(--spacing-lg);">
                        <span style="font-size: 3rem; display: block; margin-bottom: var(--spacing-md);">🌟</span>
                        <h3 style="font-family: var(--font-artistic); color: var(--primary-color);" dir="rtl">
                            پشتیبانی کامل RTL
                        </h3>
                    </div>
                    <p style="font-family: var(--font-primary); line-height: 1.9; text-align: right;" dir="rtl">
                        طراحی کاملاً راست به چپ با تنظیمات دقیق برای زبان فارسی و تجربه کاربری بی‌نظیر
                    </p>
                </div>

            </div>

            <!-- Typography Showcase -->
            <div style="background: linear-gradient(135deg, #f8f9fd 0%, #ffffff 100%); border-radius: var(--radius-xl); padding: var(--spacing-xxl); margin-top: var(--spacing-xxl); border: 1px solid var(--border-color);">
                <h2 style="text-align: center; margin-bottom: var(--spacing-xl); font-family: var(--font-display);" dir="rtl">
                    🎭 نمونه تایپوگرافی فارسی 🎭
                </h2>
                
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: var(--spacing-lg);">
                    <div style="text-align: center; padding: var(--spacing-lg);">
                        <h3 style="font-family: 'Vazirmatn', sans-serif; font-weight: 700; color: var(--primary-color);" dir="rtl">
                            وزیر متن - Vazirmatn
                        </h3>
                        <p style="font-family: 'Vazirmatn', sans-serif; margin-top: var(--spacing-sm);" dir="rtl">
                            این فونت برای متن‌های عادی استفاده می‌شود
                        </p>
                    </div>
                    
                    <div style="text-align: center; padding: var(--spacing-lg);">
                        <h3 style="font-family: 'Scheherazade New', serif; font-weight: 600; color: var(--accent-color);" dir="rtl">
                            شهرزاد نو - Scheherazade New
                        </h3>
                        <p style="font-family: 'Scheherazade New', serif; margin-top: var(--spacing-sm);" dir="rtl">
                            فونت هنری برای عناوین زیبا
                        </p>
                    </div>
                    
                    <div style="text-align: center; padding: var(--spacing-lg);">
                        <h3 style="font-family: 'Amiri', serif; font-weight: 700; color: var(--purple-accent);" dir="rtl">
                            امیری - Amiri
                        </h3>
                        <p style="font-family: 'Amiri', serif; margin-top: var(--spacing-sm);" dir="rtl">
                            فونت کلاسیک برای متن‌های رسمی
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Musical Elements Showcase -->
    <section style="padding: var(--spacing-xxxl) 0; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; position: relative; overflow: hidden;">
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: url('data:image/svg+xml,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 100 100\"><text y=\".9em\" font-size=\"90\" opacity=\"0.1\">♪♫♪</text></svg>') repeat; opacity: 0.1;"></div>
        
        <div class="container" style="position: relative; z-index: 2;">
            <h2 style="text-align: center; margin-bottom: var(--spacing-xxl); font-family: var(--font-artistic);" dir="rtl">
                🎼 ویژگی‌های تکنیکی 🎼
            </h2>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: var(--spacing-xl);">
                <div style="text-align: center; padding: var(--spacing-lg);">
                    <span style="font-size: 2.5rem; display: block; margin-bottom: var(--spacing-md);">🎨</span>
                    <h3 style="font-family: var(--font-primary);" dir="rtl">گرادیانت‌های موزیکال</h3>
                    <p style="opacity: 0.9; font-family: var(--font-primary);" dir="rtl">
                        طیف رنگ‌های هنری با ترکیب‌های منحصر به فرد
                    </p>
                </div>
                
                <div style="text-align: center; padding: var(--spacing-lg);">
                    <span style="font-size: 2.5rem; display: block; margin-bottom: var(--spacing-md);">✨</span>
                    <h3 style="font-family: var(--font-primary);" dir="rtl">انیمیشن‌های نرم</h3>
                    <p style="opacity: 0.9; font-family: var(--font-primary);" dir="rtl">
                        حرکات زیبا و روان برای تجربه کاربری بهتر
                    </p>
                </div>
                
                <div style="text-align: center; padding: var(--spacing-lg);">
                    <span style="font-size: 2.5rem; display: block; margin-bottom: var(--spacing-md);">🌟</span>
                    <h3 style="font-family: var(--font-primary);" dir="rtl">سایه‌های حرفه‌ای</h3>
                    <p style="opacity: 0.9; font-family: var(--font-primary);" dir="rtl">
                        جلوه‌های بصری سه‌بعدی و جذاب
                    </p>
                </div>
            </div>
        </div>
    </section>

    <div class="section-divider"></div>

    <!-- Call to Action -->
    <section style="padding: var(--spacing-xxxl) 0; text-align: center;">
        <div class="container">
            <h2 style="margin-bottom: var(--spacing-lg); font-family: var(--font-artistic);" dir="rtl">
                🎵 آماده برای تجربه موزیک؟ 🎵
            </h2>
            <p style="font-size: 1.2rem; margin-bottom: var(--spacing-xl); color: var(--text-secondary); font-family: var(--font-primary);" dir="rtl">
                قالب حرفه‌ای و منحصر به فرد برای وب‌سایت موزیک شما
            </p>
            <div style="display: flex; gap: var(--spacing-md); justify-content: center; flex-wrap: wrap;">
                <a href="<?php echo home_url('/music'); ?>" class="btn">
                    🎼 <?php _e('مشاهده موزیک‌ها', 'artist-music-pro'); ?>
                </a>
                <a href="<?php echo home_url('/blog'); ?>" class="btn btn-secondary">
                    📝 <?php _e('وبلاگ', 'artist-music-pro'); ?>
                </a>
            </div>
        </div>
    </section>
</div>

<style>
/* Additional styles for musical showcase */
.musical-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-xl);
}

.floating-notes .musical-note {
    color: rgba(255, 255, 255, 0.6);
    font-size: 2rem;
    animation: musicalFloat 4s ease-in-out infinite;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .musical-hero h1 {
        font-size: 2.5rem !important;
    }
    
    .musical-hero p {
        font-size: 1.1rem !important;
    }
    
    .musical-hero .btn {
        width: 100%;
        justify-content: center;
    }
}
</style>

<?php get_footer(); ?>