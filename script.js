/*=============== SHOW MENU ===============*/
const navMenu = document.getElementById('nav-menu'),
      navToggle = document.getElementById('nav-toggle'),
      navClose = document.getElementById('nav-close')

/* Menu show */
if(navToggle){
    navToggle.addEventListener('click', () =>{
        navMenu.classList.add('show-menu')
    })
}

/* Menu hidden */
if(navClose){
    navClose.addEventListener('click', () =>{
        navMenu.classList.remove('show-menu')
    })
}

/*=============== REMOVE MENU MOBILE ===============*/
const navLink = document.querySelectorAll('.nav__link')

const linkAction = () =>{
    const navMenu = document.getElementById('nav-menu')
    // When we click on each nav__link, we remove the show-menu class
    navMenu.classList.remove('show-menu')
}
navLink.forEach(n => n.addEventListener('click', linkAction))

/*=============== ADD BLUR HEADER ===============*/
const blurHeader = () =>{
    const header = document.getElementById('header')
    // When the scroll is greater than 50 viewport height, add the blur-header class to the header tag
    this.scrollY >= 50 ? header.classList.add('blur-header') 
                       : header.classList.remove('blur-header')
}
window.addEventListener('scroll', blurHeader)

/*=============== EMAIL JS ===============*/
const contactForm = document.getElementById('contact-form'),
      contactMessage = document.getElementById('contact-message')

const sendEmail = (e) => {
    e.preventDefault()

    // serviceID - templateID - #form - publicKey
    emailjs.sendForm('service_xyz', 'template_xyz', '#contact-form', 'publicKey')
    .then(() => {
        // Show sent message
        contactMessage.textContent = 'پیام با موفقیت ارسال شد ✅'

        // Remove message after five seconds
        setTimeout(() => {
            contactMessage.textContent = ''
        }, 5000)

        // Clear input fields
        contactForm.reset()
    }, () => {
        // Show error message
        contactMessage.textContent = 'پیام ارسال نشد (خطای سرویس) ❌'
    })
}

if(contactForm) {
    contactForm.addEventListener('submit', sendEmail)
}

/*=============== SHOW SCROLL UP ===============*/
const scrollUp = () =>{
    const scrollUp = document.getElementById('scroll-up')
    // When the scroll is higher than 350 viewport height, add the show-scroll class to the a tag with the scrollup class
    this.scrollY >= 350 ? scrollUp.classList.add('show-scroll')
                        : scrollUp.classList.remove('show-scroll')
}
window.addEventListener('scroll', scrollUp)

/*=============== SCROLL SECTIONS ACTIVE LINK ===============*/
const sections = document.querySelectorAll('section[id]')
    
const scrollActive = () =>{
    const scrollY = window.pageYOffset

    sections.forEach(current =>{
        const sectionHeight = current.offsetHeight,
              sectionTop = current.offsetTop - 58,
              sectionId = current.getAttribute('id'),
              sectionsClass = document.querySelector('.nav__menu a[href*=' + sectionId + ']')

        if(scrollY > sectionTop && scrollY <= sectionTop + sectionHeight){
            sectionsClass.classList.add('active-link')
        }else{
            sectionsClass.classList.remove('active-link')
        }                                                    
    })
}
window.addEventListener('scroll', scrollActive)

/*=============== SCROLL REVEAL ANIMATION ===============*/
const sr = ScrollReveal({
    origin: 'top',
    distance: '60px',
    duration: 2500,
    delay: 400,
    // reset: true, // Animations repeat
})

sr.reveal('.home__data')
sr.reveal('.home__handle', {delay: 700})
sr.reveal('.home__social, .home__scroll', {delay: 900, origin: 'bottom'})
sr.reveal('.about__img, .contact__content', {origin: 'left'})
sr.reveal('.about__data, .contact__form', {origin: 'right'})
sr.reveal('.skills__content, .services__card, .portfolio__content', {interval: 100})

