<?php
/**
 * The template for displaying all pages
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
                <header class="entry-header mb-8 text-center">
                    <h1 class="entry-title text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                        <?php the_title(); ?>
                    </h1>
                    
                    <?php if (has_excerpt()) : ?>
                    <div class="entry-excerpt text-xl text-gray-600 max-w-3xl mx-auto">
                        <?php the_excerpt(); ?>
                    </div>
                    <?php endif; ?>
                </header>

                <?php if (has_post_thumbnail()) : ?>
                <div class="entry-thumbnail mb-8">
                    <?php the_post_thumbnail('large', array('class' => 'w-full h-auto rounded-lg shadow-md')); ?>
                </div>
                <?php endif; ?>

                <div class="entry-content prose prose-lg max-w-none">
                    <?php the_content(); ?>
                </div>
            </article>
            
        <?php endwhile; ?>
    </div>
    
    <?php get_template_part('template-parts/content', 'newsletter'); ?>
</main>

<?php
get_footer();