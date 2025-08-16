<?php

/**

 * Saber de Grana Theme functions and definitions

 *

 * @package SaberDeGrana

 */



if (!defined('ABSPATH')) {

    exit; // Exit if accessed directly

}



// Define Constants

define('SABERDEGRANA_VERSION', '1.0.1');

define('SABERDEGRANA_DIR', get_template_directory());

define('SABERDEGRANA_URI', get_template_directory_uri());



/**

 * Theme Setup

 */

function saberdegrana_setup() {

    // Add default posts and comments RSS feed links to head

    add_theme_support('automatic-feed-links');



    // Let WordPress manage the document title

    add_theme_support('title-tag');



    // Enable support for Post Thumbnails on posts and pages

    add_theme_support('post-thumbnails');



    // Enable support for HTML5 markup

    add_theme_support('html5', array(

        'search-form',

        'comment-form',

        'comment-list',

        'gallery',

        'caption',

        'style',

        'script',

    ));



    // Register navigation menus

    register_nav_menus(array(

        'primary' => esc_html__('Menu Principal', 'saberdegrana'),

        'footer' => esc_html__('Menu Rodapé', 'saberdegrana'),

    ));



    // Add theme support for Custom Logo

    add_theme_support('custom-logo', array(

        'height'      => 100,

        'width'       => 350,

        'flex-height' => true,

        'flex-width'  => true,

    ));

}

add_action('after_setup_theme', 'saberdegrana_setup');



/**

 * Enqueue scripts and styles

 */

function saberdegrana_scripts() {

    // Google Fonts já será otimizado no header.php
    

    // Carregar style.css e main.css de forma não bloqueante
    wp_enqueue_style('saberdegrana-style', get_stylesheet_uri(), array(), SABERDEGRANA_VERSION);
    wp_enqueue_style('saberdegrana-main', SABERDEGRANA_URI . '/assets/css/main.css', array('saberdegrana-style'), SABERDEGRANA_VERSION);
    wp_enqueue_style('saberdegrana-popup', SABERDEGRANA_URI . '/assets/css/popup.css', array('saberdegrana-style'), SABERDEGRANA_VERSION);

    // Adiar o carregamento do jQuery (defer)
    if (!is_admin()) {
        add_filter('script_loader_tag', function($tag, $handle) {
            if ($handle === 'jquery') {
                return str_replace(' src', ' defer src', $tag);
            }
            return $tag;
        }, 10, 2);
    }

    // Scripts customizados (já estão no footer)
    wp_enqueue_script('saberdegrana-navigation', SABERDEGRANA_URI . '/assets/js/main.js', array('jquery'), SABERDEGRANA_VERSION, true);
    wp_enqueue_script('saberdegrana-popup', SABERDEGRANA_URI . '/assets/js/popup.js', array(), SABERDEGRANA_VERSION, true);

    wp_localize_script('saberdegrana-navigation', 'saberdegranaData', array(
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'homeUrl' => home_url(),
        'themeUri' => SABERDEGRANA_URI,
    ));

    wp_localize_script('saberdegrana-popup', 'exitIntentConfig', array(
        'maxShows' => EXIT_INTENT_MAX_SHOWS,
        'cookieDuration' => EXIT_INTENT_COOKIE_DURATION,
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'isAdmin' => current_user_can('manage_options'),
    ));

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'saberdegrana_scripts');



/**

 * Register widget areas

 */

function saberdegrana_widgets_init() {

    register_sidebar(array(

        'name'          => esc_html__('Barra Lateral', 'saberdegrana'),

        'id'            => 'sidebar-1',

        'description'   => esc_html__('Adicione widgets aqui.', 'saberdegrana'),

        'before_widget' => '<section id="%1$s" class="widget %2$s">',

        'after_widget'  => '</section>',

        'before_title'  => '<h2 class="widget-title">',

        'after_title'   => '</h2>',

    ));

}

add_action('widgets_init', 'saberdegrana_widgets_init');



/**

 * Ajax handler for newsletter subscription

 */

function saberdegrana_newsletter_subscribe() {

    // Verificar nonce para segurança

    if (!isset($_POST['newsletter_nonce']) || !wp_verify_nonce($_POST['newsletter_nonce'], 'newsletter_nonce')) {

        wp_send_json(array(

            'success' => false,

            'message' => 'Erro de segurança. Por favor, recarregue a página e tente novamente.'

        ));

    }

    

    // Verificar se todos os campos necessários estão presentes

    if (!isset($_POST['name']) || !isset($_POST['email'])) {

        wp_send_json(array(

            'success' => false,

            'message' => 'Por favor, preencha todos os campos obrigatórios.'

        ));

    }

    

    $name = sanitize_text_field($_POST['name']);

    $email = sanitize_email($_POST['email']);

    

    // Validar e-mail

    if (!is_email($email)) {

        wp_send_json(array(

            'success' => false,

            'message' => 'Por favor, forneça um endereço de e-mail válido.'

        ));

    }

    

    // Aqui você pode adicionar a lógica para armazenar o e-mail em um serviço de newsletter

    // Como Mailchimp, MailerLite, etc.

    

    // Exemplo: Armazenar em uma opção do WordPress (para fins de demonstração)

    $subscribers = get_option('saberdegrana_subscribers', array());

    

    // Verificar se o e-mail já está na lista

    foreach ($subscribers as $subscriber) {

        if ($subscriber['email'] === $email) {

            wp_send_json(array(

                'success' => false,

                'message' => 'Este e-mail já está inscrito em nossa newsletter.'

            ));

        }

    }

    

    // Adicionar novo assinante

    $subscribers[] = array(

        'name' => $name,

        'email' => $email,

        'date' => current_time('mysql'),

    );

    

    update_option('saberdegrana_subscribers', $subscribers);

    

    // Enviar resposta de sucesso

    wp_send_json(array(

        'success' => true,

        'message' => 'Obrigado por se inscrever! Em breve você receberá nossas novidades.'

    ));

}

