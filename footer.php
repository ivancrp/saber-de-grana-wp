<?php
/**
 * The template for displaying the footer
 *
 * @package SaberDeGrana
 */
?>

    <footer class="bg-primary text-white py-12">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Coluna 1: Logo e Descrição -->
                <div>
                    <?php if (has_custom_logo()): ?>
                        <div class="mb-4">
                            <?php 
                            $custom_logo_id = get_theme_mod('custom_logo');
                            $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
                            if ($logo) {
                                echo '<img src="' . esc_url($logo[0]) . '" alt="' . get_bloginfo('name') . '" class="h-8">';
                            }
                            ?>
                        </div>
                    <?php else: ?>
                        <h3 class="text-xl font-bold mb-4"><?php bloginfo('name'); ?></h3>
                    <?php endif; ?>
                    
                    <p class="text-white/80 mb-4">
                        <?php echo get_bloginfo('description'); ?>
                    </p>
                    
                    <div class="flex space-x-4">
                        <?php if (get_theme_mod('saberdegrana_facebook_url')): ?>
                            <a href="<?php echo esc_url(get_theme_mod('saberdegrana_facebook_url')); ?>" class="text-white hover:text-secondary" target="_blank" rel="noopener noreferrer">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5">
                                    <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                                </svg>
                            </a>
                        <?php endif; ?>
                        
                        <?php if (get_theme_mod('saberdegrana_twitter_url')): ?>
                            <a href="<?php echo esc_url(get_theme_mod('saberdegrana_twitter_url')); ?>" class="text-white hover:text-secondary" target="_blank" rel="noopener noreferrer">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5">
                                    <path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"></path>
                                </svg>
                            </a>
                        <?php endif; ?>
                        
                        <?php if (get_theme_mod('saberdegrana_instagram_url')): ?>
                            <a href="<?php echo esc_url(get_theme_mod('saberdegrana_instagram_url')); ?>" class="text-white hover:text-secondary" target="_blank" rel="noopener noreferrer">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5">
                                    <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                                    <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                                    <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                                </svg>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Coluna 2: Links Rápidos -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Links Rápidos</h3>
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer',
                        'container'      => false,
                        'menu_class'     => 'space-y-2',
                        'fallback_cb'    => false,
                        'items_wrap'     => '<ul class="%2$s">%3$s</ul>',
                        'walker'         => new Saberdegrana_Footer_Walker_Nav_Menu(),
                    ));
                    ?>
                </div>
                
                <!-- Coluna 3: Categorias -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Categorias</h3>
                    <ul class="space-y-2">
                        <?php
                        $categories = get_categories(array(
                            'orderby' => 'name',
                            'order'   => 'ASC',
                            'number'  => 6,
                        ));
                        
                        foreach ($categories as $category) {
                            echo '<li><a href="' . esc_url(get_category_link($category->term_id)) . '" class="text-white/80 hover:text-secondary transition-colors">' . esc_html($category->name) . '</a></li>';
                        }
                        ?>
                    </ul>
                </div>
                
                <!-- Coluna 4: Contato -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Contato</h3>
                    <ul class="space-y-3">
                        <?php if (get_theme_mod('saberdegrana_email')): ?>
                            <li class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5 mr-3 mt-0.5 text-secondary">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                    <polyline points="22,6 12,13 2,6"></polyline>
                                </svg>
                                <span class="text-white/80"><?php echo esc_html(get_theme_mod('saberdegrana_email')); ?></span>
                            </li>
                        <?php endif; ?>
                        
                        <?php if (get_theme_mod('saberdegrana_phone')): ?>
                            <li class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5 mr-3 mt-0.5 text-secondary">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                </svg>
                                <span class="text-white/80"><?php echo esc_html(get_theme_mod('saberdegrana_phone')); ?></span>
                            </li>
                        <?php endif; ?>
                        
                        <?php if (get_theme_mod('saberdegrana_address')): ?>
                            <li class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5 mr-3 mt-0.5 text-secondary">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                                <span class="text-white/80"><?php echo esc_html(get_theme_mod('saberdegrana_address')); ?></span>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
            
            <div class="mt-12 pt-8 border-t border-white/20 text-center sm:text-left sm:flex sm:justify-between sm:items-center">
                <p class="text-white/70 text-sm">
                    &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. Todos os direitos reservados.
                </p>
                
                <div class="mt-4 sm:mt-0">
                    <a href="<?php echo esc_url(get_privacy_policy_url()); ?>" class="text-white/70 text-sm hover:text-secondary transition-colors">Política de Privacidade</a>
                    <span class="mx-2 text-white/50">|</span>
                    <a href="<?php echo esc_url(home_url('/termos-de-uso')); ?>" class="text-white/70 text-sm hover:text-secondary transition-colors">Termos de Uso</a>
                </div>
            </div>
        </div>
    </footer>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>