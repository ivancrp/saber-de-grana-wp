<?php
/**
 * Custom Post Types for Saber de Grana
 *
 * @package SaberDeGrana
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Register custom post types
 */
function saberdegrana_register_post_types() {
    // Eventos
    $labels = array(
        'name'               => _x('Eventos', 'post type general name', 'saberdegrana'),
        'singular_name'      => _x('Evento', 'post type singular name', 'saberdegrana'),
        'menu_name'          => _x('Eventos', 'admin menu', 'saberdegrana'),
        'name_admin_bar'     => _x('Evento', 'add new on admin bar', 'saberdegrana'),
        'add_new'            => _x('Adicionar Novo', 'evento', 'saberdegrana'),
        'add_new_item'       => __('Adicionar Novo Evento', 'saberdegrana'),
        'new_item'           => __('Novo Evento', 'saberdegrana'),
        'edit_item'          => __('Editar Evento', 'saberdegrana'),
        'view_item'          => __('Ver Evento', 'saberdegrana'),
        'all_items'          => __('Todos os Eventos', 'saberdegrana'),
        'search_items'       => __('Buscar Eventos', 'saberdegrana'),
        'parent_item_colon'  => __('Eventos Pai:', 'saberdegrana'),
        'not_found'          => __('Nenhum evento encontrado.', 'saberdegrana'),
        'not_found_in_trash' => __('Nenhum evento encontrado na lixeira.', 'saberdegrana')
    );

    $args = array(
        'labels'             => $labels,
        'description'        => __('Eventos relacionados a finanças e investimentos', 'saberdegrana'),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'eventos'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-calendar-alt',
        'supports'           => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments')
    );

    register_post_type('evento', $args);

    // Cursos
    $labels = array(
        'name'               => _x('Cursos', 'post type general name', 'saberdegrana'),
        'singular_name'      => _x('Curso', 'post type singular name', 'saberdegrana'),
        'menu_name'          => _x('Cursos', 'admin menu', 'saberdegrana'),
        'name_admin_bar'     => _x('Curso', 'add new on admin bar', 'saberdegrana'),
        'add_new'            => _x('Adicionar Novo', 'curso', 'saberdegrana'),
        'add_new_item'       => __('Adicionar Novo Curso', 'saberdegrana'),
        'new_item'           => __('Novo Curso', 'saberdegrana'),
        'edit_item'          => __('Editar Curso', 'saberdegrana'),
        'view_item'          => __('Ver Curso', 'saberdegrana'),
        'all_items'          => __('Todos os Cursos', 'saberdegrana'),
        'search_items'       => __('Buscar Cursos', 'saberdegrana'),
        'parent_item_colon'  => __('Cursos Pai:', 'saberdegrana'),
        'not_found'          => __('Nenhum curso encontrado.', 'saberdegrana'),
        'not_found_in_trash' => __('Nenhum curso encontrado na lixeira.', 'saberdegrana')
    );

    $args = array(
        'labels'             => $labels,
        'description'        => __('Cursos sobre finanças e investimentos', 'saberdegrana'),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'cursos'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 6,
        'menu_icon'          => 'dashicons-welcome-learn-more',
        'supports'           => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments')
    );

    register_post_type('curso', $args);
    
    // E-books
    $labels = array(
        'name'               => _x('E-books', 'post type general name', 'saberdegrana'),
        'singular_name'      => _x('E-book', 'post type singular name', 'saberdegrana'),
        'menu_name'          => _x('E-books', 'admin menu', 'saberdegrana'),
        'name_admin_bar'     => _x('E-book', 'add new on admin bar', 'saberdegrana'),
        'add_new'            => _x('Adicionar Novo', 'e-book', 'saberdegrana'),
        'add_new_item'       => __('Adicionar Novo E-book', 'saberdegrana'),
        'new_item'           => __('Novo E-book', 'saberdegrana'),
        'edit_item'          => __('Editar E-book', 'saberdegrana'),
        'view_item'          => __('Ver E-book', 'saberdegrana'),
        'all_items'          => __('Todos os E-books', 'saberdegrana'),
        'search_items'       => __('Buscar E-books', 'saberdegrana'),
        'parent_item_colon'  => __('E-books Pai:', 'saberdegrana'),
        'not_found'          => __('Nenhum e-book encontrado.', 'saberdegrana'),
        'not_found_in_trash' => __('Nenhum e-book encontrado na lixeira.', 'saberdegrana')
    );

    $args = array(
        'labels'             => $labels,
        'description'        => __('E-books sobre finanças e investimentos', 'saberdegrana'),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'ebooks'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 7,
        'menu_icon'          => 'dashicons-book',
        'supports'           => array('title', 'editor', 'author', 'thumbnail', 'excerpt')
    );

    register_post_type('ebook', $args);
}
add_action('init', 'saberdegrana_register_post_types');

