<?php
/**
 * The template for displaying archive pages
 *
 * @package AI_Tarim
 */

get_header(); ?>

<main class="min-h-screen gradient-bg">
    <div class="container mx-auto max-w-6xl px-4 py-8">
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 overflow-hidden">
            <div class="p-8">
                
                <!-- Archive Header -->
                <header class="text-center mb-12">
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
                        <?php
                        if (is_category()) {
                            single_cat_title();
                        } elseif (is_tag()) {
                            single_tag_title();
                        } elseif (is_author()) {
                            echo 'Yazar: ' . get_the_author();
                        } elseif (is_date()) {
                            echo 'Arşiv: ' . get_the_date('F Y');
                        } elseif (is_post_type_archive()) {
                            post_type_archive_title();
                        } else {
                            echo 'Arşiv';
                        }
                        ?>
                    </h1>
                    
                    <?php if (is_category() && category_description()) : ?>
                        <div class="text-gray-600 max-w-3xl mx-auto">
                            <?php echo category_description(); ?>
                        </div>
                    <?php elseif (is_tag() && tag_description()) : ?>
                        <div class="text-gray-600 max-w-3xl mx-auto">
                            <?php echo tag_description(); ?>
                        </div>
                    <?php endif; ?>
                </header>

                <?php if (have_posts()) : ?>
                    <!-- Posts Grid -->
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
                        <?php while (have_posts()) : the_post(); ?>
                            <article class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden card-hover">
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="h-48 overflow-hidden">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail('medium', array('class' => 'w-full h-full object-cover hover:scale-105 transition-transform duration-300')); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="p-6">
                                    <h2 class="text-xl font-bold text-gray-800 mb-3">
                                        <a href="<?php the_permalink(); ?>" class="hover:text-green-600 transition-colors">
                                            <?php the_title(); ?>
                                        </a>
                                    </h2>
                                    
                                    <p class="text-gray-600 mb-4">
                                        <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                                    </p>
                                    
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

                    <!-- Pagination -->
                    <div class="flex justify-center">
                        <?php
                        the_posts_pagination(array(
                            'mid_size' => 2,
                            'prev_text' => '← Önceki',
                            'next_text' => 'Sonraki →',
                            'class' => 'pagination flex items-center space-x-2',
                        ));
                        ?>
                    </div>

                <?php else : ?>
                    <div class="text-center py-12">
                        <h2 class="text-2xl font-bold text-gray-800 mb-4">İçerik Bulunamadı</h2>
                        <p class="text-gray-600 mb-6">Bu kategoride henüz yayınlanmış içerik bulunmuyor.</p>
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="inline-flex items-center space-x-2 btn-primary text-white font-semibold py-3 px-6 rounded-xl shadow-lg">
                            <span>Ana Sayfaya Dön</span>
                        </a>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>