<?php
/**
 * Configurações do Popup de Exit Intent
 * 
 * @package SaberDeGrana
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Configurações do popup
define('EXIT_INTENT_ENABLED', true);
define('EXIT_INTENT_DOWNLOAD_URL', 'https://saberdegrana.com.br/downloads/');
define('EXIT_INTENT_COOKIE_DURATION', 1); // dias
define('EXIT_INTENT_MAX_SHOWS', 1); // máximo de vezes para mostrar por sessão

// Configuração da imagem de background da popup
// A imagem deve estar localizada em: assets/images/popup.jpg
// Recomendado: imagem com dimensões mínimas de 1000x600px para melhor qualidade
define('EXIT_INTENT_BACKGROUND_IMAGE', get_template_directory_uri() . '/assets/images/popup.jpg');

// Configuração da opacidade do overlay da popup (0.0 = transparente, 1.0 = opaco)
define('EXIT_INTENT_OVERLAY_OPACITY', 0.0); // Removido overlay para novo design

// Configurações adicionais do background
define('EXIT_INTENT_BACKGROUND_POSITION', 'center center');
define('EXIT_INTENT_BACKGROUND_SIZE', 'cover');
define('EXIT_INTENT_BACKGROUND_REPEAT', 'no-repeat');

// Configurações do e-mail
define('EXIT_INTENT_EMAIL_SUBJECT', 'Seu guia de finanças - ' . get_bloginfo('name'));
define('EXIT_INTENT_EMAIL_FROM_NAME', get_bloginfo('name'));
define('EXIT_INTENT_EMAIL_FROM_EMAIL', 'atendimento@' . parse_url(home_url(), PHP_URL_HOST));

// Configurações do CSV
define('EXIT_INTENT_CSV_ENABLED', true);
define('EXIT_INTENT_CSV_FILENAME', 'exit-intent-subscribers.csv');

// Configurações de texto
define('EXIT_INTENT_TITLE', 'Quer aliviar o caixa do seu negócio?');
define('EXIT_INTENT_SUBTITLE', 'A gente te ajuda!');
define('EXIT_INTENT_DESCRIPTION', 'Baixe GRÁTIS e conheça 5 estratégias super práticas pra economizar de verdade, começando hoje.');
define('EXIT_INTENT_HIGHLIGHT', '5 estratégias super práticas');
define('EXIT_INTENT_BUTTON_TEXT', 'BAIXE GRÁTIS');
define('EXIT_INTENT_NAME_PLACEHOLDER', 'Seu nome');
define('EXIT_INTENT_EMAIL_PLACEHOLDER', 'Seu e-mail');

// Configurações de cores (novo design)
define('EXIT_INTENT_PRIMARY_COLOR', '#0e5c65');
define('EXIT_INTENT_SECONDARY_COLOR', '#0e5c65');
define('EXIT_INTENT_ACCENT_COLOR', '#ffb200');
define('EXIT_INTENT_FORM_BG', '#ffffff'); 