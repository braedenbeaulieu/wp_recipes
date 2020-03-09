<?php get_header(); ?>
<div <?php post_class( 'front-page' ); ?>>
	<div class="rp-container">
		
		<h1>Recipes</h1>
		<div class="recipe-sidebar">
			<?php 
				// foreach recipe, put it in there with the title and the permalink
				$the_query = new WP_Query( array(
					'post_type' => 'recipe'
				) );
				
				if ( $the_query->have_posts() ) {
					while ( $the_query->have_posts() ) {
						$the_query->the_post(); ?>
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					<?php }
				}
				wp_reset_postdata();
			?>
		</div>
	</div>
</div>
<?php get_footer();