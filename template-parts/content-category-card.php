<?php
/**
 * Template part for displaying category cards (estilo igual ao card de post)
 *
 * @package SaberDeGrana
 */
$category = isset($args['category_obj']) ? $args['category_obj'] : get_query_var('category_obj');
if (!$category) return;
$image_url = function_exists('saberdegrana_get_category_image_url') ? saberdegrana_get_category_image_url($category->term_id) : '';
?>
<a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" class="card category-card-link" style="display:block; width:350px; height:302px; max-width:100%; margin:auto;">
    <div class="card-image" style="height:140px; position:relative;">
        <?php if ($image_url): ?>
            <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($category->name); ?>" style="width:100%;height:100%;object-fit:cover;filter:brightness(0.85);">
        <?php endif; ?>
        <div style="position:absolute;left:0;right:0;top:0;bottom:0;display:flex;align-items:center;justify-content:center;">
            <span style="background:rgba(13,79,76,0.85);color:#fff;padding:0.5rem 1rem;border-radius:0.5rem;font-size:1.15rem;font-weight:700;text-align:center;max-width:90%;line-height:1.2;box-shadow:0 2px 8px rgba(0,0,0,0.15);">
                <?php echo esc_html($category->name); ?>
            </span>
        </div>
    </div>
    <div class="card-body" style="padding:1rem 1rem 0.5rem 1rem;">
        <div class="card-footer" style="justify-content:center; margin-bottom: 0.5rem;">
            <div class="icon-text">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2"></rect><path d="M3 10h18"></path></svg>
                <span><?php echo esc_html($category->count); ?> posts</span>
            </div>
        </div>
        <p class="card-text line-clamp-3" style="text-align:left;"><?php echo esc_html(wp_trim_words($category->description, 20, '...')); ?></p>
    </div>
</a> 