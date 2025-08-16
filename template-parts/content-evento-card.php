<?php

/**

 * Template part for displaying event cards

 *

 * @package SaberDeGrana

 */



// Obter os metadados do evento

$evento_data_inicio = get_post_meta(get_the_ID(), '_evento_data_inicio', true);

$evento_local = get_post_meta(get_the_ID(), '_evento_local', true);



// Formatar data

$data_formatada = '';

if ($evento_data_inicio) {

    $data_formatada = date_i18n(get_option('date_format'), strtotime($evento_data_inicio));

}

?>



<article id="post-<?php the_ID(); ?>" <?php post_class('bg-white rounded-lg shadow-md overflow-hidden transition-transform transform hover:scale-105'); ?>>

    <?php if (has_post_thumbnail()) : ?>

    <a href="<?php the_permalink(); ?>" class="block relative">

        <?php the_post_thumbnail('card-thumb', array('class' => 'w-full h-48 object-cover')); ?>

        

        <?php 

        $tipos = get_the_terms(get_the_ID(), 'tipo_evento');

        if (!empty($tipos)) : 

            $tipo = $tipos[0];

        ?>

        <span class="absolute top-4 left-4 bg-primary text-white text-xs font-medium px-2 py-1 rounded">

            <?php echo esc_html($tipo->name); ?>

        </span>

        <?php endif; ?>

    </a>

    <?php endif; ?>

    

    <div class="p-5">

        <?php if ($evento_data_inicio) : ?>

        <div class="flex items-center text-gray-500 text-sm mb-2">

            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 mr-1">

                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>

                <line x1="16" y1="2" x2="16" y2="6"></line>

                <line x1="8" y1="2" x2="8" y2="6"></line>

                <line x1="3" y1="10" x2="21" y2="10"></line>

            </svg>

            <?php echo esc_html($data_formatada); ?>

        </div>

        <?php endif; ?>

        

        <h3 class="text-xl font-bold text-gray-900 mb-2">

            <a href="<?php the_permalink(); ?>" class="hover:text-primary transition-colors">

                <?php the_title(); ?>

            </a>

        </h3>

        

        <?php if ($evento_local) : ?>

        <div class="flex items-center text-gray-600 text-sm mb-4">

            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 mr-1">

                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>

                <circle cx="12" cy="10" r="3"></circle>

            </svg>

            <?php echo esc_html($evento_local); ?>

        </div>

        <?php endif; ?>

        

        <div class="text-gray-600 mb-4">

            <?php echo wp_trim_words(get_the_excerpt(), 10, '...'); ?>

        </div>

        

        <a href="<?php the_permalink(); ?>" class="inline-flex items-center text-primary hover:text-primary-dark">

            <span class="font-medium">Ver detalhes</span>

            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 ml-1">

                <line x1="5" y1="12" x2="19" y2="12"></line>

                <polyline points="12 5 19 12 12 19"></polyline>

            </svg>

        </a>

    </div>

</article>