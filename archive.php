<?php
/**
 * The template for displaying archive pages
 *
 * @package SaberDeGrana
 */

get_header();
?>

<main id="primary" class="site-main">
    <!-- Seção Hero para Arquivos -->
    <section class="relative bg-gradient-to-r from-primary to-primary-dark pt-24 pb-16 md:pt-32 md:pb-24">
        <?php
        // Não temos thumbnail para arquivos, então a imagem de fundo será a padrão do tema ou a do customizer, se configurada para a home
        // Se quiser uma imagem específica por categoria, precisaria de meta de termo e lógica aqui.
        // Por enquanto, usamos apenas o gradiente e o possível background global do hero.
        ?>
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center max-w-3xl mx-auto">
            <?php
            the_archive_title( '<h1 class="page-title text-3xl md:text-5xl font-bold text-white mb-4 leading-tight">', '</h1>' );
            the_archive_description( '<div class="archive-description text-lg md:text-xl text-white/90 mb-8">', '</div>' );
            ?>
        </div>
        
        <div class="absolute bottom-0 left-0 right-0 h-16 bg-gradient-to-t from-background to-transparent"></div>
    </section>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 pt-12 pb-12">
        <?php if (have_posts()) : ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php
                /* Start the Loop */
                while (have_posts()) : the_post();
                    /*
                     * Include the Post-Type-specific template for the content.
                     * If you want to override this in a child theme, then include a file
                     * called content-___.php (where ___ is the Post Type name)
                     * and that will be used instead.
                     */
                    get_template_part('template-parts/content', 'card');
                endwhile;
                ?>
            </div>

            <?php the_posts_navigation(); ?>

        <?php else : ?>
            <?php get_template_part('template-parts/content', 'none'); ?>

        <?php endif; ?>
    </div>
    
    <?php get_template_part('template-parts/content', 'newsletter'); ?>
</main>

<?php
get_footer(); 