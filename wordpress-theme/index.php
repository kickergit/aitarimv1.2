<?php
/**
 * The main template file
 *
 * @package AI_Tarim
 */

get_header(); ?>

<main class="min-h-screen gradient-bg">
    <div class="container mx-auto max-w-6xl px-4 py-8">
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 overflow-hidden">
            
            <?php if (have_posts()) : ?>
                <div class="p-8">
                    <!-- Hero Section -->
                    <div class="text-center mb-12 animate-fade-in">
                        <div class="flex justify-center mb-6">
                            <div class="bg-gradient-to-br from-green-500 to-emerald-600 p-4 rounded-2xl shadow-lg">
                                <svg class="h-12 w-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.5 2.5L16 5.5 13.5 3M7 7l2.5 2.5L11 7.5 8.5 5"></path>
                                </svg>
                            </div>
                        </div>
                        <h1 class="text-4xl font-bold text-gray-800 mb-4">
                            <?php echo get_theme_mod('hero_title', '🌿 AI Tarım - Yapay Zeka Destekli Tarım 🌿'); ?>
                        </h1>
                        <p class="text-gray-600 text-lg max-w-3xl mx-auto leading-relaxed">
                            <?php echo get_theme_mod('hero_description', 'Bitkilerinizin fotoğraflarını analiz edin, akıllı sulama tavsiyeleri alın ve tarımda teknolojinin gücünden faydalanın.'); ?>
                        </p>
                    </div>

                    <!-- Services Grid -->
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                        <?php
                        $services = array(
                            array(
                                'title' => get_theme_mod('service_1_title', 'Fotoğraf Analizi'),
                                'description' => get_theme_mod('service_1_desc', 'Bitki hastalıkları ve zararlı tespiti'),
                                'icon' => 'camera',
                                'color' => 'from-green-500 to-emerald-600'
                            ),
                            array(
                                'title' => get_theme_mod('service_2_title', 'İlaç Tavsiyesi'),
                                'description' => get_theme_mod('service_2_desc', 'Etken madde önerileri ve yasal uyarılar'),
                                'icon' => 'pill',
                                'color' => 'from-yellow-500 to-orange-600'
                            ),
                            array(
                                'title' => get_theme_mod('service_3_title', 'Akıllı Sulama'),
                                'description' => get_theme_mod('service_3_desc', 'FAO metodolojisi ile sulama hesaplaması'),
                                'icon' => 'droplets',
                                'color' => 'from-blue-500 to-cyan-600'
                            )
                        );

                        foreach ($services as $service) : ?>
                            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 card-hover animate-fade-in">
                                <div class="flex justify-center mb-4">
                                    <div class="bg-gradient-to-br <?php echo $service['color']; ?> p-3 rounded-xl shadow-lg">
                                        <?php ai_tarim_get_icon($service['icon'], 'h-8 w-8 text-white'); ?>
                                    </div>
                                </div>
                                <h3 class="text-xl font-bold text-gray-800 mb-3 text-center"><?php echo $service['title']; ?></h3>
                                <p class="text-gray-600 text-center leading-relaxed"><?php echo $service['description']; ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Blog Posts -->
                    <?php if (get_theme_mod('show_blog_posts', true)) : ?>
                        <div class="mb-12">
                            <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">Son Yazılar</h2>
                            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                                <?php while (have_posts()) : the_post(); ?>
                                    <article class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden card-hover">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <div class="h-48 overflow-hidden">
                                                <?php the_post_thumbnail('medium', array('class' => 'w-full h-full object-cover')); ?>
                                            </div>
                                        <?php endif; ?>
                                        <div class="p-6">
                                            <h3 class="text-xl font-bold text-gray-800 mb-3">
                                                <a href="<?php the_permalink(); ?>" class="hover:text-green-600 transition-colors">
                                                    <?php the_title(); ?>
                                                </a>
                                            </h3>
                                            <p class="text-gray-600 mb-4"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                                            <div class="flex justify-between items-center text-sm text-gray-500">
                                                <span><?php echo get_the_date(); ?></span>
                                                <a href="<?php the_permalink(); ?>" class="text-green-600 hover:text-green-700 font-semibold">
                                                    Devamını Oku →
                                                </a>
                                            </div>
                                        </div>
                                    </article>
                                <?php endwhile; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- CTA Section -->
                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl shadow-lg border border-green-200 p-8 text-center">
                        <h2 class="text-2xl font-bold text-green-700 mb-4">
                            <?php echo get_theme_mod('cta_title', 'Tarımda Yapay Zeka Deneyimini Başlatın'); ?>
                        </h2>
                        <p class="text-gray-700 leading-relaxed text-lg mb-6 max-w-4xl mx-auto">
                            <?php echo get_theme_mod('cta_description', 'Modern teknoloji ile tarımsal verimliliğinizi artırın. Hemen başlayın ve farkı görün.'); ?>
                        </p>
                        <?php if (get_theme_mod('cta_button_url')) : ?>
                            <a href="<?php echo esc_url(get_theme_mod('cta_button_url')); ?>" 
                               class="inline-flex items-center space-x-2 btn-primary text-white font-semibold py-4 px-8 rounded-xl shadow-lg">
                                <span><?php echo get_theme_mod('cta_button_text', 'Hemen Başla'); ?></span>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

            <?php else : ?>
                <div class="p-8 text-center">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">İçerik Bulunamadı</h2>
                    <p class="text-gray-600">Henüz yayınlanmış içerik bulunmuyor.</p>
                </div>
            <?php endif; ?>

        </div>
    </div>
</main>

<?php get_footer(); ?>