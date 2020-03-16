
<?php get_header(); ?>
<div <?php post_class( 'single-recipe' ); ?>>
    <div class="rp-recipe-thumbnail">
        <div class="image-cover-container">
            <img src="<?php echo get_the_post_thumbnail_url(null, 'full'); ?>" alt="<?php echo get_post_meta(get_post_thumbnail_id(), "_wp_attachment_image_alt", true); ?>">
        </div>
        <div class="underlay">
            <div class="rp-container">
                <div class="rp-content">
                    <h1><?php the_title(); ?></h1>
                </div>
            </div>
        </div>
    </div>
    <div class="top-radius">
        <div class="rp-container">
            <main class="rp-content">
                <div class="rp-recipe-meta">
                    <div class="times">
                        <p class="prep">Prep: <?php echo rp_get_cook_time(CFS()->get('prep_time')); ?></p>
                        <p class="cook">Cook: <?php echo rp_get_cook_time(CFS()->get('cook_time')); ?></p>
                        <p class="total">Total: <?php echo rp_get_cook_time((int) (CFS()->get('prep_time') + (int) CFS()->get('cook_time'))); ?></p>
                    </div>
                
                    <?php 
                        // The 'likes' meta key value will store the total like count for a specific post, it'll show 0 if it's an empty string
                        $made_it = get_post_meta(get_the_ID(), 'made_its', true);
                        $made_it = ($made_it == '') ? 0 : $made_it;
                        // Linking to the admin-ajax.php file. Nonce check included for extra security. Note the 'user_like' class for JS enabled clients.
                        $nonce = wp_create_nonce('made_it_nonce');
                        $link = admin_url('admin-ajax.php?action=made_it&post_id=' . get_the_ID() . '&nonce='.$nonce);
                    ?>
                    <a class="i_made_it" data-nonce="<?php echo $nonce ?>" data-post_id="<?php echo get_the_ID() ?>" href="<?php echo $link ?>">
                        <p>I made it!</p>
                        <div class="rating">
                            <p class="made-it-counter"><?php echo get_made_its($made_it); ?></p>
                            <img src="<?php echo get_template_directory_uri(); ?>/img/icon-spoon.png" alt="Rating Spoon">
                        </div>
                    </a>
                </div>
                <div class="rp-section">                
                    <h2>Ingredients</h2>
                    <div class="list ingredients">
                        <?php 
                            $ingredients = CFS()->get('ingredients');
                            foreach($ingredients as $ingredient) { ?>
                                <div class="list-item ingredient">
                                    <p>
                                        <?php echo rp_get_quantity($ingredient['quantity']); ?>
                                        <?php if(reset($ingredient['unit']) != 'none') { ?>
                                            <?php echo reset($ingredient['unit']); ?>
                                        <?php } ?>
                                        <?php echo $ingredient['ingredient']; ?>
                                        <?php if($ingredient['modifier']) { ?>
                                            , <?php echo $ingredient['modifier']; ?>
                                        <?php } ?>
                                    </p>
                                </div>
                            <?php } 
                        ?>
                    </div>
                </div>
                <div class="rp-section">
                    <h2>Directions</h2>
                    <div class="list directions">
                        <?php 
                            $directions = CFS()->get('directions');
                            $i = 1;
                            foreach($directions as $direction) { ?>
                                <div class="list-item direction">
                                    <!-- <div class="number">
                                        <p><?php echo $i; ?></p>
                                    </div> -->
                                    <p class="direction"><?php echo $i . '. ' . $direction['direction']; ?></p>
                                </div>
                            <?php 
                                $i++;
                            } 
                        ?>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <?php get_template_part('components/rp', 'made-it-popup'); ?>
</div>
<?php get_footer();