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
    <section class="relative bg-gradient-to-r from-primary to-primary-dark pt-24 pb-16 md:pt-32 md:pb-24">
        <div class="absolute inset-0 bg-[url('<?php echo esc_url(get_theme_mod('saberdegrana_hero_background', get_template_directory_uri() . '/assets/images/hero-bg.jpg')); ?>')] bg-cover bg-center opacity-20 mix-blend-overlay"></div>
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="max-w-3xl mx-auto text-center">
                <h1 class="text-3xl md:text-5xl font-bold text-white mb-6 leading-tight">
                    <?php echo esc_html(get_theme_mod('saberdegrana_hero_title', 'DICAS PRÁTICAS PARA CUIDAR DO SEU DINHEIRO')); ?>
                </h1>
                <p class="text-lg md:text-xl text-white/90 mb-8">
                    <?php echo esc_html(get_theme_mod('saberdegrana_hero_subtitle', 'Aprenda a controlar suas finanças, investir com sabedoria e conquistar a liberdade financeira que você merece.')); ?>
                </p>
                <a href="<?php echo esc_url(get_theme_mod('saberdegrana_hero_button_url', '#featured-posts')); ?>" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-primary bg-secondary hover:bg-secondary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary">
                    <?php echo esc_html(get_theme_mod('saberdegrana_hero_button_text', 'COMECE AGORA')); ?>
                </a>
            </div>
        </div>
        
        <div class="absolute bottom-0 left-0 right-0 h-16 bg-gradient-to-t from-background to-transparent"></div>
    </section>

    <!-- Seção Posts em Destaque -->
    <section id="featured-posts" class="py-16">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900"><?php echo esc_html(get_theme_mod('saberdegrana_featured_title', 'Destaque')); ?></h2>
                <div class="w-24 h-1 bg-primary mx-auto mt-4"></div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php
                $featured_posts = new WP_Query(array(
                    'post_type'      => 'post',
                    'posts_per_page' => 6,
                    'meta_key'       => 'featured_post',
                    'meta_value'     => 'yes',
                ));

                if ($featured_posts->have_posts()) :
                    while ($featured_posts->have_posts()) : $featured_posts->the_post();
                        echo '<div class="card-wrapper">';
                        get_template_part('template-parts/content', 'card');
                        echo '</div>';
                    endwhile;
                    wp_reset_postdata();
                else:
                    // Se não houver posts destacados, exibe os posts mais recentes
                    $recent_posts = new WP_Query(array(
                        'post_type'      => 'post',
                        'posts_per_page' => 6,
                    ));
                    
                    while ($recent_posts->have_posts()) : $recent_posts->the_post();
                        echo '<div class="card-wrapper">';
                        get_template_part('template-parts/content', 'card');
                        echo '</div>';
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
                    $image_url = saberdegrana_get_category_image_url($category->term_id);
                ?>
                    <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" class="block category-card">
                        <div class="category-card__header" style="background-image: url('<?php echo esc_url($image_url); ?>'); background-size: cover; background-position: center;">
                            <div class="absolute inset-0 bg-primary bg-opacity-60"></div>
                            <h3 class="category-card__title"><?php echo esc_html($category->name); ?></h3>
                        </div>
                        <div class="category-card__content">
                            <p class="category-card__count"><?php echo esc_html($category->count); ?> posts</p>
                            <p class="category-card__description"><?php echo esc_html(wp_trim_words($category->description, 15, '...')); ?></p>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Seção Sobre -->
    <section class="py-16 bg-background about-section">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
                <div class="about-text">
                    <span class="accent-text"><?php echo esc_html(get_bloginfo('name')); ?></span>
                    <h2 class="about-title"><?php echo esc_html(get_theme_mod('saberdegrana_about_title', 'Sobre')); ?></h2>
                    
                    <div class="about-description">
                        <?php echo wp_kses_post(get_theme_mod('saberdegrana_about_content', 'Postamos análises e insights sobre o mercado financeiro e a melhor maneira de você administrar a sua renda.')); ?>
                    </div>
                    
                    <div class="about-sections">
                        <div class="about-mission">
                            <h3>MISSÃO</h3>
                            <p>
                                <?php echo esc_html(get_theme_mod('saberdegrana_mission_content', 'Contribuir para a melhor das aplicações financeiras, melhorando assim, o mercado financeiro de modo geral.')); ?>
                            </p>
                        </div>
                        
                        <div class="about-vision">
                            <h3>VISÃO</h3>
                            <p>
                                <?php echo esc_html(get_theme_mod('saberdegrana_vision_content', 'Apresentar sempre as melhores soluções e informações no mercado financeiro.')); ?>
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="about-image-container">
                    <div class="about-image rounded-lg relative">
                        <?php 
                        // Usar uma imagem de mão segurando dinheiro como na referência
                        $about_image = get_theme_mod('saberdegrana_about_image', get_template_directory_uri() . '/assets/images/money-hand.jpg');
                        if (!$about_image) {
                            $about_image = get_template_directory_uri() . '/assets/images/about-image.jpg';
                        }
                        ?>
                        <img 
                            src="<?php echo esc_url($about_image); ?>" 
                            alt="<?php echo esc_attr(get_bloginfo('name')); ?>" 
                            class="w-full h-full object-cover rounded-lg"
                        />
                    </div>
                    <div class="quote-box">
                        <blockquote class="italic">
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