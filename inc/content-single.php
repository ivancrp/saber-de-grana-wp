<?php
/**
 * Template part for displaying single posts
 *
 * @package SaberDeGrana
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('bg-white rounded-lg overflow-hidden shadow-md'); ?>>
    <?php if (has_post_thumbnail()) : ?>
    <div class="post-thumbnail">
        <?php the_post_thumbnail('full', array('class' => 'w-full h-auto')); ?>
    </div>
    <?php endif; ?>

    <div class="px-6 py-8">
        <header class="entry-header mb-6">
            <div class="flex items-center mb-4 text-sm text-gray-600">
                <?php
                $categories = get_the_category();
                if (!empty($categories)) {
                    echo '<a href="' . esc_url(get_category_link($categories[0]->term_id)) . '" class="mr-4 text-primary hover:text-primary-dark">' . esc_html($categories[0]->name) . '</a>';
                }
                ?>
                <span class="mr-4"><?php echo get_the_date(); ?></span>
                <span><?php saberdegrana_reading_time(); ?></span>
            </div>

            <?php the_title('<h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">', '</h1>'); ?>

            <div class="flex items-center">
                <div class="flex-shrink-0 mr-3">
                    <?php echo get_avatar(get_the_author_meta('ID'), 40, '', '', array('class' => 'rounded-full w-10 h-10')); ?>
                </div>
                <div>
                    <p class="text-gray-900 font-medium"><?php the_author(); ?></p>
                </div>
            </div>
        </header>

        <div class="entry-content prose prose-lg max-w-none">
            <?php the_content(); ?>
        </div>

        <footer class="entry-footer mt-8 pt-6 border-t border-gray-200">
            <?php if (has_tag()) : ?>
            <div class="tags-links mb-6">
                <span class="text-gray-700 font-medium mr-2">Tags:</span>
                <?php the_tags('<span class="inline-flex flex-wrap gap-2">', '', '</span>'); ?>
            </div>
            <?php endif; ?>

            <?php
            // Posts relacionados
            $categories = get_the_category(get_the_ID());
            if ($categories) {
                $category_ids = array();
                foreach ($categories as $category) {
                    $category_ids[] = $category->term_id;
                }

                $related_posts = new WP_Query(array(
                    'category__in'        => $category_ids,
                    'post__not_in'        => array(get_the_ID()),
                    'posts_per_page'      => 3,
                    'ignore_sticky_posts' => 1
                ));

                if ($related_posts->have_posts()) :
            ?>
            <div class="related-posts mb-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Posts relacionados</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <?php
                    while ($related_posts->have_posts()) : $related_posts->the_post();
                        get_template_part('template-parts/content', 'related');
                    endwhile;
                    wp_reset_postdata();
                    ?>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Navegação entre posts -->
            <nav class="navigation post-navigation mb-8 pt-6 border-t border-gray-200">
                <h2 class="screen-reader-text">Navegação de posts</h2>
                <div class="nav-links flex flex-wrap justify-between">
                    <div class="nav-previous w-full md:w-1/2 mb-4 md:mb-0 md:pr-4">
                        <?php previous_post_link('<div class="text-sm text-gray-600 mb-1">Post anterior</div><span class="font-medium text-gray-900 hover:text-primary">%link</span>'); ?>
                    </div>
                    <div class="nav-next w-full md:w-1/2 text-right md:pl-4">
                        <?php next_post_link('<div class="text-sm text-gray-600 mb-1">Próximo post</div><span class="font-medium text-gray-900 hover:text-primary">%link</span>'); ?>
                    </div>
                </div>
            </nav>
            
            <!-- Comentários -->
            <?php
            if (comments_open() || get_comments_number()) :
                comments_template();
            endif;
            ?>
        </footer>
    </div>
</article>   </div>

    <footer class="entry-footer">
        <a href="<?php echo esc_url(get_permalink()); ?>" class="inline-block text-primary hover:text-primary-dark font-medium">
            Ler mais <span aria-hidden="true">→</span>
        </a>
    </footer>
</article>
```

Continuando com o arquivo assets/js/main.js:

```javascript
/**
 * Main JavaScript file for Saber de Grana theme
 */

