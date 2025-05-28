<?php
/**
 * The template for displaying all single posts
 *
 * @package SaberDeGrana
 */

get_header();
?>

<main id="primary" class="site-main pt-24 pb-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <?php
        while (have_posts()) :
            the_post();
            ?>
            
            <article id="post-<?php the_ID(); ?>" <?php post_class('max-w-4xl mx-auto'); ?>>
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
                    
                    <h1 class="entry-title text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-6">
                        <?php the_title(); ?>
                    </h1>
                    
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
                    
                    <?php if (has_post_thumbnail()) : ?>
                    <div class="entry-thumbnail mb-8">
                        <?php the_post_thumbnail('large', array('class' => 'w-full h-auto rounded-lg shadow-md')); ?>
                        <?php if (get_the_post_thumbnail_caption()) : ?>
                            <div class="text-sm text-gray-500 mt-2 italic">
                                <?php the_post_thumbnail_caption(); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
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
                    
                    <!-- Newsletter -->
                    <div class="mt-8">
                        <?php get_template_part('template-parts/content', 'newsletter-compact'); ?>
                    </div>
                </footer>
            </article>
        <?php endwhile; ?>
    </div>
</main>

<?php
get_footer();