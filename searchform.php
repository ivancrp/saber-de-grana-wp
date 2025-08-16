<?php

/**

 * The template for displaying search form

 *

 * @package SaberDeGrana

 */

?>



<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">

    <label class="sr-only" for="search-field"><?php esc_html_e('Buscar por:', 'saberdegrana'); ?></label>

    <label for="search-field" class="search-label" style="display:block;font-size:1.1rem;font-weight:500;margin-bottom:0.5rem;color:#fff;">O que você quer buscar?</label>

    <div class="relative">

        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">

            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5 text-gray-400">

                <circle cx="11" cy="11" r="8"></circle>

                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>

            </svg>

        </div>

        <input type="search" id="search-field" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-primary focus:border-primary sm:text-sm" placeholder="Digite sua busca..." value="<?php echo get_search_query(); ?>" name="s" />

        <button type="submit" class="absolute inset-y-0 right-0 px-3 flex items-center bg-primary text-white rounded-r-md hover:bg-primary-dark">

            <?php esc_html_e('Buscar', 'saberdegrana'); ?>

        </button>

    </div>

</form>