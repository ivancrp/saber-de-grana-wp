<?php
/**
 * Custom template tags for this theme
 *
 * @package SaberDeGrana
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Prints HTML with meta information for the current post (date, author, etc.)
 */
function saberdegrana_posted_on() {
    $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
    if (get_the_time('U') !== get_the_modified_time('U')) {
        $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
    }

    $time_string = sprintf(
        $time_string,
        esc_attr(get_the_date(DATE_W3C)),
        esc_html(get_the_date()),
        esc_attr(get_the_modified_date(DATE_W3C)),
        esc_html(get_the_modified_date())
    );

    $posted_on = sprintf(
        /* translators: %s: post date. */
        esc_html_x('%s', 'post date', 'saberdegrana'),
        '<a href="' . esc_url(get_permalink()) . '" rel="bookmark">' . $time_string . '</a>'
    );

    $byline = sprintf(
        /* translators: %s: post author. */
        esc_html_x('por %s', 'post author', 'saberdegrana'),
        '<span class="author vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a></span>'
    );

    echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>';
}

/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function saberdegrana_entry_footer() {
    // Hide category and tag text for pages.
    if ('post' === get_post_type()) {
        /* translators: used between list items, there is a space after the comma */
        $categories_list = get_the_category_list(esc_html__(', ', 'saberdegrana'));
        if ($categories_list) {
            /* translators: 1: list of categories. */
            printf('<span class="cat-links">' . esc_html__('Categorias: %1$s', 'saberdegrana') . '</span>', $categories_list);
        }

        /* translators: used between list items, there is a space after the comma */
        $tags_list = get_the_tag_list('', esc_html_x(', ', 'list item separator', 'saberdegrana'));
        if ($tags_list) {
            /* translators: 1: list of tags. */
            printf('<span class="tags-links">' . esc_html__('Tags: %1$s', 'saberdegrana') . '</span>', $tags_list);
        }
    }

    if (!is_single() && !post_password_required() && (comments_open() || get_comments_number())) {
        echo '<span class="comments-link">';
        comments_popup_link(
            sprintf(
                wp_kses(
                    /* translators: %s: post title */
                    __('Deixe um comentário<span class="screen-reader-text"> em %s</span>', 'saberdegrana'),
                    array(
                        'span' => array(
                            'class' => array(),
                        ),
                    )
                ),
                wp_kses_post(get_the_title())
            )
        );
        echo '</span>';
    }
}

/**
 * Displays an optional post thumbnail.
 *
 * @param string $size The size of the thumbnail.
 */
function saberdegrana_post_thumbnail($size = 'post-thumbnail') {
    if (post_password_required() || is_attachment() || !has_post_thumbnail()) {
        return;
    }

    if (is_singular()) :
        ?>
        <div class="post-thumbnail">
            <?php the_post_thumbnail($size); ?>
        </div><!-- .post-thumbnail -->
    <?php else : ?>
        <a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
            <?php
            the_post_thumbnail(
                $size,
                array(
                    'alt' => the_title_attribute(
                        array(
                            'echo' => false,
                        )
                    ),
                )
            );
            ?>
        </a>
        <?php
    endif;
}

/**
 * Prints the estimated reading time of a post.
 */
function saberdegrana_reading_time() {
    $content = get_post_field('post_content', get_the_ID());
    $word_count = str_word_count(strip_tags($content));
    $reading_time = ceil($word_count / 200); // Assume 200 words per minute reading time

    if ($reading_time < 1) {
        $reading_time = 1;
    }

    printf(
        /* translators: %s: reading time in minutes */
        _n(
            '%s min de leitura',
            '%s mins de leitura',
            $reading_time,
            'saberdegrana'
        ),
        number_format_i18n($reading_time)
    );
}

/**
 * Custom Walker class for primary menu
 */
class Saberdegrana_Walker_Nav_Menu extends Walker_Nav_Menu {
    /**
     * Starts the element output.
     */
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }
        
        $indent = ($depth) ? str_repeat($t, $depth) : '';
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        
        // Add active class
        $is_active = in_array('current-menu-item', $classes) || in_array('current-menu-parent', $classes) || in_array('current-menu-ancestor', $classes);
        
        $link_classes = 'text-white font-medium transition-colors';
        
        if ($is_active) {
            $link_classes .= ' text-secondary font-bold border-b-2 border-secondary';
        } else {
            $link_classes .= ' hover:text-secondary';
        }
        
        $attributes = '';
        $title  = ! empty($item->attr_title) ? $item->attr_title : '';
        $target = ! empty($item->target) ? ' target="' . $item->target . '"' : '';
        $rel    = ! empty($item->xfn) ? ' rel="' . $item->xfn . '"' : '';
        $href   = ! empty($item->url) ? ' href="' . $item->url . '"' : '';
        
        $attributes .= $target . $rel . $href . ' class="' . $link_classes . '"';
        
        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;
        
        $output .= $item_output;
    }
}

