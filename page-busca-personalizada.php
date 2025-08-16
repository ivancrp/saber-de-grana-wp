<?php
/*
Template Name: Busca Personalizada
*/
get_header();
?>
<main id="primary" class="site-main">
    <!-- Seção Hero para Páginas -->
    <section class="relative bg-gradient-to-r from-primary to-primary-dark pt-24 pb-16 md:pt-32 md:pb-24">
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
            </div>
        </div>
    </section>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 pt-12 pb-12">
        <div class="max-w-4xl mx-auto mb-8">
            <form id="busca-personalizada-form" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                <div class="flex flex-col md:flex-row md:items-center md:justify-center gap-4 relative">
                    <input type="text" name="s" placeholder="Buscar..." class="form-input w-full md:w-[550px] text-lg px-6 py2 border-2 border-gray-300 rounded-lg focus:border-primary focus:ring-2 focus:ring-primary transition-all duration-200 hover:border-primary" value="<?php echo esc_attr(get_query_var('s')); ?>" />
                    <button type="submit" class="btn btn-primary md:ml-2 border-2 border-primary rounded-lg bg-primary text-white px-8 py-2 text-lg transition-all duration-200 hover:bg-white hover:text-primary hover:border-primary">Buscar</button>
                    <button type="button" id="abrir-filtros" class=" btn btn-primary ml-2 flex items-center justify-center border-2 border-gray-300  py-2 rounded-lg p-2 hover:border-primary transition-all duration-200" aria-label="Abrir filtros">
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
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        <?php
        // Exibir resultados da busca personalizada se houver parâmetros
        if (isset($_GET['s']) || isset($_GET['categoria']) || isset($_GET['autor']) || isset($_GET['ano'])) {
            $search = isset($_GET['s']) ? sanitize_text_field($_GET['s']) : '';
            $categoria = isset($_GET['categoria']) ? intval($_GET['categoria']) : '';
            $autor = isset($_GET['autor']) ? intval($_GET['autor']) : '';
            $ano = isset($_GET['ano']) ? intval($_GET['ano']) : '';
            $args = [
                'post_type' => 'post',
                'post_status' => 'publish',
                's' => $search,
                'posts_per_page' => 12,
            ];
            if ($categoria) {
                $args['cat'] = $categoria;
            }
            if ($autor) {
                $args['author'] = $autor;
            }
            if ($ano) {
                $args['year'] = $ano;
            }
            $query = new WP_Query($args);
            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();
                    get_template_part('template-parts/content', 'card');
                }
                wp_reset_postdata();
            } else {
                echo '<div class="col-span-full text-center py-8 text-gray-600">Nenhum resultado encontrado.</div>';
            }
        }
        ?>
        </div>
        <?php
        // Exibir o conteúdo da página normalmente
        if (have_posts()) :
            while (have_posts()) : the_post();
                echo '<div class="entry-content prose prose-lg max-w-none my-8">';
                the_content();
                echo '</div>';
            endwhile;
        endif;
        ?>
    </div>
    <?php get_template_part('template-parts/content', 'newsletter'); ?>
</main>
<?php get_footer(); ?> 