(function($) {
    // Mobile menu toggle
    $('.mobile-menu-toggle').on('click', function() {
        $('#primary-menu-container').toggleClass('hidden');
        $(this).find('.hamburger-icon').toggleClass('hidden');
        $(this).find('.close-icon').toggleClass('hidden');
    });

    // Smooth scrolling for anchor links
    $('a[href*="#"]:not([href="#"])').on('click', function() {
        if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && location.hostname === this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
            if (target.length) {
                $('html, body').animate({
                    scrollTop: target.offset().top - 100
                }, 800);
                return false;
            }
        }
    });

    // Back to top button
    var backToTop = $('#back-to-top');
    
    $(window).scroll(function() {
        if ($(this).scrollTop() > 300) {
            backToTop.addClass('flex').removeClass('hidden');
        } else {
            backToTop.addClass('hidden').removeClass('flex');
        }
    });
    
    backToTop.on('click', function(e) {
        e.preventDefault();
        $('html, body').animate({scrollTop: 0}, 800);
    });

    // Newsletter form submission
    $('#newsletter-form').on('submit', function(e) {
        e.preventDefault();
        
        var email = $('#newsletter-email').val();
        
        // Basic validation
        if (!email || !email.includes('@')) {
            $('#newsletter-message').html('<div class="text-red-500">Por favor, insira um email válido.</div>');
            return;
        }
        
        // Here you would normally send an AJAX request to your server
        // For demo purposes, we'll just show a success message
        $('#newsletter-message').html('<div class="text-green-500">Obrigado por se inscrever!</div>');
        $('#newsletter-email').val('');
        
        // In a real implementation, you'd use something like:
        /*
        $.ajax({
            url: saberdegrana_vars.ajax_url,
            type: 'POST',
            data: {
                action: 'saberdegrana_newsletter_subscribe',
                email: email,
                nonce: saberdegrana_vars.nonce
            },
            success: function(response) {
                if (response.success) {
                    $('#newsletter-message').html('<div class="text-green-500">' + response.data.message + '</div>');
                    $('#newsletter-email').val('');
                } else {
                    $('#newsletter-message').html('<div class="text-red-500">' + response.data.message + '</div>');
                }
            },
            error: function() {
                $('#newsletter-message').html('<div class="text-red-500">Ocorreu um erro. Por favor, tente novamente.</div>');
            }
        });
        */
    });

})(jQuery);
```

Continuando com o arquivo comments.php:

```php
<?php
/**
 * The template for displaying comments
 *
 * @package SaberDeGrana
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area mt-12">

    <?php if (have_comments()) : ?>
        <h2 class="text-2xl font-bold text-gray-900 mb-6">
            <?php
            $comment_count = get_comments_number();
            if ('1' === $comment_count) {
                printf(esc_html__('1 comentário', 'saberdegrana'));
            } else {
                printf(
                    /* translators: %d: comment count number */
                    esc_html(_nx('%d comentário', '%d comentários', $comment_count, 'comments title', 'saberdegrana')),
                    esc_html(number_format_i18n($comment_count))
                );
            }
            ?>
        </h2>

        <ul class="comment-list space-y-6 mb-8">
            <?php
            wp_list_comments(array(
                'style'       => 'ul',
                'short_ping'  => true,
                'avatar_size' => 60,
                'callback'    => 'saberdegrana_comment_callback',
            ));
            ?>
        </ul>

        <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
        <nav class="comment-navigation flex justify-between mb-8" role="navigation">
            <div class="nav-previous"><?php previous_comments_link(esc_html__('Comentários anteriores', 'saberdegrana')); ?></div>
            <div class="nav-next"><?php next_comments_link(esc_html__('Comentários mais recentes', 'saberdegrana')); ?></div>
        </nav>
        <?php endif; ?>

        <?php
        // If comments are closed and there are comments, let's leave a little note.
        if (!comments_open()) :
            ?>
            <p class="no-comments text-gray-600 mb-6"><?php esc_html_e('Os comentários estão fechados.', 'saberdegrana'); ?></p>
            <?php
        endif;
    endif;

    comment_form(array(
        'title_reply'         => esc_html__('Deixe um comentário', 'saberdegrana'),
        'title_reply_before'  => '<h3 id="reply-title" class="comment-reply-title text-2xl font-bold text-gray-900 mb-6">',
        'title_reply_after'   => '</h3>',
        'class_form'          => 'comment-form space-y-4',
        'comment_field'       => '<div class="comment-form-comment">
                                    <label for="comment" class="block text-gray-700 font-medium mb-2">' . esc_html_x('Comentário', 'noun', 'saberdegrana') . '</label>
                                    <textarea id="comment" name="comment" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary" rows="5" required></textarea>
                                </div>',
        'fields'              => array(
            'author' => '<div class="comment-form-author">
                            <label for="author" class="block text-gray-700 font-medium mb-2">' . esc_html__('Nome', 'saberdegrana') . ' <span class="required text-red-500">*</span></label>
                            <input id="author" name="author" type="text" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary" required />
                        </div>',
            'email'  => '<div class="comment-form-email">
                            <label for="email" class="block text-gray-700 font-medium mb-2">' . esc_html__('Email', 'saberdegrana') . ' <span class="required text-red-500">*</span></label>
                            <input id="email" name="email" type="email" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary" required />
                        </div>',
            'url'    => '<div class="comment-form-url">
                            <label for="url" class="block text-gray-700 font-medium mb-2">' . esc_html__('Website', 'saberdegrana') . '</label>