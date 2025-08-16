<?php

/**

 * Custom functions for Saber de Grana theme

 *

 * @package SaberDeGrana

 */



if (!defined('ABSPATH')) {

    exit; // Exit if accessed directly

}



/**

 * Customizer additions

 */

function saberdegrana_customize_register($wp_customize) {

    // Social Media Links Section

    $wp_customize->add_section('saberdegrana_social_links', array(

        'title'    => __('Redes Sociais', 'saberdegrana'),

        'priority' => 30,

    ));

    

    // Facebook

    $wp_customize->add_setting('saberdegrana_facebook_url', array(

        'default'           => '',

        'sanitize_callback' => 'esc_url_raw',

    ));

    

    $wp_customize->add_control('saberdegrana_facebook_url', array(

        'label'    => __('URL do Facebook', 'saberdegrana'),

        'section'  => 'saberdegrana_social_links',

        'type'     => 'url',

    ));

    

    // Twitter

    $wp_customize->add_setting('saberdegrana_twitter_url', array(

        'default'           => '',

        'sanitize_callback' => 'esc_url_raw',

    ));

    

    $wp_customize->add_control('saberdegrana_twitter_url', array(

        'label'    => __('URL do Twitter', 'saberdegrana'),

        'section'  => 'saberdegrana_social_links',

        'type'     => 'url',

    ));

    

    // Instagram

    $wp_customize->add_setting('saberdegrana_instagram_url', array(

        'default'           => '',

        'sanitize_callback' => 'esc_url_raw',

    ));

    

    $wp_customize->add_control('saberdegrana_instagram_url', array(

        'label'    => __('URL do Instagram', 'saberdegrana'),

        'section'  => 'saberdegrana_social_links',

        'type'     => 'url',

    ));

    

    // Contact Information Section

    $wp_customize->add_section('saberdegrana_contact_info', array(

        'title'    => __('Informações de Contato', 'saberdegrana'),

        'priority' => 31,

    ));

    

    // Email

    $wp_customize->add_setting('saberdegrana_email', array(

        'default'           => '',

        'sanitize_callback' => 'sanitize_email',

    ));

    

    $wp_customize->add_control('saberdegrana_email', array(

        'label'    => __('Email', 'saberdegrana'),

        'section'  => 'saberdegrana_contact_info',

        'type'     => 'email',

    ));

    

    // Phone

    $wp_customize->add_setting('saberdegrana_phone', array(

        'default'           => '',

        'sanitize_callback' => 'sanitize_text_field',

    ));

    

    $wp_customize->add_control('saberdegrana_phone', array(

        'label'    => __('Telefone', 'saberdegrana'),

        'section'  => 'saberdegrana_contact_info',

        'type'     => 'text',

    ));

    

    // Address

    $wp_customize->add_setting('saberdegrana_address', array(

        'default'           => '',

        'sanitize_callback' => 'sanitize_text_field',

    ));

    

    $wp_customize->add_control('saberdegrana_address', array(

        'label'    => __('Endereço', 'saberdegrana'),

        'section'  => 'saberdegrana_contact_info',

        'type'     => 'textarea',

    ));

    

    // Homepage Sections

    $wp_customize->add_panel('saberdegrana_homepage_panel', array(

        'title'    => __('Seções da Página Inicial', 'saberdegrana'),

        'priority' => 32,

    ));

    

    // Hero Section

    $wp_customize->add_section('saberdegrana_hero_section', array(

        'title'    => __('Seção Hero', 'saberdegrana'),

        'panel'    => 'saberdegrana_homepage_panel',

        'priority' => 10,

    ));

    

    $wp_customize->add_setting('saberdegrana_hero_title', array(

        'default'           => 'DICAS PRÁTICAS PARA CUIDAR DO SEU DINHEIRO',

        'sanitize_callback' => 'sanitize_text_field',

    ));

    

    $wp_customize->add_control('saberdegrana_hero_title', array(

        'label'    => __('Título', 'saberdegrana'),

        'section'  => 'saberdegrana_hero_section',

        'type'     => 'text',

    ));

    

    $wp_customize->add_setting('saberdegrana_hero_subtitle', array(

        'default'           => 'Aprenda a controlar suas finanças, investir com sabedoria e conquistar a liberdade financeira que você merece.',

        'sanitize_callback' => 'sanitize_text_field',

    ));

    

    $wp_customize->add_control('saberdegrana_hero_subtitle', array(

        'label'    => __('Subtítulo', 'saberdegrana'),

        'section'  => 'saberdegrana_hero_section',

        'type'     => 'textarea',

    ));

    

    $wp_customize->add_setting('saberdegrana_hero_button_text', array(

        'default'           => 'COMECE AGORA',

        'sanitize_callback' => 'sanitize_text_field',

    ));

    

    $wp_customize->add_control('saberdegrana_hero_button_text', array(

        'label'    => __('Texto do Botão', 'saberdegrana'),

        'section'  => 'saberdegrana_hero_section',

        'type'     => 'text',

    ));

    

    $wp_customize->add_setting('saberdegrana_hero_button_url', array(

        'default'           => '#featured-posts',

        'sanitize_callback' => 'esc_url_raw',

    ));

    

    $wp_customize->add_control('saberdegrana_hero_button_url', array(

        'label'    => __('URL do Botão', 'saberdegrana'),

        'section'  => 'saberdegrana_hero_section',

        'type'     => 'url',

    ));

    

    $wp_customize->add_setting('saberdegrana_hero_background', array(

        'default'           => '',

        'sanitize_callback' => 'esc_url_raw',

    ));

    

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'saberdegrana_hero_background', array(

        'label'    => __('Imagem de Fundo', 'saberdegrana'),

        'section'  => 'saberdegrana_hero_section',

    )));

    

    // Featured Posts Section

    $wp_customize->add_section('saberdegrana_featured_posts_section', array(

        'title'    => __('Seção Posts em Destaque', 'saberdegrana'),

        'panel'    => 'saberdegrana_homepage_panel',

        'priority' => 20,

    ));

    

    $wp_customize->add_setting('saberdegrana_featured_title', array(

        'default'           => 'Posts em Destaque',

        'sanitize_callback' => 'sanitize_text_field',

    ));

    

    $wp_customize->add_control('saberdegrana_featured_title', array(

        'label'    => __('Título', 'saberdegrana'),

        'section'  => 'saberdegrana_featured_posts_section',

        'type'     => 'text',

    ));

    

    // Categories Section

    $wp_customize->add_section('saberdegrana_categories_section', array(

        'title'    => __('Seção Categorias', 'saberdegrana'),

        'panel'    => 'saberdegrana_homepage_panel',

        'priority' => 30,

    ));

    

    $wp_customize->add_setting('saberdegrana_categories_title', array(

        'default'           => 'Explore por Categoria',

        'sanitize_callback' => 'sanitize_text_field',

    ));

    

    $wp_customize->add_control('saberdegrana_categories_title', array(

        'label'    => __('Título', 'saberdegrana'),

        'section'  => 'saberdegrana_categories_section',

        'type'     => 'text',

    ));

    

    // About Section

    $wp_customize->add_section('saberdegrana_about_section', array(

        'title'    => __('Seção Sobre', 'saberdegrana'),

        'panel'    => 'saberdegrana_homepage_panel',

        'priority' => 40,

    ));

    

    $wp_customize->add_setting('saberdegrana_about_title', array(

        'default'           => 'Sobre',

        'sanitize_callback' => 'sanitize_text_field',

    ));

    

    $wp_customize->add_control('saberdegrana_about_title', array(

        'label'    => __('Título', 'saberdegrana'),

        'section'  => 'saberdegrana_about_section',

        'type'     => 'text',

    ));

    

    $wp_customize->add_setting('saberdegrana_about_content', array(

        'default'           => 'Postamos análises e insights sobre o mercado financeiro e a melhor maneira de você administrar a sua renda.',

        'sanitize_callback' => 'wp_kses_post',

    ));

    

    $wp_customize->add_control('saberdegrana_about_content', array(

        'label'    => __('Conteúdo', 'saberdegrana'),

        'section'  => 'saberdegrana_about_section',

        'type'     => 'textarea',

    ));

    

    $wp_customize->add_setting('saberdegrana_mission_title', array(

        'default'           => 'MISSÃO',

        'sanitize_callback' => 'sanitize_text_field',

    ));

    

    $wp_customize->add_control('saberdegrana_mission_title', array(

        'label'    => __('Título da Missão', 'saberdegrana'),

        'section'  => 'saberdegrana_about_section',

        'type'     => 'text',

    ));

    

    $wp_customize->add_setting('saberdegrana_mission_content', array(

        'default'           => 'Contribuir para a melhor das aplicações financeiras, melhorando assim, o mercado financeiro de modo geral.',

        'sanitize_callback' => 'sanitize_text_field',

    ));

    

    $wp_customize->add_control('saberdegrana_mission_content', array(

        'label'    => __('Conteúdo da Missão', 'saberdegrana'),

        'section'  => 'saberdegrana_about_section',

        'type'     => 'textarea',

    ));

    

    $wp_customize->add_setting('saberdegrana_vision_title', array(

        'default'           => 'VISÃO',

        'sanitize_callback' => 'sanitize_text_field',

    ));

    

    $wp_customize->add_control('saberdegrana_vision_title', array(

        'label'    => __('Título da Visão', 'saberdegrana'),

        'section'  => 'saberdegrana_about_section',

        'type'     => 'text',

    ));

    

    $wp_customize->add_setting('saberdegrana_vision_content', array(

        'default'           => 'Apresentar sempre as melhores soluções e informações no mercado financeiro.',

        'sanitize_callback' => 'sanitize_text_field',

    ));

    

    $wp_customize->add_control('saberdegrana_vision_content', array(

        'label'    => __('Conteúdo da Visão', 'saberdegrana'),

        'section'  => 'saberdegrana_about_section',

        'type'     => 'textarea',

    ));

    

    $wp_customize->add_setting('saberdegrana_about_image', array(

        'default'           => '',

        'sanitize_callback' => 'esc_url_raw',

    ));

    

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'saberdegrana_about_image', array(

        'label'    => __('Imagem', 'saberdegrana'),

        'section'  => 'saberdegrana_about_section',

    )));

    

    $wp_customize->add_setting('saberdegrana_about_quote', array(

        'default'           => 'Planeje, poupe e prospere: suas finanças, seu futuro!',

        'sanitize_callback' => 'sanitize_text_field',

    ));

    

    $wp_customize->add_control('saberdegrana_about_quote', array(

        'label'    => __('Citação', 'saberdegrana'),

        'section'  => 'saberdegrana_about_section',

        'type'     => 'text',

    ));

    

    // Newsletter Section

    $wp_customize->add_section('saberdegrana_newsletter_section', array(

        'title'    => __('Seção Newsletter', 'saberdegrana'),

        'panel'    => 'saberdegrana_homepage_panel',

        'priority' => 50,

    ));

    

    $wp_customize->add_setting('saberdegrana_newsletter_title', array(

        'default'           => 'Assine nossa Newsletter',

        'sanitize_callback' => 'sanitize_text_field',

    ));

    

      $wp_customize->add_control('saberdegrana_newsletter_title', array(

        'label'    => __('Título', 'saberdegrana'),

        'section'  => 'saberdegrana_newsletter_section',

        'type'     => 'text',

    ));

    

    $wp_customize->add_setting('saberdegrana_newsletter_content', array(

        'default'           => 'Receba dicas semanais sobre finanças pessoais e oportunidades de investimento diretamente no seu e-mail.',

        'sanitize_callback' => 'sanitize_text_field',

    ));

    

    $wp_customize->add_control('saberdegrana_newsletter_content', array(

        'label'    => __('Conteúdo', 'saberdegrana'),

        'section'  => 'saberdegrana_newsletter_section',

        'type'     => 'textarea',

    ));

    

    $wp_customize->add_setting('saberdegrana_newsletter_benefit1', array(

        'default'           => 'Conteúdo exclusivo',

        'sanitize_callback' => 'sanitize_text_field',

    ));

    

    $wp_customize->add_control('saberdegrana_newsletter_benefit1', array(

        'label'    => __('Benefício 1', 'saberdegrana'),

        'section'  => 'saberdegrana_newsletter_section',

        'type'     => 'text',

    ));

    

    $wp_customize->add_setting('saberdegrana_newsletter_benefit2', array(

        'default'           => 'Dicas práticas semanais',

        'sanitize_callback' => 'sanitize_text_field',

    ));

    

    $wp_customize->add_control('saberdegrana_newsletter_benefit2', array(

        'label'    => __('Benefício 2', 'saberdegrana'),

        'section'  => 'saberdegrana_newsletter_section',

        'type'     => 'text',

    ));

    

    $wp_customize->add_setting('saberdegrana_newsletter_benefit3', array(

        'default'           => 'Alertas de oportunidades',

        'sanitize_callback' => 'sanitize_text_field',

    ));

    

    $wp_customize->add_control('saberdegrana_newsletter_benefit3', array(

        'label'    => __('Benefício 3', 'saberdegrana'),

        'section'  => 'saberdegrana_newsletter_section',

        'type'     => 'text',

    ));

    

    $wp_customize->add_setting('saberdegrana_newsletter_form_title', array(

        'default'           => 'Cadastre-se gratuitamente',

        'sanitize_callback' => 'sanitize_text_field',

    ));

    

    $wp_customize->add_control('saberdegrana_newsletter_form_title', array(

        'label'    => __('Título do Formulário', 'saberdegrana'),

        'section'  => 'saberdegrana_newsletter_section',

        'type'     => 'text',

    ));

    

    $wp_customize->add_setting('saberdegrana_newsletter_form_shortcode', array(

        'default'           => '',

        'sanitize_callback' => 'sanitize_text_field',

    ));

    

    $wp_customize->add_control('saberdegrana_newsletter_form_shortcode', array(

        'label'       => __('Shortcode do Formulário', 'saberdegrana'),

        'description' => __('Insira o shortcode de um plugin de formulário como Contact Form 7, Gravity Forms, etc.', 'saberdegrana'),

        'section'     => 'saberdegrana_newsletter_section',

        'type'        => 'text',

    ));

}

