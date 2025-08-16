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
    <section class="hero">
        <div class="floating-elements">
            <div class="floating-element"></div>
            <div class="floating-element"></div>
            <div class="floating-element"></div>
            <div class="floating-element"></div>
        </div>
        <div class="hero-content">
            <?php the_archive_title('<h1 class="hero-title">', '</h1>'); ?>
            <?php the_archive_description('<p class="hero-subtitle">', '</p>'); ?>
        </div>
    </section>



    <div class="container mx-auto px-4 sm:px-6 lg:px-8 pt-12 pb-12">

        <?php if (have_posts()) : ?>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">

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

            
            
            <div class="mt-10" style="padding: 20px; display: flex; align-items: center; justify-content: center;">
                <?php the_posts_pagination(array(
                    'prev_text' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5"><polyline points="15 18 9 12 15 6"></polyline></svg> ' . esc_html__('Anterior', 'saberdegrana'),
                    'next_text' => esc_html__('Próximo', 'saberdegrana') . ' <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5"><polyline points="9 18 15 12 9 6"></polyline></svg>',
                )); ?>
            </div>
            

        

                 

        <?php else : ?>

            
            <?php get_template_part('template-parts/content', 'none'); ?>

           



        <?php endif; ?>

    </div>

    

    <?php get_template_part('template-parts/content', 'newsletter'); ?>

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

</main>



<?php

get_footer(); 