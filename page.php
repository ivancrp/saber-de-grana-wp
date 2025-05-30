<?php
/**
 * The template for displaying all pages
 *
 * @package SaberDeGrana
 */

get_header();
?>

<main id="primary" class="site-main">
    <!-- Seção Hero para Páginas -->
    <section class="relative bg-gradient-to-r from-primary to-primary-dark pt-24 pb-16 md:pt-32 md:pb-24">
        <?php if (has_post_thumbnail()) : ?>
            <div class="absolute inset-0 bg-[url('<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'full')); ?>')] bg-cover bg-center opacity-20 mix-blend-overlay"></div>
        <?php endif; ?>
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="max-w-3xl mx-auto text-center">
                <h1 class="text-3xl md:text-5xl font-bold text-white mb-6 leading-tight">
                    <?php the_title(); ?>
                </h1>
                <?php if (has_excerpt()) : ?>
                <p class="text-lg md:text-xl text-white/90 mb-8">
                    <?php the_excerpt(); ?>
                </p>
                <?php endif; ?>
                <?php
                // Opcional: Adicionar um botão se houver um link no excerpt ou meta
                // if (get_permalink()) : ?>
                <!-- <a href="<?php // the_permalink(); ?>" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-primary bg-secondary hover:bg-secondary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary">Saiba Mais</a> -->
                <?php // endif; ?>
            </div>
        </div>
        
        <div class="absolute bottom-0 left-0 right-0 h-16 bg-gradient-to-t from-background to-transparent"></div>
    </section>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 pt-12 pb-12">
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