add_action('wp_ajax_newsletter_subscribe', 'saberdegrana_newsletter_subscribe');

add_action('wp_ajax_nopriv_newsletter_subscribe', 'saberdegrana_newsletter_subscribe');



/**

 * Custom template tags for this theme

 */

require SABERDEGRANA_DIR . '/inc/template-tags.php';



/**

 * Custom Post Types

 */

require SABERDEGRANA_DIR . '/inc/custom-post-types.php';



/**

 * Custom Functions

 */

require SABERDEGRANA_DIR . '/inc/custom-functions.php';

/**
 * Exit Intent Popup Configuration
 */
require SABERDEGRANA_DIR . '/inc/exit-intent-config.php';

/**
 * Exit Intent Popup Test removido - agora o gerenciamento é feito via painel administrativo
 */

/**

 * Obtém a URL da imagem da categoria

 * 

 * @param int $category_id ID da categoria

 * @return string URL da imagem ou vazio se não encontrada

 */

function saberdegrana_get_category_image_url($category_id) {
    // Primeiro tenta obter do term_meta (padrão para plugins de gerenciamento de categorias)
    $thumbnail_id = get_term_meta($category_id, 'thumbnail_id', true);
    if (!$thumbnail_id) {
        $thumbnail_id = get_term_meta($category_id, 'image', true);
    }
    if (!$thumbnail_id) {
        $thumbnail_id = get_term_meta($category_id, 'category_image', true);
    }
    // Se encontrou uma imagem, retorna a URL
    if ($thumbnail_id) {
        $image_url = wp_get_attachment_image_url($thumbnail_id, 'medium');
        if ($image_url) {
            return $image_url;
        }
    }
    // Caso não encontre, retorna a imagem padrão (usa hero-background.jpg se default-category.jpg não existir)
    $default = get_template_directory() . '/assets/images/default-category.jpg';
    if (file_exists($default)) {
        return get_template_directory_uri() . '/assets/images/default-category.jpg';
    } else {
        return get_template_directory_uri() . '/assets/images/hero-background.jpg';
    }
}



// Remove 'Category:', 'Tag:', 'Author:' from archive titles

function saberdegrana_remove_archive_title_prefix( $title ) {

    if ( is_category() ) {

        $title = single_cat_title( '', false );

    } elseif ( is_tag() ) {

        $title = single_tag_title( '', false );

    } elseif ( is_author() ) {

        $title = get_the_author();

    } elseif ( is_post_type_archive() ) {

        $title = post_type_archive_title( '', false );

    } elseif ( is_tax() ) {

        $taxonomy = get_taxonomy( get_queried_object()->taxonomy );

        $title = single_term_title( '', false );

    }

    // Optionally add more conditions for other archive types if needed

    

    return $title;

}

add_filter( 'get_the_archive_title', 'saberdegrana_remove_archive_title_prefix' );



// Customize posts navigation links to use buttons

function saberdegrana_customize_posts_navigation_links( $args ) {

    // Classes CSS para estilizar como botão

    $button_classes = 'inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors';



    // Adiciona margem entre os botões se ambos existirem

    if ( get_previous_posts_link() && get_next_posts_link() ) {

         $args['next_text'] = '<span class="ml-4 '. $button_classes . '">' . __( 'Próximas &rarr;', 'saberdegrana' ) . '</span>';

         $args['prev_text'] = '<span class="' . $button_classes . '">' . __( '&larr; Anteriores', 'saberdegrana' ) . '</span>';

    } elseif ( get_previous_posts_link() ) {

        // Apenas link de posts mais antigos

        $args['prev_text'] = '<span class="' . $button_classes . '">' . __( '&larr; Anteriores', 'saberdegrana' ) . '</span>';

    } elseif ( get_next_posts_link() ) {

        // Apenas link de posts mais novos

         $args['next_text'] = '<span class="' . $button_classes . '">' . __( 'Próximas &rarr;', 'saberdegrana' ) . '</span>';

    }

    

    // Remover o texto padrão do screen reader se não quisermos

    $args['screen_reader_text'] = ''; // Ou defina um texto alternativo



    return $args;

}

