/**
 * AI Tarım Theme JavaScript
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // Mobile menu functionality
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');
    const menuIcon = document.getElementById('menu-icon');
    const closeIcon = document.getElementById('close-icon');

    if (mobileMenuToggle && mobileMenu) {
        mobileMenuToggle.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
            menuIcon.classList.toggle('hidden');
            closeIcon.classList.toggle('hidden');
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            if (!mobileMenuToggle.contains(event.target) && !mobileMenu.contains(event.target)) {
                mobileMenu.classList.add('hidden');
                menuIcon.classList.remove('hidden');
                closeIcon.classList.add('hidden');
            }
        });
    }

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                const headerOffset = 100;
                const elementPosition = target.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });

    // Intersection Observer for animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '50px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-fade-in');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Observe elements for animation
    document.querySelectorAll('.card-hover, .animate-on-scroll').forEach(el => {
        observer.observe(el);
    });

    // Back to top button
    const backToTopButton = document.createElement('button');
    backToTopButton.innerHTML = `
        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
        </svg>
    `;
    backToTopButton.className = 'fixed bottom-8 right-8 bg-green-600 text-white p-3 rounded-full shadow-lg hover:bg-green-700 transition-all duration-300 transform hover:scale-110 opacity-0 pointer-events-none z-50';
    backToTopButton.id = 'back-to-top';
    document.body.appendChild(backToTopButton);

    // Show/hide back to top button
    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 300) {
            backToTopButton.classList.remove('opacity-0', 'pointer-events-none');
            backToTopButton.classList.add('opacity-100');
        } else {
            backToTopButton.classList.add('opacity-0', 'pointer-events-none');
            backToTopButton.classList.remove('opacity-100');
        }
    });

    // Back to top functionality
    backToTopButton.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });

    // Form validation and enhancement
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        const inputs = form.querySelectorAll('input, textarea, select');
        
        inputs.forEach(input => {
            // Add focus/blur effects
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('focused');
                if (this.value.trim() !== '') {
                    this.parentElement.classList.add('filled');
                } else {
                    this.parentElement.classList.remove('filled');
                }
            });

            // Real-time validation
            input.addEventListener('input', function() {
                if (this.checkValidity()) {
                    this.classList.remove('border-red-500');
                    this.classList.add('border-green-500');
                } else {
                    this.classList.remove('border-green-500');
                    this.classList.add('border-red-500');
                }
            });
        });
    });

    // Image lazy loading fallback for older browsers
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('lazy');
                    imageObserver.unobserve(img);
                }
            });
        });

        document.querySelectorAll('img[data-src]').forEach(img => {
            imageObserver.observe(img);
        });
    }

    // Search functionality enhancement
    const searchInputs = document.querySelectorAll('input[type="search"]');
    searchInputs.forEach(input => {
        let searchTimeout;
        
        input.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const query = this.value.trim();
            
            if (query.length > 2) {
                searchTimeout = setTimeout(() => {
                    // Add search suggestions or live search functionality here
                    console.log('Searching for:', query);
                }, 300);
            }
        });
    });

    // Accessibility improvements
    document.addEventListener('keydown', function(e) {
        // Skip to main content with Tab key
        if (e.key === 'Tab' && !e.shiftKey && document.activeElement === document.body) {
            const mainContent = document.querySelector('main');
            if (mainContent) {
                mainContent.focus();
                e.preventDefault();
            }
        }

        // Close mobile menu with Escape key
        if (e.key === 'Escape' && mobileMenu && !mobileMenu.classList.contains('hidden')) {
            mobileMenu.classList.add('hidden');
            menuIcon.classList.remove('hidden');
            closeIcon.classList.add('hidden');
        }
    });

    // Performance optimization: Debounce scroll events
    let scrollTimeout;
    let lastScrollTop = 0;

    window.addEventListener('scroll', function() {
        clearTimeout(scrollTimeout);
        scrollTimeout = setTimeout(function() {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            // Add scroll direction class to body
            if (scrollTop > lastScrollTop) {
                document.body.classList.add('scrolling-down');
                document.body.classList.remove('scrolling-up');
            } else {
                document.body.classList.add('scrolling-up');
                document.body.classList.remove('scrolling-down');
            }
            
            lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
        }, 10);
    });

    // Print styles optimization
    window.addEventListener('beforeprint', function() {
        document.body.classList.add('printing');
    });

    window.addEventListener('afterprint', function() {
        document.body.classList.remove('printing');
    });

    // Cookie consent (if needed)
    function showCookieConsent() {
        const cookieConsent = localStorage.getItem('cookieConsent');
        if (!cookieConsent) {
            const consentBanner = document.createElement('div');
            consentBanner.className = 'fixed bottom-0 left-0 right-0 bg-gray-800 text-white p-4 z-50 transform translate-y-full transition-transform duration-300';
            consentBanner.innerHTML = `
                <div class="container mx-auto flex flex-col md:flex-row items-center justify-between gap-4">
                    <p class="text-sm">Bu site deneyiminizi geliştirmek için çerezler kullanır.</p>
                    <div class="flex gap-2">
                        <button id="accept-cookies" class="bg-green-600 hover:bg-green-700 px-4 py-2 rounded text-sm font-semibold transition-colors">
                            Kabul Et
                        </button>
                        <button id="decline-cookies" class="bg-gray-600 hover:bg-gray-700 px-4 py-2 rounded text-sm font-semibold transition-colors">
                            Reddet
                        </button>
                    </div>
                </div>
            `;
            
            document.body.appendChild(consentBanner);
            
            // Show banner
            setTimeout(() => {
                consentBanner.classList.remove('translate-y-full');
            }, 1000);
            
            // Handle consent
            document.getElementById('accept-cookies').addEventListener('click', function() {
                localStorage.setItem('cookieConsent', 'accepted');
                consentBanner.remove();
            });
            
            document.getElementById('decline-cookies').addEventListener('click', function() {
                localStorage.setItem('cookieConsent', 'declined');
                consentBanner.remove();
            });
        }
    }

    // Initialize cookie consent after page load
    setTimeout(showCookieConsent, 2000);

    // Service Worker registration for PWA features (optional)
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function() {
            navigator.serviceWorker.register('/sw.js')
                .then(function(registration) {
                    console.log('ServiceWorker registration successful');
                })
                .catch(function(err) {
                    console.log('ServiceWorker registration failed');
                });
        });
    }

    console.log('AI Tarım Theme JavaScript loaded successfully');
});

// Utility functions
window.aiTarimUtils = {
    // Format date
    formatDate: function(date) {
        return new Intl.DateTimeFormat('tr-TR', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        }).format(new Date(date));
    },

    // Debounce function
    debounce: function(func, wait, immediate) {
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
    },

    // Throttle function
    throttle: function(func, limit) {
        let inThrottle;
        return function() {
            const args = arguments;
            const context = this;
            if (!inThrottle) {
                func.apply(context, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        };
    },

    // Check if element is in viewport
    isInViewport: function(element) {
        const rect = element.getBoundingClientRect();
        return (
            rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
            rect.right <= (window.innerWidth || document.documentElement.clientWidth)
        );
    }
};