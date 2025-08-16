<?php

/**

 * The template for displaying search results pages

 *

 * @package SaberDeGrana

 */



get_header();

?>



<main id="primary" class="site-main pt-0 pb-12">

    <!-- Hero animada da busca -->
    <section class="hero">
        <div class="floating-elements">
            <div class="floating-element"></div>
            <div class="floating-element"></div>
            <div class="floating-element"></div>
            <div class="floating-element"></div>
        </div>
        <div class="hero-content">
            <h1 class="hero-title">
                <?php printf(esc_html__('Resultados da busca: %s', 'saberdegrana'), '<span style=\"color:#ff6b35;\">' . esc_html(get_search_query()) . '</span>'); ?>
            </h1>
      
            <div class="search-form mb-8 max-w-2xl mx-auto">
                <!-- Formulário de busca com filtros e modal -->
                <form id="busca-personalizada-form" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-center gap-4 relative">
                        <input type="text" name="s" placeholder="Buscar..." class="form-input w-full md:w-[550px] text-lg px-6 py2 border-2 border-gray-300 rounded-lg focus:border-primary focus:ring-2 focus:ring-primary transition-all duration-200 hover:border-primary" value="<?php echo esc_attr(get_search_query()); ?>" />
                        <button type="submit" class="btn btn-primary md:ml-2 border-2 border-primary rounded-lg bg-primary text-white px-8 py-2 text-lg transition-all duration-200 hover:bg-white hover:text-primary hover:border-primary">Buscar</button>
                        <button type="button" id="abrir-filtros" class="btn btn-primary ml-2 flex items-center justify-center border-2 border-gray-300 rounded-lg p-2 hover:border-primary transition-all duration-200" aria-label="Abrir filtros">
                            <!-- Ícone de filtro SVG -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707l-6.414 6.414A1 1 0 0013 13.414V19a1 1 0 01-1.447.894l-2-1A1 1 0 019 18v-4.586a1 1 0 00-.293-.707L2.293 6.707A1 1 0 012 6V4z" /></svg>
                        </button>
                    </div>
                    <!-- Modal de Filtros -->
                    <div id="modal-filtros" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
                        <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-md relative">
                            <button type="button" id="fechar-filtros" class="absolute top-2 right-2 text-gray-500 hover:text-primary text-2xl" aria-label="Fechar">&times;</button>
                            <h2 class="text-xl font-bold mb-6 text-center">Filtros</h2>
                            <div class="flex flex-col gap-4">
                                <select id="filtro-categoria" class="form-select w-full text-lg px-6 py-2 border-2 border-gray-300 rounded-lg focus:border-primary focus:ring-2 focus:ring-primary transition-all duration-200 hover:border-primary">
                                    <option value="">Todas as categorias</option>
                                    <?php
                                    $categories = get_categories(['hide_empty' => false]);
                                    $selected_cat = isset($_GET['categoria']) ? intval($_GET['categoria']) : '';
                                    foreach ($categories as $cat) {
                                        echo '<option value="' . esc_attr($cat->term_id) . '"' . selected($selected_cat, $cat->term_id, false) . '>' . esc_html($cat->name) . '</option>';
                                    }
                                    ?>
                                </select>
                                <select id="filtro-autor" class="form-select w-full text-lg px-6 py-2 border-2 border-gray-300 rounded-lg focus:border-primary focus:ring-2 focus:ring-primary transition-all duration-200 hover:border-primary">
                                    <option value="">Todos os autores</option>
                                    <?php
                                    $authors = get_users(['who' => 'authors']);
                                    $selected_author = isset($_GET['autor']) ? intval($_GET['autor']) : '';
                                    foreach ($authors as $author) {
                                        echo '<option value="' . esc_attr($author->ID) . '"' . selected($selected_author, $author->ID, false) . '>' . esc_html($author->display_name) . '</option>';
                                    }
                                    ?>
                                </select>
                                <select id="filtro-ano" class="form-select w-full text-lg px-6 py-2 border-2 border-gray-300 rounded-lg focus:border-primary focus:ring-2 focus:ring-primary transition-all duration-200 hover:border-primary">
                                    <option value="">Todos os anos</option>
                                    <?php
                                    global $wpdb;
                                    $years = $wpdb->get_col("SELECT DISTINCT YEAR(post_date) FROM $wpdb->posts WHERE post_status = 'publish' ORDER BY post_date DESC");
                                    $selected_year = isset($_GET['ano']) ? intval($_GET['ano']) : '';
                                    foreach ($years as $year) {
                                        echo '<option value="' . esc_attr($year) . '"' . selected($selected_year, $year, false) . '>' . esc_html($year) . '</option>';
                                    }
                                    ?>
                                </select>
                                <button type="button" id="aplicar-filtros" class="mt-4 w-full bg-primary text-white rounded-lg py-3 text-lg font-semibold hover:bg-primary-dark transition-all">Aplicar Filtros</button>
                            </div>
                        </div>
                    </div>
                    <!-- Filtros ocultos no form -->
                    <input type="hidden" name="categoria" id="input-categoria" value="<?php echo esc_attr($selected_cat); ?>">
                    <input type="hidden" name="autor" id="input-autor" value="<?php echo esc_attr($selected_author); ?>">
                    <input type="hidden" name="ano" id="input-ano" value="<?php echo esc_attr($selected_year); ?>">
                </form>
                <style>
                    #modal-filtros { animation: fadeIn .2s; }
                    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
                </style>
                <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const btnAbrir = document.getElementById('abrir-filtros');
                    const modal = document.getElementById('modal-filtros');
                    const btnFechar = document.getElementById('fechar-filtros');
                    const btnAplicar = document.getElementById('aplicar-filtros');
                    const inputCategoria = document.getElementById('input-categoria');
                    const inputAutor = document.getElementById('input-autor');
                    const inputAno = document.getElementById('input-ano');
                    const filtroCategoria = document.getElementById('filtro-categoria');
                    const filtroAutor = document.getElementById('filtro-autor');
                    const filtroAno = document.getElementById('filtro-ano');
                    const form = document.getElementById('busca-personalizada-form');

                    btnAbrir.addEventListener('click', () => {
                        modal.classList.remove('hidden');
                    });
                    btnFechar.addEventListener('click', () => {
                        modal.classList.add('hidden');
                    });
                    btnAplicar.addEventListener('click', () => {
                        inputCategoria.value = filtroCategoria.value;
                        inputAutor.value = filtroAutor.value;
                        inputAno.value = filtroAno.value;
                        modal.classList.add('hidden');
                        form.submit();
                    });
                    // Fechar modal ao clicar fora
                    modal.addEventListener('click', (e) => {
                        if (e.target === modal) modal.classList.add('hidden');
                    });
                });
                </script>
            </div>
        </div>
    </section>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8">


<br>      
             <h2 class="result-count">
                <?php
                global $wp_query;
                $total = $wp_query->found_posts;
                if ($total == 1) {
                    echo "1 resultado encontrado";
                } else {
                    echo $total . " resultados encontrados";
                }
                ?>
            </h2>
            <br> 
        <?php if (have_posts()) : ?>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">

                <?php

                while (have_posts()) :

                    the_post();

                    get_template_part('template-parts/content', 'card');

                endwhile;

                ?>

            </div>

            

            <div class="mt-10"  style="padding: 20px; display: flex; align-items: center; justify-content: center; flex: inherit;">

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
                    <br>
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
<br>
    </div>

</main>



<?php

get_footer();