/*=============== SERVICES MODAL ===============*/
const modalViews = document.querySelectorAll('.services__modal'),
      modalBtns = document.querySelectorAll('.services__button'),
      modalClose = document.querySelectorAll('.services__modal-close')

let modal = function(modalClick) {
    modalViews[modalClick].classList.add('active-modal')
}

modalBtns.forEach((mb, i) => {
    mb.addEventListener('click', () => {
        modal(i)
    })
})

modalClose.forEach((mc) => {
    mc.addEventListener('click', () => {
        modalViews.forEach((mv) => {
            mv.classList.remove('active-modal')
        })
    })
})

/*=============== PORTFOLIO SWIPER ===============*/
let portfolioSwiper = new Swiper(".portfolio__container", {
    cssMode: true,
    loop: true,
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    mousewheel: true,
    keyboard: true,
    // RTL support
    rtl: document.dir === 'rtl',
});

/*=============== TESTIMONIAL SWIPER ===============*/
let testimonialSwiper = new Swiper(".testimonial__container", {
    grabCursor: true,
    spaceBetween: 48,
    loop: true,
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
        dynamicBullets: true,
    },
    breakpoints:{
        568:{
            slidesPerView: 2,
        }
    },
    // RTL support
    rtl: document.dir === 'rtl',
});

/*=============== DARK LIGHT THEME ===============*/
const themeButton = document.getElementById('theme-button')
const darkTheme = 'dark-theme'
const iconTheme = 'fa-sun'

// Previously selected topic (if user selected)
const selectedTheme = localStorage.getItem('selected-theme')
const selectedIcon = localStorage.getItem('selected-icon')

// We obtain the current theme that the interface has by validating the dark-theme class
const getCurrentTheme = () => document.body.classList.contains(darkTheme) ? 'dark' : 'light'
const getCurrentIcon = () => themeButton.classList.contains(iconTheme) ? 'fa-moon' : 'fa-sun'

// We validate if the user previously chose a topic
if (selectedTheme) {
  // If the validation is fulfilled, we ask what the issue was to know if we activated or deactivated the dark
  document.body.classList[selectedTheme === 'dark' ? 'add' : 'remove'](darkTheme)
  if(themeButton) {
    themeButton.classList[selectedIcon === 'fa-moon' ? 'add' : 'remove'](iconTheme)
  }
}

// Activate / deactivate the theme manually with the button
if(themeButton) {
    themeButton.addEventListener('click', () => {
        // Add or remove the dark / icon theme
        document.body.classList.toggle(darkTheme)
        themeButton.classList.toggle(iconTheme)
        // We save the theme and the current icon that the user chose
        localStorage.setItem('selected-theme', getCurrentTheme())
        localStorage.setItem('selected-icon', getCurrentIcon())
    })
}

/*=============== TYPED JS ===============*/
const typed = new Typed('.home__education', {
    strings: [
        'برنامه‌نویس فول‌استک',
        'توسعه‌دهنده Frontend',
        'توسعه‌دهنده Backend',
        'طراح UI/UX',
        'مشاور فناوری'
    ],
    typeSpeed: 100,
    backSpeed: 50,
    backDelay: 2000,
    loop: true
});

/*=============== ANIMATION ON SCROLL ===============*/
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, observerOptions);

// Observe all sections
document.querySelectorAll('.section').forEach(section => {
    section.style.opacity = '0';
    section.style.transform = 'translateY(30px)';
    section.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
    observer.observe(section);
});

/*=============== COUNTER ANIMATION ===============*/
const counters = document.querySelectorAll('.about__subtitle');

const startCounter = (counter) => {
    const target = parseInt(counter.textContent.replace(/[^\d]/g, ''));
    const increment = target / 200;
    let current = 0;

    const timer = setInterval(() => {
        current += increment;
        if (current >= target) {
            current = target;
            clearInterval(timer);
        }
        
        // Keep the original text format but update the number
        const originalText = counter.textContent;
        const newText = originalText.replace(/\d+/, Math.floor(current));
        counter.textContent = newText;
    }, 10);
};

