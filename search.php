<?php
/**
 * The template for displaying search results pages
 *
 * @package SaberDeGrana
 */

get_header();
?>

<main id="primary" class="site-main pt-24 pb-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <header class="page-header mb-8 md:mb-12">
            <h1 class="page-title text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                <?php
                printf(
                    /* translators: %s: search query. */
                    esc_html__('Resultados da busca: %s', 'saberdegrana'),
                    '<span class="text-primary">' . get_search_query() . '</span>'
                );
                ?>
            </h1>
            
            <div class="search-form mb-8 max-w-2xl">
                <?php get_search_form(); ?>
            </div>
        </header>

        <?php if (have_posts()) : ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php
                while (have_posts()) :
                    the_post();
                    get_template_part('template-parts/content', 'card');
                endwhile;
                ?>
            </div>
            
            <div class="mt-10">
                <?php the_posts_pagination(array(
                    'prev_text' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5"><polyline points="15 18 9 12 15 6"></polyline></svg> ' . esc_html__('Anterior', 'saberdegrana'),
                    'next_text' => esc_html__('Próximo', 'saberdegrana') . ' <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5"><polyline points="9 18 15 12 9 6"></polyline></svg>',
                )); ?>
            </div>

        <?php else : ?>
            <div class="no-results text-center max-w-2xl mx-auto">
                <h2 class="text-2xl font-bold text-gray-900 mb-4"><?php esc_html_e('Nenhum resultado encontrado', 'saberdegrana'); ?></h2>
                <p class="text-gray-600 mb-8"><?php esc_html_e('Não encontramos resultados para sua busca. Tente usar palavras-chave diferentes.', 'saberdegrana'); ?></p>
                
                <div class="recent-searches mt-10">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4"><?php esc_html_e('Posts recentes', 'saberdegrana'); ?></h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <?php
                        $recent_posts = new WP_Query(array(
                            'post_type'      => 'post',
                            'posts_per_page' => 4,
                        ));
                        
                        if ($recent_posts->have_posts()) :
                            while ($recent_posts->have_posts()) : $recent_posts->the_post();
                                get_template_part('template-parts/content', 'related');
                            endwhile;
                            wp_reset_postdata();
                        endif;
                        ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php
get_footer();