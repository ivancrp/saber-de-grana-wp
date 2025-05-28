<?php
/**
 * Template part for displaying post cards
 *
 * @package SaberDeGrana
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('post-card'); ?>>
    <?php if (has_post_thumbnail()) : ?>
        <div class="post-card__thumbnail">
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail('medium', ['class' => 'w-full h-auto']); ?>
            </a>
        </div>
    <?php endif; ?>
    <div class="p-6">
        <?php 
        $categories = get_the_category();
        if (!empty($categories)) : 
            $category = $categories[0];
        ?>
        <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" class="post-card__category">
            <?php echo esc_html($category->name); ?>
        </a>
        <?php else: ?>
        <span class="post-card__category post-card__category--default">
            Sem categoria
        </span>
        <?php endif; ?>
        
        <h3 class="post-card__title">
            <a href="<?php the_permalink(); ?>" class="hover:text-primary transition-colors">
                <?php the_title(); ?>
            </a>
        </h3>
        
        <div class="post-card__excerpt">
            <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
        </div>
        
        <div class="post-card__meta">
            <div class="flex items-center">
                <span class="post-card__date">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 mr-1">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                    <?php echo get_the_date(); ?>
                </span>
                
                <span class="flex items-center ml-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 mr-1">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                    <?php saberdegrana_reading_time(); ?>
                </span>
            </div>
        </div>
        
        <a href="<?php the_permalink(); ?>" class="post-card__read-more">
            Ler mais →
        </a>
    </div>
</article>