add_action('customize_register', 'saberdegrana_customize_register');



/**

 * Add category image field to category taxonomy

 */

function saberdegrana_category_add_image_field() {

    ?>

    <div class="form-field term-group">

        <label for="category_image"><?php _e('Imagem da Categoria', 'saberdegrana'); ?></label>

        <input type="hidden" id="category_image" name="category_image" class="custom_media_url" value="">

        <div id="category-image-wrapper"></div>

        <p>

            <input type="button" class="button button-secondary ct_tax_media_button" id="ct_tax_media_button" name="ct_tax_media_button" value="<?php _e('Adicionar Imagem', 'saberdegrana'); ?>" />

            <input type="button" class="button button-secondary ct_tax_media_remove" id="ct_tax_media_remove" name="ct_tax_media_remove" value="<?php _e('Remover Imagem', 'saberdegrana'); ?>" />

        </p>

    </div>

    <?php

}

add_action('category_add_form_fields', 'saberdegrana_category_add_image_field', 10, 2);



/**

 * Edit category image field

 */

function saberdegrana_category_edit_image_field($term) {

    $category_image_id = get_term_meta($term->term_id, 'category_image', true);

    ?>

    <tr class="form-field term-group-wrap">

        <th scope="row">

            <label for="category_image"><?php _e('Imagem da Categoria', 'saberdegrana'); ?></label>

        </th>

        <td>

            <input type="hidden" id="category_image" name="category_image" class="custom_media_url" value="<?php echo $category_image_id; ?>">

            <div id="category-image-wrapper">

                <?php if ($category_image_id) { ?>

                    <?php echo wp_get_attachment_image($category_image_id, 'thumbnail'); ?>

                <?php } ?>

            </div>

            <p>

                <input type="button" class="button button-secondary ct_tax_media_button" id="ct_tax_media_button" name="ct_tax_media_button" value="<?php _e('Adicionar Imagem', 'saberdegrana'); ?>" />

                <input type="button" class="button button-secondary ct_tax_media_remove" id="ct_tax_media_remove" name="ct_tax_media_remove" value="<?php _e('Remover Imagem', 'saberdegrana'); ?>" />

            </p>

        </td>

    </tr>

    <?php

}