add_filter( 'the_posts_navigation_args', 'saberdegrana_customize_posts_navigation_links' );

// === Busca Personalizada AJAX ===
add_action('wp_ajax_busca_personalizada', 'saberdegrana_busca_personalizada_ajax');
add_action('wp_ajax_nopriv_busca_personalizada', 'saberdegrana_busca_personalizada_ajax');

function saberdegrana_busca_personalizada_ajax() {
    $search = isset($_POST['s']) ? sanitize_text_field($_POST['s']) : '';
    $categoria = isset($_POST['categoria']) ? intval($_POST['categoria']) : '';
    $autor = isset($_POST['autor']) ? intval($_POST['autor']) : '';
    $ano = isset($_POST['ano']) ? intval($_POST['ano']) : '';

    // Buscar todos os post types públicos
    $post_types = get_post_types(['public' => true], 'names');

    $args = [
        'post_type' => $post_types,
        'post_status' => 'publish',
        's' => $search,
        'posts_per_page' => 10,
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
        echo '<ul class="busca-personalizada-lista">';
        while ($query->have_posts()) {
            $query->the_post();
            echo '<li>';
            echo '<a href="' . get_permalink() . '">' . get_the_title() . '</a>';
            echo ' <span>(' . get_post_type_object(get_post_type())->labels->singular_name . ')</span>';
            echo '</li>';
        }
        echo '</ul>';
    } else {
        echo '<p>Nenhum resultado encontrado.</p>';
    }
    wp_reset_postdata();
    wp_die();
}

// Forçar busca padrão a exibir apenas posts
add_action('pre_get_posts', function($query) {
    if (!is_admin() && $query->is_main_query() && $query->is_search()) {
        $query->set('post_type', 'post');
    }
});

// === POPUP DE INTENÇÃO DE SAÍDA ===

/**
 * Adiciona o HTML do popup de exit intent
 */
function saberdegrana_exit_intent_popup_html() {
    // Verificar se o popup está habilitado
    if (!EXIT_INTENT_ENABLED) {
        return;
    }
    
    // Verificar se o popup já foi exibido nesta sessão
    if (isset($_COOKIE['exit_intent_shown'])) {
        return;
    }
    
    ?>
    <div id="exit-intent-popup" class="exit-intent-popup">
        <div class="exit-intent-overlay"></div>
        <div class="exit-intent-container">
            <button class="exit-intent-close" aria-label="Fechar popup" type="button">
                <span class="close-icon" aria-hidden="true">&times;</span>
            </button>
            
            <div class="exit-intent-content">
                <!-- Header -->
                <div class="exit-intent-header">
                    <h2><?php echo esc_html(EXIT_INTENT_TITLE); ?></h2>
                    <h3><?php echo esc_html(EXIT_INTENT_SUBTITLE); ?></h3>
                </div>
                
                <!-- Body -->
                <div class="exit-intent-body">
                    <!-- Formulário Centralizado -->
                    <div class="exit-intent-form-container">
                        <form id="exit-intent-form" method="post" class="exit-intent-form" novalidate>
                            <?php wp_nonce_field('exit_intent_nonce', 'exit_intent_nonce'); ?>
                            <div class="form-group">
                                <input 
                                    type="text" 
                                    name="name" 
                                    id="exit-name" 
                                    placeholder="<?php echo esc_attr(EXIT_INTENT_NAME_PLACEHOLDER); ?>" 
                                    required 
                                    autocomplete="name"
                                    aria-describedby="name-error"
                                >
                            </div>
                            <div class="form-group">
                                <input 
                                    type="email" 
                                    name="email" 
                                    id="exit-email" 
                                    placeholder="<?php echo esc_attr(EXIT_INTENT_EMAIL_PLACEHOLDER); ?>" 
                                    required 
                                    autocomplete="email"
                                    aria-describedby="email-error"
                                >
                            </div>
                            <button type="submit" aria-describedby="submit-status">
                                <span class="button-text"><?php echo esc_html(EXIT_INTENT_BUTTON_TEXT); ?></span>
                                <span class="button-loading" aria-hidden="true">Enviando...</span>
                            </button>
                        </form>
                        <div id="exit-intent-message" class="message" role="alert" aria-live="polite" style="display: none;"></div>
                    </div>
                </div>
                
                <!-- Footer -->
                <div class="exit-intent-footer">
                    <?php 
                        $description = str_replace(
                            EXIT_INTENT_HIGHLIGHT, 
                            '<span>' . EXIT_INTENT_HIGHLIGHT . '</span>', 
                            EXIT_INTENT_DESCRIPTION
                        );
                        echo wp_kses_post($description);
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php
}

/**
 * Adiciona o CSS do popup
 */
function saberdegrana_exit_intent_css() {
    // CSS movido para arquivo separado: assets/css/popup.css
    // Esta função agora apenas define variáveis CSS customizadas
    ?>
    <style>
    :root {
        --popup-bg-image: url('<?php echo EXIT_INTENT_BACKGROUND_IMAGE; ?>');
    }
    </style>
    <?php
}