/**
 * Register custom taxonomies
 */
function saberdegrana_register_taxonomies() {
    // Nível de Conhecimento (para Cursos)
    $labels = array(
        'name'              => _x('Níveis', 'taxonomy general name', 'saberdegrana'),
        'singular_name'     => _x('Nível', 'taxonomy singular name', 'saberdegrana'),
        'search_items'      => __('Buscar Níveis', 'saberdegrana'),
        'all_items'         => __('Todos os Níveis', 'saberdegrana'),
        'parent_item'       => __('Nível Pai', 'saberdegrana'),
        'parent_item_colon' => __('Nível Pai:', 'saberdegrana'),
        'edit_item'         => __('Editar Nível', 'saberdegrana'),
        'update_item'       => __('Atualizar Nível', 'saberdegrana'),
        'add_new_item'      => __('Adicionar Novo Nível', 'saberdegrana'),
        'new_item_name'     => __('Novo Nome de Nível', 'saberdegrana'),
        'menu_name'         => __('Níveis', 'saberdegrana'),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'nivel-conhecimento'),
    );

    register_taxonomy('nivel', array('curso'), $args);
    
    // Tipo de Evento
    $labels = array(
        'name'              => _x('Tipos de Evento', 'taxonomy general name', 'saberdegrana'),
        'singular_name'     => _x('Tipo de Evento', 'taxonomy singular name', 'saberdegrana'),
        'search_items'      => __('Buscar Tipos de Evento', 'saberdegrana'),
        'all_items'         => __('Todos os Tipos de Evento', 'saberdegrana'),
        'parent_item'       => __('Tipo de Evento Pai', 'saberdegrana'),
        'parent_item_colon' => __('Tipo de Evento Pai:', 'saberdegrana'),
        'edit_item'         => __('Editar Tipo de Evento', 'saberdegrana'),
        'update_item'       => __('Atualizar Tipo de Evento', 'saberdegrana'),
        'add_new_item'      => __('Adicionar Novo Tipo de Evento', 'saberdegrana'),
        'new_item_name'     => __('Novo Nome de Tipo de Evento', 'saberdegrana'),
        'menu_name'         => __('Tipos de Evento', 'saberdegrana'),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'tipo-evento'),
    );

    register_taxonomy('tipo_evento', array('evento'), $args);
}
add_action('init', 'saberdegrana_register_taxonomies');

/**
 * Add custom meta boxes for events
 */
