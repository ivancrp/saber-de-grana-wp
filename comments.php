<?php
/**
 * O template para exibir comentários
 *
 * @package SaberDeGrana
 */

/*
 * Se o post atual estiver protegido por senha e
 * o visitante ainda não inseriu a senha,
 * retornamos sem carregar os comentários.
 */
if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area bg-white p-8 rounded-lg shadow-sm mt-12">

    <?php if (have_comments()) : ?>
        <h2 class="text-2xl font-bold text-primary mb-6">
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
        // Se os comentários estiverem fechados e há comentários, deixe uma pequena nota.
        if (!comments_open()) :
            ?>
            <p class="no-comments text-gray-600 mb-6"><?php esc_html_e('Os comentários estão fechados.', 'saberdegrana'); ?></p>
            <?php
        endif;
    endif;

    // Formulário de comentários
    $commenter = wp_get_current_commenter();
    $consent = empty($commenter['comment_author_email']) ? '' : ' checked="checked"';
    
    $fields = array(
        'author' => '<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="form-group">
                            <label for="author" class="block text-gray-700 font-medium mb-2">' . esc_html__('Nome', 'saberdegrana') . ' <span class="required text-red-500">*</span></label>
                            <input id="author" name="author" type="text" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-transparent" value="' . esc_attr($commenter['comment_author']) . '" required />
                        </div>',
        'email'  => '<div class="form-group">
                        <label for="email" class="block text-gray-700 font-medium mb-2">' . esc_html__('E-mail', 'saberdegrana') . ' <span class="required text-red-500">*</span></label>
                        <input id="email" name="email" type="email" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-transparent" value="' . esc_attr($commenter['comment_author_email']) . '" required />
                    </div>
                </div>',
        'url'    => '<div class="form-group mb-6">
                        <label for="url" class="block text-gray-700 font-medium mb-2">' . esc_html__('Site', 'saberdegrana') . '</label>
                        <input id="url" name="url" type="url" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-transparent" value="' . esc_attr($commenter['comment_author_url']) . '" />
                    </div>',
        'cookies' => '<div class="form-group mb-6">
                        <div class="flex items-center">
                            <input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes" ' . $consent . ' class="mr-2 h-5 w-5 text-primary focus:ring-primary border-gray-300 rounded" />
                            <label for="wp-comment-cookies-consent" class="text-gray-700">' . esc_html__('Salvar meus dados neste navegador para a próxima vez que eu comentar.', 'saberdegrana') . '</label>
                        </div>
                    </div>',
    );

    $comment_field = '<div class="form-group mb-6">
                        <label for="comment" class="block text-gray-700 font-medium mb-2">' . esc_html_x('Comentário', 'noun', 'saberdegrana') . ' <span class="required text-red-500">*</span></label>
                        <textarea id="comment" name="comment" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-transparent" rows="6" required></textarea>
                    </div>';

    $submit_button = '<button type="submit" class="btn btn-primary py-3 px-6 text-base font-medium">' . esc_html__('Publicar comentário', 'saberdegrana') . '</button>';

    comment_form(array(
        'title_reply'          => esc_html__('Deixe um comentário', 'saberdegrana'),
        'title_reply_before'   => '<h3 id="reply-title" class="comment-reply-title text-2xl font-bold text-primary mb-6">',
        'title_reply_after'    => '</h3>',
        'cancel_reply_before'  => '<span class="cancel-reply ml-2">',
        'cancel_reply_after'   => '</span>',
        'cancel_reply_link'    => '<span class="text-sm text-gray-500 hover:text-primary transition-colors">' . esc_html__('Cancelar resposta', 'saberdegrana') . '</span>',
        'class_form'           => 'comment-form',
        'comment_field'        => $comment_field,
        'fields'               => $fields,
        'submit_button'        => $submit_button,
        'submit_field'         => '<div class="form-submit">%1$s %2$s</div>',
        'logged_in_as'         => '<p class="logged-in-as mb-6 text-gray-600">' .
                                  sprintf(
                                      /* translators: %1$s: user link, %2$s: logout link */
                                      __('Conectado como <a href="%1$s" class="text-primary hover:underline">%2$s</a>. <a href="%3$s" class="text-primary hover:underline">Sair?</a>', 'saberdegrana'),
                                      esc_url(get_edit_user_link()),
                                      esc_html($user_identity),
                                      esc_url(wp_logout_url(apply_filters('the_permalink', get_permalink())))
                                  ) . '</p>',
        'must_log_in'          => '<p class="must-log-in mb-6 text-gray-600">' .
                                  sprintf(
                                      /* translators: %s: login link */
                                      __('Você precisa <a href="%s" class="text-primary hover:underline">estar conectado</a> para publicar um comentário.', 'saberdegrana'),
                                      esc_url(wp_login_url(apply_filters('the_permalink', get_permalink())))
                                  ) . '</p>',
    ));
    ?>

</div><!-- #comments --> 