/**
 * Adiciona o JavaScript do popup
 */
function saberdegrana_exit_intent_js() {
    // JavaScript movido para arquivo separado: assets/js/popup.js
    // Esta função agora está vazia pois o JavaScript é carregado via wp_enqueue_script
}

/**
 * Processa o formulário do popup via AJAX
 */
function saberdegrana_process_exit_intent_form() {
    // Debug: Log da requisição
    error_log('Exit Intent Form: Requisição recebida');
    error_log('Exit Intent Form: POST data: ' . print_r($_POST, true));
    
    // Verificar nonce
    if (!isset($_POST['exit_intent_nonce']) || !wp_verify_nonce($_POST['exit_intent_nonce'], 'exit_intent_nonce')) {
        error_log('Exit Intent Form: Erro de nonce');
        wp_send_json(array(
            'success' => false,
            'message' => 'Erro de segurança. Recarregue a página e tente novamente.'
        ));
    }
    
    // Validar campos
    if (!isset($_POST['name']) || !isset($_POST['email'])) {
        wp_send_json(array(
            'success' => false,
            'message' => 'Por favor, preencha todos os campos.'
        ));
    }
    
    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_email($_POST['email']);
    
    // Validar e-mail
    if (!is_email($email)) {
        wp_send_json(array(
            'success' => false,
            'message' => 'Por favor, forneça um e-mail válido.'
        ));
    }
    
    // Salvar no banco de dados
    $subscribers = get_option('saberdegrana_exit_intent_subscribers', array());
    
    // Debug: Log dos dados
    error_log('Exit Intent Form: Dados a serem salvos - Nome: ' . $name . ', Email: ' . $email);
    error_log('Exit Intent Form: Subscribers atuais: ' . print_r($subscribers, true));
    
    // Verificar se já existe
    foreach ($subscribers as $subscriber) {
        if ($subscriber['email'] === $email) {
            error_log('Exit Intent Form: Email já existe');
            wp_send_json(array(
                'success' => false,
                'message' => 'Este e-mail já foi cadastrado.'
            ));
        }
    }
    
    // Adicionar novo inscrito
    $subscribers[] = array(
        'name' => $name,
        'email' => $email,
        'date' => current_time('mysql'),
        'source' => 'exit_intent_popup'
    );
    
    error_log('Exit Intent Form: Salvando no banco...');
    $result = update_option('saberdegrana_exit_intent_subscribers', $subscribers);
    error_log('Exit Intent Form: Resultado do update_option: ' . ($result ? 'true' : 'false'));
    
    // Salvar em CSV (opcional)
    saberdegrana_save_to_csv($name, $email);
    
    // Enviar e-mail
    saberdegrana_send_exit_intent_email($name, $email);
    
    wp_send_json(array(
        'success' => true,
        'message' => 'Obrigado! Seu download será enviado para seu e-mail em instantes.'
    ));
}

add_action('wp_ajax_exit_intent_submit', 'saberdegrana_process_exit_intent_form');
add_action('wp_ajax_nopriv_exit_intent_submit', 'saberdegrana_process_exit_intent_form');

/**
 * Salva dados em arquivo CSV
 */
function saberdegrana_save_to_csv($name, $email) {
    if (!EXIT_INTENT_CSV_ENABLED) {
        return;
    }
    
    $upload_dir = wp_upload_dir();
    $csv_file = $upload_dir['basedir'] . '/' . EXIT_INTENT_CSV_FILENAME;
    
    // Criar cabeçalho se arquivo não existir
    if (!file_exists($csv_file)) {
        $header = "Nome,E-mail,Data,Origem\n";
        file_put_contents($csv_file, $header);
    }
    
    // Adicionar linha
    $line = sprintf('"%s","%s","%s","exit_intent_popup"' . "\n", 
        str_replace('"', '""', $name),
        str_replace('"', '""', $email),
        current_time('mysql')
    );
    
    file_put_contents($csv_file, $line, FILE_APPEND | LOCK_EX);
}

/**
 * Envia e-mail com link do download
 */
