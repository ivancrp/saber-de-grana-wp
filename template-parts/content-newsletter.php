<?php
/**
 * Template part for displaying the newsletter section
 *
 * @package SaberDeGrana
 */
?>

<section class="py-16 bg-gray-100">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-2">
                <div class="p-8 md:p-12 bg-primary">
                    <h2 class="text-2xl md:text-3xl font-bold text-white mb-4">
                        <?php echo esc_html(get_theme_mod('saberdegrana_newsletter_title', 'Assine nossa Newsletter')); ?>
                    </h2>
                    <p class="text-white/90 mb-6">
                        <?php echo esc_html(get_theme_mod('saberdegrana_newsletter_content', 'Receba dicas semanais sobre finanças pessoais e oportunidades de investimento diretamente no seu e-mail.')); ?>
                    </p>
                    <ul class="space-y-3 text-white/90">
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5 mr-3 text-secondary flex-shrink-0 mt-0.5">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                            <span><?php echo esc_html(get_theme_mod('saberdegrana_newsletter_benefit1', 'Conteúdo exclusivo')); ?></span>
                        </li>
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5 mr-3 text-secondary flex-shrink-0 mt-0.5">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                            <span><?php echo esc_html(get_theme_mod('saberdegrana_newsletter_benefit2', 'Dicas práticas semanais')); ?></span>
                        </li>
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5 mr-3 text-secondary flex-shrink-0 mt-0.5">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                            <span><?php echo esc_html(get_theme_mod('saberdegrana_newsletter_benefit3', 'Alertas de oportunidades')); ?></span>
                        </li>
                    </ul>
                </div>
                
                <div class="p-8 md:p-12">
                    <h3 class="text-xl font-semibold text-gray-900 mb-6">
                        <?php echo esc_html(get_theme_mod('saberdegrana_newsletter_form_title', 'Cadastre-se gratuitamente')); ?>
                    </h3>
                    
                    <?php 
                    // Se estiver usando um plugin de formulário como Contact Form 7, Gravity Forms, etc.
                    $newsletter_form = get_theme_mod('saberdegrana_newsletter_form_shortcode', '');
                    if ($newsletter_form) {
                        echo do_shortcode($newsletter_form);
                    } else {
                        // Formulário padrão se não houver shortcode
                    ?>
                    <form id="newsletter-form" class="space-y-4" method="post">
                        <?php wp_nonce_field('newsletter_nonce', 'newsletter_nonce'); ?>
                        <div class="form-group">
                            <label for="name" class="form-label">
                                Nome
                            </label>
                            <input type="text" id="name" name="name" class="form-input" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="email" class="form-label">
                                Email
                            </label>
                            <input type="email" id="email" name="email" class="form-input" required>
                        </div>
                        
                        <div class="pt-2">
                            <button type="submit" class="w-full bg-primary hover:bg-primary-dark text-white font-medium py-2 px-4 rounded-md transition-colors">
                                Assinar Newsletter
                            </button>
                        </div>
                        
                        <div id="newsletter-response" class="mt-4 text-sm hidden"></div>
                        
                        <p class="text-xs text-gray-500 mt-4">
                            Ao se inscrever, você concorda com a nossa <a href="<?php echo esc_url(get_privacy_policy_url()); ?>" class="text-primary hover:underline">Política de Privacidade</a>.
                        </p>
                    </form>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>