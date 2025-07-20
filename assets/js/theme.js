/**
 * Artist Music Pro Theme JavaScript
 * Main theme functionality
 */

(function($) {
    'use strict';

    // Initialize everything when document is ready
    $(document).ready(function() {
        initMobileMenu();
        initScrollEffects();
        initSmoothScrolling();
        initAnimations();
        initRTLToggle();
        initContactForm();
        initNewsletterForm();
    });

    /**
     * Mobile Menu Functionality
     */
    function initMobileMenu() {
        const menuToggle = $('.menu-toggle');
        const navigation = $('.main-navigation');
        const navMenu = $('.nav-menu');

        menuToggle.on('click', function(e) {
            e.preventDefault();
            
            const isExpanded = $(this).attr('aria-expanded') === 'true';
            
            $(this).attr('aria-expanded', !isExpanded);
            navigation.toggleClass('toggled');
            navMenu.toggleClass('toggled');
            
            // Toggle hamburger icon animation
            $(this).toggleClass('active');
            
            // Update menu text for RTL support
            const menuText = $(this).find('.menu-text');
            if (menuText.length) {
                if (isExpanded) {
                    menuText.text(document.documentElement.dir === 'rtl' ? 'منو' : 'Menu');
                } else {
                    menuText.text(document.documentElement.dir === 'rtl' ? 'بستن' : 'Close');
                }
            }
        });

        // Close mobile menu when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.main-navigation, .menu-toggle').length) {
                menuToggle.attr('aria-expanded', 'false');
                navigation.removeClass('toggled');
                navMenu.removeClass('toggled');
                menuToggle.removeClass('active');
                
                const menuText = menuToggle.find('.menu-text');
                if (menuText.length) {
                    menuText.text(document.documentElement.dir === 'rtl' ? 'منو' : 'Menu');
                }
            }
        });

        // Close mobile menu on window resize
        $(window).on('resize', function() {
            if ($(window).width() > 575) {
                menuToggle.attr('aria-expanded', 'false');
                navigation.removeClass('toggled');
                navMenu.removeClass('toggled');
                menuToggle.removeClass('active');
                
                const menuText = menuToggle.find('.menu-text');
                if (menuText.length) {
                    menuText.text(document.documentElement.dir === 'rtl' ? 'منو' : 'Menu');
                }
            }
        });
    }

    /**
     * Scroll Effects
     */
    function initScrollEffects() {
        const header = $('.site-header');
        let lastScrollTop = 0;

        $(window).on('scroll', function() {
            const scrollTop = $(this).scrollTop();

            // Add/remove scrolled class for header styling
            if (scrollTop > 100) {
                header.addClass('scrolled');
            } else {
                header.removeClass('scrolled');
            }

            // Hide/show header on scroll (optional)
            if (scrollTop > lastScrollTop && scrollTop > 200) {
                // Scrolling down
                header.addClass('header-hidden');
            } else {
                // Scrolling up
                header.removeClass('header-hidden');
            }

            lastScrollTop = scrollTop;
        });
    }

    /**
     * Smooth Scrolling for Anchor Links
     */
    function initSmoothScrolling() {
        $('a[href*="#"]:not([href="#"])').on('click', function(e) {
            const target = $(this.getAttribute('href'));
            
            if (target.length) {
                e.preventDefault();
                
                $('html, body').animate({
                    scrollTop: target.offset().top - 80 // Account for fixed header
                }, 800, 'easeInOutCubic');
            }
        });
    }

    /**
     * Animation on Scroll
     */
    function initAnimations() {
        // Add fade-in-up animation to elements when they come into view
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('fade-in-up');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        // Observe elements for animation
        $('.music-card, .content-section, .about-content, .post').each(function() {
            observer.observe(this);
        });
    }

    /**
     * RTL Toggle Functionality
     */
    function initRTLToggle() {
        const rtlToggle = $('#rtl-toggle-btn');
        
        if (rtlToggle.length) {
            rtlToggle.on('click', function(e) {
                e.preventDefault();
                toggleRTL();
            });
        }
    }

    // Global RTL toggle function
    window.toggleRTL = function() {
        const body = $('body');
        const html = $('html');
        
        if (body.hasClass('rtl')) {
            // Switch to LTR
            body.removeClass('rtl');
            html.attr('dir', 'ltr');
            localStorage.setItem('theme_direction', 'ltr');
        } else {
            // Switch to RTL
            body.addClass('rtl');
            html.attr('dir', 'rtl');
            localStorage.setItem('theme_direction', 'rtl');
        }
    };

    // Load saved direction preference
    const savedDirection = localStorage.getItem('theme_direction');
    if (savedDirection === 'rtl') {
        $('body').addClass('rtl');
        $('html').attr('dir', 'rtl');
    }

    /**
     * Contact Form Handler
     */
    function initContactForm() {
        $('.contact-form').on('submit', function(e) {
            e.preventDefault();
            
            const form = $(this);
            const submitBtn = form.find('button[type="submit"]');
            const originalText = submitBtn.text();
            
            // Show loading state
            submitBtn.text(artist_music_pro_ajax.strings.loading).prop('disabled', true);
            
            // Simulate form submission (replace with actual AJAX call)
            setTimeout(function() {
                alert('تشکر! پیام شما ارسال شد.'); // Thank you! Your message has been sent.
                form[0].reset();
                submitBtn.text(originalText).prop('disabled', false);
            }, 2000);
        });
    }

    /**
     * Newsletter Form Handler
     */
    function initNewsletterForm() {
        $('.newsletter-form').on('submit', function(e) {
            e.preventDefault();
            
            const form = $(this);
            const email = form.find('input[type="email"]').val();
            const submitBtn = form.find('button[type="submit"]');
            const originalText = submitBtn.text();
            
            if (!isValidEmail(email)) {
                alert('لطفاً یک آدرس ایمیل معتبر وارد کنید.'); // Please enter a valid email address.
                return;
            }
            
            // Show loading state
            submitBtn.text(artist_music_pro_ajax.strings.loading).prop('disabled', true);
            
            // Simulate subscription (replace with actual AJAX call)
            setTimeout(function() {
                alert('عضویت شما با موفقیت ثبت شد!'); // Your subscription has been registered successfully!
                form[0].reset();
                submitBtn.text(originalText).prop('disabled', false);
            }, 2000);
        });
    }

    /**
     * Email Validation Helper
     */
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    /**
     * Utility Functions
     */
    
    // Custom easing function for smooth scrolling
    $.extend($.easing, {
        easeInOutCubic: function(x, t, b, c, d) {
            if ((t /= d / 2) < 1) return c / 2 * t * t * t + b;
            return c / 2 * ((t -= 2) * t * t + 2) + b;
        }
    });

    // Debounce function for performance
    function debounce(func, wait, immediate) {
        let timeout;
        return function executedFunction() {
            const context = this;
            const args = arguments;
            const later = function() {
                timeout = null;
                if (!immediate) func.apply(context, args);
            };
            const callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func.apply(context, args);
        };
    }

    // Throttle function for scroll events
    function throttle(func, limit) {
        let inThrottle;
        return function() {
            const args = arguments;
            const context = this;
            if (!inThrottle) {
                func.apply(context, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        }
    }

    // Apply throttling to scroll events for better performance
    $(window).on('scroll', throttle(function() {
        // Additional scroll-based functionality can be added here
    }, 100));

    // Keyboard navigation support
    $(document).on('keydown', function(e) {
        // Escape key closes mobile menu
        if (e.keyCode === 27) {
            $('.menu-toggle').attr('aria-expanded', 'false');
            $('.main-navigation').removeClass('active');
            $('.menu-toggle').removeClass('active');
        }
    });

    // Focus management for accessibility
    $('.menu-toggle').on('keydown', function(e) {
        if (e.keyCode === 13 || e.keyCode === 32) { // Enter or Space
            e.preventDefault();
            $(this).click();
        }
    });

})(jQuery);