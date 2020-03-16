<?php
/**
 *
 * rp-card
 *
 */
if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}
?>
<a href="<?php the_permalink(); ?>">
    <div class="rp-card">
        <div class="poster image-cover-container">
            <img src="<?php echo get_the_post_thumbnail_url(null, 'rp-md'); ?>" alt="<?php echo get_post_meta(get_post_thumbnail_id(), "_wp_attachment_image_alt", true); ?>">
        </div>
        <div class="underlay">
            <div class="words">
                <?php $categories = get_the_category(get_the_ID()); ?>
                <p><?php echo $categories[0]->name; ?></p>
                <h3><?php the_title(); ?></h3>
                <div class="rating">
                    <?php 
                        $made_it = get_post_meta(get_the_ID(), 'made_its', true);
                        $made_it = ($made_it == '') ? 0 : $made_it;
                    ?>
                    <p><?php echo get_made_its($made_it); ?></p>
                    <img src="<?php echo get_template_directory_uri(); ?>/img/icon-spoon.png" alt="Rating Spoon">
                </div>
            </div>
        </div>
    </div>
</a>