<?php
/**
 * The template for displaying single event posts
 *
 * @package SaberDeGrana
 */

get_header();

// Obter os metadados do evento
$evento_data_inicio = get_post_meta(get_the_ID(), '_evento_data_inicio', true);
$evento_data_fim = get_post_meta(get_the_ID(), '_evento_data_fim', true);
$evento_horario = get_post_meta(get_the_ID(), '_evento_horario', true);
$evento_local = get_post_meta(get_the_ID(), '_evento_local', true);
$evento_endereco = get_post_meta(get_the_ID(), '_evento_endereco', true);
$evento_preco = get_post_meta(get_the_ID(), '_evento_preco', true);
$evento_link_inscricao = get_post_meta(get_the_ID(), '_evento_link_inscricao', true);

// Formatar datas
$data_inicio_formatada = '';
if ($evento_data_inicio) {
    $data_inicio_formatada = date_i18n(get_option('date_format'), strtotime($evento_data_inicio));
}
$data_fim_formatada = '';
if ($evento_data_fim) {
    $data_fim_formatada = date_i18n(get_option('date_format'), strtotime($evento_data_fim));
}
?>

<main id="primary" class="site-main py-16">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <?php
        while (have_posts()) :
            the_post();
        ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('bg-white rounded-lg overflow-hidden shadow-md'); ?>>
                <?php if (has_post_thumbnail()) : ?>
                <div class="post-thumbnail">
                    <?php the_post_thumbnail('full', array('class' => 'w-full h-auto object-cover max-h-96')); ?>
                </div>
                <?php endif; ?>

                <div class="px-6 py-8">
                    <header class="entry-header mb-8">
                        <!-- Tipos de evento como tags -->
                        <?php
                        $tipos = get_the_terms(get_the_ID(), 'tipo_evento');
                        if (!empty($tipos)) : 
                        ?>
                        <div class="mb-4">
                            <?php foreach ($tipos as $tipo) : ?>
                                <span class="inline-block bg-primary text-white text-xs font-medium px-3 py-1 rounded-full mr-2">
                                    <?php echo esc_html($tipo->name); ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                        
                        <?php the_title('<h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">', '</h1>'); ?>
                    </header>

                    <!-- Informações do evento -->
                    <div class="event-details bg-gray-50 rounded-lg p-6 mb-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <?php if ($evento_data_inicio) : ?>
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6 text-primary">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm text-gray-500 font-medium">Data</h3>
                                <p class="text-gray-900">
                                    <?php 
                                    echo esc_html($data_inicio_formatada);
                                    if ($data_fim_formatada && $data_fim_formatada != $data_inicio_formatada) {
                                        echo ' a ' . esc_html($data_fim_formatada);
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if ($evento_horario) : ?>
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6 text-primary">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <polyline points="12 6 12 12 16 14"></polyline>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm text-gray-500 font-medium">Horário</h3>
                                <p class="text-gray-900"><?php echo esc_html($evento_horario); ?></p>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if ($evento_local) : ?>
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6 text-primary">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm text-gray-500 font-medium">Local</h3>
                                <p class="text-gray-900"><?php echo esc_html($evento_local); ?></p>
                                <?php if ($evento_endereco) : ?>
                                <p class="text-gray-600 text-sm mt-1"><?php echo esc_html($evento_endereco); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if ($evento_preco) : ?>
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6 text-primary">
                                    <line x1="12" y1="1" x2="12" y2="23"></line>
                                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm text-gray-500 font-medium">Investimento</h3>
                                <p class="text-gray-900"><?php echo esc_html($evento_preco); ?></p>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- Conteúdo do evento -->
                    <div class="entry-content prose prose-lg max-w-none mb-8">
                        <?php the_content(); ?>
                    </div>

                    <!-- Botão de inscrição -->
                    <?php if ($evento_link_inscricao) : ?>
                    <div class="text-center mt-8">
                        <a href="<?php echo esc_url($evento_link_inscricao); ?>" target="_blank" class="inline-block bg-primary hover:bg-primary-dark text-white font-medium py-3 px-8 rounded-md transition duration-300">
                            Fazer inscrição
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </article>

            <!-- Navegação entre posts -->
            <nav class="navigation post-navigation my-8 pt-6 border-t border-gray-200">
                <h2 class="screen-reader-text">Navegação de eventos</h2>
                <div class="nav-links flex flex-wrap justify-between">
                    <div class="nav-previous w-full md:w-1/2 mb-4 md:mb-0 md:pr-4">
                        <?php previous_post_link('<div class="text-sm text-gray-600 mb-1">Evento anterior</div><span class="font-medium text-gray-900 hover:text-primary">%link</span>'); ?>
                    </div>
                    <div class="nav-next w-full md:w-1/2 text-right md:pl-4">
                        <?php next_post_link('<div class="text-sm text-gray-600 mb-1">Próximo evento</div><span class="font-medium text-gray-900 hover:text-primary">%link</span>'); ?>
                    </div>
                </div>
            </nav>

            <?php
            // Se comentários estão abertos ou temos pelo menos um comentário, carrega o template de comentários
            if (comments_open() || get_comments_number()) :
                comments_template();
            endif;
            ?>

        <?php endwhile; ?>
    </div>
</main>

<?php
// Seção de eventos relacionados
$current_evento_id = get_the_ID();
$related_eventos = new WP_Query(array(
    'post_type'      => 'evento',
    'posts_per_page' => 3,
    'post__not_in'   => array($current_evento_id),
    'orderby'        => 'meta_value',
    'meta_key'       => '_evento_data_inicio',
    'order'          => 'ASC',
    'meta_query'     => array(
        array(
            'key'     => '_evento_data_inicio',
            'value'   => date('Y-m-d'),
            'compare' => '>=',
            'type'    => 'DATE'
        )
    )
));

if ($related_eventos->have_posts()) :
?>
<section class="related-eventos py-12 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-8 text-center">Próximos Eventos</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <?php while ($related_eventos->have_posts()) : $related_eventos->the_post(); ?>
                <?php get_template_part('template-parts/content', 'evento-card'); ?>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php get_footer(); ?>