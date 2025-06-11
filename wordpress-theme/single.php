<?php
/**
 * The template for displaying all single posts
 *
 * @package AI_Tarim
 */

get_header(); ?>

<main class="min-h-screen gradient-bg">
    <div class="container mx-auto max-w-4xl px-4 py-8">
        <?php while (have_posts()) : the_post(); ?>
            <article class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 overflow-hidden">
                
                <?php if (has_post_thumbnail()) : ?>
                    <div class="h-64 md:h-96 overflow-hidden">
                        <?php the_post_thumbnail('large', array('class' => 'w-full h-full object-cover')); ?>
                    </div>
                <?php endif; ?>

                <div class="p-8">
                    <header class="mb-8">
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
                            <?php the_title(); ?>
                        </h1>
                        
                        <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600 mb-6">
                            <div class="flex items-center">
                                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <?php echo get_the_date(); ?>
                            </div>
                            
                            <div class="flex items-center">
                                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <?php the_author(); ?>
                            </div>

                            <?php if (has_category()) : ?>
                                <div class="flex items-center">
                                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    <?php the_category(', '); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </header>

                    <div class="prose prose-lg max-w-none">
                        <?php
                        the_content();
                        
                        wp_link_pages(array(
                            'before' => '<div class="page-links mt-8 p-4 bg-gray-50 rounded-lg"><span class="font-semibold">Sayfalar:</span>',
                            'after'  => '</div>',
                        ));
                        ?>
                    </div>

                    <?php if (has_tag()) : ?>
                        <div class="mt-8 pt-8 border-t border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Etiketler</h3>
                            <div class="flex flex-wrap gap-2">
                                <?php
                                $tags = get_the_tags();
                                if ($tags) {
                                    foreach ($tags as $tag) {
                                        echo '<a href="' . get_tag_link($tag->term_id) . '" class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm hover:bg-green-200 transition-colors">' . $tag->name . '</a>';
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Author Bio -->
                    <?php if (get_the_author_meta('description')) : ?>
                        <div class="mt-8 pt-8 border-t border-gray-200">
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0">
                                    <?php echo get_avatar(get_the_author_meta('ID'), 64, '', '', array('class' => 'rounded-full')); ?>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800 mb-2">
                                        <?php the_author(); ?>
                                    </h3>
                                    <p class="text-gray-600">
                                        <?php the_author_meta('description'); ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Navigation -->
                    <div class="mt-8 pt-8 border-t border-gray-200">
                        <div class="flex flex-col md:flex-row justify-between gap-4">
                            <?php
                            $prev_post = get_previous_post();
                            $next_post = get_next_post();
                            ?>
                            
                            <?php if ($prev_post) : ?>
                                <a href="<?php echo get_permalink($prev_post); ?>" class="flex items-center space-x-3 p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors group">
                                    <svg class="h-5 w-5 text-gray-400 group-hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                    </svg>
                                    <div>
                                        <div class="text-sm text-gray-500">Önceki Yazı</div>
                                        <div class="font-semibold text-gray-800"><?php echo get_the_title($prev_post); ?></div>
                                    </div>
                                </a>
                            <?php endif; ?>

                            <?php if ($next_post) : ?>
                                <a href="<?php echo get_permalink($next_post); ?>" class="flex items-center space-x-3 p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors group text-right">
                                    <div>
                                        <div class="text-sm text-gray-500">Sonraki Yazı</div>
                                        <div class="font-semibold text-gray-800"><?php echo get_the_title($next_post); ?></div>
                                    </div>
                                    <svg class="h-5 w-5 text-gray-400 group-hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </article>

            <!-- Comments -->
            <?php if (comments_open() || get_comments_number()) : ?>
                <div class="mt-8 bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 p-8">
                    <?php comments_template(); ?>
                </div>
            <?php endif; ?>

        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?>