function saberdegrana_send_exit_intent_email($name, $email) {
    $subject = EXIT_INTENT_EMAIL_SUBJECT;
    
    // Link da página de downloads
    $download_url = 'https://saberdegrana.com.br/downloads/';
    
    $message = "
    <html>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Seu material está disponível</title>
        <style>
            body { 
                font-family: 'Inter', Arial, sans-serif; 
                line-height: 1.6; 
                color: #1f2937; 
                margin: 0; 
                padding: 0; 
                background-color: #F8FBFB;
            }
            .container { 
                max-width: 600px; 
                margin: 0 auto; 
                background-color: #ffffff;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }
            .header { 
                background: linear-gradient(135deg, #0D4F4C 0%, #136663 100%); 
                color: white; 
                padding: 30px 20px; 
                text-align: center; 
                border-radius: 8px 8px 0 0;
            }
            .header h1 {
                margin: 0;
                font-size: 28px;
                font-weight: 700;
                text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            }
            .content { 
                padding: 30px 20px; 
                background: #ffffff;
                border-radius: 0 0 8px 8px;
            }
            .button { 
                display: inline-block; 
                background: #ffffff; 
                color: #0D4F4C; 
                padding: 18px 35px; 
                text-decoration: none; 
                border-radius: 8px; 
                margin: 25px 0; 
                font-weight: 700;
                font-size: 16px;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
                transition: all 0.3s ease;
                border: 2px solid #0D4F4C;
            }
            .button:hover {
                background: #f8f9fa;
                color: #083B39;
                transform: translateY(-2px);
                box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
                border-color: #083B39;
            }
            .highlight-box {
                background: #E0F2F1;
                border-left: 4px solid #26A69A;
                padding: 20px;
                margin: 20px 0;
                border-radius: 0 8px 8px 0;
            }
            .highlight-box h3 {
                color: #0D4F4C;
                margin: 0 0 15px 0;
                font-size: 18px;
                font-weight: 700;
            }
            .highlight-box ul {
                margin: 0;
                padding-left: 20px;
            }
            .highlight-box li {
                margin-bottom: 8px;
                color: #1f2937;
            }
            .footer { 
                text-align: center; 
                padding: 20px; 
                color: #6b7280; 
                font-size: 12px;
                background: #f9fafb;
                border-top: 1px solid #e5e7eb;
            }
            .footer a {
                color: #0D4F4C;
                text-decoration: none;
            }
            .footer a:hover {
                color: #26A69A;
            }
            .text-center {
                text-align: center;
            }
            .download-link {
                word-break: break-all;
                color: #0D4F4C;
                text-decoration: none;
                font-weight: 500;
            }
            .download-link:hover {
                color: #26A69A;
                text-decoration: underline;
            }
            @media (max-width: 600px) {
                .container {
                    margin: 10px;
                }
                .header h1 {
                    font-size: 24px;
                }
                .content {
                    padding: 20px 15px;
                }
                .button {
                    padding: 15px 25px;
                    font-size: 14px;
                }
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h1>Olá, {$name}!</h1>
            </div>
            <div class='content'>
                <p>Oi {$name}, tudo bem?</p>
                
                <p>Recebemos seu interesse no nosso conteúdo sobre finanças pessoais. Como prometido, aqui está o guia que preparamos para você.</p>
                
                <p>O arquivo está disponível aqui:</p>
                <p class='text-center'>
                    <a href='{$download_url}' class='button'>ACESSAR CONTEÚDO</a>
                </p>
                
                <div class='highlight-box'>
                    <h3>O que tem no guia:</h3>
                    <ul>
                        <li>Dicas para economizar no dia a dia</li>
                        <li>Como organizar suas finanças</li>
                        <li>Ferramentas que podem ajudar</li>
                        <li>Passos para começar agora</li>
                    </ul>
                </div>
                
                <p>Caso o link não abra, você pode copiar este endereço no seu navegador:</p>
                <p><a href='{$download_url}' class='download-link'>{$download_url}</a></p>
                
                <p>Qualquer dúvida, é só responder este email!</p>
            </div>
            <div class='footer'>
                <p>Este e-mail foi enviado para <strong>{$email}</strong></p>
                <p><a href='" . home_url() . "'>" . get_bloginfo('name') . "</a> - " . get_bloginfo('description') . "</p>
                <p>Se quiser parar de receber nossos e-mails, <a href='https://saberdegrana.com.br/cancelar'>clique aqui para cancelar sua inscrição</a>.</p>
            </div>
        </div>
    </body>
    </html>
    ";
    
    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'From: ' . EXIT_INTENT_EMAIL_FROM_NAME . ' <' . EXIT_INTENT_EMAIL_FROM_EMAIL . '>',
        'List-Unsubscribe: <https://saberdegrana.com.br/cancelar>'
    );
    
    wp_mail($email, $subject, $message, $headers);
}

/**
 * Adiciona o popup ao footer
 */
function saberdegrana_add_exit_intent_popup() {
    saberdegrana_exit_intent_css();
    saberdegrana_exit_intent_js();
    saberdegrana_exit_intent_popup_html();
}

 add_action('wp_footer', 'saberdegrana_add_exit_intent_popup');

/**
 * Função para visualizar dados salvos (usar apenas para debug)
 */
function saberdegrana_view_subscribers() {
    if (!current_user_can('manage_options')) {
        return;
    }
    
    $subscribers = get_option('saberdegrana_exit_intent_subscribers', array());
    
    echo '<div style="background: white; padding: 20px; margin: 20px; border: 1px solid #ccc;">';
    echo '<h2>Inscritos do Popup Exit Intent</h2>';
    echo '<p>Total de inscritos: ' . count($subscribers) . '</p>';
    
    if (!empty($subscribers)) {
        echo '<table style="width: 100%; border-collapse: collapse;">';
        echo '<tr style="background: #f0f0f0;">';
        echo '<th style="border: 1px solid #ddd; padding: 8px;">Nome</th>';
        echo '<th style="border: 1px solid #ddd; padding: 8px;">E-mail</th>';
        echo '<th style="border: 1px solid #ddd; padding: 8px;">Data</th>';
        echo '<th style="border: 1px solid #ddd; padding: 8px;">Origem</th>';
        echo '</tr>';
        
        foreach ($subscribers as $subscriber) {
            echo '<tr>';
            echo '<td style="border: 1px solid #ddd; padding: 8px;">' . esc_html($subscriber['name']) . '</td>';
            echo '<td style="border: 1px solid #ddd; padding: 8px;">' . esc_html($subscriber['email']) . '</td>';
            echo '<td style="border: 1px solid #ddd; padding: 8px;">' . esc_html($subscriber['date']) . '</td>';
            echo '<td style="border: 1px solid #ddd; padding: 8px;">' . esc_html($subscriber['source']) . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo '<p>Nenhum inscrito encontrado.</p>';
    }
    
    echo '</div>';
}

// Comentado - agora os dados são visualizados no painel administrativo
// add_action('wp_footer', 'saberdegrana_view_subscribers');

/**
 * Função de teste removida - agora o gerenciamento é feito via painel administrativo
 */

/**
 * Adiciona página no painel administrativo para visualizar inscritos
 */
function saberdegrana_add_admin_menu() {
    add_menu_page(
        'Inscritos Popup', // Título da página
        'Inscritos Popup', // Título do menu
        'manage_options', // Capacidade necessária
        'saberdegrana-subscribers', // Slug da página
        'saberdegrana_admin_subscribers_page', // Função que renderiza a página
        'dashicons-email-alt', // Ícone
        30 // Posição no menu
    );
    
    // Adicionar submenu para teste da popup
    add_submenu_page(
        'saberdegrana-subscribers', // Parent slug
        'Testar Popup', // Título da página
        'Testar Popup', // Título do menu
        'manage_options', // Capacidade necessária
        'saberdegrana-test-popup', // Slug da página
        'saberdegrana_admin_test_popup_page' // Função que renderiza a página
    );
}
add_action('admin_menu', 'saberdegrana_add_admin_menu');

/**
 * Renderiza a página administrativa de inscritos
 */
function saberdegrana_admin_subscribers_page() {
    // Verificar permissões
    if (!current_user_can('manage_options')) {
        wp_die('Você não tem permissão para acessar esta página.');
    }
    
    // Processar ações
    if (isset($_POST['action']) && $_POST['action'] === 'delete_subscriber') {
        if (isset($_POST['subscriber_index']) && wp_verify_nonce($_POST['_wpnonce'], 'delete_subscriber')) {
            $subscribers = get_option('saberdegrana_exit_intent_subscribers', array());
            $index = intval($_POST['subscriber_index']);
            
            if (isset($subscribers[$index])) {
                unset($subscribers[$index]);
                $subscribers = array_values($subscribers); // Reindexar array
                update_option('saberdegrana_exit_intent_subscribers', $subscribers);
                echo '<div class="notice notice-success"><p>Inscrito removido com sucesso!</p></div>';
            }
        }
    }
    
    // Obter dados
    $subscribers = get_option('saberdegrana_exit_intent_subscribers', array());
    
    ?>
    <div class="wrap">
        <h1>Inscritos do Popup Exit Intent</h1>
        
        <div class="card">
            <h2>Estatísticas</h2>
            <p><strong>Total de inscritos:</strong> <?php echo count($subscribers); ?></p>
            <p><strong>Última atualização:</strong> <?php echo current_time('d/m/Y H:i:s'); ?></p>
        </div>
        
        <?php if (!empty($subscribers)): ?>
            <div class="card">
                <h2>Lista de Inscritos</h2>
                <table class="wp-list-table widefat fixed striped">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Data de Cadastro</th>
                            <th>Origem</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($subscribers as $index => $subscriber): ?>
                            <tr>
                                <td><?php echo esc_html($subscriber['name']); ?></td>
                                <td><?php echo esc_html($subscriber['email']); ?></td>
                                <td><?php echo esc_html($subscriber['date']); ?></td>
                                <td><?php echo esc_html($subscriber['source']); ?></td>
                                <td>
                                    <form method="post" style="display: inline;">
                                        <?php wp_nonce_field('delete_subscriber'); ?>
                                        <input type="hidden" name="action" value="delete_subscriber">
                                        <input type="hidden" name="subscriber_index" value="<?php echo $index; ?>">
                                        <button type="submit" class="button button-small button-link-delete" 
                                                onclick="return confirm('Tem certeza que deseja remover este inscrito?')">
                                            Remover
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                
                <div style="margin-top: 20px;">
                    <a href="<?php echo admin_url('admin-post.php?action=export_subscribers_csv'); ?>" 
                       class="button button-primary">
                        Exportar para CSV
                    </a>
                </div>
            </div>
        <?php else: ?>
            <div class="card">
                <p>Nenhum inscrito encontrado.</p>
            </div>
        <?php endif; ?>
    </div>
    <?php
}

/**
 * Função para exportar inscritos para CSV
 */
function saberdegrana_export_subscribers_csv() {
    if (!current_user_can('manage_options')) {
        wp_die('Você não tem permissão para acessar esta página.');
    }
    
    $subscribers = get_option('saberdegrana_exit_intent_subscribers', array());
    
    // Configurar headers para download
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=inscritos-popup-' . date('Y-m-d') . '.csv');
    
    // Criar arquivo CSV
    $output = fopen('php://output', 'w');
    
    // BOM para UTF-8
    fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
    
    // Cabeçalho
    fputcsv($output, array('Nome', 'E-mail', 'Data de Cadastro', 'Origem'));
    
    // Dados
    foreach ($subscribers as $subscriber) {
        fputcsv($output, array(
            $subscriber['name'],
            $subscriber['email'],
            $subscriber['date'],
            $subscriber['source']
        ));
    }
    
    fclose($output);
    exit;
}
add_action('admin-post_export_subscribers_csv', 'saberdegrana_export_subscribers_csv');

/**
 * Renderiza a página administrativa de teste da popup
 */
function saberdegrana_admin_test_popup_page() {
    // Verificar permissões
    if (!current_user_can('manage_options')) {
        wp_die('Você não tem permissão para acessar esta página.');
    }
    
    // Processar teste de envio de email
    if (isset($_POST['action']) && $_POST['action'] === 'test_email') {
        if (wp_verify_nonce($_POST['_wpnonce'], 'test_popup_email')) {
            $test_email = sanitize_email($_POST['test_email']);
            $test_name = sanitize_text_field($_POST['test_name']);
            
            if (is_email($test_email)) {
                saberdegrana_send_exit_intent_email($test_name, $test_email);
                echo '<div class="notice notice-success"><p>Email de teste enviado com sucesso para: ' . esc_html($test_email) . '</p></div>';
            } else {
                echo '<div class="notice notice-error"><p>Email inválido. Por favor, verifique o endereço.</p></div>';
            }
        }
    }
    
    ?>
    <div class="wrap">
        <h1>Testar Popup Exit Intent</h1>
        
        <div class="card">
            <h2>Teste de Email</h2>
            <p>Envie um email de teste para verificar se o template está funcionando corretamente.</p>
            
            <form method="post" style="max-width: 500px;">
                <?php wp_nonce_field('test_popup_email'); ?>
                <input type="hidden" name="action" value="test_email">
                
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="test_name">Nome</label>
                        </th>
                        <td>
                            <input type="text" id="test_name" name="test_name" class="regular-text" 
                                   value="<?php echo esc_attr(wp_get_current_user()->display_name); ?>" required>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="test_email">Email</label>
                        </th>
                        <td>
                            <input type="email" id="test_email" name="test_email" class="regular-text" 
                                   value="<?php echo esc_attr(wp_get_current_user()->user_email); ?>" required>
                        </td>
                    </tr>
                </table>
                
                <p class="submit">
                    <button type="submit" class="button button-primary">Enviar Email de Teste</button>
                </p>
            </form>
        </div>
        
        <div class="card">
            <h2>Teste da Popup no Frontend</h2>
            <p>Para testar a popup no frontend do site:</p>
            <ol>
                <li>Abra uma nova aba e acesse: <a href="<?php echo home_url(); ?>" target="_blank"><?php echo home_url(); ?></a></li>
                <li>Mova o mouse para fora da janela do navegador (exit intent)</li>
                <li>A popup deve aparecer automaticamente</li>
            </ol>
            
            <h3>🎯 Funcionalidades Especiais para Administradores:</h3>
            <ul>
                <li><strong>Painel de Teste:</strong> Aparece no canto inferior direito da tela quando você está logado como admin</li>
                <li><strong>Botão Testar Popup:</strong> Abre a popup instantaneamente</li>
                <li><strong>Botão Resetar Estado:</strong> Limpa o estado da popup para testar novamente</li>
                <li><strong>Atalho de Teclado:</strong> Pressione <code>Ctrl + Shift + P</code> para abrir a popup instantaneamente</li>
                <li><strong>Reset de Estado:</strong> Pressione <code>Ctrl + Shift + R</code> para resetar o estado da popup</li>
                <li><strong>Feedback Visual:</strong> O botão de reset mostra confirmação visual quando acionado</li>
                <li><strong>Sem Limite de Cookie:</strong> A popup pode ser testada múltiplas vezes sem limpar cookies</li>
            </ul>
            
            <h3>Dicas Gerais para Teste:</h3>
            <ul>
                <li><strong>Limpar cookies:</strong> Se a popup não aparecer, pode ser que o cookie de "já mostrado" esteja ativo. Limpe os cookies do navegador.</li>
                <li><strong>Modo desenvolvedor:</strong> Abra o console do navegador (F12) para ver possíveis erros JavaScript.</li>
                <li><strong>Teste em diferentes navegadores:</strong> Chrome, Firefox, Safari, Edge.</li>
                <li><strong>Teste em dispositivos móveis:</strong> A popup tem design responsivo.</li>
            </ul>
        </div>
        
        <div class="card">
            <h2>Configurações Atuais</h2>
            <table class="form-table">
                <tr>
                    <th scope="row">Popup Habilitada</th>
                    <td><?php echo EXIT_INTENT_ENABLED ? '✅ Sim' : '❌ Não'; ?></td>
                </tr>
                <tr>
                    <th scope="row">URL do Download</th>
                    <td><a href="<?php echo EXIT_INTENT_DOWNLOAD_URL; ?>" target="_blank"><?php echo EXIT_INTENT_DOWNLOAD_URL; ?></a></td>
                </tr>
                <tr>
                    <th scope="row">Duração do Cookie</th>
                    <td><?php echo EXIT_INTENT_COOKIE_DURATION; ?> dia(s)</td>
                </tr>
                <tr>
                    <th scope="row">Máximo de Exibições</th>
                    <td><?php echo EXIT_INTENT_MAX_SHOWS; ?> vez(es) por sessão</td>
                </tr>
                <tr>
                    <th scope="row">Assunto do Email</th>
                    <td><?php echo EXIT_INTENT_EMAIL_SUBJECT; ?></td>
                </tr>
                <tr>
                    <th scope="row">Email Remetente</th>
                    <td><?php echo EXIT_INTENT_EMAIL_FROM_NAME; ?> &lt;<?php echo EXIT_INTENT_EMAIL_FROM_EMAIL; ?>&gt;</td>
                </tr>
            </table>
        </div>
        
        <div class="card">
            <h2>Preview do Template de Email</h2>
            <p>Visualização de como o email será enviado:</p>
            <div style="border: 1px solid #ddd; padding: 20px; background: #f9f9f9; max-width: 600px;">
                <?php
                $preview_name = 'Nome de Teste';
                $preview_email = 'teste@exemplo.com';
                $preview_url = EXIT_INTENT_DOWNLOAD_URL;
                
                $preview_html = "
                <div style='max-width: 600px; margin: 0 auto; background-color: #ffffff; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);'>
                    <div style='background: linear-gradient(135deg, #0D4F4C 0%, #136663 100%); color: white; padding: 30px 20px; text-align: center; border-radius: 8px 8px 0 0;'>
                        <h1 style='margin: 0; font-size: 28px; font-weight: 700; text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);'>Olá, {$preview_name}!</h1>
                    </div>
                    <div style='padding: 30px 20px; background: #ffffff; border-radius: 0 0 8px 8px;'>
                        <p>Oi {$preview_name}, tudo bem?</p>
                        
                        <p>Recebemos seu interesse no nosso conteúdo sobre finanças pessoais. Como prometido, aqui está o guia que preparamos para você.</p>
                        
                        <p>O arquivo está disponível aqui:</p>
                        <p style='text-align: center;'>
                            <a href='{$preview_url}' style='display: inline-block; background: #ffffff; color: #0D4F4C; padding: 18px 35px; text-decoration: none; border-radius: 8px; margin: 25px 0; font-weight: 700; font-size: 16px; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15); border: 2px solid #0D4F4C;'>ACESSAR CONTEÚDO</a>
                        </p>
                        <div style='background: #E0F2F1; border-left: 4px solid #26A69A; padding: 20px; margin: 20px 0; border-radius: 0 8px 8px 0;'>
                            <h3 style='color: #0D4F4C; margin: 0 0 15px 0; font-size: 18px; font-weight: 700;'>O que tem no guia:</h3>
                            <ul style='margin: 0; padding-left: 20px;'>
                                <li style='margin-bottom: 8px; color: #1f2937;'>Dicas para economizar no dia a dia</li>
                                <li style='margin-bottom: 8px; color: #1f2937;'>Como organizar suas finanças</li>
                                <li style='margin-bottom: 8px; color: #1f2937;'>Ferramentas que podem ajudar</li>
                                <li style='margin-bottom: 8px; color: #1f2937;'>Passos para começar agora</li>
                            </ul>
                        </div>
                        <p>Caso o link não abra, você pode copiar este endereço no seu navegador:</p>
                        <p><a href='{$preview_url}' style='word-break: break-all; color: #0D4F4C; text-decoration: none; font-weight: 500;'>{$preview_url}</a></p>
                        
                        <p>Qualquer dúvida, é só responder este email!</p>
                    </div>
                    <div style='text-align: center; padding: 20px; color: #6b7280; font-size: 12px; background: #f9fafb; border-top: 1px solid #e5e7eb;'>
                        <p>Este e-mail foi enviado para <strong>{$preview_email}</strong></p>
                        <p><a href='" . home_url() . "' style='color: #0D4F4C; text-decoration: none;'>" . get_bloginfo('name') . "</a> - " . get_bloginfo('description') . "</p>
                        <p>Se quiser parar de receber nossos e-mails, <a href='https://saberdegrana.com.br/cancelar' style='color: #0D4F4C; text-decoration: none;'>clique aqui para cancelar sua inscrição</a>.</p>
                    </div>
                </div>
                ";
                
                echo $preview_html;
                ?>
            </div>
        </div>
    </div>
    <?php
}