function saberdegrana_add_meta_boxes() {
    add_meta_box(
        'evento_details',
        __('Detalhes do Evento', 'saberdegrana'),
        'saberdegrana_evento_details_callback',
        'evento',
        'normal',
        'high'
    );
    
    add_meta_box(
        'curso_details',
        __('Detalhes do Curso', 'saberdegrana'),
        'saberdegrana_curso_details_callback',
        'curso',
        'normal',
        'high'
    );
    
    add_meta_box(
        'ebook_details',
        __('Detalhes do E-book', 'saberdegrana'),
        'saberdegrana_ebook_details_callback',
        'ebook',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'saberdegrana_add_meta_boxes');

/**
 * Meta box callback for Event details
 */
function saberdegrana_evento_details_callback($post) {
    wp_nonce_field('saberdegrana_evento_details', 'saberdegrana_evento_details_nonce');

    $evento_data_inicio = get_post_meta($post->ID, '_evento_data_inicio', true);
    $evento_data_fim = get_post_meta($post->ID, '_evento_data_fim', true);
    $evento_horario = get_post_meta($post->ID, '_evento_horario', true);
    $evento_local = get_post_meta($post->ID, '_evento_local', true);
    $evento_endereco = get_post_meta($post->ID, '_evento_endereco', true);
    $evento_preco = get_post_meta($post->ID, '_evento_preco', true);
    $evento_link_inscricao = get_post_meta($post->ID, '_evento_link_inscricao', true);
    
    ?>
    <div class="saberdegrana-meta-box-field">
        <label for="evento_data_inicio"><?php esc_html_e('Data de Início', 'saberdegrana'); ?></label>
        <input type="date" id="evento_data_inicio" name="evento_data_inicio" value="<?php echo esc_attr($evento_data_inicio); ?>" class="regular-text">
    </div>
    
    <div class="saberdegrana-meta-box-field">
        <label for="evento_data_fim"><?php esc_html_e('Data de Término', 'saberdegrana'); ?></label>
        <input type="date" id="evento_data_fim" name="evento_data_fim" value="<?php echo esc_attr($evento_data_fim); ?>" class="regular-text">
    </div>
    
    <div class="saberdegrana-meta-box-field">
        <label for="evento_horario"><?php esc_html_e('Horário', 'saberdegrana'); ?></label>
        <input type="text" id="evento_horario" name="evento_horario" value="<?php echo esc_attr($evento_horario); ?>" class="regular-text" placeholder="Ex: 19h às 22h">
    </div>
    
    <div class="saberdegrana-meta-box-field">
        <label for="evento_local"><?php esc_html_e('Local', 'saberdegrana'); ?></label>
        <input type="text" id="evento_local" name="evento_local" value="<?php echo esc_attr($evento_local); ?>" class="regular-text" placeholder="Ex: Hotel Grand Plaza">
    </div>
    
    <div class="saberdegrana-meta-box-field">
        <label for="evento_endereco"><?php esc_html_e('Endereço', 'saberdegrana'); ?></label>
        <textarea id="evento_endereco" name="evento_endereco" class="large-text" rows="2"><?php echo esc_textarea($evento_endereco); ?></textarea>
    </div>
    
    <div class="saberdegrana-meta-box-field">
        <label for="evento_preco"><?php esc_html_e('Preço', 'saberdegrana'); ?></label>
        <input type="text" id="evento_preco" name="evento_preco" value="<?php echo esc_attr($evento_preco); ?>" class="regular-text" placeholder="Ex: R$ 150,00 ou Gratuito">
    </div>
    
    <div class="saberdegrana-meta-box-field">
        <label for="evento_link_inscricao"><?php esc_html_e('Link para Inscrição', 'saberdegrana'); ?></label>
        <input type="url" id="evento_link_inscricao" name="evento_link_inscricao" value="<?php echo esc_url($evento_link_inscricao); ?>" class="large-text">
    </div>
    <?php
}

/**
 * Meta box callback for Course details
 */
function saberdegrana_curso_details_callback($post) {
    wp_nonce_field('saberdegrana_curso_details', 'saberdegrana_curso_details_nonce');

    $curso_duracao = get_post_meta($post->ID, '_curso_duracao', true);
    $curso_instrutor = get_post_meta($post->ID, '_curso_instrutor', true);
    $curso_preco = get_post_meta($post->ID, '_curso_preco', true);
    $curso_link_inscricao = get_post_meta($post->ID, '_curso_link_inscricao', true);
    
    ?>
    <div class="saberdegrana-meta-box-field">
        <label for="curso_duracao"><?php esc_html_e('Duração', 'saberdegrana'); ?></label>
        <input type="text" id="curso_duracao" name="curso_duracao" value="<?php echo esc_attr($curso_duracao); ?>" class="regular-text" placeholder="Ex: 8 semanas">
    </div>
    
    <div class="saberdegrana-meta-box-field">
        <label for="curso_instrutor"><?php esc_html_e('Instrutor', 'saberdegrana'); ?></label>
        <input type="text" id="curso_instrutor" name="curso_instrutor" value="<?php echo esc_attr($curso_instrutor); ?>" class="regular-text">
    </div>
    
    <div class="saberdegrana-meta-box-field">
        <label for="curso_preco"><?php esc_html_e('Preço', 'saberdegrana'); ?></label>
        <input type="text" id="curso_preco" name="curso_preco" value="<?php echo esc_attr($curso_preco); ?>" class="regular-text" placeholder="Ex: R$ 397,00 ou Gratuito">
    </div>
    
    <div class="saberdegrana-meta-box-field">
        <label for="curso_link_inscricao"><?php esc_html_e('Link para Inscrição', 'saberdegrana'); ?></label>
        <input type="url" id="curso_link_inscricao" name="curso_link_inscricao" value="<?php echo esc_url($curso_link_inscricao); ?>" class="large-text">
    </div>
    <?php
}

/**
 * Meta box callback for E-book details
 */
function saberdegrana_ebook_details_callback($post) {
    wp_nonce_field('saberdegrana_ebook_details', 'saberdegrana_ebook_details_nonce');

    $ebook_paginas = get_post_meta($post->ID, '_ebook_paginas', true);
    $ebook_formato = get_post_meta($post->ID, '_ebook_formato', true);
    $ebook_preco = get_post_meta($post->ID, '_ebook_preco', true);
    $ebook_link_compra = get_post_meta($post->ID, '_ebook_link_compra', true);
    $ebook_arquivo = get_post_meta($post->ID, '_ebook_arquivo', true);
    
    ?>
    <div class="saberdegrana-meta-box-field">
        <label for="ebook_paginas"><?php esc_html_e('Número de Páginas', 'saberdegrana'); ?></label>
        <input type="number" id="ebook_paginas" name="ebook_paginas" value="<?php echo esc_attr($ebook_paginas); ?>" class="small-text">
    </div>
    
    <div class="saberdegrana-meta-box-field">
        <label for="ebook_formato"><?php esc_html_e('Formato', 'saberdegrana'); ?></label>
        <select id="ebook_formato" name="ebook_formato">
            <option value="PDF" <?php selected($ebook_formato, 'PDF'); ?>>PDF</option>
            <option value="EPUB" <?php selected($ebook_formato, 'EPUB'); ?>>EPUB</option>
            <option value="MOBI" <?php selected($ebook_formato, 'MOBI'); ?>>MOBI</option>
            <option value="PDF, EPUB, MOBI" <?php selected($ebook_formato, 'PDF, EPUB, MOBI'); ?>>PDF, EPUB, MOBI</option>
        </select>
    </div>
    
    <div class="saberdegrana-meta-box-field">
        <label for="ebook_preco"><?php esc_html_e('Preço', 'saberdegrana'); ?></label>
        <input type="text" id="ebook_preco" name="ebook_preco" value="<?php echo esc_attr($ebook_preco); ?>" class="regular-text" placeholder="Ex: R$ 29,90 ou Gratuito">
    </div>
    
    <div class="saberdegrana-meta-box-field">
        <label for="ebook_link_compra"><?php esc_html_e('Link para Compra', 'saberdegrana'); ?></label>
        <input type="url" id="ebook_link_compra" name="ebook_link_compra" value="<?php echo esc_url($ebook_link_compra); ?>" class="large-text">
    </div>
    
    <div class="saberdegrana-meta-box-field">
        <label for="ebook_arquivo"><?php esc_html_e('ID do Arquivo (Se gratuito)', 'saberdegrana'); ?></label>
        <input type="text" id="ebook_arquivo" name="ebook_arquivo" value="<?php echo esc_attr($ebook_arquivo); ?>" class="regular-text">
        <p class="description"><?php esc_html_e('Insira o ID do arquivo de mídia do WordPress para download gratuito', 'saberdegrana'); ?></p>
    </div>
    <?php
}

/**
 * Save post meta for custom post types
 */
function saberdegrana_save_post_meta($post_id) {
    // Check if our nonce is set for Events
    if (isset($_POST['saberdegrana_evento_details_nonce'])) {
        if (!wp_verify_nonce($_POST['saberdegrana_evento_details_nonce'], 'saberdegrana_evento_details')) {
            return;
        }
        
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
        
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
        
        // Event fields
        $fields = array(
            'evento_data_inicio', 'evento_data_fim', 'evento_horario', 
            'evento_local', 'evento_endereco', 'evento_preco', 
            'evento_link_inscricao'
        );
        
        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
            }
        }
    }
    
    // Check if our nonce is set for Courses
    if (isset($_POST['saberdegrana_curso_details_nonce'])) {
        if (!wp_verify_nonce($_POST['saberdegrana_curso_details_nonce'], 'saberdegrana_curso_details')) {
            return;
        }
        
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
        
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
        
        // Course fields
        $fields = array(
            'curso_duracao', 'curso_instrutor', 'curso_preco', 
            'curso_link_inscricao'
        );
        
        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
            }
        }
    }
    
    // Check if our nonce is set for E-books
    if (isset($_POST['saberdegrana_ebook_details_nonce'])) {
        if (!wp_verify_nonce($_POST['saberdegrana_ebook_details_nonce'], 'saberdegrana_ebook_details')) {
            return;
        }
        
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
        
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
        
        // E-book fields
        $fields = array(
            'ebook_paginas', 'ebook_formato', 'ebook_preco', 
            'ebook_link_compra', 'ebook_arquivo'
        );
        
        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
            }
        }
    }
}
add_action('save_post', 'saberdegrana_save_post_meta');