add_action('category_edit_form_fields', 'saberdegrana_category_edit_image_field', 10, 2);



/**

 * Save category image field

 */

function saberdegrana_save_category_image($term_id) {

    if (isset($_POST['category_image'])) {

        $category_image = $_POST['category_image'];

        update_term_meta($term_id, 'category_image', $category_image);

    }

}

add_action('edited_category', 'saberdegrana_save_category_image', 10, 2);

add_action('create_category', 'saberdegrana_save_category_image', 10, 2);



/**

 * Add scripts for category image uploader

 */

function saberdegrana_admin_scripts() {

    global $pagenow;

    

    if (($pagenow == 'term.php' || $pagenow == 'edit-tags.php') && isset($_GET['taxonomy']) && $_GET['taxonomy'] == 'category') {

        wp_enqueue_media();

        wp_register_script('saberdegrana-admin-script', get_template_directory_uri() . '/assets/js/admin.js', array('jquery'), '1.0.0', true);

        wp_enqueue_script('saberdegrana-admin-script');

    }

}

add_action('admin_enqueue_scripts', 'saberdegrana_admin_scripts');



/**

 * Add Meta box for featured posts

 */

function saberdegrana_add_featured_meta_box() {

    add_meta_box(

        'saberdegrana_featured_post',

        __('Post em Destaque', 'saberdegrana'),

        'saberdegrana_featured_meta_box_callback',

        'post',

        'side',

        'high'

    );

}

