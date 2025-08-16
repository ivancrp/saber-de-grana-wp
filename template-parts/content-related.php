<?php
/**
 * Template part for displaying related posts
 *
 * @package SaberDeGrana
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('bg-white rounded-lg shadow overflow-hidden'); ?>>
    <?php if (has_post_thumbnail()) : ?>
    <a href="<?php the_permalink(); ?>" class="block">
        <?php the_post_thumbnail('medium', array('class' => 'w-full h-40 object-cover')); ?>
    </a>
    <?php endif; ?>
    
    <div class="p-4">
        <h3 class="text-base font-semibold text-gray-900 mb-2">
            <a href="<?php the_permalink(); ?>" class="hover:text-primary transition-colors">
                <?php the_title(); ?>
            </a>
        </h3>
        
        <div class="flex items-center text-gray-500 text-xs mb-2">
            <span>
                <?php echo get_the_date(); ?>
            </span>
            
            <span class="mx-2">•</span>
            
            <span>
                <?php saberdegrana_reading_time(); ?>
            </span>
        </div>
    </div>
</article>