<?php
/**
 * Template part for displaying the compact newsletter section after comments
 *
 * @package SaberDeGrana
 */
?>

<section class="newsletter-compact py-8">
    <div class="container mx-auto">
        <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-2">
                <div class="p-6 md:p-8 bg-primary">
                    <h3 class="text-xl md:text-2xl font-bold text-white mb-3">
                        <?php echo esc_html(get_theme_mod('saberdegrana_newsletter_title', 'Assine nossa Newsletter')); ?>
                    </h3>
                    <p class="text-white/90 text-sm mb-4">
                        <?php echo esc_html(get_theme_mod('saberdegrana_newsletter_content', 'Receba dicas semanais sobre finanças pessoais e oportunidades de investimento diretamente no seu e-mail.')); ?>
                    </p>
                    <ul class="space-y-2 text-white/90 text-sm">
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 mr-2 text-secondary flex-shrink-0">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                            <span><?php echo esc_html(get_theme_mod('saberdegrana_newsletter_benefit1', 'Conteúdo exclusivo')); ?></span>
                        </li>
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 mr-2 text-secondary flex-shrink-0">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                            <span><?php echo esc_html(get_theme_mod('saberdegrana_newsletter_benefit2', 'Dicas práticas semanais')); ?></span>
                        </li>
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 mr-2 text-secondary flex-shrink-0">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                            <span><?php echo esc_html(get_theme_mod('saberdegrana_newsletter_benefit3', 'Alertas de oportunidades')); ?></span>
                        </li>
                    </ul>
                </div>
                
                <div class="p-6 md:p-8 bg-white">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">
                        <?php echo esc_html(get_theme_mod('saberdegrana_newsletter_form_title', 'Cadastre-se gratuitamente')); ?>
                    </h4>
                    
                    <?php 
                    // Se estiver usando um plugin de formulário como Contact Form 7, Gravity Forms, etc.
                    $newsletter_form = get_theme_mod('saberdegrana_newsletter_form_shortcode', '');
                    if ($newsletter_form) {
                        echo do_shortcode($newsletter_form);
                    } else {
                        // Formulário padrão se não houver shortcode
                    ?>
                    <form id="newsletter-form-compact" class="space-y-4" method="post">
                        <?php wp_nonce_field('newsletter_nonce', 'newsletter_nonce'); ?>
                        <div class="form-group">
                            <label for="name-compact" class="block text-gray-700 font-medium mb-1">
                                Nome
                            </label>
                            <input type="text" id="name-compact" name="name" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-transparent" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="email-compact" class="block text-gray-700 font-medium mb-1">
                                Email
                            </label>
                            <input type="email" id="email-compact" name="email" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-transparent" required>
                        </div>
                        
                        <div class="pt-1">
                            <button type="submit" class="w-full bg-primary hover:bg-primary-dark text-white font-medium py-2 px-4 rounded-md transition-colors">
                                Assinar Newsletter
                            </button>
                        </div>
                        
                        <div id="newsletter-response-compact" class="mt-3 text-xs hidden"></div>
                        
                        <p class="text-xs text-gray-500 mt-2">
                            Ao se inscrever, você concorda com a nossa <a href="<?php echo esc_url(get_privacy_policy_url()); ?>" class="text-primary hover:underline">Política de Privacidade</a>.
                        </p>
                    </form>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section> 