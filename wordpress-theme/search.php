<?php
/**
 * The template for displaying search results pages
 *
 * @package AI_Tarim
 */

get_header(); ?>

<main class="min-h-screen gradient-bg">
    <div class="container mx-auto max-w-6xl px-4 py-8">
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 overflow-hidden">
            <div class="p-8">
                
                <!-- Search Header -->
                <header class="text-center mb-12">
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
                        Arama Sonuçları
                    </h1>
                    <p class="text-gray-600 text-lg">
                        "<?php echo get_search_query(); ?>" için arama sonuçları
                    </p>
                </header>

                <?php if (have_posts()) : ?>
                    <!-- Search Results -->
                    <div class="space-y-6 mb-12">
                        <?php while (have_posts()) : the_post(); ?>
                            <article class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 card-hover">
                                <div class="flex flex-col md:flex-row gap-6">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <div class="md:w-48 flex-shrink-0">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php the_post_thumbnail('medium', array('class' => 'w-full h-32 md:h-24 object-cover rounded-lg hover:scale-105 transition-transform duration-300')); ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="flex-1">
                                        <h2 class="text-xl font-bold text-gray-800 mb-3">
                                            <a href="<?php the_permalink(); ?>" class="hover:text-green-600 transition-colors">
                                                <?php the_title(); ?>
                                            </a>
                                        </h2>
                                        
                                        <p class="text-gray-600 mb-4">
                                            <?php echo wp_trim_words(get_the_excerpt(), 30); ?>
                                        </p>
                                        
                                        <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500">
                                            <span><?php echo get_the_date(); ?></span>
                                            <span>•</span>
                                            <span><?php the_author(); ?></span>
                                            <?php if (has_category()) : ?>
                                                <span>•</span>
                                                <span><?php the_category(', '); ?></span>
                                            <?php endif; ?>
                                            <div class="ml-auto">
                                                <a href="<?php the_permalink(); ?>" class="text-green-600 hover:text-green-700 font-semibold">
                                                    Devamını Oku →
                                                </a>
                                            </div>
                                        </div>
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
                        <div class="mb-6">
                            <svg class="h-24 w-24 text-gray-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800 mb-4">Sonuç Bulunamadı</h2>
                        <p class="text-gray-600 mb-6">
                            "<?php echo get_search_query(); ?>" için herhangi bir sonuç bulunamadı. 
                            Lütfen farklı anahtar kelimeler deneyin.
                        </p>
                        
                        <!-- Search Form -->
                        <div class="max-w-md mx-auto mb-6">
                            <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="flex">
                                <input type="search" 
                                       name="s" 
                                       value="<?php echo get_search_query(); ?>"
                                       placeholder="Yeni arama yapın..."
                                       class="flex-1 px-4 py-3 border border-gray-300 rounded-l-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                <button type="submit" 
                                        class="px-6 py-3 bg-green-600 text-white rounded-r-xl hover:bg-green-700 transition-colors">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                        
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