/**
 * Custom Walker class for mobile menu
 */
class Saberdegrana_Mobile_Walker_Nav_Menu extends Walker_Nav_Menu {
    /**
     * Starts the element output.
     */
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }
        
        $indent = ($depth) ? str_repeat($t, $depth) : '';
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        
        // Add active class
        $is_active = in_array('current-menu-item', $classes) || in_array('current-menu-parent', $classes) || in_array('current-menu-ancestor', $classes);
        
        $link_classes = 'block px-3 py-2 rounded-md font-medium';
        
        if ($is_active) {
            $link_classes .= ' bg-primary-dark text-secondary font-bold';
        } else {
            $link_classes .= ' text-white hover:bg-primary-dark';
        }
        
                $attributes = '';
        $title  = ! empty($item->attr_title) ? $item->attr_title : '';
        $target = ! empty($item->target) ? ' target="' . $item->target . '"' : '';
        $rel    = ! empty($item->xfn) ? ' rel="' . $item->xfn . '"' : '';
        $href   = ! empty($item->url) ? ' href="' . $item->url . '"' : '';
        
        $attributes .= $target . $rel . $href . ' class="' . $link_classes . '"';
        
        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;
        
        $output .= $item_output;
    }
}

/**
 * Custom Walker class for footer menu
 */
class Saberdegrana_Footer_Walker_Nav_Menu extends Walker_Nav_Menu {
    /**
     * Starts the element output.
     */
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }
        
        $indent = ($depth) ? str_repeat($t, $depth) : '';
        
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        
        $args = apply_filters('nav_menu_item_args', $args, $item, $depth);
        
        $class_names = implode(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
        
        $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';
        
        $output .= $indent . '<li' . $id . $class_names . '>';
        
        $attributes = '';
        $title  = ! empty($item->attr_title) ? $item->attr_title : '';
        $target = ! empty($item->target) ? ' target="' . $item->target . '"' : '';
        $rel    = ! empty($item->xfn) ? ' rel="' . $item->xfn . '"' : '';
        $href   = ! empty($item->url) ? ' href="' . $item->url . '"' : '';
        
        $attributes .= $target . $rel . $href . ' class="text-white/80 hover:text-secondary transition-colors"';
        
        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;
        
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}

/**
 * Displays post pagination links with custom styling
 */
function saberdegrana_pagination() {
    global $wp_query;
    $total = $wp_query->max_num_pages;
    
    if ($total > 1) {
        $current_page = get_query_var('paged') ? get_query_var('paged') : 1;
        
        echo '<nav class="pagination flex justify-center mt-10" role="navigation">';
        
        echo paginate_links(array(
            'base'         => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
            'format'       => '?paged=%#%',
            'current'      => max(1, $current_page),
            'total'        => $total,
            'prev_text'    => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5"><polyline points="15 18 9 12 15 6"></polyline></svg> ' . esc_html__('Anterior', 'saberdegrana'),
            'next_text'    => esc_html__('Próximo', 'saberdegrana') . ' <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5"><polyline points="9 18 15 12 9 6"></polyline></svg>',
            'type'         => 'list',
            'end_size'     => 3,
            'mid_size'     => 2,
            'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__('Página', 'saberdegrana') . ' </span>',
        ));
        
        echo '</nav>';
    }
}

/**
 * Get related posts based on post categories
 */
function saberdegrana_get_related_posts($post_id, $number_posts = 3) {
    $related_posts = new WP_Query(array(
        'post_type'      => 'post',
        'posts_per_page' => $number_posts,
        'post__not_in'   => array($post_id),
        'category__in'   => wp_get_post_categories($post_id),
        'orderby'        => 'rand',
    ));
    
    return $related_posts;
}

/**
 * Display social sharing buttons
 */
