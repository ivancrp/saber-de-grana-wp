<?php
/**
 * The template for displaying all single posts
 *
 * @package SaberDeGrana
 */

get_header();
?>

<main id="primary" class="site-main">
    <!-- Seção Hero para Posts -->
    <section class="hero">
        <div class="floating-elements">
            <div class="floating-element"></div>
            <div class="floating-element"></div>
            <div class="floating-element"></div>
            <div class="floating-element"></div>
        </div>
        <div class="hero-content">
            <h1 class="hero-title"><?php the_title(); ?></h1>
            <?php if (has_excerpt()) : ?>
                <p class="hero-subtitle"><?php the_excerpt(); ?></p>
            <?php endif; ?>
        </div>
    </section>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 pt-12 pb-12">


        <?php while (have_posts()) : the_post(); ?>
        
        <div class="single-post-layout" style="display: flex; gap: 3rem; align-items: flex-start; max-width: 80rem; margin: 0 auto;">
    <!-- Coluna da Esquerda: Conteúdo Principal do Post -->
    <div class="main-post-content" style="flex: 2 1 0; min-width: 0;">
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="entry-header mb-8">
                <?php
                if (has_category()) {
                    echo '<div class="mb-4">';
                    $categories = get_the_category();
                    foreach ($categories as $category) {
                        echo '<a href="' . esc_url(get_category_link($category->term_id)) . '" class="inline-block bg-primary/10 text-primary px-3 py-1 rounded-full text-sm font-medium mr-2 mb-2">' . esc_html($category->name) . '</a>';
                    }
                    echo '</div>';
                }
                ?>
                
                <div class="entry-meta py-2">
                    <?php
                    $author_id = get_the_author_meta('ID');
                    ?>
                    <div class="metadata-item">
                        <div class="author-avatar-wrapper">
                            <?php echo get_avatar($author_id, 44, '', '', array('class' => 'rounded-full')); ?>
                        </div>
                        <div>
                            <span class="author-name">
                                <?php the_author_posts_link(); ?>
                            </span>
                        </div>
                    </div>
                    
                    <div class="metadata-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        <span><?php echo get_the_date(); ?></span>
                    </div>
                    
                    <div class="metadata-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                        <span><?php saberdegrana_reading_time(); ?></span>
                    </div>
                    
                    <?php if (get_comments_number() > 0) : ?>
                    <div class="metadata-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                        </svg>
                        <span><?php comments_number('0 comentários', '1 comentário', '% comentários'); ?></span>
                    </div>
                    <?php endif; ?>
                </div>
            </header>

            <div class="entry-content prose prose-lg max-w-none mb-12">
                <?php the_content(); ?>
            </div>

            <footer class="entry-footer">
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
        </article>
    </div>

    <!-- Coluna da Direita: Posts Relacionados -->
    <div class="latest-posts-sidebar" style="flex: 1 1 320px; min-width: 280px; max-width: 400px;">
        <div class="sidebar-element mb-6" style="margin-top: 0; padding-top: 0;">
            <div class="mb-4 text-lg font-semibold text-gray-800">Compartilhe:</div>
            <?php saberdegrana_social_sharing(); ?>
        </div>
        <?php
        // Seção de Posts Relacionados
        $related_posts = saberdegrana_get_related_posts(get_the_ID(), 5);

        if ($related_posts->have_posts()) :
        ?>
        <div class="sidebar-element related-posts mb-8">
            <h3 class="text-xl font-bold text-gray-900 mb-4">Últimos Posts</h3>
            <div class="space-y-4">
                <?php
                while ($related_posts->have_posts()) : $related_posts->the_post();
                    get_template_part('template-parts/content', 'latest-post-item');
                endwhile;
                wp_reset_postdata();
                ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
</div>
        <?php endwhile; ?>
    </div>
    
    <!-- Sidebar mobile: só aparece no mobile -->
    <div class="latest-posts-sidebar-mobile">
        <div class="mb-6">
            <div class="mb-4 text-lg font-semibold text-gray-800">Compartilhe:</div>
            <?php saberdegrana_social_sharing(); ?>
        </div>
        <?php
        $related_posts = saberdegrana_get_related_posts(get_the_ID(), 5);
        if ($related_posts->have_posts()) :
        ?>
        <div class="related-posts mb-8">
            <h3 class="text-xl font-bold text-gray-900 mb-4">Últimos Posts</h3>
            <div class="space-y-4">
                <?php
                while ($related_posts->have_posts()) : $related_posts->the_post();
                    get_template_part('template-parts/content', 'latest-post-item');
                endwhile;
                wp_reset_postdata();
                ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
    <!-- Newsletter -->
    <div class="mt-8">
        <?php get_template_part('template-parts/content', 'newsletter'); ?>
    </div>
</main>

<?php
get_footer();