add_action('add_meta_boxes', 'saberdegrana_add_featured_meta_box');



/**

 * Featured post meta box callback

 */

function saberdegrana_featured_meta_box_callback($post) {

    wp_nonce_field('saberdegrana_featured_post', 'saberdegrana_featured_post_nonce');

    

    $featured = get_post_meta($post->ID, 'featured_post', true);

    ?>

    <p>

        <input type="checkbox" id="featured_post" name="featured_post" value="yes" <?php checked($featured, 'yes'); ?> />

        <label for="featured_post"><?php _e('Marcar como destaque na página inicial', 'saberdegrana'); ?></label>

    </p>

    <?php

}



/**

 * Save featured post meta

 */

function saberdegrana_save_featured_meta($post_id) {

    if (!isset($_POST['saberdegrana_featured_post_nonce'])) {

        return;

    }

    

    if (!wp_verify_nonce($_POST['saberdegrana_featured_post_nonce'], 'saberdegrana_featured_post')) {

        return;

    }

    

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {

        return;

    }

    

    if (!current_user_can('edit_post', $post_id)) {

        return;

    }

    

    $featured = isset($_POST['featured_post']) ? 'yes' : 'no';

    update_post_meta($post_id, 'featured_post', $featured);

}

add_action('save_post', 'saberdegrana_save_featured_meta');



