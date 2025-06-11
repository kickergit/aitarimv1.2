<?php
/**
 * The template for displaying all pages
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