function saberdegrana_social_sharing() {
    $post_url = urlencode(get_permalink());
    $post_title = urlencode(get_the_title());
    $thumbnail = '';
    
    if (has_post_thumbnail()) {
        $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');
        $thumbnail = $thumbnail[0];
    }
    
    // Social Media Share URLs
    $twitter_url = 'https://twitter.com/intent/tweet?text=' . $post_title . '&url=' . $post_url;
    $facebook_url = 'https://www.facebook.com/sharer/sharer.php?u=' . $post_url;
    $linkedin_url = 'https://www.linkedin.com/shareArticle?mini=true&url=' . $post_url . '&title=' . $post_title;
    $whatsapp_url = 'https://api.whatsapp.com/send?text=' . $post_title . ' ' . $post_url;
    $email_url = 'mailto:?subject=' . $post_title . '&body=' . $post_url;
    
    echo '<div class="social-sharing flex space-x-2">';
    
    // Facebook
    echo '<a href="' . esc_url($facebook_url) . '" target="_blank" rel="noopener noreferrer" class="p-3 bg-gray-900 text-white rounded-full hover:bg-gray-700" aria-label="Compartilhar no Facebook">';
    echo '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5">';
    echo '<path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>';
    echo '</svg>';
    echo '</a>';
    
    // Twitter
    echo '<a href="' . esc_url($twitter_url) . '" target="_blank" rel="noopener noreferrer" class="p-3 bg-gray-900 text-white rounded-full hover:bg-gray-700" aria-label="Compartilhar no Twitter">';
    echo '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5">';
    echo '<path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"></path>';
    echo '</svg>';
    echo '</a>';
    
    // LinkedIn
    echo '<a href="' . esc_url($linkedin_url) . '" target="_blank" rel="noopener noreferrer" class="p-3 bg-gray-900 text-white rounded-full hover:bg-gray-700" aria-label="Compartilhar no LinkedIn">';
    echo '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5">';
    echo '<path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path>';
    echo '<rect x="2" y="9" width="4" height="12"></rect>';
    echo '<circle cx="4" cy="4" r="2"></circle>';
    echo '</svg>';
    echo '</a>';
    
    // WhatsApp
    echo '<a href="' . esc_url($whatsapp_url) . '" target="_blank" rel="noopener noreferrer" class="p-3 bg-gray-900 text-white rounded-full hover:bg-gray-700" aria-label="Compartilhar no WhatsApp">';
    echo '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5">';
    echo '<path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path>';
    echo '</svg>';
    echo '</a>';
    
    // Email
    echo '<a href="' . esc_url($email_url) . '" class="p-3 bg-gray-900 text-white rounded-full hover:bg-gray-700" aria-label="Compartilhar por Email">';
    echo '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5">';
    echo '<path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>';
    echo '<polyline points="22,6 12,13 2,6"></polyline>';
    echo '</svg>';
    echo '</a>';
    
    echo '</div>';
}

/**
 * Display post author box
 */
function saberdegrana_author_box() {
    $author_id = get_the_author_meta('ID');
    $author_posts_url = get_author_posts_url($author_id);
    $author_name = get_the_author_meta('display_name');
    $author_description = get_the_author_meta('description');
    $author_website = get_the_author_meta('user_url');
    $author_posts_count = count_user_posts($author_id);
    
    ?>
    <div class="author-box bg-gray-50 p-6 rounded-lg my-8">
        <div class="flex items-center mb-4">
            <?php echo get_avatar($author_id, 60, '', $author_name, array('class' => 'rounded-full mr-4')); ?>
            <div>
                <h3 class="text-lg font-semibold text-gray-900">
                    <?php echo esc_html($author_name); ?>
                </h3>
                <div class="text-sm text-gray-600">
                    <?php 
                    printf(
                        esc_html(_n('%s post', '%s posts', $author_posts_count, 'saberdegrana')), 
                        number_format_i18n($author_posts_count)
                    ); 
                    ?>
                </div>
                <?php if ($author_website) : ?>
                <a href="<?php echo esc_url($author_website); ?>" class="text-primary text-sm hover:underline" target="_blank" rel="noopener noreferrer">
                    <?php echo esc_url($author_website); ?>
                </a>
                <?php endif; ?>
            </div>
        </div>
        
        <?php if ($author_description) : ?>
        <div class="text-gray-700 mb-4">
            <?php echo wpautop($author_description); ?>
        </div>
        <?php endif; ?>
        
        <a href="<?php echo esc_url($author_posts_url); ?>" class="inline-flex items-center text-primary hover:text-primary-dark">
            <span>Ver todos os posts</span>
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 ml-1">
                <line x1="5" y1="12" x2="19" y2="12"></line>
                <polyline points="12 5 19 12 12 19"></polyline>
            </svg>
        </a>
    </div>
    <?php
}