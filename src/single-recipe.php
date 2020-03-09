<?php get_header(); ?>
<div <?php post_class( 'single-recipe' ); ?>>
    <div class="rp-container">
        <h1><?php the_title(); ?></h1>
        <h2>Ingredients</h2>
        <div class="list ingredients">
            <?php 
                $ingredients = CFS()->get('ingredients');
                foreach($ingredients as $ingredient) { ?>
                    <div class="list-item ingredient">
                        <p class="quantity"><?php echo $ingredient['quantity']; ?></p>
                        <p class="unit"><?php echo reset($ingredient['unit']); ?></p>
                        <p class="ingredient"><?php echo $ingredient['ingredient']; ?></p>
                    </div>
                <?php } 
            ?>
        </div>
        <h2>Directions</h2>
        <div class="list directions">
            <?php 
                $directions = CFS()->get('directions');
                $i = 1;
                foreach($directions as $direction) { ?>
                    <div class="list-item direction">
                        <div class="number">
                            <p><?php echo $i; ?></p>
                        </div>
                        <p class="direction"><?php echo $direction['direction']; ?></p>
                    </div>
                <?php 
                    $i++;
                } 
            ?>
        </div>
    </div>
</div>
<?php get_footer();