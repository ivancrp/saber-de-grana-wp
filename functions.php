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
 * Cria arquivos de imagem padrão se não existirem
 */
function saberdegrana_create_default_images() {
    $images_dir = get_template_directory() . '/assets/images/';
    
    // Verifica se o diretório existe, se não, cria
    if (!file_exists($images_dir)) {
        wp_mkdir_p($images_dir);
    }
    
    // Cria a imagem about-image.jpg se não existir ou for muito pequena
    $about_image_path = $images_dir . 'about-image.jpg';
    if (!file_exists($about_image_path) || filesize($about_image_path) < 1000) {
        $about_image_data = 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQEAYABgAAD//gA7Q1JFQVRPUjogZ2QtanBlZyB2MS4wICh1c2luZyBJSkcgSlBFRyB2ODApLCBxdWFsaXR5ID0gOTAK/9sAQwADAgIDAgIDAwMDBAMDBAUIBQUEBAUKBwcGCAwKDAwLCgsLDQ4SEA0OEQ4LCxAWEBETFBUVFQwPFxgWFBgSFBUU/9sAQwEDBAQFBAUJBQUJFA0LDRQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQU/8AAEQgAZABkAwEiAAIRAQMRAf/EAB8AAAEFAQEBAQEBAAAAAAAAAAABAgMEBQYHCAkKC//EALUQAAIBAwMCBAMFBQQEAAABfQECAwAEEQUSITFBBhNRYQcicRQygZGhCCNCscEVUtHwJDNicoIJChYXGBkaJSYnKCkqNDU2Nzg5OkNERUZHSElKU1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6g4SFhoeIiYqSk5SVlpeYmZqio6Slpqeoqaqys7S1tre4ubrCw8TFxsfIycrS09TV1tfY2drh4uPk5ebn6Onq8fLz9PX29/j5+v/EAB8BAAMBAQEBAQEBAQEAAAAAAAABAgMEBQYHCAkKC//EALURAAIBAgQEAwQHBQQEAAECdwABAgMRBAUhMQYSQVEHYXETIjKBCBRCkaGxwQkjM1LwFWJy0QoWJDThJfEXGBkaJicoKSo1Njc4OTpDREVGR0hJSlNUVVZXWFlaY2RlZmdoaWpzdHV2d3h5eoKDhIWGh4iJipKTlJWWl5iZmqKjpKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uLj5OXm5+jp6vLz9PX29/j5+v/aAAwDAQACEQMRAD8A+pqKKK+aP1QKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooA//9k=';
        $about_image_data = str_replace('data:image/jpeg;base64,', '', $about_image_data);
        $about_image_data = base64_decode($about_image_data);
        file_put_contents($about_image_path, $about_image_data);
    }
    
    // Cria a imagem money-hand.jpg para a seção Sobre
    $money_hand_path = $images_dir . 'money-hand.jpg';
    if (!file_exists($money_hand_path) || filesize($money_hand_path) < 1000) {
        // URL de uma imagem de mão segurando dinheiro (base64)
        $money_hand_data = 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQEAYABgAAD/2wBDAAoHBwkHBgoJCAkLCwoMDxkQDw4ODx4WFxIZJCAmJSMgIyIoLTkwKCo2KyIjMkQyNjs9QEBAJjBGS0U+Sjk/QD3/2wBDAQsLCw8NDx0QEB09KSMpPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT3/wAARCADWANYDASIAAhEBAxEB/8QAHwAAAQUBAQEBAQEAAAAAAAAAAAECAwQFBgcICQoL/8QAtRAAAgEDAwIEAwUFBAQAAAF9AQIDAAQRBRIhMUEGE1FhByJxFDKBkaEII0KxwRVS0fAkM2JyggkKFhcYGRolJicoKSo0NTY3ODk6Q0RFRkdISUpTVFVWV1hZWmNkZWZnaGlqc3R1dnd4eXqDhIWGh4iJipKTlJWWl5iZmqKjpKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uLj5OXm5+jp6vLz9PX29/j5+v/EAB8BAAMBAQEBAQEBAQEAAAAAAAABAgMEBQYHCAkKC//EALURAAIBAgQEAwQHBQQEAAECdwABAgMRBAUhMQYSQVEHYXETIjKBCBRCkaGxwQkjM1LwFWJy0QoWJDThJfEXGBkaJicoKSo1Njc4OTpDREVGR0hJSlNUVVZXWFlaY2RlZmdoaWpzdHV2d3h5eoKDhIWGh4iJipKTlJWWl5iZmqKjpKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uLj5OXm5+jp6vLz9PX29/j5+v/aAAwDAQACEQMRAD8A9looor0DnCiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigD//Z';
        $money_hand_data = str_replace('data:image/jpeg;base64,', '', $money_hand_data);
        $money_hand_data = base64_decode($money_hand_data);
        file_put_contents($money_hand_path, $money_hand_data);
    }
    
    // Cria a imagem hero-bg.jpg se não existir ou for muito pequena
    $hero_image_path = $images_dir . 'hero-bg.jpg';
    if (!file_exists($hero_image_path) || filesize($hero_image_path) < 1000) {
        $hero_image_data = 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQEAYABgAAD//gA7Q1JFQVRPUjogZ2QtanBlZyB2MS4wICh1c2luZyBJSkcgSlBFRyB2ODApLCBxdWFsaXR5ID0gOTAK/9sAQwADAgIDAgIDAwMDBAMDBAUIBQUEBAUKBwcGCAwKDAwLCgsLDQ4SEA0OEQ4LCxAWEBETFBUVFQwPFxgWFBgSFBUU/9sAQwEDBAQFBAUJBQUJFA0LDRQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQU/8AAEQgAZABkAwEiAAIRAQMRAf/EAB8AAAEFAQEBAQEBAAAAAAAAAAABAgMEBQYHCAkKC//EALUQAAIBAwMCBAMFBQQEAAABfQECAwAEEQUSITFBBhNRYQcicRQygZGhCCNCscEVUtHwJDNicoIJChYXGBkaJSYnKCkqNDU2Nzg5OkNERUZHSElKU1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6g4SFhoeIiYqSk5SVlpeYmZqio6Slpqeoqaqys7S1tre4ubrCw8TFxsfIycrS09TV1tfY2drh4uPk5ebn6Onq8fLz9PX29/j5+v/EAB8BAAMBAQEBAQEBAQEAAAAAAAABAgMEBQYHCAkKC//EALURAAIBAgQEAwQHBQQEAAECdwABAgMRBAUhMQYSQVEHYXETIjKBCBRCkaGxwQkjM1LwFWJy0QoWJDThJfEXGBkaJicoKSo1Njc4OTpDREVGR0hJSlNUVVZXWFlaY2RlZmdoaWpzdHV2d3h5eoKDhIWGh4iJipKTlJWWl5iZmqKjpKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uLj5OXm5+jp6vLz9PX29/j5+v/aAAwDAQACEQMRAD8A+paKKK+aP1QKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooA//9k=';
        $hero_image_data = str_replace('data:image/jpeg;base64,', '', $hero_image_data);
        $hero_image_data = base64_decode($hero_image_data);
        file_put_contents($hero_image_path, $hero_image_data);
    }
    
    // Cria a imagem default-category.jpg se não existir ou for muito pequena
    $category_image_path = $images_dir . 'default-category.jpg';
    if (!file_exists($category_image_path) || filesize($category_image_path) < 1000) {
        $category_image_data = 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQEAYABgAAD//gA7Q1JFQVRPUjogZ2QtanBlZyB2MS4wICh1c2luZyBJSkcgSlBFRyB2ODApLCBxdWFsaXR5ID0gOTAK/9sAQwADAgIDAgIDAwMDBAMDBAUIBQUEBAUKBwcGCAwKDAwLCgsLDQ4SEA0OEQ4LCxAWEBETFBUVFQwPFxgWFBgSFBUU/9sAQwEDBAQFBAUJBQUJFA0LDRQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQU/8AAEQgAZABkAwEiAAIRAQMRAf/EAB8AAAEFAQEBAQEBAAAAAAAAAAABAgMEBQYHCAkKC//EALUQAAIBAwMCBAMFBQQEAAABfQECAwAEEQUSITFBBhNRYQcicRQygZGhCCNCscEVUtHwJDNicoIJChYXGBkaJSYnKCkqNDU2Nzg5OkNERUZHSElKU1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6g4SFhoeIiYqSk5SVlpeYmZqio6Slpqeoqaqys7S1tre4ubrCw8TFxsfIycrS09TV1tfY2drh4uPk5ebn6Onq8fLz9PX29/j5+v/EAB8BAAMBAQEBAQEBAQEAAAAAAAABAgMEBQYHCAkKC//EALURAAIBAgQEAwQHBQQEAAECdwABAgMRBAUhMQYSQVEHYXETIjKBCBRCkaGxwQkjM1LwFWJy0QoWJDThJfEXGBkaJicoKSo1Njc4OTpDREVGR0hJSlNUVVZXWFlaY2RlZmdoaWpzdHV2d3h5eoKDhIWGh4iJipKTlJWWl5iZmqKjpKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uLj5OXm5+jp6vLz9PX29/j5+v/aAAwDAQACEQMRAD8A+pqKKK+aP1QKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooA//9k=';
        $category_image_data = str_replace('data:image/jpeg;base64,', '', $category_image_data);
        $category_image_data = base64_decode($category_image_data);
        file_put_contents($category_image_path, $category_image_data);
    }
}

// Executa a função na inicialização do tema e também quando o tema é ativado
add_action('after_setup_theme', 'saberdegrana_create_default_images');
add_action('after_switch_theme', 'saberdegrana_create_default_images');

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