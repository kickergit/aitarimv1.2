<?php
/**
 * The template for displaying comments
 *
 * @package AI_Tarim
 */

if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area">

    <?php if (have_comments()) : ?>
        <h2 class="comments-title text-2xl font-bold text-gray-800 mb-6">
            <?php
            $comment_count = get_comments_number();
            if ('1' === $comment_count) {
                printf(
                    esc_html__('One thought on &ldquo;%1$s&rdquo;', 'ai-tarim'),
                    '<span>' . wp_kses_post(get_the_title()) . '</span>'
                );
            } else {
                printf(
                    esc_html(_nx(
                        '%1$s thought on &ldquo;%2$s&rdquo;',
                        '%1$s thoughts on &ldquo;%2$s&rdquo;',
                        $comment_count,
                        'comments title',
                        'ai-tarim'
                    )),
                    number_format_i18n($comment_count),
                    '<span>' . wp_kses_post(get_the_title()) . '</span>'
                );
            }
            ?>
        </h2>

        <ol class="comment-list space-y-6 mb-8">
            <?php
            wp_list_comments(array(
                'style'      => 'ol',
                'short_ping' => true,
                'callback'   => 'ai_tarim_comment_callback',
            ));
            ?>
        </ol>

        <?php
        the_comments_navigation(array(
            'prev_text' => '<span class="screen-reader-text">' . __('Previous Comments', 'ai-tarim') . '</span>',
            'next_text' => '<span class="screen-reader-text">' . __('Next Comments', 'ai-tarim') . '</span>',
        ));
        ?>

    <?php endif; ?>

    <?php if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) : ?>
        <p class="no-comments text-gray-600 text-center py-8">
            <?php esc_html_e('Comments are closed.', 'ai-tarim'); ?>
        </p>
    <?php endif; ?>

    <?php
    comment_form(array(
        'title_reply_before' => '<h3 id="reply-title" class="comment-reply-title text-xl font-bold text-gray-800 mb-6">',
        'title_reply_after'  => '</h3>',
        'class_form'         => 'comment-form space-y-6',
        'comment_field'      => '<div class="comment-form-comment">
            <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">' . _x('Comment', 'noun', 'ai-tarim') . ' <span class="required text-red-500">*</span></label>
            <textarea id="comment" name="comment" cols="45" rows="8" maxlength="65525" required="required" class="block w-full px-4 py-3 border border-gray-300 rounded-xl bg-gray-50 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 resize-none"></textarea>
        </div>',
        'fields'             => array(
            'author' => '<div class="comment-form-author">
                <label for="author" class="block text-sm font-medium text-gray-700 mb-2">' . __('Name', 'ai-tarim') . ' <span class="required text-red-500">*</span></label>
                <input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30" maxlength="245" autocomplete="name" required="required" class="block w-full px-4 py-3 border border-gray-300 rounded-xl bg-gray-50 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500" />
            </div>',
            'email'  => '<div class="comment-form-email">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">' . __('Email', 'ai-tarim') . ' <span class="required text-red-500">*</span></label>
                <input id="email" name="email" type="email" value="' . esc_attr($commenter['comment_author_email']) . '" size="30" maxlength="100" aria-describedby="email-notes" autocomplete="email" required="required" class="block w-full px-4 py-3 border border-gray-300 rounded-xl bg-gray-50 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500" />
            </div>',
            'url'    => '<div class="comment-form-url">
                <label for="url" class="block text-sm font-medium text-gray-700 mb-2">' . __('Website', 'ai-tarim') . '</label>
                <input id="url" name="url" type="url" value="' . esc_attr($commenter['comment_author_url']) . '" size="30" maxlength="200" autocomplete="url" class="block w-full px-4 py-3 border border-gray-300 rounded-xl bg-gray-50 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500" />
            </div>',
        ),
        'submit_button'      => '<input name="%1$s" type="submit" id="%2$s" class="%3$s" value="%4$s" />',
        'submit_field'       => '<div class="form-submit">%1$s %2$s</div>',
        'class_submit'       => 'submit btn-primary text-white font-semibold py-3 px-8 rounded-xl shadow-lg cursor-pointer',
    ));
    ?>

</div>

<?php
// Custom comment callback
function ai_tarim_comment_callback($comment, $args, $depth) {
    if ('div' === $args['style']) {
        $tag       = 'div';
        $add_below = 'comment';
    } else {
        $tag       = 'li';
        $add_below = 'div-comment';
    }
    ?>
    <<?php echo $tag; ?> <?php comment_class(empty($args['has_children']) ? '' : 'parent', $comment); ?> id="comment-<?php comment_ID(); ?>">
        <?php if ('div' != $args['style']) : ?>
            <div id="div-comment-<?php comment_ID(); ?>" class="comment-body bg-gray-50 rounded-xl p-6">
        <?php endif; ?>
        
        <div class="comment-author vcard flex items-start space-x-4">
            <?php if ($args['avatar_size'] != 0) : ?>
                <div class="flex-shrink-0">
                    <?php echo get_avatar($comment, 48, '', '', array('class' => 'rounded-full')); ?>
                </div>
            <?php endif; ?>
            
            <div class="flex-1">
                <div class="comment-meta commentmetadata mb-2">
                    <cite class="fn font-semibold text-gray-800">
                        <?php printf(__('%s', 'ai-tarim'), get_comment_author_link($comment)); ?>
                    </cite>
                    <span class="text-gray-500 text-sm ml-2">
                        <a href="<?php echo htmlspecialchars(get_comment_link($comment->comment_ID)); ?>" class="hover:text-gray-700">
                            <?php printf(__('%1$s at %2$s', 'ai-tarim'), get_comment_date(), get_comment_time()); ?>
                        </a>
                        <?php edit_comment_link(__('(Edit)', 'ai-tarim'), '  ', ''); ?>
                    </span>
                </div>

                <?php if ($comment->comment_approved == '0') : ?>
                    <em class="comment-awaiting-moderation text-yellow-600 text-sm">
                        <?php esc_html_e('Your comment is awaiting moderation.', 'ai-tarim'); ?>
                    </em>
                    <br />
                <?php endif; ?>

                <div class="comment-content text-gray-700 leading-relaxed">
                    <?php comment_text(); ?>
                </div>

                <div class="reply mt-4">
                    <?php
                    comment_reply_link(array_merge($args, array(
                        'add_below' => $add_below,
                        'depth'     => $depth,
                        'max_depth' => $args['max_depth'],
                        'class'     => 'text-green-600 hover:text-green-700 font-semibold text-sm'
                    )));
                    ?>
                </div>
            </div>
        </div>
        
        <?php if ('div' != $args['style']) : ?>
            </div>
        <?php endif; ?>
    <?php
}
?>