/**

 * Register custom widget areas

 */

function saberdegrana_custom_widgets_init() {

    // Home Page Sidebar

    register_sidebar(array(

        'name'          => esc_html__('Home Sidebar', 'saberdegrana'),

        'id'            => 'home-sidebar',

        'description'   => esc_html__('Adicione widgets aqui para aparecer na barra lateral da página inicial.', 'saberdegrana'),

        'before_widget' => '<section id="%1$s" class="widget %2$s mb-8">',

        'after_widget'  => '</section>',

        'before_title'  => '<h3 class="widget-title text-lg font-semibold text-gray-900 mb-4">',

        'after_title'   => '</h3>',

    ));

    

    // Post Sidebar

    register_sidebar(array(

        'name'          => esc_html__('Post Sidebar', 'saberdegrana'),

        'id'            => 'post-sidebar',

        'description'   => esc_html__('Adicione widgets aqui para aparecer na barra lateral dos posts.', 'saberdegrana'),

        'before_widget' => '<section id="%1$s" class="widget %2$s mb-8">',

        'after_widget'  => '</section>',

        'before_title'  => '<h3 class="widget-title text-lg font-semibold text-gray-900 mb-4">',

        'after_title'   => '</h3>',

    ));

    

    // Footer Widgets

    register_sidebar(array(

        'name'          => esc_html__('Footer Widgets', 'saberdegrana'),

        'id'            => 'footer-widgets',

        'description'   => esc_html__('Adicione widgets aqui para aparecer no rodapé.', 'saberdegrana'),

        'before_widget' => '<div id="%1$s" class="widget %2$s">',

        'after_widget'  => '</div>',

        'before_title'  => '<h4 class="widget-title text-lg font-semibold text-white mb-4">',

        'after_title'   => '</h4>',

    ));

}

add_action('widgets_init', 'saberdegrana_custom_widgets_init');



/**

 * Add custom body classes

 */

function saberdegrana_body_classes($classes) {

    // Add a class for the home page

    if (is_front_page()) {

        $classes[] = 'home-page';

    }

    

    // Add a class for the post pages

    if (is_single() && 'post' === get_post_type()) {

        $classes[] = 'single-post-page';

    }

    

    return $classes;

}

add_filter('body_class', 'saberdegrana_body_classes');