// Observe counters
const counterObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            startCounter(entry.target);
            counterObserver.unobserve(entry.target);
        }
    });
}, { threshold: 0.7 });

counters.forEach(counter => {
    counterObserver.observe(counter);
});

/*=============== SKILLS PROGRESS ANIMATION ===============*/
const skillsSection = document.getElementById('skills');
let skillsAnimated = false;

const animateSkills = () => {
    if (!skillsAnimated) {
        const skillItems = document.querySelectorAll('.skills__data');
        
        skillItems.forEach((item, index) => {
            setTimeout(() => {
                item.style.opacity = '1';
                item.style.transform = 'translateX(0)';
            }, index * 100);
        });
        
        skillsAnimated = true;
    }
};

// Initial setup for skills
document.querySelectorAll('.skills__data').forEach(item => {
    item.style.opacity = '0';
    item.style.transform = 'translateX(-20px)';
    item.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
});

// Observe skills section
const skillsObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            animateSkills();
        }
    });
}, { threshold: 0.3 });

if (skillsSection) {
    skillsObserver.observe(skillsSection);
}

/*=============== FORM VALIDATION ===============*/
const contactFormValidation = document.querySelector('.contact__form');

if (contactFormValidation) {
    const nameInput = contactFormValidation.querySelector('input[name="name"]');
    const emailInput = contactFormValidation.querySelector('input[name="email"]');
    const projectInput = contactFormValidation.querySelector('textarea[name="project"]');

    const validateField = (field, regex, errorMessage) => {
        const isValid = regex.test(field.value.trim());
        
        if (!isValid && field.value.trim() !== '') {
            field.style.borderColor = '#ff6b6b';
            showFieldError(field, errorMessage);
        } else if (field.value.trim() !== '') {
            field.style.borderColor = '#51cf66';
            hideFieldError(field);
        } else {
            field.style.borderColor = 'var(--text-color-light)';
            hideFieldError(field);
        }
        
        return isValid;
    };

    const showFieldError = (field, message) => {
        hideFieldError(field);
        const errorDiv = document.createElement('div');
        errorDiv.className = 'field-error';
        errorDiv.style.color = '#ff6b6b';
        errorDiv.style.fontSize = 'var(--smaller-font-size)';
        errorDiv.style.marginTop = '0.25rem';
        errorDiv.textContent = message;
        field.parentElement.appendChild(errorDiv);
    };

    const hideFieldError = (field) => {
        const errorDiv = field.parentElement.querySelector('.field-error');
        if (errorDiv) {
            errorDiv.remove();
        }
    };

    // Real-time validation
    if (nameInput) {
        nameInput.addEventListener('input', () => {
            validateField(nameInput, /^[\u0600-\u06FFa-zA-Z\s]{2,50}$/, 'نام باید بین ۲ تا ۵۰ کاراکتر باشد');
        });
    }

    if (emailInput) {
        emailInput.addEventListener('input', () => {
            validateField(emailInput, /^[^\s@]+@[^\s@]+\.[^\s@]+$/, 'آدرس ایمیل معتبر نیست');
        });
    }

    if (projectInput) {
        projectInput.addEventListener('input', () => {
            validateField(projectInput, /^.{10,}$/, 'توضیحات پروژه باید حداقل ۱۰ کاراکتر باشد');
        });
    }

    // Form submission validation
    contactFormValidation.addEventListener('submit', (e) => {
        e.preventDefault();
        
        let isFormValid = true;
        
        if (nameInput && !validateField(nameInput, /^[\u0600-\u06FFa-zA-Z\s]{2,50}$/, 'نام الزامی است')) {
            isFormValid = false;
        }
        
        if (emailInput && !validateField(emailInput, /^[^\s@]+@[^\s@]+\.[^\s@]+$/, 'ایمیل معتبر الزامی است')) {
            isFormValid = false;
        }
        
        if (projectInput && !validateField(projectInput, /^.{10,}$/, 'توضیحات پروژه الزامی است')) {
            isFormValid = false;
        }
        
        if (isFormValid) {
            // Form is valid, proceed with submission
            showSuccessMessage('فرم با موفقیت ارسال شد!');
            contactFormValidation.reset();
            // Reset border colors
            [nameInput, emailInput, projectInput].forEach(input => {
                if (input) input.style.borderColor = 'var(--text-color-light)';
            });
        } else {
            showErrorMessage('لطفاً تمام فیلدها را به درستی پر کنید');
        }
    });
}

