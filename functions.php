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
    // Enqueue Google Fonts
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Source+Serif+Pro:wght@400;600;700&display=swap', array(), null);
    
    // Enqueue main stylesheet (theme style.css) com prioridade mais baixa
    wp_enqueue_style('saberdegrana-style', get_stylesheet_uri(), array(), SABERDEGRANA_VERSION);
    
    // Enqueue main CSS com prioridade mais alta para sobrescrever style.css
    wp_enqueue_style('saberdegrana-main', SABERDEGRANA_URI . '/assets/css/main.css', array('saberdegrana-style'), SABERDEGRANA_VERSION);
    
    // Enqueue jQuery
    wp_enqueue_script('jquery');
    
    // Enqueue custom scripts
    wp_enqueue_script('saberdegrana-navigation', SABERDEGRANA_URI . '/assets/js/main.js', array('jquery'), SABERDEGRANA_VERSION, true);
    
    // Localize script
    wp_localize_script('saberdegrana-navigation', 'saberdegranaData', array(
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'homeUrl' => home_url(),
        'themeUri' => SABERDEGRANA_URI,
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
 * Obtém a URL da imagem da categoria
 * 
 * @param int $category_id ID da categoria
 * @return string URL da imagem ou vazio se não encontrada
 */
function saberdegrana_get_category_image_url($category_id) {
    // Primeiro tenta obter do term_meta (padrão para plugins de gerenciamento de categorias)
    $thumbnail_id = get_term_meta($category_id, 'thumbnail_id', true);
    
    // Se não encontrou, tenta outros campos comuns
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
    
    // Caso não encontre, retorna a imagem padrão
    return get_template_directory_uri() . '/assets/images/default-category.jpg';
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