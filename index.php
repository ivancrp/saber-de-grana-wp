<?php
/**
 * The main template file
 *
 * @package SaberDeGrana
 */

get_header();
?>

<main id="primary" class="site-main">
    <!-- Seção Hero -->
    <section class="hero">
        <div class="floating-elements">
            <div class="floating-element"></div>
            <div class="floating-element"></div>
            <div class="floating-element"></div>
            <div class="floating-element"></div>
        </div>
        <div class="hero-content">
            <h1 class="hero-title">
                DICAS PRÁTICAS PARA CUIDAR DO SEU<br>
                <span style="color: #ff6b35;">DINHEIRO</span>
            </h1>
            <p class="hero-subtitle">
                Aprenda a controlar suas finanças, investir com sabedoria e conquistar a liberdade financeira que você merece.
            </p>
        </div>
    </section>

    <!-- Seção Posts em Destaque -->
    <section id="featured-posts" class="py-16">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900"><?php echo esc_html(get_theme_mod('saberdegrana_featured_title', 'Destaque')); ?></h2>
                <div class="w-24 h-1 bg-primary mx-auto mt-4"></div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <?php
                $featured_posts = new WP_Query(array(
                    'post_type'      => 'post',
                    'posts_per_page' => 6,
                    'meta_key'       => 'featured_post',
                    'meta_value'     => 'yes',
                ));

                if ($featured_posts->have_posts()) :
                    while ($featured_posts->have_posts()) : $featured_posts->the_post();
                        get_template_part('template-parts/content', 'card');
                    endwhile;
                    wp_reset_postdata();
                else:
                    // Se não houver posts destacados, exibe os posts mais recentes
                    $recent_posts = new WP_Query(array(
                        'post_type'      => 'post',
                        'posts_per_page' => 6,
                    ));
                    
                    while ($recent_posts->have_posts()) : $recent_posts->the_post();
                        get_template_part('template-parts/content', 'card');
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </div>
        </div>
    </section>

    <!-- Seção Categorias -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900"><?php echo esc_html(get_theme_mod('saberdegrana_categories_title', 'Categoria')); ?></h2>
                <div class="w-24 h-1 bg-primary mx-auto mt-4"></div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php
                $categories = get_categories(array(
                    'orderby'    => 'count',
                    'order'      => 'DESC',
                    'number'     => 4,
                    'hide_empty' => true,
                ));
                foreach ($categories as $category) :
                    set_query_var('category_obj', $category);
                    get_template_part('template-parts/content', 'category-card');
                endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Seção Sobre -->
    <section class="section-sobre">
        <div class="container">
            <div class="grid">
                <div> <!-- This div will contain the text content -->
                    <h2 class="titulo-small">SABER DE GRANA</h2>
                    <h3 class="titulo-principal"><?php echo esc_html(get_theme_mod('saberdegrana_about_title', 'Sobre')); ?></h3>
                    <p class="descricao">
                        <?php echo wp_kses_post(get_theme_mod('saberdegrana_about_content', 'Postamos análises e insights sobre o mercado financeiro e a melhor maneira de você administrar a sua renda.')); ?>
                    </p>
                    <div> <!-- Container for Mission and Vision -->
                        <div class="missao-visao">
                            <h4>MISSÃO</h4>
                            <p>
                                <?php echo esc_html(get_theme_mod('saberdegrana_mission_content', 'Contribuir para a melhor das aplicações financeiras, melhorando assim, o mercado financeiro de modo geral.')); ?>
                            </p>
                        </div>
                        
                        <div class="missao-visao">
                            <h4>VISÃO</h4>
                            <p>
                                <?php echo esc_html(get_theme_mod('saberdegrana_vision_content', 'Apresentar sempre as melhores soluções e informações no mercado financeiro.')); ?>
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="imagem-container"> <!-- This div will contain the image and quote -->
                    <img 
                        src="<?php 
                            // Usar uma imagem de mão segurando dinheiro como na referência
                            $about_image = get_theme_mod('saberdegrana_about_image', get_template_directory_uri() . '/assets/images/money-hand.jpg');
                            if (!$about_image) {
                                $about_image = get_template_directory_uri() . '.\\assets\\images\\about-image.jpg';
                            }
                            echo esc_url($about_image);
                        ?>" 
                        alt="<?php echo esc_attr(get_bloginfo('name')); ?>" 
                    />
                    <div class="quote">
                        <blockquote>
                            "<?php echo esc_html(get_theme_mod('saberdegrana_about_quote', 'Planeje, poupe e prospere: suas finanças, seu futuro!')); ?>"
                        </blockquote>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Seção Newsletter -->
    <?php get_template_part('template-parts/content', 'newsletter'); ?>
    
</main>

<?php
get_footer();