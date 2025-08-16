<?php
/**
 * The template for displaying all pages
 *
 * @package SaberDeGrana
 */

get_header();
?>

<main id="primary" class="site-main">
    <!-- Hero animada para páginas -->
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

    <div  class="container mx-auto px-4 sm:px-6 lg:px-8 pt-12 pb-12">
        <?php
        while (have_posts()) :
            the_post();
            ?>
            
            <article id="post-<?php the_ID(); ?>" <?php post_class('max-w-4xl mx-auto'); ?>>
                <header class="entry-header mb-8 text-center">
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