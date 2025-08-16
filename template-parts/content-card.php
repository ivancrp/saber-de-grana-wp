<?php
/**
 * Template part for displaying post cards
 *
 * @package SaberDeGrana
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('card'); ?>>
    <a href="<?php the_permalink(); ?>">
        <div class="card-image">
            <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('medium', ['alt' => the_title_attribute('echo=0')]); ?>
            <?php else: ?>
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/hero-background.jpg" alt="Imagem padrão" style="width:100%;height:200px;object-fit:cover;filter:brightness(0.85);">
            <?php endif; ?>
            <?php 
            $categories = get_the_category();
            if (!empty($categories)) : 
                $category = $categories[0];
            ?>
            <span class="badge">
                <?php echo esc_html($category->name); ?>
            </span>
            <?php endif; ?>
        </div>
    </a>
    <div class="card-body">
        <a href="<?php the_permalink(); ?>">
            <h3 class="card-title">
                <?php the_title(); ?>
            </h3>
        </a>
        <p class="card-text line-clamp-3">
            <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); // Mantendo wp_trim_words para controle de tamanho do resumo ?>
        </p>
        <div class="card-footer">
            <div class="icon-text">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M8 2v4"></path>
                    <path d="M16 2v4"></path>
                    <rect width="18" height="18" x="3" y="4" rx="2"></rect>
                    <path d="M3 10h18"></path>
                </svg>
                <span><?php echo get_the_date(); ?></span>
            </div>
            <div class="icon-text">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
                <span><?php saberdegrana_reading_time(); ?></span>
            </div>
        </div>
        
    </div>
     <a href="<?php the_permalink(); ?>" class="read-more">
            LER MAIS →
        </a>
</article>