/**

 * Modify the "Read More" link text

 */

function saberdegrana_modify_read_more_link() {

    return '<a class="more-link text-primary hover:text-primary-dark font-medium" href="' . get_permalink() . '">' . __('Continue lendo', 'saberdegrana') . ' <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 inline-block ml-1"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg></a>';

}

add_filter('the_content_more_link', 'saberdegrana_modify_read_more_link');



/**

 * Custom excerpt length

 */

function saberdegrana_custom_excerpt_length($length) {

    return 20;

}

add_filter('excerpt_length', 'saberdegrana_custom_excerpt_length', 999);



/**

 * Custom excerpt more

 */

function saberdegrana_excerpt_more($more) {

    return '...';

}

add_filter('excerpt_more', 'saberdegrana_excerpt_more');



/**

 * Add image sizes

 */

function saberdegrana_add_image_sizes() {

    add_image_size('featured-large', 1200, 600, true);

    add_image_size('featured-medium', 800, 500, true);

    add_image_size('card-thumb', 600, 400, true);

    add_image_size('author-thumb', 100, 100, true);

}

add_action('after_setup_theme', 'saberdegrana_add_image_sizes');



/**

 * Add custom image sizes to media uploader

 */

function saberdegrana_custom_image_sizes($sizes) {

    return array_merge($sizes, array(

        'featured-large' => __('Destaque Grande', 'saberdegrana'),

        'featured-medium' => __('Destaque Médio', 'saberdegrana'),

        'card-thumb' => __('Thumbnail de Card', 'saberdegrana'),

    ));

}

add_filter('image_size_names_choose', 'saberdegrana_custom_image_sizes');



/**

 * Admin Notice after theme activation

 */

function saberdegrana_admin_notice() {

    global $pagenow;

    if (is_admin() && 'themes.php' == $pagenow && isset($_GET['activated'])) {

        ?>

        <div class="notice notice-success is-dismissible">

            <p><?php _e('Obrigado por escolher o tema Saber de Grana! Para começar a configuração, visite a <a href="customize.php">página de personalização</a>.', 'saberdegrana'); ?></p>

        </div>

        <?php

    }

}

add_action('admin_notices', 'saberdegrana_admin_notice');



/**

 * Format the post date

 */

function saberdegrana_format_date($date) {

    return date_i18n(get_option('date_format'), strtotime($date));

}



/**

 * Process AJAX newsletter subscription

 */

function saberdegrana_process_newsletter() {

    check_ajax_referer('newsletter_nonce', 'nonce');

    

    $name = sanitize_text_field($_POST['name']);

    $email = sanitize_email($_POST['email']);

    

    if (empty($name) || empty($email)) {

        wp_send_json_error(array('message' => __('Por favor, preencha todos os campos.', 'saberdegrana')));

    }

    

    if (!is_email($email)) {

        wp_send_json_error(array('message' => __('Por favor, insira um email válido.', 'saberdegrana')));

    }

    

    // Here you would typically add the subscriber to your mailing list service

    // This is just a placeholder - you'd need to implement the actual subscription logic

    

    // For demonstration, we'll just return success

    wp_send_json_success(array('message' => __('Obrigado por se inscrever! Em breve você receberá nossos conteúdos.', 'saberdegrana')));

}

add_action('wp_ajax_newsletter_subscribe', 'saberdegrana_process_newsletter');

add_action('wp_ajax_nopriv_newsletter_subscribe', 'saberdegrana_process_newsletter');



/**

 * Callback personalizado para exibição de comentários

 *

 * @param object $comment O objeto de comentário

 * @param array $args Os argumentos

 * @param int $depth A profundidade do comentário

 */

