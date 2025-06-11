<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    
    <!-- Preload Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<nav class="bg-gradient-to-r from-green-700 via-green-600 to-emerald-600 text-white shadow-2xl sticky top-0 z-50 backdrop-blur-sm">
    <div class="container mx-auto max-w-7xl px-4">
        <div class="flex justify-between items-center py-4">
            <!-- Logo -->
            <div class="flex items-center space-x-3">
                <div class="bg-white/20 p-2 rounded-xl backdrop-blur-sm">
                    <?php ai_tarim_get_icon('leaf', 'h-8 w-8 text-green-100'); ?>
                </div>
                <div>
                    <h1 class="text-2xl font-bold tracking-tight">
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="text-white hover:text-green-100 transition-colors">
                            <?php echo get_theme_mod('site_title', get_bloginfo('name')); ?>
                        </a>
                    </h1>
                    <p class="text-green-100 text-xs">
                        <?php echo get_theme_mod('site_tagline', get_bloginfo('description')); ?>
                    </p>
                </div>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex items-center space-x-1">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'menu_class' => 'flex items-center space-x-1',
                    'container' => false,
                    'fallback_cb' => 'ai_tarim_fallback_menu',
                    'walker' => new AI_Tarim_Walker_Nav_Menu()
                ));
                ?>
            </div>

            <!-- Mobile Menu Button -->
            <button id="mobile-menu-toggle" class="lg:hidden p-2 rounded-xl bg-white/20 backdrop-blur-sm">
                <svg id="menu-icon" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
                <svg id="close-icon" class="h-6 w-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Mobile Navigation -->
        <div id="mobile-menu" class="lg:hidden pb-4 border-t border-white/20 mt-4 pt-4 hidden">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'menu_class' => 'space-y-2',
                'container' => false,
                'fallback_cb' => 'ai_tarim_fallback_menu',
                'walker' => new AI_Tarim_Walker_Nav_Menu_Mobile()
            ));
            ?>
        </div>
    </div>
</nav>