<?php
/**
 * Template part for displaying a latest post item in a list.
 *
 * @package SaberDeGrana
 */

?>

<div class="flex items-center space-x-4">
    <?php if (has_post_thumbnail()) : ?>
        <div class="flex-shrink-0">
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail('thumbnail', array('class' => 'w-16 h-16 object-cover rounded-md')); ?>
            </a>
        </div>
    <?php endif; ?>
    <div>
        <h4 class="text-sm font-medium text-gray-900 mb-1 leading-tight">
            <a href="<?php the_permalink(); ?>" class="hover:text-primary"><?php the_title(); ?></a>
        </h4>
        <?php if (has_excerpt()) : ?>
            <p class="text-xs text-gray-600"><?php echo wp_kses_post(wp_trim_words(get_the_excerpt(), 15)); ?></p>
        <?php endif; ?>
    </div>
</div> 