function saberdegrana_comment_callback($comment, $args, $depth) {

    $GLOBALS['comment'] = $comment;

    $comment_class = empty($args['has_children']) ? '' : 'parent';

    $tag = 'li';

    ?>

    <<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class($comment_class); ?>>

        <article id="div-comment-<?php comment_ID(); ?>" class="comment-body bg-white p-6 rounded-lg shadow-sm">

            <footer class="comment-meta mb-4">

                <div class="flex items-start">

                    <div class="comment-author vcard mr-4">

                        <?php

                        if (0 != $args['avatar_size']) {

                            echo get_avatar($comment, $args['avatar_size'], '', '', array('class' => 'rounded-full'));

                        }

                        ?>

                    </div>

                    

                    <div class="flex-1">

                        <div class="comment-author-name font-semibold text-gray-900">

                            <?php comment_author_link(); ?>

                        </div>

                        

                        <div class="comment-metadata text-sm text-gray-500 mt-1">

                            <time datetime="<?php comment_time('c'); ?>">

                                <?php

                                printf(

                                    _x('%1$s às %2$s', '1: date, 2: time', 'saberdegrana'),

                                    get_comment_date(),

                                    get_comment_time()

                                );

                                ?>

                            </time>

                            

                            <?php

                            edit_comment_link(__('Editar', 'saberdegrana'), ' <span class="edit-link ml-2 text-primary hover:underline">', '</span>');

                            ?>

                        </div>

                    </div>

                </div>

            </footer>

            

            <div class="comment-content prose prose-sm">

                <?php if ('0' == $comment->comment_approved) : ?>

                    <p class="comment-awaiting-moderation italic text-yellow-600 mb-4">

                        <?php _e('Seu comentário está aguardando moderação.', 'saberdegrana'); ?>

                    </p>

                <?php endif; ?>

                

                <?php comment_text(); ?>

            </div>

            

            <div class="reply mt-4 text-sm">

                <?php

                comment_reply_link(

                    array_merge(

                        $args,

                        array(

                            'add_below' => 'div-comment',

                            'depth'     => $depth,

                            'max_depth' => $args['max_depth'],

                            'before'    => '<span class="text-primary hover:underline">',

                            'after'     => '</span>'

                        )

                    )

                );

                ?>

            </div>

        </article>

    <?php

}

// Shortcode: Calculadora de Ponto de Equilíbrio
function saberdegrana_ponto_equilibrio_shortcode() {
    ob_start();
    ?>
    <section class="max-w-3xl mx-auto bg-white rounded-lg shadow-lg p-8 my-8">
        <h2 class="text-2xl font-bold text-primary mb-6 text-center">Calculadora de Ponto de Equilíbrio</h2>
        <form id="ponto-equilibrio-form" class="space-y-4">
            <div>
                <label for="peq-cft" class="form-label">Custo Fixo Total (CFT) – R$ <span class="text-red-600">*</span></label>
                <input type="text" id="peq-cft" class="form-input" placeholder="Ex: 15.000,00" required>
            </div>
            <div>
                <label for="peq-cvu" class="form-label">Custo Variável Unitário (CVU) – R$ <span class="text-red-600">*</span></label>
                <input type="text" id="peq-cvu" class="form-input" placeholder="Ex: 12,00" required>
            </div>
            <div>
                <label for="peq-pvu" class="form-label">Preço de Venda Unitário (PVU) – R$ <span class="text-red-600">*</span></label>
                <input type="text" id="peq-pvu" class="form-input" placeholder="Ex: 30,00" required>
            </div>
            <div>
                <label for="peq-vendas" class="form-label">Previsão de Vendas (opcional)</label>
                <input type="text" id="peq-vendas" class="form-input" placeholder="Ex: 1000">
            </div>
            <div>
                <label for="peq-custoMensal" class="form-label">Custo Fixo Mensal (opcional)</label>
                <input type="text" id="peq-custoMensal" class="form-input" placeholder="Ex: 5.000,00">
            </div>
            <div class="flex gap-4 mt-4">
                <button type="button" id="peq-calcular" class="btn btn-primary w-full">Calcular Ponto de Equilíbrio</button>
                <button type="button" id="peq-limpar" class="btn btn-secondary w-full">Limpar Campos</button>
            </div>
        </form>
        <div id="peq-resultado" class="result mt-8 p-6 bg-secondary rounded-lg shadow-md hidden">
            <h3 class="text-xl font-semibold text-primary mb-4">Resultados</h3>
            <p><strong>Margem de Contribuição Unitária (MCU):</strong> R$ <span id="peq-mcu"></span></p>
            <p><strong>Ponto de Equilíbrio em Quantidade (PEQ):</strong> <span id="peq-peq"></span> unidades</p>
            <p><strong>Ponto de Equilíbrio em Faturamento (PEF):</strong> R$ <span id="peq-pef"></span></p>
        </div>
    </section>
    <?php
    return ob_get_clean();
}
add_shortcode('ponto_equilibrio', 'saberdegrana_ponto_equilibrio_shortcode');