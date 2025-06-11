<footer class="bg-gradient-to-r from-gray-800 to-gray-900 text-white py-12">
    <div class="container mx-auto max-w-6xl px-4">
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Site Info -->
            <div class="lg:col-span-2">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="bg-green-600 p-2 rounded-xl">
                        <?php ai_tarim_get_icon('leaf', 'h-6 w-6 text-white'); ?>
                    </div>
                    <h3 class="text-xl font-bold"><?php echo get_theme_mod('site_title', get_bloginfo('name')); ?></h3>
                </div>
                <p class="text-gray-300 leading-relaxed mb-4">
                    <?php echo get_theme_mod('footer_description', 'Yapay zeka destekli tarım çözümleri ile verimliliğinizi artırın. Modern teknoloji, geleneksel tarımla buluşuyor.'); ?>
                </p>
                <div class="flex space-x-4">
                    <?php if (get_theme_mod('social_facebook')) : ?>
                        <a href="<?php echo esc_url(get_theme_mod('social_facebook')); ?>" class="text-gray-300 hover:text-white transition-colors">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                    <?php endif; ?>
                    <?php if (get_theme_mod('social_twitter')) : ?>
                        <a href="<?php echo esc_url(get_theme_mod('social_twitter')); ?>" class="text-gray-300 hover:text-white transition-colors">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                        </a>
                    <?php endif; ?>
                    <?php if (get_theme_mod('social_instagram')) : ?>
                        <a href="<?php echo esc_url(get_theme_mod('social_instagram')); ?>" class="text-gray-300 hover:text-white transition-colors">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 6.62 5.367 11.987 11.988 11.987 6.62 0 11.987-5.367 11.987-11.987C24.014 5.367 18.637.001 12.017.001zM8.449 16.988c-1.297 0-2.448-.49-3.323-1.297C4.198 14.895 3.708 13.744 3.708 12.447s.49-2.448 1.297-3.323c.875-.807 2.026-1.297 3.323-1.297s2.448.49 3.323 1.297c.807.875 1.297 2.026 1.297 3.323s-.49 2.448-1.297 3.323c-.875.807-2.026 1.297-3.323 1.297z"/>
                            </svg>
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="text-lg font-semibold mb-4">Hızlı Bağlantılar</h4>
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'footer',
                    'menu_class' => 'space-y-2',
                    'container' => false,
                    'fallback_cb' => 'ai_tarim_footer_fallback_menu',
                    'walker' => new AI_Tarim_Walker_Footer_Menu()
                ));
                ?>
            </div>

            <!-- Contact Info -->
            <div>
                <h4 class="text-lg font-semibold mb-4">İletişim</h4>
                <div class="space-y-2 text-gray-300">
                    <?php if (get_theme_mod('contact_email')) : ?>
                        <p class="flex items-center">
                            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <a href="mailto:<?php echo esc_attr(get_theme_mod('contact_email')); ?>" class="hover:text-white transition-colors">
                                <?php echo get_theme_mod('contact_email'); ?>
                            </a>
                        </p>
                    <?php endif; ?>
                    <?php if (get_theme_mod('contact_phone')) : ?>
                        <p class="flex items-center">
                            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <a href="tel:<?php echo esc_attr(get_theme_mod('contact_phone')); ?>" class="hover:text-white transition-colors">
                                <?php echo get_theme_mod('contact_phone'); ?>
                            </a>
                        </p>
                    <?php endif; ?>
                    <?php if (get_theme_mod('contact_address')) : ?>
                        <p class="flex items-start">
                            <svg class="h-4 w-4 mr-2 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span><?php echo get_theme_mod('contact_address'); ?></span>
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-300">
            <p>&copy; <?php echo date('Y'); ?> <?php echo get_theme_mod('site_title', get_bloginfo('name')); ?>. 
               <?php echo get_theme_mod('copyright_text', 'Tüm hakları saklıdır.'); ?>
            </p>
            <?php if (get_theme_mod('show_developer_credit', true)) : ?>
                <p class="mt-2 text-sm">
                    <?php echo get_theme_mod('developer_credit', 'Created by Ahmet Özkan with AI assistance'); ?>
                </p>
            <?php endif; ?>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>

<script>
// Mobile menu toggle
document.addEventListener('DOMContentLoaded', function() {
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
    }

    // Smooth scrolling for anchor links
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

    // Add animation classes on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '50px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-fade-in');
            }
        });
    }, observerOptions);

    document.querySelectorAll('.card-hover').forEach(el => {
        observer.observe(el);
    });
});
</script>

</body>
</html>