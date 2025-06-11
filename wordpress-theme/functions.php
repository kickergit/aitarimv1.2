<?php
/**
 * AI Tarım Theme Functions
 *
 * @package AI_Tarim
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Theme setup
function ai_tarim_setup() {
    // Add theme support
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));
    add_theme_support('customize-selective-refresh-widgets');
    add_theme_support('responsive-embeds');
    add_theme_support('wp-block-styles');
    add_theme_support('align-wide');

    // Register navigation menus
    register_nav_menus(array(
        'primary' => esc_html__('Primary Menu', 'ai-tarim'),
        'footer' => esc_html__('Footer Menu', 'ai-tarim'),
    ));

    // Add image sizes
    add_image_size('ai-tarim-featured', 800, 600, true);
    add_image_size('ai-tarim-thumbnail', 400, 300, true);
}
add_action('after_setup_theme', 'ai_tarim_setup');

// Enqueue scripts and styles
function ai_tarim_scripts() {
    wp_enqueue_style('ai-tarim-style', get_stylesheet_uri(), array(), '1.2');
    wp_enqueue_style('ai-tarim-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap', array(), null);
    
    wp_enqueue_script('ai-tarim-script', get_template_directory_uri() . '/js/main.js', array(), '1.2', true);
    
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'ai_tarim_scripts');

// Register widget areas
function ai_tarim_widgets_init() {
    register_sidebar(array(
        'name'          => esc_html__('Sidebar', 'ai-tarim'),
        'id'            => 'sidebar-1',
        'description'   => esc_html__('Add widgets here.', 'ai-tarim'),
        'before_widget' => '<section id="%1$s" class="widget %2$s bg-white rounded-2xl shadow-lg border border-gray-100 p-6 mb-6">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title text-xl font-bold text-gray-800 mb-4">',
        'after_title'   => '</h3>',
    ));

    register_sidebar(array(
        'name'          => esc_html__('Footer Widget Area', 'ai-tarim'),
        'id'            => 'footer-widgets',
        'description'   => esc_html__('Add widgets to the footer area.', 'ai-tarim'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title text-lg font-semibold mb-4">',
        'after_title'   => '</h4>',
    ));
}
add_action('widgets_init', 'ai_tarim_widgets_init');

// Custom post types
function ai_tarim_custom_post_types() {
    // Services post type
    register_post_type('services', array(
        'labels' => array(
            'name' => 'Hizmetler',
            'singular_name' => 'Hizmet',
            'add_new' => 'Yeni Hizmet Ekle',
            'add_new_item' => 'Yeni Hizmet Ekle',
            'edit_item' => 'Hizmeti Düzenle',
            'new_item' => 'Yeni Hizmet',
            'view_item' => 'Hizmeti Görüntüle',
            'search_items' => 'Hizmet Ara',
            'not_found' => 'Hizmet bulunamadı',
            'not_found_in_trash' => 'Çöp kutusunda hizmet bulunamadı'
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'menu_icon' => 'dashicons-admin-tools',
        'rewrite' => array('slug' => 'hizmetler')
    ));

    // Testimonials post type
    register_post_type('testimonials', array(
        'labels' => array(
            'name' => 'Referanslar',
            'singular_name' => 'Referans',
            'add_new' => 'Yeni Referans Ekle',
            'add_new_item' => 'Yeni Referans Ekle',
            'edit_item' => 'Referansı Düzenle',
            'new_item' => 'Yeni Referans',
            'view_item' => 'Referansı Görüntüle',
            'search_items' => 'Referans Ara',
            'not_found' => 'Referans bulunamadı',
            'not_found_in_trash' => 'Çöp kutusunda referans bulunamadı'
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
        'menu_icon' => 'dashicons-format-quote',
        'rewrite' => array('slug' => 'referanslar')
    ));
}
add_action('init', 'ai_tarim_custom_post_types');

// Custom meta boxes
function ai_tarim_add_meta_boxes() {
    add_meta_box(
        'service_details',
        'Hizmet Detayları',
        'ai_tarim_service_meta_box_callback',
        'services',
        'normal',
        'high'
    );

    add_meta_box(
        'testimonial_details',
        'Referans Detayları',
        'ai_tarim_testimonial_meta_box_callback',
        'testimonials',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'ai_tarim_add_meta_boxes');

function ai_tarim_service_meta_box_callback($post) {
    wp_nonce_field('ai_tarim_save_service_meta', 'ai_tarim_service_meta_nonce');
    
    $icon = get_post_meta($post->ID, '_service_icon', true);
    $color = get_post_meta($post->ID, '_service_color', true);
    $features = get_post_meta($post->ID, '_service_features', true);
    
    echo '<table class="form-table">';
    echo '<tr><th><label for="service_icon">İkon:</label></th>';
    echo '<td><select name="service_icon" id="service_icon">';
    $icons = array('camera' => 'Kamera', 'pill' => 'İlaç', 'droplets' => 'Damla', 'leaf' => 'Yaprak', 'sun' => 'Güneş');
    foreach ($icons as $value => $label) {
        echo '<option value="' . $value . '"' . selected($icon, $value, false) . '>' . $label . '</option>';
    }
    echo '</select></td></tr>';
    
    echo '<tr><th><label for="service_color">Renk Sınıfı:</label></th>';
    echo '<td><input type="text" name="service_color" id="service_color" value="' . esc_attr($color) . '" placeholder="from-green-500 to-emerald-600" /></td></tr>';
    
    echo '<tr><th><label for="service_features">Özellikler (Her satıra bir özellik):</label></th>';
    echo '<td><textarea name="service_features" id="service_features" rows="5" cols="50">' . esc_textarea($features) . '</textarea></td></tr>';
    echo '</table>';
}

function ai_tarim_testimonial_meta_box_callback($post) {
    wp_nonce_field('ai_tarim_save_testimonial_meta', 'ai_tarim_testimonial_meta_nonce');
    
    $company = get_post_meta($post->ID, '_testimonial_company', true);
    $position = get_post_meta($post->ID, '_testimonial_position', true);
    $rating = get_post_meta($post->ID, '_testimonial_rating', true);
    
    echo '<table class="form-table">';
    echo '<tr><th><label for="testimonial_company">Şirket:</label></th>';
    echo '<td><input type="text" name="testimonial_company" id="testimonial_company" value="' . esc_attr($company) . '" /></td></tr>';
    
    echo '<tr><th><label for="testimonial_position">Pozisyon:</label></th>';
    echo '<td><input type="text" name="testimonial_position" id="testimonial_position" value="' . esc_attr($position) . '" /></td></tr>';
    
    echo '<tr><th><label for="testimonial_rating">Puan (1-5):</label></th>';
    echo '<td><select name="testimonial_rating" id="testimonial_rating">';
    for ($i = 1; $i <= 5; $i++) {
        echo '<option value="' . $i . '"' . selected($rating, $i, false) . '>' . $i . ' Yıldız</option>';
    }
    echo '</select></td></tr>';
    echo '</table>';
}

// Save meta box data
function ai_tarim_save_meta_boxes($post_id) {
    // Services meta
    if (isset($_POST['ai_tarim_service_meta_nonce']) && wp_verify_nonce($_POST['ai_tarim_service_meta_nonce'], 'ai_tarim_save_service_meta')) {
        if (isset($_POST['service_icon'])) {
            update_post_meta($post_id, '_service_icon', sanitize_text_field($_POST['service_icon']));
        }
        if (isset($_POST['service_color'])) {
            update_post_meta($post_id, '_service_color', sanitize_text_field($_POST['service_color']));
        }
        if (isset($_POST['service_features'])) {
            update_post_meta($post_id, '_service_features', sanitize_textarea_field($_POST['service_features']));
        }
    }

    // Testimonials meta
    if (isset($_POST['ai_tarim_testimonial_meta_nonce']) && wp_verify_nonce($_POST['ai_tarim_testimonial_meta_nonce'], 'ai_tarim_save_testimonial_meta')) {
        if (isset($_POST['testimonial_company'])) {
            update_post_meta($post_id, '_testimonial_company', sanitize_text_field($_POST['testimonial_company']));
        }
        if (isset($_POST['testimonial_position'])) {
            update_post_meta($post_id, '_testimonial_position', sanitize_text_field($_POST['testimonial_position']));
        }
        if (isset($_POST['testimonial_rating'])) {
            update_post_meta($post_id, '_testimonial_rating', intval($_POST['testimonial_rating']));
        }
    }
}
add_action('save_post', 'ai_tarim_save_meta_boxes');

// Customizer settings
function ai_tarim_customize_register($wp_customize) {
    // Hero Section
    $wp_customize->add_section('hero_section', array(
        'title' => 'Ana Sayfa Hero Bölümü',
        'priority' => 30,
    ));

    $wp_customize->add_setting('hero_title', array(
        'default' => '🌿 AI Tarım - Yapay Zeka Destekli Tarım 🌿',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('hero_title', array(
        'label' => 'Hero Başlık',
        'section' => 'hero_section',
        'type' => 'text',
    ));

    $wp_customize->add_setting('hero_description', array(
        'default' => 'Bitkilerinizin fotoğraflarını analiz edin, akıllı sulama tavsiyeleri alın ve tarımda teknolojinin gücünden faydalanın.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('hero_description', array(
        'label' => 'Hero Açıklama',
        'section' => 'hero_section',
        'type' => 'textarea',
    ));

    // Services Section
    $wp_customize->add_section('services_section', array(
        'title' => 'Hizmetler Bölümü',
        'priority' => 31,
    ));

    for ($i = 1; $i <= 3; $i++) {
        $wp_customize->add_setting("service_{$i}_title", array(
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control("service_{$i}_title", array(
            'label' => "Hizmet {$i} Başlık",
            'section' => 'services_section',
            'type' => 'text',
        ));

        $wp_customize->add_setting("service_{$i}_desc", array(
            'default' => '',
            'sanitize_callback' => 'sanitize_textarea_field',
        ));

        $wp_customize->add_control("service_{$i}_desc", array(
            'label' => "Hizmet {$i} Açıklama",
            'section' => 'services_section',
            'type' => 'textarea',
        ));
    }

    // CTA Section
    $wp_customize->add_section('cta_section', array(
        'title' => 'Çağrı Bölümü (CTA)',
        'priority' => 32,
    ));

    $wp_customize->add_setting('cta_title', array(
        'default' => 'Tarımda Yapay Zeka Deneyimini Başlatın',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('cta_title', array(
        'label' => 'CTA Başlık',
        'section' => 'cta_section',
        'type' => 'text',
    ));

    $wp_customize->add_setting('cta_description', array(
        'default' => 'Modern teknoloji ile tarımsal verimliliğinizi artırın. Hemen başlayın ve farkı görün.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('cta_description', array(
        'label' => 'CTA Açıklama',
        'section' => 'cta_section',
        'type' => 'textarea',
    ));

    $wp_customize->add_setting('cta_button_text', array(
        'default' => 'Hemen Başla',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('cta_button_text', array(
        'label' => 'CTA Buton Metni',
        'section' => 'cta_section',
        'type' => 'text',
    ));

    $wp_customize->add_setting('cta_button_url', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('cta_button_url', array(
        'label' => 'CTA Buton URL',
        'section' => 'cta_section',
        'type' => 'url',
    ));

    // Contact Section
    $wp_customize->add_section('contact_section', array(
        'title' => 'İletişim Bilgileri',
        'priority' => 33,
    ));

    $wp_customize->add_setting('contact_email', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_email',
    ));

    $wp_customize->add_control('contact_email', array(
        'label' => 'E-posta Adresi',
        'section' => 'contact_section',
        'type' => 'email',
    ));

    $wp_customize->add_setting('contact_phone', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('contact_phone', array(
        'label' => 'Telefon Numarası',
        'section' => 'contact_section',
        'type' => 'text',
    ));

    $wp_customize->add_setting('contact_address', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('contact_address', array(
        'label' => 'Adres',
        'section' => 'contact_section',
        'type' => 'textarea',
    ));

    // Social Media
    $wp_customize->add_section('social_section', array(
        'title' => 'Sosyal Medya',
        'priority' => 34,
    ));

    $social_platforms = array('facebook', 'twitter', 'instagram', 'linkedin', 'youtube');
    foreach ($social_platforms as $platform) {
        $wp_customize->add_setting("social_{$platform}", array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
        ));

        $wp_customize->add_control("social_{$platform}", array(
            'label' => ucfirst($platform) . ' URL',
            'section' => 'social_section',
            'type' => 'url',
        ));
    }

    // Footer Settings
    $wp_customize->add_section('footer_section', array(
        'title' => 'Footer Ayarları',
        'priority' => 35,
    ));

    $wp_customize->add_setting('footer_description', array(
        'default' => 'Yapay zeka destekli tarım çözümleri ile verimliliğinizi artırın. Modern teknoloji, geleneksel tarımla buluşuyor.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('footer_description', array(
        'label' => 'Footer Açıklama',
        'section' => 'footer_section',
        'type' => 'textarea',
    ));

    $wp_customize->add_setting('copyright_text', array(
        'default' => 'Tüm hakları saklıdır.',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('copyright_text', array(
        'label' => 'Telif Hakkı Metni',
        'section' => 'footer_section',
        'type' => 'text',
    ));

    $wp_customize->add_setting('developer_credit', array(
        'default' => 'Created by Ahmet Özkan with AI assistance',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('developer_credit', array(
        'label' => 'Geliştirici Kredisi',
        'section' => 'footer_section',
        'type' => 'text',
    ));

    $wp_customize->add_setting('show_developer_credit', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));

    $wp_customize->add_control('show_developer_credit', array(
        'label' => 'Geliştirici Kredisini Göster',
        'section' => 'footer_section',
        'type' => 'checkbox',
    ));

    // General Settings
    $wp_customize->add_setting('show_blog_posts', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));

    $wp_customize->add_control('show_blog_posts', array(
        'label' => 'Ana Sayfada Blog Yazılarını Göster',
        'section' => 'static_front_page',
        'type' => 'checkbox',
    ));
}
add_action('customize_register', 'ai_tarim_customize_register');

// Icon helper function
function ai_tarim_get_icon($icon, $class = 'h-6 w-6') {
    $icons = array(
        'leaf' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.5 2.5L16 5.5 13.5 3M7 7l2.5 2.5L11 7.5 8.5 5"></path>',
        'camera' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>',
        'pill' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547A1.934 1.934 0 014 17.5c0 .775.301 1.52.828 2.047l8.489 8.489a2 2 0 002.828 0l8.489-8.489A2.934 2.934 0 0025 17.5c0-.775-.301-1.52-.828-2.047z"></path>',
        'droplets' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7.5 14.25c0-1.78 1.409-3.25 3.25-3.25s3.25 1.47 3.25 3.25-1.409 3.25-3.25 3.25-3.25-1.47-3.25-3.25z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.75 6.75a.75.75 0 00-1.5 0v2.5a.75.75 0 001.5 0v-2.5zM14.25 6.75a.75.75 0 00-1.5 0v2.5a.75.75 0 001.5 0v-2.5z"></path>',
        'sun' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>'
    );

    if (isset($icons[$icon])) {
        echo '<svg class="' . esc_attr($class) . '" fill="none" stroke="currentColor" viewBox="0 0 24 24">' . $icons[$icon] . '</svg>';
    }
}

// Custom navigation walker
class AI_Tarim_Walker_Nav_Menu extends Walker_Nav_Menu {
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $output .= '<li' . $class_names .'>';

        $attributes = ! empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) .'"' : '';
        $attributes .= ! empty($item->target)     ? ' target="' . esc_attr($item->target     ) .'"' : '';
        $attributes .= ! empty($item->xfn)        ? ' rel="'    . esc_attr($item->xfn        ) .'"' : '';
        $attributes .= ! empty($item->url)        ? ' href="'   . esc_attr($item->url        ) .'"' : '';

        $item_output = isset($args->before) ? $args->before : '';
        $item_output .= '<a class="flex items-center space-x-2 px-4 py-2 rounded-xl transition-all duration-300 text-green-100 hover:bg-white/10 hover:text-white"' . $attributes .'>';
        $item_output .= (isset($args->link_before) ? $args->link_before : '') . apply_filters('the_title', $item->title, $item->ID) . (isset($args->link_after) ? $args->link_after : '');
        $item_output .= '</a>';
        $item_output .= isset($args->after) ? $args->after : '';

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}

class AI_Tarim_Walker_Nav_Menu_Mobile extends Walker_Nav_Menu {
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $output .= '<div' . $class_names .'>';

        $attributes = ! empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) .'"' : '';
        $attributes .= ! empty($item->target)     ? ' target="' . esc_attr($item->target     ) .'"' : '';
        $attributes .= ! empty($item->xfn)        ? ' rel="'    . esc_attr($item->xfn        ) .'"' : '';
        $attributes .= ! empty($item->url)        ? ' href="'   . esc_attr($item->url        ) .'"' : '';

        $item_output = isset($args->before) ? $args->before : '';
        $item_output .= '<a class="w-full flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-300 text-green-100 hover:bg-white/10 hover:text-white"' . $attributes .'>';
        $item_output .= (isset($args->link_before) ? $args->link_before : '') . apply_filters('the_title', $item->title, $item->ID) . (isset($args->link_after) ? $args->link_after : '');
        $item_output .= '</a>';
        $item_output .= isset($args->after) ? $args->after : '';

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
        $output .= '</div>';
    }
}

class AI_Tarim_Walker_Footer_Menu extends Walker_Nav_Menu {
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $attributes = ! empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) .'"' : '';
        $attributes .= ! empty($item->target)     ? ' target="' . esc_attr($item->target     ) .'"' : '';
        $attributes .= ! empty($item->xfn)        ? ' rel="'    . esc_attr($item->xfn        ) .'"' : '';
        $attributes .= ! empty($item->url)        ? ' href="'   . esc_attr($item->url        ) .'"' : '';

        $item_output = '<a class="text-gray-300 hover:text-white transition-colors"' . $attributes .'>';
        $item_output .= apply_filters('the_title', $item->title, $item->ID);
        $item_output .= '</a>';

        $output .= '<div>' . $item_output . '</div>';
    }
}

// Fallback menus
function ai_tarim_fallback_menu() {
    echo '<div class="flex items-center space-x-1">';
    echo '<a href="' . esc_url(home_url('/')) . '" class="flex items-center space-x-2 px-4 py-2 rounded-xl transition-all duration-300 text-green-100 hover:bg-white/10 hover:text-white">Ana Sayfa</a>';
    echo '<a href="' . esc_url(home_url('/hizmetler/')) . '" class="flex items-center space-x-2 px-4 py-2 rounded-xl transition-all duration-300 text-green-100 hover:bg-white/10 hover:text-white">Hizmetler</a>';
    echo '<a href="' . esc_url(home_url('/hakkimizda/')) . '" class="flex items-center space-x-2 px-4 py-2 rounded-xl transition-all duration-300 text-green-100 hover:bg-white/10 hover:text-white">Hakkımızda</a>';
    echo '<a href="' . esc_url(home_url('/iletisim/')) . '" class="flex items-center space-x-2 px-4 py-2 rounded-xl transition-all duration-300 text-green-100 hover:bg-white/10 hover:text-white">İletişim</a>';
    echo '</div>';
}

function ai_tarim_footer_fallback_menu() {
    echo '<div class="space-y-2">';
    echo '<div><a href="' . esc_url(home_url('/')) . '" class="text-gray-300 hover:text-white transition-colors">Ana Sayfa</a></div>';
    echo '<div><a href="' . esc_url(home_url('/hizmetler/')) . '" class="text-gray-300 hover:text-white transition-colors">Hizmetler</a></div>';
    echo '<div><a href="' . esc_url(home_url('/hakkimizda/')) . '" class="text-gray-300 hover:text-white transition-colors">Hakkımızda</a></div>';
    echo '<div><a href="' . esc_url(home_url('/iletisim/')) . '" class="text-gray-300 hover:text-white transition-colors">İletişim</a></div>';
    echo '</div>';
}

// Add admin styles
function ai_tarim_admin_styles() {
    echo '<style>
        .ai-tarim-meta-box table.form-table th {
            width: 150px;
        }
        .ai-tarim-meta-box table.form-table td input[type="text"],
        .ai-tarim-meta-box table.form-table td select,
        .ai-tarim-meta-box table.form-table td textarea {
            width: 100%;
        }
    </style>';
}
add_action('admin_head', 'ai_tarim_admin_styles');

// Security enhancements
function ai_tarim_security_headers() {
    if (!is_admin()) {
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: SAMEORIGIN');
        header('X-XSS-Protection: 1; mode=block');
    }
}
add_action('send_headers', 'ai_tarim_security_headers');

// Remove WordPress version from head
remove_action('wp_head', 'wp_generator');

// Disable XML-RPC
add_filter('xmlrpc_enabled', '__return_false');

// Remove unnecessary WordPress features
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_shortlink_wp_head');

// Optimize WordPress
function ai_tarim_optimize_wp() {
    // Remove emoji scripts
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('admin_print_styles', 'print_emoji_styles');
    
    // Remove block library CSS if not using Gutenberg
    if (!is_admin()) {
        wp_dequeue_style('wp-block-library');
        wp_dequeue_style('wp-block-library-theme');
    }
}
add_action('init', 'ai_tarim_optimize_wp');

// Add theme support for Gutenberg
function ai_tarim_gutenberg_support() {
    add_theme_support('editor-styles');
    add_editor_style('editor-style.css');
    
    add_theme_support('editor-color-palette', array(
        array(
            'name' => 'Primary Green',
            'slug' => 'primary-green',
            'color' => '#059669',
        ),
        array(
            'name' => 'Primary Emerald',
            'slug' => 'primary-emerald',
            'color' => '#10b981',
        ),
        array(
            'name' => 'Secondary Blue',
            'slug' => 'secondary-blue',
            'color' => '#3b82f6',
        ),
        array(
            'name' => 'Accent Yellow',
            'slug' => 'accent-yellow',
            'color' => '#f59e0b',
        ),
    ));
}
add_action('after_setup_theme', 'ai_tarim_gutenberg_support');