const showSuccessMessage = (message) => {
    showMessage(message, '#51cf66');
};

const showErrorMessage = (message) => {
    showMessage(message, '#ff6b6b');
};

const showMessage = (message, color) => {
    // Remove existing message
    const existingMessage = document.querySelector('.form-message');
    if (existingMessage) {
        existingMessage.remove();
    }

    const messageDiv = document.createElement('div');
    messageDiv.className = 'form-message';
    messageDiv.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${color};
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 0.5rem;
        font-size: var(--small-font-size);
        z-index: 1000;
        animation: slideInRight 0.3s ease;
    `;
    messageDiv.textContent = message;

    document.body.appendChild(messageDiv);

    setTimeout(() => {
        messageDiv.style.animation = 'slideOutRight 0.3s ease';
        setTimeout(() => {
            messageDiv.remove();
        }, 300);
    }, 3000);
};

// Add CSS animations for messages
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }

    .services__modal {
        z-index: 1000;
    }

    .blur-header {
        backdrop-filter: blur(25px);
        -webkit-backdrop-filter: blur(25px);
    }
`;
document.head.appendChild(style);

/*=============== LOADING SCREEN ===============*/
window.addEventListener('load', () => {
    const loader = document.createElement('div');
    loader.className = 'loader';
    loader.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: var(--body-color);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        transition: opacity 0.5s ease;
    `;
    
    const spinnerHTML = `
        <div style="
            width: 50px;
            height: 50px;
            border: 3px solid var(--container-color);
            border-top: 3px solid var(--first-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        "></div>
    `;
    
    loader.innerHTML = spinnerHTML;
    
    // Add spinner animation
    const spinnerStyle = document.createElement('style');
    spinnerStyle.textContent = `
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    `;
    document.head.appendChild(spinnerStyle);
    
    document.body.appendChild(loader);
    
    setTimeout(() => {
        loader.style.opacity = '0';
        setTimeout(() => {
            loader.remove();
        }, 500);
    }, 1000);
});

/*=============== SMOOTH SCROLLING FOR LINKS ===============*/
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

/*=============== PORTFOLIO FILTER (if needed) ===============*/
const portfolioFilters = document.querySelectorAll('.portfolio__filter');
const portfolioItems = document.querySelectorAll('.portfolio__item');

if (portfolioFilters.length > 0) {
    portfolioFilters.forEach(filter => {
        filter.addEventListener('click', () => {
            // Remove active class from all filters
            portfolioFilters.forEach(f => f.classList.remove('active'));
            // Add active class to clicked filter
            filter.classList.add('active');
            
            const filterValue = filter.getAttribute('data-filter');
            
            portfolioItems.forEach(item => {
                if (filterValue === 'all' || item.classList.contains(filterValue)) {
                    item.style.display = 'block';
                    item.style.animation = 'fadeIn 0.5s ease';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
}

console.log('🎉 سایت نیما اولادی بارگذاری شد - طراحی شده با عشق برای فارسی زبانان');

// Persian number conversion (if needed)
const toPersianDigits = (str) => {
    const persianDigits = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
    return str.toString().replace(/\d/g, (digit) => persianDigits[parseInt(digit)]);
};

// Apply Persian numbers to specific elements if needed
document.querySelectorAll('.persian-numbers').forEach(element => {
    element.textContent = toPersianDigits(element.textContent);
});