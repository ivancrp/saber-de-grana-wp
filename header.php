<?php

/**

 * The header for our theme

 *

 * @package SaberDeGrana

 */

?>

<!DOCTYPE html>

<html <?php language_attributes(); ?>>

<head>

    <meta charset="<?php bloginfo('charset'); ?>">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="profile" href="https://gmpg.org/xfn/11">
    
    <!-- Preconnect e Preload para Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Source+Serif+Pro:wght@400;600;700&display=swap">
    
    <!-- Preload da imagem LCP (imagem destacada do post) -->
    <?php if (is_single() && has_post_thumbnail()) : ?>
        <link rel="preload" as="image" href="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'full')); ?>">
    <?php endif; ?>
    
    <script src="https://cdn.tailwindcss.com"></script>

    <?php wp_head(); ?>

</head>



<body <?php body_class(); ?>>

<?php wp_body_open(); ?>



<div id="page" class="site min-h-screen bg-background ">

    <header id="masthead" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 bg-primary shadow-xl border-b-10">

        <div class="px-4 sm:px-6 lg:px-8">

            <div class="flex items-center justify-between h-16 md:h-20">

                <div class="flex items-center">

                    <?php if (has_custom_logo()): ?>

                        <div class="site-logo"><?php the_custom_logo(); ?></div>
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center">

                            <span class="text-white text-xl font-semibold"><?php bloginfo('name'); ?></span>

                        </a>

                    <?php else: ?>

                        <a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center">

                            <span class="text-white text-xl font-semibold"><?php bloginfo('name'); ?></span>

                        </a>

                    <?php endif; ?>

                </div>



                <!-- Desktop Navigation -->

                <nav id="site-navigation" class="hidden md:flex space-x-8">

                    <?php

                    wp_nav_menu(array(

                        'theme_location' => 'primary',

                        'menu_id'        => 'primary-menu',

                        'container'      => false,

                        'menu_class'     => 'hidden md:flex space-x-8',

                        'fallback_cb'    => false,

                        'items_wrap'     => '%3$s',

                        'walker'         => new Saberdegrana_Walker_Nav_Menu(),

                    ));

                    ?>

                </nav>



                <div class="hidden md:flex items-center space-x-4">
                    <a href="<?php echo esc_url(home_url('/busca')); ?>" class="p-2 rounded-full flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5 text-white">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                        <span class="text-white text-base font-medium">Buscar</span>
                    </a>
                </div>



                <!-- Mobile menu button -->

                <div class="md:hidden flex items-center">

                    <button id="mobile-menu-toggle" class="p-2 text-white bg-transparent border-none focus:outline-none" aria-label="Open menu">

                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6 text-white">

                            <line x1="3" y1="12" x2="21" y2="12"></line>

                            <line x1="3" y1="6" x2="21" y2="6"></line>

                            <line x1="3" y1="18" x2="21" y2="18"></line>

                        </svg>

                    </button>

                </div>

            </div>

        </div>



        <!-- Mobile menu (hidden by default) -->

        <div id="mobile-menu" class="md:hidden bg-primary hidden">

            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3" style="

    margin-left: 16px;">

                <?php

                wp_nav_menu(array(

                    'theme_location' => 'primary',

                    'menu_id'        => 'mobile-menu',

                    'container'      => false,

                    'menu_class'     => 'mobile-menu',

                    'fallback_cb'    => false,

                    'items_wrap'     => '%3$s',

                    'walker'         => new Saberdegrana_Mobile_Walker_Nav_Menu(),

                ));

                ?>

                <div class="pt-4 pb-3 border-t border-gray-700">

                    <a href="<?php echo esc_url(home_url('/busca')); ?>" class="flex items-center px-3 py-2 rounded-md font-medium text-white hover:bg-primary-dark">

                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5 mr-3">

                            <circle cx="11" cy="11" r="8"></circle>

                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>

                        </svg>

                        <span>Buscar</span>

                    </a>

                </div>

            </div>

        </div>

    </header>

   