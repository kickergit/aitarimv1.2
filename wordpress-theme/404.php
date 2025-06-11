<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package AI_Tarim
 */

get_header(); ?>

<main class="min-h-screen gradient-bg">
    <div class="container mx-auto max-w-4xl px-4 py-8">
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 overflow-hidden">
            <div class="p-8 text-center">
                
                <!-- 404 Icon -->
                <div class="mb-8">
                    <div class="inline-flex items-center justify-center w-32 h-32 bg-gradient-to-br from-red-500 to-pink-600 rounded-full shadow-lg mb-6">
                        <svg class="h-16 w-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <h1 class="text-6xl font-bold text-gray-800 mb-4">404</h1>
                </div>

                <!-- Error Message -->
                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-gray-800 mb-4">
                        Sayfa Bulunamadı
                    </h2>
                    <p class="text-gray-600 text-lg mb-6 max-w-2xl mx-auto">
                        Aradığınız sayfa mevcut değil, taşınmış veya silinmiş olabilir. 
                        Ana sayfaya dönerek istediğiniz içeriği bulabilirsiniz.
                    </p>
                </div>

                <!-- Search Form -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Arama Yapın</h3>
                    <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="max-w-md mx-auto">
                        <div class="flex">
                            <input type="search" 
                                   name="s" 
                                   placeholder="Aradığınızı buraya yazın..."
                                   class="flex-1 px-4 py-3 border border-gray-300 rounded-l-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            <button type="submit" 
                                    class="px-6 py-3 bg-green-600 text-white rounded-r-xl hover:bg-green-700 transition-colors">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Quick Links -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Hızlı Bağlantılar</h3>
                    <div class="flex flex-wrap justify-center gap-4">
                        <a href="<?php echo esc_url(home_url('/')); ?>" 
                           class="inline-flex items-center space-x-2 bg-green-600 text-white font-semibold py-3 px-6 rounded-xl shadow-lg hover:bg-green-700 transition-colors">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            <span>Ana Sayfa</span>
                        </a>
                        
                        <a href="<?php echo esc_url(home_url('/hizmetler/')); ?>" 
                           class="inline-flex items-center space-x-2 bg-blue-600 text-white font-semibold py-3 px-6 rounded-xl shadow-lg hover:bg-blue-700 transition-colors">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547A1.934 1.934 0 014 17.5c0 .775.301 1.52.828 2.047l8.489 8.489a2 2 0 002.828 0l8.489-8.489A2.934 2.934 0 0025 17.5c0-.775-.301-1.52-.828-2.047z"></path>
                            </svg>
                            <span>Hizmetler</span>
                        </a>
                        
                        <a href="<?php echo esc_url(home_url('/iletisim/')); ?>" 
                           class="inline-flex items-center space-x-2 bg-purple-600 text-white font-semibold py-3 px-6 rounded-xl shadow-lg hover:bg-purple-700 transition-colors">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <span>İletişim</span>
                        </a>
                    </div>
                </div>

                <!-- Recent Posts -->
                <?php
                $recent_posts = wp_get_recent_posts(array(
                    'numberposts' => 3,
                    'post_status' => 'publish'
                ));
                
                if ($recent_posts) : ?>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Son Yazılar</h3>
                        <div class="grid md:grid-cols-3 gap-4">
                            <?php foreach ($recent_posts as $post) : ?>
                                <a href="<?php echo get_permalink($post['ID']); ?>" 
                                   class="block bg-gray-50 rounded-lg p-4 hover:bg-gray-100 transition-colors text-left">
                                    <h4 class="font-semibold text-gray-800 mb-2">
                                        <?php echo $post['post_title']; ?>
                                    </h4>
                                    <p class="text-sm text-gray-600">
                                        <?php echo wp_trim_words($post['post_content'], 15); ?>
                                    </p>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>